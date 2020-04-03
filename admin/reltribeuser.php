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
        $adminObject->addItemButton(AM_YOGURT_RELTRIBEUSER_LIST, 'reltribeuser.php', 'list');
        $adminObject->displayButton('left');

        $reltribeuserObject = $reltribeuserHandler->create();
        $form               = $reltribeuserObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('reltribeuser.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('rel_id', 0)) {
            $reltribeuserObject = $reltribeuserHandler->get(Request::getInt('rel_id', 0));
        } else {
            $reltribeuserObject = $reltribeuserHandler->create();
        }
        // Form save fields
        $reltribeuserObject->setVar('rel_tribe_id', Request::getVar('rel_tribe_id', ''));
        $reltribeuserObject->setVar('rel_user_uid', Request::getVar('rel_user_uid', ''));
        if ($reltribeuserHandler->insert($reltribeuserObject)) {
            redirect_header('reltribeuser.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $reltribeuserObject->getHtmlErrors();
        $form = $reltribeuserObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_RELTRIBEUSER, 'reltribeuser.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_RELTRIBEUSER_LIST, 'reltribeuser.php', 'list');
        $adminObject->displayButton('left');
        $reltribeuserObject = $reltribeuserHandler->get(Request::getString('rel_id', ''));
        $form               = $reltribeuserObject->getForm();
        $form->display();
        break;

    case 'delete':
        $reltribeuserObject = $reltribeuserHandler->get(Request::getString('rel_id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('reltribeuser.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($reltribeuserHandler->delete($reltribeuserObject)) {
                redirect_header('reltribeuser.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $reltribeuserObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'rel_id' => Request::getString('rel_id', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_YOGURT_FORMSUREDEL, $reltribeuserObject->getVar('rel_id')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('rel_id', '');

        if ($utility::cloneRecord('yogurt_reltribeuser', 'rel_id', $id_field)) {
            redirect_header('reltribeuser.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('reltribeuser.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_RELTRIBEUSER, 'reltribeuser.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                       = \Xmf\Request::getInt('start', 0);
        $reltribeuserPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('rel_id ASC, rel_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit($reltribeuserPaginationLimit);
        $criteria->setStart($start);
        $reltribeuserTempRows  = $reltribeuserHandler->getCount();
        $reltribeuserTempArray = $reltribeuserHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($reltribeuserTempRows > $reltribeuserPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $reltribeuserTempRows, $reltribeuserPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('reltribeuserRows', $reltribeuserTempRows);
        $reltribeuserArray = [];

        //    $fields = explode('|', rel_id:int:11::NOT NULL::primary:rel_id|rel_tribe_id:int:11::NOT NULL:::rel_tribe_id|rel_user_uid:int:11::NOT NULL:::rel_user_uid);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($reltribeuserPaginationLimit);
        $criteria->setStart($start);

        $reltribeuserCount     = $reltribeuserHandler->getCount($criteria);
        $reltribeuserTempArray = $reltribeuserHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($reltribeuserCount > 0) {
            foreach (array_keys($reltribeuserTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorrel_id', AM_YOGURT_RELTRIBEUSER_REL_ID);
                $reltribeuserArray['rel_id'] = $reltribeuserTempArray[$i]->getVar('rel_id');

                $GLOBALS['xoopsTpl']->assign('selectorrel_tribe_id', AM_YOGURT_RELTRIBEUSER_REL_TRIBE_ID);
                $reltribeuserArray['rel_tribe_id'] = $tribesHandler->get($reltribeuserTempArray[$i]->getVar('rel_tribe_id'))->getVar('tribe_title');

                $GLOBALS['xoopsTpl']->assign('selectorrel_user_uid', AM_YOGURT_RELTRIBEUSER_REL_USER_UID);
                $reltribeuserArray['rel_user_uid'] = strip_tags(\XoopsUser::getUnameFromId($reltribeuserTempArray[$i]->getVar('rel_user_uid')));
                $reltribeuserArray['edit_delete']  = "<a href='reltribeuser.php?op=edit&rel_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='reltribeuser.php?op=delete&rel_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='reltribeuser.php?op=clone&rel_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->append_by_ref('reltribeuserArrays', $reltribeuserArray);
                unset($reltribeuserArray);
            }
            unset($reltribeuserTempArray);
            // Display Navigation
            if ($reltribeuserCount > $reltribeuserPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $reltribeuserCount, $reltribeuserPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='reltribeuser.php?op=edit&rel_id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='reltribeuser.php?op=delete&rel_id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='4'>There are noXXX reltribeuser</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/yogurt_admin_reltribeuser.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
