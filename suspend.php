<?php
// $Id: suspend.php,v 1.1 2007/10/20 01:27:28 marcellobrandao Exp $
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
include_once '../../class/criteria.php';

include_once 'class/yogurt_suspensions.php';

if(!($GLOBALS['xoopsSecurity']->check())) {redirect_header($_SERVER['HTTP_REFERER'], 5, _MD_YOGURT_TOKENEXPIRED);}

$uid = intval($_POST['uid']);
/**
* Creating the factory  loading the picture changing its caption
*/
$suspensions_factory = new Xoopsyogurt_suspensionsHandler($xoopsDB);
$suspension = $suspensions_factory->create(false);
$suspension->load($uid);

if($xoopsUser->isAdmin(1))
{
	$member_handler =& xoops_gethandler('member');
	$thisUser =& $member_handler->getUser($uid);
	$suspension->setVar('uid', $uid);
	$suspension->setVar('old_email', $thisUser->getVar('email'));
	$suspension->setVar('old_pass',$thisUser->getVar('pass'));
	if(defined(ICMS_VERSION_NAME))
	{
		$thisUser->setVar('old_salt', $thisUser->getVar('salt'));
		$thisUser->setVar('old_pass_expired', $thisUser->getVar('pass_expired'));
		$thisUser->setVar('old_enc_type', $thisUser->getVar('enc_type'));
	}
	$suspension->setVar('old_signature',$thisUser->getVar('user_sig'));
	$suspension->setVar('suspension_time',time()+intval($_POST['time']));
	$suspensions_factory->insert($suspension);
	$thisUser->setVar('email',md5(time()));
	$thisUser->setVar('pass',md5(time()));
	
	$thisUser->setVar('user_sig',sprintf(_MD_YOGURT_SUSPENDED,formatTimestamp( time()+intval($_POST['time']),'m')));
	$member_handler->insertUser($thisUser);
	redirect_header('index.php?uid='.$uid,300,_MD_YOGURT_USERSUSPENDED);
}

include '../../footer.php';
?>