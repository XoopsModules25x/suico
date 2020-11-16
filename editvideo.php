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

require __DIR__ . '/header.php';
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
$video_id = Request::getInt('video_id', 0, 'POST');
$marker   = Request::getInt('marker', 0, 'POST');
$uid      = (int)$xoopsUser->getVar('uid');
if (1 === $marker) {
    /**
     * Creating the factory loading the video changing its caption
     */
    $videoFactory = new VideoHandler(
        $xoopsDB
    );
    $video        = $videoFactory->create(false);
    $video->load($video_id);
    $video->setVar('video_title', trim(htmlspecialchars($_POST['title'], ENT_QUOTES | ENT_HTML5)));
    $video->setVar('video_desc', trim(htmlspecialchars($_POST['caption'], ENT_QUOTES | ENT_HTML5)));
    /**
     * Verifying who's the owner to allow changes
     */
    if ($uid === $video->getVar('uid_owner')) {
        if ($videoFactory->insert2($video)) {
            redirect_header('videos.php?uid=' . $uid . '#' . $video_id, 2, _MD_SUICO_DESC_EDITED);
        } else {
            redirect_header('index.php?uid=' . $uid, 2, _MD_SUICO_ERROR);
        }
    }
}
/**
 * Creating the factory  and the criteria to edit the video
 * The user must be the owner
 */
$videoFactory   = new VideoHandler(
    $xoopsDB
);
$criteria_video = new Criteria('video_id', $video_id);
$criteriaUid    = new Criteria('uid_owner', $uid);
$criteria       = new CriteriaCompo($criteria_video);
$criteria->add($criteriaUid);
/**
 * Lets fetch the info of the video to be able to render the form
 * The user must be the owner
 */
$array_vid = $videoFactory->getObjects(
    $criteria
);
if ($array_vid) {
    $title   = $array_vid[0]->getVar('video_title');
    $caption = $array_vid[0]->getVar('video_desc');
    $url     = $array_vid[0]->getVar('youtube_code');
}
$videoFactory->renderFormEdit($title, $caption, $video_id, $url);
require dirname(__DIR__, 2) . '/footer.php';
