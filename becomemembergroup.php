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

//require_once __DIR__ . '/class/Friendpetition.php';
//require_once __DIR__ . '/class/Relgroupuser.php';
//require_once __DIR__ . '/class/Groups.php';

/**
 * Factories of groups... testing for zend editor
 */
$relgroupuserFactory = new Yogurt\RelgroupuserHandler($xoopsDB);
$groupsFactory       = new Yogurt\GroupsHandler($xoopsDB);

$group_id = \Xmf\Request::getInt('group_id', 0, 'POST');
$uid      = (int)$xoopsUser->getVar('uid');

$criteria_uid      = new \Criteria('rel_user_uid', $uid);
$criteria_group_id = new \Criteria('rel_group_id', $group_id);
$criteria          = new \CriteriaCompo($criteria_uid);
$criteria->add($criteria_group_id);
if ($relgroupuserFactory->getCount($criteria) < 1) {
    $relgroupuser = $relgroupuserFactory->create();
    $relgroupuser->setVar('rel_group_id', $group_id);
    $relgroupuser->setVar('rel_user_uid', $uid);
    if ($relgroupuserFactory->insert($relgroupuser)) {
        redirect_header('groups.php', 1, _MD_YOGURT_YOUAREMEMBERNOW);
    } else {
        redirect_header('groups.php', 1, _MD_YOGURT_NOCACHACA);
    }
} else {
    redirect_header('groups.php', 1, _MD_YOGURT_YOUAREMEMBERALREADY);
}

require dirname(dirname(__DIR__)) . '/footer.php';
