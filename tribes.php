<?php
// $Id: tribes.php,v 1.17 2008/04/19 16:39:10 marcellobrandao Exp $
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
include_once'../../mainfile.php';
$xoopsOption['template_main'] = 'yogurt_tribes.html';
include_once'../../header.php';
include_once'class/yogurt_controler.php';

$controler = new YogurtControlerTribes($xoopsDB,$xoopsUser);

/**
* Fecthing numbers of tribes friends videos pictures etc...
*/
$nbSections = $controler->getNumbersSections();

$start_all = (isset($_GET['start_all']))? intval($_GET['start_all']) : 0;
$start_my = (isset($_GET['start_my']))? intval($_GET['start_my']) : 0;

/**
* All Tribes 
*/
$criteria_tribes = new criteria('tribe_id',0,'>');
$nb_tribes = $controler->tribes_factory->getCount($criteria_tribes);
$criteria_tribes->setLimit($xoopsModuleConfig['tribesperpage']);
$criteria_tribes->setStart($start_all);
$tribes = $controler->tribes_factory->getTribes($criteria_tribes);

/**
* My Tribes 
*/
$mytribes = '';
$criteria_mytribes = new criteria('rel_user_uid', $controler->uidOwner);
$nb_mytribes = $controler->reltribeusers_factory->getCount($criteria_mytribes);
$criteria_mytribes->setLimit($xoopsModuleConfig['tribesperpage']);
$criteria_mytribes->setStart($start_my);
$mytribes = $controler->reltribeusers_factory->getTribes('', $criteria_mytribes,0);

/**
* Adding to the module js and css of the lightbox and new ones
*/
$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if(ereg('msie', strtolower($_SERVER['HTTP_USER_AGENT']))) {$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/css/jquery.tabs-ie.css');}
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/css/lightbox.css');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/prototype.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/scriptaculous.js?load=effects'); 
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/lightbox.js');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.lightbox-0.3.css');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.lightbox-0.3.js');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/yogurt.js');

/**
* Criando a barra de navegao caso tenha muitos amigos
*/
$barra_navegacao = new XoopsPageNav($nb_tribes,$xoopsModuleConfig['tribesperpage'],$start_all,'start_all','uid='.intval($controler->uidOwner).'&amp;start_my='.$start_my);
$barrinha = $barra_navegacao->renderImageNav(2);//alltribes

$barra_navegacao_my = new XoopsPageNav($nb_mytribes,$xoopsModuleConfig['tribesperpage'],$start_my,'start_my','uid='.intval($controler->uidOwner).'&amp;start_all='.$start_all);
$barrinha_my = $barra_navegacao_my->renderImageNav(2);

$maxfilebytes = $xoopsModuleConfig['maxfilesize'];

//permissions
$xoopsTpl->assign('allow_scraps',$controler->checkPrivilegeBySection('scraps'));
$xoopsTpl->assign('allow_friends',$controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes',$controler->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures',$controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos',$controler->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios',$controler->checkPrivilegeBySection('audio'));

//form
$xoopsTpl->assign('lang_youcanupload',sprintf(_MD_YOGURT_YOUCANUPLOAD,$maxfilebytes/1024));
$xoopsTpl->assign('lang_tribeimage',_MD_YOGURT_TRIBE_IMAGE);
$xoopsTpl->assign('maxfilesize',$maxfilebytes);
$xoopsTpl->assign('lang_title',_MD_YOGURT_TRIBE_TITLE);
$xoopsTpl->assign('lang_description',_MD_YOGURT_TRIBE_DESC);
$xoopsTpl->assign('lang_savetribe',_MD_YOGURT_UPLOADTRIBE);

//Owner data
$xoopsTpl->assign('uid_owner',$controler->uidOwner);
$xoopsTpl->assign('owner_uname',$controler->nameOwner);
$xoopsTpl->assign('isOwner',$controler->isOwner);
$xoopsTpl->assign('isanonym',$controler->isAnonym);

//numbers
//$xoopsTpl->assign('nb_tribes',$nbSections['nbTribes']);look at hte end for this nb
$xoopsTpl->assign('nb_photos',$nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos',$nbSections['nbVideos']);
$xoopsTpl->assign('nb_scraps',$nbSections['nbScraps']);
$xoopsTpl->assign('nb_friends',$nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio',$nbSections['nbAudio']);
$xoopsTpl->assign('nb_tribes',$nbSections['nbTribes']);

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_YOGURT_MYTRIBES);
$xoopsTpl->assign('section_name',_MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_home',_MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos',_MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends',_MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio',_MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos',_MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_scrapbook',_MD_YOGURT_SCRAPBOOK);
$xoopsTpl->assign('lang_profile',_MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_tribes',_MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_configs',_MD_YOGURT_CONFIGSTITLE);

//xoopsToken
$xoopsTpl->assign('token',$GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE,$xoopsModule->getVar('name'), $controler->nameOwner));

//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);
$xoopsTpl->assign('tribes',$tribes);
$xoopsTpl->assign('mytribes',$mytribes);
$xoopsTpl->assign('lang_mytribestitle',_MD_YOGURT_MYTRIBES);
$xoopsTpl->assign('lang_tribestitle',_MD_YOGURT_ALLTRIBES.' ('.$nb_tribes.')');
$xoopsTpl->assign('lang_notribesyet',_MD_YOGURT_NOTRIBESYET);

//page nav
$xoopsTpl->assign('barra_navegacao',$barrinha);//alltribes
$xoopsTpl->assign('barra_navegacao_my',$barrinha_my);
$xoopsTpl->assign('nb_tribes',$nb_mytribes);// this is the one wich shows in the upper bar actually is about the mytribes
$xoopsTpl->assign('nb_tribes_all',$nb_tribes);//this is total number of tribes

$xoopsTpl->assign('lang_createtribe',_MD_YOGURTCREATEYOURTRIBE);
$xoopsTpl->assign('lang_owner',_MD_YOGURT_TRIBEOWNER);
$xoopsTpl->assign('lang_abandontribe',_MD_YOGURT_TRIBE_ABANDON);
$xoopsTpl->assign('lang_jointribe',_MD_YOGURT_TRIBE_JOIN);
$xoopsTpl->assign('lang_searchtribe',_MD_YOGURT_TRIBE_SEARCH);
$xoopsTpl->assign('lang_tribekeyword',_MD_YOGURT_TRIBE_SEARCHKEYWORD);

include '../../footer.php';
?>