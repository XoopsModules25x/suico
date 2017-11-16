<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author     XOOPS Development Team
 */

require_once __DIR__ . '/admin_header.php';
// Display Admin header
xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();

//$configurator = include __DIR__ . '/../include/config.php';
//foreach (array_keys($configurator->uploadFolders) as $i) {
//    $utility::createFolder($configurator->uploadFolders[$i]);
//    $adminObject->addConfigBoxLine($configurator->uploadFolders[$i], 'folder');
//}

/*
//-------------------------------------
//count "total quotes"
$quotesCount = $quotesHandler->getCount();
// InfoBox quotes
$adminObject->addInfoBox(_AM_RANDOMQUOTE_STATISTICS);
// InfoBox quotes
$adminObject->addInfoBoxLine(sprintf(_AM_RANDOMQUOTE_THEREARE_QUOTES, $quotesCount));

// or

$adminObject->addInfoBox(_AM_LEXIKON_SUMMARY);
$adminObject->addInfoBoxLine(sprintf(_AM_LEXIKON_TOTALENTRIES2, '<span class="green">' . $summary['publishedEntries'] . '</span>'), '', 'green');
$adminObject->addInfoBoxLine(sprintf(_AM_LEXIKON_TOTALCATS2, '<span class="green">' .$summary['availableCategories']. '</span>'), '', 'green');
$adminObject->addInfoBoxLine(sprintf(_AM_LEXIKON_TOTALSUBM2, '<span class="red">' .$summary['submittedEntries']. '</span>'), '', 'red');
$adminObject->addInfoBoxLine(sprintf(_AM_LEXIKON_TOTALREQ2, '<span class="red">' .$summary['requestedEntries']. '</span>'), '', 'red');


$adminObject->addInfoBox(_AM_SOAPBOX_MODCONTENT);
if ($totcol > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="main.php">' . _AM_SOAPBOX_TOTCOL . '</a>' . '</infolabel>', '<span class="green">' . $totcol . '</span>'), '', 'green');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_TOTCOL . '</infolabel>', '<span class="green">' . $totcol . '</span>'), '', 'Green');
}
if ($totpub > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="main.php">' . _AM_SOAPBOX_TOTART . '</a>' . '</infolabel>', '<span class="green">' . $totpub . '</span>'), '', 'green');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_TOTART . '</infolabel>', '<span class="green">' . $totpub . '</span>'), '', 'green');
}
if ($totoff > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="main.php">' . _AM_SOAPBOX_TOTOFF . '</a>' . '</infolabel>', '<span class="red">' . $totoff . '</span>'), '', 'red');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_TOTOFF . '</infolabel>', '<span class="green">' . $totoff . '</span>'), '', 'green');
}
if ($totall > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="main.php">' . _AM_SOAPBOX_TOTSUB . '</a>' . '</infolabel>', '<span class="green">' . $totall . '</span>'), '', 'green');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_TOTSUB . '</infolabel>', '<span class="green">' . $totall . '</span>'), '', 'green');
}

if ($totsub > 0) {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . '<a href="submissions.php">' . _AM_SOAPBOX_NEED_APPROVAL . '</a>' . '</infolabel>', '<span class="green">' . $totsub . '</span>'), '', 'red');
} else {
    $adminObject->addInfoBoxLine(sprintf('<infolabel>' . _AM_SOAPBOX_NEED_APPROVAL . '</infolabel>', '<span class="green">' . $totsub . '</span>'), '', 'green');
}
*/
$adminObject->displayNavigation(basename(__FILE__));

//------------- Test Data ----------------------------
//if ($publisher->getConfig('displaySampleButton')) {
//    xoops_loadLanguage('admin/modulesadmin', 'system');
//    require_once __DIR__ . '/../testdata/index.php';
//    $adminObject->addItemButton(_AM_SYSTEM_MODULES_INSTALL_TESTDATA, '__DIR__ . /../../testdata/index.php?op=load', 'add');
//    $adminObject->displayButton('left', '');
//}
//------------- End Test Data ----------------------------

$adminObject->displayIndex();


//echo $utility::getServerStats();

require_once __DIR__ . '/admin_footer.php';

