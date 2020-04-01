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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_tribes.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\ControllerTribes($xoopsDB, $xoopsUser);

/**
 * Fecthing numbers of tribes friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

$start_all = \Xmf\Request::getInt('start_all', 0, 'GET');
$start_my  = \Xmf\Request::getInt('start_my', 0, 'GET');

/**
 * All Tribes
 */
$criteria_tribes = new \Criteria('tribe_id', 0, '>');
$nb_tribes       = $controller->tribesFactory->getCount($criteria_tribes);
$criteria_tribes->setLimit($xoopsModuleConfig['tribesperpage']);
$criteria_tribes->setStart($start_all);
$tribes = $controller->tribesFactory->getTribes($criteria_tribes);

/**
 * My Tribes
 */
$mytribes          = '';
$criteria_mytribes = new \Criteria('rel_user_uid', $controller->uidOwner);
$nb_mytribes       = $controller->reltribeusersFactory->getCount($criteria_mytribes);
$criteria_mytribes->setLimit($xoopsModuleConfig['tribesperpage']);
$criteria_mytribes->setStart($start_my);
$mytribes = $controller->reltribeusersFactory->getTribes('', $criteria_mytribes, 0);

/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (false !== strpos(mb_strtolower($_SERVER['HTTP_USER_AGENT']), "msie")) {
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
$barra_navegacao = new \XoopsPageNav($nb_tribes, $xoopsModuleConfig['tribesperpage'], $start_all, 'start_all', 'uid=' . (int)$controller->uidOwner . '&amp;start_my=' . $start_my);
$barrinha        = $barra_navegacao->renderImageNav(2); //alltribes

$barra_navegacao_my = new \XoopsPageNav($nb_mytribes, $xoopsModuleConfig['tribesperpage'], $start_my, 'start_my', 'uid=' . (int)$controller->uidOwner . '&amp;start_all=' . $start_all);
$barrinha_my        = $barra_navegacao_my->renderImageNav(2);

$maxfilebytes = $xoopsModuleConfig['maxfilesize'];

//permissions
$xoopsTpl->assign('allow_notes', $controller->checkPrivilegeBySection('notes'));
$xoopsTpl->assign('allow_friends', $controller->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes', $controller->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures', $controller->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controller->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controller->checkPrivilegeBySection('audio'));

//form
$xoopsTpl->assign('lang_youcanupload', sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxfilebytes / 1024));
$xoopsTpl->assign('lang_tribeimage', _MD_YOGURT_TRIBE_IMAGE);
$xoopsTpl->assign('maxfilesize', $maxfilebytes);
$xoopsTpl->assign('lang_title', _MD_YOGURT_TRIBE_TITLE);
$xoopsTpl->assign('lang_description', _MD_YOGURT_TRIBE_DESC);
$xoopsTpl->assign('lang_savetribe', _MD_YOGURT_UPLOADTRIBE);

//Owner data
$xoopsTpl->assign('uid_owner', $controller->uidOwner);
$xoopsTpl->assign('owner_uname', $controller->nameOwner);
$xoopsTpl->assign('isOwner', $controller->isOwner);
$xoopsTpl->assign('isanonym', $controller->isAnonym);

//numbers
//$xoopsTpl->assign('nb_tribes',$nbSections['nbTribes']);look at hte end for this nb
$xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
$xoopsTpl->assign('nb_notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);
$xoopsTpl->assign('nb_tribes', $nbSections['nbTribes']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYTRIBES);
$xoopsTpl->assign('section_name', _MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_Notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_tribes', _MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner));

//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);
$xoopsTpl->assign('tribes', $tribes);
$xoopsTpl->assign('mytribes', $mytribes);
$xoopsTpl->assign('lang_mytribestitle', _MD_YOGURT_MYTRIBES);
$xoopsTpl->assign('lang_tribestitle', _MD_YOGURT_ALLTRIBES . ' (' . $nb_tribes . ')');
$xoopsTpl->assign('lang_notribesyet', _MD_YOGURT_NOTRIBESYET);

//page nav
$xoopsTpl->assign('barra_navegacao', $barrinha); //alltribes
$xoopsTpl->assign('barra_navegacao_my', $barrinha_my);
$xoopsTpl->assign('nb_tribes', $nb_mytribes); // this is the one wich shows in the upper bar actually is about the mytribes
$xoopsTpl->assign('nb_tribes_all', $nb_tribes); //this is total number of tribes

$xoopsTpl->assign('lang_createtribe', _MD_YOGURTCREATEYOURTRIBE);
$xoopsTpl->assign('lang_owner', _MD_YOGURT_TRIBEOWNER);
$xoopsTpl->assign('lang_abandontribe', _MD_YOGURT_TRIBE_ABANDON);
$xoopsTpl->assign('lang_jointribe', _MD_YOGURT_TRIBE_JOIN);
$xoopsTpl->assign('lang_searchtribe', _MD_YOGURT_TRIBE_SEARCH);
$xoopsTpl->assign('lang_tribekeyword', _MD_YOGURT_TRIBE_SEARCHKEYWORD);

require dirname(dirname(__DIR__)) . '/footer.php';
