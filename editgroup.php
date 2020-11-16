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

use Xmf\Request;
use XoopsModules\Suico\{
    GroupController
};

$GLOBALS['xoopsOption']['template_main'] = 'suico_editgroup.tpl';
require __DIR__ . '/header.php';
$controller = new GroupController($xoopsDB, $xoopsUser);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
$group_id   = Request::getInt('group_id', 0, 'POST');
$marker     = Request::getInt('marker', 0, 'POST');
$criteria   = new Criteria('group_id', $group_id);
$groups     = $controller->groupsFactory->getObjects($criteria);
$group      = $groups[0];
$uid        = $xoopsUser->getVar('uid');
if (1 === $marker && $group->getVar('owner_uid') === $uid) {
    $title         = Request::getString('title', '', 'POST');
    $desc          = Request::getString('desc', '', 'POST');
    $img           = Request::getString('img', '', 'POST');
    $updateImg     = 1 === Request::getInt('flag_oldimg', 0, 'POST') ? 0 : 1;
    $path_upload   = XOOPS_ROOT_PATH . '/uploads/suico/images';
    $maxfilebytes  = $helper->getConfig('maxfilesize');
    $maxfileheight = $helper->getConfig('max_original_height');
    $maxfilewidth  = $helper->getConfig('max_original_width');
    $controller->groupsFactory->receiveGroup(
        $title,
        $desc,
        $img,
        $path_upload,
        $maxfilebytes,
        $maxfilewidth,
        $maxfileheight,
        $updateImg,
        $group
    );
    redirect_header('group.php?group_id=' . $group_id . '', 3, _MD_SUICO_GROUPEDITED);
} else {
    /**
     * Render a form with the info of the user
     */
    $group_members = $controller->relgroupusersFactory->getUsersFromGroup(
        $group_id,
        0,
        50
    );
    $xoopsTpl->assign('group_members', $group_members);
    $maxfilebytes = $helper->getConfig('maxfilesize');
    $xoopsTpl->assign('lang_savegroup', _MD_SUICO_UPLOADGROUP);
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
    $xoopsTpl->assign('lang_membersofgroup', _MD_SUICO_MEMBERSOFGROUP);
    $xoopsTpl->assign('lang_editgroup', _MD_SUICO_EDIT_GROUP);
    $xoopsTpl->assign('lang_groupimage', _MD_SUICO_GROUP_IMAGE);
    $xoopsTpl->assign('lang_keepimage', _MD_SUICO_MAINTAIN_OLD_IMAGE);
    $xoopsTpl->assign('lang_youcanupload', sprintf(_MD_SUICO_YOU_CAN_UPLOAD, $maxfilebytes / 1024));
    $xoopsTpl->assign('lang_titlegroup', _MD_SUICO_GROUP_TITLE);
    $xoopsTpl->assign('lang_descgroup', _MD_SUICO_GROUP_DESC);
    //Owner data
    $xoopsTpl->assign('uid_owner', $controller->uidOwner);
    $xoopsTpl->assign('owner_uname', $controller->nameOwner);
    $xoopsTpl->assign('isOwner', $controller->isOwner);
    $xoopsTpl->assign('isAnonym', $controller->isAnonym);
    //numbers
    $xoopsTpl->assign('countGroups', $nbSections['countGroups']);
    $xoopsTpl->assign('countPhotos', $nbSections['countPhotos']);
    $xoopsTpl->assign('countVideos', $nbSections['countGroups']);
    $xoopsTpl->assign('countNotes', $nbSections['countNotes']);
    $xoopsTpl->assign('countFriends', $nbSections['countFriends']);
    $xoopsTpl->assign('countAudio', $nbSections['countAudios']);
    //navbar
    $xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
    $xoopsTpl->assign('lang_mysection', _MD_SUICO_GROUPS . ' :: ' . _MD_SUICO_EDIT_GROUP);
    $xoopsTpl->assign('section_name', _MD_SUICO_GROUPS . '> ' . _MD_SUICO_EDIT_GROUP);
    $xoopsTpl->assign('lang_home', _MD_SUICO_HOME);
    $xoopsTpl->assign('lang_photos', _MD_SUICO_PHOTOS);
    $xoopsTpl->assign('lang_friends', _MD_SUICO_FRIENDS);
    $xoopsTpl->assign('lang_videos', _MD_SUICO_VIDEOS);
    $xoopsTpl->assign('lang_notebook', _MD_SUICO_NOTEBOOK);
    $xoopsTpl->assign('lang_profile', _MD_SUICO_PROFILE);
    $xoopsTpl->assign('lang_groups', _MD_SUICO_GROUPS);
    $xoopsTpl->assign('lang_configs', _MD_SUICO_CONFIGS_TITLE);
    $xoopsTpl->assign('lang_audio', _MD_SUICO_AUDIOS);
    //xoopsToken
    $xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
    //page atributes
    $xoopsTpl->assign(
        'xoops_pagetitle',
        sprintf(_MD_SUICO_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner)
    );
    //$xoopsTpl->assign('path_suico_uploads',$helper->getConfig('link_path_upload'));
    $xoopsTpl->assign(
        'lang_owner',
        _MD_SUICO_GROUPOWNER
    );
}
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
