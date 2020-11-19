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
    Helper
};
/** @var Helper $helper */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
//include_once(XOOPS_ROOT_PATH."/class/criteria.php");
//require_once XOOPS_ROOT_PATH . '/modules/suico/class/Friendship.php';
/**
 * @param $options
 * @return array
 */
function b_suico_friends_show($options)
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsUser;

    /** @var Helper $helper */
    if (!class_exists(Helper::class)) {
        return false;
    }

    $helper = Helper::getInstance();
    $helper->loadLanguage('main');

    $myts  = \MyTextSanitizer::getInstance();
    $block = [];
    if ($xoopsUser) {
        /**
         * Filter for fetch votes ishot and isnothot
         */
        $criteria2 = new Criteria(
            'friend1_uid', $xoopsUser->getVar(
            'uid'
        )
        );
        /**
         * Creating factories of pictures and votes
         */
        //$albumFactory      = new ImagesHandler($xoopsDB);
        $friendsFactory           = new \XoopsModules\Suico\FriendshipHandler($xoopsDB);
        $block['friends']         = $friendsFactory->getFriends($options[0], $criteria2);
        $block['lang_allfriends'] = _MB_SUICO_ALLFRIENDS;
        $block['lang_nofriends']  = _MB_SUICO_NOFRIENDSYET;
        $block['enablepm']        = $options[1] ?? '';
        return $block;
    }
}

/**
 * @param array $options
 * @return string
 */
function b_suico_friends_edit($options)
{
    $form .= _MB_SUICO_TOTALFRIENDSTOSHOW . '&nbsp;';
    $form .= "<input type='text' name='options[0]' value='" . $options[0] . "'><br>";
    $form .= _MB_SUICO_ENABLEPM . '&nbsp;';
    if (isset($options[1]) && 1 === $options[1]) {
        $chk = ' checked';
    }
    $form .= "<input type='radio' name='options[1]' value='1'" . $chk . '>&nbsp;' . _YES . '';
    $chk  = '';
    if (!isset($options[1]) || 0 === $options[1]) {
        $chk = ' checked';
    }
    $form .= "&nbsp;<input type='radio' name='options[1]' value='0'" . $chk . '>' . _NO . '<br>';
    return $form;
}
