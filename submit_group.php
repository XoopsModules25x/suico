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

require __DIR__ . '/header.php';

/**
 * Modules class includes
 */
//require_once __DIR__ . '/class/Friendpetition.php';
//require_once __DIR__ . '/class/Relgroupuser.php';
//require_once __DIR__ . '/class/Groups.php';

/**
 * Factories of groups
 */
$relgroupuserFactory = new Yogurt\RelgroupuserHandler($xoopsDB);
$groupsFactory       = new Yogurt\GroupsHandler($xoopsDB);

$marker = isset($_POST['marker']) ? $_POST['marker'] : 0;

if (1 == $marker) {
    /**
     * Verify Token
     */
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
    }

    $myts          = \MyTextSanitizer::getInstance();
    $group_title   = $myts->displayTarea($_POST['group_title'], 0, 1, 1, 1, 1);
    $group_desc    = $myts->displayTarea($_POST['group_desc'], 0, 1, 1, 1, 1);
    $group_img     = (!empty($_POST['group_img'])) ? $_POST['group_img'] : '';
    $path_upload   = XOOPS_UPLOAD_PATH . '/yogurt/groups';
    $pictwidth     = $xoopsModuleConfig['resized_width'];
    $pictheight    = $xoopsModuleConfig['resized_height'];
    $thumbwidth    = $xoopsModuleConfig['thumb_width'];
    $thumbheight   = $xoopsModuleConfig['thumb_height'];
    $maxfilebytes  = $xoopsModuleConfig['maxfilesize'];
    $maxfileheight = $xoopsModuleConfig['max_original_height'];
    $maxfilewidth  = $xoopsModuleConfig['max_original_width'];
    if ($groupsFactory->receiveGroup($group_title, $group_desc, '', $path_upload, $maxfilebytes, $maxfilewidth, $maxfileheight)) {
        $relgroupuser = $relgroupuserFactory->create();
        $relgroupuser->setVar('rel_group_id', $xoopsDB->getInsertId());
        $relgroupuser->setVar('rel_user_uid', $xoopsUser->getVar('uid'));
        $relgroupuserFactory->insert($relgroupuser);
        redirect_header('groups.php', 500, _MD_YOGURT_GROUP_CREATED);
    } else {
        $groupsFactory->renderFormSubmit(120000, $xoopsTpl);
    }
} else {
    $groupsFactory->renderFormSubmit(120000, $xoopsTpl);
}

/**
 * Close page
 */
require dirname(dirname(__DIR__)) . '/footer.php';
