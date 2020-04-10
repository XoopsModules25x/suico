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

$controller = new \XoopsModules\Yogurt\ControllerIndex($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

/**
 * This variable define the beggining of the navigation must b
 * setted here so all calls to database will take this into account
 */
$start = \Xmf\Request::getInt('start', 0, 'GET');

/**
 * Filter for new friend petition
 */
$petition = 0;
if (1 == $controller->isOwner) {
    $criteria_uidpetition = new \Criteria('petioned_uid', $controller->uidOwner);
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
 * Criteria for mainvideo
 */
$criteria_uidvideo  = new \Criteria('uid_owner', $controller->uidOwner);
$criteria_mainvideo = new \Criteria('main_video', '1');
$criteria_video     = new \CriteriaCompo($criteria_mainvideo);
$criteria_video->add($criteria_uidvideo);

if (($nbSections['nbVideos'] > 0) && ($videos = $controller->videosFactory->getObjects($criteria_video))) {
    $mainvideocode = $videos[0]->getVar('youtube_code');
    $mainvideodesc = $videos[0]->getVar('video_desc');
}

/**
 * Friends
 */
$criteria_friends = new \Criteria('friend1_uid', $controller->uidOwner);
$friends          = $controller->friendshipsFactory->getFriends(9, $criteria_friends);

$controller->visitorsFactory->purgeVisits();
$evaluation = $controller->friendshipsFactory->getMoyennes($controller->uidOwner);

/**
 * Groups
 */
$criteria_groups = new \Criteria('rel_user_uid', $controller->uidOwner);
$groups          = $controller->relgroupusersFactory->getGroups(9, $criteria_groups);

/**
 * Visitors
 */
if (0 == $controller->isAnonym) {
    /**
     * Fectching last visitors
     */
    if ($controller->uidOwner != $xoopsUser->getVar('uid')) {
        $visitor_now = $controller->visitorsFactory->create();
        $visitor_now->setVar('uid_owner', $controller->uidOwner);
        $visitor_now->setVar('uid_visitor', $xoopsUser->getVar('uid'));
        $visitor_now->setVar('uname_visitor', $xoopsUser->getVar('uname'));
        $controller->visitorsFactory->insert($visitor_now);
    }
    $criteria_visitors = new \Criteria('uid_owner', $controller->uidOwner);
    //$criteria_visitors->setLimit(5);
    $visitors_object_array = $controller->visitorsFactory->getObjects($criteria_visitors);

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

/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (false !== strpos(mb_strtolower($_SERVER['HTTP_USER_AGENT']), 'msie')) {
    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.tabs-ie.css');
}
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/css/lightbox.css');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/prototype.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/scriptaculous.js?load=effects');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/lightbox.js');
//
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.lightbox-0.3.css');

$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.lightbox-0.3.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/yogurt.js');

//permissions
$xoopsTpl->assign('allow_friends', $controller->checkPrivilege('friends'));
$xoopsTpl->assign('allow_notes', $controller->checkPrivilege('notes'));
$xoopsTpl->assign('allow_groups', $controller->checkPrivilege('groups'));
$xoopsTpl->assign('allow_pictures', $controller->checkPrivilege('pictures'));
$xoopsTpl->assign('allow_videos', $controller->checkPrivilege('videos'));
$xoopsTpl->assign('allow_audios', $controller->checkPrivilegeBySection('audio'));
$xoopsTpl->assign('allow_profile_contact', $controller->checkPrivilege('profile_contact') ? 1 : 0);
$xoopsTpl->assign('allow_profile_general', $controller->checkPrivilege('profile_general') ? 1 : 0);
$xoopsTpl->assign('allow_profile_stats', $controller->checkPrivilege('profile_stats') ? 1 : 0);
$xoopsTpl->assign('lang_suspensionadmin', _MD_YOGURT_SUSPENSIONADMIN);
if (0 == $controller->isSuspended) {
    $xoopsTpl->assign('isSuspended', 0);
    $xoopsTpl->assign('lang_suspend', _MD_YOGURT_SUSPENDUSER);
    $xoopsTpl->assign('lang_timeinseconds', _MD_YOGURT_SUSPENDTIME);
} else {
    $xoopsTpl->assign('lang_unsuspend', _MD_YOGURT_UNSUSPEND);
    $xoopsTpl->assign('isSuspended', 1);
    $xoopsTpl->assign('lang_suspended', _MD_YOGURT_USERSUSPENDED);
}
if ($xoopsUser && $xoopsUser->isAdmin(1)) {
    $xoopsTpl->assign('isWebmaster', '1');
} else {
    $xoopsTpl->assign('isWebmaster', '0');
}

/**
 * Assigning smarty variables
 */

//Owner data
$xoopsTpl->assign('uid_owner', $controller->uidOwner);
$xoopsTpl->assign('owner_uname', $controller->nameOwner);
$xoopsTpl->assign('isOwner', $controller->isOwner);
$xoopsTpl->assign('isanonym', $controller->isAnonym);
$xoopsTpl->assign('isfriend', $controller->isFriend);

//numbers
$xoopsTpl->assign('nb_groups', $nbSections['nbGroups']);
$xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
$xoopsTpl->assign('nb_notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYPROFILE);
$xoopsTpl->assign('section_name', _MD_YOGURT_PROFILE);
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
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner));

//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);

//groups
$xoopsTpl->assign('groups', $groups);
if ($nbSections['nbGroups'] <= 0) {
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
$xoopsTpl->assign('enable_friendsevaluation', $xoopsModuleConfig['enable_friendsevaluation']);

//petitions to become friend
if (1 == $petition) {
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
$xoopsTpl->assign('lang_addasafriend', _MD_YOGURT_ADDASAFRIEND);

//Avatar and Main 
$xoopsTpl->assign('avatar_url', $avatar);
$xoopsTpl->assign('lang_selectavatar', _MD_YOGURT_SELECTAVATAR);
$xoopsTpl->assign('lang_selectmainvideo', _MD_YOGURT_SELECTMAINVIDEO);
$xoopsTpl->assign('lang_noavatar', _MD_YOGURT_NOAVATARYET);
$xoopsTpl->assign('lang_nomainvideo', _MD_YOGURT_NOMAINVIDEOYET);
$xoopsTpl->assign('lang_featuredvideo', _MD_YOGURT_FEATUREDVIDEO);
$xoopsTpl->assign('lang_viewallvideos', _MD_YOGURT_ALLVIDEOS);

if ($nbSections['nbVideos'] > 0) {
    $xoopsTpl->assign('mainvideocode', $mainvideocode);
    $xoopsTpl->assign('mainvideodesc', $mainvideodesc);
    $xoopsTpl->assign('width', $xoopsModuleConfig['width_maintube']); // Falta configurar o tamnho do main nas configs e alterar no template
    $xoopsTpl->assign('height', $xoopsModuleConfig['height_maintube']);
}
//friends
$xoopsTpl->assign('friends', $friends);
$xoopsTpl->assign('lang_friendstitle', sprintf(_MD_YOGURT_FRIENDSTITLE, $controller->nameOwner));
$xoopsTpl->assign('lang_viewallfriends', _MD_YOGURT_ALLFRIENDS);

$xoopsTpl->assign('lang_nofriendsyet', _MD_YOGURT_NOFRIENDSYET);

//search
$xoopsTpl->assign('lang_usercontributions', _MD_YOGURT_USERCONTRIBUTIONS);

$xoopsTpl->assign('lang_detailsinfo', _MD_YOGURT_USERDETAILS);
$xoopsTpl->assign('lang_contactinfo', _MD_YOGURT_CONTACTINFO);
//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);
$xoopsTpl->assign('lang_max_nb_pict', sprintf(_MD_YOGURT_YOUCANHAVE, $xoopsModuleConfig['nb_pict']));
$xoopsTpl->assign('lang_delete', _MD_YOGURT_DELETE);
$xoopsTpl->assign('lang_editdesc', _MD_YOGURT_EDITDESC);

$xoopsTpl->assign('lang_visitors', _MD_YOGURT_VISITORS);
$xoopsTpl->assign('lang_profilevisitors', _MD_YOGURT_PROFILEVISITORS);

$xoopsTpl->assign('lang_editprofile', _MD_YOGURT_EDITPROFILE);

$xoopsTpl->assign('user_uname', $thisUser->getVar('uname'));
$xoopsTpl->assign('user_realname', $thisUser->getVar('name'));
$xoopsTpl->assign('lang_uname', _US_NICKNAME);
$xoopsTpl->assign('lang_website', _US_WEBSITE);
$userwebsite = ('' != $thisUser->getVar('url', 'E')) ? '<a href="' . $thisUser->getVar('url', 'E') . '" target="_blank">' . $thisUser->getVar('url') . '</a>' : '';
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
if (1 == $thisUser->getVar('user_viewemail')) {
    $xoopsTpl->assign('user_email', $thisUser->getVar('email', 'E'));
} else {
    $xoopsTpl->assign('user_email', '&nbsp;');
}

$xoopsTpl->assign('uname', $thisUser->getVar('uname'));
$xoopsTpl->assign('lang_realname', _US_REALNAME);
$xoopsTpl->assign('name', $thisUser->getVar('name'));

$gpermHandler  = xoops_getHandler('groupperm');
$groups        = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$moduleHandler = xoops_getHandler('module');
$criteria      = new \CriteriaCompo(new \Criteria('hassearch', 1));
$criteria->add(new \Criteria('isactive', 1));
$mids = array_keys($moduleHandler->getList($criteria));

//userranl
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
                if (isset($results[$i]['image']) && '' != $results[$i]['image']) {
                    $results[$i]['image'] = 'modules/' . $module->getVar('dirname') . '/' . $results[$i]['image'];
                } else {
                    $results[$i]['image'] = 'images/icons/posticon2.gif';
                }

                if (!preg_match("/^http[s]*:\/\//i", $results[$i]['link'])) {
                    $results[$i]['link'] = 'modules/' . $module->getVar('dirname') . '/' . $results[$i]['link'];
                }

                $results[$i]['title'] = $myts->makeTboxData4Show($results[$i]['title']);
                $results[$i]['time']  = $results[$i]['time'] ? formatTimestamp($results[$i]['time']) : '';
            }
            if (5 == $count) {
                $showall_link = '<a href="../../search.php?action=showallbyuser&amp;mid=' . $mid . '&amp;uid=' . $thisUser->getVar('uid') . '">' . _US_SHOWALL . '</a>';
            } else {
                $showall_link = '';
            }
            $xoopsTpl->append('modules', ['name' => $module->getVar('name'), 'results' => $results, 'showall_link' => $showall_link]);
        }
        unset($module);
    }
}

/**
 * Closing the page
 */
require dirname(dirname(__DIR__)) . '/footer.php';
