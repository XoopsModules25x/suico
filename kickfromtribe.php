<?php
// $Id: kickfromtribe.php,v 1.2 2007/11/16 18:24:33 marcellobrandao Exp $
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

include_once 'class/yogurt_reltribeuser.php';
include_once 'class/yogurt_tribes.php';

$tribe_id = intval($_POST['tribe_id']);
$rel_user_uid = intval($_POST['rel_user_uid']);

if($_POST['confirm']!=1)
{
	xoops_confirm(array('rel_user_uid' => $rel_user_uid, 'tribe_id' => $tribe_id ,'confirm' => 1 ) , 'kickfromtribe.php', _MD_YOGURT_ASKCONFIRMKICKFROMTRIBE, _MD_YOGURT_CONFIRMKICK);
}
else
{
	/**
	* Creating the factory  and the criteria to delete the picture
	* The user must be the owner
	*/
	$reltribeuser_factory = new Xoopsyogurt_reltribeuserHandler($xoopsDB);
	$tribes_factory = new Xoopsyogurt_tribesHandler($xoopsDB);
	$tribe = $tribes_factory->get($tribe_id);
	//	echo "<pre>";
	//	print_r($tribe);
	if($xoopsUser->getVar('uid')==$tribe->getVar('owner_uid'))
	{
		$criteria_rel_user_uid = new Criteria('rel_user_uid',$rel_user_uid);
		$criteria_tribe_id 	   = new Criteria('rel_tribe_id',$tribe_id);
		$criteria = new CriteriaCompo($criteria_rel_user_uid);
		$criteria->add($criteria_tribe_id);
		/**
		* Try to delete  
		*/
		if($reltribeuser_factory->deleteAll($criteria)){redirect_header('tribes.php', 2, _MD_YOGURT_TRIBEKICKED);}
		else {redirect_header('tribes.php', 2, _MD_YOGURT_NOCACHACA);}
	}
	else {redirect_header('tribes.php', 2, _MD_YOGURT_NOCACHACA);}
}

include '../../footer.php';
?>
