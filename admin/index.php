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
 * @category        Module
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Suico\{
    Common,
    Common\TestdataButtons,
    Helper,
    Utility
};
/** @var Admin $adminObject */
/** @var Helper $helper */
/** @var Utility $utility */
require_once __DIR__ . '/admin_header.php';
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
//if (null !== $newRelease) {
//    $adminObject->addItemButton($newRelease[0], $newRelease[1], 'download', 'style="color : Red"');
//}

//------------- Test Data Buttons ----------------------------
if ($helper->getConfig('displaySampleButton')) {
    TestdataButtons::loadButtonConfig($adminObject);
    $adminObject->displayButton('left', '');
}
$op = Request::getString('op', 0, 'GET');
switch ($op) {
    case 'hide_buttons':
        TestdataButtons::hideButtons();
        break;
    case 'show_buttons':
        TestdataButtons::showButtons();
        break;
}
//------------- End Test Data Buttons ----------------------------

$adminObject->displayIndex();

echo $utility::getServerStats();
require_once __DIR__ . '/admin_footer.php';
