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
        $adminObject->addItemButton(AM_SUICO_SUSPENSIONS_LIST, 'suspensions.php', 'list');
        $adminObject->displayButton('left');
        $suspensionsObject = $suspensionsHandler->create();
        $form              = $suspensionsObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('suspensions.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('uid', 0)) {
            $suspensionsObject = $suspensionsHandler->get(Request::getInt('uid', 0));
        } else {
            $suspensionsObject = $suspensionsHandler->create();
        }
        // Form save fields
        $suspensionsObject->setVar('old_pass', Request::getVar('old_pass', ''));
        $suspensionsObject->setVar('old_email', Request::getVar('old_email', ''));
        $suspensionsObject->setVar('old_signature', Request::getVar('old_signature', ''));
        $suspensionsObject->setVar('suspension_time', Request::getVar('suspension_time', ''));
        $suspensionsObject->setVar('old_enc_type', Request::getVar('old_enc_type', ''));
        $suspensionsObject->setVar('old_pass_expired', Request::getVar('old_pass_expired', ''));
        if ($suspensionsHandler->insert($suspensionsObject)) {
            redirect_header('suspensions.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $suspensionsObject->getHtmlErrors();
        $form = $suspensionsObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_SUSPENSIONS, 'suspensions.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_SUSPENSIONS_LIST, 'suspensions.php', 'list');
        $adminObject->displayButton('left');
        $suspensionsObject = $suspensionsHandler->get(Request::getString('uid', ''));
        $form              = $suspensionsObject->getForm();
        $form->display();
        break;
    case 'delete':
        $suspensionsObject = $suspensionsHandler->get(Request::getString('uid', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('suspensions.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($suspensionsHandler->delete($suspensionsObject)) {
                redirect_header('suspensions.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $suspensionsObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'  => 1,
                    'uid' => Request::getString('uid', ''),
                    'op'  => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_SUICO_FORMSUREDEL,
                    $suspensionsObject->getVar('uid')
                )
            );
        }
        break;
    case 'clone':
        $id_field = Request::getString('uid', '');
        if ($utility::cloneRecord('suico_suspensions', 'uid', $id_field)) {
            redirect_header('suspensions.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('suspensions.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_SUSPENSIONS, 'suspensions.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                      = Request::getInt('start', 0);
        $suspensionsPaginationLimit = $helper->getConfig('userpager');
        $criteria                   = new CriteriaCompo();
        $criteria->setSort('uid ASC, uid');
        $criteria->setOrder('ASC');
        $criteria->setLimit($suspensionsPaginationLimit);
        $criteria->setStart($start);
        $suspensionsTempRows  = $suspensionsHandler->getCount();
        $suspensionsTempArray = $suspensionsHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_SUICO_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */
        // Display Page Navigation
        if ($suspensionsTempRows > $suspensionsPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $suspensionsTempRows, $suspensionsPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('suspensionsRows', $suspensionsTempRows);
        $suspensionsArray = [];
        //    $fields = explode('|', uid:int:11::NOT NULL::primary:uid|old_pass:varchar:255::NOT NULL:::old_pass|old_email:varchar:100::NOT NULL:::old_email|old_signature:text:0::NOT NULL:::old_signature|suspension_time:int:11::NOT NULL:::suspension_time|old_enc_type:int:2::NOT NULL:::old_enc_type|old_pass_expired:int:1::NOT NULL:::old_pass_expired);
        //    $fieldsCount    = count($fields);
        $criteria = new CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($suspensionsPaginationLimit);
        $criteria->setStart($start);
        $suspensionsCount     = $suspensionsHandler->getCount($criteria);
        $suspensionsTempArray = $suspensionsHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($suspensionsCount > 0) {
            foreach (array_keys($suspensionsTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);
                $GLOBALS['xoopsTpl']->assign(
                    'selectoruid',
                    AM_SUICO_SUSPENSIONS_UID
                );
                $suspensionsArray['uid'] = $suspensionsTempArray[$i]->getVar('uid');
                $GLOBALS['xoopsTpl']->assign('selectorold_pass', AM_SUICO_SUSPENSIONS_OLD_PASS);
                $suspensionsArray['old_pass'] = $suspensionsTempArray[$i]->getVar('old_pass');
                $GLOBALS['xoopsTpl']->assign('selectorold_email', AM_SUICO_SUSPENSIONS_OLD_EMAIL);
                $suspensionsArray['old_email'] = $suspensionsTempArray[$i]->getVar('old_email');
                $GLOBALS['xoopsTpl']->assign('selectorold_signature', AM_SUICO_SUSPENSIONS_OLD_SIGNATURE);
                $suspensionsArray['old_signature'] = strip_tags($suspensionsTempArray[$i]->getVar('old_signature'));
                $GLOBALS['xoopsTpl']->assign('selectorsuspension_time', AM_SUICO_SUSPENSIONS_SUSPENSION_TIME);
                $suspensionsArray['suspension_time'] = $suspensionsTempArray[$i]->getVar('suspension_time');
                $GLOBALS['xoopsTpl']->assign('selectorold_enc_type', AM_SUICO_SUSPENSIONS_OLD_ENC_TYPE);
                $suspensionsArray['old_enc_type'] = $suspensionsTempArray[$i]->getVar('old_enc_type');
                $GLOBALS['xoopsTpl']->assign('selectorold_pass_expired', AM_SUICO_SUSPENSIONS_OLD_PASS_EXPIRED);
                $suspensionsArray['old_pass_expired'] = $suspensionsTempArray[$i]->getVar('old_pass_expired');
                $suspensionsArray['edit_delete']      = "<a href='suspensions.php?op=edit&uid=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='suspensions.php?op=delete&uid=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='suspensions.php?op=clone&uid=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('suspensionsArrays', $suspensionsArray);
                unset($suspensionsArray);
            }
            unset($suspensionsTempArray);
            // Display Navigation
            if ($suspensionsCount > $suspensionsPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $suspensionsCount, $suspensionsPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/suico_admin_suspensions.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
