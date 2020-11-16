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
$uploadDir  = XOOPS_UPLOAD_PATH . '/suico/groups/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/suico/groups/';
switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_SUICO_GROUPS_LIST, 'groups.php', 'list');
        $adminObject->displayButton('left');
        $groupsObject = $groupsHandler->create();
        $form         = $groupsObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('groups.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('group_id', 0)) {
            $groupsObject = $groupsHandler->get(Request::getInt('group_id', 0));
        } else {
            $groupsObject = $groupsHandler->create();
        }
        // Form save fields
        $groupsObject->setVar('owner_uid', Request::getVar('owner_uid', ''));
        $groupsObject->setVar('group_title', Request::getVar('group_title', ''));
        $groupsObject->setVar('group_desc', Request::getText('group_desc', ''));
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = XOOPS_UPLOAD_PATH . '/suico/groups/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir, $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null
        );
        if ($uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0])) {
            //$extension = preg_replace( '/^.+\.([^.]+)$/sU' , '' , $_FILES['attachedfile']['name']);
            //$imgName = str_replace(' ', '', $_POST['group_img']).'.'.$extension;
            $uploader->setPrefix('group_img_');
            $uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0]);
            if ($uploader->upload()) {
                $groupsObject->setVar('group_img', $uploader->getSavedFileName());
            } else {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            }
        } else {
            $groupsObject->setVar('group_img', Request::getVar('group_img', ''));
        }
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_created', '', 'POST'));
        $groupsObject->setVar('date_created', $dateTimeObj->getTimestamp());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_updated', '', 'POST'));
        $groupsObject->setVar('date_updated', $dateTimeObj->getTimestamp());
        if ($groupsHandler->insert($groupsObject)) {
            redirect_header('groups.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $groupsObject->getHtmlErrors();
        $form = $groupsObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_GROUPS, 'groups.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_GROUPS_LIST, 'groups.php', 'list');
        $adminObject->displayButton('left');
        $groupsObject = $groupsHandler->get(Request::getString('group_id', ''));
        $form         = $groupsObject->getForm();
        $form->display();
        break;
    case 'delete':
        $groupsObject = $groupsHandler->get(Request::getString('group_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('groups.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($groupsHandler->delete($groupsObject)) {
                redirect_header('groups.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $groupsObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'       => 1,
                    'group_id' => Request::getString('group_id', ''),
                    'op'       => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_SUICO_FORMSUREDEL,
                    $groupsObject->getVar('group_title')
                )
            );
        }
        break;
    case 'clone':
        $id_field = Request::getString('group_id', '');
        if ($utility::cloneRecord('suico_groups', 'group_id', $id_field)) {
            redirect_header('groups.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('groups.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_GROUPS, 'groups.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                 = Request::getInt('start', 0);
        $groupsPaginationLimit = $helper->getConfig('userpager');
        $criteria              = new CriteriaCompo();
        $criteria->setSort('group_id ASC, group_title');
        $criteria->setOrder('ASC');
        $criteria->setLimit($groupsPaginationLimit);
        $criteria->setStart($start);
        $groupsTempRows  = $groupsHandler->getCount();
        $groupsTempArray = $groupsHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_SUICO_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */
        // Display Page Navigation
        if ($groupsTempRows > $groupsPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $groupsTempRows, $groupsPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('groupsRows', $groupsTempRows);
        $groupsArray = [];
        //    $fields = explode('|', group_id:int:11::NOT NULL::primary:group_id|owner_uid:int:11::NOT NULL:::owner_uid|group_title:varchar:255::NOT NULL:::group_title|group_desc:tinytext:0::NOT NULL:::group_desc|group_img:varchar:255::NOT NULL:::group_img);
        //    $fieldsCount    = count($fields);
        $criteria = new CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($groupsPaginationLimit);
        $criteria->setStart($start);
        $groupsCount     = $groupsHandler->getCount($criteria);
        $groupsTempArray = $groupsHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($groupsCount > 0) {
            foreach (array_keys($groupsTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);
                $GLOBALS['xoopsTpl']->assign(
                    'selectorgroup_id',
                    AM_SUICO_GROUPS_GROUP_ID
                );
                $groupsArray['group_id'] = $groupsTempArray[$i]->getVar('group_id');
                $GLOBALS['xoopsTpl']->assign('selectorowner_uid', AM_SUICO_GROUPS_OWNER_UID);
                $groupsArray['owner_uid'] = strip_tags(
                    XoopsUser::getUnameFromId($groupsTempArray[$i]->getVar('owner_uid'))
                );
                $GLOBALS['xoopsTpl']->assign('selectorgroup_title', AM_SUICO_GROUPS_GROUP_TITLE);
                $groupsArray['group_title'] = $groupsTempArray[$i]->getVar('group_title');
                $GLOBALS['xoopsTpl']->assign('selectorgroup_desc', AM_SUICO_GROUPS_GROUP_DESC);
                $groupsArray['group_desc'] = $groupsTempArray[$i]->getVar('group_desc');
                $GLOBALS['xoopsTpl']->assign('selectorgroup_img', AM_SUICO_GROUPS_GROUP_IMG);
                $groupsArray['group_img'] = "<img src='" . $uploadUrl . $groupsTempArray[$i]->getVar(
                        'group_img'
                    ) . "' name='" . 'name' . "' id=" . 'id' . " alt='' style='max-width:100px'>";
                $GLOBALS['xoopsTpl']->assign('selectordate_created', AM_SUICO_GROUPS_DATE_CREATED);
                $groupsArray['date_created'] = formatTimestamp($groupsTempArray[$i]->getVar('date_created'), 's');
                $GLOBALS['xoopsTpl']->assign('selectordate_updated', AM_SUICO_GROUPS_DATE_UPDATED);
                $groupsArray['date_updated'] = formatTimestamp($groupsTempArray[$i]->getVar('date_updated'), 's');
                $groupsArray['edit_delete']  = "<a href='groups.php?op=edit&group_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='groups.php?op=delete&group_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='groups.php?op=clone&group_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('groupsArrays', $groupsArray);
                unset($groupsArray);
            }
            unset($groupsTempArray);
            // Display Navigation
            if ($groupsCount > $groupsPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $groupsCount, $groupsPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/suico_admin_groups.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
