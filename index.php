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
    FriendsController,
    IndexController
};

/**
 * Xoops header
 */
$GLOBALS['xoopsOption']['template_main'] = 'suico_index.tpl';
require __DIR__ . '/header.php';
$helper->loadLanguage('user');
$controller = new IndexController($xoopsDB, $xoopsUser);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
$uid        = $controller->uidOwner;
$categories = [];
/* @var  \XoopsGroupPermHandler $grouppermHandler */
$grouppermHandler = xoops_getHandler('groupperm');
$groups           = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : [XOOPS_GROUP_ANONYMOUS];
if (is_object($GLOBALS['xoopsUser']) && $uid == $GLOBALS['xoopsUser']->getVar('uid')) {
    //disable cache
    $GLOBALS['xoopsConfig']['module_cache'][$GLOBALS['xoopsModule']->getVar('mid')] = 0;
    //    include $GLOBALS['xoops']->path('header.php');
    /* @var XoopsConfigHandler $configHandler */
    $configHandler              = xoops_getHandler('config');
    $GLOBALS['xoopsConfigUser'] = $configHandler->getConfigsByCat(XOOPS_CONF_USER);
    $GLOBALS['xoopsTpl']->assign('user_ownpage', true);
    if (1 == $GLOBALS['xoopsConfigUser']['self_delete']) {
        $GLOBALS['xoopsTpl']->assign('user_candelete', true);
        $GLOBALS['xoopsTpl']->assign('lang_deleteaccount', _US_DELACCOUNT);
    } else {
        $GLOBALS['xoopsTpl']->assign('user_candelete', false);
    }
    $GLOBALS['xoopsTpl']->assign('user_changeemail', $GLOBALS['xoopsConfigUser']['allow_chgmail']);
    $thisUser = &$GLOBALS['xoopsUser'];
} else {
    /* @var XoopsMemberHandler $memberHandler */
    $memberHandler = xoops_getHandler('member');
    $thisUser      = $memberHandler->getUser($uid);
    // Redirect if not a user or not active and the current user is not admin
    if (!is_object($thisUser) || (!$thisUser->isActive() && (!$GLOBALS['xoopsUser'] || !$GLOBALS['xoopsUser']->isAdmin()))) {
        redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname', 'n'), 3, _US_SELECTNG);
    }
    /**
     * Access permission check
     *
     * Note:
     * "thisUser" refers to the user whose profile will be accessed; "xoopsUser" refers to the current user $GLOBALS['xoopsUser']
     * "Basic Groups" refer to XOOPS_GROUP_ADMIN, XOOPS_GROUP_USERS and XOOPS_GROUP_ANONYMOUS;
     * "Non Basic Groups" refer to all other custom groups
     *
     * Admin groups: If thisUser belongs to admin groups, the xoopsUser has access if and only if one of xoopsUser's groups is allowed to access admin group; else
     * Non basic groups: If thisUser belongs to one or more non basic groups, the xoopsUser has access if and only if one of xoopsUser's groups is allowed to allowed to any of the non basic groups; else
     * User group: If thisUser belongs to User group only, the xoopsUser has access if and only if one of his groups is allowed to access User group
     */
    // Redirect if current user is not allowed to access the user's profile based on group permission
    $groups_basic             = [XOOPS_GROUP_ADMIN, XOOPS_GROUP_USERS, XOOPS_GROUP_ANONYMOUS];
    $groups_thisUser          = $thisUser->getGroups();
    $groups_thisUser_nonbasic = array_diff($groups_thisUser, $groups_basic);
    $groups_xoopsUser         = $groups;
    /* @var  XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler  = xoops_getHandler('groupperm');
    $groups_accessible = $grouppermHandler->getItemIds('profile_access', $groups_xoopsUser, $helper->getModule()->getVar('mid'));
    $rejected          = false;
    if ($thisUser->isAdmin()) {
        $rejected = !in_array(XOOPS_GROUP_ADMIN, $groups_accessible);
    } elseif ($groups_thisUser_nonbasic) {
        $rejected = !array_intersect($groups_thisUser_nonbasic, $groups_accessible);
    } else {
        $rejected = !in_array(XOOPS_GROUP_USERS, $groups_accessible);
    }
    if ($rejected) {
        // redirect_header(XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname', 'n'), 3, _NOPERM);
    }
    if (is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin()) {
        //disable cache
        $GLOBALS['xoopsConfig']['module_cache'][$GLOBALS['xoopsModule']->getVar('mid')] = 0;
    }
    $GLOBALS['xoopsTpl']->assign('user_ownpage', false);
}
$GLOBALS['xoopsTpl']->assign('user_uid', $thisUser->getVar('uid'));
if (is_object($GLOBALS['xoopsUser']) && $GLOBALS['xoopsUser']->isAdmin()) {
    $GLOBALS['xoopsTpl']->assign('lang_editprofile', _US_EDITPROFILE);
    $GLOBALS['xoopsTpl']->assign('lang_deleteaccount', _US_DELACCOUNT);
    $GLOBALS['xoopsTpl']->assign('userlevel', $thisUser->isActive());
}
// Dynamic User Profiles
$thisUsergroups    = $thisUser->getGroups();
$visibilityHandler = $helper->getHandler('Visibility');
//search for visible Fields or null for none
$field_ids_visible = $visibilityHandler->getVisibleFields($thisUsergroups, $groups);
$profileHandler    = $helper->getHandler('Profile');
$fields            = $profileHandler->loadFields();
$categoryHandler   = $helper->getHandler('Category');
$categoryCriteria  = new CriteriaCompo();
$categoryCriteria->setSort('cat_weight');
$cats = $categoryHandler->getObjects($categoryCriteria, true, false);
unset($categoryCriteria);
$avatar = '';
if ($thisUser->getVar('user_avatar') && 'blank.gif' !== $thisUser->getVar('user_avatar')) {
    $avatar = XOOPS_UPLOAD_URL . '/' . $thisUser->getVar('user_avatar');
}
foreach (array_keys($cats) as $i) {
    $categories[$i] = $cats[$i];
}
$profileHandler = $helper->getHandler('Profile');
$profile        = $profileHandler->get($thisUser->getVar('uid'));
// Add dynamic fields
foreach (array_keys($fields) as $i) {
    //If field is not visible, skip
    //if ( $field_ids_visible && !in_array($fields[$i]->getVar('field_id'), $field_ids_visible) ) continue;
    if (!in_array($fields[$i]->getVar('field_id'), $field_ids_visible)) {
        continue;
    }
    $cat_id = $fields[$i]->getVar('cat_id');
    $value  = $fields[$i]->getOutputValue($thisUser, $profile);
    if (is_array($value)) {
        $value = implode('<br>', array_values($value));
    }
    if ($value) {
        $categories[$cat_id]['fields'][] = ['title' => $fields[$i]->getVar('field_title'), 'value' => $value];
        $weights[$cat_id][]              = $fields[$i]->getVar('cat_id');
    }
}
$GLOBALS['xoopsTpl']->assign('categories', $categories);
// Dynamic user profiles end
$featuredvideocode  = '';
$featuredvideotitle = '';
$featuredvideodesc  = '';
//require_once __DIR__ . '/class/suico_controller.php';
//if (!@ require_once XOOPS_ROOT_PATH . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/user.php') {
//    require_once XOOPS_ROOT_PATH . '/language/english/user.php';
//}
/**
 * This variable define the beginning of the navigation must be
 * set here so all calls to database will take this into account
 */
$start = Request::getInt('start', 0, 'GET');
/**
 * Criteria for featuredvideo
 */
$criteriaUidVideo       = new Criteria('uid_owner', $controller->uidOwner);
$criteria_featuredvideo = new Criteria('featured_video', '1');
$criteria_video         = new CriteriaCompo($criteria_featuredvideo);
$criteria_video->add($criteriaUidVideo);
if ((isset($nbSections['countVideos']) && $nbSections['countVideos'] > 0) && ($videos = $controller->videosFactory->getObjects($criteria_video))) {
    $featuredvideocode  = $videos[0]->getVar('youtube_code');
    $featuredvideotitle = $videos[0]->getVar('video_title');
    $featuredvideodesc  = $videos[0]->getVar('video_desc');
}
/**
 * Groups
 */
$criteria_groups = new Criteria('rel_user_uid', $controller->uidOwner);
$groups          = $controller->relgroupusersFactory->getGroups(8, $criteria_groups);
/**
 * Visitors
 */
$controller->visitorsFactory->purgeVisits();
if (0 === $controller->isAnonym) {
    // Fetching last visitors
    if ($controller->uidOwner !== $xoopsUser->getVar('uid')) {
        $criteriaDeleteOldVisits = new CriteriaCompo(new Criteria('uid_owner', $controller->uidOwner));
        $criteriaDeleteOldVisits->add(new Criteria('uid_visitor', $xoopsUser->getVar('uid')));
        $visitorsFactory->deleteAll($criteriaDeleteOldVisits, true);



        $visitor_now = $controller->visitorsFactory->create();
        $visitor_now->setVar('uid_owner', $controller->uidOwner);
        $visitor_now->setVar('uid_visitor', $xoopsUser->getVar('uid'));
        $visitor_now->setVar('uname_visitor', $xoopsUser->getVar('uname'));
        $controller->visitorsFactory->insert2($visitor_now);
    }
    $criteria_visitors = new Criteria('uid_owner', $controller->uidOwner);
    //$criteria_visitors->setLimit(5);
    $visitorsObjectArray = $controller->visitorsFactory->getObjects(
        $criteria_visitors
    );
    // Lets populate an array with the data from visitors
    $i             = 0;
    $visitorsArray = [];
    if (is_array($visitorsObjectArray) && count($visitorsObjectArray) > 0) {
        foreach ($visitorsObjectArray as $visitor) {
            $myvisitor = [];
            if (null !== $visitor) {
                $myvisitor['uid_visitor']    = $visitor->getVar('uid_visitor', 's');
                $myvisitor['uname_visitor']  = $visitor->getVar('uname_visitor', 's');
                $myvisitor['date_visited']   = formatTimestamp($visitor->getVar('date_visited'), 'S');
                $memberHandler               = xoops_getHandler('member');
                $visitor                     = $memberHandler->getUser($visitor->getVar('uid_visitor'));
                $myvisitor['avatar_visitor'] = $visitor->getVar('user_avatar', 's');
                $visitorsArray[]             = $myvisitor;
                unset($myvisitor);
                ++$i;
            }
        }
    }
    $xoopsTpl->assign('visitors', $visitorsArray);
    $xoopsTpl->assign('lang_visitors', _MD_SUICO_VISITORS);
//    $criteria_deletevisitors = new criteria('uid_owner', $uid);
//    $criteria_deletevisitors->setStart(5);
    //        print_r($criteria_deletevisitors);
    //        $visitorsFactory->deleteAll($criteria_deletevisitors, true);
}
$avatar        = $controller->owner->getVar('user_avatar');
$memberHandler = xoops_getHandler('member');
$thisUser      = $memberHandler->getUser($controller->uidOwner);
$myts          = \MyTextSanitizer::getInstance();
//navbar
$xoopsTpl->assign('lang_mysection', _MD_SUICO_MYPROFILE);
$xoopsTpl->assign('section_name', _MD_SUICO_PROFILE);
//$xoopsTpl->assign('path_suico_uploads',$helper->getConfig('link_path_upload'));
//groups
$xoopsTpl->assign('groups', $groups);
if (isset($nbSections['countGroups']) && $nbSections['countGroups'] <= 0) {
    $xoopsTpl->assign('lang_nogroupsyet', _MD_SUICO_NOGROUPSYET);
}
$xoopsTpl->assign('lang_viewallgroups', _MD_SUICO_ALLGROUPS);
//Avatar and Main
$xoopsTpl->assign('avatar_url', $avatar);
$xoopsTpl->assign('lang_selectavatar', _MD_SUICO_SELECTAVATAR);
$xoopsTpl->assign('lang_selectfeaturedvideo', _MD_SUICO_SELECTFEATUREDVIDEO);
$xoopsTpl->assign('lang_noavatar', _MD_SUICO_NOAVATARYET);
$xoopsTpl->assign('lang_nofeaturedvideo', _MD_SUICO_NOFEATUREDVIDEOYET);
$xoopsTpl->assign('lang_featuredvideo', _MD_SUICO_VIDEO_FEATURED);
$xoopsTpl->assign('lang_viewallvideos', _MD_SUICO_ALLVIDEOS);
if (isset($nbSections['countVideos']) && $nbSections['countVideos'] > 0) {
    $xoopsTpl->assign('featuredvideocode', $featuredvideocode);
    $xoopsTpl->assign('featuredvideodesc', $featuredvideodesc);
    $xoopsTpl->assign('featuredvideotitle', $featuredvideotitle);
    $xoopsTpl->assign(
        'width',
        $helper->getConfig('width_maintube')
    ); // We still need to configure the main size in the configs and change the template
    $xoopsTpl->assign(
        'height',
        $helper->getConfig('height_maintube')
    );
}
/**
 * Friends
 */
$friendController = new FriendsController($xoopsDB, $xoopsUser);
if ($xoopsUser) {
    $friendrequest = 0;
    if (1 === $friendController->isOwner) {
        $criteria_uidfriendrequest = new Criteria('friendrequestto_uid', $friendController->uidOwner);
        $newFriendrequest          = $friendController->friendrequestFactory->getObjects($criteria_uidfriendrequest);
        if ($newFriendrequest) {
            $countFriendrequest     = count($newFriendrequest);
            $memberHandler          = xoops_getHandler('member');
            $friendrequester        = $memberHandler->getUser($newFriendrequest[0]->getVar('friendrequester_uid'));
            $friendrequester_uid    = $friendrequester->getVar('uid');
            $friendrequester_uname  = $friendrequester->getVar('uname');
            $friendrequester_avatar = $friendrequester->getVar('user_avatar');
            $friendrequest_id       = $newFriendrequest[0]->getVar('friendreq_id');
            $friendrequest          = 1;
        }
    }
    //requests to become friend
    if (1 === $friendrequest) {
        $xoopsTpl->assign('lang_you_have_x_friendrequests', sprintf(_MD_SUICO_YOU_HAVE_X_FRIENDREQUESTS, $countFriendrequest));
        $xoopsTpl->assign('friendrequester_uid', $friendrequester_uid);
        $xoopsTpl->assign('friendrequester_uname', $friendrequester_uname);
        $xoopsTpl->assign('friendrequester_avatar', $friendrequester_avatar);
        $xoopsTpl->assign('friendrequest', $friendrequest);
        $xoopsTpl->assign('friendrequest_id', $friendrequest_id);
        $xoopsTpl->assign('lang_rejected', _MD_SUICO_UNKNOWN_REJECTING);
        $xoopsTpl->assign('lang_accepted', _MD_SUICO_UNKNOWN_ACCEPTING);
        $xoopsTpl->assign('lang_acquaintance', _MD_SUICO_AQUAITANCE);
        $xoopsTpl->assign('lang_friend', _MD_SUICO_FRIEND);
        $xoopsTpl->assign('lang_bestfriend', _MD_SUICO_BESTFRIEND);
        $linkedpetioner = '<a href="index.php?uid=' . $friendrequester_uid . '">' . $friendrequester_uname . '</a>';
        $xoopsTpl->assign('lang_askingfriend', sprintf(_MD_SUICO_ASKINGFRIEND, $linkedpetioner));
    }
}
$xoopsTpl->assign('lang_askusertobefriend', _MD_SUICO_ASKBEFRIEND);
$xoopsTpl->assign('lang_addfriend', _MD_SUICO_ADDFRIEND);
$xoopsTpl->assign('lang_friendrequestpending', _MD_SUICO_FRIENDREQUEST_PENDING);
$xoopsTpl->assign('lang_myfriend', _MD_SUICO_MYFRIEND);
$xoopsTpl->assign('lang_friendrequestsent', _MD_SUICO_FRIENDREQUEST_SENT);
$xoopsTpl->assign('lang_acceptfriend', _MD_SUICO_FRIEND_ACCEPT);
$xoopsTpl->assign('lang_rejectfriend', _MD_SUICO_FRIEND_REJECT);
$criteria_friends = new Criteria('friend1_uid', $friendController->uidOwner);
$friends          = $friendController->friendshipsFactory->getFriends(8, $criteria_friends);
$xoopsTpl->assign('friends', $friends);
$xoopsTpl->assign('lang_friendstitle', sprintf(_MD_SUICO_FRIENDSTITLE, $friendController->nameOwner));
$xoopsTpl->assign('lang_viewallfriends', _MD_SUICO_ALLFRIENDS);
$xoopsTpl->assign('lang_nofriendsyet', _MD_SUICO_NOFRIENDSYET);
//search
$xoopsTpl->assign('lang_usercontributions', _MD_SUICO_USER_CONTRIBUTIONS);
//Profile
$xoopsTpl->assign('lang_detailsinfo', _MD_SUICO_USER_DETAILS);
$xoopsTpl->assign('lang_contactinfo', _MD_SUICO_CONTACTINFO);
//$xoopsTpl->assign('path_suico_uploads',$helper->getConfig('link_path_upload'));
$xoopsTpl->assign(
    'lang_max_countPicture',
    sprintf(_MD_SUICO_YOUCANHAVE, $helper->getConfig('countPicture'))
);
$xoopsTpl->assign('lang_delete', _MD_SUICO_DELETE);
$xoopsTpl->assign('lang_visitors', _MD_SUICO_VISITORS);
$xoopsTpl->assign('lang_profilevisitors', _MD_SUICO_PROFILEVISITORS);
$xoopsTpl->assign('lang_editprofile', _MD_SUICO_EDITPROFILE);
$xoopsTpl->assign('user_uname', $thisUser->getVar('uname'));
$xoopsTpl->assign('user_realname', $thisUser->getVar('name'));
$xoopsTpl->assign('lang_uname', _US_NICKNAME);
$xoopsTpl->assign('lang_website', _US_WEBSITE);
$userwebsite = '' !== $thisUser->getVar('url', 'E') ? '<a href="' . $thisUser->getVar(
        'url',
        'E'
    ) . '" target="_blank">' . $thisUser->getVar(
        'url'
    ) . '</a>' : '';
$xoopsTpl->assign('user_websiteurl', $userwebsite);
$xoopsTpl->assign('lang_email', _US_EMAIL);
$xoopsTpl->assign('lang_privmsg', _US_PM);
$xoopsTpl->assign('lang_location', _US_LOCATION);
$xoopsTpl->assign('user_location', $thisUser->getVar('user_from'));
$xoopsTpl->assign('lang_occupation', _US_OCCUPATION);
$xoopsTpl->assign('user_occupation', $thisUser->getVar('user_occ'));
$xoopsTpl->assign('lang_interest', _US_INTEREST);
$xoopsTpl->assign('user_interest', $thisUser->getVar('user_intrest'));
$xoopsTpl->assign('lang_extrainfo', _US_EXTRAINFO);
$var = $thisUser->getVar('bio', 'N');
$xoopsTpl->assign('user_extrainfo', $myts->displayTarea($var, 0, 1, 1));
$xoopsTpl->assign('lang_statistics', _US_STATISTICS);
$xoopsTpl->assign('lang_membersince', _US_MEMBERSINCE);
$var = $thisUser->getVar('user_regdate');
$xoopsTpl->assign('user_joindate', formatTimestamp($var, 's'));
$xoopsTpl->assign('lang_rank', _US_RANK);
$xoopsTpl->assign('lang_posts', _US_POSTS);
$xoopsTpl->assign('lang_basicInfo', _US_BASICINFO);
$xoopsTpl->assign('lang_more', _US_MOREABOUT);
$xoopsTpl->assign('lang_myinfo', _US_MYINFO);
$xoopsTpl->assign('user_posts', $thisUser->getVar('posts'));
$xoopsTpl->assign('lang_lastlogin', _US_LASTLOGIN);
$date = $thisUser->getVar('last_login');
if (!empty($date)) {
    $xoopsTpl->assign('user_lastlogin', formatTimestamp($date, 'm'));
}
$xoopsTpl->assign('lang_notregistered', _US_NOTREGISTERED);
$xoopsTpl->assign('lang_signature', _US_SIGNATURE);
$var = $thisUser->getVar('user_sig', 'N');
$xoopsTpl->assign('user_signature', $myts->displayTarea($var, 0, 1, 1));
$xoopsTpl->assign('user_viewemail', $thisUser->getVar('user_viewemail', 'E'));
if (1 === $thisUser->getVar('user_viewemail')) {
    $xoopsTpl->assign('user_email', $thisUser->getVar('email', 'E'));
} else {
    $xoopsTpl->assign('user_email', '&nbsp;');
}
$xoopsTpl->assign('user_onlinestatus', $thisUser->isOnline());
$xoopsTpl->assign('lang_onlinestatus', _MD_SUICO_ONLINESTATUS);
$xoopsTpl->assign('uname', $thisUser->getVar('uname'));
$xoopsTpl->assign('lang_realname', _US_REALNAME);
$xoopsTpl->assign('name', $thisUser->getVar('name'));
$gpermHandler  = xoops_getHandler('groupperm');
$groups        = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$moduleHandler = xoops_getHandler('module');
$criteria      = new CriteriaCompo(new Criteria('hassearch', 1));
$criteria->add(new Criteria('isactive', 1));
$mids = array_keys($moduleHandler->getList($criteria));
//user rank
$userrank = $thisUser->rank();
if ($userrank['image']) {
    $xoopsTpl->assign('user_rankimage', '<img src="' . XOOPS_UPLOAD_URL . '/' . $userrank['image'] . '" alt="">');
}
$xoopsTpl->assign('user_ranktitle', $userrank['title']);
foreach ($mids as $mid) {
    if ($gpermHandler->checkRight('module_read', $mid, $groups)) {
        $module   = $moduleHandler->get($mid);
        $user_uid = $thisUser->getVar('uid');
        $results  = $module->search('', '', 5, 0, $user_uid);
        if (is_array($results)) {
            $count = count($results);
        }
        if (is_array($results) && $count > 0) {
            for ($i = 0; $i < $count; ++$i) {
                if (isset($results[$i]['image']) && '' !== $results[$i]['image']) {
                    $results[$i]['image'] = 'modules/' . $module->getVar('dirname') . '/' . $results[$i]['image'];
                } else {
                    $results[$i]['image'] = 'images/icons/posticon2.gif';
                }
                if (!preg_match('#^http[s]*:\/\/#i', $results[$i]['link'])) {
                    $results[$i]['link'] = 'modules/' . $module->getVar('dirname') . '/' . $results[$i]['link'];
                }
                $results[$i]['title'] = $myts->htmlSpecialChars($results[$i]['title']);
                $results[$i]['time']  = $results[$i]['time'] ? formatTimestamp($results[$i]['time']) : '';
            }
            if (5 === $count) {
                $showall_link = '<a href="../../search.php?action=showallbyuser&amp;mid=' . $mid . '&amp;uid=' . $thisUser->getVar(
                        'uid'
                    ) . '">' . _US_SHOWALL . '</a>';
            } else {
                $showall_link = '';
            }
            $xoopsTpl->append(
                'modules',
                [
                    'name'         => $module->getVar('name'),
                    'results'      => $results,
                    'showall_link' => $showall_link,
                ]
            );
        }
        unset($module);
    }
}
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
