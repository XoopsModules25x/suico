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
        $adminObject->addItemButton(AM_SUICO_FRIENDSHIP_LIST, 'friendships.php', 'list');
        $adminObject->displayButton('left');
        $friendshipObject = $friendshipHandler->create();
        $form             = $friendshipObject->getForm();
        $form->display();
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('friendships.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (0 !== Request::getInt('friendship_id', 0)) {
            $friendshipObject = $friendshipHandler->get(Request::getInt('friendship_id', 0));
        } else {
            $friendshipObject = $friendshipHandler->create();
        }
        // Form save fields
        $friendshipObject->setVar('friend1_uid', Request::getVar('friend1_uid', ''));
        $friendshipObject->setVar('friend2_uid', Request::getVar('friend2_uid', ''));
        $friendshipObject->setVar('level', Request::getVar('level', ''));
        $friendshipObject->setVar('hot', Request::getVar('hot', ''));
        $friendshipObject->setVar('trust', Request::getVar('trust', ''));
        $friendshipObject->setVar('cool', Request::getVar('cool', ''));
        $friendshipObject->setVar('fan', Request::getVar('fan', ''));
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_created', '', 'POST'));
        $friendshipObject->setVar('date_created', $dateTimeObj->getTimestamp());
        $dateTimeObj = \DateTime::createFromFormat(_SHORTDATESTRING, Request::getString('date_updated', '', 'POST'));
        $friendshipObject->setVar('date_updated', $dateTimeObj->getTimestamp());
        if ($friendshipHandler->insert($friendshipObject)) {
            redirect_header('friendships.php?op=list', 2, AM_SUICO_FORMOK);
        }
        echo $friendshipObject->getHtmlErrors();
        $form = $friendshipObject->getForm();
        $form->display();
        break;
    case 'edit':
        $adminObject->addItemButton(AM_SUICO_ADD_FRIENDSHIP, 'friendships.php?op=new', 'add');
        $adminObject->addItemButton(AM_SUICO_FRIENDSHIP_LIST, 'friendships.php', 'list');
        $adminObject->displayButton('left');
        $friendshipObject = $friendshipHandler->get(Request::getString('friendship_id', ''));
        $form             = $friendshipObject->getForm();
        $form->display();
        break;
    case 'delete':
        $friendshipObject = $friendshipHandler->get(Request::getString('friendship_id', ''));
        if (1 === Request::getInt('ok', 0)) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('friendships.php', 3, implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($friendshipHandler->delete($friendshipObject)) {
                redirect_header('friendships.php', 3, AM_SUICO_FORMDELOK);
            } else {
                echo $friendshipObject->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok'            => 1,
                    'friendship_id' => Request::getString('friendship_id', ''),
                    'op'            => 'delete',
                ],
                Request::getUrl('REQUEST_URI', '', 'SERVER'),
                sprintf(
                    AM_SUICO_FORMSUREDEL,
                    $friendshipObject->getVar('friendship_id')
                )
            );
        }
        break;
    case 'clone':
        $id_field = Request::getString('friendship_id', '');
        if ($utility::cloneRecord('suico_friendships', 'friendship_id', $id_field)) {
            redirect_header('friendships.php', 3, AM_SUICO_CLONED_OK);
        } else {
            redirect_header('friendships.php', 3, AM_SUICO_CLONED_FAILED);
        }
        break;
    case 'list':
    default:
        $adminObject->addItemButton(AM_SUICO_ADD_FRIENDSHIP, 'friendships.php?op=new', 'add');
        $adminObject->displayButton('left');
        $start                     = Request::getInt('start', 0);
        $friendshipPaginationLimit = $helper->getConfig('userpager');
        $criteria                  = new CriteriaCompo();
        $criteria->setSort('friendship_id ASC, friendship_id');
        $criteria->setOrder('ASC');
        $criteria->setLimit($friendshipPaginationLimit);
        $criteria->setStart($start);
        $friendshipTempRows  = $friendshipHandler->getCount();
        $friendshipTempArray = $friendshipHandler->getAll($criteria);
        /*
        //
        //
                            <th class='center width5'>".AM_SUICO_FORM_ACTION."</th>
        //                    </tr>";
        //            $class = "odd";
        */
        // Display Page Navigation
        if ($friendshipTempRows > $friendshipPaginationLimit) {
            xoops_load('XoopsPageNav');
            $pagenav = new \XoopsPageNav(
                $friendshipTempRows, $friendshipPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
            );
            $GLOBALS['xoopsTpl']->assign('pagenav', null === $pagenav ? $pagenav->renderNav() : '');
        }
        $GLOBALS['xoopsTpl']->assign('friendshipRows', $friendshipTempRows);
        $friendshipArray = [];
        //    $fields = explode('|', friendship_id:int:11::NOT NULL::primary:friendship_id|friend1_uid:int:11::NOT NULL:::friend1_uid|friend2_uid:int:11::NOT NULL:::friend2_uid|level:int:11::NOT NULL:::level|hot:tinyint:4::NOT NULL:::hot|trust:tinyint:4::NOT NULL:::trust|cool:tinyint:4::NOT NULL:::cool|fan:tinyint:4::NOT NULL:::fan);
        //    $fieldsCount    = count($fields);
        $criteria = new CriteriaCompo();
        //$criteria->setOrder('DESC');
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setLimit($friendshipPaginationLimit);
        $criteria->setStart($start);
        $friendshipCount     = $friendshipHandler->getCount($criteria);
        $friendshipTempArray = $friendshipHandler->getAll($criteria);
        //    for ($i = 0; $i < $fieldsCount; ++$i) {
        if ($friendshipCount > 0) {
            foreach (array_keys($friendshipTempArray) as $i) {
                //        $field = explode(':', $fields[$i]);
                $GLOBALS['xoopsTpl']->assign(
                    'selectorfriendship_id',
                    AM_SUICO_FRIENDSHIP_FRIENDSHIP_ID
                );
                $friendshipArray['friendship_id'] = $friendshipTempArray[$i]->getVar('friendship_id');
                $GLOBALS['xoopsTpl']->assign('selectorfriend1_uid', AM_SUICO_FRIENDSHIP_FRIEND1_UID);
                $friendshipArray['friend1_uid'] = strip_tags(
                    XoopsUser::getUnameFromId($friendshipTempArray[$i]->getVar('friend1_uid'))
                );
                $GLOBALS['xoopsTpl']->assign('selectorfriend2_uid', AM_SUICO_FRIENDSHIP_FRIEND2_UID);
                $friendshipArray['friend2_uid'] = strip_tags(
                    XoopsUser::getUnameFromId($friendshipTempArray[$i]->getVar('friend2_uid'))
                );
                $GLOBALS['xoopsTpl']->assign('selectorlevel', AM_SUICO_FRIENDSHIP_LEVEL);
                $friendshipArray['level'] = $friendshipTempArray[$i]->getVar('level');
                $GLOBALS['xoopsTpl']->assign('selectorhot', AM_SUICO_FRIENDSHIP_HOT);
                $friendshipArray['hot'] = $friendshipTempArray[$i]->getVar('hot');
                $GLOBALS['xoopsTpl']->assign('selectortrust', AM_SUICO_FRIENDSHIP_TRUST);
                $friendshipArray['trust'] = $friendshipTempArray[$i]->getVar('trust');
                $GLOBALS['xoopsTpl']->assign('selectorcool', AM_SUICO_FRIENDSHIP_COOL);
                $friendshipArray['cool'] = $friendshipTempArray[$i]->getVar('cool');
                $GLOBALS['xoopsTpl']->assign('selectorfan', AM_SUICO_FRIENDSHIP_FAN);
                $friendshipArray['fan'] = $friendshipTempArray[$i]->getVar('fan');
                $GLOBALS['xoopsTpl']->assign('selectordate_created', AM_SUICO_FRIENDSHIP_DATE_CREATED);
                $friendshipArray['date_created'] = formatTimestamp($friendshipTempArray[$i]->getVar('date_created'), 's');
                $GLOBALS['xoopsTpl']->assign('selectordate_updated', AM_SUICO_FRIENDSHIP_DATE_UPDATED);
                $friendshipArray['date_updated'] = formatTimestamp($friendshipTempArray[$i]->getVar('date_updated'), 's');
                $friendshipArray['edit_delete']  = "<a href='friendships.php?op=edit&friendship_id=" . $i . "'><img src=" . $pathIcon16 . "/edit.png alt='" . _EDIT . "' title='" . _EDIT . "'></a>
               <a href='friendships.php?op=delete&friendship_id=" . $i . "'><img src=" . $pathIcon16 . "/delete.png alt='" . _DELETE . "' title='" . _DELETE . "'></a>
               <a href='friendships.php?op=clone&friendship_id=" . $i . "'><img src=" . $pathIcon16 . "/editcopy.png alt='" . _CLONE . "' title='" . _CLONE . "'></a>";
                $GLOBALS['xoopsTpl']->append_by_ref('friendshipsArray', $friendshipArray);
                unset($friendshipArray);
            }
            unset($friendshipTempArray);
            // Display Navigation
            if ($friendshipCount > $friendshipPaginationLimit) {
                xoops_load('XoopsPageNav');
                $pagenav = new \XoopsPageNav(
                    $friendshipCount, $friendshipPaginationLimit, $start, 'start', 'op=list' . '&sort=' . $sort . '&order=' . $order . ''
                );
                $GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
            }
            echo $GLOBALS['xoopsTpl']->fetch(
                XOOPS_ROOT_PATH . '/modules/' . $GLOBALS['xoopsModule']->getVar(
                    'dirname'
                ) . '/templates/admin/suico_admin_friendships.tpl'
            );
        }
        break;
}
require __DIR__ . '/admin_footer.php';
