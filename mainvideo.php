<?php
// $Id: mainvideo.php,v 1.1 2007/09/11 10:14:49 marcellobrandao Exp $
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
include_once '../../header.php';
include_once '../../class/criteria.php';

include_once 'class/yogurt_seutubo.php';

if(!($GLOBALS['xoopsSecurity']->check())) {redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);}

$cod_img = intval($_POST['video_id']);

/**
* Creating the factory  loading the video changing its caption
*/
$video_factory = new Xoopsyogurt_seutuboHandler($xoopsDB);
$video = $video_factory->create(false);
$video->load($cod_img);
$video->setVar('main_video',1);

/**
* Verifying who's the owner to allow changes
*/
$uid = intval($xoopsUser->getVar('uid'));
if($uid == $video->getVar('uid_owner'))
{
	if($video_factory->unsetAllMainsbyID($uid))
	{
		if($video_factory->insert($video)) {redirect_header('seutubo.php', 2, _MD_YOGURT_SETMAINVIDEO);}
		else {redirect_header('seutubo.php', 2, _MD_YOGURT_NOCACHACA);}
	}
	else {echo "nao deu certo";}
}

include '../../footer.php';
?>