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
use XoopsModules\Suico\{
    Helper,
    ImageHandler,
    VisitorsHandler,
    VideoHandler,
    FriendrequestHandler,
    FriendshipHandler
};

/** @var Helper $helper */

require __DIR__ . '/preloads/autoloader.php';
require dirname(__DIR__, 2) . '/mainfile.php';
require XOOPS_ROOT_PATH . '/header.php';
$moduleDirName = basename(__DIR__);
$helper        = Helper::getInstance();
$modulePath    = XOOPS_ROOT_PATH . '/modules/' . $moduleDirName;
$myts          = \MyTextSanitizer::getInstance();
if (!isset($GLOBALS['xoTheme']) || !is_object($GLOBALS['xoTheme'])) {
    require $GLOBALS['xoops']->path('class/theme.php');
    $GLOBALS['xoTheme'] = new xos_opal_Theme();
}
//Handlers
//$XXXHandler = xoops_getModuleHandler('XXX', $moduleDirName);
/** @var \XoopsPersistableObjectHandler $imageHandler */
$imageHandler = $helper->getHandler('Image');
/** @var \XoopsPersistableObjectHandler $friendshipHandler */
$friendshipHandler = $helper->getHandler('Friendship');
/** @var \XoopsPersistableObjectHandler $visitorsHandler */
$visitorsHandler = $helper->getHandler('Visitors');
/** @var \XoopsPersistableObjectHandler $videoHandler */
$videoHandler = $helper->getHandler('Video');
/** @var \XoopsPersistableObjectHandler $friendrequestHandler */
$friendrequestHandler = $helper->getHandler('Friendrequest');
/** @var \XoopsPersistableObjectHandler $groupsHandler */
$groupsHandler = $helper->getHandler('Groups');
/** @var \XoopsPersistableObjectHandler $relgroupuserHandler */
$relgroupuserHandler = $helper->getHandler('Relgroupuser');
/** @var \XoopsPersistableObjectHandler $notesHandler */
$notesHandler = $helper->getHandler('Notes');
/** @var \XoopsPersistableObjectHandler $configsHandler */
$configsHandler = $helper->getHandler('Configs');
/** @var \XoopsPersistableObjectHandler $suspensionsHandler */
$suspensionsHandler = $helper->getHandler('Suspensions');
/** @var \XoopsPersistableObjectHandler $audioHandler */
$audioHandler = $helper->getHandler('Audio');
// Load language files
$helper->loadLanguage('blocks');
$helper->loadLanguage('common');
$helper->loadLanguage('main');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');
//$helper->loadLanguage('user');
xoops_loadLanguage('user');
if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    require $GLOBALS['xoops']->path('class/template.php');
    $xoopsTpl = new \XoopsTpl();
}
$imageFactory         = new ImageHandler($xoopsDB);
$visitorsFactory      = new VisitorsHandler($xoopsDB);
$videosFactory        = new VideoHandler($xoopsDB);
$friendrequestFactory = new FriendrequestHandler($xoopsDB);
$friendshipFactory    = new FriendshipHandler($xoopsDB);
$isOwner              = 0;
$isAnonym             = 1;
$isFriend             = 0;
if (1 === $helper->getConfig('enable_guestaccess')) {
    /**
     * Enable Guest Access
     * If anonym and uid not set then redirect to admins profile
     * Else redirects to own profile
     */
    if (empty($xoopsUser)) {
        $isAnonym = 1;
        if (isset($_GET['uid'])) {
            $uid_owner = Request::getInt('uid', 0, 'GET');
        } else {
            $uid_owner = 1;
            $isOwner   = 0;
        }
    } else {
        $isAnonym = 0;
        if (isset($_GET['uid'])) {
            $uid_owner = Request::getInt('uid', 0, 'GET');
            $isOwner   = $xoopsUser->getVar('uid') === $uid_owner ? 1 : 0;
        } else {
            $uid_owner = (int)$xoopsUser->getVar('uid');
            $isOwner   = 1;
        }
    }
} else {
    /**
     * Disable Guest Access
     * If anonym redirect to landing guest page
     * Else redirects to own profile
     */
    if (empty($xoopsUser)) {
        $isAnonym = 1;
        if (!mb_stripos($_SERVER['REQUEST_URI'], 'user.php')) {
            $xoopsUser || redirect_header('user.php', 3, _NOPERM);
        }
    } else {
        $isAnonym = 0;
        if (isset($_GET['uid'])) {
            $uid_owner = Request::getInt('uid', 0, 'GET');
            $isOwner   = $xoopsUser->getVar('uid') === $uid_owner ? 1 : 0;
        } else {
            $uid_owner = (int)$xoopsUser->getVar('uid');
            $isOwner   = 1;
        }
    }
}
