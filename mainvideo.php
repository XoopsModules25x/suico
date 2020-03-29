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

$cod_img = (int)$_POST['video_id'];

/**
 * Creating the factory  loading the video changing its caption
 */
$videoFactory = new Yogurt\SeutuboHandler($xoopsDB);
$video         = $videoFactory->create(false);
$video->load($cod_img);
$video->setVar('main_video', 1);

/**
 * Verifying who's the owner to allow changes
 */
$uid = (int)$xoopsUser->getVar('uid');
if ($uid == $video->getVar('uid_owner')) {
	if ($videoFactory->unsetAllMainsbyID($uid)) {
		if ($videoFactory->insert($video)) {
			redirect_header('seutubo.php', 2, _MD_YOGURT_SETMAINVIDEO);
		} else {
			redirect_header('seutubo.php', 2, _MD_YOGURT_NOCACHACA);
		}
	} else {
		echo 'nao deu certo';
	}
}

include __DIR__.'/../../footer.php';
