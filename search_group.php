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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_groups_results.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\ControllerGroups($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

$start_all = \Xmf\Request::getInt('start_all', 0, 'GET');
$start_my  = \Xmf\Request::getInt('start_my', 0, 'GET');

$group_keyword = trim(htmlspecialchars($_GET['group_keyword'], ENT_QUOTES | ENT_HTML5));
/**
 * All Groups
 */
$criteria_title  = new \Criteria('group_title', '%' . $group_keyword . '%', 'LIKE');
$criteria_desc   = new \Criteria('group_desc', '%' . $group_keyword . '%', 'LIKE');
$criteria_groups = new \CriteriaCompo($criteria_title);
$criteria_groups->add($criteria_desc, 'OR');
$nb_groups = $controller->groupsFactory->getCount($criteria_groups);
$criteria_groups->setLimit($xoopsModuleConfig['groupsperpage']);
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

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (false !== strpos(mb_strtolower($_SERVER['HTTP_USER_AGENT']), 'msie')) {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs-ie.css');
}
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.tabs.pack.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/yogurt.js');

/**
 * Creating the navigation bar if you have a lot of friends
 */
$barra_navegacao = new \XoopsPageNav($nb_groups, $xoopsModuleConfig['groupsperpage'], $start_all, 'start_all', 'group_keyword=' . $group_keyword . '&amp;start_my=' . $start_my);
$barrinha        = $barra_navegacao->renderImageNav(2);

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

//form
//$xoopsTpl->assign('lang_youcanupload',sprintf(_MD_YOGURT_YOUCANUPLOAD,$maxfilebytes/1024));
$xoopsTpl->assign('lang_groupimage', _MD_YOGURT_GROUP_IMAGE);
//$xoopsTpl->assign('maxfilesize',$maxfilebytes);
$xoopsTpl->assign('lang_title', _MD_YOGURT_GROUP_TITLE);
$xoopsTpl->assign('lang_description', _MD_YOGURT_GROUP_DESC);
$xoopsTpl->assign('lang_savegroup', _MD_YOGURT_UPLOADGROUP);

//Owner data
$xoopsTpl->assign('uid_owner', $controller->uidOwner);
$xoopsTpl->assign('owner_uname', $controller->nameOwner);
$xoopsTpl->assign('isOwner', $controller->isOwner);
$xoopsTpl->assign('isanonym', $controller->isAnonym);

//numbers
//$xoopsTpl->assign('nb_groups',$nbSections['nbGroups']);look at hte end for this nb
$xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
$xoopsTpl->assign('nb_notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_groups', $nbSections['nbGroups']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYGROUPS);
$xoopsTpl->assign('section_name', _MD_YOGURT_GROUPS);
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
$xoopsTpl->assign('groups', $groups);
//$xoopsTpl->assign('mygroups',$mygroups);
$xoopsTpl->assign('lang_mygroupstitle', _MD_YOGURT_MYGROUPS);
$xoopsTpl->assign('lang_groupstitle', _MD_YOGURT_ALLGROUPS . ' (' . $nb_groups . ')');
$xoopsTpl->assign('lang_nogroupsyet', _MD_YOGURT_NOGROUPSYET);

//page nav
$xoopsTpl->assign('barra_navegacao', $barrinha);
//$xoopsTpl->assign('barra_navegacao_my',$barrinha_my);
//$xoopsTpl->assign('nb_groups',$nb_mygroups);// this is the one wich shows in the upper bar actually is about the mygroups
$xoopsTpl->assign('nb_groups_all', $nb_groups); //this is total number of groups

$xoopsTpl->assign('lang_creategroup', _MD_YOGURTCREATEYOURGROUP);
$xoopsTpl->assign('lang_owner', _MD_YOGURT_GROUPOWNER);
$xoopsTpl->assign('lang_abandongroup', _MD_YOGURT_GROUP_ABANDON);
$xoopsTpl->assign('lang_joingroup', _MD_YOGURT_GROUP_JOIN);
$xoopsTpl->assign('lang_searchgroup', _MD_YOGURT_GROUP_SEARCH);
$xoopsTpl->assign('lang_groupkeyword', _MD_YOGURT_GROUP_SEARCHKEYWORD);

require dirname(dirname(__DIR__)) . '/footer.php';
