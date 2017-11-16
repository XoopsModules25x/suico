<?php
// $Id: submit.php,v 1.8 2008/01/23 10:26:21 marcellobrandao Exp $
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

/**
 * Xoops header ...
 */
include_once '../../mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'yogurt_index.tpl';
include_once '../../header.php';

/**
 * Modules class includes
 */
include_once 'class/yogurt_images.php';

/**
 * Factory of pictures created
 */
$album_factory = new Xoopsyogurt_imagesHandler($xoopsDB);

/**
 * Getting the title
 */
$title = $_POST['caption'];

/**
 * Getting parameters defined in admin side
 */
$path_upload   = XOOPS_ROOT_PATH . '/uploads';
$pictwidth     = $xoopsModuleConfig['resized_width'];
$pictheight    = $xoopsModuleConfig['resized_height'];
$thumbwidth    = $xoopsModuleConfig['thumb_width'];
$thumbheight   = $xoopsModuleConfig['thumb_height'];
$maxfilebytes  = $xoopsModuleConfig['maxfilesize'];
$maxfileheight = $xoopsModuleConfig['max_original_height'];
$maxfilewidth  = $xoopsModuleConfig['max_original_width'];

/**
 * If we are receiving a file
 */
if ('sel_photo' == $_POST['xoops_upload_file'][0]) {

    /**
     * Verify Token
     */
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
    }
    ini_set('memory_limit', '50M');
    /**
     * Try to upload picture resize it insert in database and then redirect to index
     */
    if ($album_factory->receivePicture($title, $path_upload, $thumbwidth, $thumbheight, $pictwidth, $pictheight, $maxfilebytes, $maxfilewidth, $maxfileheight)) {
        $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
        $extra_tags['X_OWNER_UID']  = $xoopsUser->getVar('uid');
        $notificationHandler        = xoops_getHandler('notification');
        $notificationHandler->triggerEvent('picture', $xoopsUser->getVar('uid'), 'new_picture', $extra_tags);
        //header("Location: ".XOOPS_URL."/modules/yogurt/index.php?uid=".$xoopsUser->getVar('uid'));
        redirect_header(XOOPS_URL . '/modules/yogurt/album.php?uid=' . $xoopsUser->getVar('uid'), 3, _MD_YOGURT_UPLOADED);
    } else {
        redirect_header(XOOPS_URL . '/modules/yogurt/album.php?uid=' . $xoopsUser->getVar('uid'), 3, _MD_YOGURT_NOCACHACA);
    }
}

/**
 * Close page
 */
include '../../footer.php';
