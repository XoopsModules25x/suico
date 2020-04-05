<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Marcello Brandão aka  Suico
 * @author       XOOPS Development Team
 * @since
 */

use XoopsModules\Yogurt;

require __DIR__ . '/header.php';

/**
 * Modules class includes
 */
//require_once __DIR__ . '/class/Notes.php';

/**
 * Factories of groups
 */
$notesFactory = new Yogurt\NotesHandler($xoopsDB);

/**
 * Verify Token
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$myts         = MyTextSanitizer::getInstance();
$Notebook_uid = $_POST['uid'];
$note_text    = $myts->displayTarea($_POST['text'], 0, 1, 1, 1, 1);
$mainform     = (!empty($_POST['mainform'])) ? 1 : 0;
$Note         = $notesFactory->create();
$Note->setVar('note_text', $note_text);
$Note->setVar('note_from', $xoopsUser->getVar('uid'));
$Note->setVar('note_to', $Notebook_uid);
$notesFactory->insert($Note);
$extra_tags['X_OWNER_NAME'] = $xoopsUser::getUnameFromId($Notebook_uid);
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
require dirname(dirname(__DIR__)) . '/footer.php';
