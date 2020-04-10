<?php
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
include dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$helper = \XoopsModules\Yogurt\Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');

$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    //    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

$adminmenu[] = [
    'title' => _MI_YOGURT_ADMENU1,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU2,
    'link'  => 'admin/images.php',
    'icon'  => "{$pathIcon32}/photo.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU3,
    'link'  => 'admin/friendship.php',
    'icon'  => "{$pathIcon32}/users.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU4,
    'link'  => 'admin/friendpetition.php',
    'icon'  => "{$pathIcon32}/face-smile.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU5,
    'link'  => 'admin/visitors.php',
    'icon'  => "{$pathIcon32}/user-icon.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU6,
    'link'  => 'admin/video.php',
    'icon'  => "{$pathIcon32}/marquee.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU7,
    'link'  => 'admin/groups.php',
    'icon'  => "{$pathIcon32}/groupmod.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU8,
    'link'  => 'admin/relgroupuser.php',
    'icon'  => "{$pathIcon32}/penguin.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU9,
    'link'  => 'admin/notes.php',
    'icon'  => "{$pathIcon32}/translations.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU10,
    'link'  => 'admin/configs.php',
    'icon'  => "{$pathIcon32}/administration.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU11,
    'link'  => 'admin/suspensions.php',
    'icon'  => "{$pathIcon32}/alert.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU12,
    'link'  => 'admin/audio.php',
    'icon'  => "{$pathIcon32}/playlist.png",
];

$adminmenu[] = [
    'title' => _MI_YOGURT_MENU_02,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/manage.png',
];

// Blocks Admin
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link'  => 'admin/blocksadmin.php',
    'icon'  => $pathIcon32 . '/block.png',
];

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link'  => 'admin/migrate.php',
        'icon'  => $pathIcon32 . '/database_go.png',
    ];
}

//$adminmenu[] = [
//    'title' => _MI_YOGURT_ADMENU2,
//    'link'  => 'admin/main.php?op=about',
//    'icon'  => $pathIcon32 . '/about.png',
//];

$adminmenu[] = [
    'title' => _MI_YOGURT_ADMENU2,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
