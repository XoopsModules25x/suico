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

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_friends.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\ControllerFriends($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

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
 * Friends
 */
$criteria_friends = new \Criteria('friend1_uid', (int)$controller->uidOwner);
$nb_friends       = $controller->friendshipsFactory->getCount($criteria_friends);
$criteria_friends->setLimit($xoopsModuleConfig['friendsperpage']);
$criteria_friends->setStart($start);
$vetor = $controller->friendshipsFactory->getFriends('', $criteria_friends, 0);
if (0 == $nb_friends) {
    $xoopsTpl->assign('lang_nofriendsyet', _MD_YOGURT_NOFRIENDSYET);
}

/**
 * Let's get the user name of the owner of the album
 */
$owner      = new \XoopsUser();
$identifier = $owner::getUnameFromId($controller->uidOwner);

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
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/css/jquery.lightbox-0.3.css');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/jquery.lightbox-0.3.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/assets/js/yogurt.js');

/**
 * Criando a barra de navegao caso tenha muitos amigos
 */
$barra_navegacao = new \XoopsPageNav($nbSections['nbFriends'], $xoopsModuleConfig['friendsperpage'], $start, 'start', 'uid=' . (int)$controller->uidOwner);
$navegacao       = $barra_navegacao->renderImageNav(2);

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


//permissions
$xoopsTpl->assign('allow_notes', $controller->checkPrivilegeBySection('notes'));
$xoopsTpl->assign('allow_friends', $controller->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_groups', $controller->checkPrivilegeBySection('groups'));
$xoopsTpl->assign('allow_pictures', $controller->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controller->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controller->checkPrivilegeBySection('audio'));

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
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYFRIENDS);
$xoopsTpl->assign('section_name', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_groups', _MD_YOGURT_GROUPS);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);

//barra de navega��o
$xoopsTpl->assign('navegacao', $navegacao);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controller->nameOwner));

$xoopsTpl->assign('lang_friendstitle', sprintf(_MD_YOGURT_FRIENDSTITLE, $identifier));
//$xoopsTpl->assign('path_yogurt_uploads',$xoopsModuleConfig['link_path_upload']);

$xoopsTpl->assign('friends', $vetor);

$xoopsTpl->assign('lang_delete', _MD_YOGURT_DELETE);
$xoopsTpl->assign('lang_evaluate', _MD_YOGURT_FRIENDSHIPCONFIGS);

require dirname(dirname(__DIR__)) . '/footer.php';
