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
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Marcello Brandão aka  Suico
 * @author       XOOPS Development Team
 * @since
 */

use XoopsModules\Yogurt;

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_editgroup.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\ControllerGroups($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

$group_id = \Xmf\Request::getInt('group_id', 0, 'POST');
$marker   = \Xmf\Request::getInt('marker', 0, 'POST');
$criteria = new \Criteria('group_id', $group_id);
$groups   = $controller->groupsFactory->getObjects($criteria);
$group    = $groups[0];

$uid = $xoopsUser->getVar('uid');

if (1 == $marker && $group->getVar('owner_uid') == $uid) {
    $title     = trim(htmlspecialchars($_POST['title'], ENT_QUOTES | ENT_HTML5));
    $desc      = $_POST['desc'];
    $img       = $_POST['img'];
    $updateImg = (1 == $_POST['flag_oldimg']) ? 0 : 1;

    $path_upload   = XOOPS_ROOT_PATH . '/uploads/yogurt/images';
    $maxfilebytes  = $xoopsModuleConfig['maxfilesize'];
    $maxfileheight = $xoopsModuleConfig['max_original_height'];
    $maxfilewidth  = $xoopsModuleConfig['max_original_width'];
    $controller->groupsFactory->receiveGroup($title, $desc, $img, $path_upload, $maxfilebytes, $maxfilewidth, $maxfileheight, $updateImg, $group);

    redirect_header('groups.php?uid=' . $uid, 3, _MD_YOGURT_GROUPEDITED);
} else {
    /**
     * Render a form with the info of the user
     */
    $group_members = $controller->relgroupusersFactory->getUsersFromGroup($group_id, 0, 50);
    $xoopsTpl->assign('group_members', $group_members);
    $maxfilebytes = $xoopsModuleConfig['maxfilesize'];
    $xoopsTpl->assign('lang_savegroup', _MD_YOGURT_UPLOADGROUP);
    $xoopsTpl->assign('maxfilesize', $maxfilebytes);
    $xoopsTpl->assign('group_title', $group->getVar('group_title'));
    $xoopsTpl->assign('group_desc', $group->getVar('group_desc'));
    $xoopsTpl->assign('group_img', $group->getVar('group_img'));
    $xoopsTpl->assign('group_id', $group->getVar('group_id'));

    //permissions
    $xoopsTpl->assign('allow_notes', $controller->checkPrivilegeBySection('notes'));
    $xoopsTpl->assign('allow_friends', $controller->checkPrivilegeBySection('friends'));
    $xoopsTpl->assign('allow_groups', $controller->checkPrivilegeBySection('groups'));
    $xoopsTpl->assign('allow_pictures', $controller->checkPrivilegeBySection('pictures'));
    $xoopsTpl->assign('allow_videos', $controller->checkPrivilegeBySection('videos'));
    $xoopsTpl->assign('allow_audios', $controller->checkPrivilegeBySection('audio'));
    $xoopsTpl->assign('allow_profile_contact', $controller->checkPrivilege('profile_contact') ? 1 : 0);
    $xoopsTpl->assign('allow_profile_general', $controller->checkPrivilege('profile_general') ? 1 : 0);
    $xoopsTpl->assign('allow_profile_stats', $controller->checkPrivilege('profile_stats') ? 1 : 0);

    $xoopsTpl->assign('lang_membersofgroup', _MD_YOGURT_MEMBERSDOFGROUP);
    $xoopsTpl->assign('lang_editgroup', _MD_YOGURT_EDIT_GROUP);
    $xoopsTpl->assign('lang_groupimage', _MD_YOGURT_GROUP_IMAGE);
    $xoopsTpl->assign('lang_keepimage', _MD_YOGURT_MAINTAINOLDIMAGE);
    $xoopsTpl->assign('lang_youcanupload', sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxfilebytes / 1024));
    $xoopsTpl->assign('lang_titlegroup', _MD_YOGURT_GROUP_TITLE);
    $xoopsTpl->assign('lang_descgroup', _MD_YOGURT_GROUP_DESC);

    //Owner data
    $xoopsTpl->assign('uid_owner', $controller->uidOwner);
    $xoopsTpl->assign('owner_uname', $controller->nameOwner);
    $xoopsTpl->assign('isOwner', $controller->isOwner);
    $xoopsTpl->assign('isanonym', $controller->isAnonym);

    //numbers
    $xoopsTpl->assign('nb_groups', $nbSections['nbGroups']);
    $xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
    $xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
    $xoopsTpl->assign('nb_notes', $nbSections['nbNotes']);
    $xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
    $xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

    //navbar
    $xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
    $xoopsTpl->assign('lang_mysection', _MD_YOGURT_GROUPS . ' :: ' . _MD_YOGURT_EDIT_GROUP);
    $xoopsTpl->assign('section_name', _MD_YOGURT_GROUPS . '> ' . _MD_YOGURT_EDIT_GROUP);
    $xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
    $xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
    $xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
    $xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
    $xoopsTpl->assign('lang_notebook', _MD_YOGURT_NOTEBOOK);
    $xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
    $xoopsTpl->assign('lang_groups', _MD_YOGURT_GROUPS);
    $xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);
    $xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);

    //xoopsToken
    $xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

    //page atributes
    $xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner));

    //$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);
    $xoopsTpl->assign('lang_owner', _MD_YOGURT_GROUPOWNER);
}

$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/yogurt.js');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (false !== strpos(mb_strtolower($_SERVER['HTTP_USER_AGENT']), 'msie')) {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs-ie.css');
}

require dirname(dirname(__DIR__)) . '/footer.php';
