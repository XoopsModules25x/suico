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
//$uploadDir  = XOOPS_UPLOAD_PATH . '/suico/images/';
//$uploadUrl  = XOOPS_UPLOAD_URL . '/suico/images/';
switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_SUICO_CONFIGS_LIST, 'configs.php', 'list');
        $adminObject->displayButton('left');
        $configsObject = $configsHandler->create();
        $form          = $configsObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('configs.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('config_id', 0)) {
            $configsObject = $configsHandler->get(Request::getInt('config_id', 0));
        } else {
            $configsObject = $configsHandler->create();
        }
        // Form save fields
        $configsObject->setVar('config_uid', Request::getVar('config_uid', ''));
        $configsObject->setVar('pictures', Request::getVar('pictures', ''));
        $configsObject->setVar('audio', Request::getVar('audio', ''));
        $configsObject->setVar('videos', Request::getVar('videos', ''));
        $configsObject->setVar('groups', Request::getVar('groups', ''));
        $configsObject->setVar('notes', Request::getVar('notes', ''));
        $configsObject->setVar('friends', Request::getVar('friends', ''));
        $configsObject->setVar('profile_contact', Request::getVar('profile_contact', ''));
        $configsObject->setVar('profile_general', Request::getVar('profile_general', ''));
        $configsObject->setVar('profile_stats', Request::getVar('profile_stats', ''));
        $configsObject->setVar('suspension', ((1 == Request::getInt('suspension', 0)) ? '1' : '0'));
        $configsObject->setVar('backup_password', Request::getVar('backup_password', ''));
        $configsObject->setVar('backup_email', Request::getVar('backup_email', ''));
        //        $configsObject->setVar('end_suspension', date('Y-m-d H:i:s', strtotime($_REQUEST['end_suspension']['date']) + $_REQUEST['end_suspension']['time']));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('end_suspension', '', 'POST'));
        $configsObject->setVar('end_suspension', $dateTimeObj->getTimestamp());
        if ($configsHandler->insert($configsObject)) {
            redirect_header('configs.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $configsObject->getHtmlErrors();
        $form = $configsObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_CONFIGS, 'configs.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_CONFIGS_LIST, 'configs.php', 'list');
        $adminObject->displayButton('left');
        $configsObject = $configsHandler->get(Request::getString('config_id', ''));
        $form          = $configsObject->getForm();
        $form->display();
        break;
    case 'delete':
        $configsObject = $configsHandler->get(Request::getString('config_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('configs.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($configsHandler->delete($configsObject)) {
                redirect_header('configs.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $configsObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'config_id' => Request::getString('config_id', ''), 'op' => 'delete'], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_SUICO_FORMSUREDEL, $configsObject->getVar('config_uid')));
        }
        break;
    case 'clone':
        $id_field = Request::getString('config_id', '');
        if ($utility::cloneRecord('suico_configs', 'config_id', $id_field)) {
            redirect_header('configs.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('configs.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_CONFIGS, 'configs.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                  = Request::getInt('start', 0);
        $configsPaginationLimit = $helper->getConfig('userpager');
        $criteria               = new CriteriaCompo();
        $criteria->setSort('config_id ASC, config_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit($configsPaginationLimit);
        $criteria->setStart($start);
        $configsTempRows  = $configsHandler->getCount();
        $configsTempArray = $configsHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_SUICO_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */
        // Display Page Navigation
        if ($configsTempRows > $configsPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $configsTempRows, $configsPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('configsRows', $configsTempRows);
        $configsArray = [];
        $criteria     = new CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($configsPaginationLimit);
        $criteria->setStart($start);
        $configsCount     = $configsHandler->getCount($criteria);
        $configsTempArray = $configsHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($configsCount > 0) {
            foreach (array_keys($configsTempArray) as $i) {
                $GLOBALS['xoopsTpl']->assign('selectorconfig_id', AM_SUICO_CONFIGS_CONFIG_ID);
                $configsArray['config_id'] = $configsTempArray[$i]->getVar('config_id');
                $GLOBALS['xoopsTpl']->assign('selectorconfig_uid', AM_SUICO_CONFIGS_CONFIG_UID);
                $configsArray['config_uid'] = strip_tags(\XoopsUser::getUnameFromId($configsTempArray[$i]->getVar('config_uid')));
                $GLOBALS['xoopsTpl']->assign('selectorpictures', AM_SUICO_CONFIGS_PICTURES);
                $configsArray['pictures'] = $privacyHandler->get($configsTempArray[$i]->getVar('pictures'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectoraudio', AM_SUICO_CONFIGS_AUDIO);
                $configsArray['audio'] = $privacyHandler->get($configsTempArray[$i]->getVar('audio'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectorvideos', AM_SUICO_CONFIGS_VIDEOS);
                $configsArray['videos'] = $privacyHandler->get($configsTempArray[$i]->getVar('videos'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectorgroups', AM_SUICO_CONFIGS_GROUPS);
                $configsArray['groups'] = $privacyHandler->get($configsTempArray[$i]->getVar('groups'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectornotes', AM_SUICO_CONFIGS_NOTES);
                $configsArray['notes'] = $privacyHandler->get($configsTempArray[$i]->getVar('notes'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectorfriends', AM_SUICO_CONFIGS_FRIENDS);
                $configsArray['friends'] = $privacyHandler->get($configsTempArray[$i]->getVar('friends'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectorprofile_contact', AM_SUICO_CONFIGS_PROFILE_CONTACT);
                $configsArray['profile_contact'] = $privacyHandler->get($configsTempArray[$i]->getVar('profile_contact'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectorprofile_general', AM_SUICO_CONFIGS_PROFILE_GENERAL);
                $configsArray['profile_general'] = $privacyHandler->get($configsTempArray[$i]->getVar('profile_general'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectorprofile_stats', AM_SUICO_CONFIGS_PROFILE_STATS);
                $configsArray['profile_stats'] = $privacyHandler->get($configsTempArray[$i]->getVar('profile_stats'))->getVar('name');
                $GLOBALS['xoopsTpl']->assign('selectorsuspension', AM_SUICO_CONFIGS_SUSPENSION);
                $configsArray['suspension'] = $configsTempArray[$i]->getVar('suspension');
                $GLOBALS['xoopsTpl']->assign('selectorbackup_password', AM_SUICO_CONFIGS_BACKUP_PASSWORD);
                $configsArray['backup_password'] = $configsTempArray[$i]->getVar('backup_password');
                $GLOBALS['xoopsTpl']->assign('selectorbackup_email', AM_SUICO_CONFIGS_BACKUP_EMAIL);
                $configsArray['backup_email'] = $configsTempArray[$i]->getVar('backup_email');
                $GLOBALS['xoopsTpl']->assign('selectorend_suspension', AM_SUICO_CONFIGS_END_SUSPENSION);
                $configsArray['end_suspension'] = formatTimestamp($configsTempArray[$i]->getVar('end_suspension'), 's');
                $configsArray['edit_delete']    = "<a href='configs.php?op=edit&config_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='configs.php?op=delete&config_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='configs.php?op=clone&config_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('configsArrays', $configsArray);
                unset($configsArray);
            }
            unset($configsTempArray);
            // Display Navigation
            if ($configsCount > $configsPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $configsCount, $configsPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/suico_admin_configs.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
