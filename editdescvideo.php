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
 * @package         yogurt
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use Xmf\Request;
use XoopsModules\Yogurt;

require __DIR__ . '/header.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$cod_img = Request::getInt('video_id', 0, 'POST');
$marker  = Request::getInt('marker', 0, 'POST');

$uid = (int)$xoopsUser->getVar('uid');

if (1 === $marker) {
    /**
     * Creating the factory  loading the picture changing its caption
     */
    $videoFactory = new Yogurt\VideoHandler(
        $xoopsDB
    );
    $video        = $videoFactory->create(false);
    $video->load($cod_img);
    $video->setVar('video_desc', trim(htmlspecialchars($_POST['caption'], ENT_QUOTES | ENT_HTML5)));

    /**
     * Verifying who's the owner to allow changes
     */
    if ($uid === $video->getVar('uid_owner')) {
        if ($videoFactory->insert2($video)) {
            redirect_header('videos.php?uid=' . $uid, 2, _MD_YOGURT_DESC_EDITED);
        } else {
            redirect_header('index.php?uid=' . $uid, 2, _MD_YOGURT_ERROR);
        }
    }
}
/**
 * Creating the factory  and the criteria to edit the desc of the picture
 * The user must be the owner
 */
$videoFactory   = new Yogurt\VideoHandler(
    $xoopsDB
);
$criteria_video = new Criteria('video_id', $cod_img);
$criteriaUid    = new Criteria('uid_owner', $uid);
$criteria       = new CriteriaCompo($criteria_video);
$criteria->add($criteriaUid);

/**
 * Lets fetch the info of the pictures to be able to render the form
 * The user must be the owner
 */
$array_pict = $videoFactory->getObjects(
    $criteria
);
if ($array_pict) {
    $caption = $array_pict[0]->getVar('video_desc');
    $url     = $array_pict[0]->getVar('youtube_code');
}

$videoFactory->renderFormEdit($caption, $cod_img, $url);

require dirname(__DIR__, 2) . '/footer.php';
