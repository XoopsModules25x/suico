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
 * Module: Yogurt
 *
 * @category        Module
 * @package         yogurt
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GPL 2.0 or later
 * @link            https://xoops.org/
 * @since           1.0.0
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
$uploadDir  = XOOPS_UPLOAD_PATH . '/yogurt/audio/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/yogurt/audio/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_YOGURT_AUDIO_LIST, 'audio.php', 'list');
        $adminObject->displayButton('left');

        $audioObject = $audioHandler->create();
        $form        = $audioObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('audio.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('audio_id', 0)) {
            $audioObject = $audioHandler->get(Request::getInt('audio_id', 0));
        } else {
            $audioObject = $audioHandler->create();
        }
        // Form save fields
        $audioObject->setVar('title', Request::getVar('title', ''));
        $audioObject->setVar('author', Request::getVar('author', ''));

//        $audioObject->setVar('url', Request::getVar('url', ''));
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = XOOPS_UPLOAD_PATH . '/yogurt/audio/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir, $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null
        );
        if ($uploader->fetchMedia(Request::getString('xoops_upload_file')[0], '', 'POST')) {
//            $uploader->setPrefix('url_');
            $uploader->setPrefix('aud_' . $uid . '_');
            $uploader->fetchMedia(Request::getString('xoops_upload_file')[0], '', 'POST');
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            } else {
                $audioObject->setVar("url", $uploader->getSavedFileName());
            }
        }

        $audioObject->setVar('uid_owner', Request::getVar('uid_owner', ''));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_created', '', 'POST'));
        $audioObject->setVar('date_created', $dateTimeObj->getTimestamp());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_updated', '', 'POST'));
        $audioObject->setVar('date_updated', $dateTimeObj->getTimestamp());

        if ($audioHandler->insert($audioObject)) {
            redirect_header('audio.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $audioObject->getHtmlErrors();
        $form = $audioObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_AUDIO, 'audio.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_AUDIO_LIST, 'audio.php', 'list');
        $adminObject->displayButton('left');
        $audioObject = $audioHandler->get(Request::getString('audio_id', ''));
        $form        = $audioObject->getForm();
        $form->display();
        break;

    case 'delete':
        $audioObject = $audioHandler->get(Request::getString('audio_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('audio.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($audioHandler->delete($audioObject)) {
                redirect_header('audio.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $audioObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'       => 1,
                    'audio_id' => Request::getString('audio_id', ''),
                    'op'       => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_YOGURT_FORMSUREDEL,
                    $audioObject->getVar('title')
                )
            );
        }
        break;

    case 'clone':

        $id_field = Request::getString('audio_id', '');

        if ($utility::cloneRecord('yogurt_audio', 'audio_id', $id_field)) {
            redirect_header('audio.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('audio.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_AUDIO, 'audio.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                = Request::getInt('start', 0);
        $audioPaginationLimit = $helper->getConfig('userpager');

        $criteria = new CriteriaCompo();
        $criteria->setSort('audio_id ASC, title');
        $criteria->setOrder('ASC');
        $criteria->setLimit($audioPaginationLimit);
        $criteria->setStart($start);
        $audioTempRows  = $audioHandler->getCount();
        $audioTempArray = $audioHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($audioTempRows > $audioPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new XoopsPageNav(
                $audioTempRows,
                $audioPaginationLimit,
                $start,
                'start',
                'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('audioRows', $audioTempRows);
        $audioArray = [];

        //    $fields = explode('|', audio_id:int:11::NOT NULL::primary:audio_id|title:varchar:256::NOT NULL:::title|author:varchar:256::NOT NULL:::author|url:varchar:256::NOT NULL:::url|uid_owner:int:11::NOT NULL:::uid_owner|date_created:date:0::NOT NULL:::date_created|date_updated:timestamp:CURRENT_TIMESTAMP::NOT NULL:::date_updated);
        //    $fieldsCount    = count($fields);

        $criteria = new CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($audioPaginationLimit);
        $criteria->setStart($start);

        $audioCount     = $audioHandler->getCount($criteria);
        $audioTempArray = $audioHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($audioCount > 0) {
            foreach (array_keys($audioTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign(
                    'selectoraudio_id',
                    AM_YOGURT_AUDIO_AUDIO_ID
                );
                $audioArray['audio_id'] = $audioTempArray[$i]->getVar('audio_id');

                $GLOBALS['xoopsTpl']->assign('selectortitle', AM_YOGURT_AUDIO_TITLE);
                $audioArray['title'] = $audioTempArray[$i]->getVar('title');

                $GLOBALS['xoopsTpl']->assign('selectorauthor', AM_YOGURT_AUDIO_AUTHOR);
                $audioArray['author'] = $audioTempArray[$i]->getVar('author');

                $GLOBALS['xoopsTpl']->assign('selectorurl', AM_YOGURT_AUDIO_URL);
                $audioArray['url'] = $audioTempArray[$i]->getVar('url');

                $GLOBALS['xoopsTpl']->assign('selectoruid_owner', AM_YOGURT_AUDIO_UID_OWNER);
                $audioArray['uid_owner'] = strip_tags(
                    XoopsUser::getUnameFromId($audioTempArray[$i]->getVar('uid_owner'))
                );

                $GLOBALS['xoopsTpl']->assign('selectordate_created', AM_YOGURT_AUDIO_DATE_CREATED);
                $audioArray['date_created'] = formatTimeStamp($audioTempArray[$i]->getVar('date_created'), 's');

                $GLOBALS['xoopsTpl']->assign('selectordate_updated', AM_YOGURT_AUDIO_DATE_UPDATED);
                $audioArray['date_updated'] = formatTimeStamp($audioTempArray[$i]->getVar('date_updated'), 's');

                $audioArray['edit_delete'] = "<a href='audio.php?op=edit&audio_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='audio.php?op=delete&audio_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='audio.php?op=clone&audio_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->append_by_ref('audioArrays', $audioArray);
                unset($audioArray);
            }
            unset($audioTempArray);
            // Display Navigation
            if ($audioCount > $audioPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new XoopsPageNav(
                    $audioCount,
                    $audioPaginationLimit,
                    $start,
                    'start',
                    'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='audio.php?op=edit&audio_id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='audio.php?op=delete&audio_id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='8'>There are noXXX audio</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/yogurt_admin_audio.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
