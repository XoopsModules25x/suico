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

require __DIR__ . '/header.php';
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
/**
 * Receiving info from get parameters
 */
$cod_audio = Request::getString('cod_audio', '', 'POST');
if (!isset($_POST['confirm']) || 1 !== Request::getInt('confirm', 0, 'POST')) {
    xoops_confirm(
        [
            'cod_audio' => $cod_audio,
            'confirm'   => 1,
        ],
        'delaudio.php',
        _MD_SUICO_AUDIO_DELETE_CONFIRM_ASK,
        _MD_SUICO_AUDIO_DELETE_CONFIRM
    );
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $audioFactory = new AudioHandler(
        $xoopsDB
    );
    $criteria_aud = new Criteria('audio_id', $cod_audio);
    $uid          = (int)$xoopsUser->getVar('uid');
    $criteriaUid  = new Criteria('uid_owner', $uid);
    $criteria     = new CriteriaCompo($criteria_aud);
    $criteria->add($criteriaUid);
    $objects_array = $audioFactory->getObjects($criteria);
    $audio_name    = $objects_array[0]->getVar('filename');
    /**
     * Try to delete
     */
    if ($audioFactory->deleteAll($criteria)) {
        unlink(XOOPS_ROOT_PATH . '/uploads/suico/audio/' . $audio_name);
        redirect_header('audios.php', 2, _MD_SUICO_AUDIO_DELETED);
    } else {
        redirect_header('audios.php', 2, _MD_SUICO_ERROR);
    }
}
require dirname(__DIR__, 2) . '/footer.php';
