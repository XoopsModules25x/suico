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
    SuspensionsHandler
};

require __DIR__ . '/header.php';
//require_once __DIR__ . '/class/Suspensions.php';
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 5, _MD_SUICO_TOKENEXPIRED);
}
$uid = Request::getInt('uid', 0, 'POST');
/**
 * Creating the factory  loading the picture changing its caption
 */
$suspensionsFactory = new SuspensionsHandler(
    $xoopsDB
);
$suspension         = $suspensionsFactory->create(false);
$suspension->load($uid);
if ($xoopsUser->isAdmin(1)) {
    /** @var \XoopsMemberHandler $memberHandler */
    $memberHandler = xoops_getHandler('member');
    $thisUser      = $memberHandler->getUser($uid);
    $suspension->setVar('uid', $uid);
    $suspension->setVar('old_email', $thisUser->getVar('email'));
    $suspension->setVar('old_pass', $thisUser->getVar('pass'));
    $suspension->setVar('old_signature', $thisUser->getVar('user_sig'));
    $suspension->setVar('suspension_time', time() + Request::getInt('time', 0, 'POST'));
    $suspensionsFactory->insert2($suspension);
    $thisUser->setVar('email', md5((string)time()));
    $thisUser->setVar('pass', md5((string)time()));
    $thisUser->setVar('user_sig', sprintf(_MD_SUICO_SUSPENDED, formatTimestamp(time() + Request::getInt('time', 0, 'POST'), 'm')));
    $memberHandler->insertUser($thisUser);
    redirect_header('index.php?uid=' . $uid, 300, _MD_SUICO_USER_SUSPENDED);
}
require dirname(__DIR__, 2) . '/footer.php';
