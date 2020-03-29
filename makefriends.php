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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_index.tpl';
require __DIR__.'/header.php';

//include_once __DIR__ . '/class/Friendpetition.php';
//include_once __DIR__ . '/class/Friendship.php';

/**
 * Factory of petitions created
 */
$friendpetitionFactory = new Yogurt\FriendpetitionHandler($xoopsDB);
$friendshipFactory     = new Yogurt\FriendshipHandler($xoopsDB);

$petition_id      = (int) $_POST['petition_id'];
$friendship_level = (int) $_POST['level'];
$uid              = (int) $xoopsUser->getVar('uid');

if (!$GLOBALS['xoopsSecurity']->check()) {
	redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}

$criteria = new \CriteriaCompo(new \Criteria('friendpet_id', $petition_id));
$criteria->add(new \Criteria('petioned_uid', $uid));
if ($friendpetitionFactory->getCount($criteria) > 0) {
	if (($friendship_level > 0) && ($petition = $friendpetitionFactory->getObjects($criteria))) {
		$friend1_uid = $petition[0]->getVar('petitioner_uid');
		$friend2_uid = $petition[0]->getVar('petioned_uid');

		$newfriendship1 = $friendshipFactory->create(true);
		$newfriendship1->setVar('level', 3);
		$newfriendship1->setVar('friend1_uid', $friend1_uid);
		$newfriendship1->setVar('friend2_uid', $friend2_uid);
		$newfriendship2 = $friendshipFactory->create(true);
		$newfriendship2->setVar('level', $friendship_level);
		$newfriendship2->setVar('friend1_uid', $friend2_uid);
		$newfriendship2->setVar('friend2_uid', $friend1_uid);
		$friendpetitionFactory->deleteAll($criteria);
		$friendshipFactory->insert($newfriendship1);
		$friendshipFactory->insert($newfriendship2);

		redirect_header(XOOPS_URL . '/modules/yogurt/friends.php?uid=' . $friend2_uid, 3, _MD_YOGURT_FRIENDMADE);
	} else {
		if (0 == $friendship_level) {
			$friendpetitionFactory->deleteAll($criteria);
			redirect_header(XOOPS_URL . '/modules/yogurt/seutubo.php?uid=' . $uid, 3, _MD_YOGURT_FRIENDSHIPNOTACCEPTED);
		}
		redirect_header(XOOPS_URL . '/modules/yogurt/index.php?uid=' . $uid, 3, _MD_YOGURT_NOCACHACA);
	}
} else {
	redirect_header(XOOPS_URL . '/modules/yogurt/index.php?uid=' . $uid, 3, _MD_YOGURT_NOCACHACA);
}

include __DIR__ . '/../../footer.php';
