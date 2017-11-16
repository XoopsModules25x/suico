<?php
// $Id: ishot.php,v 1.4 2007/09/06 01:47:11 marcellobrandao Exp $
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
$GLOBALS['xoopsOption']['template_main'] = 'yogurt_index.tpl';
include_once __DIR__ . '/../../header.php';

include_once __DIR__ . '/class/yogurt_ishot.php';

/**
 * Factory of pictures created
 */
$ishot_factory = new Xoopsyogurt_ishotHandler($xoopsDB);

$uid_voted = (int)$_POST['uid_voted'];
$ishot     = (int)$_POST['ishot'];
$uid_voter = (int)$xoopsUser->getVar('uid');

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

/**
 * Verify if user is trying to vote for himself
 */
if ($uid_voter == $uid_voted) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_CANTVOTEOWN);
}

/**
 * Verify that this user hasn't voted or added this user yet
 */
$criteria_uidvoter = new criteria('uid_voter', $uid_voter);
$criteria_uidvoted = new criteria('uid_voted', $uid_voted);
$criteria          = new criteriaCompo($criteria_uidvoter);
$criteria->add($criteria_uidvoted);

if (0 == $ishot_factory->getCount($criteria)) {
    $vote = $ishot_factory->create(true);
    $vote->setVar('uid_voted', $uid_voted);
    $vote->setVar('uid_voter', $uid_voter);

    if (1 == $ishot) {
        $vote->setVar('ishot', 1);
    } else {
        $vote->setVar('ishot', 0);
    }

    $ishot_factory->insert($vote);
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_VOTED);
} else {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_ALREADYVOTED);
}

include __DIR__ . '/../../footer.php';
