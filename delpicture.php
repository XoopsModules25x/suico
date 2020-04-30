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
use XoopsModules\Suico;

require __DIR__ . '/header.php';
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
$cod_img = Request::getInt('cod_img', 0, 'POST');
if (!isset($_POST['confirm']) || 1 !== Request::getInt('confirm', 0, 'POST')) {
    xoops_confirm(
        [
            'cod_img' => $cod_img,
            'confirm' => 1,
        ],
        'delpicture.php',
        _MD_SUICO_ASK_CONFIRM_DELETION,
        _MD_SUICO_CONFIRM_DELETION
    );
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $imageFactory = new Suico\ImageHandler(
        $xoopsDB
    );
    $criteria_img = new Criteria('cod_img', $cod_img);
    $uid          = (int)$xoopsUser->getVar('uid');
    $criteriaUid  = new Criteria('uid_owner', $uid);
    $criteria     = new CriteriaCompo($criteria_img);
    $criteria->add($criteriaUid);
    $objects_array = $imageFactory->getObjects($criteria);
    $image_name    = $objects_array[0]->getVar('filename');
    $avatar_image  = $xoopsUser->getVar('user_avatar');
    /**
     * Try to delete
     */
    if ($imageFactory->deleteAll($criteria)) {
        if (1 === $helper->getConfig('physical_delete')) {
            //unlink($xoopsModuleConfig['path_upload']."\/".$image_name);
            unlink(
                XOOPS_ROOT_PATH . '/uploads' . '/images/suico/' . $image_name
            );
            unlink(XOOPS_ROOT_PATH . '/uploads' . '/images/suico/resized_' . $image_name);
            /**
             * Delete the thumb (avatar now has another name)
             */
            //if ($avatar_image!=$image_name){
            unlink(XOOPS_ROOT_PATH . '/uploads' . '/images/thumb_' . $image_name);
            //}
        }
        redirect_header('album.php', 2, _MD_SUICO_DELETED);
    } else {
        redirect_header('album.php', 2, _MD_SUICO_ERROR);
    }
}
require dirname(__DIR__, 2) . '/footer.php';
