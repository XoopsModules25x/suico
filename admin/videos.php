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

use Xmf\Module\Helper\Permission;
use Xmf\Request;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = Request::getString('op', 'list');
$order = Request::getString('order', 'desc');
$sort  = Request::getString('sort', '');
$adminObject->displayNavigation(basename(__FILE__));
$permHelper = new Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/suico/videos/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/suico/videos/';
switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_SUICO_VIDEO_LIST, 'videos.php', 'list');
        $adminObject->displayButton('left');
        $videoObject = $videoHandler->create();
        $form        = $videoObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('videos.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('video_id', 0)) {
            $videoObject = $videoHandler->get(Request::getInt('video_id', 0));
        } else {
            $videoObject = $videoHandler->create();
        }
        // Form save fields
        $videoObject->setVar('uid_owner', Request::getVar('uid_owner', ''));
        $videoObject->setVar('video_title', Request::getVar('video_title', ''));
        $videoObject->setVar('video_desc', Request::getVar('video_desc', ''));
		
		$videourl=Request::getVar('youtube_code', '');
		//Get youtube video id
		if (11 === mb_strlen($videourl)) {
			$videocode = $videourl;
		} else {
		//Get youtube video id
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videourl, $match);
			$videocode = $match[1];	
		}
        $videoObject->setVar('youtube_code', $videocode);
        $videoObject->setVar('featured_video', Request::getVar('featured_video', ''));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_created', '', 'POST'));
        $videoObject->setVar('date_created', $dateTimeObj->getTimestamp());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_updated', '', 'POST'));
        $videoObject->setVar('date_updated', $dateTimeObj->getTimestamp());
        if ($videoHandler->insert($videoObject)) {
            redirect_header('videos.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $videoObject->getHtmlErrors();
        $form = $videoObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_VIDEO, 'videos.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_VIDEO_LIST, 'videos.php', 'list');
        $adminObject->displayButton('left');
        $videoObject = $videoHandler->get(Request::getString('video_id', ''));
        $form        = $videoObject->getForm();
        $form->display();
        break;
    case 'delete':
        $videoObject = $videoHandler->get(Request::getString('video_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('videos.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($videoHandler->delete($videoObject)) {
                redirect_header('videos.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $videoObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'       => 1,
                    'video_id' => Request::getString('video_id', ''),
                    'op'       => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_SUICO_FORMSUREDEL,
                    $videoObject->getVar('video_desc')
                )
            );
        }
        break;
    case 'clone':
        $id_field = Request::getString('video_id', '');
        if ($utility::cloneRecord('suico_videos', 'video_id', $id_field)) {
            redirect_header('videos.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('videos.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_VIDEO, 'videos.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                = Request::getInt('start', 0);
        $videoPaginationLimit = $helper->getConfig('userpager');
        $criteria             = new CriteriaCompo();
        $criteria->setSort('video_id ASC, video_desc');
        $criteria->setOrder('ASC');
        $criteria->setLimit($videoPaginationLimit);
        $criteria->setStart($start);
        $videoTempRows  = $videoHandler->getCount();
        $videoTempArray = $videoHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_SUICO_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */
        // Display Page Navigation
        if ($videoTempRows > $videoPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $videoTempRows, $videoPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('videoRows', $videoTempRows);
        $videoArray = [];
        //    $fields = explode('|', video_id:int:11::NOT NULL::primary:video_id|uid_owner:int:11::NOT NULL:::uid_owner|video_desc:text:0::NOT NULL:::video_desc|youtube_code:varchar:11::NOT NULL:::youtube_code|featured_video:varchar:1::NOT NULL:::featured_video);
        //    $fieldsCount    = count($fields);
        $criteria = new CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($videoPaginationLimit);
        $criteria->setStart($start);
        $videoCount     = $videoHandler->getCount($criteria);
        $videoTempArray = $videoHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($videoCount > 0) {
            foreach (array_keys($videoTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);
                $GLOBALS['xoopsTpl']->assign('selectorvideo_id', AM_SUICO_VIDEO_VIDEO_ID);
                $videoArray['video_id'] = $videoTempArray[$i]->getVar('video_id');
                $GLOBALS['xoopsTpl']->assign('selectoruid_owner', AM_SUICO_VIDEO_UID_OWNER);
                $videoArray['uid_owner'] = strip_tags(
                    XoopsUser::getUnameFromId($videoTempArray[$i]->getVar('uid_owner'))
                );
                $GLOBALS['xoopsTpl']->assign('selectorvideo_title', AM_SUICO_VIDEO_TITLE);
                $videoArray['video_title'] = strip_tags($videoTempArray[$i]->getVar('video_title'));
                $GLOBALS['xoopsTpl']->assign('selectorvideo_desc', AM_SUICO_VIDEO_VIDEO_DESC);
                $videoArray['video_desc'] = strip_tags($videoTempArray[$i]->getVar('video_desc'));
                $GLOBALS['xoopsTpl']->assign('selectoryoutube_code', AM_SUICO_VIDEO_YOUTUBE_CODE);
                $videoArray['youtube_code'] = $videoTempArray[$i]->getVar('youtube_code');
                $GLOBALS['xoopsTpl']->assign('selectorfeatured_video', AM_SUICO_VIDEO_MAIN_VIDEO);
                $videoArray['featured_video'] = $videoTempArray[$i]->getVar('featured_video');
                $GLOBALS['xoopsTpl']->assign('selectordate_created', AM_SUICO_VIDEO_DATE_CREATED);
                $videoArray['date_created'] = formatTimestamp($videoTempArray[$i]->getVar('date_created'), 's');
                $GLOBALS['xoopsTpl']->assign('selectordate_updated', AM_SUICO_VIDEO_DATE_UPDATED);
                $videoArray['date_updated'] = formatTimestamp($videoTempArray[$i]->getVar('date_updated'), 's');
                $videoArray['edit_delete']  = "<a href='videos.php?op=edit&video_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='videos.php?op=delete&video_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='videos.php?op=clone&video_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('videosArray', $videoArray);
                unset($videoArray);
            }
            unset($videoTempArray);
            // Display Navigation
            if ($videoCount > $videoPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $videoCount, $videoPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/suico_admin_videos.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
