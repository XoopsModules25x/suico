<?php declare(strict_types=1);

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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_notebook.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\NotesController($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

//$controller->renderFormNewPost($xoopsTpl);
$criteriaUid = new Criteria('note_to', $controller->uidOwner);
$criteriaUid->setOrder('DESC');
$criteriaUid->setSort('note_id');

if (!($notes = $controller->fetchNotes($nbSections['nbNotes'], $criteriaUid))) {
    $xoopsTpl->assign('lang_noNotesyet', _MD_YOGURT_NONOTESYET);
}

//form
$xoopsTpl->assign('lang_entertext', _MD_YOGURT_ENTERTEXTNOTE);
$xoopsTpl->assign('lang_submit', _MD_YOGURT_SENDNOTE);
$xoopsTpl->assign('lang_cancel', _MD_YOGURT_CANCEL);

//Notes
$xoopsTpl->assign('notes', $notes);
$xoopsTpl->assign('lang_answerNote', _MD_YOGURT_ANSWERNOTE);
$xoopsTpl->assign('lang_tips', _MD_YOGURT_NOTETIPS);
$xoopsTpl->assign('lang_bold', _MD_YOGURT_BOLD);
$xoopsTpl->assign('lang_italic', _MD_YOGURT_ITALIC);
$xoopsTpl->assign('lang_underline', _MD_YOGURT_UNDERLINE);

$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYNOTEBOOK);
$xoopsTpl->assign('section_name', _MD_YOGURT_NOTEBOOK);

require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
