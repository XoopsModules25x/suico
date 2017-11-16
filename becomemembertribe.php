<?php
// $Id: becomemembertribe.php,v 1.3 2008/06/17 00:43:12 marcellobrandao Exp $
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
include_once __DIR__ . '/../../mainfile.php';
include_once __DIR__ . '/../../header.php';

include_once __DIR__ . '/class/yogurt_friendpetition.php';
include_once __DIR__ . '/class/yogurt_reltribeuser.php';
include_once __DIR__ . '/class/yogurt_tribes.php';

/**
 * Factories of tribes... testing for zend editor
 */
$reltribeuser_factory = new Xoopsyogurt_reltribeuserHandler($xoopsDB);
$tribes_factory       = new Xoopsyogurt_tribesHandler($xoopsDB);

$tribe_id = (int)$_POST['tribe_id'];
$uid      = (int)$xoopsUser->getVar('uid');

$criteria_uid      = new Criteria('rel_user_uid', $uid);
$criteria_tribe_id = new Criteria('rel_tribe_id', $tribe_id);
$criteria          = new CriteriaCompo($criteria_uid);
$criteria->add($criteria_tribe_id);
if ($reltribeuser_factory->getCount($criteria) < 1) {
    $reltribeuser = $reltribeuser_factory->create();
    $reltribeuser->setVar('rel_tribe_id', $tribe_id);
    $reltribeuser->setVar('rel_user_uid', $uid);
    if ($reltribeuser_factory->insert($reltribeuser)) {
        redirect_header('tribes.php', 1, _MD_YOGURT_YOUAREMEMBERNOW);
    } else {
        redirect_header('tribes.php', 1, _MD_YOGURT_NOCACHACA);
    }
} else {
    redirect_header('tribes.php', 1, _MD_YOGURT_YOUAREMEMBERALREADY);
}

include __DIR__ . '/../../footer.php';
