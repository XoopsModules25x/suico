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

$group_id     = \Xmf\Request::getInt('group_id', 0, 'POST');
$rel_user_uid = \Xmf\Request::getInt('rel_user_uid', 0, 'POST');

if (1 != $_POST['confirm']) {
    xoops_confirm(['rel_user_uid' => $rel_user_uid, 'group_id' => $group_id, 'confirm' => 1], 'kickfromgroup.php', _MD_YOGURT_ASKCONFIRMKICKFROMGROUP, _MD_YOGURT_CONFIRMKICK);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $relgroupuserFactory = new Yogurt\RelgroupuserHandler($xoopsDB);
    $groupsFactory       = new Yogurt\GroupsHandler($xoopsDB);
    $group               = $groupsFactory->get($group_id);
    //  echo "<pre>";
    //  print_r($group);
    if ($xoopsUser->getVar('uid') == $group->getVar('owner_uid')) {
        $criteria_rel_user_uid = new \Criteria('rel_user_uid', $rel_user_uid);
        $criteria_group_id     = new \Criteria('rel_group_id', $group_id);
        $criteria              = new \CriteriaCompo($criteria_rel_user_uid);
        $criteria->add($criteria_group_id);
        /**
         * Try to delete
         */
        if ($relgroupuserFactory->deleteAll($criteria)) {
            redirect_header('groups.php', 2, _MD_YOGURT_GROUPKICKED);
        } else {
            redirect_header('groups.php', 2, _MD_YOGURT_NOCACHACA);
        }
    } else {
        redirect_header('groups.php', 2, _MD_YOGURT_NOCACHACA);
    }
}

require dirname(dirname(__DIR__)) . '/footer.php';
