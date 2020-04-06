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
$uploadDir  = XOOPS_UPLOAD_PATH . '/yogurt/images/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/yogurt/images/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_YOGURT_RELGROUPUSER_LIST, 'relgroupuser.php', 'list');
        $adminObject->displayButton('left');

        $relgroupuserObject = $relgroupuserHandler->create();
        $form               = $relgroupuserObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('relgroupuser.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('rel_id', 0)) {
            $relgroupuserObject = $relgroupuserHandler->get(Request::getInt('rel_id', 0));
        } else {
            $relgroupuserObject = $relgroupuserHandler->create();
        }
        // Form save fields
        $relgroupuserObject->setVar('rel_group_id', Request::getVar('rel_group_id', ''));
        $relgroupuserObject->setVar('rel_user_uid', Request::getVar('rel_user_uid', ''));
        if ($relgroupuserHandler->insert($relgroupuserObject)) {
            redirect_header('relgroupuser.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $relgroupuserObject->getHtmlErrors();
        $form = $relgroupuserObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_RELGROUPUSER, 'relgroupuser.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_RELGROUPUSER_LIST, 'relgroupuser.php', 'list');
        $adminObject->displayButton('left');
        $relgroupuserObject = $relgroupuserHandler->get(Request::getString('rel_id', ''));
        $form               = $relgroupuserObject->getForm();
        $form->display();
        break;

    case 'delete':
        $relgroupuserObject = $relgroupuserHandler->get(Request::getString('rel_id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('relgroupuser.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($relgroupuserHandler->delete($relgroupuserObject)) {
                redirect_header('relgroupuser.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $relgroupuserObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'rel_id' => Request::getString('rel_id', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_YOGURT_FORMSUREDEL, $relgroupuserObject->getVar('rel_id')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('rel_id', '');

        if ($utility::cloneRecord('yogurt_relgroupuser', 'rel_id', $id_field)) {
            redirect_header('relgroupuser.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('relgroupuser.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_RELGROUPUSER, 'relgroupuser.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                       = \Xmf\Request::getInt('start', 0);
        $relgroupuserPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('rel_id ASC, rel_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit($relgroupuserPaginationLimit);
        $criteria->setStart($start);
        $relgroupuserTempRows  = $relgroupuserHandler->getCount();
        $relgroupuserTempArray = $relgroupuserHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($relgroupuserTempRows > $relgroupuserPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $relgroupuserTempRows, $relgroupuserPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('relgroupuserRows', $relgroupuserTempRows);
        $relgroupuserArray = [];

        //    $fields = explode('|', rel_id:int:11::NOT NULL::primary:rel_id|rel_group_id:int:11::NOT NULL:::rel_group_id|rel_user_uid:int:11::NOT NULL:::rel_user_uid);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($relgroupuserPaginationLimit);
        $criteria->setStart($start);

        $relgroupuserCount     = $relgroupuserHandler->getCount($criteria);
        $relgroupuserTempArray = $relgroupuserHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($relgroupuserCount > 0) {
            foreach (array_keys($relgroupuserTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorrel_id', AM_YOGURT_RELGROUPUSER_REL_ID);
                $relgroupuserArray['rel_id'] = $relgroupuserTempArray[$i]->getVar('rel_id');

                $GLOBALS['xoopsTpl']->assign('selectorrel_group_id', AM_YOGURT_RELGROUPUSER_REL_GROUP_ID);
                $relgroupuserArray['rel_group_id'] = $groupsHandler->get($relgroupuserTempArray[$i]->getVar('rel_group_id'))->getVar('group_title');

                $GLOBALS['xoopsTpl']->assign('selectorrel_user_uid', AM_YOGURT_RELGROUPUSER_REL_USER_UID);
                $relgroupuserArray['rel_user_uid'] = strip_tags(\XoopsUser::getUnameFromId($relgroupuserTempArray[$i]->getVar('rel_user_uid')));
                $relgroupuserArray['edit_delete']  = "<a href='relgroupuser.php?op=edit&rel_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='relgroupuser.php?op=delete&rel_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='relgroupuser.php?op=clone&rel_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->append_by_ref('relgroupuserArrays', $relgroupuserArray);
                unset($relgroupuserArray);
            }
            unset($relgroupuserTempArray);
            // Display Navigation
            if ($relgroupuserCount > $relgroupuserPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $relgroupuserCount, $relgroupuserPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='relgroupuser.php?op=edit&rel_id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='relgroupuser.php?op=delete&rel_id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='4'>There are noXXX relgroupuser</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/yogurt_admin_relgroupuser.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
