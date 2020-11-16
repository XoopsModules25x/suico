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
    ImageHandler
};

require __DIR__ . '/header.php';
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
$image_id = Request::getInt('image_id', 0, 'POST');
$marker   = Request::getInt('marker', 0, 'POST');
$uid      = (int)$xoopsUser->getVar('uid');
if (1 === $marker) {
    /**
     * Creating the factory loading the picture changing its caption
     */
    $imageFactory = new ImageHandler(
        $xoopsDB
    );
    $picture      = $imageFactory->create(false);
    $picture->load($image_id);
    $picture->setVar('title', Request::getString('title', '', 'POST'));
    $picture->setVar('caption', Request::getString('caption', '', 'POST'));
    /**
     * Verifying who's the owner to allow changes
     */
    if ($uid === (int)$picture->getVar('uid_owner')) {
        if ($imageFactory->insert2($picture)) {
            redirect_header('album.php#' . $image_id . '', 2, _MD_SUICO_DESC_EDITED);
        } else {
            redirect_header('album.php', 2, _MD_SUICO_ERROR);
        }
    }
}
/**
 * Creating the factory  and the criteria to edit the desc of the picture
 * The user must be the owner
 */
$imageFactory = new ImageHandler(
    $xoopsDB
);
$criteria_img = new Criteria('image_id', $image_id);
$criteriaUid  = new Criteria('uid_owner', $uid);
$criteria     = new CriteriaCompo($criteria_img);
$criteria->add($criteriaUid);
/**
 * Lets fetch the info of the pictures to be able to render the form
 * The user must be the owner
 */
$array_pict = $imageFactory->getObjects(
    $criteria
);
if ($array_pict) {
    $title    = $array_pict[0]->getVar('title');
    $caption  = $array_pict[0]->getVar('caption');
    $filename = $array_pict[0]->getVar('filename');
}
//$url = $xoopsModuleConfig['link_path_upload']."/thumb_".$url;
$url = XOOPS_URL . '/uploads/suico/images/thumb_' . $filename;
$imageFactory->renderFormEdit($title, $caption, $image_id, $url);
require dirname(__DIR__, 2) . '/footer.php';
