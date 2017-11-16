<?php
// $Id: friends.php,v 1.17 2008/04/19 16:39:08 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include_once __DIR__ . '/../../mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'yogurt_friends.tpl';
include_once __DIR__ . '/../../header.php';
include_once __DIR__ . '/class/yogurt_controler.php';

$controler = new YogurtControlerFriends($xoopsDB, $xoopsUser);

/**
 * Fecthing numbers of tribes friends videos pictures etc...
 */
$nbSections = $controler->getNumbersSections();

$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;

/**
 * Friends
 */
$criteria_friends = new criteria('friend1_uid', (int)$controler->uidOwner);
$nb_friends       = $controler->friendships_factory->getCount($criteria_friends);
$criteria_friends->setLimit($xoopsModuleConfig['friendsperpage']);
$criteria_friends->setStart($start);
$vetor = $controler->friendships_factory->getFriends('', $criteria_friends, 0);
if (0 == $nb_friends) {
    $xoopsTpl->assign('lang_nofriendsyet', _MD_YOGURT_NOFRIENDSYET);
}

/**
 * Let's get the user name of the owner of the album
 */
$owner      = new XoopsUser();
$identifier = $owner->getUnameFromId($controler->uidOwner);

/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (preg_match('/msie/', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/css/jquery.tabs-ie.css');
}
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/css/lightbox.css');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/prototype.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/scriptaculous.js?load=effects');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/lightbox.js');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/jquery.lightbox-0.3.css');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/jquery.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/jquery.lightbox-0.3.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/yogurt.js');

/**
 * Criando a barra de navegao caso tenha muitos amigos
 */
$barra_navegacao = new XoopsPageNav($nbSections['nbFriends'], $xoopsModuleConfig['friendsperpage'], $start, 'start', 'uid=' . (int)$controler->uidOwner);
$navegacao       = $barra_navegacao->renderImageNav(2);

//permissions
$xoopsTpl->assign('allow_Notes', $controler->checkPrivilegeBySection('Notes'));
$xoopsTpl->assign('allow_friends', $controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes', $controler->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures', $controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controler->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controler->checkPrivilegeBySection('audio'));

//Owner data
$xoopsTpl->assign('uid_owner', $controler->uidOwner);
$xoopsTpl->assign('owner_uname', $controler->nameOwner);
$xoopsTpl->assign('isOwner', $controler->isOwner);
$xoopsTpl->assign('isanonym', $controler->isAnonym);

//numbers
$xoopsTpl->assign('nb_tribes', $nbSections['nbTribes']);
$xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
$xoopsTpl->assign('nb_Notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYFRIENDS);
$xoopsTpl->assign('section_name', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_Notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_tribes', _MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);

//barra de navega��o
$xoopsTpl->assign('navegacao', $navegacao);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controler->nameOwner));

$xoopsTpl->assign('lang_friendstitle', sprintf(_MD_YOGURT_FRIENDSTITLE, $identifier));
//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);

$xoopsTpl->assign('friends', $vetor);

$xoopsTpl->assign('lang_delete', _MD_YOGURT_DELETE);
$xoopsTpl->assign('lang_evaluate', _MD_YOGURT_FRIENDSHIPCONFIGS);

include __DIR__ . '/../../footer.php';
