<?php
// $Id: submitaudio.php,v 1.1 2008/04/19 16:39:11 marcellobrandao Exp $
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
$xoopsOption['template_main'] = 'yogurt_index.html';
include_once("../../header.php");

/**
 * Modules class includes  
 */
include_once("class/yogurt_audio.php");

/**
 * Factory of pictures created  
 */
$audio_factory      = new Xoopsyogurt_audioHandler($xoopsDB);

$myts =& MyTextSanitizer::getInstance();	
/**
 * Getting the title 
 */
$title = $myts->displayTarea($_POST['title'],0,1,1,1,1);
$author = $myts->displayTarea($_POST['author'],0,1,1,1,1); 

/**
 * Getting parameters defined in admin side  
 */
$path_upload    = XOOPS_ROOT_PATH."/uploads/yogurt/mp3/";
$maxfilebytes   = $xoopsModuleConfig['maxfilesize'];

/**
 * If we are receiving a file  
 */
if ($_POST['xoops_upload_file'][0]=='sel_audio'){
       
              /**
              * Verify Token
              */
              if (!($GLOBALS['xoopsSecurity']->check())){
                     redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);
              }
              
              /**
              * Try to upload picture resize it insert in database and then redirect to index
              */
              if ($audio_factory->receiveAudio($title,$path_upload, $author, $maxfilebytes)){
                     //$extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
//                     $extra_tags['X_OWNER_UID'] = $xoopsUser->getVar('uid');
//                     $notification_handler =& xoops_gethandler('notification');
//                     $notification_handler->triggerEvent ("picture", $xoopsUser->getVar('uid'), "new_picture",$extra_tags);
                     //header("Location: ".XOOPS_URL."/modules/yogurt/index.php?uid=".$xoopsUser->getVar('uid'));
                     redirect_header(XOOPS_URL."/modules/yogurt/audio.php?uid=".$xoopsUser->getVar('uid'),50,_MD_YOGURT_UPLOADEDAUDIO);
              } else {
                     redirect_header(XOOPS_URL."/modules/yogurt/audio.php?uid=".$xoopsUser->getVar('uid'),50,_MD_YOGURT_NOCACHACA);
              }
}

/**
 * Close page  
 */
include("../../footer.php");
?>