<?php
// $Id: delvideo.php,v 1.2 2007/09/22 03:34:01 marcellobrandao Exp $
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

include_once __DIR__ . '/class/yogurt_seutubo.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$cod_video = $_POST['cod_video'];

if (1 != $_POST['confirm']) {
    xoops_confirm(['cod_video' => $cod_video, 'confirm' => 1], 'delvideo.php', _MD_YOGURT_ASKCONFIRMVIDEODELETION, _MD_YOGURT_CONFIRMVIDEODELETION);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $album_factory = new Xoopsyogurt_seutuboHandler($xoopsDB);
    $criteria_img  = new Criteria('video_id', $cod_video);
    $uid           = (int)$xoopsUser->getVar('uid');
    $criteria_uid  = new Criteria('uid_owner', $uid);
    $criteria      = new CriteriaCompo($criteria_img);
    $criteria->add($criteria_uid);

    /**
     * Try to delete
     */
    if ($album_factory->deleteAll($criteria)) {
        redirect_header('seutubo.php?uid=' . $uid, 2, _MD_YOGURT_VIDEODELETED);
    } else {
        redirect_header('seutubo.php?uid=' . $uid, 2, _MD_YOGURT_NOCACHACA);
    }
}

include __DIR__ . '/../../footer.php';
