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

use Xmf\Module\Helper\Permission;
use Xmf\Request;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = Request::getString('op', 'list');
$order = Request::getString('order', 'desc');
$sort  = Request::getString('sort', '');
$adminObject->displayNavigation(basename(__FILE__));
$permHelper = new Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/suico/images/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/suico/images/';
switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_SUICO_NOTES_LIST, 'notes.php', 'list');
        $adminObject->displayButton('left');
        $notesObject = $notesHandler->create();
        $form        = $notesObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('notes.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('note_id', 0)) {
            $notesObject = $notesHandler->get(Request::getInt('note_id', 0));
        } else {
            $notesObject = $notesHandler->create();
        }
        // Form save fields
        $notesObject->setVar('note_text', Request::getText('note_text', ''));
        $notesObject->setVar('note_from', Request::getVar('note_from', ''));
        $notesObject->setVar('note_to', Request::getVar('note_to', ''));
        $notesObject->setVar('private', (1 === Request::getInt('private', 0) ? '1' : '0'));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_created', '', 'POST'));
        $notesObject->setVar('date_created', $dateTimeObj->getTimestamp());
        if ($notesHandler->insert($notesObject)) {
            redirect_header('notes.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $notesObject->getHtmlErrors();
        $form = $notesObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_NOTES, 'notes.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_NOTES_LIST, 'notes.php', 'list');
        $adminObject->displayButton('left');
        $notesObject = $notesHandler->get(Request::getString('note_id', ''));
        $form        = $notesObject->getForm();
        $form->display();
        break;
    case 'delete':
        $notesObject = $notesHandler->get(Request::getString('note_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('notes.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($notesHandler->delete($notesObject)) {
                redirect_header('notes.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $notesObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'      => 1,
                    'note_id' => Request::getString('note_id', ''),
                    'op'      => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_SUICO_FORMSUREDEL,
                    $notesObject->getVar('note_id')
                )
            );
        }
        break;
    case 'clone':
        $id_field = Request::getString('note_id', '');
        if ($utility::cloneRecord('suico_notes', 'note_id', $id_field)) {
            redirect_header('notes.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('notes.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_NOTES, 'notes.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                = Request::getInt('start', 0);
        $notesPaginationLimit = $helper->getConfig('userpager');
        $criteria             = new CriteriaCompo();
        $criteria->setSort('note_id ASC, note_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit($notesPaginationLimit);
        $criteria->setStart($start);
        $notesTempRows  = $notesHandler->getCount();
        $notesTempArray = $notesHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_SUICO_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */
        // Display Page Navigation
        if ($notesTempRows > $notesPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $notesTempRows, $notesPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('notesRows', $notesTempRows);
        $notesArray = [];
        //    $fields = explode('|', note_id:int:11::NOT NULL::primary:ID:0|note_text:text:0::NOT NULL:::Text:1|note_from:int:11::NOT NULL:::From:2|note_to:int:11::NOT NULL:::To:3|private:tinyint:1::NOT NULL:::Private:4|date_created:int:11::NOT NULL:CURRENT_TIMESTAMP::Date:5);
        //    $fieldsCount    = count($fields);
        $criteria = new CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($notesPaginationLimit);
        $criteria->setStart($start);
        $notesCount     = $notesHandler->getCount($criteria);
        $notesTempArray = $notesHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($notesCount > 0) {
            foreach (array_keys($notesTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);
                $GLOBALS['xoopsTpl']->assign(
                    'selectornote_id',
                    AM_SUICO_NOTES_NOTE_ID
                );
                $notesArray['note_id'] = $notesTempArray[$i]->getVar('note_id');
                $GLOBALS['xoopsTpl']->assign('selectornote_text', AM_SUICO_NOTES_NOTE_TEXT);
                $notesArray['note_text'] = $notesTempArray[$i]->getVar('note_text');
                $notesArray['note_text'] = $utility::truncateHtml($notesArray['note_text'], $helper->getConfig('truncatelength'));
                $GLOBALS['xoopsTpl']->assign('selectornote_from', AM_SUICO_NOTES_NOTE_FROM);
                $notesArray['note_from'] = strip_tags(
                    XoopsUser::getUnameFromId($notesTempArray[$i]->getVar('note_from'))
                );
                $GLOBALS['xoopsTpl']->assign('selectornote_to', AM_SUICO_NOTES_NOTE_TO);
                $notesArray['note_to'] = strip_tags(
                    XoopsUser::getUnameFromId($notesTempArray[$i]->getVar('note_to'))
                );
                $GLOBALS['xoopsTpl']->assign('selectorprivate', AM_SUICO_NOTES_PRIVATE);
                $notesArray['private'] = $notesTempArray[$i]->getVar('private');
                $GLOBALS['xoopsTpl']->assign('selectordate', AM_SUICO_NOTES_DATE);
                $notesArray['date_created'] = formatTimestamp($notesTempArray[$i]->getVar('date_created'), 's');
                $notesArray['edit_delete']  = "<a href='notes.php?op=edit&note_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='notes.php?op=delete&note_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='notes.php?op=clone&note_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('notesArrays', $notesArray);
                unset($notesArray);
            }
            unset($notesTempArray);
            // Display Navigation
            if ($notesCount > $notesPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $notesCount, $notesPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/suico_admin_notes.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
