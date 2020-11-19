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
    FriendrequestHandler
};

$GLOBALS['xoopsOption']['template_main'] = 'suico_index.tpl';
require __DIR__ . '/header.php';
/**
 * Modules class includes
 */
//require_once __DIR__ . '/class/Friendrequest.php';
/**
 * Factory of friendrequests created
 */
$friendrequestFactory = new FriendrequestHandler($xoopsDB);
/**
 * Getting the uid of the user which user want to ask to be friend
 */
$friendrequestfrom_uid = $_POST['friendrequestfrom_uid'];
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
//Verify if the user has already asked for friendship or if the user he s asking to be a friend has already asked him
$criteria = new CriteriaCompo(
    new Criteria(
        'friendrequestto_uid', $friendrequestfrom_uid
    )
);
$criteria->add(new Criteria('friendrequester_uid', $xoopsUser->getVar('uid')));
if ($friendrequestFactory->getCount($criteria) > 0) {
    redirect_header(
        XOOPS_URL . '/modules/suico/index.php?uid=' . Request::getInt('friendrequestfrom_uid', 0, 'POST'),
        3,
        _MD_SUICO_ALREADY_FRIEND_REQUESTFROM
    );
} else {
    $criteria2 = new CriteriaCompo(new Criteria('friendrequester_uid', $friendrequestfrom_uid));
    $criteria2->add(new Criteria('friendrequestto_uid', $xoopsUser->getVar('uid')));
    if ($friendrequestFactory->getCount($criteria2) > 0) {
        redirect_header(
            XOOPS_URL . '/modules/suico/index.php?uid=' . Request::getInt('friendrequestfrom_uid', 0, 'POST'),
            3,
            _MD_SUICO_ALREADY_FRIEND_REQUESTFROM
        );
    }
}
/**
 * create the friendrequest in database
 */
$newFriendrequest = $friendrequestFactory->create(true);
$newFriendrequest->setVar('friendrequester_uid', $xoopsUser->getVar('uid'));
$newFriendrequest->setVar('friendrequestto_uid', Request::getInt('friendrequestfrom_uid', 0, 'POST'));
if ($friendrequestFactory->insert2($newFriendrequest)) {
    $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
    $extra_tags['X_OWNER_UID']  = $xoopsUser->getVar('uid');
    /** @var \XoopsNotificationHandler $notificationHandler */
    $notificationHandler = xoops_getHandler('notification');
    $notificationHandler->triggerEvent('friendship', Request::getInt('friendrequestfrom_uid', 0, 'POST'), 'new_friendship', $extra_tags);
    redirect_header(
        XOOPS_URL . '/modules/suico/index.php?uid=' . Request::getInt('friendrequestfrom_uid', 0, 'POST'),
        3,
        _MD_SUICO_FRIENDREQUEST_FROM
    );
} else {
    redirect_header(
        XOOPS_URL . '/modules/suico/index.php?uid=' . $xoopsUser->getVar('uid'),
        3,
        _MD_SUICO_ERROR
    );
}
/**
 * Close page
 */
require dirname(__DIR__, 2) . '/footer.php';
