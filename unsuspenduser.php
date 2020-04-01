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

$uid = (int)$_POST['uid'];
/**
 * Creating the factory  loading the picture changing its caption
 */
$suspensionsFactory = new Yogurt\SuspensionsHandler($xoopsDB);
$suspension         = $suspensionsFactory->create(false);
$suspension->load($uid);

if ($xoopsUser->isAdmin(1)) {
    $memberHandler = xoops_getHandler('member');
    $thisUser      = $memberHandler->getUser($uid);

    $thisUser->setVar('email', $suspension->getVar('old_email', 'n'));
    $thisUser->setVar('pass', $suspension->getVar('old_pass', 'n'));
    if (defined(ICMS_VERSION_NAME)) {
        $thisUser->setVar('salt', $suspension->getVar('old_salt', 'n'));
        $thisUser->setVar('pass_expired', $suspension->getVar('old_pass_expired', 'n'));
        $thisUser->setVar('enc_type', $suspension->getVar('old_enc_type', 'n'));
    }
    $thisUser->setVar('user_sig', $suspension->getVar('old_signature', 'n'));
    $memberHandler->insertUser($thisUser);

    $criteria = new \Criteria('uid', $uid);
    $suspensionsFactory->deleteAll($criteria);
    redirect_header('index.php?uid=' . $uid, 3, _MD_YOGURT_USERUNSUSPENDED);
}

require  dirname(dirname(__DIR__)) . '/footer.php';
