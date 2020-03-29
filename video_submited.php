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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_index.tpl';
require __DIR__.'/header.php';

//include_once __DIR__ . '/class/Seutubo.php';

/**
 * Factory of pictures created
 */
$albumFactory = new Yogurt\SeutuboHandler($xoopsDB);

$url = $_POST['codigo'];

if (!$GLOBALS['xoopsSecurity']->check()) {
	redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

/**
 * Try to upload picture resize it insert in database and then redirect to index
 */
$newvideo = $albumFactory->create(true);
$newvideo->setVar('uid_owner', (int)$xoopsUser->getVar('uid'));
$newvideo->setVar('video_desc', trim(htmlspecialchars($_POST['caption'], ENT_QUOTES | ENT_HTML5)));

if (11 == strlen($url)) {
	$code = $url;
} else {
	$position_of_code = strpos($url, 'v=');
	$code             = substr($url, $position_of_code + 2, 11);
}

$newvideo->setVar('youtube_code', $code);
if ($albumFactory->insert($newvideo)) {
	$extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
	$extra_tags['X_OWNER_UID']  = (int)$xoopsUser->getVar('uid');
	$notificationHandler        = xoops_getHandler('notification');
	$notificationHandler->triggerEvent('video', (int)$xoopsUser->getVar('uid'), 'new_video', $extra_tags);
	redirect_header(XOOPS_URL . '/modules/yogurt/seutubo.php?uid=' . (int)$xoopsUser->getVar('uid'), 2, _MD_YOGURT_VIDEOSAVED);
} else {
	redirect_header(XOOPS_URL . '/modules/yogurt/seutubo.php?uid=' . (int)$xoopsUser->getVar('uid'), 2, _MD_YOGURT_NOCACHACA);
}

include __DIR__ . '/../../footer.php';
