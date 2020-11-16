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
 * @copyright       XOOPS https://xoops.org
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          XOOPS https://xoops.org
 */

use Xmf\Request;
use XoopsModules\Suico\{
    FriendrequestHandler
};

/**
 * CSS & JS
 */
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/suico.css'
);
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/suicob4.css'
);
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/pagination.css'
);
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/magnific-popup.css'
);
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.magnific-popup.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/suico.js');
//$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/crud.js');
//if (mb_stripos($_SERVER['REQUEST_URI'], 'memberslist.php')) {
//  if ('datatables' == $xoopsModuleConfig['memberslisttemplate']) {
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.dataTables.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/responsive.dataTables.min.css');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.dataTables.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/dataTables.responsive.min.js');
//}
//}
//permissions
$xoopsTpl->assign('allow_notes', $controller->checkPrivilegeBySection('notes'));
$xoopsTpl->assign('allow_friends', $controller->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_groups', $controller->checkPrivilegeBySection('groups'));
$xoopsTpl->assign('allow_pictures', $controller->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controller->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controller->checkPrivilegeBySection('audio'));
$xoopsTpl->assign('allow_profile_contact', $controller->checkPrivilege('profile_contact') ? 1 : 0);
$xoopsTpl->assign('allow_profile_general', $controller->checkPrivilege('profile_general') ? 1 : 0);
$xoopsTpl->assign('allow_profile_stats', $controller->checkPrivilege('profile_stats') ? 1 : 0);
//Owner data
$xoopsTpl->assign('uid_owner', $controller->uidOwner);
$xoopsTpl->assign('owner_uname', $controller->nameOwner);
$xoopsTpl->assign('isOwner', $controller->isOwner);
$xoopsTpl->assign('isAnonym', $controller->isAnonym);
$xoopsTpl->assign('isUser', $controller->isUser);
$xoopsTpl->assign('isFriend', $controller->isFriend);
//Is Webmaster/Administrator
if ($xoopsUser && $xoopsUser->isAdmin(1)) {
    $xoopsTpl->assign('isWebmaster', '1');
} else {
    $xoopsTpl->assign('isWebmaster', '0');
}
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$xoopsTpl->assign('countGroups', $nbSections['countGroups']);
$xoopsTpl->assign('countPhotos', $nbSections['countPhotos']);
$xoopsTpl->assign('countVideos', $nbSections['countVideos']);
$xoopsTpl->assign('countNotes', $nbSections['countNotes']);
$xoopsTpl->assign('countFriends', $nbSections['countFriends']);
$xoopsTpl->assign('countAudio', $nbSections['countAudios']);
//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_home', _MD_SUICO_HOME);
$xoopsTpl->assign('lang_photos', _MD_SUICO_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_SUICO_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_SUICO_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_SUICO_VIDEOS);
$xoopsTpl->assign('lang_notebook', _MD_SUICO_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_SUICO_PROFILE);
$xoopsTpl->assign('lang_groups', _MD_SUICO_GROUPS);
$xoopsTpl->assign('lang_configs', _MD_SUICO_CONFIGS_TITLE);
//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
//page atributes
$xoopsTpl->assign(
    'xoops_pagetitle',
    sprintf(_MD_SUICO_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner)
);
//Navbar User Info
$avatar        = $controller->owner->getVar('user_avatar');
$memberHandler = xoops_getHandler('member');
$thisUser      = $memberHandler->getUser($controller->uidOwner);
$myts          = \MyTextSanitizer::getInstance();
$xoopsTpl->assign('user_uname', $thisUser->getVar('uname'));
$xoopsTpl->assign('user_realname', $thisUser->getVar('name'));
$xoopsTpl->assign('lang_uname', _US_NICKNAME);
$xoopsTpl->assign('lang_website', _US_WEBSITE);
$userwebsite = ('' != $thisUser->getVar('url', 'E')) ? '<a href="' . $thisUser->getVar('url', 'E') . '" target="_blank">' . $thisUser->getVar('url') . '</a>' : '';
$xoopsTpl->assign('user_websiteurl', $userwebsite);
$xoopsTpl->assign('lang_email', _US_EMAIL);
$xoopsTpl->assign('lang_privmsg', _US_PM);
$xoopsTpl->assign('user_viewemail', $thisUser->getVar('user_viewemail', 'E'));
if (1 == $thisUser->getVar('user_viewemail')) {
    $xoopsTpl->assign('user_email', $thisUser->getVar('email', 'E'));
} else {
    $xoopsTpl->assign('user_email', '&nbsp;');
}
$xoopsTpl->assign('lang_location', _US_LOCATION);
$xoopsTpl->assign('user_location', $thisUser->getVar('user_from'));
$xoopsTpl->assign('lang_occupation', _US_OCCUPATION);
$xoopsTpl->assign('user_occupation', $thisUser->getVar('user_occ'));
$xoopsTpl->assign('avatar_url', $avatar);
$xoopsTpl->assign('lang_selectavatar', _MD_SUICO_SELECTAVATAR);
$xoopsTpl->assign('lang_noavatar', _MD_SUICO_NOAVATARYET);
$xoopsTpl->assign('user_onlinestatus', $thisUser->isOnline());
$xoopsTpl->assign('lang_onlinestatus', _MD_SUICO_ONLINESTATUS);
/**
 * Filter for new friend request
 */
if ($xoopsUser) {
    $friendrequest = 0;
    if (1 === $controller->isOwner) {
        $criteria_uidrequest = new Criteria('friendrequestto_uid', $controller->uidOwner);
        $newFriendrequest    = $controller->friendrequestFactory->getObjects($criteria_uidrequest);
        if ($newFriendrequest) {
            $countFriendrequests    = count($newFriendrequest);
            $friendrequesterHandler = xoops_getHandler('member');
            $friendrequester        = $friendrequesterHandler->getUser($newFriendrequest[0]->getVar('requester_uid'));
            $friendrequester_uid    = $friendrequester->getVar('uid');
            $friendrequester_uname  = $friendrequester->getVar('uname');
            $friendrequester_avatar = $friendrequester->getVar('user_avatar');
            $friendrequest_id       = $newFriendrequest[0]->getVar('friendreq_id');
            $friendrequest          = 1;
        }
    }
    $criteria_friends = new Criteria('friend1_uid', $controller->uidOwner);
    $criteriaIsfriend = new CriteriaCompo(new Criteria('friend2_uid', $xoopsUser->getVar('uid')));
    $criteriaIsfriend->add($criteria_friends);
    $controller->isFriend = $controller->friendshipsFactory->getCount($criteriaIsfriend);
    $xoopsTpl->assign('isFriend', $controller->isFriend);
    $friendrequestFactory   = new FriendrequestHandler($xoopsDB);
    $criteria_selfrequest   = new Criteria('friendrequester_uid', $xoopsUser->getVar('uid'));
    $criteria_isselfrequest = new CriteriaCompo(new Criteria('friendrequestto_uid', $controller->uidOwner));
    $criteria_isselfrequest->add($criteria_selfrequest);
    $controller->isSelfRequest = $friendrequestFactory->getCount($criteria_isselfrequest);
    $xoopsTpl->assign('selffriendrequest', $controller->isSelfRequest);
    if ($controller->isSelfRequest > 0) {
        $xoopsTpl->assign('self_uid', $xoopsUser->getVar('uid'));
    }
    $xoopsTpl->assign('lang_myfriend', _MD_SUICO_MYFRIEND);
    $xoopsTpl->assign('lang_friendrequestsent', _MD_SUICO_FRIENDREQUEST_SENT);
    $xoopsTpl->assign('lang_friendshipstatus', _MD_SUICO_FRIENDSHIP_STATUS);
    $criteria_otherrequest   = new Criteria('friendrequester_uid', $controller->uidOwner);
    $criteria_isotherrequest = new CriteriaCompo(new Criteria('friendrequestto_uid', $xoopsUser->getVar('uid')));
    $criteria_isotherrequest->add($criteria_otherrequest);
    $controller->isOtherRequest = $friendrequestFactory->getCount($criteria_isotherrequest);
    $xoopsTpl->assign('otherfriendrequest', $controller->isOtherRequest);
    if ($controller->isOtherRequest > 0) {
        $xoopsTpl->assign('other_uid', $controller->uidOwner);
    }
}
$evaluation = $controller->friendshipsFactory->getMoyennes($controller->uidOwner);
//evaluations
$xoopsTpl->assign('lang_fans', _MD_SUICO_FANS);
$xoopsTpl->assign('countFans', $evaluation['sumfan']);
$xoopsTpl->assign('lang_funny', _MD_SUICO_FUNNY);
$xoopsTpl->assign('funny', $evaluation['mediatrust']);
$xoopsTpl->assign('funny_rest', 48 - $evaluation['mediatrust']);
$xoopsTpl->assign('lang_friendly', _MD_SUICO_FRIENDLY);
$xoopsTpl->assign('friendly', $evaluation['mediahot']);
$xoopsTpl->assign('friendly_rest', 48 - $evaluation['mediahot']);
$xoopsTpl->assign('lang_cool', _MD_SUICO_COOL);
$xoopsTpl->assign('cool', $evaluation['mediacool']);
$xoopsTpl->assign('cool_rest', 48 - $evaluation['mediacool']);
$xoopsTpl->assign('allow_fanssevaluation', $helper->getConfig('allow_fanssevaluation'));
$xoopsTpl->assign('lang_askusertobefriend', _MD_SUICO_ASKBEFRIEND);
$xoopsTpl->assign('lang_addfriend', _MD_SUICO_ADDFRIEND);
$xoopsTpl->assign('lang_friendrequestpending', _MD_SUICO_FRIENDREQUEST_PENDING);
$xoopsTpl->assign('lang_cancelfriendrequest', _MD_SUICO_FRIENDREQUEST_CANCEL);
$xoopsTpl->assign('lang_myfriend', _MD_SUICO_MYFRIEND);
$xoopsTpl->assign('lang_friendrequestsent', _MD_SUICO_FRIENDREQUEST_SENT);
$xoopsTpl->assign('lang_acceptfriend', _MD_SUICO_FRIEND_ACCEPT);
$xoopsTpl->assign('lang_rejectfriend', _MD_SUICO_FRIEND_REJECT);
// Member Suspension
$xoopsTpl->assign('allow_usersuspension', $xoopsModuleConfig['allow_usersuspension']);
$xoopsTpl->assign('lang_suspensionadmin', _MD_SUICO_SUSPENSIONADMIN);
if (0 === $controller->isSuspended) {
    $xoopsTpl->assign('isSuspended', 0);
    $xoopsTpl->assign('lang_suspend', _MD_SUICO_SUSPENDUSER);
    $xoopsTpl->assign('lang_timeinseconds', _MD_SUICO_SUSPENDTIME);
} else {
    $xoopsTpl->assign('lang_unsuspend', _MD_SUICO_UNSUSPEND);
    $xoopsTpl->assign('isSuspended', 1);
    $xoopsTpl->assign('lang_suspended', _MD_SUICO_USER_SUSPENDED);
}
$xoopsTpl->assign('groupsperpage', $xoopsModuleConfig['groupsperpage']);
//Memberslist and Search Members
$xoopsTpl->assign('displayrealname', $xoopsModuleConfig['displayrealname']);
$xoopsTpl->assign('displayemail', $xoopsModuleConfig['displayemail']);
$xoopsTpl->assign('displaypm', $xoopsModuleConfig['displaypm']);
$xoopsTpl->assign('displayurl', $xoopsModuleConfig['displayurl']);
$xoopsTpl->assign('displayavatar', $xoopsModuleConfig['displayavatar']);
$xoopsTpl->assign('displayregdate', $xoopsModuleConfig['displayregdate']);
$xoopsTpl->assign('displayfrom', $xoopsModuleConfig['displayfrom']);
$xoopsTpl->assign('displayposts', $xoopsModuleConfig['displayposts']);
$xoopsTpl->assign('displaylastlogin', $xoopsModuleConfig['displaylastlogin']);
$xoopsTpl->assign('displayoccupation', $xoopsModuleConfig['displayoccupation']);
$xoopsTpl->assign('displayinterest', $xoopsModuleConfig['displayinterest']);
$xoopsTpl->assign('displaylatestmember', $xoopsModuleConfig['displaylatestmember']);
$xoopsTpl->assign('displaywelcomemessage', $xoopsModuleConfig['displaywelcomemessage']);
$xoopsTpl->assign('displaybreadcrumb', $xoopsModuleConfig['displaybreadcrumb']);
$xoopsTpl->assign('displaytotalmember', $xoopsModuleConfig['displaytotalmember']);
$xoopsTpl->assign('displaysignature', $xoopsModuleConfig['displaysignature']);
$xoopsTpl->assign('displayrank', $xoopsModuleConfig['displayrank']);
$xoopsTpl->assign('displaygroups', $xoopsModuleConfig['displaygroups']);
$xoopsTpl->assign('displayonlinestatus', $xoopsModuleConfig['displayonlinestatus']);
$xoopsTpl->assign('displayextrainfo', $xoopsModuleConfig['displayextrainfo']);
$xoopsTpl->assign('membersperpage', $xoopsModuleConfig['membersperpage']);
$xoopsTpl->assign('memberslisttemplate', $xoopsModuleConfig['memberslisttemplate']);

