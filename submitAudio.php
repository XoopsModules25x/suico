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
    AudioHandler
};

/**
 * Xoops header ...
 */
$GLOBALS['xoopsOption']['template_main'] = 'suico_index.tpl';
require __DIR__ . '/header.php';
/**
 * Modules class includes
 */
//require_once __DIR__ . '/class/Audio.php';
/**
 * Audio Factory created
 */
$audioFactory = new AudioHandler($xoopsDB);
$myts         = \MyTextSanitizer::getInstance();
/**
 * Getting the title
 */
$title       = Request::getString('title', '', 'POST');
$author      = Request::getString('author', '', 'POST');
$description = Request::getText('description', '', 'POST');
/**
 * Getting parameters defined in admin side
 */
$path_upload  = XOOPS_ROOT_PATH . '/uploads/suico/audio/';
$maxfilebytes = $helper->getConfig('maxfilesize');
/**
 * If we are receiving a file
 */
if ('sel_audio' === (Request::getArray('xoops_upload_file', '', 'POST')[0])) {
    /**
     * Verify Token
     */
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
    }
    /**
     * Try to upload the audio file, insert in database, and then redirect to index
     */
    if ($audioFactory->receiveAudio(
        $title,
        $path_upload,
        $author,
        $maxfilebytes,
        $description
    )) {
        //$extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
        //                     $extra_tags['X_OWNER_UID'] = $xoopsUser->getVar('uid');
        // /** @var \XoopsNotificationHandler $notificationHandler */
        //                     $notificationHandler = xoops_getHandler('notification');
        //                     $notificationHandler->triggerEvent ("picture", $xoopsUser->getVar('uid'), "new_picture",$extra_tags);
        //header("Location: ".XOOPS_URL."/modules/suico/index.php?uid=".$xoopsUser->getVar('uid'));
        redirect_header(
            XOOPS_URL . '/modules/suico/audios.php?uid=' . $xoopsUser->getVar('uid'),
            50,
            _MD_SUICO_UPLOADEDAUDIO
        );
    } else {
        redirect_header(
            XOOPS_URL . '/modules/suico/audios.php?uid=' . $xoopsUser->getVar('uid'),
            50,
            _MD_SUICO_ERROR
        );
    }
}
/**
 * Close page
 */
require dirname(__DIR__, 2) . '/footer.php';
