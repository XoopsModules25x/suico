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
 * Module: Yogurt
 *
 * @category        Module
 * @package         yogurt
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GPL 2.0 or later
 * @link            https://xoops.org/
 * @since           1.0.0
 */

use Xmf\Request;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = \Xmf\Request::getString('op', 'list');
$order = \Xmf\Request::getString('order', 'desc');
$sort  = \Xmf\Request::getString('sort', '');

$adminObject->displayNavigation(basename(__FILE__));
/** @var \Xmf\Module\Helper\Permission $permHelper */
$permHelper = new \Xmf\Module\Helper\Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/yogurt/groups/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/yogurt/groups/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_YOGURT_GROUPS_LIST, 'groups.php', 'list');
        $adminObject->displayButton('left');

        $groupsObject = $groupsHandler->create();
        $form         = $groupsObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('groups.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('group_id', 0)) {
            $groupsObject = $groupsHandler->get(Request::getInt('group_id', 0));
        } else {
            $groupsObject = $groupsHandler->create();
        }
        // Form save fields
        $groupsObject->setVar('owner_uid', Request::getVar('owner_uid', ''));
        $groupsObject->setVar('group_title', Request::getVar('group_title', ''));
        $groupsObject->setVar('group_desc', Request::getText('group_desc', ''));

        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = XOOPS_UPLOAD_PATH . '/yogurt/groups/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir, $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null
        );
        if ($uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0])) {
            //$extension = preg_replace( '/^.+\.([^.]+)$/sU' , '' , $_FILES['attachedfile']['name']);
            //$imgName = str_replace(' ', '', $_POST['group_img']).'.'.$extension;

            $uploader->setPrefix('group_img_');
            $uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            } else {
                $groupsObject->setVar('group_img', $uploader->getSavedFileName());
            }
        } else {
            $groupsObject->setVar('group_img', Request::getVar('group_img', ''));
        }

        if ($groupsHandler->insert($groupsObject)) {
            redirect_header('groups.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $groupsObject->getHtmlErrors();
        $form = $groupsObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_GROUPS, 'groups.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_GROUPS_LIST, 'groups.php', 'list');
        $adminObject->displayButton('left');
        $groupsObject = $groupsHandler->get(Request::getString('group_id', ''));
        $form         = $groupsObject->getForm();
        $form->display();
        break;

    case 'delete':
        $groupsObject = $groupsHandler->get(Request::getString('group_id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('groups.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($groupsHandler->delete($groupsObject)) {
                redirect_header('groups.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $groupsObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'group_id' => Request::getString('group_id', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_YOGURT_FORMSUREDEL, $groupsObject->getVar('group_title')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('group_id', '');

        if ($utility::cloneRecord('yogurt_groups', 'group_id', $id_field)) {
            redirect_header('groups.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('groups.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_GROUPS, 'groups.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                 = \Xmf\Request::getInt('start', 0);
        $groupsPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('group_id ASC, group_title');
        $criteria->setOrder('ASC');
        $criteria->setLimit($groupsPaginationLimit);
        $criteria->setStart($start);
        $groupsTempRows  = $groupsHandler->getCount();
        $groupsTempArray = $groupsHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
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

        $criteria = new \CriteriaCompo();

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

                $GLOBALS['xoopsTpl']->assign('selectorgroup_id', AM_YOGURT_GROUPS_GROUP_ID);
                $groupsArray['group_id'] = $groupsTempArray[$i]->getVar('group_id');

                $GLOBALS['xoopsTpl']->assign('selectorowner_uid', AM_YOGURT_GROUPS_OWNER_UID);
                $groupsArray['owner_uid'] = strip_tags(\XoopsUser::getUnameFromId($groupsTempArray[$i]->getVar('owner_uid')));

                $GLOBALS['xoopsTpl']->assign('selectorgroup_title', AM_YOGURT_GROUPS_GROUP_TITLE);
                $groupsArray['group_title'] = $groupsTempArray[$i]->getVar('group_title');

                $GLOBALS['xoopsTpl']->assign('selectorgroup_desc', AM_YOGURT_GROUPS_GROUP_DESC);
                $groupsArray['group_desc'] = $groupsTempArray[$i]->getVar('group_desc');

                $GLOBALS['xoopsTpl']->assign('selectorgroup_img', AM_YOGURT_GROUPS_GROUP_IMG);
                $groupsArray['group_img']   = "<img src='" . $uploadUrl . $groupsTempArray[$i]->getVar('group_img') . "' name='" . 'name' . "' id=" . 'id' . " alt='' style='max-width:100px'>";
                $groupsArray['edit_delete'] = "<a href='groups.php?op=edit&group_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
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

            //                     echo "<td class='center width5'>

            //                    <a href='groups.php?op=edit&group_id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='groups.php?op=delete&group_id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='6'>There are noXXX groups</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/yogurt_admin_groups.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
