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
    VideoController
};

$GLOBALS['xoopsOption']['template_main'] = 'suico_videos.tpl';
require __DIR__ . '/header.php';
$controller = new VideoController($xoopsDB, $xoopsUser);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
$start      = Request::getInt('start', 0, 'GET');
/**
 * Criteria for Videos
 */
$criteriaUidVideo = new Criteria('uid_owner', $controller->uidOwner);
$criteriaUidVideo->setStart($start);
$criteriaUidVideo->setLimit($helper->getConfig('videosperpage'));
/**
 * Get all videos of this user and assign them to template
 */
$videos      = $controller->getVideos($criteriaUidVideo);
$videosArray = [];
$pageNav     = '';
if (isset($nbSections['countVideos'])) {
    $videosArray = $controller->assignVideoContent($nbSections['countVideos'], $videos);
}
if (is_array($videosArray)) {
    $xoopsTpl->assign('videos', $videosArray);
} else {
    $xoopsTpl->assign('lang_novideoyet', _MD_SUICO_NOVIDEOSYET);
}
$xoopsTpl->assign('lang_selectfeaturedvideo', _MD_SUICO_SELECTFEATUREDVIDEO);
if (isset($nbSections['countVideos']) && $nbSections['countVideos'] > 0) {
    $pageNav = $controller->videosNavBar($nbSections['countVideos'], $helper->getConfig('videosperpage'), $start, 2);
}
//form actions
$xoopsTpl->assign('lang_delete', _MD_SUICO_DELETE);
$xoopsTpl->assign('lang_editvideo', _MD_SUICO_EDIT_VIDEO);
$xoopsTpl->assign('lang_featurethisvideo', _MD_SUICO_FEATURETHISVIDEO);
//FORM SUBMIT
$xoopsTpl->assign('lang_addvideos', _MD_SUICO_ADDFAVORITEVIDEOS);
$xoopsTpl->assign('lang_youtubecodeLabel', _MD_SUICO_YOUTUBECODE);
$xoopsTpl->assign('lang_captionLabel', _MD_SUICO_CAPTION);
$xoopsTpl->assign('lang_submitValue', _MD_SUICO_ADDVIDEO);
$xoopsTpl->assign('width', $helper->getConfig('width_tube'));
$xoopsTpl->assign('height', $helper->getConfig('height_tube'));
$xoopsTpl->assign('lang_videohelp', _MD_SUICO_ADDVIDEOSHELP);
$xoopsTpl->assign('lang_mysection', _MD_SUICO_MYVIDEOS);
$xoopsTpl->assign('section_name', _MD_SUICO_VIDEOS);
//Navigation
$xoopsTpl->assign('pageNav', $pageNav);
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
