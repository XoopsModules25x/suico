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
 * @copyright       XOOPS https://www.xoops.org
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          XOOPS https://www.xoops.org
 */

/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurt.css'
);
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (false !== stripos($_SERVER['HTTP_USER_AGENT'], 'msie')) {
    $xoTheme->addStylesheet(
        XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs-ie.css'
    );
}
if (stripos($_SERVER['REQUEST_URI'], 'album.php')) {
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.lightbox-0.3.css'
);
}

if (!stripos($_SERVER['REQUEST_URI'], 'memberslist.php')) {
$xoTheme->addScript(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.js'
);
}

if (stripos($_SERVER['REQUEST_URI'], 'album.php')) {
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.lightbox-0.3.js'); }
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/yogurt.js');

if (stripos($_SERVER['REQUEST_URI'], 'memberslist.php')) {
if ('datatables' == $xoopsModuleConfig['memberslisttemplate']) {
	$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.dataTables.css');
	$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/responsive.dataTables.min.css');
	$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.dataTables.js');
	$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/dataTables.responsive.min.js');
}
}


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

//Owner data

$xoopsTpl->assign('uid_owner', $controller->uidOwner);
$xoopsTpl->assign('owner_uname', $controller->nameOwner);
$xoopsTpl->assign('isOwner', $controller->isOwner);
$xoopsTpl->assign('isAnonym', $controller->isAnonym);
$xoopsTpl->assign('isUser', $controller->isUser);
$xoopsTpl->assign('isFriend', $controller->isFriend);

//Is Webmaster/Administrator
if ($xoopsUser && $xoopsUser->isAdmin(1)) {
    $xoopsTpl->assign('isWebmaster', '1');
} else {
    $xoopsTpl->assign('isWebmaster', '0');
}

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
$xoopsTpl->assign('nb_groups', $nbSections['nbGroups']);
$xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
$xoopsTpl->assign('nb_notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
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
$xoopsTpl->assign(
    'xoops_pagetitle',
    sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner)
);

//Memberslist and Search Members
$xoopsTpl->assign('displayrealname', $xoopsModuleConfig['displayrealname']);
$xoopsTpl->assign('displayemail', $xoopsModuleConfig['displayemail']);
$xoopsTpl->assign('displaypm', $xoopsModuleConfig['displaypm']);
$xoopsTpl->assign('displayurl', $xoopsModuleConfig['displayurl']);
$xoopsTpl->assign('displayavatar', $xoopsModuleConfig['displayavatar']);
$xoopsTpl->assign('displayregdate', $xoopsModuleConfig['displayregdate']);
$xoopsTpl->assign('displayfrom', $xoopsModuleConfig['displayfrom']);
$xoopsTpl->assign('displayposts', $xoopsModuleConfig['displayposts']);
$xoopsTpl->assign('displaylastlogin', $xoopsModuleConfig['displaylastlogin']);
$xoopsTpl->assign('displayoccupation', $xoopsModuleConfig['displayoccupation']);
$xoopsTpl->assign('displayinterest', $xoopsModuleConfig['displayinterest']);
$xoopsTpl->assign('displaylatestmember', $xoopsModuleConfig['displaylatestmember']);
$xoopsTpl->assign('displaywelcomemessage', $xoopsModuleConfig['displaywelcomemessage']);
$xoopsTpl->assign('displaybreadcrumb', $xoopsModuleConfig['displaybreadcrumb']);
$xoopsTpl->assign('displaytotalmember', $xoopsModuleConfig['displaytotalmember']);
$xoopsTpl->assign('displaysignature', $xoopsModuleConfig['displaysignature']);
$xoopsTpl->assign('displayrank', $xoopsModuleConfig['displayrank']);
$xoopsTpl->assign('displaygroups', $xoopsModuleConfig['displaygroups']);
$xoopsTpl->assign('displayonlinestatus', $xoopsModuleConfig['displayonlinestatus']);
$xoopsTpl->assign('displayextrainfo', $xoopsModuleConfig['displayextrainfo']);
$xoopsTpl->assign('membersperpage', $xoopsModuleConfig['membersperpage']);
$xoopsTpl->assign('memberslisttemplate', $xoopsModuleConfig['memberslisttemplate']);