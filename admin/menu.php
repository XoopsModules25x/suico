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
 * Module: Yogurt
 *
 * @category        Module
 * @package         yogurt
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */

use XoopsModules\Yogurt;
use Xmf\Request;
use Xmf\Module\Admin;

require dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

/** @var \XoopsModules\Yogurt\Helper $helper */
$helper = Yogurt\Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo');
$helper->loadLanguage('main');

$pathIcon32 = Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    //    $pathModIcon32 = $helper->getConfig('modicons32');
    $pathModIcon32 = $helper->url(
        $helper->getConfig('modicons32')
    );
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
    'link'  => 'admin/friendships.php',
    'icon'  => "{$pathIcon32}/users.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU4,
    'link'  => 'admin/visitors.php',
    'icon'  => "{$pathIcon32}/user-icon.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU5,
    'link'  => 'admin/videos.php',
    'icon'  => "{$pathIcon32}/marquee.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU6,
    'link'  => 'admin/friendrequests.php',
    'icon'  => "{$pathIcon32}/face-smile.png",
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
    'link'  => 'admin/audios.php',
    'icon'  => "{$pathIcon32}/playlist.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU13,
    'link'  => 'admin/privacy.php',
    'icon'  => "{$pathIcon32}/album.png",
];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU17,
	'link'  => 'admin/profile_user.php',
	'icon'  => $pathIcon32 . '/users.png',
];
$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU18,
	'link'  => 'admin/profile_fieldscategory.php',
	'icon'  => $pathIcon32 . '/category.png',
];
$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU19,
	'link'  => 'admin/profile_fieldslist.php',
	'icon'  => $pathIcon32 . '/index.png',
];
$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU20,
	'link'  => 'admin/profile_registrationstep.php',
	'icon'  => $pathIcon32 . '/stats.png',
];
$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU21,
	'link'  => 'admin/profile_fieldspermissions.php',
	'icon'  => $pathIcon32 . '/permissions.png',
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

$adminmenu[] = [
    'title' => _MI_YOGURT_MENU_02,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/manage.png',
];

//$adminmenu[] = [
//    'title' => _MI_YOGURT_ADMENU2,
//    'link'  => 'admin/main.php?op=about',
//    'icon'  => $pathIcon32 . '/about.png',
//];

$adminmenu[] = [
    'title' => MI_YOGURT_ADMENU16,
    'link'  => 'admin/about.php',
    'icon'  => "{$pathIcon32}/about.png",
];
