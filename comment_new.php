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
    GroupController
};

require __DIR__ . '/header.php';
$controller = new GroupController($xoopsDB, $xoopsUser);
/**
 * Receiving info from get parameters
 */
$groupId   = Request::getInt('com_itemid', 0, 'GET');
$criteria  = new Criteria('group_id', $groupId);
$groups    = $controller->groupsFactory->getObjects($criteria);
$group     = $groups[0];
$comItemid = Request::getInt('com_itemid', 0, 'GET');
if ($comItemid > 0) {
    $com_replytitle = _MD_SUICO_GROUPS . ': ' . $group->getVar('group_title');
    require XOOPS_ROOT_PATH . '/include/comment_new.php';
}
