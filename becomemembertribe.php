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

//include_once __DIR__ . '/class/Friendpetition.php';
//include_once __DIR__ . '/class/Reltribeuser.php';
//include_once __DIR__ . '/class/Tribes.php';

/**
 * Factories of tribes... testing for zend editor
 */
$reltribeuserFactory = new Yogurt\ReltribeuserHandler($xoopsDB);
$tribesFactory = new Yogurt\TribesHandler($xoopsDB);

$tribe_id = (int)$_POST['tribe_id'];
$uid = (int)$xoopsUser->getVar('uid');

$criteria_uid = new \Criteria('rel_user_uid', $uid);
$criteria_tribe_id = new \Criteria('rel_tribe_id', $tribe_id);
$criteria = new \CriteriaCompo($criteria_uid);
$criteria->add($criteria_tribe_id);
if ($reltribeuserFactory->getCount($criteria) < 1) {
    $reltribeuser = $reltribeuserFactory->create();
    $reltribeuser->setVar('rel_tribe_id', $tribe_id);
    $reltribeuser->setVar('rel_user_uid', $uid);
    if ($reltribeuserFactory->insert($reltribeuser)) {
        redirect_header('tribes.php', 1, _MD_YOGURT_YOUAREMEMBERNOW);
    } else {
        redirect_header('tribes.php', 1, _MD_YOGURT_NOCACHACA);
    }
} else {
    redirect_header('tribes.php', 1, _MD_YOGURT_YOUAREMEMBERALREADY);
}

include __DIR__ . '/../../footer.php';
