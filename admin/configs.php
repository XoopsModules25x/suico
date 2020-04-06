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
        $adminObject->addItemButton(AM_YOGURT_CONFIGS_LIST, 'configs.php', 'list');
        $adminObject->displayButton('left');

        $configsObject = $configsHandler->create();
        $form          = $configsObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('configs.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('config_id', 0)) {
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
        $configsObject->setVar('suspension', Request::getVar('suspension', ''));
        $configsObject->setVar('backup_password', Request::getVar('backup_password', ''));
        $configsObject->setVar('backup_email', Request::getVar('backup_email', ''));
        $configsObject->setVar('end_suspension', $_REQUEST['end_suspension']);
        if ($configsHandler->insert($configsObject)) {
            redirect_header('configs.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $configsObject->getHtmlErrors();
        $form = $configsObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_CONFIGS, 'configs.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_CONFIGS_LIST, 'configs.php', 'list');
        $adminObject->displayButton('left');
        $configsObject = $configsHandler->get(Request::getString('config_id', ''));
        $form          = $configsObject->getForm();
        $form->display();
        break;

    case 'delete':
        $configsObject = $configsHandler->get(Request::getString('config_id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('configs.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($configsHandler->delete($configsObject)) {
                redirect_header('configs.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $configsObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'config_id' => Request::getString('config_id', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_YOGURT_FORMSUREDEL, $configsObject->getVar('config_id')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('config_id', '');

        if ($utility::cloneRecord('yogurt_configs', 'config_id', $id_field)) {
            redirect_header('configs.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('configs.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_CONFIGS, 'configs.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                  = \Xmf\Request::getInt('start', 0);
        $configsPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('config_id ASC, config_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit($configsPaginationLimit);
        $criteria->setStart($start);
        $configsTempRows  = $configsHandler->getCount();
        $configsTempArray = $configsHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
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

        //    $fields = explode('|', config_id:int:11::NOT NULL::primary:config_id|config_uid:int:11::NOT NULL:::config_uid|pictures:tinyint:1::NOT NULL:::pictures|audio:tinyint:1::NOT NULL:::audio|videos:tinyint:1::NOT NULL:::videos|groups:tinyint:1::NOT NULL:::groups|notes:tinyint:1::NOT NULL:::notes|friends:tinyint:1::NOT NULL:::friends|profile_contact:tinyint:1::NOT NULL:::profile_contact|profile_general:tinyint:1::NOT NULL:::profile_general|profile_stats:tinyint:1::NOT NULL:::profile_stats|suspension:tinyint:1::NOT NULL:::suspension|backup_password:varchar:255::NOT NULL:::backup_password|backup_email:varchar:255::NOT NULL:::backup_email|end_suspension:timestamp:0::NOT NULL:CURRENT_TIMESTAMP::end_suspension);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

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
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorconfig_id', AM_YOGURT_CONFIGS_CONFIG_ID);
                $configsArray['config_id'] = $configsTempArray[$i]->getVar('config_id');

                $GLOBALS['xoopsTpl']->assign('selectorconfig_uid', AM_YOGURT_CONFIGS_CONFIG_UID);
                $configsArray['config_uid'] = strip_tags(\XoopsUser::getUnameFromId($configsTempArray[$i]->getVar('config_uid')));

                $GLOBALS['xoopsTpl']->assign('selectorpictures', AM_YOGURT_CONFIGS_PICTURES);
                $configsArray['pictures'] = $imagesHandler->get($configsTempArray[$i]->getVar('pictures'))->getVar('title');

                $GLOBALS['xoopsTpl']->assign('selectoraudio', AM_YOGURT_CONFIGS_AUDIO);
                $configsArray['audio'] = $audioHandler->get($configsTempArray[$i]->getVar('audio'))->getVar('title');

                $GLOBALS['xoopsTpl']->assign('selectorvideos', AM_YOGURT_CONFIGS_VIDEOS);
                $configsArray['videos'] = $videoHandler->get($configsTempArray[$i]->getVar('videos'))->getVar('title');

                $GLOBALS['xoopsTpl']->assign('selectorgroups', AM_YOGURT_CONFIGS_GROUPS);
                $configsArray['groups'] = $groupsHandler->get($configsTempArray[$i]->getVar('groups'))->getVar('group_title');

                $GLOBALS['xoopsTpl']->assign('selectornotes', AM_YOGURT_CONFIGS_NOTES);
                $configsArray['notes'] = $notesHandler->get($configsTempArray[$i]->getVar('notes'))->getVar('note_id');

                $GLOBALS['xoopsTpl']->assign('selectorfriends', AM_YOGURT_CONFIGS_FRIENDS);
                $configsArray['friends'] = $friendshipHandler->get($configsTempArray[$i]->getVar('friends'))->getVar('friendship_id');

                $GLOBALS['xoopsTpl']->assign('selectorprofile_contact', AM_YOGURT_CONFIGS_PROFILE_CONTACT);
                $configsArray['profile_contact'] = strip_tags(\XoopsUser::getUnameFromId($configsTempArray[$i]->getVar('profile_contact')));

                $GLOBALS['xoopsTpl']->assign('selectorprofile_general', AM_YOGURT_CONFIGS_PROFILE_GENERAL);
                $configsArray['profile_general'] = strip_tags(\XoopsUser::getUnameFromId($configsTempArray[$i]->getVar('profile_general')));

                $GLOBALS['xoopsTpl']->assign('selectorprofile_stats', AM_YOGURT_CONFIGS_PROFILE_STATS);
                $configsArray['profile_stats'] = strip_tags(\XoopsUser::getUnameFromId($configsTempArray[$i]->getVar('profile_stats')));

                $GLOBALS['xoopsTpl']->assign('selectorsuspension', AM_YOGURT_CONFIGS_SUSPENSION);
                $configsArray['suspension'] = $suspensionsHandler->get($configsTempArray[$i]->getVar('suspension'))->getVar('uid');

                $GLOBALS['xoopsTpl']->assign('selectorbackup_password', AM_YOGURT_CONFIGS_BACKUP_PASSWORD);
                $configsArray['backup_password'] = $configsTempArray[$i]->getVar('backup_password');

                $GLOBALS['xoopsTpl']->assign('selectorbackup_email', AM_YOGURT_CONFIGS_BACKUP_EMAIL);
                $configsArray['backup_email'] = $configsTempArray[$i]->getVar('backup_email');

                $GLOBALS['xoopsTpl']->assign('selectorend_suspension', AM_YOGURT_CONFIGS_END_SUSPENSION);
                $configsArray['end_suspension'] = date(_SHORTDATESTRING, strtotime((string)$configsTempArray[$i]->getVar('end_suspension')));
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

            //                     echo "<td class='center width5'>

            //                    <a href='configs.php?op=edit&config_id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='configs.php?op=delete&config_id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='16'>There are noXXX configs</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/yogurt_admin_configs.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
