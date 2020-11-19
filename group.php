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


$GLOBALS['xoopsOption']['template_main'] = 'suico_group.tpl';
require __DIR__ . '/header.php';
$helper->loadLanguage('main');
$controller = new GroupController($xoopsDB, $xoopsUser);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
$group_id   = Request::getInt('group_id', 0, 'GET');
$criteria   = new Criteria('group_id', $group_id);
$groups     = $controller->groupsFactory->getObjects($criteria);
$group      = $groups[0];
/**
 * Fetching rel_id
 */
$sql               = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('suico_relgroupuser') . ' WHERE rel_group_id=' . $group_id . ' AND rel_user_uid=' . $controller->uidOwner . '';
$result            = $GLOBALS['xoopsDB']->query($sql);
$myrow             = $GLOBALS['xoopsDB']->fetchArray($result);
$mygroup['rel_id'] = $myrow['rel_id'];
$xoopsTpl->assign('group_rel_id', $mygroup['rel_id']);
/**
 * Render a form with the info of the user
 */
$group_members = $controller->relgroupusersFactory->getUsersFromGroup(
    $group_id,
    0,
    50
);
if (!empty($uids)) {
    if ($xoopsUser) {
        $uid = (int)$xoopsUser->getVar('uid');
        if (in_array($uid, $uids, true)) {
            $xoopsTpl->assign('memberOfGroup', 1);
        }
        $xoopsTpl->assign('useruid', $uid);
    }
}
/**
 * Get Total Members for Group */
$group_total_members = $controller->groupsFactory->getGroupTotalMembers($group_id);
if ($group_total_members > 0) {
    if (1 == $group_total_members) {
        $xoopsTpl->assign('group_total_members', '' . _MD_SUICO_ONEMEMBER . '&nbsp;');
    } else {
        $xoopsTpl->assign('group_total_members', '' . $group_total_members . '&nbsp;' . _MD_SUICO_GROUPMEMBERS . '&nbsp;');
    }
} else {
    $xoopsTpl->assign('group_total_members', '' . _MD_SUICO_NO_MEMBER . '&nbsp;');
}
/**
 * Get Total Comment for Group */
$group_total_comments = $controller->groupsFactory->getComment($group_id);
if ($group_total_comments > 0) {
    if (1 == $group_total_comments) {
        $xoopsTpl->assign('group_total_comments', '' . _MD_SUICO_ONECOMMENT . '&nbsp;');
    } else {
        $xoopsTpl->assign('group_total_comments', '' . $group_total_comments . '&nbsp;' . _MD_SUICO_COMMENTS . '&nbsp;');
    }
} else {
    $xoopsTpl->assign('group_total_comments', '' . _MD_SUICO_NO_COMMENTS . '&nbsp;');
}
$owner_uid       = $group->getVar('owner_uid');
$group_ownername = XoopsUser::getUnameFromId($owner_uid);
$xoopsTpl->assign('group_members', $group_members);
$maxfilebytes = $helper->getConfig('maxfilesize');
$xoopsTpl->assign('lang_savegroup', _MD_SUICO_UPLOADGROUP);
$xoopsTpl->assign('maxfilesize', $maxfilebytes);
$xoopsTpl->assign('group_title', $group->getVar('group_title'));
$xoopsTpl->assign('group_desc', $group->getVar('group_desc'));
$xoopsTpl->assign('group_img', $group->getVar('group_img'));
$xoopsTpl->assign('group_id', $group->getVar('group_id'));
$xoopsTpl->assign('group_date_created', formatTimestamp($group->getVar('date_created')));
$xoopsTpl->assign('group_date_updated', formatTimestamp($group->getVar('date_updated')));
$xoopsTpl->assign('group_owneruid', $group->getVar('owner_uid'));
$xoopsTpl->assign('group_ownername', $group_ownername);
$xoopsTpl->assign('lang_groupmembers', _MD_SUICO_GROUPMEMBERS);
$xoopsTpl->assign('lang_membersofgroup', _MD_SUICO_MEMBERSOFGROUP);
$xoopsTpl->assign('lang_editgroup', _MD_SUICO_EDIT_GROUP);
$xoopsTpl->assign('lang_groupimage', _MD_SUICO_GROUP_IMAGE);
$xoopsTpl->assign('lang_keepimage', _MD_SUICO_MAINTAIN_OLD_IMAGE);
$xoopsTpl->assign('lang_youcanupload', sprintf(_MD_SUICO_YOU_CAN_UPLOAD, $maxfilebytes / 1024));
$xoopsTpl->assign('lang_titlegroup', _MD_SUICO_GROUP_TITLE);
$xoopsTpl->assign('lang_descgroup', _MD_SUICO_GROUP_DESC);
$xoopsTpl->assign('lang_abandongroup', _MD_SUICO_GROUP_ABANDON);
$xoopsTpl->assign('lang_joingroup', _MD_SUICO_GROUP_JOIN);
$xoopsTpl->assign('lang_ownerofgroup', _MD_SUICO_OWNEROFGROUP);
$xoopsTpl->assign('lang_removemember', _MD_SUICO_KICKOUT);
//$xoopsTpl->assign('path_suico_uploads',$helper->getConfig('link_path_upload'));
$xoopsTpl->assign(
    'lang_owner',
    _MD_SUICO_GROUPOWNER
);
$xoopsTpl->assign('lang_mysection', _MD_SUICO_GROUPS . ' :: ' . $group->getVar('group_title'));
$xoopsTpl->assign('section_name', _MD_SUICO_GROUPS . '> ' . $group->getVar('group_title'));
require_once XOOPS_ROOT_PATH . '/include/comment_view.php';
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
