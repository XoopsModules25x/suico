<?php

declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @category        Module
 * @package         suico
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use Xmf\Request;
use XoopsModules\Suico\{
    NotesHandler
};

require __DIR__ . '/header.php';
/**
 * Modules class includes
 */
//require_once __DIR__ . '/class/Notes.php';
/**
 * Factories of groups
 */
$notesFactory = new NotesHandler($xoopsDB);
/**
 * Verify Token
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
$myts         = \MyTextSanitizer::getInstance();
$notebook_uid = Request::getInt('uid', 0, 'POST');
$noteText     = $myts->displayTarea(Request::getText('text', '', 'POST'), 0, 1, 1, 1, 1);
$mainform     = !empty($_POST['mainform']) ? 1 : 0;
$noteObj      = $notesFactory->create();
$noteObj->setVar('note_text', $noteText);
$noteObj->setVar('note_from', $xoopsUser->getVar('uid'));
$noteObj->setVar('note_to', $notebook_uid);
$noteObj->setVar('date_created', time());
$notesFactory->insert2($noteObj);
$noteId                     = $xoopsDB->getInsertId();
$extra_tags['X_OWNER_NAME'] = $xoopsUser::getUnameFromId($notebook_uid);
$extra_tags['X_OWNER_UID']  = $notebook_uid;
/** @var \XoopsNotificationHandler $notificationHandler */
$notificationHandler = xoops_getHandler('notification');
$notificationHandler->triggerEvent('Note', $xoopsUser->getVar('uid'), 'new_Note', $extra_tags);
if (1 == $mainform) {
    redirect_header('notebook.php?uid=' . $notebook_uid . '#' . $noteId, 1, _MD_SUICO_NOTE_SENT);
} else {
    redirect_header('notebook.php?uid=' . $xoopsUser->getVar('uid'), 1, _MD_SUICO_NOTE_SENT);
}
/**
 * Close page
 */
require dirname(__DIR__, 2) . '/footer.php';
