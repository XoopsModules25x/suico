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
        $adminObject->addItemButton(AM_SUICO_VISITORS_LIST, 'visitors.php', 'list');
        $adminObject->displayButton('left');
        $visitorsObject = $visitorsHandler->create();
        $form           = $visitorsObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('visitors.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('visit_id', 0)) {
            $visitorsObject = $visitorsHandler->get(Request::getInt('visit_id', 0));
        } else {
            $visitorsObject = $visitorsHandler->create();
        }
        // Form save fields
        $visitorsObject->setVar('uid_owner', Request::getVar('uid_owner', ''));
        $visitorsObject->setVar('uid_visitor', Request::getVar('uid_visitor', ''));
        $visitorsObject->setVar('uname_visitor', Request::getVar('uname_visitor', ''));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_visited', '', 'POST'));
        $visitorsObject->setVar('date_visited', $dateTimeObj->getTimestamp());
        if ($visitorsHandler->insert($visitorsObject)) {
            redirect_header('visitors.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $visitorsObject->getHtmlErrors();
        $form = $visitorsObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_VISITORS, 'visitors.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_VISITORS_LIST, 'visitors.php', 'list');
        $adminObject->displayButton('left');
        $visitorsObject = $visitorsHandler->get(Request::getString('visit_id', ''));
        $form           = $visitorsObject->getForm();
        $form->display();
        break;
    case 'delete':
        $visitorsObject = $visitorsHandler->get(Request::getString('visit_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('visitors.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($visitorsHandler->delete($visitorsObject)) {
                redirect_header('visitors.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $visitorsObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'       => 1,
                    'visit_id' => Request::getString('visit_id', ''),
                    'op'       => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_SUICO_FORMSUREDEL,
                    $visitorsObject->getVar('uname_visitor')
                )
            );
        }
        break;
    case 'clone':
        $id_field = Request::getString('visit_id', '');
        if ($utility::cloneRecord('suico_visitors', 'visit_id', $id_field)) {
            redirect_header('visitors.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('visitors.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_VISITORS, 'visitors.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                   = Request::getInt('start', 0);
        $visitorsPaginationLimit = $helper->getConfig('userpager');
        $criteria                = new CriteriaCompo();
        $criteria->setSort('visit_id ASC, uname_visitor');
        $criteria->setOrder('ASC');
        $criteria->setLimit($visitorsPaginationLimit);
        $criteria->setStart($start);
        $visitorsTempRows  = $visitorsHandler->getCount();
        $visitorsTempArray = $visitorsHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_SUICO_FORM_ACTION."</th>
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
        //    $fields = explode('|', visit_id:int:11::NOT NULL::primary:visit_id|uid_owner:int:11::NOT NULL:::uid_owner|uid_visitor:int:11::NOT NULL:::uid_visitor|uname_visitor:varchar:30::NOT NULL:::uname_visitor|date_visited:timestamp:0::NOT NULL:CURRENT_TIMESTAMP::date_visited);
        //    $fieldsCount    = count($fields);
        $criteria = new CriteriaCompo();
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
                $GLOBALS['xoopsTpl']->assign(
                    'selectorvisit_id',
                    AM_SUICO_VISITORS_VISIT_ID
                );
                $visitorsArray['visit_id'] = $visitorsTempArray[$i]->getVar('visit_id');
                $GLOBALS['xoopsTpl']->assign('selectoruid_owner', AM_SUICO_VISITORS_UID_OWNER);
                $visitorsArray['uid_owner'] = strip_tags(
                    XoopsUser::getUnameFromId($visitorsTempArray[$i]->getVar('uid_owner'))
                );
                $GLOBALS['xoopsTpl']->assign('selectoruid_visitor', AM_SUICO_VISITORS_UID_VISITOR);
                $visitorsArray['uid_visitor'] = strip_tags(
                    XoopsUser::getUnameFromId($visitorsTempArray[$i]->getVar('uid_visitor'))
                );
                $GLOBALS['xoopsTpl']->assign('selectoruname_visitor', AM_SUICO_VISITORS_UNAME_VISITOR);
                $visitorsArray['uname_visitor'] = $visitorsTempArray[$i]->getVar('uname_visitor');
                $GLOBALS['xoopsTpl']->assign('selectordate_visited', AM_SUICO_VISITORS_DATETIME);
                $visitorsArray['date_visited'] = formatTimestamp($visitorsTempArray[$i]->getVar('date_visited'), 's');
                $visitorsArray['edit_delete']  = "<a href='visitors.php?op=edit&visit_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='visitors.php?op=delete&visit_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='visitors.php?op=clone&visit_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
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
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/suico_admin_visitors.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
