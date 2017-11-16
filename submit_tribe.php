<?php
// $Id: submit_tribe.php,v 1.4 2008/01/23 10:26:21 marcellobrandao Exp $
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



/**
 * Xoops header ...
 */
include_once("../../mainfile.php");
include_once("../../header.php");

/**
 * Modules class includes  
 */
include_once("class/yogurt_friendpetition.php");
include_once("class/yogurt_reltribeuser.php");
include_once("class/yogurt_tribes.php");


/**
 * Factories of tribes  
 */
$reltribeuser_factory      = new Xoopsyogurt_reltribeuserHandler($xoopsDB);
$tribes_factory = new Xoopsyogurt_tribesHandler($xoopsDB);


$marker = (isset($_POST['marker']))?$_POST['marker']:0;

if ($marker==1) {
  /**
   * Verify Token
   */
  if (!($GLOBALS['xoopsSecurity']->check())){
	redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);
  }
  /**
   * 
   */
  $myts =& MyTextSanitizer::getInstance();
  $tribe_title = $myts->displayTarea($_POST['tribe_title'],0,1,1,1,1);
  $tribe_desc  = $myts->displayTarea($_POST['tribe_desc'],0,1,1,1,1);
  $tribe_img   = (!empty($_POST['tribe_img'])) ? $_POST['tribe_img'] : "";
  $path_upload    = XOOPS_ROOT_PATH."/uploads";
  $pictwidth      = $xoopsModuleConfig['resized_width'];
  $pictheight     = $xoopsModuleConfig['resized_height'];
  $thumbwidth     = $xoopsModuleConfig['thumb_width'];
  $thumbheight    = $xoopsModuleConfig['thumb_height'];
  $maxfilebytes   = $xoopsModuleConfig['maxfilesize'];
  $maxfileheight  = $xoopsModuleConfig['max_original_height'];
  $maxfilewidth   = $xoopsModuleConfig['max_original_width'];
  if ($tribes_factory->receiveTribe($tribe_title,$tribe_desc,'',$path_upload,$maxfilebytes,$maxfilewidth,$maxfileheight))
  {
    $reltribeuser = $reltribeuser_factory->create();
    $reltribeuser->setVar('rel_tribe_id',$xoopsDB->getInsertId());
    $reltribeuser->setVar('rel_user_uid',$xoopsUser->getVar('uid'));
    $reltribeuser_factory->insert($reltribeuser);
    redirect_header("tribes.php",500,_MD_YOGURT_TRIBE_CREATED);
  }else{
    $tribes_factory->renderFormSubmit(120000,$xoopsTpl);
  }
}else{
  $tribes_factory->renderFormSubmit(120000,$xoopsTpl);
}

       

/**
 * Close page  
 */
include("../../footer.php");
?>