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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_tribe.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\ControllerTribes($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of tribes friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

$tribe_id = \Xmf\Request::getInt('tribe_id', 0, 'GET');
$criteria = new \Criteria('tribe_id', $tribe_id);
$tribes   = $controller->tribesFactory->getObjects($criteria);
$tribe    = $tribes[0];

/**
 * Render a form with the info of the user
 */
$tribe_members = $controller->reltribeusersFactory->getUsersFromTribe($tribe_id, 0, 50);
foreach ($tribe_members as $tribe_member) {
    $uids[] = (int)$tribe_member['uid'];
}

$uid = (int)$xoopsUser->getVar('uid');
if ($xoopsUser) {
    if (in_array($uid, $uids)) {
        $xoopsTpl->assign('memberOfTribe', 1);
    }
    $xoopsTpl->assign('useruid', $uid);
}
$xoopsTpl->assign('tribe_members', $tribe_members);
$maxfilebytes = $xoopsModuleConfig['maxfilesize'];
$xoopsTpl->assign('lang_savetribe', _MD_YOGURT_UPLOADTRIBE);
$xoopsTpl->assign('maxfilesize', $maxfilebytes);
$xoopsTpl->assign('tribe_title', $tribe->getVar('tribe_title'));
$xoopsTpl->assign('tribe_desc', $tribe->getVar('tribe_desc'));
$xoopsTpl->assign('tribe_img', $tribe->getVar('tribe_img'));
$xoopsTpl->assign('tribe_id', $tribe->getVar('tribe_id'));
$xoopsTpl->assign('tribe_owneruid', $tribe->getVar('owner_uid'));

$xoopsTpl->assign('lang_membersoftribe', _MD_YOGURT_MEMBERSDOFTRIBE);
$xoopsTpl->assign('lang_edittribe', _MD_YOGURT_EDIT_TRIBE);
$xoopsTpl->assign('lang_tribeimage', _MD_YOGURT_TRIBE_IMAGE);
$xoopsTpl->assign('lang_keepimage', _MD_YOGURT_MAINTAINOLDIMAGE);
$xoopsTpl->assign('lang_youcanupload', sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxfilebytes / 1024));
$xoopsTpl->assign('lang_titletribe', _MD_YOGURT_TRIBE_TITLE);
$xoopsTpl->assign('lang_desctribe', _MD_YOGURT_TRIBE_DESC);

//permissions
$xoopsTpl->assign('allow_notes', $controller->checkPrivilegeBySection('notes'));
$xoopsTpl->assign('allow_friends', $controller->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes', $controller->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures', $controller->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controller->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controller->checkPrivilegeBySection('audio'));

//Owner data
$xoopsTpl->assign('uid_owner', $controller->uidOwner);
$xoopsTpl->assign('owner_uname', $controller->nameOwner);
$xoopsTpl->assign('isOwner', $controller->isOwner);
$xoopsTpl->assign('isanonym', $controller->isAnonym);

//numbers
$xoopsTpl->assign('nb_tribes', $nbSections['nbTribes']);
$xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
$xoopsTpl->assign('nb_notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_TRIBES . ' :: ' . $tribe->getVar('tribe_title'));
$xoopsTpl->assign('section_name', _MD_YOGURT_TRIBES . '> ' . $tribe->getVar('tribe_title'));
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_tribes', _MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner));

//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);
$xoopsTpl->assign('lang_owner', _MD_YOGURT_TRIBEOWNER);

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

require_once XOOPS_ROOT_PATH . '/include/comment_view.php';

require dirname(dirname(__DIR__)) . '/footer.php';
