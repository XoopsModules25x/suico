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
        $adminObject->addItemButton(AM_YOGURT_FRIENDPETITION_LIST, 'friendpetition.php', 'list');
        $adminObject->displayButton('left');

        $friendpetitionObject = $friendpetitionHandler->create();
        $form                 = $friendpetitionObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('friendpetition.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('friendpet_id', 0)) {
            $friendpetitionObject = $friendpetitionHandler->get(Request::getInt('friendpet_id', 0));
        } else {
            $friendpetitionObject = $friendpetitionHandler->create();
        }
        // Form save fields
        $friendpetitionObject->setVar('petitioner_uid', Request::getVar('petitioner_uid', ''));
        $friendpetitionObject->setVar('petioned_uid', Request::getVar('petioned_uid', ''));
        if ($friendpetitionHandler->insert($friendpetitionObject)) {
            redirect_header('friendpetition.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $friendpetitionObject->getHtmlErrors();
        $form = $friendpetitionObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_FRIENDPETITION, 'friendpetition.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_FRIENDPETITION_LIST, 'friendpetition.php', 'list');
        $adminObject->displayButton('left');
        $friendpetitionObject = $friendpetitionHandler->get(Request::getString('friendpet_id', ''));
        $form                 = $friendpetitionObject->getForm();
        $form->display();
        break;

    case 'delete':
        $friendpetitionObject = $friendpetitionHandler->get(Request::getString('friendpet_id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('friendpetition.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($friendpetitionHandler->delete($friendpetitionObject)) {
                redirect_header('friendpetition.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $friendpetitionObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'friendpet_id' => Request::getString('friendpet_id', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_YOGURT_FORMSUREDEL, $friendpetitionObject->getVar('friendpet_id')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('friendpet_id', '');

        if ($utility::cloneRecord('yogurt_friendpetition', 'friendpet_id', $id_field)) {
            redirect_header('friendpetition.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('friendpetition.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_FRIENDPETITION, 'friendpetition.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                         = \Xmf\Request::getInt('start', 0);
        $friendpetitionPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('friendpet_id ASC, friendpet_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit($friendpetitionPaginationLimit);
        $criteria->setStart($start);
        $friendpetitionTempRows  = $friendpetitionHandler->getCount();
        $friendpetitionTempArray = $friendpetitionHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($friendpetitionTempRows > $friendpetitionPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $friendpetitionTempRows, $friendpetitionPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('friendpetitionRows', $friendpetitionTempRows);
        $friendpetitionArray = [];

        //    $fields = explode('|', friendpet_id:int:11::NOT NULL::primary:friendpet_id|petitioner_uid:int:11::NOT NULL:::petitioner_uid|petioned_uid:int:11::NOT NULL:::petioned_uid);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($friendpetitionPaginationLimit);
        $criteria->setStart($start);

        $friendpetitionCount     = $friendpetitionHandler->getCount($criteria);
        $friendpetitionTempArray = $friendpetitionHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($friendpetitionCount > 0) {
            foreach (array_keys($friendpetitionTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorfriendpet_id', AM_YOGURT_FRIENDPETITION_FRIENDPET_ID);
                $friendpetitionArray['friendpet_id'] = $friendpetitionTempArray[$i]->getVar('friendpet_id');

                $GLOBALS['xoopsTpl']->assign('selectorpetitioner_uid', AM_YOGURT_FRIENDPETITION_PETITIONER_UID);
                $friendpetitionArray['petitioner_uid'] = strip_tags(\XoopsUser::getUnameFromId($friendpetitionTempArray[$i]->getVar('petitioner_uid')));

                $GLOBALS['xoopsTpl']->assign('selectorpetioned_uid', AM_YOGURT_FRIENDPETITION_PETIONED_UID);
                $friendpetitionArray['petioned_uid'] = strip_tags(\XoopsUser::getUnameFromId($friendpetitionTempArray[$i]->getVar('petioned_uid')));
                $friendpetitionArray['edit_delete']  = "<a href='friendpetition.php?op=edit&friendpet_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='friendpetition.php?op=delete&friendpet_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='friendpetition.php?op=clone&friendpet_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->append_by_ref('friendpetitionArrays', $friendpetitionArray);
                unset($friendpetitionArray);
            }
            unset($friendpetitionTempArray);
            // Display Navigation
            if ($friendpetitionCount > $friendpetitionPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $friendpetitionCount, $friendpetitionPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='friendpetition.php?op=edit&friendpet_id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='friendpetition.php?op=delete&friendpet_id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='4'>There are noXXX friendpetition</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/yogurt_admin_friendpetition.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
