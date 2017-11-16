<?php
// $Id: abandontribe.php,v 1.1 2007/09/21 03:28:05 marcellobrandao Exp $
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

include_once __DIR__ . '/class/yogurt_reltribeuser.php';

/**
 * Verify Token
 */
//if (!($GLOBALS['xoopsSecurity']->check())){
//            redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 5, _MD_YOGURT_TOKENEXPIRED);
//}

/**
 * Receiving info from get parameters
 */
$reltribeuser_id = (int)$_POST['reltribe_id'];
if (!isset($_POST['confirm']) || 1 != $_POST['confirm']) {
    xoops_confirm(['reltribe_id' => $reltribeuser_id, 'confirm' => 1], 'abandontribe.php', _MD_YOGURT_ASKCONFIRMABANDONTRIBE, _MD_YOGURT_CONFIRMABANDON);
} else {

    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $reltribeuser_factory = new Xoopsyogurt_reltribeuserHandler($xoopsDB);
    $criteria_rel_id      = new Criteria('rel_id', $reltribeuser_id);
    $uid                  = (int)$xoopsUser->getVar('uid');
    $criteria_uid         = new Criteria('rel_user_uid', $uid);
    $criteria             = new CriteriaCompo($criteria_rel_id);
    $criteria->add($criteria_uid);

    /**
     * Try to delete
     */
    if ($reltribeuser_factory->deleteAll($criteria)) {
        redirect_header('tribes.php', 1, _MD_YOGURT_TRIBEABANDONED);
    } else {
        redirect_header('tribes.php', 1, _MD_YOGURT_NOCACHACA);
    }
}
include __DIR__ . '/../../footer.php';
