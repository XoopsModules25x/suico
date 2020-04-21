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
use XoopsModules\Yogurt\IndexController;

/**
 * Xoops header
 */
$GLOBALS['xoopsOption']['template_main'] = 'yogurt_index.tpl';
require __DIR__ . '/header.php';

$helper->loadLanguage('user');

$mainvideocode = '';
$mainvideodesc = '';

//require_once __DIR__ . '/class/yogurt_controller.php';
//if (!@ require_once XOOPS_ROOT_PATH . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/user.php') {
//    require_once XOOPS_ROOT_PATH . '/language/english/user.php';
//}

$controller = new IndexController($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

/**
 * This variable define the beginning of the navigation must be
 * set here so all calls to database will take this into account
 */
$start = Request::getInt(
    'start',
    0,
    'GET'
);

/**
 * Filter for new friend friendrequest
 */
$friendrequest = 0;
if (1 === $controller->isOwner) {
    $criteria_uidfriendrequest = new Criteria('friendrequestto_uid', $controller->uidOwner);
    $newFriendrequest          = $controller->friendrequestFactory->getObjects($criteria_uidfriendrequest);
    if ($newFriendrequest) {
        $nb_friendrequest      = count($newFriendrequest);
        $friendrequesterHandler = xoops_getHandler('member');
        $friendrequester        = $friendrequesterHandler->getUser($newFriendrequest[0]->getVar('friendrequester_uid'));
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
        'friendrequestto_uid',
        $friendrequestfrom_uid
    )
);

if ($xoopsUser) {
    $criteria->add(new Criteria('friendrequester_uid', $xoopsUser->getVar('uid')));
    if ($friendrequestFactory->getCount($criteria) > 0) {
        $xoopsTpl->assign('friendrequestfrom_uid', $friendrequestfrom_uid);
    } else {
        $criteria2 = new CriteriaCompo(new Criteria('friendrequester_uid', $friendrequestfrom_uid));
        $criteria2->add(new Criteria('friendrequestto_uid', $xoopsUser->getVar('uid')));
        if ($friendrequestFactory->getCount($criteria2) > 0) {
            $xoopsTpl->assign('friendrequestto_uid', $xoopsUser->getVar('uid'));
        }
    }
}

/**
 * Criteria for mainvideo
 */
$criteria_uidvideo  = new Criteria('uid_owner', $controller->uidOwner);
$criteria_mainvideo = new Criteria('main_video', '1');
$criteria_video     = new CriteriaCompo($criteria_mainvideo);
$criteria_video->add($criteria_uidvideo);

if ((isset($nbSections['nbVideos']) && $nbSections['nbVideos'] > 0) && ($videos = $controller->videosFactory->getObjects($criteria_video))) {
    $mainvideocode = $videos[0]->getVar('youtube_code');
    $mainvideodesc = $videos[0]->getVar('video_desc');
}

/**
 * Friends
 */
$criteria_friends = new Criteria('friend1_uid', $controller->uidOwner);
$friends          = $controller->friendshipsFactory->getFriends(9, $criteria_friends);

$controller->visitorsFactory->purgeVisits();
$evaluation = $controller->friendshipsFactory->getMoyennes($controller->uidOwner);

/**
 * Groups
 */
$criteria_groups = new Criteria('rel_user_uid', $controller->uidOwner);
$groups          = $controller->relgroupusersFactory->getGroups(9, $criteria_groups);

/**
 * Visitors
 */
if (0 === $controller->isAnonym) {
    /**
     * Fectching last visitors
     */
    if ($controller->uidOwner !== $xoopsUser->getVar('uid')) {
        $visitor_now = $controller->visitorsFactory->create();
        $visitor_now->setVar('uid_owner', $controller->uidOwner);
        $visitor_now->setVar('uid_visitor', $xoopsUser->getVar('uid'));
        $visitor_now->setVar('uname_visitor', $xoopsUser->getVar('uname'));
        $controller->visitorsFactory->insert2($visitor_now);
    }
    $criteria_visitors = new Criteria('uid_owner', $controller->uidOwner);
    //$criteria_visitors->setLimit(5);
    $visitors_object_array = $controller->visitorsFactory->getObjects(
        $criteria_visitors
    );

    /**
     * Lets populate an array with the dati from visitors
     */
    $i              = 0;
    $visitors_array = [];
    foreach ($visitors_object_array as $visitor) {
        $indice                  = $visitor->getVar('uid_visitor', 's');
        $visitors_array[$indice] = $visitor->getVar('uname_visitor', 's');

        $i++;
    }

    $xoopsTpl->assign('visitors', $visitors_array);
    $xoopsTpl->assign('lang_visitors', _MD_YOGURT_VISITORS);
    /*    $criteria_deletevisitors = new criteria('uid_owner',$uid);
        $criteria_deletevisitors->setStart(5);

        print_r($criteria_deletevisitors);
        $visitorsFactory->deleteAll($criteria_deletevisitors, true);
    */
}

$avatar = $controller->owner->getVar('user_avatar');

$memberHandler = xoops_getHandler('member');
$thisUser      = $memberHandler->getUser($controller->uidOwner);
$myts          = MyTextSanitizer::getInstance();

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


//navbar
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYPROFILE);
$xoopsTpl->assign('section_name', _MD_YOGURT_PROFILE);

//$xoopsTpl->assign('path_yogurt_uploads',$helper->getConfig('link_path_upload'));

//groups
$xoopsTpl->assign('groups', $groups);
if (isset($nbSections['nbGroups']) && $nbSections['nbGroups'] <= 0) {
    $xoopsTpl->assign('lang_nogroupsyet', _MD_YOGURT_NOGROUPSYET);
}
$xoopsTpl->assign('lang_viewallgroups', _MD_YOGURT_ALLGROUPS);

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

//requests to become friend
if (1 === $friendrequest) {
    $xoopsTpl->assign('lang_youhavexfriendrequests', sprintf(_MD_YOGURT_YOUHAVEXREQUESTS, $nb_friendrequest));
    $xoopsTpl->assign('friendrequester_uid', $friendrequester_uid);
    $xoopsTpl->assign('friendrequester_uname', $friendrequester_uname);
    $xoopsTpl->assign('friendrequester_avatar', $friendrequester_avatar);
    $xoopsTpl->assign('friendrequest', $friendrequest);
    $xoopsTpl->assign('friendrequest_id', $friendrequest_id);
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

//Avatar and Main
$xoopsTpl->assign('avatar_url', $avatar);
$xoopsTpl->assign('lang_selectavatar', _MD_YOGURT_SELECTAVATAR);
$xoopsTpl->assign('lang_selectmainvideo', _MD_YOGURT_SELECTMAINVIDEO);
$xoopsTpl->assign('lang_noavatar', _MD_YOGURT_NOAVATARYET);
$xoopsTpl->assign('lang_nomainvideo', _MD_YOGURT_NOMAINVIDEOYET);
$xoopsTpl->assign('lang_featuredvideo', _MD_YOGURT_FEATUREDVIDEO);
$xoopsTpl->assign('lang_viewallvideos', _MD_YOGURT_ALLVIDEOS);

if (isset($nbSections['nbVideos']) && $nbSections['nbVideos'] > 0) {
    $xoopsTpl->assign('mainvideocode', $mainvideocode);
    $xoopsTpl->assign('mainvideodesc', $mainvideodesc);
    $xoopsTpl->assign(
        'width',
        $helper->getConfig('width_maintube')
    ); // Falta configurar o tamnho do main nas configs e alterar no template
    $xoopsTpl->assign(
        'height',
        $helper->getConfig('height_maintube')
    );
}

//friends
$xoopsTpl->assign('friends', $friends);
$xoopsTpl->assign('lang_friendstitle', sprintf(_MD_YOGURT_FRIENDSTITLE, $controller->nameOwner));
$xoopsTpl->assign('lang_viewallfriends', _MD_YOGURT_ALLFRIENDS);
$xoopsTpl->assign('lang_nofriendsyet', _MD_YOGURT_NOFRIENDSYET);

//search
$xoopsTpl->assign('lang_usercontributions', _MD_YOGURT_USERCONTRIBUTIONS);

//Profile
$xoopsTpl->assign('lang_detailsinfo', _MD_YOGURT_USERDETAILS);
$xoopsTpl->assign('lang_contactinfo', _MD_YOGURT_CONTACTINFO);
//$xoopsTpl->assign('path_yogurt_uploads',$helper->getConfig('link_path_upload'));
$xoopsTpl->assign(
    'lang_max_nb_pict',
    sprintf(_MD_YOGURT_YOUCANHAVE, $helper->getConfig('nb_pict'))
);
$xoopsTpl->assign('lang_delete', _MD_YOGURT_DELETE);
$xoopsTpl->assign('lang_editdesc', _MD_YOGURT_EDITDESC);
$xoopsTpl->assign('lang_visitors', _MD_YOGURT_VISITORS);
$xoopsTpl->assign('lang_profilevisitors', _MD_YOGURT_PROFILEVISITORS);
$xoopsTpl->assign('lang_editprofile', _MD_YOGURT_EDITPROFILE);

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
$xoopsTpl->assign('lang_icq', _US_ICQ);
$xoopsTpl->assign('user_icq', $thisUser->getVar('user_icq'));
$xoopsTpl->assign('lang_aim', _US_AIM);
$xoopsTpl->assign('user_aim', $thisUser->getVar('user_aim'));
$xoopsTpl->assign('lang_yim', _US_YIM);
$xoopsTpl->assign('user_yim', $thisUser->getVar('user_yim'));
$xoopsTpl->assign('lang_msnm', _US_MSNM);
$xoopsTpl->assign('user_msnm', $thisUser->getVar('user_msnm'));
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
$xoopsTpl->assign('lang_onlinestatus', _MD_YOGURT_ONLINESTATUS);
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
            for ($i = 0; $i < $count; $i++) {
                if (isset($results[$i]['image']) && '' !== $results[$i]['image']) {
                    $results[$i]['image'] = 'modules/' . $module->getVar('dirname') . '/' . $results[$i]['image'];
                } else {
                    $results[$i]['image'] = 'images/icons/posticon2.gif';
                }

                if (!preg_match("#^http[s]*:\/\/#i", $results[$i]['link'])) {
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

// temporary solution for profile module integration
if (xoops_isActiveModule('profile')) {
    $profileHandler=xoops_getModuleHandler('profile', 'profile');
    $uid = $controller->uidOwner;
    if ($uid <= 0) {
        if (is_object($xoopsUser)) {
            $profile = $profileHandler->get($uid);
        } else {
            header('location: ' . XOOPS_URL);
            exit();
        }
    } else {
        $profile = $profileHandler->get($uid);
    }
}

require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
