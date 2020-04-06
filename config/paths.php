<?php

$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

return (object)[
    'name'        => mb_strtoupper($moduleDirName) . ' PathConfigurator',
    'paths'       => [
        'dirname'    => $moduleDirName,
        'admin'      => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/admin',
        'modPath'    => XOOPS_ROOT_PATH . '/modules/' . $moduleDirName,
        'modUrl'     => XOOPS_URL . '/modules/' . $moduleDirName,
        'uploadPath' => XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        'uploadUrl'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName,
    ],
    'uploadPaths' => [
        'yogurt'  => XOOPS_UPLOAD_PATH . '/' . $moduleDirName,
        'avatars' => XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/avatars',
        'images'  => XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        'mp3'     => XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/mp3',
        'photos'  => XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/images',
        'thumbs'  => XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/thumbs',
        'groups'  => XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/groups',
        'videos'  => XOOPS_UPLOAD_PATH . '/' . $moduleDirName . '/videos',
        //XOOPS_UPLOAD_PATH . '/flags'
    ],
    'uploadUrls'  => [
        'yogurt'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName,
        'avatars' => XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/avatars',
        'images'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/images',
        'mp3'     => XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/mp3',
        'photos'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/images',
        'thumbs'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/thumbs',
        'groups'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/groups',
        'videos'  => XOOPS_UPLOAD_URL . '/' . $moduleDirName . '/videos',
        //XOOPS_UPLOAD_PATH . '/flags'
    ],
];
