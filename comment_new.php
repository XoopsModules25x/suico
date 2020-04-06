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

/**
 * Xoops header
 */

use XoopsModules\Yogurt;

require __DIR__ . '/header.php';

$controller = new Yogurt\ControllerGroups($xoopsDB, $xoopsUser);

/**
 * Receiving info from get parameters
 */
$group_id = $_GET['com_itemid'];
$criteria = new \Criteria('group_id', $group_id);
$groups   = $controller->groupsFactory->getObjects($criteria);
$group    = $groups[0];

$com_itemid = \Xmf\Request::getInt('com_itemid', 0, 'GET');
if ($com_itemid > 0) {
    $com_replytitle = _MD_YOGURT_GROUPS . ': ' . $group->getVar('group_title');
    require XOOPS_ROOT_PATH . '/include/comment_new.php';
}
