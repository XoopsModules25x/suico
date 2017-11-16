<?php
// $Id: seutubo.php,v 1.18 2008/04/19 16:39:10 marcellobrandao Exp $
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
include_once '../../mainfile.php';
$xoopsOption['template_main'] = 'yogurt_seutubo.html';
include_once '../../header.php';
include_once 'class/yogurt_controler.php';

$controler = new YogurtVideoControler($xoopsDB,$xoopsUser);

/**
* Fecthing numbers of tribes friends videos pictures etc...
*/
$nbSections = $controler->getNumbersSections();

$start = (isset($_GET['start']))? intval($_GET['start']) : 0;

/**
* Criteria for Videos
*/
$criteriaUidVideo  = new criteria('uid_owner',$controler->uidOwner);
$criteriaUidVideo->setStart($start);
$criteriaUidVideo->setLimit($xoopsModuleConfig['videosperpage']);

/**
* Get all videos of this user and assign them to template
*/

$videos = $controler->getVideos($criteriaUidVideo);
$videos_array = $controler->assignVideoContent($nbSections['nbVideos'],$videos);

if(is_array($videos_array)) {$xoopsTpl->assign('videos', $videos_array);}
else {$xoopsTpl->assign('lang_novideoyet',_MD_YOGURT_NOVIDEOSYET);}

$pageNav = $controler->VideosNavBar($nbSections['nbVideos'], $xoopsModuleConfig['videosperpage'],$start,2);

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
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.lightbox-0.3.css');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.lightbox-0.3.js');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/yogurt.js');

//permissions
$xoopsTpl->assign('allow_scraps',$controler->checkPrivilegeBySection('scraps'));
$xoopsTpl->assign('allow_friends',$controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes',$controler->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures',$controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos',$controler->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios',$controler->checkPrivilegeBySection('audio'));

//Owner data
$xoopsTpl->assign('uid_owner',$controler->uidOwner);
$xoopsTpl->assign('owner_uname',$controler->nameOwner);
$xoopsTpl->assign('isOwner',$controler->isOwner);
$xoopsTpl->assign('isanonym',$controler->isAnonym);

//numbers
$xoopsTpl->assign('nb_tribes',$nbSections['nbTribes']);
$xoopsTpl->assign('nb_photos',$nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos',$nbSections['nbVideos']);
$xoopsTpl->assign('nb_scraps',$nbSections['nbScraps']);
$xoopsTpl->assign('nb_friends',$nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio',$nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_YOGURT_MYVIDEOS);
$xoopsTpl->assign('section_name',_MD_YOGURT_VIDEOS);
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
$xoopsTpl->assign('xoops_pagetitle',  sprintf(_MD_YOGURT_PAGETITLE,$xoopsModule->getVar('name'), $controler->nameOwner));

//form actions
$xoopsTpl->assign('lang_delete',_MD_YOGURT_DELETE );
$xoopsTpl->assign('lang_editdesc',_MD_YOGURT_EDITDESC );
$xoopsTpl->assign('lang_makemain',_MD_YOGURT_MAKEMAIN);

//FORM SUBMIT
$xoopsTpl->assign('lang_addvideos',_MD_YOGURT_ADDFAVORITEVIDEOS);
$xoopsTpl->assign('lang_youtubecodeLabel',_MD_YOGURT_YOUTUBECODE);
$xoopsTpl->assign('lang_captionLabel',_MD_YOGURT_CAPTION);
$xoopsTpl->assign('lang_submitValue',_MD_YOGURT_ADDVIDEO);


$xoopsTpl->assign('width',$xoopsModuleConfig['width_tube']);
$xoopsTpl->assign('height',$xoopsModuleConfig['height_tube']);
$xoopsTpl->assign('lang_videohelp',_MD_YOGURT_ADDVIDEOSHELP);

//Videos NAvBAr
$xoopsTpl->assign('pageNav',$pageNav);

include '../../footer.php';
?>