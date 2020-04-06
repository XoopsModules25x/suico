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
$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
require_once dirname(__DIR__) . '/include/common.php';

return (object)[
    'name'           => mb_strtoupper($moduleDirName) . ' ModuleConfigurator',
    'paths'          => [
        'dirname'    => $moduleDirName,
        'admin'      => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/admin',
        'modPath'    => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName,
        'modUrl'     => XOOPS_URL . '/modules/' . $moduleDirName,
        'uploadPath' => XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        'uploadUrl'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName,
    ],
    'uploadFolders'  => [
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/avatars',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/mp3',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/thumbs',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/groups',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/videos',
        //XOOPS_UPLOAD_PATH . '/flags'
    ],
    'copyBlankFiles' => [
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/avatars',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/mp3',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/thumbs',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/groups',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/videos',
        //XOOPS_UPLOAD_PATH . '/flags'
    ],

    'copyTestFolders' => [
        [
            XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/testdata/uploads',
            XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        ],
        //            [
        //                XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/testdata/thumbs',
        //                XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/thumbs',
        //            ],
    ],

    'templateFolders' => [
        '/templates/',
        //            '/templates/blocks/',
        //            '/templates/admin/'
    ],
    'oldFiles'        => [
        '/class/request.php',
        '/class/registry.php',
        '/class/utilities.php',
        '/class/util.php',
        //            '/include/constants.php',
        //            '/include/functions.php',
        '/ajaxrating.txt',
    ],
    'oldFolders'      => [
        '/images',
        '/css',
        '/js',
        '/tcpdf',
    ],
    'renameTables'    => [
        'yogurt_seutubo' => 'yogurt_video',
        'yogurt_Groups'  => 'yogurt_groups',
        'yogurt_Configs' => 'yogurt_configs',
    ],
    'renameColumns'   => [
        '3.4' => [
            'yogurt_notes' => [
                'Note_id'   => 'note_id',
                'Note_text' => 'yogurt_configs',
                'Note_from' => 'note_text',
                'Note_to'   => 'note_from',
            ],
        ],
    ],
    'moduleStats'     => [
        //            'totalcategories' => $helper->getHandler('Category')->getCategoriesCount(-1),
        //            'totalitems'      => $helper->getHandler('Item')->getItemsCount(),
        //            'totalsubmitted'  => $helper->getHandler('Item')->getItemsCount(-1, [Constants::PUBLISHER_STATUS_SUBMITTED]),
    ],
    'modCopyright'    => "<a href='https://xoops.org' title='XOOPS Project' target='_blank'>
                     <img src='" . constant($moduleDirNameUpper . '_AUTHOR_LOGOIMG') . "' alt='XOOPS Project'></a>",
];
