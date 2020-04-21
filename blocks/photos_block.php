<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Marcello Brandão aka  Suico
 * @author       XOOPS Development Team
 * @since
 */

use XoopsModules\Yogurt;

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
//include_once(XOOPS_ROOT_PATH."/class/criteria.php");
//require_once XOOPS_ROOT_PATH . '/modules/yogurt/class/Image.php';

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

    $criteria = new Criteria('cod_img', 0, '>');
    $criteria->setSort('cod_img');
    $criteria->setOrder('DESC');
    $criteria->setLimit($options[0]);

    /**
     * Creating factories of pictures and votes
     */
    //$albumFactory      = new ImagesHandler($xoopsDB);
    $imageFactory = new Yogurt\ImageHandler($xoopsDB);

    return $imageFactory->getLastPicturesForBlock($options[0]);
}

/**
 * @param $options
 * @return string
 */
function b_yogurt_lastpictures_edit($options)
{
    return "<input type='text' value='" . $options['0'] . "'id='options[]' name='options[]'>";
}
