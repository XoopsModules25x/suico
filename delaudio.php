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

/**
 * Receiving info from get parameters
 */
$cod_audio = $_POST['cod_audio'];
if (!isset($_POST['confirm']) || 1 != $_POST['confirm']) {
    xoops_confirm(['cod_audio' => $cod_audio, 'confirm' => 1], 'delaudio.php', _MD_YOGURT_ASKCONFIRMAUDIODELETION, _MD_YOGURT_CONFIRMAUDIODELETION);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $audioFactory = new Yogurt\AudioHandler($xoopsDB);
    $criteria_aud = new \Criteria('audio_id', $cod_audio);
    $uid          = (int)$xoopsUser->getVar('uid');
    $criteria_uid = new \Criteria('uid_owner', $uid);
    $criteria     = new \CriteriaCompo($criteria_aud);
    $criteria->add($criteria_uid);

    $objects_array = $audioFactory->getObjects($criteria);
    $audio_name    = $objects_array[0]->getVar('url');

    /**
     * Try to delete
     */
    if ($audioFactory->deleteAll($criteria)) {
        unlink(XOOPS_ROOT_PATH . '/uploads/yogurt/mp3/' . $audio_name);
        redirect_header('audio.php', 2, _MD_YOGURT_AUDIODELETED);
    } else {
        redirect_header('audio.php', 2, _MD_YOGURT_NOCACHACA);
    }
}

require dirname(dirname(__DIR__)) . '/footer.php';
