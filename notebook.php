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

use XoopsModules\Suico\{
    NotesController
};

$GLOBALS['xoopsOption']['template_main'] = 'suico_notebook.tpl';
require __DIR__ . '/header.php';
$controller = new NotesController($xoopsDB, $xoopsUser);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
//$controller->renderFormNewPost($xoopsTpl);
$criteriaUid = new Criteria('note_to', $controller->uidOwner);
$criteriaUid->setOrder('DESC');
$criteriaUid->setSort('note_id');
if (!($notes = $controller->fetchNotes($nbSections['countNotes'], $criteriaUid))) {
    $xoopsTpl->assign('lang_noNotesyet', _MD_SUICO_NONOTESYET);
}
//form
$xoopsTpl->assign('lang_entertext', _MD_SUICO_ENTERTEXTNOTE);
$xoopsTpl->assign('lang_submit', _MD_SUICO_SENDNOTE);
$xoopsTpl->assign('lang_cancel', _MD_SUICO_CANCEL);
//Notes
$xoopsTpl->assign('notes', $notes);
$xoopsTpl->assign('lang_answerNote', _MD_SUICO_ANSWERNOTE);
$xoopsTpl->assign('lang_tips', _MD_SUICO_NOTETIPS);
$xoopsTpl->assign('lang_bold', _MD_SUICO_BOLD);
$xoopsTpl->assign('lang_italic', _MD_SUICO_ITALIC);
$xoopsTpl->assign('lang_underline', _MD_SUICO_UNDERLINE);
$xoopsTpl->assign('lang_mysection', _MD_SUICO_MYNOTEBOOK);
$xoopsTpl->assign('section_name', _MD_SUICO_NOTEBOOK);
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
