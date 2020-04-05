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

use XoopsModules\Yogurt;

require __DIR__ . '/header.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$cod_img = \Xmf\Request::getInt('video_id', 0, 'POST');
$marker  = \Xmf\Request::getInt('marker', 0, 'POST');

$uid = (int)$xoopsUser->getVar('uid');

if (1 == $marker) {
    /**
     * Creating the factory  loading the picture changing its caption
     */
    $videoFactory = new Yogurt\VideoHandler($xoopsDB);
    $video        = $videoFactory->create(false);
    $video->load($cod_img);
    $video->setVar('video_desc', trim(htmlspecialchars($_POST['caption'], ENT_QUOTES | ENT_HTML5)));

    /**
     * Verifying who's the owner to allow changes
     */
    if ($uid == $video->getVar('uid_owner')) {
        if ($videoFactory->insert($video)) {
            redirect_header('video.php?uid=' . $uid, 2, _MD_YOGURT_DESC_EDITED);
        } else {
            redirect_header('index.php?uid=' . $uid, 2, _MD_YOGURT_NOCACHACA);
        }
    }
}
/**
 * Creating the factory  and the criteria to edit the desc of the picture
 * The user must be the owner
 */
$videoFactory   = new Yogurt\VideoHandler($xoopsDB);
$criteria_video = new \Criteria('video_id', $cod_img);
$criteria_uid   = new \Criteria('uid_owner', $uid);
$criteria       = new \CriteriaCompo($criteria_video);
$criteria->add($criteria_uid);

/**
 * Lets fetch the info of the pictures to be able to render the form
 * The user must be the owner
 */
$array_pict = $videoFactory->getObjects($criteria);
if ($array_pict) {
    $caption = $array_pict[0]->getVar('video_desc');
    $url     = $array_pict[0]->getVar('youtube_code');
}

$videoFactory->renderFormEdit($caption, $cod_img, $url);

require dirname(dirname(__DIR__)) . '/footer.php';
