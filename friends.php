<?php declare(strict_types=1);

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

use Xmf\Request;
use XoopsModules\Yogurt;

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_friends.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\FriendsController($xoopsDB, $xoopsUser);

/**

 */


$start = Request::getInt('start', 0, 'GET');

/**
 * Filter for new friend petition
 */
$petition = 0;
if (1 === $controller->isOwner) {
    $criteria_uidpetition = new Criteria('petitionto_uid', $controller->uidOwner);
    $newpetition          = $controller->petitionsFactory->getObjects($criteria_uidpetition);
    if ($newpetition) {
        $nb_petitions      = count($newpetition);
        $petitionerHandler = xoops_getHandler('member');
        $petitioner        = $petitionerHandler->getUser($newpetition[0]->getVar('petitioner_uid'));
        $petitioner_uid    = $petitioner->getVar('uid');
        $petitioner_uname  = $petitioner->getVar('uname');
        $petitioner_avatar = $petitioner->getVar('user_avatar');
        $petition_id       = $newpetition[0]->getVar('friendpet_id');
        $petition          = 1;
    }
}

/**
 * Friends
 */
$criteria_friends = new Criteria('friend1_uid', (int)$controller->uidOwner);
$nb_friends       = $controller->friendshipsFactory->getCount($criteria_friends);
$criteria_friends->setLimit($helper->getConfig('friendsperpage'));
$criteria_friends->setStart($start);
$vetor = $controller->friendshipsFactory->getFriends('', $criteria_friends, 0);
if (0 === $nb_friends) {
    $xoopsTpl->assign('lang_nofriendsyet', _MD_YOGURT_NOFRIENDSYET);
}

/**
 * Let's get the user name of the owner of the album
 */
$owner      = new XoopsUser();
$identifier = $owner::getUnameFromId($controller->uidOwner);

/**
 * Creating the navigation bar if you have a lot of friends
 */
$navigationBar = new XoopsPageNav(
    $nbSections['nbFriends'], $helper->getConfig('friendsperpage'), $start, 'start', 'uid=' . (int)$controller->uidOwner
);
$navegacao       = $navigationBar->renderImageNav(2);

//petitions to become friend
if (1 === $petition) {
    $xoopsTpl->assign('lang_youhavexpetitions', sprintf(_MD_YOGURT_YOUHAVEXPETITIONS, $nb_petitions));
    $xoopsTpl->assign('petitioner_uid', $petitioner_uid);
    $xoopsTpl->assign('petitioner_uname', $petitioner_uname);
    $xoopsTpl->assign('petitioner_avatar', $petitioner_avatar);
    $xoopsTpl->assign('petition', $petition);
    $xoopsTpl->assign('petition_id', $petition_id);
    $xoopsTpl->assign('lang_rejected', _MD_YOGURT_UNKNOWNREJECTING);
    $xoopsTpl->assign('lang_accepted', _MD_YOGURT_UNKNOWNACCEPTING);
    $xoopsTpl->assign('lang_acquaintance', _MD_YOGURT_AQUAITANCE);
    $xoopsTpl->assign('lang_friend', _MD_YOGURT_FRIEND);
    $xoopsTpl->assign('lang_bestfriend', _MD_YOGURT_BESTFRIEND);
    $linkedpetioner = '<a href="index.php?uid=' . $petitioner_uid . '">' . $petitioner_uname . '</a>';
    $xoopsTpl->assign('lang_askingfriend', sprintf(_MD_YOGURT_ASKINGFRIEND, $linkedpetioner));
}
$xoopsTpl->assign('lang_askusertobefriend', _MD_YOGURT_ASKBEFRIEND);
$xoopsTpl->assign('lang_addfriend', _MD_YOGURT_ADDFRIEND);
$xoopsTpl->assign('lang_friendrequestpending', _MD_YOGURT_FRIENDREQUESTPENDING);
$xoopsTpl->assign('lang_myfriend', _MD_YOGURT_MYFRIEND);
$xoopsTpl->assign('lang_friendrequestsent', _MD_YOGURT_FRIENDREQUESTSENT);
$xoopsTpl->assign('lang_acceptfriend', _MD_YOGURT_ACCEPTFRIEND);
$xoopsTpl->assign('lang_rejectfriend', _MD_YOGURT_REJECTFRIEND);
//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYFRIENDS);
$xoopsTpl->assign('lang_friendstitle', sprintf(_MD_YOGURT_FRIENDSTITLE, $identifier));
//$xoopsTpl->assign('path_yogurt_uploads',$helper->getConfig('link_path_upload'));

$xoopsTpl->assign('friends', $vetor);

$xoopsTpl->assign('lang_delete', _MD_YOGURT_DELETE);
$xoopsTpl->assign('lang_evaluate', _MD_YOGURT_FRIENDSHIPCONFIGS);
$xoopsTpl->assign('allow_friendshiplevel', $helper->getConfig('allow_friendshiplevel'));
$xoopsTpl->assign('allow_fanssevaluation', $helper->getConfig('allow_fanssevaluation'));

// Navigation
$xoopsTpl->assign('navegacao', $navegacao);

require __DIR__ . '/footer.php';
require dirname(dirname(__DIR__)) . '/footer.php';
