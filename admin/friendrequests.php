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
        $adminObject->addItemButton(AM_SUICO_FRIENDREQUEST_LIST, 'friendrequests.php', 'list');
        $adminObject->displayButton('left');
        $friendrequestObject = $friendrequestHandler->create();
        $form                = $friendrequestObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('friendrequests.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('friendreq_id', 0)) {
            $friendrequestObject = $friendrequestHandler->get(Request::getInt('friendreq_id', 0));
        } else {
            $friendrequestObject = $friendrequestHandler->create();
        }
        // Form save fields
        $friendrequestObject->setVar('friendrequester_uid', Request::getVar('friendrequester_uid', ''));
        $friendrequestObject->setVar('friendrequestto_uid', Request::getVar('friendrequestto_uid', ''));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_created', '', 'POST'));
        $friendrequestObject->setVar('date_created', $dateTimeObj->getTimestamp());
        if ($friendrequestHandler->insert($friendrequestObject)) {
            redirect_header('friendrequests.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $friendrequestObject->getHtmlErrors();
        $form = $friendrequestObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_FRIENDREQUEST, 'friendrequests.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_FRIENDREQUEST_LIST, 'friendrequests.php', 'list');
        $adminObject->displayButton('left');
        $friendrequestObject = $friendrequestHandler->get(Request::getString('friendreq_id', ''));
        $form                = $friendrequestObject->getForm();
        $form->display();
        break;
    case 'delete':
        $friendrequestObject = $friendrequestHandler->get(Request::getString('friendreq_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('friendrequests.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($friendrequestHandler->delete($friendrequestObject)) {
                redirect_header('friendrequests.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $friendrequestObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'           => 1,
                    'friendreq_id' => Request::getString('friendreq_id', ''),
                    'op'           => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_SUICO_FORMSUREDEL,
                    $friendrequestObject->getVar('friendreq_id')
                )
            );
        }
        break;
    case 'clone':
        $id_field = Request::getString('friendreq_id', '');
        if ($utility::cloneRecord('suico_friendrequests', 'friendreq_id', $id_field)) {
            redirect_header('friendrequests.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('friendrequests.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_FRIENDREQUEST, 'friendrequests.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                        = Request::getInt('start', 0);
        $friendrequestPaginationLimit = $helper->getConfig('userpager');
        $criteria                     = new CriteriaCompo();
        $criteria->setSort('friendreq_id ASC, friendreq_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit($friendrequestPaginationLimit);
        $criteria->setStart($start);
        $friendrequestTempRows  = $friendrequestHandler->getCount();
        $friendrequestTempArray = $friendrequestHandler->getAll($criteria);
        // Display Page Navigation
        if ($friendrequestTempRows > $friendrequestPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $friendrequestTempRows, $friendrequestPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('friendrequestRows', $friendrequestTempRows);
        $friendrequestArray = [];
        //    $fields = explode('|', friendreq_id:int:11::NOT NULL::primary:friendreq_id|friendrequester_uid:int:11::NOT NULL:::friendrequester_uid|friendrequestto_uid:int:11::NOT NULL:::friendrequestto_uid);
        //    $fieldsCount    = count($fields);
        $criteria = new CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($friendrequestPaginationLimit);
        $criteria->setStart($start);
        $friendrequestCount     = $friendrequestHandler->getCount($criteria);
        $friendrequestTempArray = $friendrequestHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($friendrequestCount > 0) {
            foreach (array_keys($friendrequestTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);
                $GLOBALS['xoopsTpl']->assign(
                    'selectorfriendreq_id',
                    AM_SUICO_FRIENDREQUEST_FRIENDPET_ID
                );
                $friendrequestArray['friendreq_id'] = $friendrequestTempArray[$i]->getVar('friendreq_id');
                $GLOBALS['xoopsTpl']->assign('selectorfriendrequester_uid', AM_SUICO_FRIENDREQUEST_FRIENDREQUESTER_UID);
                $friendrequestArray['friendrequester_uid'] = strip_tags(
                    XoopsUser::getUnameFromId($friendrequestTempArray[$i]->getVar('friendrequester_uid'))
                );
                $GLOBALS['xoopsTpl']->assign('selectorfriendrequestto_uid', AM_SUICO_FRIENDREQUEST_FRIENDREQUESTTO_UID);
                $friendrequestArray['friendrequestto_uid'] = strip_tags(
                    XoopsUser::getUnameFromId($friendrequestTempArray[$i]->getVar('friendrequestto_uid'))
                );
                $GLOBALS['xoopsTpl']->assign('selectordate_created', AM_SUICO_FRIENDREQUEST_DATE_CREATED);
                $friendrequestArray['date_created'] = formatTimestamp($friendrequestTempArray[$i]->getVar('date_created'), 's');
                $friendrequestArray['edit_delete']  = "<a href='friendrequests.php?op=edit&friendreq_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='friendrequests.php?op=delete&friendreq_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='friendrequests.php?op=clone&friendreq_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('friendrequestsArray', $friendrequestArray);
                unset($friendrequestArray);
            }
            unset($friendrequestTempArray);
            // Display Navigation
            if ($friendrequestCount > $friendrequestPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $friendrequestCount, $friendrequestPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/suico_admin_friendrequests.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
