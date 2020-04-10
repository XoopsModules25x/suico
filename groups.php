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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_groups.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\ControllerGroups($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

$start_all = \Xmf\Request::getInt('start_all', 0, 'GET');
$start_my  = \Xmf\Request::getInt('start_my', 0, 'GET');

/**
 * All Groups
 */
$criteria_groups = new \Criteria('group_id', 0, '>');
$nb_groups       = $controller->groupsFactory->getCount($criteria_groups);
$criteria_groups->setLimit($xoopsModuleConfig['groupsperpage']);
$criteria_groups->setStart($start_all);
$groups = $controller->groupsFactory->getGroups($criteria_groups);

/**
 * My Groups
 */
$mygroups          = '';
$criteria_mygroups = new \Criteria('rel_user_uid', $controller->uidOwner);
$nb_mygroups       = $controller->relgroupusersFactory->getCount($criteria_mygroups);
$criteria_mygroups->setLimit($xoopsModuleConfig['groupsperpage']);
$criteria_mygroups->setStart($start_my);
$mygroups = $controller->relgroupusersFactory->getGroups('', $criteria_mygroups, 0);

/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (false !== strpos(mb_strtolower($_SERVER['HTTP_USER_AGENT']), 'msie')) {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs-ie.css');
}
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/css/lightbox.css');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/prototype.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/scriptaculous.js?load=effects');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/lightbox.js');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.lightbox-0.3.css');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.lightbox-0.3.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/yogurt.js');

/**
 * Creating the navigation bar if you have a lot of friends
 */
$barra_navegacao = new \XoopsPageNav($nb_groups, $xoopsModuleConfig['groupsperpage'], $start_all, 'start_all', 'uid=' . (int)$controller->uidOwner . '&amp;start_my=' . $start_my);
$barrinha        = $barra_navegacao->renderImageNav(2); //allgroups

$barra_navegacao_my = new \XoopsPageNav($nb_mygroups, $xoopsModuleConfig['groupsperpage'], $start_my, 'start_my', 'uid=' . (int)$controller->uidOwner . '&amp;start_all=' . $start_all);
$barrinha_my        = $barra_navegacao_my->renderImageNav(2);

$maxfilebytes = $xoopsModuleConfig['maxfilesize'];

//permissions
$xoopsTpl->assign('allow_notes', $controller->checkPrivilegeBySection('notes'));
$xoopsTpl->assign('allow_friends', $controller->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_groups', $controller->checkPrivilegeBySection('groups'));
$xoopsTpl->assign('allow_pictures', $controller->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controller->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controller->checkPrivilegeBySection('audio'));

//form
$xoopsTpl->assign('lang_youcanupload', sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxfilebytes / 1024));
$xoopsTpl->assign('lang_groupimage', _MD_YOGURT_GROUP_IMAGE);
$xoopsTpl->assign('maxfilesize', $maxfilebytes);
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
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);
$xoopsTpl->assign('nb_groups', $nbSections['nbGroups']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYGROUPS);
$xoopsTpl->assign('section_name', _MD_YOGURT_GROUPS);
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_groups', _MD_YOGURT_GROUPS);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner));

//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);
$xoopsTpl->assign('groups', $groups);
$xoopsTpl->assign('mygroups', $mygroups);
$xoopsTpl->assign('lang_mygroupstitle', _MD_YOGURT_MYGROUPS);
$xoopsTpl->assign('lang_groupstitle', _MD_YOGURT_ALLGROUPS . ' (' . $nb_groups . ')');
$xoopsTpl->assign('lang_nogroupsyet', _MD_YOGURT_NOGROUPSYET);

//page nav
$xoopsTpl->assign('barra_navegacao', $barrinha); //allgroups
$xoopsTpl->assign('barra_navegacao_my', $barrinha_my);
$xoopsTpl->assign('nb_groups', $nb_mygroups); // this is the one wich shows in the upper bar actually is about the mygroups
$xoopsTpl->assign('nb_groups_all', $nb_groups); //this is total number of groups

$xoopsTpl->assign('lang_creategroup', _MD_YOGURTCREATEYOURGROUP);
$xoopsTpl->assign('lang_owner', _MD_YOGURT_GROUPOWNER);
$xoopsTpl->assign('lang_abandongroup', _MD_YOGURT_GROUP_ABANDON);
$xoopsTpl->assign('lang_joingroup', _MD_YOGURT_GROUP_JOIN);
$xoopsTpl->assign('lang_searchgroup', _MD_YOGURT_GROUP_SEARCH);
$xoopsTpl->assign('lang_groupkeyword', _MD_YOGURT_GROUP_SEARCHKEYWORD);

require dirname(dirname(__DIR__)) . '/footer.php';
