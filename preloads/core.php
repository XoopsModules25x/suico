<?php declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          XOOPS Project <www.xoops.org> <www.xoops.ir>
 */
defined(
    'XOOPS_ROOT_PATH'
)
|| die('Restricted access.');

/**
 * Class YogurtCorePreload
 */
class YogurtCorePreload extends XoopsPreloadItem
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
    public static function eventCoreUserStart($args)
    {
        $op = 'main';
        if (isset($_POST['op'])) {
            $op = trim($_POST['op']);
        } elseif (isset($_GET['op'])) {
            $op = trim($_GET['op']);
        }
        if ($op !== 'login' && (empty($_GET['from']) || 'yogurt' !== $_GET['from'])) {
            header('location: ./modules/yogurt/user.php' . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']));
            exit();
        }
    }

    /**
     * @param $args
     */
    public static function eventCoreEdituserStart($args)
    {
        header('location: ./modules/yogurt/edituser.php' . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']));
        exit();
    }

	/**
     * @param $args
     */
    public static function eventCoreUserinfoStart($args)
    {
        header('location: ./modules/yogurt/index.php' . (empty($_SERVER['QUERY_STRING']) ? '' : '?' . $_SERVER['QUERY_STRING']));
        exit();
    }
	
}
