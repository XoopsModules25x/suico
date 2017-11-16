<?php
// $Id: makefriends.php,v 1.4 2008/04/11 21:56:35 marcellobrandao Exp $
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
$xoopsOption['template_main'] = 'yogurt_index.html';
include_once '../../header.php';

include_once 'class/yogurt_friendpetition.php';
include_once 'class/yogurt_friendship.php';

/**
* Factory of petitions created
*/
$friendpetition_factory = new Xoopsyogurt_friendpetitionHandler($xoopsDB);
$friendship_factory = new Xoopsyogurt_friendshipHandler($xoopsDB);

$petition_id = intval($_POST['petition_id']);
$friendship_level = intval($_POST['level']);
$uid = intval($xoopsUser->getVar('uid'));

if(!($GLOBALS['xoopsSecurity']->check())) {redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_YOGURT_TOKENEXPIRED);}

$criteria= new criteriaCompo(new criteria('friendpet_id',$petition_id));
$criteria->add(new criteria('petioned_uid',$uid));
if($friendpetition_factory->getCount($criteria)>0)
{
	if(($friendship_level>0) && ($petition = $friendpetition_factory->getObjects($criteria)))
	{
		$friend1_uid = $petition[0]->getVar('petitioner_uid');
		$friend2_uid = $petition[0]->getVar('petioned_uid');
		
		$newfriendship1 = $friendship_factory->create(true);
		$newfriendship1->setVar('level',3);
		$newfriendship1->setVar('friend1_uid',$friend1_uid);
		$newfriendship1->setVar('friend2_uid',$friend2_uid);
		$newfriendship2 = $friendship_factory->create(true);
		$newfriendship2->setVar('level',$friendship_level);
		$newfriendship2->setVar('friend1_uid',$friend2_uid);
		$newfriendship2->setVar('friend2_uid',$friend1_uid);
		$friendpetition_factory->deleteAll($criteria);
		$friendship_factory->insert($newfriendship1);
		$friendship_factory->insert($newfriendship2);
	
		redirect_header(XOOPS_URL.'/modules/yogurt/friends.php?uid='.$friend2_uid,3,_MD_YOGURT_FRIENDMADE);
	}
	else
	{
		if($friendship_level==0)
		{
			$friendpetition_factory->deleteAll($criteria);
			redirect_header(XOOPS_URL.'/modules/yogurt/seutubo.php?uid='.$uid,3,_MD_YOGURT_FRIENDSHIPNOTACCEPTED);
		}
		redirect_header(XOOPS_URL.'/modules/yogurt/index.php?uid='.$uid,3,_MD_YOGURT_NOCACHACA);
	}
}
else {redirect_header(XOOPS_URL.'/modules/yogurt/index.php?uid='.$uid,3,_MD_YOGURT_NOCACHACA);}

include '../../footer.php';
?>