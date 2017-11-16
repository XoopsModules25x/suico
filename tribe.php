<?php
// $Id: tribe.php,v 1.7 2008/04/19 16:39:10 marcellobrandao Exp $
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
$xoopsOption['template_main'] = 'yogurt_tribe.html';
include_once '../../header.php';
include_once 'class/yogurt_controler.php';

$controler = new YogurtControlerTribes($xoopsDB,$xoopsUser);

/**
* Fecthing numbers of tribes friends videos pictures etc...
*/
$nbSections = $controler->getNumbersSections();

$tribe_id = intval($_GET['tribe_id']);
$criteria= new criteria('tribe_id',$tribe_id);
$tribes = $controler->tribes_factory->getObjects($criteria);
$tribe = $tribes[0];

/**
* Render a form with the info of the user  
*/
$tribe_members = $controler->reltribeusers_factory->getUsersFromTribe($tribe_id,0,50);
foreach($tribe_members as $tribe_member) {$uids[]=intval($tribe_member['uid']);}

$uid = intval($xoopsUser->getVar('uid'));
if($xoopsUser)
{
	if(in_array($uid,$uids)) $xoopsTpl->assign('memberOfTribe', 1);
	$xoopsTpl->assign('useruid', $uid);
}
$xoopsTpl->assign('tribe_members', $tribe_members );
$maxfilebytes = $xoopsModuleConfig['maxfilesize'];
$xoopsTpl->assign('lang_savetribe',_MD_YOGURT_UPLOADTRIBE);
$xoopsTpl->assign('maxfilesize',$maxfilebytes);
$xoopsTpl->assign('tribe_title', $tribe->getVar('tribe_title'));
$xoopsTpl->assign('tribe_desc', $tribe->getVar('tribe_desc'));
$xoopsTpl->assign('tribe_img', $tribe->getVar('tribe_img'));
$xoopsTpl->assign('tribe_id', $tribe->getVar('tribe_id'));
$xoopsTpl->assign('tribe_owneruid', $tribe->getVar('owner_uid'));

$xoopsTpl->assign('lang_membersoftribe', _MD_YOGURT_MEMBERSDOFTRIBE);
$xoopsTpl->assign('lang_edittribe', _MD_YOGURT_EDIT_TRIBE);
$xoopsTpl->assign('lang_tribeimage', _MD_YOGURT_TRIBE_IMAGE);
$xoopsTpl->assign('lang_keepimage', _MD_YOGURT_MAINTAINOLDIMAGE);
$xoopsTpl->assign('lang_youcanupload',sprintf(_MD_YOGURT_YOUCANUPLOAD,$maxfilebytes/1024));
$xoopsTpl->assign('lang_titletribe', _MD_YOGURT_TRIBE_TITLE);
$xoopsTpl->assign('lang_desctribe', _MD_YOGURT_TRIBE_DESC);

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
$xoopsTpl->assign('lang_mysection',_MD_YOGURT_TRIBES.' :: '.$tribe->getVar('tribe_title'));
$xoopsTpl->assign('section_name',_MD_YOGURT_TRIBES.' > '.$tribe->getVar('tribe_title'));
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
$xoopsTpl->assign('lang_owner',_MD_YOGURT_TRIBEOWNER);

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

include_once XOOPS_ROOT_PATH.'/include/comment_view.php';

include '../../footer.php';
?>

