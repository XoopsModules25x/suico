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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_tribes_results.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\ControllerTribes($xoopsDB, $xoopsUser);

/**
 * Fecthing numbers of tribes friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

$start_all = isset($_GET['start_all']) ? (int)$_GET['start_all'] : 0;
$start_my  = isset($_GET['start_my']) ? (int)$_GET['start_my'] : 0;

$tribe_keyword = trim(htmlspecialchars($_GET['tribe_keyword'], ENT_QUOTES | ENT_HTML5));
/**
 * All Tribes
 */
$criteria_title  = new \Criteria('tribe_title', '%' . $tribe_keyword . '%', 'LIKE');
$criteria_desc   = new \Criteria('tribe_desc', '%' . $tribe_keyword . '%', 'LIKE');
$criteria_tribes = new \CriteriaCompo($criteria_title);
$criteria_tribes->add($criteria_desc, 'OR');
$nb_tribes = $controller->tribesFactory->getCount($criteria_tribes);
$criteria_tribes->setLimit($xoopsModuleConfig['tribesperpage']);
$criteria_tribes->setStart($start_all);
$tribes_objects = $controller->tribesFactory->getObjects($criteria_tribes);
$i              = 0;
foreach ($tribes_objects as $tribe_object) {
    $tribes[$i]['id']    = $tribe_object->getVar('tribe_id');
    $tribes[$i]['title'] = $tribe_object->getVar('tribe_title');
    $tribes[$i]['img']   = $tribe_object->getVar('tribe_img');
    $tribes[$i]['desc']  = $tribe_object->getVar('tribe_desc');
    $tribes[$i]['uid']   = $tribe_object->getVar('owner_uid');
    $i++;
}

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (false !== strpos(mb_strtolower($_SERVER['HTTP_USER_AGENT']), "msie")) {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs-ie.css');
}
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.tabs.pack.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/yogurt.js');

/**
 * Criando a barra de navegao caso tenha muitos amigos
 */
$barra_navegacao = new \XoopsPageNav($nb_tribes, $xoopsModuleConfig['tribesperpage'], $start_all, 'start_all', 'tribe_keyword=' . $tribe_keyword . '&amp;start_my=' . $start_my);
$barrinha        = $barra_navegacao->renderImageNav(2);

//permissions
$xoopsTpl->assign('allow_notes', $controller->checkPrivilegeBySection('Notes'));
$xoopsTpl->assign('allow_friends', $controller->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes', $controller->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures', $controller->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controller->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controller->checkPrivilegeBySection('audio'));
$xoopsTpl->assign('allow_profile_contact', $controller->checkPrivilege('profile_contact') ? 1 : 0);
$xoopsTpl->assign('allow_profile_general', $controller->checkPrivilege('profile_general') ? 1 : 0);
$xoopsTpl->assign('allow_profile_stats', $controller->checkPrivilege('profile_stats') ? 1 : 0);

//form
//$xoopsTpl->assign('lang_youcanupload',sprintf(_MD_YOGURT_YOUCANUPLOAD,$maxfilebytes/1024));
$xoopsTpl->assign('lang_tribeimage', _MD_YOGURT_TRIBE_IMAGE);
//$xoopsTpl->assign('maxfilesize',$maxfilebytes);
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
$xoopsTpl->assign('nb_Notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_tribes', $nbSections['nbTribes']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYTRIBES);
$xoopsTpl->assign('section_name', _MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_Notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_tribes', _MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner));

//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);
//$xoopsTpl->assign('tribes',$tribes);
//$xoopsTpl->assign('mytribes',$mytribes);
$xoopsTpl->assign('lang_mytribestitle', _MD_YOGURT_MYTRIBES);
$xoopsTpl->assign('lang_tribestitle', _MD_YOGURT_ALLTRIBES . ' (' . $nb_tribes . ')');
$xoopsTpl->assign('lang_notribesyet', _MD_YOGURT_NOTRIBESYET);

//page nav
$xoopsTpl->assign('barra_navegacao', $barrinha);
//$xoopsTpl->assign('barra_navegacao_my',$barrinha_my);
//$xoopsTpl->assign('nb_tribes',$nb_mytribes);// this is the one wich shows in the upper bar actually is about the mytribes
$xoopsTpl->assign('nb_tribes_all', $nb_tribes); //this is total number of tribes

$xoopsTpl->assign('lang_createtribe', _MD_YOGURTCREATEYOURTRIBE);
$xoopsTpl->assign('lang_owner', _MD_YOGURT_TRIBEOWNER);
$xoopsTpl->assign('lang_abandontribe', _MD_YOGURT_TRIBE_ABANDON);
$xoopsTpl->assign('lang_jointribe', _MD_YOGURT_TRIBE_JOIN);
$xoopsTpl->assign('lang_searchtribe', _MD_YOGURT_TRIBE_SEARCH);
$xoopsTpl->assign('lang_tribekeyword', _MD_YOGURT_TRIBE_SEARCHKEYWORD);

require  dirname(dirname(__DIR__)) . '/footer.php';
