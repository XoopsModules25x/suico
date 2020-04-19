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
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Marcello Brandão aka  Suico
 * @author       XOOPS Development Team
 * @since
 */

use XoopsModules\Yogurt;
use Xmf\Request;

$GLOBALS['xoopsOption']['template_main'] = 'yogurt_audio.tpl';
require __DIR__ . '/header.php';

$controller = new Yogurt\AudioController($xoopsDB, $xoopsUser);

/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();

$start = Request::getInt('start', 0, 'GET');

/**
 * Criteria for Audio
 */
$criteriaUidAudio = new Criteria('uid_owner', $controller->uidOwner);
$criteriaUidAudio->setStart($start);
$criteriaUidAudio->setLimit($helper->getConfig('audiosperpage'));

/**
 * Get all audios of this user and assign them to template
 */
$audios       = $controller->getAudio($criteriaUidAudio);
$nbAudio = isset($nbSections['nbAudio']) ?  $nbSections['nbAudio'] : '';
try {
    $audios_array = $controller->assignAudioContent($nbAudio, $audios);
} catch (\RuntimeException $e) {
}

if (is_array($audios_array)) {
    $xoopsTpl->assign('audios', $audios_array);
    $audio_list = [];
    foreach ($audios_array as $audio_item) {
        $audio_list[] = XOOPS_UPLOAD_URL . '/yogurt/audio/' . $audio_item['url']; // . ' | ';
    }
    //$audio_list = substr($audio_list,-2);
    $xoopsTpl->assign('audio_list', $audio_list);
} else {
    $xoopsTpl->assign('lang_noaudioyet', _MD_YOGURT_NOAUDIOYET);
}
$pageNav = '';
if (isset($nbSections['nbAudio']) && $nbSections['nbAudio'] > 0) {
    $pageNav = $controller->getAudiosNavBar($nbSections['nbAudio'], $helper->getConfig('audiosperpage'), $start, 2);
}
$xoTheme->addScript('https://unpkg.com/wavesurfer.js');

//meta language names
$xoopsTpl->assign('lang_meta', _MD_YOGURT_META);
$xoopsTpl->assign('lang_title', _MD_YOGURT_META_TITLE);
$xoopsTpl->assign('lang_album', _MD_YOGURT_META_ALBUM);
$xoopsTpl->assign('lang_artist', _MD_YOGURT_META_ARTIST);
$xoopsTpl->assign('lang_year', _MD_YOGURT_META_YEAR);

//form actions
$xoopsTpl->assign('lang_delete', _MD_YOGURT_DELETE);
$xoopsTpl->assign('lang_editdesc', _MD_YOGURT_EDITDESC);
$xoopsTpl->assign('lang_makemain', _MD_YOGURT_MAKEMAIN);

//Form Submit
$xoopsTpl->assign('lang_selectaudio', _MD_YOGURT_SELECTAUDIO);
$xoopsTpl->assign('lang_authorLabel', _MD_YOGURT_AUTHORAUDIO);
$xoopsTpl->assign('lang_titleLabel', _MD_YOGURT_TITLEAUDIO);
$xoopsTpl->assign('lang_submitValue', _MD_YOGURT_SUBMITAUDIO);
$xoopsTpl->assign('lang_addaudios', _MD_YOGURT_ADDAUDIO);

$xoopsTpl->assign('width', $helper->getConfig('width_tube'));
$xoopsTpl->assign('height', $helper->getConfig('height_tube'));
$xoopsTpl->assign('player_from_list', _MD_YOGURT_PLAYER);
$xoopsTpl->assign('lang_audiohelp', sprintf(_MD_YOGURT_ADDAUDIOHELP, $helper->getConfig('maxfilesize')));
$xoopsTpl->assign('max_youcanupload', $helper->getConfig('maxfilesize'));

$xoopsTpl->assign('lang_mysection', _MD_YOGURT_MYAUDIOS);
$xoopsTpl->assign('section_name', _MD_YOGURT_AUDIOS);

//Page Navigation
$xoopsTpl->assign('pageNav', $pageNav);


require __DIR__ . '/footer.php';
require dirname(dirname(__DIR__)) . '/footer.php';
