<?php declare(strict_types=1);

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

use Xmf\Request;
use XoopsModules\Yogurt;

require __DIR__ . '/header.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$cod_video = Request::getInt('cod_video', 0, 'POST');

if (!Request::hasVar('confirm', 'POST') || 1 !== Request::getInt('confirm', 0, 'POST')) {
    xoops_confirm(
        [
            'cod_video' => $cod_video,
            'confirm'   => 1,
        ],
        'delvideos.php',
        _MD_YOGURT_ASKCONFIRMVIDEODELETION,
        _MD_YOGURT_CONFIRMVIDEODELETION
    );
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $videoFactory = new Yogurt\VideoHandler(
        $xoopsDB
    );
    $criteria_img = new Criteria('video_id', $cod_video);
    $uid          = (int)$xoopsUser->getVar('uid');
    $criteriaUid = new Criteria('uid_owner', $uid);
    $criteria     = new CriteriaCompo($criteria_img);
    $criteria->add($criteriaUid);

    /**
     * Try to delete
     */
    if ($videoFactory->deleteAll($criteria)) {
        redirect_header('videos.php?uid=' . $uid, 2, _MD_YOGURT_VIDEO_DELETED);
    } else {
        redirect_header('videos.php?uid=' . $uid, 2, _MD_YOGURT_ERROR);
    }
}

require dirname(__DIR__, 2) . '/footer.php';
