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
/**
 * Factory of petitions created
 */
$friendpetitionFactory = new Yogurt\FriendpetitionHandler($xoopsDB);
$friendshipFactory     = new Yogurt\FriendshipHandler($xoopsDB);

/**
 * Getting the uid of the user which user want to ask to be friend
 */
$friend1_uid = (int)$_POST['friend_uid'];
$friend2_uid = (int)$xoopsUser->getVar('uid');

$criteria_friend1 = new \Criteria('friend1_uid', $friend1_uid);
$criteria_friend2 = new \Criteria('friend2_uid', $friend2_uid);

$criteria_delete1 = new \CriteriaCompo($criteria_friend1);
$criteria_delete1->add($criteria_friend2);

$friendshipFactory->deleteAll($criteria_delete1);

$criteria_friend1 = new \Criteria('friend1_uid', $friend2_uid);
$criteria_friend2 = new \Criteria('friend2_uid', $friend1_uid);

$criteria_delete1 = new \CriteriaCompo($criteria_friend1);
$criteria_delete1->add($criteria_friend2);

$friendshipFactory->deleteAll($criteria_delete1);

redirect_header('friends.php', 3, _MD_YOGURT_FRIENDSHIPTERMINATED);

require  dirname(dirname(__DIR__)) . '/footer.php';
