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
    FriendshipHandler
};

require __DIR__ . '/header.php';
if (!$xoopsUser) {
    redirect_header('index.php');
}
$friendshipFactory = new FriendshipHandler($xoopsDB);
$friend2_uid       = Request::getInt('friend_uid', 0, 'POST');
$marker            = Request::getInt('marker', 0, 'POST');
$friend            = new \XoopsUser($friend2_uid);
if (1 === $marker) {
    $level         = $_POST['level'];
    $cool          = $_POST['cool'];
    $friendly      = $_POST['hot'];
    $funny         = $_POST['trust'];
    $fan           = $_POST['fan'];
    $friendship_id = Request::getInt('friendship_id', 0, 'POST');
    $criteria      = new Criteria('friendship_id', $friendship_id);
    $friendships   = $friendshipFactory->getObjects($criteria);
    $friendship    = $friendships[0];
    $friendship->setVar('level', $level);
    $friendship->setVar('cool', $cool);
    $friendship->setVar('hot', $friendly);
    $friendship->setVar('trust', $funny);
    $friendship->setVar('fan', $fan);
    $friend2_uid = (int)$friendship->getVar('friend2_uid');
    $friendship->unsetNew();
    $friendshipFactory->insert2($friendship);
    redirect_header('friends.php', 2, _MD_SUICO_FRIENDSHIP_UPDATED);
} else {
    $friendshipFactory->renderFormSubmit($friend);
}
require dirname(__DIR__, 2) . '/footer.php';
