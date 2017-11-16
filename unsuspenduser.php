<?php
// $Id: unsuspenduser.php,v 1.1 2007/10/20 01:27:28 marcellobrandao Exp $
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
include_once __DIR__ . '/../../class/criteria.php';
include_once __DIR__ . '/../../class/criteria.php';

include_once __DIR__ . '/class/yogurt_suspensions.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$uid = (int)$_POST['uid'];
/**
 * Creating the factory  loading the picture changing its caption
 */
$suspensions_factory = new Xoopsyogurt_suspensionsHandler($xoopsDB);
$suspension          = $suspensions_factory->create(false);
$suspension->load($uid);

if ($xoopsUser->isAdmin(1)) {
    $memberHandler = xoops_getHandler('member');
    $thisUser      = $memberHandler->getUser($uid);

    $thisUser->setVar('email', $suspension->getVar('old_email', 'n'));
    $thisUser->setVar('pass', $suspension->getVar('old_pass', 'n'));
    if (defined(ICMS_VERSION_NAME)) {
        $thisUser->setVar('salt', $suspension->getVar('old_salt', 'n'));
        $thisUser->setVar('pass_expired', $suspension->getVar('old_pass_expired', 'n'));
        $thisUser->setVar('enc_type', $suspension->getVar('old_enc_type', 'n'));
    }
    $thisUser->setVar('user_sig', $suspension->getVar('old_signature', 'n'));
    $memberHandler->insertUser($thisUser);

    $criteria = new Criteria('uid', $uid);
    $suspensions_factory->deleteAll($criteria);
    redirect_header('index.php?uid=' . $uid, 3, _MD_YOGURT_USERUNSUSPENDED);
}

include __DIR__ . '/../../footer.php';
