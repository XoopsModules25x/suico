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
$moduleDirName      = basename(
    __DIR__
);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
// ------------------- Informations ------------------- //
$modversion = [
    'version'             => 3.5,
    'module_status'       => 'Final',
    'release_date'        => '2020/11/16',
    'name'                => _MI_SUICO_MODULE_NAME,
    'description'         => _MI_SUICO_MODULEDESC,
    'official'            => 0,
    //1 indicates official XOOPS module supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'Marcello Brandao',
    'credits'             => 'XOOPS Development Team, The ImpressCMS Project, Jquery Lightbox, Komeia, vaughan, mamba, liomj',
    'author_mail'         => 'author-email',
    'author_website_url'  => 'https://xoops.org',
    'author_website_name' => 'XOOPS',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',
    // ------------------- Folders & Files -------------------
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . "/modules/${moduleDirName}/docs/changelog.txt",
    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/${moduleDirName}/docs/install.txt",
    // images
    'image'               => 'assets/images/logoModule.png',
    'iconsmall'           => 'assets/images/iconsmall.png',
    'iconbig'             => 'assets/images/iconbig.png',
    'dirname'             => $moduleDirName,
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://github.com/XoopsModules25x/' . $moduleDirName . '/issues',
    'support_name'        => 'Support Forum',
    'submit_bug'          => 'https://github.com/XoopsModules25x/' . $moduleDirName . '/issues',
    'module_website_url'  => 'https://xoops.org',
    'module_website_name' => 'XOOPS Project',
    // ------------------- Min Requirements -------------------
    'min_php'             => '7.1',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => [
        'mysql' => '5.5',
    ],
    // ------------------- Admin Menu -------------------
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // ------------------- Main Menu -------------------
    'hasMain'             => 1,
    // ------------------- Install/Update -------------------
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php',
    'onUninstall'         => 'include/onuninstall.php',
    // -------------------  PayPal ---------------------------
    'paypal'              => [
        'business'      => 'xoopsfoundation@gmail.com',
        'item_name'     => 'Donation : ' . _MI_SUICO_MODULE_NAME,
        'amount'        => 0,
        'currency_code' => 'USD',
    ],
    // ------------------- Mysql -----------------------------
    'sqlfile'             => [
        'mysql' => 'sql/mysql.sql',
    ],
    // ------------------- Tables ----------------------------
    'tables'              => [
        $moduleDirName . '_' . 'friendrequests',
        $moduleDirName . '_' . 'friendships',
        $moduleDirName . '_' . 'images',
        $moduleDirName . '_' . 'visitors',
        $moduleDirName . '_' . 'videos',
        $moduleDirName . '_' . 'relgroupuser',
        $moduleDirName . '_' . 'groups',
        $moduleDirName . '_' . 'notes',
        $moduleDirName . '_' . 'configs',
        $moduleDirName . '_' . 'suspensions',
        $moduleDirName . '_' . 'audios',
        $moduleDirName . '_' . 'privacy',
        $moduleDirName . '_' . 'profile',
        $moduleDirName . '_' . 'profile_category',
        $moduleDirName . '_' . 'profile_field',
        $moduleDirName . '_' . 'profile_regstep',
        $moduleDirName . '_' . 'profile_visibility',
    ],
];
// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    [
        'name' => _MI_SUICO_OVERVIEW,
        'link' => 'page=help',
    ],
    [
        'name' => _MI_SUICO_DISCLAIMER,
        'link' => 'page=disclaimer',
    ],
    [
        'name' => _MI_SUICO_LICENSE,
        'link' => 'page=license',
    ],
    [
        'name' => _MI_SUICO_SUPPORT,
        'link' => 'page=support',
    ],
];
// SX Updater/Installer
$modversion['simpleversion'] = '3.4';
$modversion['simplename']    = 'suico';
$modversion['simpleid']      = 22;
//Adicionado para rodar no about
$modversion['developer_website_url']   = 'https://sourceforge.net/projects/galeriasuico/';
$modversion['developer_website_name']  = 'Sourceforge - galeriasuico';
$modversion['developer_email']         = 'marcello.brandao@gmail.com';
$modversion['status_version']          = 'Beta';
$modversion['status']                  = 'Beta';
$modversion['date']                    = '2017-11-11';
$modversion['people']['developers'][]  = 'Suico (Dev)';
$modversion['people']['developers'][]  = 'Alfred (Dev)';
$modversion['people']['developers'][]  = 'm0nty_ (Dev)';
$modversion['people']['developers'][]  = 'sato-san (Design)';
$modversion['people']['testers'][]     = 'Luix (xoopstotal.com.br)';
$modversion['people']['testers'][]     = 'BoOot (xoopstotal.com.br)';
$modversion['people']['testers'][]     = 'Rodrigo (komeia)';
$modversion['people']['testers'][]     = 'Casar Felipe (komeia)';
$modversion['people']['translators'][] = 'Wizanda (english)';
$modversion['people']['translators'][] = 'Daniel Woo (simplified chinese)';
$modversion['people']['translators'][] = 'Werner Feichtlbauer (german)';
$modversion['people']['translators'][] = 'Francesco (italian)';
$modversion['people']['translators'][] = 'Erik Philippe (french)';
//$modversion['people']['documenters'][] = "documenter 1";
$modversion['people']['other'][] = 'Komeia (patrocanio)';
$modversion['demo_site_url']     = 'http://www.marcellobrandao.eti.br';
$modversion['demo_site_name']    = 'Marcello Brandao Site';
$modversion['support_site_url']  = 'http://sourceforge.net/projects/galeriasuico/';
$modversion['support_site_name'] = 'Sourceforge';
$modversion['submit_bug']        = 'http://sourceforge.net/tracker/?func=add&group_id=204109&atid=988288';
$modversion['submit_feature']    = 'http://sourceforge.net/tracker/?func=add&group_id=204109&atid=988291';
//$modversion['config'][1]['valuetype'] = 'int';
//can be 'int', 'float', 'textarea' or 'array'. All items with formtype 'multi_xxx' must have the valuetype 'array'
xoops_load(
    'xoopseditorhandler'
);

//Configs
$modversion['config'][] = [
    'name'        => 'general_configs',
    'title'       => '_MI_SUICO_CONFIG_GENERAL',
    'description' => '_MI_SUICO_CONFIG_GENERALDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => 'MI_SUICO_ADMINPAGER',
    'description' => 'MI_SUICO_ADMINPAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
$modversion['config'][] = [
    'name'        => 'userpager',
    'title'       => 'MI_SUICO_USERPAGER',
    'description' => 'MI_SUICO_USERPAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
$modversion['config'][] = [
    'name'        => 'enable_guestaccess',
    'title'       => '_MI_SUICO_ENABLEGUESTACCESS_TITLE',
    'description' => '_MI_SUICO_ENABLEGUESTACCESS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
    'category'    => 'general',
];
$modversion['config'][] = [
    'name'        => 'displaybreadcrumb',
    'title'       => '_MI_SUICO_DISPLAYBREADCRUMB',
    'description' => '_MI_SUICO_DISPLAYBREADCRUMB_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'general',
];
$modversion['config'][] = [
    'name'        => 'allow_usersuspension',
    'title'       => '_MI_SUICO_ENABLEUSERSUSPENSION_TITLE',
    'description' => '_MI_SUICO_ENABLEUSERSUSPENSION_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
    'category'    => 'general',
];
$modversion['config'][] = [
    'name'        => 'profile_search',
    'title'       => '_MI_SUICO_PROFILE_SEARCH',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'general',
];
$modversion['config'][] = [
    'name'        => 'profileCaptchaAfterStep1',
    'title'       => '_MI_SUICO_PROFILE_CAPTCHA_STEP1',
    'description' => '_MI_SUICO_PROFILE_CAPTCHA_STEP1_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'general',
];
// group header
$modversion['config'][] = [
    'name'        => 'notes_config',
    'title'       => '_MI_SUICO_CONFIG_NOTES',
    'description' => '_MI_SUICO_CONFIG_NOTESDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'enable_notes',
    'title'       => '_MI_SUICO_ENABLENOTES_TITLE',
    'description' => '_MI_SUICO_ENABLENOTES_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'notes',
];
$modversion['config'][] = [
    'name'        => 'notesperpage',
    'title'       => '_MI_SUICO_NOTESPERPAGE_TITLE',
    'description' => '_MI_SUICO_NOTESPERPAGE_DESC',
    'default'     => 20,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'notes',
];
// group header
$modversion['config'][] = [
    'name'        => 'photos_config',
    'title'       => '_MI_SUICO_CONFIG_PHOTOS',
    'description' => '_MI_SUICO_CONFIG_PHOTOSDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'enable_pictures',
    'title'       => '_MI_SUICO_ENABLEPICT_TITLE',
    'description' => '_MI_SUICO_ENABLEPICT_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'countPicture',
    'title'       => '_MI_SUICO_NUMBPICT_TITLE',
    'description' => '_MI_SUICO_NUMBPICT_DESC',
    'default'     => 12,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'resized_width',
    'title'       => '_MI_SUICO_RESIZEDW_TITLE',
    'description' => '_MI_SUICO_RESIZEDW_DESC',
    'default'     => 650,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'resized_height',
    'title'       => '_MI_SUICO_RESIZEDH_TITLE',
    'description' => '_MI_SUICO_RESIZEDH_DESC',
    'default'     => 450,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'max_original_width',
    'title'       => '_MI_SUICO_ORIGINALW_TITLE',
    'description' => '_MI_SUICO_ORIGINALW_DESC',
    'default'     => 2048,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'max_original_height',
    'title'       => '_MI_SUICO_ORIGINALH_TITLE',
    'description' => '_MI_SUICO_ORIGINALH_DESC',
    'default'     => 1600,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'maxfilesize',
    'title'       => '_MI_SUICO_MAXFILEBYTES_TITLE',
    'description' => '_MI_SUICO_MAXFILEBYTES_DESC',
    'default'     => 2048000,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'thumb_width',
    'title'       => '_MI_SUICO_THUMW_TITLE',
    'description' => '_MI_SUICO_THUMBW_DESC',
    'default'     => 125,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'thumb_height',
    'title'       => '_MI_SUICO_THUMBH_TITLE',
    'description' => '_MI_SUICO_THUMBH_DESC',
    'default'     => 175,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'picturesperpage',
    'title'       => '_MI_SUICO_PICTURESPERPAGE_TITLE',
    'description' => '_MI_SUICO_PICTURESPERPAGE_DESC',
    'default'     => 6,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
$modversion['config'][] = [
    'name'        => 'images_order',
    'title'       => '_MI_SUICO_IMGORDER_TITLE',
    'description' => '_MI_SUICO_IMGORDER_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'photos',
];
// group header
$modversion['config'][] = [
    'name'        => 'audios_config',
    'title'       => '_MI_SUICO_CONFIG_AUDIOS',
    'description' => '_MI_SUICO_CONFIG_AUDIOSDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'enable_audio',
    'title'       => '_MI_SUICO_ENABLEAUDIO_TITLE',
    'description' => '_MI_SUICO_ENABLEAUDIO_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'audios',
];
$modversion['config'][] = [
    'name'        => 'countAudio',
    'title'       => '_MI_SUICO_NUMBAUDIO_TITLE',
    'description' => '_MI_SUICO_NUMBAUDIO_DESC',
    'default'     => 12,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'audios',
];
$modversion['config'][] = [
    'name'        => 'audiosperpage',
    'title'       => '_MI_SUICO_AUDIOSPERPAGE_TITLE',
    'description' => '_MI_SUICO_AUDIOSPERPAGE_DESC',
    'default'     => 20,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'audios',
];
// group header
$modversion['config'][] = [
    'name'        => 'videos_config',
    'title'       => '_MI_SUICO_CONFIG_VIDEOS',
    'description' => '_MI_SUICO_CONFIG_VIDEOSDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'enable_videos',
    'title'       => '_MI_SUICO_ENABLEVIDEOS_TITLE',
    'description' => '_MI_SUICO_ENABLEVIDEOS_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'videos',
];
$modversion['config'][] = [
    'name'        => 'videosperpage',
    'title'       => '_MI_SUICO_VIDEOSPERPAGE_TITLE',
    'description' => '_MI_SUICO_VIDEOSPERPAGE_DESC',
    'default'     => 6,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'videos',
];
$modversion['config'][] = [
    'name'        => 'width_tube',
    'title'       => '_MI_SUICO_TUBEW_TITLE',
    'description' => '_MI_SUICO_TUBEW_DESC',
    'default'     => 450,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'videos',
];
$modversion['config'][] = [
    'name'        => 'height_tube',
    'title'       => '_MI_SUICO_TUBEH_TITLE',
    'description' => '_MI_SUICO_TUBEH_DESC',
    'default'     => 350,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'videos',
];
$modversion['config'][] = [
    'name'        => 'width_maintube',
    'title'       => '_MI_SUICO_MAINTUBEW_TITLE',
    'description' => '_MI_SUICO_MAINTUBEW_DESC',
    'default'     => 250,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'videos',
];
$modversion['config'][] = [
    'name'        => 'height_maintube',
    'title'       => '_MI_SUICO_MAINTUBEH_TITLE',
    'description' => '_MI_SUICO_MAINTUBEH_DESC',
    'default'     => 210,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'videos',
];
// group header
$modversion['config'][] = [
    'name'        => 'friends_config',
    'title'       => '_MI_SUICO_CONFIG_FRIENDS',
    'description' => '_MI_SUICO_CONFIG_FRIENDSDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'enable_friends',
    'title'       => '_MI_SUICO_ENABLEFRIENDS_TITLE',
    'description' => '_MI_SUICO_ENABLEFRIENDS_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'friends',
];
$modversion['config'][] = [
    'name'        => 'friendsperpage',
    'title'       => '_MI_SUICO_FRIENDSPERPAGE_TITLE',
    'description' => '_MI_SUICO_FRIENDSPERPAGE_DESC',
    'default'     => 12,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'friends',
];
$modversion['config'][] = [
    'name'        => 'allow_friendshiplevel',
    'title'       => '_MI_SUICO_ENABLEFRIENDSHIPLEVEL_TITLE',
    'description' => '_MI_SUICO_ENABLEFRIENDSHIPLEVEL_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'friends',
];
$modversion['config'][] = [
    'name'        => 'allow_fanssevaluation',
    'title'       => '_MI_SUICO_ENABLEFANSSEVALUATION_TITLE',
    'description' => '_MI_SUICO_ENABLEFANSSEVALUATION_DESC',
    'default'     => 0,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'friends',
];
// group header
$modversion['config'][] = [
    'name'        => 'groups_config',
    'title'       => '_MI_SUICO_CONFIG_GROUPS',
    'description' => '_MI_SUICO_CONFIG_GROUPSDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'enable_groups',
    'title'       => '_MI_SUICO_ENABLEGROUPS_TITLE',
    'description' => '_MI_SUICO_ENABLEGROUPS_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'groups',
];
$modversion['config'][] = [
    'name'        => 'groupsperpage',
    'title'       => '_MI_SUICO_GROUPSPERPAGE_TITLE',
    'description' => '_MI_SUICO_GROUPSPERPAGE_DESC',
    'default'     => 6,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'groups',
];
$modversion['config'][] = [
    'name'        => 'groupslogo_width',
    'title'       => '_MI_SUICO_GROUPS_LOGO_WIDTH',
    'description' => '_MI_SUICO_GROUPS_LOGO_WIDTH_DESC',
    'default'     => 125,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'groups',
];
$modversion['config'][] = [
    'name'        => 'groupslogo_height',
    'title'       => '_MI_SUICO_GROUPS_LOGO_HEIGHT',
    'description' => '_MI_SUICO_GROUPS_LOGO_HEIGHT_DESC',
    'default'     => 80,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'category'    => 'groups',
];
// group header
$modversion['config'][] = [
    'name'        => 'uploads_config',
    'title'       => '_MI_SUICO_CONFIG_UPLOAD',
    'description' => '_MI_SUICO_CONFIG_UPLOADDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
// --------------Uploads : mimetypes of image --------------
$modversion['config'][] = [
    'name'        => 'mimetypes',
    'title'       => 'MI_SUICO_MIMETYPES',
    'description' => 'MI_SUICO_MIMETYPES_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['image/gif', 'image/jpeg', 'image/png'],
    'options'     => [
        'bmp'   => 'image/bmp',
        'gif'   => 'image/gif',
        'pjpeg' => 'image/pjpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpg',
        'jpe'   => 'image/jpe',
        'png'   => 'image/png',
    ],
    'category'    => 'editor',
];
$modversion['config'][] = [
    'name'        => 'physical_delete',
    'title'       => '_MI_SUICO_DELETEPHYSICAL_TITLE',
    'description' => '_MI_SUICO_DELETEPHYSICAL_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'category'    => 'upload',
];
// group header
$modversion['config'][] = [
    'name'        => 'editor_config',
    'title'       => '_MI_SUICO_CONFIG_EDITOR',
    'description' => '_MI_SUICO_CONFIG_EDITORDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$editorHandler          = XoopsEditorHandler::getInstance();
$modversion['config'][] = [
    'name'        => 'suicoEditorAdmin',
    'title'       => 'MI_SUICO_EDITOR_ADMIN',
    'description' => 'MI_SUICO_EDITOR_DESC_ADMIN',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => array_flip($editorHandler->getList()),
    'default'     => 'tinymce',
    'category'    => 'editor',
];
$modversion['config'][] = [
    'name'        => 'suicoEditorUser',
    'title'       => 'MI_SUICO_EDITOR_USER',
    'description' => 'MI_SUICO_EDITOR_DESC_USER',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => array_flip($editorHandler->getList()),
    'default'     => 'dhtmltextarea',
    'category'    => 'editor',
];
$modversion['config'][] = [
    'name'        => 'memberslist_configs',
    'title'       => '_MI_SUICO_CONFIG_MEMBER_LIST',
    'description' => '_MI_SUICO_CONFIG_MEMBER_LIST',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'displaywelcomemessage',
    'title'       => '_MI_SUICO_MEMBER_LIST_DISPLAYWELCOMEMSG',
    'description' => '_MI_SUICO_MEMBER_LIST_DISPLAYWELCOMEMSG_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberslist',
];
$modversion['config'][] = [
    'name'        => 'welcomemessage',
    'title'       => '_MI_SUICO_MEMBER_LIST_WELCOMEMSG',
    'description' => '_MI_SUICO_MEMBER_LIST_WELCOMEMSGDSC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => _MI_SUICO_MEMBER_LIST_DEFAULTWELCOMEMSG,
    'category'    => 'memberslist',
];
$modversion['config'][] = [
    'name'        => 'displaylatestmember',
    'title'       => '_MI_SUICO_MEMBER_LIST_LATESTMEMBER',
    'description' => '_MI_SUICO_MEMBER_LIST_LATESTMEMBER_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberslist',
];
$modversion['config'][] = [
    'name'        => 'membersperpage',
    'title'       => '_MI_SUICO_MEMBER_LIST_MPAGE',
    'description' => '_MI_SUICO_MEMBER_LIST_MPAGE_DSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 15,
    'category'    => 'memberslist',
];
$modversion['config'][] = [
    'name'        => 'sortmembers',
    'title'       => '_MI_SUICO_MEMBER_LIST_SORT',
    'description' => '_MI_SUICO_MEMBER_LIST_SORT_DSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'uname',
    'options'     => [
        _MI_SUICO_UNAME     => 'uname',
        _MI_SUICO_REALNAME  => 'name',
        _MI_SUICO_LASTLOGIN => 'last_login',
        _MI_SUICO_REGDATE   => 'user_regdate',
        _MI_SUICO_POSTS     => 'posts',
    ],
    'category'    => 'memberslist',
];
$modversion['config'][] = [
    'name'        => 'membersorder',
    'title'       => '_MI_SUICO_MEMBER_LIST_ORDER',
    'description' => '_MI_SUICO_MEMBER_LIST_ORDER_DSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'ASC',
    'options'     => [
        _MI_SUICO_ASCORDER  => 'ASC',
        _MI_SUICO_DESCORDER => 'DESC',
    ],
    'category'    => 'memberslist',
];
$modversion['config'][] = [
    'name'        => 'memberslisttemplate',
    'title'       => '_MI_SUICO_MEMBER_LIST_TEMPSTYLE',
    'description' => '_MI_SUICO_MEMBER_LIST_TEMPSTYLE_DSC',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'datatables',
    'options'     => [
        _MI_SUICO_DATATABLESBASICTEMPLATE => 'datatables',
        _MI_SUICO_TEMPLATE_NORMAL         => 'normal',
    ],
    'category'    => 'memberslist',
];
// group header
$modversion['config'][] = [
    'name'        => 'memberslistsearch_configs',
    'title'       => '_MI_SUICO_CONFIG_MEMBER_LIST_SEARCH',
    'description' => '_MI_SUICO_CONFIG_MEMBER_LIST_SEARCH',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'even',
    'category'    => 'group_header',
];
$modversion['config'][] = [
    'name'        => 'displaytotalmember',
    'title'       => '_MI_SUICO_DISPLAYTOTALMEMBER',
    'description' => '_MI_SUICO_DISPLAYTOTALMEMBER_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayavatar',
    'title'       => '_MI_SUICO_DISPLAYAVATAR',
    'description' => '_MI_SUICO_DISPLAYAVATAR_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayrealname',
    'title'       => '_MI_SUICO_DISPLAYREALNAME',
    'description' => '_MI_SUICO_DISPLAYREALNAME_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayemail',
    'title'       => '_MI_SUICO_DISPLAYEMAIL',
    'description' => '_MI_SUICO_DISPLAYEMAIL_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displaypm',
    'title'       => '_MI_SUICO_DISPLAYPM',
    'description' => '_MI_SUICO_DISPLAYPM_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayurl',
    'title'       => '_MI_SUICO_DISPLAYURL',
    'description' => '_MI_SUICO_DISPLAYURL_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayregdate',
    'title'       => '_MI_SUICO_DISPLAYREGDATE',
    'description' => '_MI_SUICO_DISPLAYREGDATE_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayfrom',
    'title'       => '_MI_SUICO_DISPLAYFROM',
    'description' => '_MI_SUICO_DISPLAYFROM_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayposts',
    'title'       => '_MI_SUICO_DISPLAYPOSTS',
    'description' => '_MI_SUICO_DISPLAYPOSTS_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displaylastlogin',
    'title'       => '_MI_SUICO_DISPLAYLASTLOGIN',
    'description' => '_MI_SUICO_DISPLAYLASTLOGIN_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayoccupation',
    'title'       => '_MI_SUICO_DISPLAYOCC',
    'description' => '_MI_SUICO_DISPLAYOCC_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayinterest',
    'title'       => '_MI_SUICO_DISPLAYINTEREST',
    'description' => '_MI_SUICO_DISPLAYINTEREST_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayextrainfo',
    'title'       => '_MI_SUICO_DISPLAYBIO',
    'description' => '_MI_SUICO_DISPLAYBIO_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayonlinestatus',
    'title'       => '_MI_SUICO_DISPLAYONLINESTATUS',
    'description' => '_MI_SUICO_DISPLAYONLINESTATUS_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displaysignature',
    'title'       => '_MI_SUICO_DISPLAYSIGNATURE',
    'description' => '_MI_SUICO_DISPLAYSIGNATURE_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displayrank',
    'title'       => '_MI_SUICO_DISPLAYRANK',
    'description' => '_MI_SUICO_DISPLAYRANK_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
$modversion['config'][] = [
    'name'        => 'displaygroups',
    'title'       => '_MI_SUICO_DISPLAYGROUPS',
    'description' => '_MI_SUICO_DISPLAYGROUPS_DSC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'memberlistsearch',
];
// group header
$modversion['config'][] = [
    'name'        => 'admin_config',
    'title'       => '_MI_SUICO_CONFIG_ADMIN',
    'description' => '_MI_SUICO_CONFIG_ADMINDSC',
    'formtype'    => 'line_break',
    'valuetype'   => 'textbox',
    'default'     => 'odd',
    'category'    => 'group_header',
];
// -------------- Get Admin groups --------------
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('group_type', 'Admin'));
/** @var \XoopsMemberHandler $memberHandler */
$memberHandler    = xoops_getHandler('member');
$adminXoopsGroups = $memberHandler->getGroupList($criteria);
foreach ($adminXoopsGroups as $key => $adminGroup) {
    $admin_groups[$adminGroup] = $key;
}
$modversion['config'][] = [
    'name'        => 'admin_groups',
    'title'       => 'MI_SUICO_ADMINGROUPS',
    'description' => 'MI_SUICO_ADMINGROUPS_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'options'     => $admin_groups,
    'default'     => $admin_groups,
    'category'    => 'admin',
];
// Truncate Max. length
$modversion['config'][] = [
    'name'        => 'truncatelength',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'TRUNCATE_LENGTH',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'TRUNCATE_LENGTH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 100,
];
/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'admin',
];
/**
 * Show Developer Tools?
 */
$modversion['config'][]  = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
    'category'    => 'admin',
];
$modversion['templates'] = [
    ['file' => 'admin/suico_admin_about.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_audios.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_configs.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_friendrequest.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_friendships.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_groups.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_help.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_images.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_notes.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_privacy.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_relgroupuser.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_suspensions.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_videos.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_visitors.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_fieldslist.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_fieldscategory.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_fieldspermission.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_fieldsvisibility.tpl', 'description' => ''],
    ['file' => 'admin/suico_admin_registrationstep.tpl', 'description' => ''],
    ['file' => 'suico_form.tpl', 'description' => ''],
    ['file' => 'suico_register.tpl', 'description' => ''],
    ['file' => 'suico_changepass.tpl', 'description' => ''],
    ['file' => 'suico_editprofile.tpl', 'description' => ''],
    ['file' => 'suico_avatar.tpl', 'description' => ''],
    ['file' => 'suico_email.tpl', 'description' => ''],
    ['file' => 'blocks/suico_block_friends.tpl', 'description' => ''],
    ['file' => 'blocks/suico_block_hotfriends.tpl', 'description' => ''],
    ['file' => 'blocks/suico_block_hottest.tpl', 'description' => ''],
    ['file' => 'blocks/suico_block_lastpictures.tpl', 'description' => ''],
    ['file' => 'suico_search.tpl', 'description' => ''],
    ['file' => 'suico_results.tpl', 'description' => ''],
    ['file' => 'suico_album.tpl', 'description' => _MI_SUICO_TEMPLATE_ALBUMDESC],
    ['file' => 'suico_audios.tpl', 'description' => _MI_SUICO_TEMPLATE_AUDIOSDESC],
    ['file' => 'suico_configs.tpl', 'description' => _MI_SUICO_TEMPLATE_CONFIGSDESC],
    ['file' => 'suico_editgroup.tpl', 'description' => _MI_SUICO_TEMPLATE_EDITGROUP],
    ['file' => 'suico_fans.tpl', 'description' => _MI_SUICO_TEMPLATE_FANS],
    ['file' => 'suico_footer.tpl', 'description' => _MI_SUICO_TEMPLATE_FOOTERDESC],
    ['file' => 'suico_friends.tpl', 'description' => _MI_SUICO_TEMPLATE_FRIENDSDESC],
    ['file' => 'suico_group.tpl', 'description' => _MI_SUICO_TEMPLATE_GROUPDESC],
    ['file' => 'suico_groups.tpl', 'description' => _MI_SUICO_TEMPLATE_GROUPSDESC],
    ['file' => 'suico_groups_results.tpl', 'description' => _MI_SUICO_TEMPLATE_SEARCHRESULTDESC],
    ['file' => 'suico_index.tpl', 'description' => _MI_SUICO_TEMPLATE_INDEXDESC],
    ['file' => 'suico_memberslist_datatables.tpl', 'description' => _MI_SUICO_TEMPLATE_MEMBERSDESC],
    ['file' => 'suico_memberslist_normal.tpl', 'description' => _MI_SUICO_TEMPLATE_MEMBERSDESC],
    ['file' => 'suico_navbar.tpl', 'description' => _MI_SUICO_TEMPLATE_NAVBARDESC],
    ['file' => 'suico_notebook.tpl', 'description' => _MI_SUICO_TEMPLATE_NOTEBOOKDESC],
    ['file' => 'suico_notifications.tpl', 'description' => _MI_SUICO_TEMPLATE_NOTIFICATIONS],
    ['file' => 'suico_searchform.tpl', 'description' => _MI_SUICO_TEMPLATE_SEARCHFORMDESC],
    ['file' => 'suico_searchresults.tpl', 'description' => _MI_SUICO_TEMPLATE_SEARCHRESULTSDESC],
    ['file' => 'suico_user.tpl', 'description' => _MI_SUICO_TEMPLATE_USERDESC],
    ['file' => 'suico_videos.tpl', 'description' => _MI_SUICO_TEMPLATE_VIDEOSDESC],
];
global $xoopsModule;
if (is_object($xoopsModule) && $xoopsModule->dirname() === $modversion['dirname']) {
    $moduleHandler = xoops_getHandler('module');
    $moduleSuico   = $moduleHandler->getByDirname('suico');
    /** @var \XoopsConfigHandler $confHandler */
    $confHandler  = xoops_getHandler('config');
    $moduleConfig = $confHandler->getConfigsByCat(0, $moduleSuico->getVar('mid'));
    if ($GLOBALS['xoopsUser']) {
        $modversion['sub'][0]['name'] = _MI_SUICO_MYPROFILE;
        $modversion['sub'][0]['url']  = 'index.php';
        if (1 === $moduleConfig['enable_notes']) {
            $modversion['sub'][1]['name'] = _MI_SUICO_MYNOTES;
            $modversion['sub'][1]['url']  = 'notebook.php';
        }
        if (1 === $moduleConfig['enable_pictures']) {
            $modversion['sub'][2]['name'] = _MI_SUICO_MYPICTURES;
            $modversion['sub'][2]['url']  = 'album.php';
        }
        if (1 === $moduleConfig['enable_audio']) {
            $modversion['sub'][3]['name'] = _MI_SUICO_MYAUDIOS;
            $modversion['sub'][3]['url']  = 'audios.php';
        }
        if (1 === $moduleConfig['enable_videos']) {
            $modversion['sub'][4]['name'] = _MI_SUICO_MYVIDEOS;
            $modversion['sub'][4]['url']  = 'videos.php';
        }
        if (1 === $moduleConfig['enable_friends']) {
            $modversion['sub'][5]['name'] = _MI_SUICO_MYFRIENDS;
            $modversion['sub'][5]['url']  = 'friends.php';
        }
        if (1 === $moduleConfig['enable_groups']) {
            $modversion['sub'][6]['name'] = _MI_SUICO_MYGROUPS;
            $modversion['sub'][6]['url']  = 'groups.php';
        }
    }
}
if ($GLOBALS['xoopsUser']) {
    $modversion['sub'][7]['name']  = _MI_SUICO_MYCONFIGS;
    $modversion['sub'][7]['url']   = 'configs.php';
    $modversion['sub'][8]['name']  = _MI_SUICO_EDITPROFILE;
    $modversion['sub'][8]['url']   = 'edituser.php';
    $modversion['sub'][9]['name']  = _MI_SUICO_CHANGEPASS;
    $modversion['sub'][9]['url']   = 'changepass.php';
    $modversion['sub'][10]['name'] = _MI_SUICO_CHANGEAVATAR;
    $modversion['sub'][10]['url']  = 'edituser.php?op=avatarform';
}
$modversion['sub'][11]['name'] = _MI_SUICO_MEMBERSLIST;
$modversion['sub'][11]['url']  = 'memberslist.php';
if ($GLOBALS['xoopsUser']) {
    $modversion['sub'][12]['name'] = _MI_SUICO_SEARCH;
    $modversion['sub'][12]['url']  = 'searchmembers.php';
}
$modversion['hasComments']          = 1;
$modversion['comments']['itemName'] = 'group_id';
$modversion['comments']['pageName'] = 'group.php';
// Search
$modversion['hasSearch']      = 0; //disabled for version 3.0 will come back in a next release
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'suico_search';
//Notifications
$modversion['hasNotification']                               = 1;
$modversion['notification']['category'][1]['name']           = 'picture';
$modversion['notification']['category'][1]['title']          = _MI_SUICO_PICTURE_NOTIFYTIT;
$modversion['notification']['category'][1]['description']    = _MI_SUICO_PICTURE_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = 'album.php';
$modversion['notification']['category'][1]['item_name']      = 'uid';
$modversion['notification']['category'][1]['allow_bookmark'] = 1;
$modversion['notification']['event'][1]['name']              = 'new_picture';
$modversion['notification']['event'][1]['category']          = 'picture';
$modversion['notification']['event'][1]['title']             = _MI_SUICO_PICTURE_NEWPIC_NOTIFY;
$modversion['notification']['event'][1]['caption']           = _MI_SUICO_PICTURE_NEWPIC_NOTIFYCAP;
$modversion['notification']['event'][1]['description']       = _MI_SUICO_PICTURE_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template']     = 'picture_newpic_notify';
$modversion['notification']['event'][1]['mail_subject']      = _MI_SUICO_PICTURE_NEWPIC_NOTIFYSBJ;
$modversion['notification']['category'][2]['name']           = 'video';
$modversion['notification']['category'][2]['title']          = _MI_SUICO_VIDEO_NOTIFYTIT;
$modversion['notification']['category'][2]['description']    = _MI_SUICO_VIDEO_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'videos.php';
$modversion['notification']['category'][2]['item_name']      = 'uid';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;
$modversion['notification']['event'][2]['name']              = 'new_video';
$modversion['notification']['event'][2]['category']          = 'video';
$modversion['notification']['event'][2]['title']             = _MI_SUICO_VIDEO_NEWVIDEO_NOTIFY;
$modversion['notification']['event'][2]['caption']           = _MI_SUICO_VIDEO_NEWVIDEO_NOTIFYCAP;
$modversion['notification']['event'][2]['description']       = _MI_SUICO_VIDEO_NEWVIDEO_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template']     = 'video_newvideo_notify';
$modversion['notification']['event'][2]['mail_subject']      = _MI_SUICO_VIDEO_NEWVIDEO_NOTIFYSBJ;
$modversion['notification']['category'][3]['name']           = 'Note';
$modversion['notification']['category'][3]['title']          = _MI_SUICO_NOTE_NOTIFYTIT;
$modversion['notification']['category'][3]['description']    = _MI_SUICO_NOTE_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'notebook.php';
$modversion['notification']['category'][3]['item_name']      = 'uid';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;
$modversion['notification']['event'][3]['name']              = 'new_Note';
$modversion['notification']['event'][3]['category']          = 'Note';
$modversion['notification']['event'][3]['title']             = _MI_SUICO_NOTE_NEWNOTE_NOTIFY;
$modversion['notification']['event'][3]['caption']           = _MI_SUICO_NOTE_NEWNOTE_NOTIFYCAP;
$modversion['notification']['event'][3]['description']       = _MI_SUICO_NOTE_NEWNOTE_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template']     = 'note_newnote_notify';
$modversion['notification']['event'][3]['mail_subject']      = _MI_SUICO_NOTE_NEWNOTE_NOTIFYSBJ;
$modversion['notification']['category'][4]['name']           = 'friendship';
$modversion['notification']['category'][4]['title']          = _MI_SUICO_FRIENDSHIP_NOTIFYTIT;
$modversion['notification']['category'][4]['description']    = _MI_SUICO_FRIENDSHIP_NOTIFYDSC;
$modversion['notification']['category'][4]['subscribe_from'] = 'friends.php';
$modversion['notification']['category'][4]['item_name']      = 'uid';
$modversion['notification']['category'][4]['allow_bookmark'] = 0;
$modversion['notification']['event'][4]['name']              = 'new_friendship';
$modversion['notification']['event'][4]['category']          = 'friendship';
$modversion['notification']['event'][4]['title']             = _MI_SUICO_FRIEND_NEWFRIENDREQUEST_NOTIFY;
$modversion['notification']['event'][4]['caption']           = _MI_SUICO_FRIEND_NEWFRIENDREQUEST_NOTIFYCAP;
$modversion['notification']['event'][4]['description']       = _MI_SUICO_FRIEND_NEWFRIENDREQUEST_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template']     = 'friendship_newFriendrequest_notify';
$modversion['notification']['event'][4]['mail_subject']      = _MI_SUICO_FRIEND_NEWFRIENDREQUEST_NOTIFYSBJ;
$modversion['notification']['lookup_file']                   = 'include/notification.inc.php';
$modversion['notification']['lookup_func']                   = 'suico_iteminfo';
//$modversion['notification']['tags_file'] = 'include/notification.inc.php';
//$modversion['notification']['tags_func'] = 'suico_tags';
$modversion['blocks'][] = [
    'file'        => 'friends_block.php',
    'name'        => _MI_SUICO_FRIENDS,
    'description' => _MI_SUICO_FRIENDS_DESC,
    'show_func'   => 'b_suico_friends_show',
    'options'     => '8|0',
    'edit_func'   => 'b_suico_friends_edit',
    'template'    => 'suico_block_friends.tpl',
];
$modversion['blocks'][] = [
    'file'        => 'photos_block.php',
    'name'        => _MI_SUICO_LAST,
    'description' => _MI_SUICO_LAST_DESC,
    'show_func'   => 'b_suico_lastpictures_show',
    'options'     => '1|0|0|1|8',
    'edit_func'   => 'b_suico_lastpictures_edit',
    'template'    => 'suico_block_lastpictures.tpl',
];
