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
        $adminObject->addItemButton(AM_YOGURT_VISITORS_LIST, 'visitors.php', 'list');
        $adminObject->displayButton('left');

        $visitorsObject = $visitorsHandler->create();
        $form           = $visitorsObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('visitors.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('cod_visit', 0)) {
            $visitorsObject = $visitorsHandler->get(Request::getInt('cod_visit', 0));
        } else {
            $visitorsObject = $visitorsHandler->create();
        }
        // Form save fields
        $visitorsObject->setVar('uid_owner', Request::getVar('uid_owner', ''));
        $visitorsObject->setVar('uid_visitor', Request::getVar('uid_visitor', ''));
        $visitorsObject->setVar('uname_visitor', Request::getVar('uname_visitor', ''));
        $visitorsObject->setVar('datetime', $_REQUEST['datetime']);
        if ($visitorsHandler->insert($visitorsObject)) {
            redirect_header('visitors.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $visitorsObject->getHtmlErrors();
        $form = $visitorsObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_VISITORS, 'visitors.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_VISITORS_LIST, 'visitors.php', 'list');
        $adminObject->displayButton('left');
        $visitorsObject = $visitorsHandler->get(Request::getString('cod_visit', ''));
        $form           = $visitorsObject->getForm();
        $form->display();
        break;

    case 'delete':
        $visitorsObject = $visitorsHandler->get(Request::getString('cod_visit', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('visitors.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($visitorsHandler->delete($visitorsObject)) {
                redirect_header('visitors.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $visitorsObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'cod_visit' => Request::getString('cod_visit', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_YOGURT_FORMSUREDEL, $visitorsObject->getVar('uname_visitor')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('cod_visit', '');

        if ($utility::cloneRecord('yogurt_visitors', 'cod_visit', $id_field)) {
            redirect_header('visitors.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('visitors.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_VISITORS, 'visitors.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                   = \Xmf\Request::getInt('start', 0);
        $visitorsPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('cod_visit ASC, uname_visitor');
        $criteria->setOrder('ASC');
        $criteria->setLimit($visitorsPaginationLimit);
        $criteria->setStart($start);
        $visitorsTempRows  = $visitorsHandler->getCount();
        $visitorsTempArray = $visitorsHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($visitorsTempRows > $visitorsPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $visitorsTempRows, $visitorsPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('visitorsRows', $visitorsTempRows);
        $visitorsArray = [];

        //    $fields = explode('|', cod_visit:int:11::NOT NULL::primary:cod_visit|uid_owner:int:11::NOT NULL:::uid_owner|uid_visitor:int:11::NOT NULL:::uid_visitor|uname_visitor:varchar:30::NOT NULL:::uname_visitor|datetime:timestamp:0::NOT NULL:CURRENT_TIMESTAMP::datetime);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($visitorsPaginationLimit);
        $criteria->setStart($start);

        $visitorsCount     = $visitorsHandler->getCount($criteria);
        $visitorsTempArray = $visitorsHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($visitorsCount > 0) {
            foreach (array_keys($visitorsTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorcod_visit', AM_YOGURT_VISITORS_COD_VISIT);
                $visitorsArray['cod_visit'] = $visitorsTempArray[$i]->getVar('cod_visit');

                $GLOBALS['xoopsTpl']->assign('selectoruid_owner', AM_YOGURT_VISITORS_UID_OWNER);
                $visitorsArray['uid_owner'] = strip_tags(\XoopsUser::getUnameFromId($visitorsTempArray[$i]->getVar('uid_owner')));

                $GLOBALS['xoopsTpl']->assign('selectoruid_visitor', AM_YOGURT_VISITORS_UID_VISITOR);
                $visitorsArray['uid_visitor'] = strip_tags(\XoopsUser::getUnameFromId($visitorsTempArray[$i]->getVar('uid_visitor')));

                $GLOBALS['xoopsTpl']->assign('selectoruname_visitor', AM_YOGURT_VISITORS_UNAME_VISITOR);
                $visitorsArray['uname_visitor'] = $visitorsTempArray[$i]->getVar('uname_visitor');

                $GLOBALS['xoopsTpl']->assign('selectordatetime', AM_YOGURT_VISITORS_DATETIME);
                $visitorsArray['datetime']    = date(_SHORTDATESTRING, strtotime((string)$visitorsTempArray[$i]->getVar('datetime')));
                $visitorsArray['edit_delete'] = "<a href='visitors.php?op=edit&cod_visit=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='visitors.php?op=delete&cod_visit=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='visitors.php?op=clone&cod_visit=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->append_by_ref('visitorsArrays', $visitorsArray);
                unset($visitorsArray);
            }
            unset($visitorsTempArray);
            // Display Navigation
            if ($visitorsCount > $visitorsPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $visitorsCount, $visitorsPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='visitors.php?op=edit&cod_visit=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='visitors.php?op=delete&cod_visit=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='6'>There are noXXX visitors</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/yogurt_admin_visitors.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
