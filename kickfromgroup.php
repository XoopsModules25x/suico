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
$group_id     = Request::getInt('group_id', 0, 'POST');
$rel_user_uid = Request::getInt('rel_user_uid', 0, 'POST');
if (1 !== Request::getInt('confirm', 0, 'POST')) {
    xoops_confirm(
        [
            'rel_user_uid' => $rel_user_uid,
            'group_id'     => $group_id,
            'confirm'      => 1,
        ],
        'kickfromgroup.php',
        _MD_SUICO_ASKCONFIRMKICKFROMGROUP,
        _MD_SUICO_CONFIRMKICK
    );
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $relgroupuserFactory = new RelgroupuserHandler(
        $xoopsDB
    );
    $groupsFactory       = new GroupsHandler($xoopsDB);
    $group               = $groupsFactory->get2($group_id);
    //  echo "<pre>";
    //  print_r($group);
    if ($xoopsUser->getVar('uid') === $group->getVar('owner_uid')) {
        $criteria_rel_user_uid = new Criteria('rel_user_uid', $rel_user_uid);
        $criteria_group_id     = new Criteria('rel_group_id', $group_id);
        $criteria              = new CriteriaCompo($criteria_rel_user_uid);
        $criteria->add($criteria_group_id);
        /**
         * Try to delete
         */
        if ($relgroupuserFactory->deleteAll($criteria)) {
            redirect_header('group.php?group_id=' . $group_id . '', 2, _MD_SUICO_GROUPKICKED);
        } else {
            redirect_header('group.php?group_id=' . $group_id . '', 2, _MD_SUICO_ERROR);
        }
    } else {
        redirect_header('group.php?group_id=' . $group_id . '', 2, _MD_SUICO_ERROR);
    }
}
require dirname(__DIR__, 2) . '/footer.php';
