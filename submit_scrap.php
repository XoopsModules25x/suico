<?php
// $Id: submit_Note.php,v 1.3 2008/04/07 20:25:22 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

/**
 * Xoops header ...
 */
include_once '../../mainfile.php';
include_once '../../header.php';

/**
 * Modules class includes
 */
include_once 'class/yogurt_Notes.php';

/**
 * Factories of tribes
 */
$Notes_factory = new Xoopsyogurt_NotesHandler($xoopsDB);

/**
 * Verify Token
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}
/**
 *
 */

$myts          = MyTextSanitizer::getInstance();
$Notebook_uid = $_POST['uid'];
$Note_text    = $myts->displayTarea($_POST['text'], 0, 1, 1, 1, 1);
$mainform      = (!empty($_POST['mainform'])) ? 1 : 0;
$Note         = $Notes_factory->create();
$Note->setVar('Note_text', $Note_text);
$Note->setVar('Note_from', $xoopsUser->getVar('uid'));
$Note->setVar('Note_to', $Notebook_uid);
$Notes_factory->insert($Note);
$extra_tags['X_OWNER_NAME'] = $xoopsUser->getUnameFromId($Notebook_uid);
$extra_tags['X_OWNER_UID']  = $Notebook_uid;
$notificationHandler        = xoops_getHandler('notification');
$notificationHandler->triggerEvent('Note', $xoopsUser->getVar('uid'), 'new_Note', $extra_tags);
if (1 == $mainform) {
    redirect_header('notebook.php?uid=' . $Notebook_uid, 1, _MD_YOGURT_NOTE_SENT);
} else {
    redirect_header('notebook.php?uid=' . $xoopsUser->getVar('uid'), 1, _MD_YOGURT_NOTE_SENT);
}

/**
 * Close page
 */
include '../../footer.php';
