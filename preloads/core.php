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

use Xmf\Request;

/**
 * Class SuicoCorePreload
 */
class SuicoCorePreload extends \XoopsPreloadItem
{
    // to add PSR-4 autoloader
    /**
     * @param $args
     */
    public static function eventCoreIncludeCommonEnd($args)
    {
        require __DIR__ . '/autoloader.php';
    }

    /**
     * @param $args
     */
    public static function eventCoreEdituserStart($args)
    {
        header('location: ./modules/suico/edituser.php' . (Request::getString('QUERY_STRING', '', 'SERVER')));
        exit();
    }

    /**
     * @param $args
     */
    public static function eventCoreRegisterStart($args)
    {
        header('location: ./modules/suico/user.php?op=register' . (Request::getString('QUERY_STRING', '', 'SERVER')));
        exit();
    }

    /**
     * @param $args
     */
    public static function eventCoreUserinfoStart($args)
    {
        header('location: ./modules/suico/index.php?' . (Request::getString('QUERY_STRING', '', 'SERVER')));
        exit();
    }
}
