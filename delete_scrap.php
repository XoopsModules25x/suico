<?php
// $Id: delete_Note.php,v 1.3 2008/01/22 10:25:42 marcellobrandao Exp $
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
include_once __DIR__ . '/../../mainfile.php';
include_once __DIR__ . '/../../header.php';
include_once __DIR__ . '/../../class/criteria.php';

include_once __DIR__ . '/class/yogurt_Notes.php';

/**
 * Factories of tribes
 */
$Notes_factory = new Xoopsyogurt_NotesHandler($xoopsDB);

$Note_id = (int)$_POST['Note_id'];

if (1 != $_POST['confirm']) {
    xoops_confirm(['Note_id' => $Note_id, 'confirm' => 1], 'delete_Note.php', _MD_YOGURT_ASKCONFIRMNOTEDELETION, _MD_YOGURT_CONFIRMNOTEDELETION);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $criteria_Note_id = new Criteria('Note_id', $Note_id);
    $uid               = (int)$xoopsUser->getVar('uid');
    $criteria_uid      = new Criteria('Note_to', $uid);
    $criteria          = new CriteriaCompo($criteria_Note_id);
    $criteria->add($criteria_uid);

    /**
     * Try to delete
     */
    if (1 == $Notes_factory->getCount($criteria)) {
        if ($Notes_factory->deleteAll($criteria)) {
            redirect_header('notebook.php?uid=' . $uid, 2, _MD_YOGURT_NOTEDELETED);
        } else {
            redirect_header('notebook.php?uid=' . $uid, 2, _MD_YOGURT_NOCACHACA);
        }
    }
}

include __DIR__ . '/../../footer.php';


