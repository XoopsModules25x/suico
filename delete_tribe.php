<?php
// $Id: delete_tribe.php,v 1.2 2007/11/25 14:36:21 marcellobrandao Exp $
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
include_once __DIR__ . '/class/yogurt_tribes.php';

/**
 * Factories of tribes
 */
$reltribeuser_factory = new Xoopsyogurt_reltribeuserHandler($xoopsDB);
$tribes_factory       = new Xoopsyogurt_tribesHandler($xoopsDB);

$tribe_id = (int)$_POST['tribe_id'];

if (!isset($_POST['confirm']) || 1 != $_POST['confirm']) {
    xoops_confirm(['tribe_id' => $tribe_id, 'confirm' => 1], 'delete_tribe.php', _MD_YOGURT_ASKCONFIRMTRIBEDELETION, _MD_YOGURT_CONFIRMTRIBEDELETION);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $criteria_tribe_id = new Criteria('tribe_id', $tribe_id);
    $uid               = (int)$xoopsUser->getVar('uid');
    $criteria_uid      = new Criteria('owner_uid', $uid);
    $criteria          = new CriteriaCompo($criteria_tribe_id);
    $criteria->add($criteria_uid);

    /**
     * Try to delete
     */
    if (1 == $tribes_factory->getCount($criteria)) {
        if ($tribes_factory->deleteAll($criteria)) {
            $criteria_rel_tribe_id = new Criteria('rel_tribe_id', $tribe_id);
            $reltribeuser_factory->deleteAll($criteria_rel_tribe_id);
            redirect_header('tribes.php?uid=' . $uid, 3, _MD_YOGURT_TRIBEDELETED);
        } else {
            redirect_header('tribes.php?uid=' . $uid, 3, _MD_YOGURT_NOCACHACA);
        }
    }
}

include __DIR__ . '/../../footer.php';
