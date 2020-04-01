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

/**
 * Factories of tribes
 */
$reltribeuserFactory = new Yogurt\ReltribeuserHandler($xoopsDB);
$tribesFactory       = new Yogurt\TribesHandler($xoopsDB);

$tribe_id = \Xmf\Request::getInt('tribe_id', 0, 'POST');

if (!isset($_POST['confirm']) || 1 != $_POST['confirm']) {
    xoops_confirm(['tribe_id' => $tribe_id, 'confirm' => 1], 'delete_tribe.php', _MD_YOGURT_ASKCONFIRMTRIBEDELETION, _MD_YOGURT_CONFIRMTRIBEDELETION);
} else {
    /**
     * Creating the factory  and the criteria to delete the picture
     * The user must be the owner
     */
    $criteria_tribe_id = new \Criteria('tribe_id', $tribe_id);
    $uid               = (int)$xoopsUser->getVar('uid');
    $criteria_uid      = new \Criteria('owner_uid', $uid);
    $criteria          = new \CriteriaCompo($criteria_tribe_id);
    $criteria->add($criteria_uid);

    /**
     * Try to delete
     */
    if (1 == $tribesFactory->getCount($criteria)) {
        if ($tribesFactory->deleteAll($criteria)) {
            $criteria_rel_tribe_id = new \Criteria('rel_tribe_id', $tribe_id);
            $reltribeuserFactory->deleteAll($criteria_rel_tribe_id);
            redirect_header('tribes.php?uid=' . $uid, 3, _MD_YOGURT_TRIBEDELETED);
        } else {
            redirect_header('tribes.php?uid=' . $uid, 3, _MD_YOGURT_NOCACHACA);
        }
    }
}

require  dirname(dirname(__DIR__)) . '/footer.php';
