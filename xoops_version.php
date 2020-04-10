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
$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

// ------------------- Informations ------------------- //
$modversion = [
    'version'             => 3.5,
    'module_status'       => 'Alpha 4',
    'release_date'        => '2020/04/05',
    'name'                => _MI_YOGURT_MODULE_NAME,
    'description'         => _MI_YOGURT_MODULEDESC,
    'official'            => 0,
    //1 indicates official XOOPS module supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'Marcello Brandao',
    'credits'             => 'XOOPS Development Team, The ImpressCMS Project, Jquery Lightbox, Komeia, vaughan,',
    'author_mail'         => 'author-email',
    'author_website_url'  => 'https://xoops.org',
    'author_website_name' => 'XOOPS',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    'help'                => 'page=help',
    // ------------------- Folders & Files -------------------
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . "/modules/$moduleDirName/docs/changelog.txt",

    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/$moduleDirName/docs/install.txt",
    // images
    'image'               => 'assets/images/logoModule.png',
    'iconsmall'           => 'assets/images/iconsmall.png',
    'iconbig'             => 'assets/images/iconbig.png',
    'dirname'             => $moduleDirName,
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb/viewforum.php?forum=28/',
    'support_name'        => 'Support Forum',
    'submit_bug'          => 'https://github.com/XoopsModules25x/' . $moduleDirName . '/issues',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // ------------------- Min Requirements -------------------
    'min_php'             => '7.1',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5'],
    // ------------------- Admin Menu -------------------
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // ------------------- Main Menu -------------------
    'hasMain'             => 1,
    'sub'                 => [
        [
            'name' => _MI_YOGURT_SEARCH,
            'url'  => 'searchmembers.php',
        ],
        [
            'name' => _MI_YOGURT_MYPROFILE,
            'url'  => 'index.php',
        ],
    ],

    // ------------------- Install/Update -------------------
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php',
    'onUninstall'         => 'include/onuninstall.php',
    // -------------------  PayPal ---------------------------
    'paypal'              => [
        'business'      => 'xoopsfoundation@gmail.com',
        'item_name'     => 'Donation : ' . _MI_YOGURT_MODULE_NAME,
        'amount'        => 0,
        'currency_code' => 'USD',
    ],
    // ------------------- Mysql -----------------------------
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables'              => [
        $moduleDirName . '_' . 'friendpetition',
        $moduleDirName . '_' . 'friendship',
        $moduleDirName . '_' . 'images',
        $moduleDirName . '_' . 'visitors',
        $moduleDirName . '_' . 'video',
        $moduleDirName . '_' . 'relgroupuser',
        $moduleDirName . '_' . 'groups',
        $moduleDirName . '_' . 'notes',
        $moduleDirName . '_' . 'configs',
        $moduleDirName . '_' . 'suspensions',
        $moduleDirName . '_' . 'audio',
    ],
];

// ------------------- Help files ------------------- //
$modversion['helpsection'] = [
    ['name' => _MI_YOGURT_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_YOGURT_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_YOGURT_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_YOGURT_SUPPORT, 'link' => 'page=support'],
];

// SX Updater/Installer
$modversion['simpleversion'] = '3.4';
$modversion['simplename']    = 'yogurt';
$modversion['simpleid']      = 22;

//Adicionado para rodar no about
$modversion['developer_website_url']  = 'https://sourceforge.net/projects/galeriayogurt/';
$modversion['developer_website_name'] = 'Sourceforge - galeriayogurt';
$modversion['developer_email']        = 'marcello.brandao@gmail.com';
$modversion['status_version']         = 'Beta';
$modversion['status']                 = 'Beta';
$modversion['date']                   = '2017-11-11';

$modversion['people']['developers'][] = 'Suico (Dev)';
$modversion['people']['developers'][] = 'Alfred (Dev)';
$modversion['people']['developers'][] = 'm0nty_ (Dev)';
$modversion['people']['developers'][] = 'sato-san (Design)';

$modversion['people']['testers'][] = 'Luix (xoopstotal.com.br)';
$modversion['people']['testers'][] = 'BoOot (xoopstotal.com.br)';
$modversion['people']['testers'][] = 'Rodrigo (komeia)';
$modversion['people']['testers'][] = 'Casar Felipe (komeia)';

$modversion['people']['translators'][] = 'Wizanda (english)';
$modversion['people']['translators'][] = 'Daniel Woo (simplified chinese)';
$modversion['people']['translators'][] = 'Werner Feichtlbauer (german)';
$modversion['people']['translators'][] = 'Francesco (italian)';
$modversion['people']['translators'][] = 'Erik Philippe (french)';
//$modversion['people']['documenters'][] = "documenter 1";

$modversion['people']['other'][] = 'Komeia (patrocanio)';

$modversion['demo_site_url']     = 'http://www.marcellobrandao.eti.br';
$modversion['demo_site_name']    = 'Marcello Brandao Site';
$modversion['support_site_url']  = 'http://sourceforge.net/projects/galeriayogurt/';
$modversion['support_site_name'] = 'Sourceforge';
$modversion['submit_bug']        = 'http://sourceforge.net/tracker/?func=add&group_id=204109&atid=988288';
$modversion['submit_feature']    = 'http://sourceforge.net/tracker/?func=add&group_id=204109&atid=988291';

//$modversion['config'][1]['valuetype'] = 'int';
//can be 'int', 'float', 'textarea' or 'array'. All items with formtype 'multi_xxx' must have the valuetype 'array'

xoops_load('xoopseditorhandler');
$editorHandler          = \XoopsEditorHandler::getInstance();
$modversion['config'][] = [
    'name'        => 'yogurtEditorAdmin',
    'title'       => 'MI_YOGURT_EDITOR_ADMIN',
    'description' => 'MI_YOGURT_EDITOR_DESC_ADMIN',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => array_flip($editorHandler->getList()),
    'default'     => 'tinymce',
];

$modversion['config'][] = [
    'name'        => 'yogurtEditorUser',
    'title'       => 'MI_YOGURT_EDITOR_USER',
    'description' => 'MI_YOGURT_EDITOR_DESC_USER',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => array_flip($editorHandler->getList()),
    'default'     => 'dhtmltextarea',
];

// -------------- Get Admin groups --------------
$criteria = new \CriteriaCompo ();
$criteria->add(new \Criteria ('group_type', 'Admin'));
/** @var \XoopsMemberHandler $memberHandler */
$memberHandler    = xoops_getHandler('member');
$adminXoopsGroups = $memberHandler->getGroupList($criteria);
foreach ($adminXoopsGroups as $key => $adminGroup) {
    $admin_groups[$adminGroup] = $key;
}
$modversion['config'][] = [
    'name'        => 'admin_groups',
    'title'       => 'MI_YOGURT_ADMINGROUPS',
    'description' => 'MI_YOGURT_ADMINGROUPS_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'options'     => $admin_groups,
    'default'     => $admin_groups,
];

// --------------Uploads : mimetypes of image --------------
$modversion['config'][] = [
    'name'        => 'mimetypes',
    'title'       => 'MI_YOGURT_MIMETYPES',
    'description' => 'MI_YOGURT_MIMETYPES_DESC',
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
];

$modversion['config'][] = [
    'name'        => 'enable_pictures',
    'title'       => '_MI_YOGURT_ENABLEPICT_TITLE',
    'description' => '_MI_YOGURT_ENABLEPICT_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'nb_pict',
    'title'       => '_MI_YOGURT_NUMBPICT_TITLE',
    'description' => '_MI_YOGURT_NUMBPICT_DESC',
    'default'     => 12,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

/*
 $modversion['config'][] = [
'name' =>  'path_upload',
'title' =>  '_MI_YOGURT_PATHUPLOAD_TITLE',
'description' =>  '_MI_YOGURT_PATHUPLOAD_DESC',
'default' =>  XOOPS_ROOT_PATH."/uploads/",
'formtype' =>  'textbox',
'valuetype' =>  'text',
];

$modversion['config'][] = [
'name' =>  'link_path_upload',
'title' =>  '_MI_YOGURT_LINKPATHUPLOAD_TITLE',
'description' =>  '_MI_YOGURT_LINKPATHUPLOAD_DESC',
'default' =>  XOOPS_UPLOAD_URL,
'formtype' =>  'textbox',
'valuetype' =>  'text',
];
*/

$modversion['config'][] = [
    'name'        => 'groupslogo_width',
    'title'       => '_MI_YOGURT_GROUPS_LOGO_WIDTH',
    'description' => '_MI_YOGURT_GROUPS_LOGO_WIDTH_DESC',
    'default'     => 125,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'groupslogo_height',
    'title'       => '_MI_YOGURT_GROUPS_LOGO_HEIGHT',
    'description' => '_MI_YOGURT_GROUPS_LOGO_HEIGHT_DESC',
    'default'     => 80,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'thumb_width',
    'title'       => '_MI_YOGURT_THUMW_TITLE',
    'description' => '_MI_YOGURT_THUMBW_DESC',
    'default'     => 125,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'thumb_height',
    'title'       => '_MI_YOGURT_THUMBH_TITLE',
    'description' => '_MI_YOGURT_THUMBH_DESC',
    'default'     => 175,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'resized_width',
    'title'       => '_MI_YOGURT_RESIZEDW_TITLE',
    'description' => '_MI_YOGURT_RESIZEDW_DESC',
    'default'     => 650,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'resized_height',
    'title'       => '_MI_YOGURT_RESIZEDH_TITLE',
    'description' => '_MI_YOGURT_RESIZEDH_DESC',
    'default'     => 450,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'max_original_width',
    'title'       => '_MI_YOGURT_ORIGINALW_TITLE',
    'description' => '_MI_YOGURT_ORIGINALW_DESC',
    'default'     => 2048,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'max_original_height',
    'title'       => '_MI_YOGURT_ORIGINALH_TITLE',
    'description' => '_MI_YOGURT_ORIGINALH_DESC',
    'default'     => 1600,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'maxfilesize',
    'title'       => '_MI_YOGURT_MAXFILEBYTES_TITLE',
    'description' => '_MI_YOGURT_MAXFILEBYTES_DESC',
    'default'     => 512000,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'picturesperpage',
    'title'       => '_MI_YOGURT_PICTURESPERPAGE_TITLE',
    'description' => '_MI_YOGURT_PICTURESPERPAGE_DESC',
    'default'     => 6,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'physical_delete',
    'title'       => '_MI_YOGURT_DELETEPHYSICAL_TITLE',
    'description' => '_MI_YOGURT_DELETEPHYSICAL_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'images_order',
    'title'       => '_MI_YOGURT_IMGORDER_TITLE',
    'description' => '_MI_YOGURT_IMGORDER_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'enable_friends',
    'title'       => '_MI_YOGURT_ENABLEFRIENDS_TITLE',
    'description' => '_MI_YOGURT_ENABLEFRIENDS_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'friendsperpage',
    'title'       => '_MI_YOGURT_FRIENDSPERPAGE_TITLE',
    'description' => '_MI_YOGURT_FRIENDSPERPAGE_DESC',
    'default'     => 12,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'enable_friendsevaluation',
    'title'       => '_MI_YOGURT_ENABLEFRIENDSEVALUATION_TITLE',
    'description' => '_MI_YOGURT_ENABLEFRIENDSEVALUATION_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'enable_audio',
    'title'       => '_MI_YOGURT_ENABLEAUDIO_TITLE',
    'description' => '_MI_YOGURT_ENABLEAUDIO_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'nb_audio',
    'title'       => '_MI_YOGURT_NUMBAUDIO_TITLE',
    'description' => '_MI_YOGURT_NUMBAUDIO_DESC',
    'default'     => 12,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'audiosperpage',
    'title'       => '_MI_YOGURT_AUDIOSPERPAGE_TITLE',
    'description' => '_MI_YOGURT_AUDIOSPERPAGE_DESC',
    'default'     => 20,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'enable_videos',
    'title'       => '_MI_YOGURT_ENABLEVIDEOS_TITLE',
    'description' => '_MI_YOGURT_ENABLEVIDEOS_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'videosperpage',
    'title'       => '_MI_YOGURT_VIDEOSPERPAGE_TITLE',
    'description' => '_MI_YOGURT_VIDEOSPERPAGE_DESC',
    'default'     => 6,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'width_tube',
    'title'       => '_MI_YOGURT_TUBEW_TITLE',
    'description' => '_MI_YOGURT_TUBEW_DESC',
    'default'     => 450,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'height_tube',
    'title'       => '_MI_YOGURT_TUBEH_TITLE',
    'description' => '_MI_YOGURT_TUBEH_DESC',
    'default'     => 350,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'width_maintube',
    'title'       => '_MI_YOGURT_MAINTUBEW_TITLE',
    'description' => '_MI_YOGURT_MAINTUBEW_DESC',
    'default'     => 250,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'height_maintube',
    'title'       => '_MI_YOGURT_MAINTUBEH_TITLE',
    'description' => '_MI_YOGURT_MAINTUBEH_DESC',
    'default'     => 210,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'enable_groups',
    'title'       => '_MI_YOGURT_ENABLEGROUPS_TITLE',
    'description' => '_MI_YOGURT_ENABLEGROUPS_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'groupsperpage',
    'title'       => '_MI_YOGURT_GROUPSPERPAGE_TITLE',
    'description' => '_MI_YOGURT_GROUPSPERPAGE_DESC',
    'default'     => 6,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'enable_notes',
    'title'       => '_MI_YOGURT_ENABLENOTES_TITLE',
    'description' => '_MI_YOGURT_ENABLENOTES_DESC',
    'default'     => 1,
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
];

$modversion['config'][] = [
    'name'        => 'notesperpage',
    'title'       => '_MI_YOGURT_NOTESPERPAGE_TITLE',
    'description' => '_MI_YOGURT_NOTESPERPAGE_DESC',
    'default'     => 20,
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
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
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['templates'] = [
    ['file' => 'yogurt_navbar.tpl', 'description' => _MI_YOGURT_TEMPLATENAVBARDESC],
    ['file' => 'yogurt_index.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEINDEXDESC],
    ['file' => 'yogurt_friends.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEFRIENDSDESC],
    ['file' => 'yogurt_notebook.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATENOTEBOOKDESC],
    ['file' => 'yogurt_audio.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEAUDIODESC],
    ['file' => 'yogurt_video.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATESEUTUBODESC],
    ['file' => 'yogurt_album.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEALBUMDESC],
    ['file' => 'yogurt_groups.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEGROUPSDESC],
    ['file' => 'yogurt_configs.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATECONFIGSDESC],
    ['file' => 'yogurt_footer.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEFOOTERDESC],
    ['file' => 'yogurt_editgroup.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEEDITGROUP],
    ['file' => 'yogurt_groups_results.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATESEARCHRESULTDESC],
    ['file' => 'yogurt_group.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEGROUPDESC],
    ['file' => 'yogurt_searchresults.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATESEARCHRESULTSDESC],
    ['file' => 'yogurt_searchform.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATESEARCHFORMDESC],
    ['file' => 'yogurt_notifications.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATENOTIFICATIONS],
    ['file' => 'yogurt_fans.tpl', 'description' => _MI_YOGURT_PICTURE_TEMPLATEFANS],
];

global $xoopsModule;
if (is_object($xoopsModule) && $xoopsModule->dirname() == $modversion['dirname']) {
    $moduleHandler = xoops_getHandler('module');
    $mod_yogurt    = $moduleHandler->getByDirname('yogurt');
    $confHandler   = xoops_getHandler('config');
    $moduleConfig  = $confHandler->getConfigsByCat(0, $mod_yogurt->getVar('mid'));

    if (1 == $moduleConfig['enable_notes']) {
        $modversion['sub'][3]['name'] = _MI_YOGURT_MYNOTES;
        $modversion['sub'][3]['url']  = 'notebook.php';
    }
    if (1 == $moduleConfig['enable_pictures']) {
        $modversion['sub'][4]['name'] = _MI_YOGURT_MYPICTURES;
        $modversion['sub'][4]['url']  = 'album.php';
    }
    if (1 == $moduleConfig['enable_audio']) {
        $modversion['sub'][5]['name'] = _MI_YOGURT_MYAUDIOS;
        $modversion['sub'][5]['url']  = 'audio.php';
    }
    if (1 == $moduleConfig['enable_videos']) {
        $modversion['sub'][6]['name'] = _MI_YOGURT_MYVIDEOS;
        $modversion['sub'][6]['url']  = 'video.php';
    }
    if (1 == $moduleConfig['enable_friends']) {
        $modversion['sub'][7]['name'] = _MI_YOGURT_MYFRIENDS;
        $modversion['sub'][7]['url']  = 'friends.php';
    }
    if (1 == $moduleConfig['enable_groups']) {
        $modversion['sub'][8]['name'] = _MI_YOGURT_MYGROUPS;
        $modversion['sub'][8]['url']  = 'groups.php';
    }
}
$modversion['sub'][9]['name'] = _MI_YOGURT_MYCONFIGS;
$modversion['sub'][9]['url']  = 'configs.php';

$modversion['hasComments']          = 1;
$modversion['comments']['itemName'] = 'group_id';
$modversion['comments']['pageName'] = 'group.php';

// Search
$modversion['hasSearch']      = 0; //disabled for version 3.0 will come back in a next release
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'yogurt_search';

//Notifications
$modversion['hasNotification']                               = 1;
$modversion['notification']['category'][1]['name']           = 'picture';
$modversion['notification']['category'][1]['title']          = _MI_YOGURT_PICTURE_NOTIFYTIT;
$modversion['notification']['category'][1]['description']    = _MI_YOGURT_PICTURE_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = 'album.php';
$modversion['notification']['category'][1]['item_name']      = 'uid';
$modversion['notification']['category'][1]['allow_bookmark'] = 1;
$modversion['notification']['event'][1]['name']              = 'new_picture';
$modversion['notification']['event'][1]['category']          = 'picture';
$modversion['notification']['event'][1]['title']             = _MI_YOGURT_PICTURE_NEWPIC_NOTIFY;
$modversion['notification']['event'][1]['caption']           = _MI_YOGURT_PICTURE_NEWPIC_NOTIFYCAP;
$modversion['notification']['event'][1]['description']       = _MI_YOGURT_PICTURE_NEWPOST_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template']     = 'picture_newpic_notify';
$modversion['notification']['event'][1]['mail_subject']      = _MI_YOGURT_PICTURE_NEWPIC_NOTIFYSBJ;

$modversion['notification']['category'][2]['name']           = 'video';
$modversion['notification']['category'][2]['title']          = _MI_YOGURT_VIDEO_NOTIFYTIT;
$modversion['notification']['category'][2]['description']    = _MI_YOGURT_VIDEO_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'video.php';
$modversion['notification']['category'][2]['item_name']      = 'uid';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;
$modversion['notification']['event'][2]['name']              = 'new_video';
$modversion['notification']['event'][2]['category']          = 'video';
$modversion['notification']['event'][2]['title']             = _MI_YOGURT_VIDEO_NEWVIDEO_NOTIFY;
$modversion['notification']['event'][2]['caption']           = _MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYCAP;
$modversion['notification']['event'][2]['description']       = _MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template']     = 'video_newvideo_notify';
$modversion['notification']['event'][2]['mail_subject']      = _MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYSBJ;

$modversion['notification']['category'][3]['name']           = 'Note';
$modversion['notification']['category'][3]['title']          = _MI_YOGURT_NOTE_NOTIFYTIT;
$modversion['notification']['category'][3]['description']    = _MI_YOGURT_NOTE_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'notebook.php';
$modversion['notification']['category'][3]['item_name']      = 'uid';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;
$modversion['notification']['event'][3]['name']              = 'new_Note';
$modversion['notification']['event'][3]['category']          = 'Note';
$modversion['notification']['event'][3]['title']             = _MI_YOGURT_NOTE_NEWNOTE_NOTIFY;
$modversion['notification']['event'][3]['caption']           = _MI_YOGURT_NOTE_NEWNOTE_NOTIFYCAP;
$modversion['notification']['event'][3]['description']       = _MI_YOGURT_NOTE_NEWNOTE_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template']     = 'note_newnote_notify';
$modversion['notification']['event'][3]['mail_subject']      = _MI_YOGURT_NOTE_NEWNOTE_NOTIFYSBJ;

$modversion['notification']['category'][4]['name']           = 'friendship';
$modversion['notification']['category'][4]['title']          = _MI_YOGURT_FRIENDSHIP_NOTIFYTIT;
$modversion['notification']['category'][4]['description']    = _MI_YOGURT_FRIENDSHIP_NOTIFYDSC;
$modversion['notification']['category'][4]['subscribe_from'] = 'friends.php';
$modversion['notification']['category'][4]['item_name']      = 'uid';
$modversion['notification']['category'][4]['allow_bookmark'] = 0;
$modversion['notification']['event'][4]['name']              = 'new_friendship';
$modversion['notification']['event'][4]['category']          = 'friendship';
$modversion['notification']['event'][4]['title']             = _MI_YOGURT_FRIEND_NEWPETITION_NOTIFY;
$modversion['notification']['event'][4]['caption']           = _MI_YOGURT_FRIEND_NEWPETITION_NOTIFYCAP;
$modversion['notification']['event'][4]['description']       = _MI_YOGURT_FRIEND_NEWPETITION_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template']     = 'friendship_newpetition_notify';
$modversion['notification']['event'][4]['mail_subject']      = _MI_YOGURT_FRIEND_NEWPETITION_NOTIFYSBJ;

$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'yogurt_iteminfo';
//$modversion['notification']['tags_file'] = 'include/notification.inc.php';
//$modversion['notification']['tags_func'] = 'yogurt_tags';

$modversion['blocks'][] = [
    'file'        => 'blocks.php',
    'name'        => _MI_YOGURT_FRIENDS,
    'description' => _MI_YOGURT_FRIENDS_DESC,
    'show_func'   => 'b_yogurt_friends_show',
    'options'     => '6|0',
    'edit_func'   => 'b_yogurt_friends_edit',
    'template'    => 'yogurt_block_friends.tpl',
];

$modversion['blocks'][] = [
    'file'        => 'blocks.php',
    'name'        => _MI_YOGURT_LAST,
    'description' => _MI_YOGURT_LAST_DESC,
    'show_func'   => 'b_yogurt_lastpictures_show',
    'options'     => '5',
    'edit_func'   => 'b_yogurt_lastpictures_edit',
    'template'    => 'yogurt_block_lastpictures.tpl',
];
