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
/**
 * Factory of friendrequests created
 */
$friendrequestFactory = new Yogurt\FriendrequestHandler($xoopsDB);
$friendshipFactory     = new Yogurt\FriendshipHandler($xoopsDB);

/**
 * Getting the uid of the user which user want to canel friend request
 */
$friendrequestto_uid = Request::getInt(
    'friendrequestto_uid',
    0,
    'POST'
);
$friendrequester_uid = (int)$xoopsUser->getVar('uid');

$criteria_friend1 = new Criteria('friendrequestto_uid', $friendrequestto_uid);
$criteria_friend2 = new Criteria('friendrequester_uid', $friendrequester_uid);

$criteria_delete1 = new CriteriaCompo($criteria_friend1);
$criteria_delete1->add($criteria_friend2);

$friendrequestFactory->deleteAll($criteria_delete1);

$criteria_friend1 = new Criteria('friendrequestto_uid', $friendrequester_uid);
$criteria_friend2 = new Criteria('friendrequester_uid', $friendrequestto_uid);

$criteria_delete1 = new CriteriaCompo($criteria_friend1);
$criteria_delete1->add($criteria_friend2);

$friendrequestFactory->deleteAll($criteria_delete1);

redirect_header('index.php?uid='.$friendrequestto_uid.'', 3, _MD_YOGURT_FRIENDREQUESTCANCELLED);

require dirname(__DIR__, 2) . '/footer.php';
