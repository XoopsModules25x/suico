<?php
// $Id: video_submited.php,v 1.4 2007/09/23 18:50:36 marcellobrandao Exp $
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
$xoopsOption['template_main'] = 'yogurt_index.html';
include_once '../../header.php';

include_once 'class/yogurt_seutubo.php';

/**
* Factory of pictures created  
*/
$album_factory = new Xoopsyogurt_seutuboHandler($xoopsDB);

$url = $_POST['codigo'];

if(!($GLOBALS['xoopsSecurity']->check())) {redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);}

/**
* Try to upload picture resize it insert in database and then redirect to index
*/
$newvideo = $album_factory->create(true);
$newvideo->setVar('uid_owner', intval($xoopsUser->getVar('uid')));
$newvideo->setVar('video_desc', trim(htmlspecialchars($_POST['caption'])));

if(strlen($url)==11) {$code=$url;}
else
{
	$position_of_code = strpos($url,'v=');
	$code = substr($url,$position_of_code+2,11);
}

$newvideo->setVar('youtube_code',$code);
if($album_factory->insert($newvideo))
{
	$extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
	$extra_tags['X_OWNER_UID'] = intval($xoopsUser->getVar('uid'));
	$notification_handler =& xoops_gethandler('notification');
	$notification_handler->triggerEvent('video', intval($xoopsUser->getVar('uid')), 'new_video',$extra_tags);
	redirect_header(XOOPS_URL.'/modules/yogurt/seutubo.php?uid='.intval($xoopsUser->getVar('uid')),2,_MD_YOGURT_VIDEOSAVED);
}
else {redirect_header(XOOPS_URL.'/modules/yogurt/seutubo.php?uid='.intval($xoopsUser->getVar('uid')),2,_MD_YOGURT_NOCACHACA);}

include '../../footer.php';
?>