<?php
// $Id: submit_configs.php,v 1.3 2008/04/19 16:39:10 marcellobrandao Exp $
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
include_once("class/yogurt_configs.php");



/**
 * Factories of tribes  
 */
$configs_factory      = new Xoopsyogurt_configsHandler($xoopsDB);

/**
 * Verify Token
 */
if (!($GLOBALS['xoopsSecurity']->check())){
	redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);
}
/**
 * 
 */
//		$this->initVar("config_id",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("config_uid",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("pictures",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("videos",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("tribes",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("scraps",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("friends",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("profile_contact",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("profile_general",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("profile_stats",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("suspension",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("backup_password",XOBJ_DTYPE_TXTBOX, null, false);
//		$this->initVar("backup_email",XOBJ_DTYPE_TXTBOX, null, false);
//		$this->initVar("end_suspension",XOBJ_DTYPE_TXTBOX, null, false);


//$pic 	= $_POST['pic'];
//$vid	= $_POST['vid'];
//$aud    = $_POST['aud'];
//$tri	= $_POST['tribes'];
//$fri	= $_POST['friends'];
//$scr	= $_POST['scraps'];
//$pcon   = $_POST['profileContact'];
//$pgen   = $_POST['gen'];
//$psta   = $_POST['stat'];



$criteria = new Criteria('config_uid',$xoopsUser->getVar("uid"));
if ($configs_factory->getCount($criteria)>0){
	$configs = $configs_factory->getObjects($criteria);
	$config = $configs[0];
	$config->unsetNew();
}else{
	$config = $configs_factory->create();
}

$config->setVar('config_uid',$xoopsUser->getVar("uid"));
if (isset($_POST['pic']))  $config->setVar('pictures',$_POST['pic']);
if (isset($_POST['aud'])) $config->setVar('audio',$_POST['aud']);
if (isset($_POST['vid'])) $config->setVar('videos',$_POST['vid']);
if (isset($_POST['tribes'])) $config->setVar('tribes',$_POST['tribes']);
if (isset($_POST['scraps'])) $config->setVar('scraps',$_POST['scraps']);
if (isset($_POST['friends'])) $config->setVar('friends',$_POST['friends']);
if (isset($_POST['profileContact'])) $config->setVar('profile_contact',$_POST['profileContact']);
if (isset($_POST['gen'])) $config->setVar('profile_general',$_POST['gen']);
if (isset($_POST['stat'])) $config->setVar('profile_stats',$_POST['stat']);
if (!$configs_factory->insert($config)) {

}
redirect_header("configs.php?uid=".$xoopsUser->getVar("uid"),3,_MD_YOGURT_CONFIGSSAVE);
       
/**
 * Close page  
 */
include("../../footer.php");
?>