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
 * Factories of groups
 */
$notesFactory = new Yogurt\NotesHandler($xoopsDB);

$note_id = \Xmf\Request::getInt('note_id', 0, 'POST');

if (1 != $_POST['confirm']) {
    xoops_confirm(['note_id' => $note_id, 'confirm' => 1], 'delete_Note.php', _MD_YOGURT_ASKCONFIRMNOTEDELETION, _MD_YOGURT_CONFIRMNOTEDELETION);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $criteria_note_id = new \Criteria('note_id', $note_id);
    $uid              = (int)$xoopsUser->getVar('uid');
    $criteria_uid     = new \Criteria('note_to', $uid);
    $criteria         = new \CriteriaCompo($criteria_note_id);
    $criteria->add($criteria_uid);

    /**
     * Try to delete
     */
    if (1 == $notesFactory->getCount($criteria)) {
        if ($notesFactory->deleteAll($criteria)) {
            redirect_header('notebook.php?uid=' . $uid, 2, _MD_YOGURT_NOTEDELETED);
        } else {
            redirect_header('notebook.php?uid=' . $uid, 2, _MD_YOGURT_NOCACHACA);
        }
    }
}

require dirname(dirname(__DIR__)) . '/footer.php';
