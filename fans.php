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
    FriendsController
};

$GLOBALS['xoopsOption']['template_main'] = 'suico_fans.tpl';
require __DIR__ . '/header.php';
$controller = new FriendsController($xoopsDB, $xoopsUser);
$start      = Request::getInt('start', 0, 'GET');
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
/**
 * Friends
 */
$criteria_friends    = new Criteria('friend2_uid', $controller->uidOwner);
$criteria_fans       = new Criteria('fan', 1);
$criteria_compo_fans = new CriteriaCompo($criteria_friends);
$criteria_compo_fans->add($criteria_fans);
$countFriends = $controller->friendshipsFactory->getCount($criteria_compo_fans);
$criteria_compo_fans->setLimit($helper->getConfig('friendsperpage'));
$criteria_compo_fans->setStart($start);
$vetor = $controller->friendshipsFactory->getFans('', $criteria_compo_fans, 0);
if (0 === $countFriends) {
    $xoopsTpl->assign('lang_nofansyet', _MD_SUICO_NOFANSYET);
}
/**
 * Let's get the user name of the owner of the album
 */
$owner      = new \XoopsUser();
$identifier = $owner::getUnameFromId($controller->uidOwner);
/**
 * Creating the navigation bar if you have a lot of friends
 */
$navigationBar = new \XoopsPageNav(
    $countFriends, $helper->getConfig('friendsperpage'), $start, 'start', 'uid=' . (int)$controller->uidOwner
);
$navegacao     = $navigationBar->renderImageNav(2);
//navbar
$xoopsTpl->assign('lang_mysection', _MD_SUICO_MYFANS);
$xoopsTpl->assign('section_name', _MD_SUICO_FANS);
//Navigation Bar
$xoopsTpl->assign('navegacao', $navegacao);
$xoopsTpl->assign('lang_fanstitle', sprintf(_MD_SUICO_FANSTITLE, $identifier));
//$xoopsTpl->assign('path_suico_uploads',$helper->getConfig('link_path_upload'));
$xoopsTpl->assign('friends', $vetor);
$xoopsTpl->assign('lang_delete', _MD_SUICO_DELETE);
$xoopsTpl->assign('lang_evaluate', _MD_SUICO_FRIENDSHIP_CONFIGS);
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
