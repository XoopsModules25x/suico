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

use XoopsModules\Yogurt;

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_configs.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\ConfigController($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();


if (!$xoopsUser) {
    redirect_header('index.php');
}

/**
 * Factories of groups
 */
$configsFactory = new Yogurt\ConfigsHandler($xoopsDB);

$uid = (int)$xoopsUser->getVar('uid');

$criteria = new Criteria('config_uid', $uid);
if ($configsFactory->getCount($criteria) > 0) {
    $configs = $configsFactory->getObjects($criteria);
    $config  = $configs[0];

    $pic  = $config->getVar('pictures');
    $aud  = $config->getVar('audio');
    $vid  = $config->getVar('videos');
    $tri  = $config->getVar('groups');
    $scr  = $config->getVar('notes');
    $fri  = $config->getVar('friends');
    $pcon = $config->getVar('profile_contact');
    $pgen = $config->getVar('profile_general');
    $psta = $config->getVar('profile_stats');

    $xoopsTpl->assign('pic', $pic);
    $xoopsTpl->assign('aud', $aud);
    $xoopsTpl->assign('vid', $vid);
    $xoopsTpl->assign('tri', $tri);
    $xoopsTpl->assign('scr', $scr);
    $xoopsTpl->assign('fri', $fri);
    $xoopsTpl->assign('pcon', $pcon);
    $xoopsTpl->assign('pgen', $pgen);
    $xoopsTpl->assign('psta', $psta);
}

//form
$xoopsTpl->assign('lang_whocan', _MD_YOGURT_WHOCAN);
$xoopsTpl->assign('lang_configtitle', _MD_YOGURT_CONFIGSTITLE);
$xoopsTpl->assign('lang_configprofilestats', _MD_YOGURT_CONFIGSPROFILESTATS);
$xoopsTpl->assign('lang_configprofilegeneral', _MD_YOGURT_CONFIGSPROFILEGENERAL);
$xoopsTpl->assign('lang_configprofilecontact', _MD_YOGURT_CONFIGSPROFILECONTACT);
$xoopsTpl->assign('lang_configfriends', _MD_YOGURT_CONFIGSFRIENDS);
$xoopsTpl->assign('lang_confignotes', _MD_YOGURT_CONFIGSNOTES);
$xoopsTpl->assign('lang_configsendnotes', _MD_YOGURT_CONFIGSNOTESSEND);
$xoopsTpl->assign('lang_configgroups', _MD_YOGURT_CONFIGSGROUPS);
$xoopsTpl->assign('lang_configaudio', _MD_YOGURT_CONFIGSAUDIOS);
$xoopsTpl->assign('lang_configvideos', _MD_YOGURT_CONFIGSVIDEOS);
$xoopsTpl->assign('lang_configpictures', _MD_YOGURT_CONFIGSPICTURES);
$xoopsTpl->assign('lang_only_me', _MD_YOGURT_CONFIGSONLYME);
$xoopsTpl->assign('lang_only_friends', _MD_YOGURT_CONFIGSONLYEFRIENDS);
$xoopsTpl->assign('lang_only_users', _MD_YOGURT_CONFIGSONLYEUSERS);
$xoopsTpl->assign('lang_everyone', _MD_YOGURT_CONFIGSEVERYONE);

$xoopsTpl->assign('lang_cancel', _MD_YOGURT_CANCEL);

//Notes
//$xoopsTpl->assign('notes',$notes);
$xoopsTpl->assign('lang_answerNote', _MD_YOGURT_ANSWERNOTE);

//navbar
$xoopsTpl->assign('lang_mysection', _MD_YOGURT_CONFIGSTITLE);
$xoopsTpl->assign('section_name', _MD_YOGURT_CONFIGSTITLE);

require __DIR__ . '/footer.php';
require dirname(dirname(__DIR__)) . '/footer.php';
