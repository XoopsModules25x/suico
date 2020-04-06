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

if (!$xoopsUser) {
    redirect_header('index.php');
}

$friendshipFactory = new Yogurt\FriendshipHandler($xoopsDB);
$friend2_uid       = \Xmf\Request::getInt('friend_uid', 0, 'POST');
$marker            = \Xmf\Request::getInt('marker', 0, 'POST');

$friend = new \XoopsUser($friend2_uid);

if (1 == $marker) {
    $level         = $_POST['level'];
    $cool          = $_POST['cool'];
    $friendly      = $_POST['hot'];
    $funny         = $_POST['trust'];
    $fan           = $_POST['fan'];
    $friendship_id = \Xmf\Request::getInt('friendship_id', 0, 'POST');

    $criteria    = new \Criteria('friendship_id', $friendship_id);
    $friendships = $friendshipFactory->getObjects($criteria);
    $friendship  = $friendships[0];
    $friendship->setVar('level', $level);
    $friendship->setVar('cool', $cool);
    $friendship->setVar('hot', $friendly);
    $friendship->setVar('trust', $funny);
    $friendship->setVar('fan', $fan);
    $friend2_uid = (int)$friendship->getVar('friend2_uid');
    $friendship->unsetNew();
    $friendshipFactory->insert($friendship);
    redirect_header('friends.php', 2, _MD_YOGURT_FRIENDSHIPUPDATED);
} else {
    $friendshipFactory->renderFormSubmit($friend);
}

require dirname(dirname(__DIR__)) . '/footer.php';
