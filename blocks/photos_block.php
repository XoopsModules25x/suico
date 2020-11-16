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

use XoopsModules\Suico\{
    Helper,
    ImageHandler
};
/** @var Helper $helper */

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
    global $xoopsDB;

    /** @var Helper $helper */
    if (!class_exists(Helper::class)) {
        return false;
    }

    $helper = Helper::getInstance();
    $helper->loadLanguage('main');

    $myts  = \MyTextSanitizer::getInstance();
    $block = [];
    /**
     * Criteria for Pictures Block
     */
    $criteria = new Criteria('image_id', 0, '>');
    $criteria->setSort('image_id');
    $criteria->setOrder('DESC');
    $criteria->setLimit($options[4]);
    /**
     * Creating factories of pictures
     */
    $imageFactory         = new ImageHandler($xoopsDB);
    $block['picture']     = $imageFactory->getLastPicturesForBlock($options[4]);
    $block['showtitle']   = $options[0];
    $block['showcaption'] = $options[1];
    $block['showdate']    = $options[2];
    $block['showowner']   = $options[3];
    return $block;
}

/**
 * @param $options
 * @return string
 */
function b_suico_lastpictures_edit($options)
{
    $form = _MB_SUICO_SHOWPICTURETITLE . '&nbsp;';
    $chk  = '';
    if (isset($options[0]) && 0 != $options[0]) {
        $chk = ' checked';
    }
    $form .= "<input type='radio' name='options[0]' value='1'" . $chk . ' >&nbsp;' . _YES . '';
    $chk  = '';
    if (!isset($options[0]) || 0 == $options[0]) {
        $chk = ' checked';
    }
    $form .= "&nbsp;<input type='radio' name='options[0]' value='0'" . $chk . ' >' . _NO . '<br>';
    $form .= _MB_SUICO_SHOWPICTURECAPTION . '&nbsp;';
    if (isset($options[1]) && 1 == $options[1]) {
        $chk = ' checked';
    }
    $form .= "<input type='radio' name='options[1]' value='1'" . $chk . ' >&nbsp;' . _YES . '';
    $chk  = '';
    if (!isset($options[1]) || 0 == $options[1]) {
        $chk = ' checked';
    }
    $form .= "&nbsp;<input type='radio' name='options[1]' value='0'" . $chk . ' >' . _NO . '<br>';
    $form .= _MB_SUICO_SHOWPICTUREDATE . '&nbsp;';
    if (isset($options[2]) && 1 == $options[2]) {
        $chk = ' checked';
    }
    $form .= "<input type='radio' name='options[2]' value='1'" . $chk . ' >&nbsp;' . _YES . '';
    $chk  = '';
    if (!isset($options[2]) || 0 == $options[2]) {
        $chk = ' checked';
    }
    $form .= "&nbsp;<input type='radio' name='options[2]' value='0'" . $chk . ' >' . _NO . '<br>';
    $form .= _MB_SUICO_SHOWPICTUREOWNER . '&nbsp;';
    if (isset($options[3]) && 1 == $options[3]) {
        $chk = ' checked';
    }
    $form .= "<input type='radio' name='options[3]' value='1'" . $chk . ' >&nbsp;' . _YES . '';
    $chk  = '';
    if (!isset($options[3]) || 0 == $options[3]) {
        $chk = ' checked';
    }
    $form .= "&nbsp;<input type='radio' name='options[3]' value='0'" . $chk . ' >' . _NO . '<br>';
    $form .= _MB_SUICO_TOTALPICTUREDISPLAY . '&nbsp;';
    $form .= "<input type='text' name='options[4]' value='" . ($options[4] ?? 0) . "'>";
    return $form;
}
