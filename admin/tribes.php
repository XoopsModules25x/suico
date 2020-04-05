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

use Xmf\Request;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = \Xmf\Request::getString('op', 'list');
$order = \Xmf\Request::getString('order', 'desc');
$sort  = \Xmf\Request::getString('sort', '');

$adminObject->displayNavigation(basename(__FILE__));
/** @var \Xmf\Module\Helper\Permission $permHelper */
$permHelper = new \Xmf\Module\Helper\Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/yogurt/tribes/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/yogurt/tribes/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_YOGURT_TRIBES_LIST, 'tribes.php', 'list');
        $adminObject->displayButton('left');

        $tribesObject = $tribesHandler->create();
        $form         = $tribesObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('tribes.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('tribe_id', 0)) {
            $tribesObject = $tribesHandler->get(Request::getInt('tribe_id', 0));
        } else {
            $tribesObject = $tribesHandler->create();
        }
        // Form save fields
        $tribesObject->setVar('owner_uid', Request::getVar('owner_uid', ''));
        $tribesObject->setVar('tribe_title', Request::getVar('tribe_title', ''));
        $tribesObject->setVar('tribe_desc', Request::getText('tribe_desc', ''));

        require_once XOOPS_ROOT_PATH . '/class/uploader.php';
        $uploadDir = XOOPS_UPLOAD_PATH . '/yogurt/tribes/';
        $uploader  = new \XoopsMediaUploader(
            $uploadDir, $helper->getConfig('mimetypes'), $helper->getConfig('maxsize'), null, null
        );
        if ($uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0])) {
            //$extension = preg_replace( '/^.+\.([^.]+)$/sU' , '' , $_FILES['attachedfile']['name']);
            //$imgName = str_replace(' ', '', $_POST['tribe_img']).'.'.$extension;

            $uploader->setPrefix('tribe_img_');
            $uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0]);
            if (!$uploader->upload()) {
                $errors = $uploader->getErrors();
                redirect_header('javascript:history.go(-1)', 3, $errors);
            } else {
                $tribesObject->setVar('tribe_img', $uploader->getSavedFileName());
            }
        } else {
            $tribesObject->setVar('tribe_img', Request::getVar('tribe_img', ''));
        }

        if ($tribesHandler->insert($tribesObject)) {
            redirect_header('tribes.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $tribesObject->getHtmlErrors();
        $form = $tribesObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_TRIBES, 'tribes.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_TRIBES_LIST, 'tribes.php', 'list');
        $adminObject->displayButton('left');
        $tribesObject = $tribesHandler->get(Request::getString('tribe_id', ''));
        $form         = $tribesObject->getForm();
        $form->display();
        break;

    case 'delete':
        $tribesObject = $tribesHandler->get(Request::getString('tribe_id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('tribes.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($tribesHandler->delete($tribesObject)) {
                redirect_header('tribes.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $tribesObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'tribe_id' => Request::getString('tribe_id', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_YOGURT_FORMSUREDEL, $tribesObject->getVar('tribe_title')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('tribe_id', '');

        if ($utility::cloneRecord('yogurt_tribes', 'tribe_id', $id_field)) {
            redirect_header('tribes.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('tribes.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_TRIBES, 'tribes.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                 = \Xmf\Request::getInt('start', 0);
        $tribesPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('tribe_id ASC, tribe_title');
        $criteria->setOrder('ASC');
        $criteria->setLimit($tribesPaginationLimit);
        $criteria->setStart($start);
        $tribesTempRows  = $tribesHandler->getCount();
        $tribesTempArray = $tribesHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($tribesTempRows > $tribesPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $tribesTempRows, $tribesPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('tribesRows', $tribesTempRows);
        $tribesArray = [];

        //    $fields = explode('|', tribe_id:int:11::NOT NULL::primary:tribe_id|owner_uid:int:11::NOT NULL:::owner_uid|tribe_title:varchar:255::NOT NULL:::tribe_title|tribe_desc:tinytext:0::NOT NULL:::tribe_desc|tribe_img:varchar:255::NOT NULL:::tribe_img);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($tribesPaginationLimit);
        $criteria->setStart($start);

        $tribesCount     = $tribesHandler->getCount($criteria);
        $tribesTempArray = $tribesHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($tribesCount > 0) {
            foreach (array_keys($tribesTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectortribe_id', AM_YOGURT_TRIBES_TRIBE_ID);
                $tribesArray['tribe_id'] = $tribesTempArray[$i]->getVar('tribe_id');

                $GLOBALS['xoopsTpl']->assign('selectorowner_uid', AM_YOGURT_TRIBES_OWNER_UID);
                $tribesArray['owner_uid'] = strip_tags(\XoopsUser::getUnameFromId($tribesTempArray[$i]->getVar('owner_uid')));

                $GLOBALS['xoopsTpl']->assign('selectortribe_title', AM_YOGURT_TRIBES_TRIBE_TITLE);
                $tribesArray['tribe_title'] = $tribesTempArray[$i]->getVar('tribe_title');

                $GLOBALS['xoopsTpl']->assign('selectortribe_desc', AM_YOGURT_TRIBES_TRIBE_DESC);
                $tribesArray['tribe_desc'] = $tribesTempArray[$i]->getVar('tribe_desc');

                $GLOBALS['xoopsTpl']->assign('selectortribe_img', AM_YOGURT_TRIBES_TRIBE_IMG);
                $tribesArray['tribe_img']   = "<img src='" . $uploadUrl . $tribesTempArray[$i]->getVar('tribe_img') . "' name='" . 'name' . "' id=" . 'id' . " alt='' style='max-width:100px'>";
                $tribesArray['edit_delete'] = "<a href='tribes.php?op=edit&tribe_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='tribes.php?op=delete&tribe_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='tribes.php?op=clone&tribe_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->append_by_ref('tribesArrays', $tribesArray);
                unset($tribesArray);
            }
            unset($tribesTempArray);
            // Display Navigation
            if ($tribesCount > $tribesPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $tribesCount, $tribesPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='tribes.php?op=edit&tribe_id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='tribes.php?op=delete&tribe_id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='6'>There are noXXX tribes</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/yogurt_admin_tribes.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
