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
$uploadDir  = XOOPS_UPLOAD_PATH . '/suico/images/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/suico/images/';
switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_SUICO_IMAGES_LIST, 'images.php', 'list');
        $adminObject->displayButton('left');
        $imagesObject = $imageHandler->create();
        $form         = $imagesObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('images.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('image_id', 0)) {
            $imagesObject = $imageHandler->get(Request::getInt('image_id', 0));
        } else {
            $imagesObject = $imageHandler->create();
        }
        // Form save fields
        $imagesObject->setVar('title', Request::getVar('title', ''));
        $imagesObject->setVar('caption', Request::getVar('caption', ''));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_created', '', 'POST'));
        $imagesObject->setVar('date_created', $dateTimeObj->getTimestamp());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_updated', '', 'POST'));
        $imagesObject->setVar('date_updated', $dateTimeObj->getTimestamp());
        $imagesObject->setVar('uid_owner', Request::getVar('uid_owner', ''));
        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = XOOPS_UPLOAD_PATH . '/suico/images/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir, $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null
        );
        if ($uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0])) {
            //$extension = preg_replace( '/^.+\.([^.]+)$/sU' , '' , $_FILES['attachedfile']['name']);
            //$imgName = str_replace(' ', '', $_POST['filename']).'.'.$extension;
            $uploader->setPrefix('pic_');
            $uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0]);
            if ($uploader->upload()) {
                $imagesObject->setVar('filename', $uploader->getSavedFileName());
            } else {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            }
        } else {
            $imagesObject->setVar('filename', Request::getVar('filename', ''));
        }
        $imagesObject->setVar('private', ((1 == \Xmf\Request::getInt('private', 0)) ? '1' : '0'));
        if ($imageHandler->insert($imagesObject)) {
            redirect_header('images.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $imagesObject->getHtmlErrors();
        $form = $imagesObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_IMAGES, 'images.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_IMAGES_LIST, 'images.php', 'list');
        $adminObject->displayButton('left');
        $imagesObject = $imageHandler->get(Request::getString('image_id', ''));
        $form         = $imagesObject->getForm();
        $form->display();
        break;
    case 'delete':
        $imagesObject = $imageHandler->get(Request::getString('image_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('images.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($imageHandler->delete($imagesObject)) {
                redirect_header('images.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $imagesObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'       => 1,
                    'image_id' => Request::getString('image_id', ''),
                    'op'       => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_SUICO_FORMSUREDEL,
                    $imagesObject->getVar('title')
                )
            );
        }
        break;
    case 'clone':
        $id_field = Request::getString('image_id', '');
        if ($utility::cloneRecord('suico_images', 'image_id', $id_field)) {
            redirect_header('images.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('images.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_IMAGES, 'images.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                 = Request::getInt('start', 0);
        $imagesPaginationLimit = $helper->getConfig('userpager');
        $criteria              = new CriteriaCompo();
        $criteria->setSort('image_id ASC, title');
        $criteria->setOrder('ASC');
        $criteria->setLimit($imagesPaginationLimit);
        $criteria->setStart($start);
        $imagesTempRows  = $imageHandler->getCount();
        $imagesTempArray = $imageHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_SUICO_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */
        // Display Page Navigation
        if ($imagesTempRows > $imagesPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $imagesTempRows, $imagesPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('imagesRows', $imagesTempRows);
        $imagesArray = [];
        //    $fields = explode('|', image_id:int:11::NOT NULL::primary:image_id|title:varchar:255::NOT NULL:::title|date_created:date:0::NOT NULL:::date_created|date_updated:date:0::NOT NULL:::date_updated|uid_owner:varchar:50::NOT NULL:::uid_owner|filename:text:0::NOT NULL:::filename|private:varchar:1::NOT NULL:::private);
        //    $fieldsCount    = count($fields);
        $criteria = new CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($imagesPaginationLimit);
        $criteria->setStart($start);
        $imagesCount     = $imageHandler->getCount($criteria);
        $imagesTempArray = $imageHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($imagesCount > 0) {
            foreach (array_keys($imagesTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);
                $GLOBALS['xoopsTpl']->assign(
                    'selectorimage_id',
                    AM_SUICO_IMAGES_IMAGE_ID
                );
                $imagesArray['image_id'] = $imagesTempArray[$i]->getVar('image_id');
                $GLOBALS['xoopsTpl']->assign('selectortitle', AM_SUICO_IMAGES_TITLE);
                $imagesArray['title'] = $imagesTempArray[$i]->getVar('title');
                $GLOBALS['xoopsTpl']->assign('selectorcaption', AM_SUICO_IMAGES_CAPTION);
                $imagesArray['caption'] = $imagesTempArray[$i]->getVar('caption');
                $GLOBALS['xoopsTpl']->assign('selectordate_created', AM_SUICO_IMAGES_DATE_CREATED);
                $imagesArray['date_created'] = formatTimestamp($imagesTempArray[$i]->getVar('date_created'), 's');
                $GLOBALS['xoopsTpl']->assign('selectordate_updated', AM_SUICO_IMAGES_DATE_UPDATED);
                $imagesArray['date_updated'] = formatTimestamp($imagesTempArray[$i]->getVar('date_updated'), 's');
                $GLOBALS['xoopsTpl']->assign('selectoruid_owner', AM_SUICO_IMAGES_UID_OWNER);
                $imagesArray['uid_owner'] = strip_tags(
                    XoopsUser::getUnameFromId($imagesTempArray[$i]->getVar('uid_owner'))
                );
                $GLOBALS['xoopsTpl']->assign('selectorurl', AM_SUICO_IMAGES_URL);
                $imagesArray['filename'] = "<img src='" . $uploadUrl . $imagesTempArray[$i]->getVar('filename') . "' name='" . 'name' . "' id=" . 'id' . " alt='' style='max-width:100px'>";
                $GLOBALS['xoopsTpl']->assign('selectorprivate', AM_SUICO_IMAGES_PRIVATE);
                $imagesArray['private']     = $imagesTempArray[$i]->getVar('private');
                $imagesArray['edit_delete'] = "<a href='images.php?op=edit&image_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='images.php?op=delete&image_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='images.php?op=clone&image_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('imagesArrays', $imagesArray);
                unset($imagesArray);
            }
            unset($imagesTempArray);
            // Display Navigation
            if ($imagesCount > $imagesPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $imagesCount, $imagesPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/suico_admin_images.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
