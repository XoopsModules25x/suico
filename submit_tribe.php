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
//include_once 'class/Friendpetition.php';
//include_once 'class/Reltribeuser.php';
//include_once 'class/Tribes.php';

/**
 * Factories of tribes
 */
$reltribeuserFactory = new Yogurt\ReltribeuserHandler($xoopsDB);
$tribesFactory = new Yogurt\TribesHandler($xoopsDB);

$marker = isset($_POST['marker']) ? $_POST['marker'] : 0;

if (1 == $marker) {
    /**
     * Verify Token
     */
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
    }

    $myts = MyTextSanitizer::getInstance();
    $tribe_title = $myts->displayTarea($_POST['tribe_title'], 0, 1, 1, 1, 1);
    $tribe_desc = $myts->displayTarea($_POST['tribe_desc'], 0, 1, 1, 1, 1);
    $tribe_img = (!empty($_POST['tribe_img'])) ? $_POST['tribe_img'] : '';
    $path_upload = XOOPS_ROOT_PATH . '/uploads';
    $pictwidth = $xoopsModuleConfig['resized_width'];
    $pictheight = $xoopsModuleConfig['resized_height'];
    $thumbwidth = $xoopsModuleConfig['thumb_width'];
    $thumbheight = $xoopsModuleConfig['thumb_height'];
    $maxfilebytes = $xoopsModuleConfig['maxfilesize'];
    $maxfileheight = $xoopsModuleConfig['max_original_height'];
    $maxfilewidth = $xoopsModuleConfig['max_original_width'];
    if ($tribesFactory->receiveTribe($tribe_title, $tribe_desc, '', $path_upload, $maxfilebytes, $maxfilewidth, $maxfileheight)) {
        $reltribeuser = $reltribeuserFactory->create();
        $reltribeuser->setVar('rel_tribe_id', $xoopsDB->getInsertId());
        $reltribeuser->setVar('rel_user_uid', $xoopsUser->getVar('uid'));
        $reltribeuserFactory->insert($reltribeuser);
        redirect_header('tribes.php', 500, _MD_YOGURT_TRIBE_CREATED);
    } else {
        $tribesFactory->renderFormSubmit(120000, $xoopsTpl);
    }
} else {
    $tribesFactory->renderFormSubmit(120000, $xoopsTpl);
}

/**
 * Close page
 */
include '../../footer.php';
