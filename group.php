<?php declare(strict_types=1);

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

use Xmf\Request;
use XoopsModules\Yogurt;

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_group.tpl';
require __DIR__ . '/header.php';

$helper->loadLanguage('main');

$controller = new Yogurt\GroupController($xoopsDB, $xoopsUser);

$group_id = Request::getInt('group_id', 0, 'GET');
$criteria = new Criteria('group_id', $group_id);
$groups   = $controller->groupsFactory->getObjects($criteria);
$group    = $groups[0];

/**
 * Fetching rel_id
 */

$sql                 = 'SELECT * FROM ' . $GLOBALS['xoopsDB']->prefix('yogurt_relgroupuser') . ' WHERE rel_group_id='.$group_id.' AND rel_user_uid='.$controller->uidOwner.'';
$result              = $GLOBALS['xoopsDB']->query($sql);
$myrow               = $GLOBALS['xoopsDB']->fetchArray($result);
$mygroup['rel_id']   = $myrow['rel_id'];
$xoopsTpl->assign('group_rel_id', $mygroup['rel_id']);

/**
 * Render a form with the info of the user
 */
$group_members = $controller->relgroupusersFactory->getUsersFromGroup(
    $group_id,
    0,
    50
);
foreach ($group_members as $group_member) {
    $uids[] = (int)$group_member['uid'];
}


if ($xoopsUser) {
$uid = (int)$xoopsUser->getVar('uid');
    if (in_array($uid, $uids, true)) {
        $xoopsTpl->assign('memberOfGroup', 1);
    }
    $xoopsTpl->assign('useruid', $uid);
}
$owner_uid       = $group->getVar('owner_uid');
$group_ownername = XoopsUser::getUnameFromId($owner_uid);

$xoopsTpl->assign('group_members', $group_members);
$maxfilebytes = $helper->getConfig('maxfilesize');
$xoopsTpl->assign('lang_savegroup', _MD_YOGURT_UPLOADGROUP);
$xoopsTpl->assign('maxfilesize', $maxfilebytes);
$xoopsTpl->assign('group_title', $group->getVar('group_title'));
$xoopsTpl->assign('group_desc', $group->getVar('group_desc'));
$xoopsTpl->assign('group_img', $group->getVar('group_img'));
$xoopsTpl->assign('group_id', $group->getVar('group_id'));
$xoopsTpl->assign('group_owneruid', $group->getVar('owner_uid'));
$xoopsTpl->assign('group_ownername', $group_ownername);

$xoopsTpl->assign('lang_membersofgroup', _MD_YOGURT_MEMBERSDOFGROUP);
$xoopsTpl->assign('lang_editgroup', _MD_YOGURT_EDIT_GROUP);
$xoopsTpl->assign('lang_groupimage', _MD_YOGURT_GROUP_IMAGE);
$xoopsTpl->assign('lang_keepimage', _MD_YOGURT_MAINTAINOLDIMAGE);
$xoopsTpl->assign('lang_youcanupload', sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxfilebytes / 1024));
$xoopsTpl->assign('lang_titlegroup', _MD_YOGURT_GROUP_TITLE);
$xoopsTpl->assign('lang_descgroup', _MD_YOGURT_GROUP_DESC);
$xoopsTpl->assign('lang_abandongroup', _MD_YOGURT_GROUP_ABANDON);
$xoopsTpl->assign('lang_joingroup', _MD_YOGURT_GROUP_JOIN);
$xoopsTpl->assign('lang_ownerofgroup', _MD_YOGURT_OWNEROFGROUP);
$xoopsTpl->assign('lang_removemember', _MD_YOGURT_KICKOUT);

//$xoopsTpl->assign('path_yogurt_uploads',$helper->getConfig('link_path_upload'));
$xoopsTpl->assign(
    'lang_owner',
    _MD_YOGURT_GROUPOWNER
);

$xoopsTpl->assign('lang_mysection', _MD_YOGURT_GROUPS . ' :: ' . $group->getVar('group_title'));
$xoopsTpl->assign('section_name', _MD_YOGURT_GROUPS . '> ' . $group->getVar('group_title'));

require_once XOOPS_ROOT_PATH . '/include/comment_view.php';

require __DIR__ . '/footer.php';
require dirname(dirname(__DIR__)) . '/footer.php';
