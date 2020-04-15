<?php declare(strict_types=1);

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

use Xmf\Request;
use XoopsModules\Yogurt;

require __DIR__ . '/header.php';
//require_once __DIR__ . '/class/Suspensions.php';

if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 5, _MD_YOGURT_TOKENEXPIRED);
}

$uid = Request::getInt('uid', 0, 'POST');
/**
 * Creating the factory  loading the picture changing its caption
 */
$suspensionsFactory = new Yogurt\SuspensionsHandler(
    $xoopsDB
);
$suspension         = $suspensionsFactory->create(false);
$suspension->load($uid);

if ($xoopsUser->isAdmin(1)) {
    $memberHandler = xoops_getHandler('member');
    $thisUser      = $memberHandler->getUser($uid);
    $suspension->setVar('uid', $uid);
    $suspension->setVar('old_email', $thisUser->getVar('email'));
    $suspension->setVar('old_pass', $thisUser->getVar('pass'));
    if (defined(ICMS_VERSION_NAME)) {
        $thisUser->setVar('old_salt', $thisUser->getVar('salt'));
        $thisUser->setVar('old_pass_expired', $thisUser->getVar('pass_expired'));
        $thisUser->setVar('old_enc_type', $thisUser->getVar('enc_type'));
    }
    $suspension->setVar('old_signature', $thisUser->getVar('user_sig'));
    $suspension->setVar('suspension_time', time() + Request::getInt('time', 0, 'POST'));
    $suspensionsFactory->insert($suspension);
    $thisUser->setVar('email', md5(time()));
    $thisUser->setVar('pass', md5(time()));

    $thisUser->setVar('user_sig', sprintf(_MD_YOGURT_SUSPENDED, formatTimestamp(time() + Request::getInt('time', 0, 'POST'), 'm')));
    $memberHandler->insertUser($thisUser);
    redirect_header('index.php?uid=' . $uid, 300, _MD_YOGURT_USERSUSPENDED);
}

require dirname(dirname(__DIR__)) . '/footer.php';
