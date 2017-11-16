<?php
// $Id: editdesc.php,v 1.6 2008/01/23 10:26:21 marcellobrandao Exp $
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

if(!($GLOBALS['xoopsSecurity']->check())) {redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);}

$cod_img = $_POST['cod_img'];
$marker = (!empty($_POST['marker'])) ? intval($_POST['marker']):0;
$uid = intval($xoopsUser->getVar('uid'));

if($marker==1)
{
	/**
	* Creating the factory loading the picture changing its caption
	*/
	$picture_factory = new Xoopsyogurt_imagesHandler($xoopsDB);
	$picture = $picture_factory->create(false);
	$picture->load($cod_img);
	$picture->setVar('title', trim(htmlspecialchars($_POST['caption'])));
	
	/**
	* Verifying who's the owner to allow changes
	*/
	if($uid == $picture->getVar('uid_owner'))
	{
		if($picture_factory->insert($picture)) {redirect_header('album.php', 2, _MD_YOGURT_DESC_EDITED);}
		else {redirect_header('album.php', 2, _MD_YOGURT_NOCACHACA);}
	}
}
/**
* Creating the factory  and the criteria to edit the desc of the picture
* The user must be the owner
*/ 
$album_factory = new Xoopsyogurt_imagesHandler($xoopsDB);
$criteria_img = new Criteria ('cod_img', $cod_img);
$criteria_uid = new Criteria ('uid_owner',$uid);
$criteria = new CriteriaCompo ($criteria_img);
$criteria->add($criteria_uid);

/**
* Lets fetch the info of the pictures to be able to render the form
* The user must be the owner
*/
if($array_pict = $album_factory->getObjects($criteria))
{
	$caption = $array_pict[0]->getVar('title');
	$url = $array_pict[0]->getVar('url');
}
//$url = $xoopsModuleConfig['link_path_upload']."/thumb_".$url;
$url = XOOPS_URL.'/uploads/thumb_'.$url;
$album_factory->renderFormEdit($caption,$cod_img,$url);

include '../../footer.php';
?>
