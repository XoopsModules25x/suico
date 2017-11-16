<?php
// $Id: submit_scrap.php,v 1.3 2008/04/07 20:25:22 marcellobrandao Exp $
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
include_once("class/yogurt_scraps.php");

/**
 * Factories of tribes  
 */
$scraps_factory      = new Xoopsyogurt_scrapsHandler($xoopsDB);

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
$scrapbook_uid = $_POST['uid'];
$scrap_text    = $myts->displayTarea($_POST['text'],0,1,1,1,1);
$mainform	   = (!empty($_POST['mainform'])) ? 1 : 0;
$scrap = $scraps_factory->create();
$scrap->setVar('scrap_text',$scrap_text);
$scrap->setVar('scrap_from',$xoopsUser->getVar('uid'));
$scrap->setVar('scrap_to',$scrapbook_uid);
$scraps_factory->insert($scrap);
$extra_tags['X_OWNER_NAME'] =  $xoopsUser->getUnameFromId($scrapbook_uid);
$extra_tags['X_OWNER_UID'] = $scrapbook_uid;
$notification_handler =& xoops_gethandler('notification');
$notification_handler->triggerEvent ("scrap", $xoopsUser->getVar('uid'), "new_scrap",$extra_tags);
if ($mainform==1){
	redirect_header("scrapbook.php?uid=".$scrapbook_uid,1,_MD_YOGURT_SCRAP_SENT);
}else{
	redirect_header("scrapbook.php?uid=".$xoopsUser->getVar('uid'),1,_MD_YOGURT_SCRAP_SENT);
}

       

/**
 * Close page  
 */
include("../../footer.php");
?>