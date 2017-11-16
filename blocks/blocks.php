<?php
// $Id: blocks.php,v 1.8 2008/01/22 10:29:27 marcellobrandao Exp $ //
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
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
//include_once(XOOPS_ROOT_PATH."/class/criteria.php");
include_once XOOPS_ROOT_PATH . '/modules/yogurt/class/yogurt_friendship.php';
include_once XOOPS_ROOT_PATH . '/modules/yogurt/class/yogurt_images.php';

/**
 * @param $options
 * @return array
 */
function b_yogurt_friends_show($options)
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsUser;
    $myts  = MyTextSanitizer::getInstance();
    $block = [];

    if (!empty($xoopsUser)) {

        /**
         * Filter for fetch votes ishot and isnothot
         */

        $criteria_2 = new criteria('friend1_uid', $xoopsUser->getVar('uid'));

        /**
         * Creating factories of pictures and votes
         */
        //$album_factory      = new Xoopsyogurt_imagesHandler($xoopsDB);
        $friends_factory = new Xoopsyogurt_friendshipHandler($xoopsDB);

        $block['friends'] = $friends_factory->getFriends($options[0], $criteria_2, 0);
    }
    $block['lang_allfriends'] = _MB_YOG_ALLFRIENDS;
    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_yogurt_friends_edit($options)
{
    $form = "<input type='text' value='" . $options['0'] . "'id='options[]' name='options[]' />";

    return $form;
}

/**
 * @param $options
 * @return array
 */
function b_yogurt_lastpictures_show($options)
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig;
    $myts  = MyTextSanitizer::getInstance();
    $block = [];

    /**
     * Filter for fetch votes ishot and isnothot
     */

    $criteria = new criteria('cod_img', 0, '>');
    $criteria->setSort('cod_img');
    $criteria->setOrder('DESC');
    $criteria->setLimit($options[0]);

    /**
     * Creating factories of pictures and votes
     */
    //$album_factory      = new Xoopsyogurt_imagesHandler($xoopsDB);
    $pictures_factory = new Xoopsyogurt_imagesHandler($xoopsDB);

    $block = $pictures_factory->getLastPicturesForBlock($options[0]);

    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_yogurt_lastpictures_edit($options)
{
    $form = "<input type='text' value='" . $options['0'] . "'id='options[]' name='options[]' />";

    return $form;
}
