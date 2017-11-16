<?php
// $Id: delpicture.php,v 1.9 2008/04/07 21:43:49 marcellobrandao Exp $
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

if(!($GLOBALS['xoopsSecurity']->check())) {
  redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);
}

$cod_img = $_POST['cod_img'];

if(!isset($_POST['confirm']) || $_POST['confirm']!=1)
{
	xoops_confirm(array('cod_img'=> $cod_img,'confirm'=>1), 'delpicture.php', _MD_YOGURT_ASKCONFIRMDELETION, _MD_YOGURT_CONFIRMDELETION);
}
else
{
	/**
	* Creating the factory  and the criteria to delete the picture
	* The user must be the owner
	*/
	$album_factory = new Xoopsyogurt_imagesHandler($xoopsDB);
	$criteria_img = new Criteria('cod_img',$cod_img);
	$uid = intval($xoopsUser->getVar('uid'));
	$criteria_uid = new Criteria('uid_owner',$uid);
	$criteria = new CriteriaCompo($criteria_img);
	$criteria->add($criteria_uid);
	
	$objects_array = $album_factory->getObjects($criteria);
	$image_name = $objects_array[0]->getVar('url');  
	$avatar_image = $xoopsUser->getVar('user_avatar');
	
	/**
	* Try to delete  
	*/
	if($album_factory->deleteAll($criteria))
	{
		if($xoopsModuleConfig['physical_delete']==1)
		{
			//unlink($xoopsModuleConfig['path_upload']."\/".$image_name);
			unlink(XOOPS_ROOT_PATH.'/uploads'.'/'.$image_name);
			unlink(XOOPS_ROOT_PATH.'/uploads'.'/resized_'.$image_name);
			/**
			* Delete the thumb (avatar now has another name)
			*/ 
			//if ($avatar_image!=$image_name){
			unlink(XOOPS_ROOT_PATH.'/uploads'.'/thumb_'.$image_name);
			//}
		}
		redirect_header('album.php', 2, _MD_YOGURT_DELETED);
	}
	else {redirect_header('album.php', 2, _MD_YOGURT_NOCACHACA);}
}

include '../../footer.php';
?>
