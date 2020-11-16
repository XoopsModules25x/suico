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
//require_once __DIR__ . '/class/Image.php';
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
$image_id = Request::getInt('image_id', 0, 'POST');
/**
 * Creating the factory  loading the picture changing its caption
 */
$imageFactory = new ImageHandler(
    $xoopsDB
);
$picture      = $imageFactory->create(false);
$picture->load($image_id);
$picture->setVar('private', Request::getInt('private', 0, 'POST'));
/**
 * Verifying who's the owner to allow changes
 */
$uid = (int)$xoopsUser->getVar('uid');
if ($uid === (int)$picture->getVar('uid_owner')) {
    if ($imageFactory->insert2($picture)) {
        if (1 === Request::getInt('private', 0, 'POST')) {
            redirect_header('album.php', 2, _MD_SUICO_PRIVATIZED);
        } else {
            redirect_header('album.php', 2, _MD_SUICO_UNPRIVATIZED);
        }
    } else {
        redirect_header('album.php', 2, _MD_SUICO_ERROR);
    }
}
require dirname(__DIR__, 2) . '/footer.php';
