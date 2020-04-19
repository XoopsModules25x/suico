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

$friendpetitionFactory = new Yogurt\FriendpetitionHandler($xoopsDB);
/**
 * create the petition in database
 */
$newpetition = $friendpetitionFactory->create(true);
$newpetition->setVar('petitioner_uid', $xoopsUser->getVar('uid'));
$newpetition->setVar('petitionto_uid', Request::getInt('petitionto_uid', 0, 'POST'));

if ($friendpetitionFactory->insert2($newpetition)) {
    $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
    $extra_tags['X_OWNER_UID']  = $xoopsUser->getVar('uid');
    /** @var \XoopsNotificationHandler $notificationHandler */
    $notificationHandler        = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('friendship', Request::getInt('petitionto_uid', 0, 'POST'), 'new_friendship', $extra_tags);

    redirect_header(
        XOOPS_URL . '/modules/yogurt/index.php?uid=' . Request::getInt('petitionto_uid', 0, 'POST'), 3, _MD_YOGURT_PETITIONTO);
} else {
    redirect_header(
        XOOPS_URL . '/modules/yogurt/index.php?uid=' . $xoopsUser->getVar('uid'),
        3,
        _MD_YOGURT_NOCACHACA
    );
}

/**
 * Close page
 */
require dirname(dirname(__DIR__)) . '/footer.php';