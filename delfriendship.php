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
    FriendrequestHandler,
    FriendshipHandler
};

require __DIR__ . '/header.php';
/**
 * Factory of friendrequests created
 */
$friendrequestFactory = new FriendrequestHandler($xoopsDB);
$friendshipFactory    = new FriendshipHandler($xoopsDB);
/**
 * Getting the uid of the user which user want to ask to be friend
 */
$friend1_uid      = Request::getInt(
    'friend_uid',
    0,
    'POST'
);
$friend2_uid      = (int)$xoopsUser->getVar('uid');
$criteria_friend1 = new Criteria('friend1_uid', $friend1_uid);
$criteria_friend2 = new Criteria('friend2_uid', $friend2_uid);
$criteria_delete1 = new CriteriaCompo($criteria_friend1);
$criteria_delete1->add($criteria_friend2);
$friendshipFactory->deleteAll($criteria_delete1);
$criteria_friend1 = new Criteria('friend1_uid', $friend2_uid);
$criteria_friend2 = new Criteria('friend2_uid', $friend1_uid);
$criteria_delete1 = new CriteriaCompo($criteria_friend1);
$criteria_delete1->add($criteria_friend2);
$friendshipFactory->deleteAll($criteria_delete1);
redirect_header('friends.php', 3, _MD_SUICO_FRIENDSHIP_TERMINATED);
require dirname(__DIR__, 2) . '/footer.php';
