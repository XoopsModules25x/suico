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
 * @copyright       XOOPS https://www.xoops.org
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          XOOPS https://www.xoops.org
 */

use Xmf\Request;
use XoopsModules\Yogurt;
use XoopsModules\Yogurt\IndexController;


/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurt.css'
);
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurtb4.css'
);
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/pagination.css'
);

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (false !== stripos($_SERVER['HTTP_USER_AGENT'], 'msie')) {
    $xoTheme->addStylesheet(
        XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs-ie.css'
    );
}
//if (stripos($_SERVER['REQUEST_URI'], 'album.php')) {
$xoTheme->addStylesheet(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.lightbox-0.3.css'
);
//}

if (!stripos($_SERVER['REQUEST_URI'], 'memberslist.php')) {
$xoTheme->addScript(
    XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.js'
);
}

//if (stripos($_SERVER['REQUEST_URI'], 'album.php')) {
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.lightbox-0.3.js'); 
//}
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/yogurt.js');

if (stripos($_SERVER['REQUEST_URI'], 'memberslist.php')) {
if ('datatables' == $xoopsModuleConfig['memberslisttemplate']) {
	$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.dataTables.css');
	$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/responsive.dataTables.min.css');
	$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.dataTables.js');
	$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/dataTables.responsive.min.js');
}
}


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
$xoopsTpl->assign('nb_groups', $nbSections['nbGroups']);
$xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
$xoopsTpl->assign('nb_notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_groups', _MD_YOGURT_GROUPS);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign(
    'xoops_pagetitle',
    sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner)
);



//Navbar User Info
$avatar = $controller->owner->getVar('user_avatar');
$memberHandler = xoops_getHandler('member');
$thisUser      = $memberHandler->getUser($controller->uidOwner);
$myts          = MyTextSanitizer::getInstance();

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
$xoopsTpl->assign('lang_selectavatar', _MD_YOGURT_SELECTAVATAR);
$xoopsTpl->assign('lang_noavatar', _MD_YOGURT_NOAVATARYET);
$xoopsTpl->assign('user_onlinestatus', $thisUser->isOnline());
$xoopsTpl->assign('lang_onlinestatus', _MD_YOGURT_ONLINESTATUS);

/**
 * Filter for new friend request
 */
$friendrequest = 0;
if (1 === $controller->isOwner) {
    $criteria_uidrequest = new Criteria('requestto_uid', $controller->uidOwner);
    $newFriendrequest          = $controller->friendrequestFactory->getObjects($criteria_uidrequest);
    if ($newFriendrequest) {
        $nb_friendrequests      = count($newFriendrequest);
        $friendrequesterHandler = xoops_getHandler('member');
        $friendrequester        = $friendrequesterHandler->getUser($newFriendrequest[0]->getVar('requester_uid'));
        $friendrequester_uid    = $friendrequester->getVar('uid');
        $friendrequester_uname  = $friendrequester->getVar('uname');
        $friendrequester_avatar = $friendrequester->getVar('user_avatar');
        $friendrequest_id       = $newFriendrequest[0]->getVar('friendpet_id');
        $friendrequest          = 1;
    }
}

$friendrequestFactory = new Yogurt\FriendrequestHandler($xoopsDB);
/**
 * Getting the uid of the user which user want to ask to be friend
 */
$friendrequestfrom_uid = $controller->uidOwner;

//Verify if the user has already asked for friendship or if the user he s asking to be a friend has already asked him
$criteria = new CriteriaCompo(
    new Criteria(
        'requestto_uid', $friendrequestfrom_uid
    )
);

if ($xoopsUser){
$criteria->add(new Criteria('requester_uid', $xoopsUser->getVar('uid')));
if ($friendrequestFactory->getCount($criteria) > 0) {
	$xoopsTpl->assign('requestfrom_uid', $friendrequestfrom_uid);
	
}
else {
    $criteria2 = new CriteriaCompo(new Criteria('requester_uid', $friendrequestfrom_uid));
    $criteria2->add(new Criteria('requestto_uid', $xoopsUser->getVar('uid')));
    if ($friendrequestFactory->getCount($criteria2) > 0) {
       $xoopsTpl->assign('requestto_uid', $xoopsUser->getVar('uid'));
    }
}}

/**
 * Friends
 */
$criteria_friends = new Criteria('friend1_uid', $controller->uidOwner);
$friends          = $controller->friendshipsFactory->getFriends(9, $criteria_friends);

$controller->visitorsFactory->purgeVisits();
$evaluation = $controller->friendshipsFactory->getMoyennes($controller->uidOwner);


//evaluations
$xoopsTpl->assign('lang_fans', _MD_YOGURT_FANS);
$xoopsTpl->assign('nb_fans', $evaluation['sumfan']);
$xoopsTpl->assign('lang_funny', _MD_YOGURT_FUNNY);
$xoopsTpl->assign('funny', $evaluation['mediatrust']);
$xoopsTpl->assign('funny_rest', 48 - $evaluation['mediatrust']);
$xoopsTpl->assign('lang_friendly', _MD_YOGURT_FRIENDLY);
$xoopsTpl->assign('friendly', $evaluation['mediahot']);
$xoopsTpl->assign('friendly_rest', 48 - $evaluation['mediahot']);
$xoopsTpl->assign('lang_cool', _MD_YOGURT_COOL);
$xoopsTpl->assign('cool', $evaluation['mediacool']);
$xoopsTpl->assign('cool_rest', 48 - $evaluation['mediacool']);
$xoopsTpl->assign('allow_fanssevaluation', $helper->getConfig('allow_fanssevaluation'));

//request to become friend
if (1 === $friendrequest) {
    $xoopsTpl->assign('lang_youhavexfriendrequests', sprintf(_MD_YOGURT_YOUHAVEXFRIENDREQUESTS, $nb_friendrequests));
    $xoopsTpl->assign('requester_uid', $friendrequester_uid);
    $xoopsTpl->assign('requester_uname', $friendrequester_uname);
    $xoopsTpl->assign('requester_avatar', $friendrequester_avatar);
    $xoopsTpl->assign('request', $friendrequest);
    $xoopsTpl->assign('request_id', $friendrequest_id);
    $xoopsTpl->assign('lang_rejected', _MD_YOGURT_UNKNOWNREJECTING);
    $xoopsTpl->assign('lang_accepted', _MD_YOGURT_UNKNOWNACCEPTING);
    $xoopsTpl->assign('lang_acquaintance', _MD_YOGURT_AQUAITANCE);
    $xoopsTpl->assign('lang_friend', _MD_YOGURT_FRIEND);
    $xoopsTpl->assign('lang_bestfriend', _MD_YOGURT_BESTFRIEND);
    $linkedpetioner = '<a href="index.php?uid=' . $friendrequester_uid . '">' . $friendrequester_uname . '</a>';
    $xoopsTpl->assign('lang_askingfriend', sprintf(_MD_YOGURT_ASKINGFRIEND, $linkedpetioner));
}
$xoopsTpl->assign('lang_askusertobefriend', _MD_YOGURT_ASKBEFRIEND);
$xoopsTpl->assign('lang_addfriend', _MD_YOGURT_ADDFRIEND);
$xoopsTpl->assign('lang_friendrequestpending', _MD_YOGURT_FRIENDREQUESTPENDING);
$xoopsTpl->assign('lang_myfriend', _MD_YOGURT_MYFRIEND);
$xoopsTpl->assign('lang_friendrequestsent', _MD_YOGURT_FRIENDREQUESTSENT);
$xoopsTpl->assign('lang_acceptfriend', _MD_YOGURT_ACCEPTFRIEND);
$xoopsTpl->assign('lang_rejectfriend', _MD_YOGURT_REJECTFRIEND);


// Member Suspension
$xoopsTpl->assign('allow_usersuspension', $xoopsModuleConfig['allow_usersuspension']);
$xoopsTpl->assign('lang_suspensionadmin', _MD_YOGURT_SUSPENSIONADMIN);
if (0 === $controller->isSuspended) {
    $xoopsTpl->assign('isSuspended', 0);
    $xoopsTpl->assign('lang_suspend', _MD_YOGURT_SUSPENDUSER);
    $xoopsTpl->assign('lang_timeinseconds', _MD_YOGURT_SUSPENDTIME);
} else {
    $xoopsTpl->assign('lang_unsuspend', _MD_YOGURT_UNSUSPEND);
    $xoopsTpl->assign('isSuspended', 1);
    $xoopsTpl->assign('lang_suspended', _MD_YOGURT_USERSUSPENDED);
}


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
