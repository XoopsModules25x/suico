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
    VideoHandler
};

$GLOBALS['xoopsOption']['template_main'] = 'suico_index.tpl';
require __DIR__ . '/header.php';
//require_once __DIR__ . '/class/Video.php';
/**
 * Factory of pictures created
 */
$videoFactory = new VideoHandler($xoopsDB);
$url          = Request::getUrl('videourl', '', 'POST');
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
/**
 * Try to upload picture resize it insert in database and then redirect to index
 */
$newvideo = $videoFactory->create(
    true
);
$newvideo->setVar('uid_owner', (int)$xoopsUser->getVar('uid'));
$newvideo->setVar('video_title', Request::getString('title', '', 'POST'));
$newvideo->setVar('video_desc', Request::getString('caption', '', 'POST'));

if (11 === mb_strlen($url)) {
    $code = $url;
} else {
  //Get youtube video id
	preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
	$code = $match[1];
}

$newvideo->setVar('youtube_code', $code);
$newvideo->setVar('featured_video', Request::getInt('featured_video', 0, 'POST'));
$newvideo->setVar('date_created', \time());
$newvideo->setVar('date_updated', \time());
$videoFactory->insert($newvideo);
$insertId = $xoopsDB->getInsertId();
if ($videoFactory->insert($newvideo)) {
    $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
    $extra_tags['X_OWNER_UID']  = (int)$xoopsUser->getVar('uid');
    /** @var \XoopsNotificationHandler $notificationHandler */
    $notificationHandler = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('video', (int)$xoopsUser->getVar('uid'), 'new_video', $extra_tags);
    redirect_header(
        XOOPS_URL . '/modules/suico/videos.php?uid=' . (int)$xoopsUser->getVar('uid') . '#' . $insertId,
        2,
        _MD_SUICO_VIDEOSAVED
    );
} else {
    redirect_header(
        XOOPS_URL . '/modules/suico/videos.php?uid=' . (int)$xoopsUser->getVar('uid'),
        2,
        _MD_SUICO_ERROR
    );
}
require dirname(__DIR__, 2) . '/footer.php';
