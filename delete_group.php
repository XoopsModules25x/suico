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
    RelgroupuserHandler,
    GroupsHandler
};

require __DIR__ . '/header.php';
/**
 * Factories of groups
 */
$relgroupuserFactory = new RelgroupuserHandler($xoopsDB);
$groupsFactory       = new GroupsHandler($xoopsDB);
$group_id            = Request::getInt('group_id', 0, 'POST');
if (!isset($_POST['confirm']) || 1 !== Request::getInt('confirm', 0, 'POST')) {
    xoops_confirm(
        [
            'group_id' => $group_id,
            'confirm'  => 1,
        ],
        'delete_group.php',
        _MD_SUICO_ASKCONFIRMGROUPDELETION,
        _MD_SUICO_CONFIRMGROUPDELETION
    );
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $criteria_group_id = new Criteria(
        'group_id', $group_id
    );
    $uid               = (int)$xoopsUser->getVar('uid');
    $criteriaUid       = new Criteria('owner_uid', $uid);
    $criteria          = new CriteriaCompo($criteria_group_id);
    $criteria->add($criteriaUid);
    /**
     * Try to delete
     */
    if (1 == $groupsFactory->getCount($criteria)) {
        if ($groupsFactory->deleteAll($criteria)) {
            $criteria_rel_group_id = new Criteria('rel_group_id', $group_id);
            $relgroupuserFactory->deleteAll($criteria_rel_group_id);
            redirect_header('groups.php?uid=' . $uid, 3, _MD_SUICO_GROUP_DELETED);
        } else {
            redirect_header('groups.php?uid=' . $uid, 3, _MD_SUICO_ERROR);
        }
    }
}
require dirname(__DIR__, 2) . '/footer.php';
