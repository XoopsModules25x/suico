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

use Xmf\Request;
use XoopsModules\Suico\{
    RelgroupuserHandler,
    GroupsHandler
};

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
$relgroupuserFactory = new RelgroupuserHandler($xoopsDB);
$groupsFactory       = new GroupsHandler($xoopsDB);
$marker              = Request::getInt('marker', 0, 'POST');
if (1 == $marker) { //if (1 === $marker) {
    /**
     * Verify Token
     */
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
    }
    if (0 !== \Xmf\Request::getInt('group_id', 0)) {
        $groupsObject = $groupsHandler->get(Request::getInt('group_id', 0));
    } else {
        $groupsObject = $groupsHandler->create();
    }
    // Form save fields
    $groupsObject->setVar('owner_uid', (int)$xoopsUser->getVar('uid'));
    $groupsObject->setVar('group_title', Request::getString('group_title', '', 'POST'));
    $groupsObject->setVar('group_desc', Request::getString('group_desc', '', 'POST'));
    //    $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_created', '', 'POST'));
    //    $groupsObject->setVar('date_created', $dateTimeObj->getTimestamp());
    //    $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_updated', '', 'POST'));
    //    $groupsObject->setVar('date_updated', $dateTimeObj->getTimestamp());
    $groupsObject->setVar('date_created', \time());
    $groupsObject->setVar('date_updated', \time());
    require_once XOOPS_ROOT_PATH . '/class/uploader.php';
    $uploadDir = XOOPS_UPLOAD_PATH . '/suico/groups/';
    $uploader  = new \XoopsMediaUploader(
        $uploadDir, $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null
    );
    if ($uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0])) {
        //$extension = preg_replace( '/^.+\.([^.]+)$/sU' , '' , $_FILES['attachedfile']['name']);
        //$imgName = str_replace(' ', '', $_POST['group_img']).'.'.$extension;
        $uploader->setPrefix('group_img_');
        $uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0]);
        if ($uploader->upload()) {
            $groupsObject->setVar('group_img', $uploader->getSavedFileName());
        } else {
            $errors = $uploader->getErrors();
            redirect_header('javascript:history.go(-1)', 3, $errors);
        }
    } else {
        $groupsObject->setVar('group_img', Request::getVar('group_img', ''));
    }
    if ($groupsHandler->insert($groupsObject)) {
        //add membership info for the group
        $relgroupuser = $relgroupuserFactory->create();
        $relgroupuser->setVar('rel_group_id', $xoopsDB->getInsertId());
        $relgroupuser->setVar('rel_user_uid', $xoopsUser->getVar('uid'));
        $relgroupuserFactory->insert($relgroupuser);
        $group_id = $relgroupuser->getVar('rel_group_id', $xoopsDB->getInsertId());
        redirect_header('group.php?group_id=' . $group_id . '', 500, _MD_SUICO_GROUP_CREATED);
        redirect_header('groups.php?op=list', 2, _MD_SUICO_GROUP_SAVED);
    } else {
        redirect_header(
            XOOPS_URL . '/modules/suico/groups.php?uid=' . (int)$xoopsUser->getVar('uid'),
            2,
            _MD_SUICO_ERROR
        );
        $group_img     = !empty($_POST['group_img']) ? Request::getString('group_img', '', 'POST') : '';
        $path_upload   = XOOPS_UPLOAD_PATH . '/suico/groups';
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
            //add membership info for the group
            $relgroupuser = $relgroupuserFactory->create();
            $relgroupuser->setVar('rel_group_id', $xoopsDB->getInsertId());
            $relgroupuser->setVar('rel_user_uid', $xoopsUser->getVar('uid'));
            $relgroupuserFactory->insert2($relgroupuser);
            $group_id = $relgroupuser->getVar('rel_group_id', $xoopsDB->getInsertId());
            redirect_header('group.php?group_id=' . $group_id . '', 500, _MD_SUICO_GROUP_CREATED);
        } else {
            $groupsFactory->renderFormSubmit(120000, $xoopsTpl);
        }
    }
} else {
    $groupsFactory->renderFormSubmit(120000, $xoopsTpl);
}
/**
 * Close page
 */
require dirname(__DIR__, 2) . '/footer.php';
