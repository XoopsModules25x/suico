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
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
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
    $thisUser->setVar('email', $suspension->getVar('old_email', 'n'));
    $thisUser->setVar('pass', $suspension->getVar('old_pass', 'n'));
    $thisUser->setVar('user_sig', $suspension->getVar('old_signature', 'n'));
    $memberHandler->insertUser($thisUser);
    $criteria = new Criteria('uid', $uid);
    $suspensionsFactory->deleteAll($criteria);
    redirect_header('index.php?uid=' . $uid, 3, _MD_SUICO_USER_UNSUSPENDED);
}
require dirname(__DIR__, 2) . '/footer.php';
