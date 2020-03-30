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

$tribe_id     = (int)$_POST['tribe_id'];
$rel_user_uid = (int)$_POST['rel_user_uid'];

if (1 != $_POST['confirm']) {
    xoops_confirm(['rel_user_uid' => $rel_user_uid, 'tribe_id' => $tribe_id, 'confirm' => 1], 'kickfromtribe.php', _MD_YOGURT_ASKCONFIRMKICKFROMTRIBE, _MD_YOGURT_CONFIRMKICK);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $reltribeuserFactory = new Yogurt\ReltribeuserHandler($xoopsDB);
    $tribesFactory       = new Yogurt\TribesHandler($xoopsDB);
    $tribe               = $tribesFactory->get($tribe_id);
    //  echo "<pre>";
    //  print_r($tribe);
    if ($xoopsUser->getVar('uid') == $tribe->getVar('owner_uid')) {
        $criteria_rel_user_uid = new \Criteria('rel_user_uid', $rel_user_uid);
        $criteria_tribe_id     = new \Criteria('rel_tribe_id', $tribe_id);
        $criteria              = new \CriteriaCompo($criteria_rel_user_uid);
        $criteria->add($criteria_tribe_id);
        /**
         * Try to delete
         */
        if ($reltribeuserFactory->deleteAll($criteria)) {
            redirect_header('tribes.php', 2, _MD_YOGURT_TRIBEKICKED);
        } else {
            redirect_header('tribes.php', 2, _MD_YOGURT_NOCACHACA);
        }
    } else {
        redirect_header('tribes.php', 2, _MD_YOGURT_NOCACHACA);
    }
}

include __DIR__ . '/../../footer.php';
