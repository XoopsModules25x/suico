<?php
// $Id: editfriendship.php,v 1.4 2008/01/23 10:26:21 marcellobrandao Exp $
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

include_once 'class/yogurt_friendship.php';

if(!$xoopsUser) {redirect_header('index.php');}

$friendship_factory = new Xoopsyogurt_friendshipHandler($xoopsDB);
$friend2_uid = intval($_POST['friend_uid']);
$marker = (!empty($_POST['marker'])) ? intval($_POST['marker']) : 0;

$friend = new XoopsUser($friend2_uid);

if($marker==1)
{
	$level = $_POST['level'];
	$cool = $_POST['cool'];
	$sexy = $_POST['hot'];
	$trusty = $_POST['trust'];
	$fan = $_POST['fan'];
	$friendship_id = intval($_POST['friendship_id']);
	
	$criteria= new criteria('friendship_id',$friendship_id);
	$friendships = $friendship_factory->getObjects($criteria);
	$friendship = $friendships[0];
	$friendship->setVar('level',$level);
	$friendship->setVar('cool',$cool);
	$friendship->setVar('hot',$sexy);
	$friendship->setVar('trust',$trusty);
	$friendship->setVar('fan' ,$fan);
	$friend2_uid = intval($friendship->getVar('friend2_uid'));
	$friendship->unsetNew();
	$friendship_factory->insert($friendship);
	redirect_header('friends.php',2,_MD_YOGURT_FRIENDSHIPUPDATED);
	
}
else {$friendship_factory->renderFormSubmit($friend);}

include '../../footer.php';
?>

