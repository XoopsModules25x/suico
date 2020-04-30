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
 * @category        Module
 * @package         suico
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use XoopsModules\Suico;

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
//include_once(XOOPS_ROOT_PATH."/class/criteria.php");
//require_once XOOPS_ROOT_PATH . '/modules/suico/class/Image.php';
/**
 * @param $options
 * @return array
 */
function b_suico_lastpictures_show($options)
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
    $imageFactory = new Suico\ImageHandler($xoopsDB);
    return $imageFactory->getLastPicturesForBlock($options[0]);
}

/**
 * @param $options
 * @return string
 */
function b_suico_lastpictures_edit($options)
{
    return "<input type='text' value='" . $options['0'] . "'id='options[]' name='options[]'>";
}
