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

use Xmf\Module\Admin;

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
require_once dirname(__DIR__) . '/include/common.php';
return (object)[
    'name'            => mb_strtoupper($moduleDirName) . ' ModuleConfigurator',
    'paths'           => [
        'dirname'    => $moduleDirName,
        'admin'      => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/admin',
        'modPath'    => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName,
        'modUrl'     => XOOPS_URL . '/modules/' . $moduleDirName,
        'uploadPath' => XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        'uploadUrl'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName,
    ],
    'uploadFolders'   => [
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/avatars',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/audio',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/thumbs',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/groups',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/videos',
        //XOOPS_UPLOAD_PATH . '/flags'
    ],
    'copyBlankFiles'  => [
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/avatars',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/audio',
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
        'suico_seutubo'        => 'suico_videos',
        'suico_Groups'         => 'suico_groups',
        'suico_Configs'        => 'suico_configs',
        'suico_friendpetition' => 'suico_friendrequests',
        'suico_audio'          => 'suico_audios',
        'suico_friendship'     => 'suico_friendships',
    ],
    'renameColumns'   => [
        '3.5' => [
            'suico_notes'          => [
                'Note_id'   => 'note_id',
                'Note_text' => 'note_text',
                'Note_from' => 'note_from',
                'Note_to'   => 'note_to',
            ],
            'suico_friendrequests' => [
                'requespet_uid' => 'friendreq_id',
                'requester_uid' => 'friendrequester_uid',
                'requestto_uid' => 'friendrequestto_uid',
            ],
            'suico_audios'         => [
                'url' => 'filename',
            ],
            'suico_images'         => [
                'url' => 'filename',
            ],
        ],
    ],
    'moduleStats'     => [
        //            'totalcategories' => $helper->getHandler('Category')->getCategoriesCount(-1),
        //            'totalitems'      => $helper->getHandler('Item')->getItemsCount(),
        //            'totalsubmitted'  => $helper->getHandler('Item')->getItemsCount(-1, [Constants::PUBLISHER_STATUS_SUBMITTED]),
    ],
    'modCopyright'    => "<a href='https://xoops.org' title='XOOPS Project' target='_blank'>
                     <img src='" . Admin::iconUrl('xoopsmicrobutton.gif') . "' alt='XOOPS Project'></a>",
];
