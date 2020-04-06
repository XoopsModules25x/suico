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
    redirect_header('index.php', 3, _MD_YOGURT_TOKENEXPIRED);
}

/**
 * Creating the factory  loading the picture changing its caption
 */
$imageFactory = new Yogurt\ImageHandler($xoopsDB);
$picture      = $imageFactory->create(false);
$picture->load($_POST['cod_img']);

$uid = (int)$xoopsUser->getVar('uid');

$image       = XOOPS_ROOT_PATH . '/uploads/yogurt/images/' . 'thumb_' . $picture->getVar('url');
$avatar      = 'av' . $uid . '_' . time() . '.jpg';
$imageavatar = XOOPS_ROOT_PATH . '/uploads/avatars/' . $avatar;

if (!copy($image, $imageavatar)) {
    echo 'failed to copy $file...\n';
}
$xoopsUser->setVar('user_avatar', 'avatars/' . $avatar);

$userHandler = new \XoopsUserHandler($xoopsDB);

/**
 * Verifying who's the owner to allow changes
 */
if ($uid == $picture->getVar('uid_owner')) {
    if ($userHandler->insert($xoopsUser)) {
        redirect_header('album.php', 2, _MD_YOGURT_AVATAR_EDITED);
    } else {
        redirect_header('album.php', 2, _MD_YOGURT_NOCACHACA);
    }
}

require dirname(dirname(__DIR__)) . '/footer.php';
