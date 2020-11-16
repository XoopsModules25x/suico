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

use Xmf\Module\Admin;
use Xmf\Request;
use Xmf\Yaml;
use XoopsModules\Suico\{
    Common,
    Helper,
    Utility
};

/** @var Admin $adminObject */
/** @var Helper $helper */
/** @var Utility $utility */

require __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();
$adminObject = Admin::getInstance();
//check or upload folders
$configurator = new Common\Configurator();
foreach (array_keys($configurator->uploadFolders) as $i) {
    $utility::createFolder($configurator->uploadFolders[$i]);
    $adminObject->addConfigBoxLine($configurator->uploadFolders[$i], 'folder');
}
//-------------------------------------
/*
//count "total quotes"
$quotesCount = $quotesHandler->getCount();
// InfoBox quotes
$adminObject->addInfoBox(_AM_SUICO_STATISTICS);
// InfoBox quotes
$adminObject->addInfoBoxLine(sprintf(_AM_SUICO_THEREARE_QUOTES, $quotesCount));
*/
//count "total Images"
/** @var XoopsPersistableObjectHandler $imageHandler */
$totalImages = $imageHandler->getCount();
//count "total Friendship"
$totalFriendship = $friendshipHandler->getCount();
//count "total Visitors"
$totalVisitors = $visitorsHandler->getCount();
//count "total Video"
$totalVideo = $videoHandler->getCount();
//count "total Friendrequest"
$totalFriendrequest = $friendrequestHandler->getCount();
//count "total Groups"
$totalGroups = $groupsHandler->getCount();
//count "total Relgroupuser"
$totalRelgroupuser = $relgroupuserHandler->getCount();
//count "total Notes"
$totalNotes = $notesHandler->getCount();
//count "total Configs"
$totalConfigs = $configsHandler->getCount();
//count "total Suspensions"
$totalSuspensions = $suspensionsHandler->getCount();
//count "total Audio"
$totalAudio = $audioHandler->getCount();
//count "total Privacy"
$totalPrivacy = $privacyHandler->getCount();
// InfoBox Statistics
$adminObject->addInfoBox(AM_SUICO_STATISTICS);
// InfoBox images
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_IMAGES, $totalImages));
// InfoBox friendship
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_FRIENDS, $totalFriendship));
// InfoBox friendrequest
$adminObject->addInfoBoxLine(
    sprintf(AM_SUICO_THEREARE_FRIENDREQUEST, $totalFriendrequest)
);
// InfoBox visitors
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_VISITORS, $totalVisitors));
// InfoBox video
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_VIDEO, $totalVideo));
// InfoBox friendrequest
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_FRIENDREQUEST, $totalFriendrequest));
// InfoBox groups
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_GROUPS, $totalGroups));
// InfoBox relgroupuser
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_MEMBERS, $totalRelgroupuser));
// InfoBox notes
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_NOTES, $totalNotes));
// InfoBox configs
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_CONFIGS, $totalConfigs));
// InfoBox suspensions
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_SUSPENSIONS, $totalSuspensions));
// InfoBox audio
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_AUDIO, $totalAudio));
// InfoBox privacy
$adminObject->addInfoBoxLine(sprintf(AM_SUICO_THEREARE_PRIVACY, $totalPrivacy));
// Render Index
$adminObject->displayNavigation(basename(__FILE__));
//check for latest release
//$newRelease = $utility->checkVerModule($helper);
//if (!empty($newRelease)) {
//    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
//}
//------------- Test Data ----------------------------
if ($helper->getConfig('displaySampleButton')) {
    $yamlFile            = dirname(__DIR__) . '/config/admin.yml';
    $config              = loadAdminConfig($yamlFile);
    $displaySampleButton = $config['displaySampleButton'];
    if (1 === $displaySampleButton) {
        xoops_loadLanguage('admin/modulesadmin', 'system');
        require_once dirname(__DIR__) . '/testdata/index.php';
        $adminObject->addItemButton(
            constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA'),
            '__DIR__ . /../../testdata/index.php?op=load',
            'add'
        );
        $adminObject->addItemButton(
            constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA'),
            '__DIR__ . /../../testdata/index.php?op=save',
            'add'
        );
        //    $adminObject->addItemButton(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA'), '__DIR__ . /../../testdata/index.php?op=exportschema', 'add');
        $adminObject->addItemButton(
            constant('CO_' . $moduleDirNameUpper . '_' . 'HIDE_SAMPLEDATA_BUTTONS'),
            '?op=hide_buttons',
            'delete'
        );
    } else {
        $adminObject->addItemButton(
            constant('CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLEDATA_BUTTONS'),
            '?op=show_buttons',
            'add'
        );
        $displaySampleButton = $config['displaySampleButton'];
    }
    $adminObject->displayButton('left', '');
}
//------------- End Test Data ----------------------------
$adminObject->displayIndex();
/**
 * @param $yamlFile
 * @return array|bool
 */
function loadAdminConfig($yamlFile)
{
    return Yaml::readWrapped($yamlFile); // work with phpmyadmin YAML dumps
}

/**
 * @param $yamlFile
 */
function hideButtons($yamlFile)
{
    $app['displaySampleButton'] = 0;
    Yaml::save($app, $yamlFile);
    redirect_header('index.php', 0, '');
}

/**
 * @param $yamlFile
 */
function showButtons($yamlFile)
{
    $app                        = [];
    $app['displaySampleButton'] = 1;
    Yaml::save($app, $yamlFile);
    redirect_header('index.php', 0, '');
}

$op = Request::getString('op', 0, 'GET');
switch ($op) {
    case 'hide_buttons':
        hideButtons($yamlFile);
        break;
    case 'show_buttons':
        showButtons($yamlFile);
        break;
}
echo $utility::getServerStats();
require __DIR__ . '/admin_footer.php';
