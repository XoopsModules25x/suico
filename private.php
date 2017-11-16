<?php
// $Id: private.php,v 1.2 2007/09/06 14:40:15 marcellobrandao Exp $
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

include_once __DIR__ . '/class/yogurt_images.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$cod_img = $_POST['cod_img'];

/**
 * Creating the factory  loading the picture changing its caption
 */
$picture_factory = new Xoopsyogurt_imagesHandler($xoopsDB);
$picture         = $picture_factory->create(false);
$picture->load($cod_img);
$picture->setVar('private', (int)$_POST['private']);

/**
 * Verifying who's the owner to allow changes
 */
$uid = (int)$xoopsUser->getVar('uid');
if ($uid == $picture->getVar('uid_owner')) {
    if ($picture_factory->insert($picture)) {
        if (1 == $_POST['private']) {
            redirect_header('album.php', 2, _MD_YOGURT_PRIVATIZED);
        } else {
            redirect_header('album.php', 2, _MD_YOGURT_UNPRIVATIZED);
        }
    } else {
        redirect_header('album.php', 2, _MD_YOGURT_NOCACHACA);
    }
}

include __DIR__ . '/../../footer.php';
