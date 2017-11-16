<?php
// $Id: avatar.php,v 1.5 2008/04/07 23:56:46 marcellobrandao Exp $
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

include_once 'class/yogurt_images.php';

if(!($GLOBALS['xoopsSecurity']->check())) {redirect_header('index.php', 3, _MD_YOGURT_TOKENEXPIRED);}

/**
* Creating the factory  loading the picture changing its caption
*/
$picture_factory = new Xoopsyogurt_imagesHandler($xoopsDB);
$picture = $picture_factory->create(false);
$picture->load($_POST['cod_img']);

$uid = intval($xoopsUser->getVar('uid'));

$image = XOOPS_ROOT_PATH.'/uploads/'.'thumb_'.$picture->getVar('url');
$avatar = 'av'.$uid.'_'.time().'.jpg';
$imageavatar = XOOPS_ROOT_PATH.'/uploads/'.$avatar;

if(!copy($image, $imageavatar)) {echo 'failed to copy $file...\n';}
$xoopsUser->setVar('user_avatar',$avatar);

$userHandler = new XoopsUserHandler($xoopsDB);

/**
* Verifying who's the owner to allow changes
*/
if($uid == $picture->getVar('uid_owner'))
{
	if($userHandler->insert($xoopsUser)) {redirect_header('album.php', 2, _MD_YOGURT_AVATAR_EDITED);}
	else {redirect_header('album.php', 2, _MD_YOGURT_NOCACHACA);}
}

include '../../footer.php';
?>