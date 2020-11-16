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
/**
 * Creating the factory  loading the video changing its caption
 */
$videoFactory = new VideoHandler(
    $xoopsDB
);
$video        = $videoFactory->create(false);
$video->load($video_id);
$video->setVar('featured_video', 1);
/**
 * Verifying who's the owner to allow changes
 */
$uid = (int)$xoopsUser->getVar('uid');
if ($uid === $video->getVar('uid_owner')) {
    if ($videoFactory->unsetAllMainsbyID($uid)) {
        if ($videoFactory->insert2($video)) {
            redirect_header('videos.php?uid=' . (int)$xoopsUser->getVar('uid') . '#' . $video_id, 2, _MD_SUICO_SETFEATUREDVIDEO);
        } else {
            redirect_header('videos.php', 2, _MD_SUICO_ERROR);
        }
    } else {
        echo 'did not work';
    }
}
require dirname(__DIR__, 2) . '/footer.php';
