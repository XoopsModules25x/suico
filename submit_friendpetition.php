<?php
// $Id: submit_friendpetition.php,v 1.4 2008/04/11 21:56:35 marcellobrandao Exp $
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
include_once("class/yogurt_friendpetition.php");

/**
 * Factory of petitions created  
 */
$friendpetition_factory      = new Xoopsyogurt_friendpetitionHandler($xoopsDB);

/**
 * Getting the uid of the user which user want to ask to be friend
 */
$petitioned_uid = $_POST['petitioned_uid'];
                     
       
              /**
              * Verify Token
              */
              if (!($GLOBALS['xoopsSecurity']->check())){
                     redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);
              }

              
              //Verify if the user has already asked for friendship or if the user he s asking to be a friend has already asked him
$criteria= new criteriaCompo (new criteria('petioned_uid',$petitioned_uid));
$criteria->add(new criteria('petitioner_uid',$xoopsUser->getVar('uid')));
if ($friendpetition_factory->getCount($criteria)>0){
redirect_header(XOOPS_URL."/modules/yogurt/index.php?uid=".$_POST['petitioned_uid'],3,_MD_YOGURT_ALREADY_PETITIONED);
} else {
$criteria2= new criteriaCompo (new criteria('petitioner_uid',$petitioned_uid));
$criteria2->add(new criteria('petioned_uid',$xoopsUser->getVar('uid')));
if ($friendpetition_factory->getCount($criteria2)>0){
redirect_header(XOOPS_URL."/modules/yogurt/index.php?uid=".$_POST['petitioned_uid'],3,_MD_YOGURT_ALREADY_PETITIONED);
}	
}             
              /**
              * create the petition in database
              */
              $newpetition = $friendpetition_factory->create(true);
              $newpetition->setVar('petitioner_uid',$xoopsUser->getVar('uid'));
              $newpetition->setVar('petioned_uid',$_POST['petitioned_uid']);

              if ($friendpetition_factory->insert($newpetition)){
              $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
              $extra_tags['X_OWNER_UID'] = $xoopsUser->getVar('uid');
              $notification_handler =& xoops_gethandler('notification');
              $notification_handler->triggerEvent ("friendship", $_POST['petitioned_uid'] , "new_friendship",$extra_tags);       
                     
                     redirect_header(XOOPS_URL."/modules/yogurt/index.php?uid=".$_POST['petitioned_uid'],3,_MD_YOGURT_PETITIONED);
              } else {
                     redirect_header(XOOPS_URL."/modules/yogurt/index.php?uid=".$xoopsUser->getVar('uid'),3,_MD_YOGURT_NOCACHACA);
              }


/**
 * Close page  
 */
include("../../footer.php");
?>