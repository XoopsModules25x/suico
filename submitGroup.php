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

use Xmf\Request;
use XoopsModules\Yogurt;

require __DIR__ . '/header.php';

/**
 * Modules class includes
 */
//require_once __DIR__ . '/class/Friendrequest.php';
//require_once __DIR__ . '/class/Relgroupuser.php';
//require_once __DIR__ . '/class/Groups.php';

/**
 * Factories of groups
 */
$relgroupuserFactory = new Yogurt\RelgroupuserHandler($xoopsDB);
$groupsFactory       = new Yogurt\GroupsHandler($xoopsDB);


///**
// * Factory of pictures created
// */
//$imageFactory = new Yogurt\ImageHandler($xoopsDB);
//
///**
// * Getting the title
// */
//$title = $_POST['caption'];







//
///**
// * Getting parameters defined in admin side
// */
//$path_upload   = XOOPS_ROOT_PATH . '/uploads/yogurt/groups';
//$pictwidth     = $helper->getConfig('resized_width');
//$pictheight    = $helper->getConfig('resized_height');
//$thumbwidth    = $helper->getConfig('thumb_width');
//$thumbheight   = $helper->getConfig('thumb_height');
//$maxfilebytes  = $helper->getConfig('maxfilesize');
//$maxfileheight = $helper->getConfig('max_original_height');
//$maxfilewidth  = $helper->getConfig('max_original_width');
//
///**
// * If we are receiving a file
// */
//if ('sel_photo' === $_POST['xoops_upload_file'][0]) {
//    /**
//     * Verify Token
//     */
//    if (!$GLOBALS['xoopsSecurity']->check()) {
//        redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
//    }
//    ini_set('memory_limit', '50M');
//    /**
//     * Try to upload picture resize it insert in database and then redirect to index
//     */
//    if ($imageFactory->receivePicture(
//        $title,
//        $path_upload,
//        $thumbwidth,
//        $thumbheight,
//        $pictwidth,
//        $pictheight,
//        $maxfilebytes,
//        $maxfilewidth,
//        $maxfileheight
//    )) {
//        $extra_tags['X_OWNER_NAME'] = $xoopsUser->getVar('uname');
//        $extra_tags['X_OWNER_UID']  = $xoopsUser->getVar('uid');
//        ** @var \XoopsNotificationHandler $notificationHandler */
//        $notificationHandler        = xoops_getHandler('notification');
//        $notificationHandler->triggerEvent('picture', $xoopsUser->getVar('uid'), 'new_picture', $extra_tags);
//        //header("Location: ".XOOPS_URL."/modules/yogurt/index.php?uid=".$xoopsUser->getVar('uid'));
//
//
//        $relgroupuser = $relgroupuserFactory->create();
//        $relgroupuser->setVar('rel_group_id', $xoopsDB->getInsertId());
//        $relgroupuser->setVar('rel_user_uid', $xoopsUser->getVar('uid'));
//        $relgroupuserFactory->insert2($relgroupuser);
//        redirect_header('groups.php', 500, _MD_YOGURT_GROUP_CREATED);
//    } else {
//        $groupsFactory->renderFormSubmit(120000, $xoopsTpl);
//    }




//        redirect_header(
//            XOOPS_URL . '/modules/yogurt/groups.php?uid=' . $xoopsUser->getVar('uid'),
//            3,
//            _MD_YOGURT_UPLOADED
//        );
//    } else {
//        redirect_header(
//            XOOPS_URL . '/modules/yogurt/groups.php?uid=' . $xoopsUser->getVar('uid'),
//            3,
//            _MD_YOGURT_NOCACHACA
//        );
//    }

//}







$marker = Request::getInt('marker', 0, 'POST');

if (1 === $marker) {//if (1 === $marker) {
    /**
     * Verify Token
     */
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
    }

    $myts          = MyTextSanitizer::getInstance();
    $group_title   = $myts->displayTarea(Request::getString('group_title', '', 'POST'), 0, 1, 1, 1, 1);
    $group_desc    = $myts->displayTarea(Request::getString('group_desc', '', 'POST'), 0, 1, 1, 1, 1);
    $group_img     = !empty($_POST['group_img']) ? Request::getString('group_img', '', 'POST') : '';
    $path_upload   = XOOPS_UPLOAD_PATH . '/yogurt/groups';
    $pictwidth     = $helper->getConfig('resized_width');
    $pictheight    = $helper->getConfig('resized_height');
    $thumbwidth    = $helper->getConfig('thumb_width');
    $thumbheight   = $helper->getConfig('thumb_height');
    $maxfilebytes  = $helper->getConfig('maxfilesize');
    $maxfileheight = $helper->getConfig('max_original_height');
    $maxfilewidth  = $helper->getConfig('max_original_width');
    if ($groupsFactory->receiveGroup(
        $group_title,
        $group_desc,
        '',
        $path_upload,
        $maxfilebytes,
        $maxfilewidth,
        $maxfileheight
    )) {
        $relgroupuser = $relgroupuserFactory->create();
        $relgroupuser->setVar('rel_group_id', $xoopsDB->getInsertId());
        $relgroupuser->setVar('rel_user_uid', $xoopsUser->getVar('uid'));
        $relgroupuserFactory->insert2($relgroupuser);
        $group_id=$relgroupuser->getVar('rel_group_id', $xoopsDB->getInsertId());
        redirect_header('group.php?group_id='.$group_id.'', 500, _MD_YOGURT_GROUP_CREATED);
    } else {
        $groupsFactory->renderFormSubmit(120000, $xoopsTpl);
    }
} else {
    $groupsFactory->renderFormSubmit(120000, $xoopsTpl);
}

/**
 * Close page
 */
require dirname(__DIR__, 2) . '/footer.php';
