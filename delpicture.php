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

if (!isset($_POST['confirm']) || 1 != $_POST['confirm']) {
    xoops_confirm(['cod_img' => $cod_img, 'confirm' => 1], 'delpicture.php', _MD_YOGURT_ASKCONFIRMDELETION, _MD_YOGURT_CONFIRMDELETION);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $imageFactory = new Yogurt\ImageHandler($xoopsDB);
    $criteria_img = new \Criteria('cod_img', $cod_img);
    $uid          = (int)$xoopsUser->getVar('uid');
    $criteria_uid = new \Criteria('uid_owner', $uid);
    $criteria     = new \CriteriaCompo($criteria_img);
    $criteria->add($criteria_uid);

    $objects_array = $imageFactory->getObjects($criteria);
    $image_name    = $objects_array[0]->getVar('url');
    $avatar_image  = $xoopsUser->getVar('user_avatar');

    /**
     * Try to delete
     */
    if ($imageFactory->deleteAll($criteria)) {
        if (1 == $xoopsModuleConfig['physical_delete']) {
            //unlink($xoopsModuleConfig['path_upload']."\/".$image_name);
            unlink(XOOPS_ROOT_PATH . '/uploads' . '/images/yogurt/' . $image_name);
            unlink(XOOPS_ROOT_PATH . '/uploads' . '/images/yogurt/resized_' . $image_name);
            /**
             * Delete the thumb (avatar now has another name)
             */
            //if ($avatar_image!=$image_name){
            unlink(XOOPS_ROOT_PATH . '/uploads' . '/images/thumb_' . $image_name);
            //}
        }
        redirect_header('album.php', 2, _MD_YOGURT_DELETED);
    } else {
        redirect_header('album.php', 2, _MD_YOGURT_NOCACHACA);
    }
}

require dirname(dirname(__DIR__)) . '/footer.php';
