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

$GLOBALS['xoopsOption']['template_main'] = 'suico_index.tpl';
require __DIR__ . '/header.php';
//require_once __DIR__ . '/class/Friendrequest.php';
//require_once __DIR__ . '/class/Friendship.php';
/**
 * Factory of friendrequests created
 */
$friendrequestFactory = new FriendrequestHandler($xoopsDB);
$friendshipFactory    = new FriendshipHandler($xoopsDB);
$friendrequest_id     = Request::getInt('friendrequest_id', 0, 'POST');
$friendship_level     = Request::getInt('level', 0, 'POST');
$uid                  = (int)$xoopsUser->getVar('uid');
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
$criteria = new CriteriaCompo(new Criteria('friendreq_id', $friendrequest_id));
$criteria->add(new Criteria('friendrequestto_uid', $uid));
if ($friendrequestFactory->getCount($criteria) > 0) {
    if (($friendship_level > 0) && ($friendrequest = $friendrequestFactory->getObjects($criteria))) {
        $friend1_uid    = $friendrequest[0]->getVar('friendrequester_uid');
        $friend2_uid    = $friendrequest[0]->getVar('friendrequestto_uid');
        $newfriendship1 = $friendshipFactory->create(true);
        $newfriendship1->setVar('level', 3);
        $newfriendship1->setVar('friend1_uid', $friend1_uid);
        $newfriendship1->setVar('friend2_uid', $friend2_uid);
        $newfriendship2 = $friendshipFactory->create(true);
        $newfriendship2->setVar('level', $friendship_level);
        $newfriendship2->setVar('friend1_uid', $friend2_uid);
        $newfriendship2->setVar('friend2_uid', $friend1_uid);
        $friendrequestFactory->deleteAll($criteria);
        $friendshipFactory->insert2($newfriendship1);
        $friendshipFactory->insert2($newfriendship2);
        redirect_header(XOOPS_URL . '/modules/suico/friends.php?uid=' . $friend2_uid, 3, _MD_SUICO_FRIENDMADE);
    } else {
        if (0 === $friendship_level) {
            $friendrequestFactory->deleteAll($criteria);
            redirect_header(XOOPS_URL . '/modules/suico/index.php?uid=' . $uid, 3, _MD_SUICO_FRIENDSHIP_NOTACCEPTED);
        }
        redirect_header(XOOPS_URL . '/modules/suico/index.php?uid=' . $uid, 3, _MD_SUICO_ERROR);
    }
} else {
    redirect_header(XOOPS_URL . '/modules/suico/index.php?uid=' . $uid, 3, _MD_SUICO_ERROR);
}
require dirname(__DIR__, 2) . '/footer.php';
