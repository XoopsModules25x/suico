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

$cod_img = $_POST['cod_img'];
$marker  = \Xmf\Request::getInt('marker', 0, 'POST');
$uid     = (int)$xoopsUser->getVar('uid');

if (1 == $marker) {
    /**
     * Creating the factory loading the picture changing its caption
     */
    $imageFactory = new Yogurt\ImageHandler($xoopsDB);
    $picture      = $imageFactory->create(false);
    $picture->load($cod_img);
    $picture->setVar('title', trim(htmlspecialchars($_POST['caption'], ENT_QUOTES | ENT_HTML5)));

    /**
     * Verifying who's the owner to allow changes
     */
    if ($uid == $picture->getVar('uid_owner')) {
        if ($imageFactory->insert($picture)) {
            redirect_header('album.php', 2, _MD_YOGURT_DESC_EDITED);
        } else {
            redirect_header('album.php', 2, _MD_YOGURT_NOCACHACA);
        }
    }
}
/**
 * Creating the factory  and the criteria to edit the desc of the picture
 * The user must be the owner
 */
$imageFactory = new Yogurt\ImageHandler($xoopsDB);
$criteria_img = new \Criteria('cod_img', $cod_img);
$criteria_uid = new \Criteria('uid_owner', $uid);
$criteria     = new \CriteriaCompo($criteria_img);
$criteria->add($criteria_uid);

/**
 * Lets fetch the info of the pictures to be able to render the form
 * The user must be the owner
 */
$array_pict = $imageFactory->getObjects($criteria);
if ($array_pict) {
    $caption = $array_pict[0]->getVar('title');
    $url     = $array_pict[0]->getVar('url');
}
//$url = $xoopsModuleConfig['link_path_upload']."/thumb_".$url;
$url = XOOPS_URL . '/uploads/yogurt/images/thumb_' . $url;
$imageFactory->renderFormEdit($caption, $cod_img, $url);

require dirname(dirname(__DIR__)) . '/footer.php';
