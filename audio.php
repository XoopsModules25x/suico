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


$GLOBALS['xoopsOption']['template_main'] = 'yogurt_audio.tpl';
require __DIR__.'/header.php';

$controler = new Yogurt\AudioControler($xoopsDB, $xoopsUser);

/**
 * Fecthing numbers of tribes friends videos pictures etc...
 */
$nbSections = $controler->getNumbersSections();

$start = isset($_GET['start']) ? (int) $_GET['start'] : 0;

/**
 * Criteria for Audio
 */
$criteriaUidAudio = new \Criteria('uid_owner', $controler->uidOwner);
$criteriaUidAudio->setStart($start);
$criteriaUidAudio->setLimit($xoopsModuleConfig['audiosperpage']);

/**
 * Get all audios of this user and assign them to template
 */
$audios       = $controler->getAudio($criteriaUidAudio);
$audios_array = $controler->assignAudioContent($nbSections['nbAudio'], $audios);

if (is_array($audios_array)) {
	$xoopsTpl->assign('audios', $audios_array);
	$audio_list = '';
	foreach ($audios_array as $audio_item) {
		$audio_list .= '../../uploads/yogurt/mp3/' . $audio_item['url'] . ' | ';
	}
	//$audio_list = substr($audio_list,-2);
	$xoopsTpl->assign('audio_list', $audio_list);
} else {
	$xoopsTpl->assign('lang_noaudioyet', _MD_YOGURT_NOAUDIOYET);
}

$pageNav = $controler->AudiosNavBar($nbSections['nbAudio'], $xoopsModuleConfig['audiosperpage'], $start, 2);

//linking style and js
/**
 * Adding to the module js and css of the lightbox and new ones
 */
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if (preg_match('/msie/', strtolower($_SERVER['HTTP_USER_AGENT']))) {
	$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/css/jquery.tabs-ie.css');
}
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/css/lightbox.css');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/prototype.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/scriptaculous.js?load=effects');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/lightbox.js');
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.lightbox-0.3.css');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/jquery.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/jquery.lightbox-0.3.js');
$xoTheme->addScript(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/include/yogurt.js');

//meta language names
$xoopsTpl->assign('lang_meta', _MD_YOGURT_META);
$xoopsTpl->assign('lang_title', _MD_YOGURT_META_TITLE);
$xoopsTpl->assign('lang_album', _MD_YOGURT_META_ALBUM);
$xoopsTpl->assign('lang_artist', _MD_YOGURT_META_ARTIST);
$xoopsTpl->assign('lang_year', _MD_YOGURT_META_YEAR);

//permissions
$xoopsTpl->assign('allow_Notes', $controler->checkPrivilegeBySection('Notes'));
$xoopsTpl->assign('allow_friends', $controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes', $controler->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures', $controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controler->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controler->checkPrivilegeBySection('audio'));

//Owner data
$xoopsTpl->assign('uid_owner', $controler->uidOwner);
$xoopsTpl->assign('owner_uname', $controler->nameOwner);
$xoopsTpl->assign('isOwner', $controler->isOwner);
$xoopsTpl->assign('isanonym', $controler->isAnonym);

//numbers
$xoopsTpl->assign('nb_tribes', $nbSections['nbTribes']);
$xoopsTpl->assign('nb_photos', $nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos', $nbSections['nbVideos']);
$xoopsTpl->assign('nb_Notes', $nbSections['nbNotes']);
$xoopsTpl->assign('nb_friends', $nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio', $nbSections['nbAudio']);

//navbar
$xoopsTpl->assign('module_name', $xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYVIDEOS);
$xoopsTpl->assign('section_name', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_audios', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_Notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_tribes', _MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//page atributes
$xoopsTpl->assign('xoops_pagetitle', sprintf(_MD_YOGURT_PAGETITLE, $xoopsModule->getVar('name'), $controler->nameOwner));

//form actions
$xoopsTpl->assign('lang_delete', _MD_YOGURT_DELETE);
$xoopsTpl->assign('lang_editdesc', _MD_YOGURT_EDITDESC);
$xoopsTpl->assign('lang_makemain', _MD_YOGURT_MAKEMAIN);

//FORM SUBMIT
$xoopsTpl->assign('lang_selectaudio', _MD_YOGURT_SELECTAUDIO);
$xoopsTpl->assign('lang_authorLabel', _MD_YOGURT_AUTHORAUDIO);
$xoopsTpl->assign('lang_titleLabel', _MD_YOGURT_TITLEAUDIO);
$xoopsTpl->assign('lang_submitValue', _MD_YOGURT_SUBMITAUDIO);
$xoopsTpl->assign('lang_addaudios', _MD_YOGURT_ADDAUDIO);

$xoopsTpl->assign('width', $xoopsModuleConfig['width_tube']);
$xoopsTpl->assign('height', $xoopsModuleConfig['height_tube']);
$xoopsTpl->assign('player_from_list', _MD_YOGURT_PLAYER);
$xoopsTpl->assign('lang_audiohelp', sprintf(_MD_YOGURT_ADDAUDIOHELP, $xoopsModuleConfig['maxfilesize']));
$xoopsTpl->assign('max_youcanupload', $xoopsModuleConfig['maxfilesize']);
//Videos NAvBAr
$xoopsTpl->assign('pageNav', $pageNav);

include __DIR__.'/../../footer.php';
