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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_groups_results.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\GroupController($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

$start_all = Request::getInt('start_all', 0, 'GET');
$start_my  = Request::getInt('start_my', 0, 'GET');

$group_keyword = trim(htmlspecialchars(Request::getString('group_keyword', '', 'GET'), ENT_QUOTES | ENT_HTML5));
/**
 * All Groups
 */
$criteria_title  = new Criteria('group_title', '%' . $group_keyword . '%', 'LIKE');
$criteria_desc   = new Criteria('group_desc', '%' . $group_keyword . '%', 'LIKE');
$criteria_groups = new CriteriaCompo($criteria_title);
$criteria_groups->add($criteria_desc, 'OR');
$nb_groups = $controller->groupsFactory->getCount($criteria_groups);
$criteria_groups->setLimit($helper->getConfig('groupsperpage'));
$criteria_groups->setStart($start_all);
$groups_objects = $controller->groupsFactory->getObjects($criteria_groups);
$i              = 0;
foreach ($groups_objects as $group_object) {
    $groups[$i]['id']    = $group_object->getVar('group_id');
    $groups[$i]['title'] = $group_object->getVar('group_title');
    $groups[$i]['img']   = $group_object->getVar('group_img');
    $groups[$i]['desc']  = $group_object->getVar('group_desc');
    $groups[$i]['uid']   = $group_object->getVar('owner_uid');
    $i++;
}

/**
 * My Groups
 */
$mygroups          = '';
$criteria_mygroups = new Criteria('rel_user_uid', $controller->uidOwner);
$nb_mygroups       = $controller->relgroupusersFactory->getCount($criteria_mygroups);
$criteria_mygroups->setLimit($helper->getConfig('groupsperpage'));
$criteria_mygroups->setStart($start_my);
$mygroups = $controller->relgroupusersFactory->getGroups('', $criteria_mygroups, 0);


$mygroupsid =[];
foreach ($mygroups as $value) {
    $mygroupsid[] = $value['group_id'];
}

/**
 * Creating the navigation bar if you have a lot of friends
 */
$navigationBar = new XoopsPageNav(
    $nb_groups,
    $helper->getConfig('groupsperpage'),
    $start_all,
    'start_all',
    'group_keyword=' . $group_keyword . '&amp;start_my=' . $start_my
);
$barrinha        = $navigationBar->renderImageNav(2);


//form
//$xoopsTpl->assign('lang_youcanupload',sprintf(_MD_YOGURT_YOU_CAN_UPLOAD,$maxfilebytes/1024));
$xoopsTpl->assign(
    'lang_groupimage',
    _MD_YOGURT_GROUP_IMAGE
);
//$xoopsTpl->assign('maxfilesize',$maxfilebytes);
$xoopsTpl->assign('lang_title', _MD_YOGURT_GROUP_TITLE);
$xoopsTpl->assign('lang_description', _MD_YOGURT_GROUP_DESC);
$xoopsTpl->assign('lang_savegroup', _MD_YOGURT_UPLOADGROUP);

//navbar
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYGROUPS);
$xoopsTpl->assign('section_name', _MD_YOGURT_GROUPS);

//$xoopsTpl->assign('path_yogurt_uploads',$helper->getConfig('link_path_upload'));
$xoopsTpl->assign('groups', $groups);
//$xoopsTpl->assign('mygroups',$mygroups);
$xoopsTpl->assign('lang_mygroupstitle', _MD_YOGURT_MYGROUPS);
$xoopsTpl->assign('lang_groupstitle', _MD_YOGURT_ALLGROUPS . ' (' . $nb_groups . ')');
$xoopsTpl->assign('lang_nogroupsyet', _MD_YOGURT_NOGROUPSYET);

//page nav
$xoopsTpl->assign('navigationBar', $barrinha);
//$xoopsTpl->assign('navigationBar_my',$barrinha_my);
//$xoopsTpl->assign('nb_groups',$nb_mygroups);// this is the one wich shows in the upper bar actually is about the mygroups
$xoopsTpl->assign(
    'nb_groups_all',
    $nb_groups
); //this is total number of groups

$xoopsTpl->assign('lang_creategroup', _MD_YOGURTCREATEYOURGROUP);
$xoopsTpl->assign('lang_owner', _MD_YOGURT_GROUPOWNER);
$xoopsTpl->assign('lang_abandongroup', _MD_YOGURT_GROUP_ABANDON);
$xoopsTpl->assign('lang_joingroup', _MD_YOGURT_GROUP_JOIN);
$xoopsTpl->assign('lang_searchgroup', _MD_YOGURT_GROUP_SEARCH);
$xoopsTpl->assign('lang_groupkeyword', _MD_YOGURT_GROUP_SEARCHKEYWORD);
$xoopsTpl->assign('lang_memberofgroup', _MD_YOGURT_MEMBEROFGROUP);

require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
