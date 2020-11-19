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

use XoopsModules\Suico\{
    ConfigController,
    ConfigsHandler
};

$GLOBALS['xoopsOption']['template_main'] = 'suico_configs.tpl';
require __DIR__ . '/header.php';
$controller = new ConfigController($xoopsDB, $xoopsUser);
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
$configsFactory = new ConfigsHandler($xoopsDB);
$uid            = (int)$xoopsUser->getVar('uid');
$criteria       = new Criteria('config_uid', $uid);
if ($configsFactory->getCount($criteria) > 0) {
    $configs = $configsFactory->getObjects($criteria);
    $config  = $configs[0];
    $pic     = $config->getVar('pictures');
    $aud     = $config->getVar('audio');
    $vid     = $config->getVar('videos');
    $tri     = $config->getVar('groups');
    $scr     = $config->getVar('notes');
    $fri     = $config->getVar('friends');
    $pcon    = $config->getVar('profile_contact');
    $pgen    = $config->getVar('profile_general');
    $psta    = $config->getVar('profile_stats');
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
$xoopsTpl->assign('lang_whocan', _MD_SUICO_WHOCAN);
$xoopsTpl->assign('lang_configtitle', _MD_SUICO_CONFIGS_TITLE);
$xoopsTpl->assign('lang_configprofilestats', _MD_SUICO_CONFIGS_PROFILESTATS);
$xoopsTpl->assign('lang_configprofilegeneral', _MD_SUICO_CONFIGS_PROFILEGENERAL);
$xoopsTpl->assign('lang_configprofilecontact', _MD_SUICO_CONFIGS_PROFILECONTACT);
$xoopsTpl->assign('lang_configfriends', _MD_SUICO_CONFIGS_FRIENDS);
$xoopsTpl->assign('lang_confignotes', _MD_SUICO_CONFIGS_NOTES);
$xoopsTpl->assign('lang_configsendnotes', _MD_SUICO_CONFIGS_NOTESSEND);
$xoopsTpl->assign('lang_configgroups', _MD_SUICO_CONFIGS_GROUPS);
$xoopsTpl->assign('lang_configaudio', _MD_SUICO_CONFIGS_AUDIOS);
$xoopsTpl->assign('lang_configvideos', _MD_SUICO_CONFIGS_VIDEOS);
$xoopsTpl->assign('lang_configpictures', _MD_SUICO_CONFIGS_PICTURES);
$xoopsTpl->assign('lang_only_me', _MD_SUICO_CONFIGS_ONLYME);
$xoopsTpl->assign('lang_only_friends', _MD_SUICO_CONFIGS_ONLYEFRIENDS);
$xoopsTpl->assign('lang_only_users', _MD_SUICO_CONFIGS_ONLYEUSERS);
$xoopsTpl->assign('lang_everyone', _MD_SUICO_CONFIGS_EVERYONE);
$xoopsTpl->assign('lang_cancel', _MD_SUICO_CANCEL);
//Notes
//$xoopsTpl->assign('notes',$notes);
$xoopsTpl->assign('lang_answerNote', _MD_SUICO_ANSWERNOTE);
//navbar
$xoopsTpl->assign('lang_mysection', _MD_SUICO_CONFIGS_TITLE);
$xoopsTpl->assign('section_name', _MD_SUICO_CONFIGS_TITLE);
require __DIR__ . '/footer.php';
require dirname(__DIR__, 2) . '/footer.php';
