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

use Xmf\Request;

require __DIR__ . '/admin_header.php';
xoops_cp_header();
//It recovered the value of argument op in URL$
$op    = \Xmf\Request::getString('op', 'list');
$order = \Xmf\Request::getString('order', 'desc');
$sort  = \Xmf\Request::getString('sort', '');

$adminObject->displayNavigation(basename(__FILE__));
$permHelper = new \Xmf\Module\Helper\Permission();
$uploadDir  = XOOPS_UPLOAD_PATH . '/yogurt/images/';
$uploadUrl  = XOOPS_UPLOAD_URL . '/yogurt/images/';

switch ($op) {
    case 'new':
        $adminObject->addItemButton(AM_YOGURT_PRIVACY_LIST, 'privacy.php', 'list');
        $adminObject->displayButton('left');

        $privacyObject = $privacyHandler->create();
        $form          = $privacyObject->getForm();
        $form->display();
        break;

    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('privacy.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== \Xmf\Request::getInt('id', 0)) {
            $privacyObject = $privacyHandler->get(Request::getInt('id', 0));
        } else {
            $privacyObject = $privacyHandler->create();
        }
        // Form save fields
        $privacyObject->setVar('level', Request::getVar('level', ''));
        $privacyObject->setVar('name', Request::getVar('name', ''));
        $privacyObject->setVar('description', Request::getText('description', ''));
        if ($privacyHandler->insert($privacyObject)) {
            redirect_header('privacy.php?op=list', 2, AM_YOGURT_FORMOK);
        }

        echo $privacyObject->getHtmlErrors();
        $form = $privacyObject->getForm();
        $form->display();
        break;

    case 'edit':
        $adminObject->addItemButton(AM_YOGURT_ADD_PRIVACY, 'privacy.php?op=new', 'add');
        $adminObject->addItemButton(AM_YOGURT_PRIVACY_LIST, 'privacy.php', 'list');
        $adminObject->displayButton('left');
        $privacyObject = $privacyHandler->get(Request::getString('id', ''));
        $form          = $privacyObject->getForm();
        $form->display();
        break;

    case 'delete':
        $privacyObject = $privacyHandler->get(Request::getString('id', ''));
        if (1 == \Xmf\Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('privacy.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($privacyHandler->delete($privacyObject)) {
                redirect_header('privacy.php', 3, AM_YOGURT_FORMDELOK);
            } else {
                echo $privacyObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(['ok' => 1, 'id' => Request::getString('id', ''), 'op' => 'delete',], Request::getUrl('REQUEST_URI', '', 'SERVER'), sprintf(AM_YOGURT_FORMSUREDEL, $privacyObject->getVar('name')));
        }
        break;

    case 'clone':

        $id_field = \Xmf\Request::getString('id', '');

        if ($utility::cloneRecord('yogurt_privacy', 'id', $id_field)) {
            redirect_header('privacy.php', 3, AM_YOGURT_CLONED_OK);
        } else {
            redirect_header('privacy.php', 3, AM_YOGURT_CLONED_FAILED);
        }

        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_YOGURT_ADD_PRIVACY, 'privacy.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                  = \Xmf\Request::getInt('start', 0);
        $privacyPaginationLimit = $helper->getConfig('userpager');

        $criteria = new \CriteriaCompo();
        $criteria->setSort('id ASC, name');
        $criteria->setOrder('ASC');
        $criteria->setLimit($privacyPaginationLimit);
        $criteria->setStart($start);
        $privacyTempRows  = $privacyHandler->getCount();
        $privacyTempArray = $privacyHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_YOGURT_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */

        // Display Page Navigation
        if ($privacyTempRows > $privacyPaginationLimit) {
            xoops_load('XoopsPageNav');

            $pagenav = new \XoopsPageNav(
                $privacyTempRows,
                $privacyPaginationLimit,
                $start,
                'start',
                'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }

        $GLOBALS['xoopsTpl']->assign('privacyRows', $privacyTempRows);
        $privacyArray = [];

        //    $fields = explode('|', id:int:8::NOT NULL:::ID:0|level:int:8::NOT NULL:::Level:1|name:varchar:20::NOT NULL:::Name:2|description:text:::NOT NULL:::Description:3);
        //    $fieldsCount    = count($fields);

        $criteria = new \CriteriaCompo();

        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($privacyPaginationLimit);
        $criteria->setStart($start);

        $privacyCount     = $privacyHandler->getCount($criteria);
        $privacyTempArray = $privacyHandler->getAll($criteria);

        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($privacyCount > 0) {
            foreach (array_keys($privacyTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);

                $GLOBALS['xoopsTpl']->assign('selectorid', AM_YOGURT_PRIVACY_ID);
                $privacyArray['id'] = $privacyTempArray[$i]->getVar('id');

                $selectorlevel = $utility::selectSorting(AM_YOGURT_PRIVACY_LEVEL, 'level');
                $GLOBALS['xoopsTpl']->assign('selectorlevel', $selectorlevel);
                $privacyArray['level'] = $privacyTempArray[$i]->getVar('level');

                $GLOBALS['xoopsTpl']->assign('selectorname', AM_YOGURT_PRIVACY_NAME);
                $privacyArray['name'] = $privacyTempArray[$i]->getVar('name');

                $GLOBALS['xoopsTpl']->assign('selectordescription', AM_YOGURT_PRIVACY_DESCRIPTION);
                $privacyArray['description'] = $privacyTempArray[$i]->getVar('description');
                $privacyArray['description'] = $utility::truncateHtml($privacyArray['description'], $helper->getConfig('truncatelength'));
                $privacyArray['edit_delete'] = "<a href='privacy.php?op=edit&id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='privacy.php?op=delete&id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='privacy.php?op=clone&id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";

                $GLOBALS['xoopsTpl']->append_by_ref('privacyArrays', $privacyArray);
                unset($privacyArray);
            }
            unset($privacyTempArray);
            // Display Navigation
            if ($privacyCount > $privacyPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $privacyCount,
                    $privacyPaginationLimit,
                    $start,
                    'start',
                    'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }

            //                     echo "<td class='center width5'>

            //                    <a href='privacy.php?op=edit&id=".$i."'><img src=".$pathIcon16."/edit.png alt='"._EDIT."' title='"._EDIT."'></a>
            //                    <a href='privacy.php?op=delete&id=".$i."'><img src=".$pathIcon16."/delete.png alt='"._DELETE."' title='"._DELETE."'></a>
            //                    </td>";

            //                echo "</tr>";

            //            }

            //            echo "</table><br><br>";

            //        } else {

            //            echo "<table width='100%' cellspacing='1' class='outer'>

            //                    <tr>

            //                     <th class='center width5'>".AM_YOGURT_FORM_ACTION."XXX</th>
            //                    </tr><tr><td class='errorMsg' colspan='5'>There are noXXX privacy</td></tr>";
            //            echo "</table><br><br>";

            //-------------------------------------------

            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/admin/yogurt_admin_privacy.tpl'
            );
        }

        break;
}
require __DIR__ . '/admin_footer.php';
