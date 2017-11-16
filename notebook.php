<?php
// $Id: notebook.php,v 1.12 2008/04/19 16:39:08 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include_once __DIR__ . '/../../mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'yogurt_Notebook.tpl';
include_once __DIR__ . '/../../header.php';
include_once __DIR__ . '/class/yogurt_controler.php';

$controler  = new YogurtControlerNotes($xoopsDB, $xoopsUser);
$nbSections = $controler->getNumbersSections();

//$controler->renderFormNewPost($xoopsTpl);
$criteria_uid = new Criteria('Note_to', $controler->uidOwner);
$criteria_uid->setOrder('DESC');
$criteria_uid->setSort('date');

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

//permissions
$xoopsTpl->assign('allow_Notes', $controler->checkPrivilegeBySection('Notes'));
$xoopsTpl->assign('allow_friends', $controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes', $controler->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures', $controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos', $controler->checkPrivilegeBySection('videos'));
$xoopsTpl->assign('allow_audios', $controler->checkPrivilegeBySection('audio'));

if (!($Notes = $controler->fecthNotes($nbSections['nbNotes'], $criteria_uid))) {
    $xoopsTpl->assign('lang_noNotesyet', _MD_YOGURT_NONOTESYET);
}

//form
$xoopsTpl->assign('lang_entertext', _MD_YOGURT_ENTERTEXTNOTE);
$xoopsTpl->assign('lang_submit', _MD_YOGURT_SENDNOTE);
$xoopsTpl->assign('lang_cancel', _MD_YOGURT_CANCEL);

//xoopsToken
$xoopsTpl->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());

//Notes
$xoopsTpl->assign('Notes', $Notes);
$xoopsTpl->assign('lang_answerNote', _MD_YOGURT_ANSWERNOTE);
$xoopsTpl->assign('lang_tips', _MD_YOGURT_NOTETIPS);
$xoopsTpl->assign('lang_bold', _MD_YOGURT_BOLD);
$xoopsTpl->assign('lang_italic', _MD_YOGURT_ITALIC);
$xoopsTpl->assign('lang_underline', _MD_YOGURT_UNDERLINE);

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
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYNOTEBOOK);
$xoopsTpl->assign('section_name', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_home', _MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos', _MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends', _MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio', _MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos', _MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_Notebook', _MD_YOGURT_NOTEBOOK);
$xoopsTpl->assign('lang_profile', _MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_tribes', _MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_configs', _MD_YOGURT_CONFIGSTITLE);

include __DIR__ . '/../../footer.php';
