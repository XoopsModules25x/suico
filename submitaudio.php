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

/**
 * Xoops header ...
 */
$GLOBALS['xoopsOption']['template_main'] = 'yogurt_index.tpl';
require __DIR__ . '/header.php';

/**
 * Modules class includes
 */
//require_once __DIR__ . '/class/Audio.php';

/**
 * Factory of pictures created
 */
$audioFactory = new Yogurt\AudioHandler($xoopsDB);

$myts = MyTextSanitizer::getInstance();
/**
 * Getting the title
 */
$title  = $myts->displayTarea($_POST['title'], 0, 1, 1, 1, 1);
$author = $myts->displayTarea($_POST['author'], 0, 1, 1, 1, 1);

/**
 * Getting parameters defined in admin side
 */
$path_upload  = XOOPS_ROOT_PATH . '/uploads/yogurt/mp3/';
$maxfilebytes = $xoopsModuleConfig['maxfilesize'];

/**
 * If we are receiving a file
 */
if ('sel_audio' == $_POST['xoops_upload_file'][0]) {
    /**
     * Verify Token
     */
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
    }

    /**
     * Try to upload picture resize it insert in database and then redirect to index
     */
    if ($audioFactory->receiveAudio($title, $path_upload, $author, $maxfilebytes)) {
        //$extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
        //                     $extra_tags['X_OWNER_UID'] = $xoopsUser->getVar('uid');
        //                     $notificationHandler = xoops_getHandler('notification');
        //                     $notificationHandler->triggerEvent ("picture", $xoopsUser->getVar('uid'), "new_picture",$extra_tags);
        //header("Location: ".XOOPS_URL."/modules/yogurt/index.php?uid=".$xoopsUser->getVar('uid'));
        redirect_header(XOOPS_URL . '/modules/yogurt/audio.php?uid=' . $xoopsUser->getVar('uid'), 50, _MD_YOGURT_UPLOADEDAUDIO);
    } else {
        redirect_header(XOOPS_URL . '/modules/yogurt/audio.php?uid=' . $xoopsUser->getVar('uid'), 50, _MD_YOGURT_NOCACHACA);
    }
}

/**
 * Close page
 */
require dirname(dirname(__DIR__)) . '/footer.php';
