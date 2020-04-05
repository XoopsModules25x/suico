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

$cod_video = $_POST['cod_video'];

if (1 != $_POST['confirm']) {
    xoops_confirm(['cod_video' => $cod_video, 'confirm' => 1], 'delvideo.php', _MD_YOGURT_ASKCONFIRMVIDEODELETION, _MD_YOGURT_CONFIRMVIDEODELETION);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $videoFactory = new Yogurt\VideoHandler($xoopsDB);
    $criteria_img = new \Criteria('video_id', $cod_video);
    $uid          = (int)$xoopsUser->getVar('uid');
    $criteria_uid = new \Criteria('uid_owner', $uid);
    $criteria     = new \CriteriaCompo($criteria_img);
    $criteria->add($criteria_uid);

    /**
     * Try to delete
     */
    if ($videoFactory->deleteAll($criteria)) {
        redirect_header('video.php?uid=' . $uid, 2, _MD_YOGURT_VIDEODELETED);
    } else {
        redirect_header('video.php?uid=' . $uid, 2, _MD_YOGURT_NOCACHACA);
    }
}

require dirname(dirname(__DIR__)) . '/footer.php';
