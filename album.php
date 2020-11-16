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
    PhotosController
};

const COUNTPHOTOS = 'countPhotos';
$GLOBALS['xoopsOption']['template_main'] = 'suico_album.tpl';
require __DIR__ . '/header.php';
$controller = new PhotosController($xoopsDB, $xoopsUser);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
/**
 * This variable define the beggining of the navigation must b
 * setted here so all calls to database will take this into account
 */
$start = Request::getInt(
    'start',
    0,
    'GET'
);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
/**
 * Filter for search pictures in database
 */
if (1 === $controller->isOwner) {
    $criteriaUid = new Criteria('uid_owner', $controller->uidOwner);
} else {
    $criteria_private = new Criteria('private', 0);
    $criteriaUid2     = new Criteria('uid_owner', (int)$controller->uidOwner);
    $criteriaUid      = new CriteriaCompo($criteriaUid2);
    $criteriaUid->add($criteria_private);
}
$criteriaUid->setLimit($helper->getConfig('picturesperpage'));
$criteriaUid->setStart($start);
if (1 === $helper->getConfig('images_order')) {
    $criteriaUid->setOrder('DESC');
    $criteriaUid->setSort('image_id');
}
/**
 * Fetch pictures from factory
 */
$pictures_object_array = $controller->albumFactory->getObjects($criteriaUid);
$criteriaUid->setLimit(0);
$criteriaUid->setStart(0);
/**
 * If there is no pictures in the album show in template lang_nopicyet
 */
if (isset($nbSections[COUNTPHOTOS]) && 0 === $nbSections[COUNTPHOTOS]) {
    $nopicturesyet = _MD_SUICO_NOTHINGYET;
    $xoopsTpl->assign('lang_nopicyet', $nopicturesyet);
} else {
    /**
     * Lets populate an array with the data from the pictures
     */
    $i = 0;
    foreach ($pictures_object_array as $picture) {
        $pictures_array[$i]['filename']     = $picture->getVar('filename', 's');
        $pictures_array[$i]['title']        = $picture->getVar('title', 's');
        $pictures_array[$i]['caption']      = $picture->getVar('caption', 's');
        $pictures_array[$i]['image_id']     = $picture->getVar('image_id', 's');
        $pictures_array[$i]['private']      = $picture->getVar('private', 's');
        $pictures_array[$i]['date_created'] = formatTimestamp($picture->getVar('date_created', 's'));
        $pictures_array[$i]['date_updated'] = formatTimestamp($picture->getVar('date_updated', 's'));
        $xoopsTpl->assign('pics_array', $pictures_array);
        $i++;
    }
}
/**
 * Show the form if it is the owner and he can still upload pictures
 */
$maxfilebytes = $helper->getConfig('maxfilesize');
if (!empty($xoopsUser)) {
    if ((isset($nbSections[COUNTPHOTOS]) && 1 === $controller->isOwner) && $helper->getConfig('countPicture') > $nbSections[COUNTPHOTOS]) {
        //        $maxfilebytes = $helper->getConfig('maxfilesize');
        $xoopsTpl->assign('maxfilebytes', $maxfilebytes);
        $xoopsTpl->assign('showForm', '1');
    }
}
/**
 * Let's get the user name of the owner of the album
 */
$owner      = new \XoopsUser($controller->uidOwner);
$identifier = $owner->getVar('uname');
$avatar     = $owner->getVar('user_avatar');
/**
 * Creating the navigation bar if you have a lot of friends
 */
$countPhotos   = $nbSections[COUNTPHOTOS] ?? 0;
$navigationBar = new \XoopsPageNav(
    $countPhotos, $helper->getConfig('picturesperpage'), $start, 'start', 'uid=' . (int)$controller->uidOwner
);
$navegacao     = $navigationBar->renderImageNav(2);
//form
$xoopsTpl->assign('lang_formtitle', _MD_SUICO_SUBMIT_PIC_TITLE);
$xoopsTpl->assign('lang_selectphoto', _MD_SUICO_SELECT_PHOTO);
$xoopsTpl->assign('lang_phototitle', _MD_SUICO_PHOTOTITLE);
$xoopsTpl->assign('lang_caption', _MD_SUICO_CAPTION);
$xoopsTpl->assign('lang_uploadpicture', _MD_SUICO_UPLOADPICTURE);
$xoopsTpl->assign('lang_youcanupload', sprintf(_MD_SUICO_YOU_CAN_UPLOAD, $maxfilebytes / 1024));
//$xoopsTpl->assign('path_suico_uploads',$helper->getConfig('link_path_upload'));
$xoopsTpl->assign(
    'lang_max_countPicture',
    sprintf(_MD_SUICO_YOUCANHAVE, $helper->getConfig('countPicture'))
);
$xoopsTpl->assign('lang_delete', _MD_SUICO_DELETE);
$xoopsTpl->assign('lang_editpicture', _MD_SUICO_EDIT_PICTURE);
$xoopsTpl->assign('lang_countPicture', sprintf(_MD_SUICO_YOUHAVE, ($nbSections[COUNTPHOTOS] ?? '')));
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
$xoopsTpl->assign('navegacao', $navegacao);
$xoopsTpl->assign('lang_avatarchange', _MD_SUICO_AVATARCHANGE);
$xoopsTpl->assign('avatar_url', $avatar);
$xoopsTpl->assign('lang_setprivate', _MD_SUICO_PRIVATIZE);
$xoopsTpl->assign('lang_unsetprivate', _MD_SUICO_UNPRIVATIZE);
$xoopsTpl->assign('lang_privatephoto', _MD_SUICO_PRIVATEPHOTO);
$xoopsTpl->assign('lang_mysection', _MD_SUICO_MYPHOTOS);
$xoopsTpl->assign('section_name', _MD_SUICO_PHOTOS);
require XOOPS_ROOT_PATH . '/include/comment_view.php';
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
