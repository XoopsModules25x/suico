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

//require_once __DIR__ . '/class/Image.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$cod_img = $_POST['cod_img'];

/**
 * Creating the factory  loading the picture changing its caption
 */
$imageFactory = new Yogurt\ImageHandler($xoopsDB);
$picture      = $imageFactory->create(false);
$picture->load($cod_img);
$picture->setVar('private', \Xmf\Request::getInt('private', 0, 'POST'));

/**
 * Verifying who's the owner to allow changes
 */
$uid = (int)$xoopsUser->getVar('uid');
if ($uid == $picture->getVar('uid_owner')) {
    if ($imageFactory->insert($picture)) {
        if (1 == $_POST['private']) {
            redirect_header('album.php', 2, _MD_YOGURT_PRIVATIZED);
        } else {
            redirect_header('album.php', 2, _MD_YOGURT_UNPRIVATIZED);
        }
    } else {
        redirect_header('album.php', 2, _MD_YOGURT_NOCACHACA);
    }
}

require dirname(dirname(__DIR__)) . '/footer.php';
