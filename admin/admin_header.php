<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team
 */

use XoopsModules\Yogurt;

require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
//require $GLOBALS['xoops']->path('www/class/xoopsformloader.php');

include dirname(__DIR__) . '/preloads/autoloader.php';

require dirname(__DIR__) . '/include/common.php';

$moduleDirName = basename(dirname(__DIR__));

/** @var \XoopsModules\Yogurt\Helper $helper */
$helper = \XoopsModules\Yogurt\Helper::getInstance();

/** @var \Xmf\Module\Admin $adminObject */
$adminObject = \Xmf\Module\Admin::getInstance();

// Load language files
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('common');

$db = \XoopsDatabaseFactory::getDatabaseConnection();

$pathIcon16    = \Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32    = \Xmf\Module\Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

/** @var \XoopsPersistableObjectHandler $imagesHandler */
$imagesHandler = $helper->getHandler('Images');
/** @var \XoopsPersistableObjectHandler $friendshipHandler */
$friendshipHandler = $helper->getHandler('Friendship');
/** @var \XoopsPersistableObjectHandler $visitorsHandler */
$visitorsHandler = $helper->getHandler('Visitors');
/** @var \XoopsPersistableObjectHandler $videoHandler */
$videoHandler = $helper->getHandler('Video');
/** @var \XoopsPersistableObjectHandler $friendpetitionHandler */
$friendpetitionHandler = $helper->getHandler('Friendpetition');
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

$myts = \MyTextSanitizer::getInstance();
if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    require XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new \XoopsTpl();
}

$pathIcon16    = Xmf\Module\Admin::iconUrl('', 16);
$pathIcon32    = Xmf\Module\Admin::iconUrl('', 32);
$pathModIcon32 = $helper->getModule()->getInfo('modicons32');

// Local icons path
$xoopsTpl->assign('pathModIcon16', $pathIcon16);
$xoopsTpl->assign('pathModIcon32', $pathIcon32);
