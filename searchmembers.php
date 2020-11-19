<?php

declare(strict_types=1);
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <https://xoops.org>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
use Xmf\Request;
use XoopsModules\Suico\{
    FriendrequestHandler,
    IndexController
};

require __DIR__ . '/header.php';
$op = Request::getCmd('op', 'form', 'POST');
//require_once __DIR__ . '/class/suico_controller.php';
$controller = new IndexController($xoopsDB, $xoopsUser);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections = $controller->getNumbersSections();
if ('form' === $op) {
    $GLOBALS['xoopsOption']['template_main'] = 'suico_searchform.tpl';
    require XOOPS_ROOT_PATH . '/header.php';
    /** @var \XoopsMemberHandler $memberHandler */
    $memberHandler = xoops_getHandler('member');
    $total         = $memberHandler->getUserCount(new Criteria('level', 0, '>'));
    require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $uname_text  = new \XoopsFormText('', 'user_uname', 30, 60);
    $uname_match = new \XoopsFormSelectMatchOption('', 'user_uname_match');
    $uname_tray  = new \XoopsFormElementTray(_MD_SUICO_UNAME, '&nbsp;');
    $uname_tray->addElement($uname_match);
    $uname_tray->addElement($uname_text);
    $name_text  = new \XoopsFormText('', 'user_name', 30, 60);
    $name_match = new \XoopsFormSelectMatchOption('', 'user_name_match');
    $name_tray  = new \XoopsFormElementTray(_MD_SUICO_REALNAME, '&nbsp;');
    $name_tray->addElement($name_match);
    $name_tray->addElement($name_text);
    $email_text  = new \XoopsFormText('', 'user_email', 30, 60);
    $email_match = new \XoopsFormSelectMatchOption('', 'user_email_match');
    $email_tray  = new \XoopsFormElementTray(_MD_SUICO_EMAIL, '&nbsp;');
    $email_tray->addElement($email_match);
    $email_tray->addElement($email_text);
    $url_text        = new \XoopsFormText(_MD_SUICO_URL_CONTAINS, 'user_url', 30, 100);
    $location_text   = new \XoopsFormText(_MD_SUICO_LOCATION_CONTAINS, 'user_from', 30, 100);
    $occupation_text = new \XoopsFormText(_MD_SUICO_OCCUPATION_CONTAINS, 'user_occ', 30, 100);
    $interest_text   = new \XoopsFormText(_MD_SUICO_INTEREST_CONTAINS, 'user_intrest', 30, 100);
    $extrainfo_text  = new \XoopsFormText(_MD_SUICO_EXTRAINFO_CONTAINS, 'bio', 30, 100);
    $signature_text  = new \XoopsFormText(_MD_SUICO_SIGNATURE_CONTAINS, 'user_sig', 30, 100);
    $lastlog_more    = new \XoopsFormText(
        _MD_SUICO_LASTLOGMORE, 'user_lastlog_more', 10, 5
    );
    $lastlog_less    = new \XoopsFormText(_MD_SUICO_LASTLOGLESS, 'user_lastlog_less', 10, 5);
    $reg_more        = new \XoopsFormText(_MD_SUICO_REGMORE, 'user_reg_more', 10, 5);
    $reg_less        = new \XoopsFormText(_MD_SUICO_REGLESS, 'user_reg_less', 10, 5);
    $posts_more      = new \XoopsFormText(_MD_SUICO_POSTSMORE, 'user_posts_more', 10, 5);
    $posts_less      = new \XoopsFormText(_MD_SUICO_POSTSLESS, 'user_posts_less', 10, 5);
    $sort_select     = new \XoopsFormSelect(_MD_SUICO_SORT, 'user_sort');
    $sort_select->addOptionArray(
        [
            'uname'        => _MD_SUICO_UNAME,
            'email'        => _MD_SUICO_EMAIL,
            'last_login'   => _MD_SUICO_LASTLOGIN,
            'user_regdate' => _MD_SUICO_REGDATE,
            'posts'        => _MD_SUICO_POSTS,
        ]
    );
    $order_select = new \XoopsFormSelect(_MD_SUICO_ORDER, 'user_order');
    $order_select->addOptionArray(
        [
            'ASC'  => _MD_SUICO_ASC,
            'DESC' => _MD_SUICO_DESC,
        ]
    );
    $limit_text    = new \XoopsFormText(_MD_SUICO_LIMIT, 'limit', 6, 2);
    $op_hidden     = new \XoopsFormHidden('op', 'submit');
    $submit_button = new \XoopsFormButton('', 'user_submit', _SUBMIT, 'submit');
    $form          = new \XoopsThemeForm('', 'searchform', 'searchmembers.php');
    $form->addElement($uname_tray);
    $form->addElement($name_tray);
    $form->addElement($email_tray);
    if (1 == $xoopsModuleConfig['displayurl']) {
        $form->addElement($url_text);
    }
    if (1 == $xoopsModuleConfig['displayfrom']) {
        $form->addElement($location_text);
    }
    if (1 == $xoopsModuleConfig['displayoccupation']) {
        $form->addElement($occupation_text);
    }
    if (1 == $xoopsModuleConfig['displayinterest']) {
        $form->addElement($interest_text);
    }
    if (1 == $xoopsModuleConfig['displayextrainfo']) {
        $form->addElement($extrainfo_text);
    }
    if (1 == $xoopsModuleConfig['displaysignature']) {
        $form->addElement($signature_text);
    }
    if (1 == $xoopsModuleConfig['displaylastlogin']) {
        $form->addElement($lastlog_more);
        $form->addElement($lastlog_less);
    }
    if (1 == $xoopsModuleConfig['displayregdate']) {
        $form->addElement($reg_more);
        $form->addElement($reg_less);
    }
    if (1 == $xoopsModuleConfig['displayposts']) {
        $form->addElement($posts_more);
        $form->addElement($posts_less);
    }
    $form->addElement($sort_select);
    $form->addElement($order_select);
    $form->addElement($limit_text);
    $form->addElement($op_hidden);
    $form->addElement($submit_button);
    $form->assign($xoopsTpl);
    $xoopsTpl->assign('lang_search', _MD_SUICO_SEARCH);
    $xoopsTpl->assign(
        'lang_totalusers',
        sprintf(_MD_SUICO_TOTALUSERS, '<span style="color:#ff0000;">' . $total . '</span>')
    );
    $xoopsTpl->assign('totalmember', $total);
}
if ('submit' === $op) {
    $GLOBALS['xoopsOption']['template_main'] = 'suico_searchresults.tpl';
    require XOOPS_ROOT_PATH . '/header.php';
    $iamadmin = $xoopsUserIsAdmin;
    $myts     = \MyTextSanitizer::getInstance();
    $criteria = new CriteriaCompo();
    if (!empty($_POST['user_uname'])) {
        $match = !empty($_POST['user_uname_match']) ? Request::getInt('user_uname_match', 0, 'POST') : XOOPS_MATCH_START;
        switch ($match) {
            case XOOPS_MATCH_START:
                $criteria->add(new Criteria('uname', Request::getString('user_uname', '', 'POST') . '%', 'LIKE'));
                break;
            case XOOPS_MATCH_END:
                $criteria->add(new Criteria('uname', '%' . Request::getString('user_uname', '', 'POST'), 'LIKE'));
                break;
            case XOOPS_MATCH_EQUAL:
                $criteria->add(new Criteria('uname', Request::getString('user_uname', '', 'POST')));
                break;
            case XOOPS_MATCH_CONTAIN:
                $criteria->add(
                    new Criteria('uname', '%' . Request::getString('user_uname', '', 'POST') . '%', 'LIKE')
                );
                break;
        }
    }
    if (!empty($_POST['user_name'])) {
        $match = !empty($_POST['user_name_match']) ? Request::getInt('user_name_match', 0, 'POST') : XOOPS_MATCH_START;
        switch ($match) {
            case XOOPS_MATCH_START:
                $criteria->add(new Criteria('name', Request::getString('user_uname', '', 'POST') . '%', 'LIKE'));
                break;
            case XOOPS_MATCH_END:
                $criteria->add(
                    new Criteria('name', '%' . Request::getString('user_uname', '', 'POST') . '%', 'LIKE')
                );
                break;
            case XOOPS_MATCH_EQUAL:
                $criteria->add(new Criteria('name', Request::getString('user_uname', '', 'POST')));
                break;
            case XOOPS_MATCH_CONTAIN:
                $criteria->add(
                    new Criteria('name', '%' . Request::getString('user_uname', '', 'POST') . '%', 'LIKE')
                );
                break;
        }
    }
    if (!empty($_POST['user_email'])) {
        $match = !empty($_POST['user_email_match']) ? Request::getInt('user_email_match', 0, 'POST') : XOOPS_MATCH_START;
        switch ($match) {
            case XOOPS_MATCH_START:
                $criteria->add(new Criteria('email', Request::getString('user_email', '', 'POST') . '%', 'LIKE'));
                break;
            case XOOPS_MATCH_END:
                $criteria->add(new Criteria('email', '%' . Request::getString('user_email', '', 'POST'), 'LIKE'));
                break;
            case XOOPS_MATCH_EQUAL:
                $criteria->add(new Criteria('email', Request::getString('user_email', '', 'POST')));
                break;
            case XOOPS_MATCH_CONTAIN:
                $criteria->add(
                    new Criteria('email', '%' . Request::getString('user_email', '', 'POST') . '%', 'LIKE')
                );
                break;
        }
        if (!$iamadmin) {
            $criteria->add(new Criteria('user_viewemail', 1));
        }
    }
    if (!empty($_POST['user_url'])) {
        //        $url = Request::getUrl('user_url', '', 'POST');
        $criteria->add(new Criteria('url', Request::getUrl('user_url', '', 'POST') . '%', 'LIKE'));
    }
    if (!empty($_POST['user_from'])) {
        $criteria->add(new Criteria('user_from', '%' . Request::getString('user_from', '', 'POST') . '%', 'LIKE'));
    }
    if (!empty($_POST['user_intrest'])) {
        $criteria->add(
            new Criteria('user_intrest', '%' . Request::getString('user_intrest', '', 'POST') . '%', 'LIKE')
        );
    }
    if (!empty($_POST['user_occ'])) {
        $criteria->add(new Criteria('user_occ', '%' . Request::getString('user_occ', '', 'POST') . '%', 'LIKE'));
    }
    if (!empty($_POST['bio'])) {
        $criteria->add(new Criteria('bio', '%' . Request::getString('bio', '', 'POST') . '%', 'LIKE'));
    }
    if (!empty($_POST['user_sig'])) {
        $criteria->add(new Criteria('user_sig', '%' . Request::getString('user_sig', '', 'POST') . '%', 'LIKE'));
    }
    if (!empty($_POST['user_lastlog_more']) && is_numeric($_POST['user_lastlog_more'])) {
        $f_user_lastlog_more = Request::getInt('user_lastlog_more', 0, 'POST');
        $time                = time() - (60 * 60 * 24 * $f_user_lastlog_more);
        if ($time > 0) {
            $criteria->add(new Criteria('last_login', $time, '<'));
        }
    }
    if (!empty($_POST['user_lastlog_less']) && is_numeric($_POST['user_lastlog_less'])) {
        $f_user_lastlog_less = Request::getInt('user_lastlog_less', 0, 'POST');
        $time                = time() - (60 * 60 * 24 * $f_user_lastlog_less);
        if ($time > 0) {
            $criteria->add(new Criteria('last_login', $time, '>'));
        }
    }
    if (!empty($_POST['user_reg_more']) && is_numeric($_POST['user_reg_more'])) {
        $f_user_reg_more = Request::getInt('user_reg_more', 0, 'POST');
        $time            = time() - (60 * 60 * 24 * $f_user_reg_more);
        if ($time > 0) {
            $criteria->add(new Criteria('user_regdate', $time, '<'));
        }
    }
    if (!empty($_POST['user_reg_less']) && is_numeric($_POST['user_reg_less'])) {
        $f_user_reg_less = Request::getInt('user_reg_less', 0, 'POST');
        $time            = time() - (60 * 60 * 24 * $f_user_reg_less);
        if ($time > 0) {
            $criteria->add(new Criteria('user_regdate', $time, '>'));
        }
    }
    if (isset($_POST['user_posts_more']) && is_numeric($_POST['user_posts_more'])) {
        $criteria->add(new Criteria('posts', Request::getInt('user_posts_more', 0, 'POST'), '>'));
    }
    if (!empty($_POST['user_posts_less']) && is_numeric($_POST['user_posts_less'])) {
        $criteria->add(new Criteria('posts', Request::getInt('user_posts_less', 0, 'POST'), '<'));
    }
    $criteria->add(new Criteria('level', 0, '>'));
    $validsort = ['uname', 'email', 'last_login', 'user_regdate', 'posts'];
    $sort      = !in_array(Request::getString('user_sort', 'uname', 'POST'), $validsort, true);
    $order     = 'ASC';
    if (isset($_POST['user_order']) && 'DESC' === Request::getString('user_order', '', 'POST')) {
        $order = 'DESC';
    }
    $limit = Request::getInt('limit', 20, 'POST');
    if (0 === $limit || $limit > 50) {
        $limit = 50;
    }
    $start         = Request::getInt('start', 0, 'POST');
    $memberHandler = xoops_getHandler('member');
    $total         = $memberHandler->getUserCount($criteria);
    $xoopsTpl->assign('lang_search', _MD_SUICO_SEARCH);
    $xoopsTpl->assign('lang_results', _MD_SUICO_RESULTS);
    $xoopsTpl->assign('total_found', $total);
    if (0 === $total) {
        $xoopsTpl->assign('lang_nonefound', _MD_SUICO_NOFOUND);
    } elseif ($start < $total) {
        $xoopsTpl->assign('lang_username', _MD_SUICO_UNAME);
        $xoopsTpl->assign('lang_realname', _MD_SUICO_REALNAME);
        $xoopsTpl->assign('lang_avatar', _MD_SUICO_AVATAR);
        $xoopsTpl->assign('lang_email', _MD_SUICO_EMAIL);
        $xoopsTpl->assign('lang_privmsg', _MD_SUICO_PM);
        $xoopsTpl->assign('lang_regdate', _MD_SUICO_REGDATE);
        $xoopsTpl->assign('lang_lastlogin', _MD_SUICO_LASTLOGIN);
        $xoopsTpl->assign('lang_posts', _MD_SUICO_POSTS);
        $xoopsTpl->assign('lang_url', _MD_SUICO_URL);
        $xoopsTpl->assign('lang_admin', _MD_SUICO_ADMIN);
        if ($iamadmin) {
            $xoopsTpl->assign('is_admin', true);
        }
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $foundusers = $memberHandler->getUsers($criteria, true);
        foreach (array_keys($foundusers) as $j) {
            $userdata['avatar']   = $foundusers[$j]->getVar('user_avatar');
            $userdata['realname'] = $foundusers[$j]->getVar('name');
            $userdata['name']     = $foundusers[$j]->getVar('uname');
            $userdata['id']       = $foundusers[$j]->getVar('uid');
            $userdata['uid']      = $foundusers[$j]->getVar('uid');
            $criteria_friends     = new Criteria('friend1_uid', $controller->uidOwner);
            $criteriaIsfriend     = new CriteriaCompo(new Criteria('friend2_uid', $userdata['uid']));
            $criteriaIsfriend->add($criteria_friends);
            $controller->isFriend   = $controller->friendshipsFactory->getCount($criteriaIsfriend);
            $userdata['isFriend']   = $controller->isFriend;
            $friendrequestFactory   = new FriendrequestHandler($xoopsDB);
            $criteria_selfrequest   = new Criteria('friendrequester_uid', $controller->uidOwner);
            $criteria_isselfrequest = new CriteriaCompo(new Criteria('friendrequestto_uid', $userdata['uid']));
            $criteria_isselfrequest->add($criteria_selfrequest);
            $controller->isSelfRequest     = $friendrequestFactory->getCount($criteria_isselfrequest);
            $userdata['selffriendrequest'] = $controller->isSelfRequest;
            if ($controller->isSelfRequest > 0) {
                $xoopsTpl->assign('self_uid', $controller->uidOwner);
            }
            $xoopsTpl->assign('lang_myfriend', _MD_SUICO_MYFRIEND);
            $xoopsTpl->assign('lang_friendrequestsent', _MD_SUICO_FRIENDREQUEST_SENT);
            $xoopsTpl->assign('lang_friendshipstatus', _MD_SUICO_FRIENDSHIP_STATUS);
            $criteria_otherrequest   = new Criteria('friendrequester_uid', $userdata['uid']);
            $criteria_isotherrequest = new CriteriaCompo(new Criteria('friendrequestto_uid', $controller->uidOwner));
            $criteria_isotherrequest->add($criteria_otherrequest);
            $controller->isOtherRequest     = $friendrequestFactory->getCount($criteria_isotherrequest);
            $userdata['otherfriendrequest'] = $controller->isOtherRequest;
            if ($controller->isOtherRequest > 0) {
                $xoopsTpl->assign('other_uid', $userdata['uid']);
            }
            if (1 === $foundusers[$j]->getVar('user_viewemail') || $iamadmin) {
                $userdata['email']        = "<a href='mailto:" . $foundusers[$j]->getVar(
                        'email'
                    ) . "'><img src='" . XOOPS_URL . "/images/icons/email.gif' border='0' alt='" . sprintf(
                                                _SENDEMAILTO,
                                                $foundusers[$j]->getVar('uname', 'E')
                                            ) . "'></a>";
                $userdata['emailaddress'] = $foundusers[$j]->getVar('email');
            } else {
                $userdata['email'] = '&nbsp;';
            }
            if ($xoopsUser) {
                $userdata['pmlink'] = "<a href='javascript:openWithSelfMain(\"" . XOOPS_URL . '/pmlite.php?send2=1&amp;to_userid=' . $foundusers[$j]->getVar(
                        'uid'
                    ) . "\",\"pmlite\",450,370);'><img src='" . XOOPS_URL . "/images/icons/pm.gif' border='0' alt='" . sprintf(
                                          _SENDPMTO,
                                          $foundusers[$j]->getVar(
                                              'uname',
                                              'E'
                                          )
                                      ) . "'></a>";
                $userdata['pm']     = $foundusers[$j]->getVar('uid');
            } else {
                $userdata['pmlink'] = '&nbsp;';
            }
            if ('' !== $foundusers[$j]->getVar('url', 'E')) {
                $userdata['website'] = "<a href='" . $foundusers[$j]->getVar(
                        'url',
                        'E'
                    ) . "' target='_blank'><img src='" . XOOPS_URL . "/images/icons/www.gif' border='0' alt='" . _VISITWEBSITE . "'></a>";
            } else {
                $userdata['website'] = '&nbsp;';
            }
            $userdata['url']          = $foundusers[$j]->getVar('url', 'e');
            $userdata['registerdate'] = formatTimestamp($foundusers[$j]->getVar('user_regdate'), 's');
            if (0 !== $foundusers[$j]->getVar('last_login')) {
                $userdata['lastlogin'] = formatTimestamp($foundusers[$j]->getVar('last_login'), 'm');
            } else {
                $userdata['lastlogin'] = _MD_SUICO_NEVERLOGIN;
            }
            $userdata['posts'] = $foundusers[$j]->getVar('posts');
            if ($iamadmin) {
                $userdata['adminlink'] = "<a href='" . XOOPS_URL . '/modules/system/admin.php?fct=users&amp;uid=' . (int)$foundusers[$j]->getVar(
                        'uid'
                    ) . "&amp;op=modifyUser'>" . _EDIT . "</a>  <a href='" . XOOPS_URL . '/modules/system/admin.php?fct=users&amp;op=delUser&amp;uid=' . (int)$foundusers[$j]->getVar(
                        'uid'
                    ) . "'>" . _DELETE . '</a>';
            }
            $userdata['location']     = $foundusers[$j]->getVar('user_from');
            $userdata['occupation']   = $foundusers[$j]->getVar('user_occ');
            $userdata['interest']     = $foundusers[$j]->getVar('user_intrest');
            $userdata['extrainfo']    = $foundusers[$j]->getVar('bio');
            $userdata['signature']    = $foundusers[$j]->getVar('user_sig');
            $userdata['onlinestatus'] = $foundusers[$j]->isOnline();
            $userrank                 = $foundusers[$j]->rank();
            if ($userrank['image']) {
                $userdata['rankimage'] = '<img src="' . XOOPS_UPLOAD_URL . '/' . $userrank['image'] . '" alt="">';
            }
            $userdata['ranktitle'] = $userrank['title'];
            $uid                   = $userdata['id'];
            $groups                = $memberHandler->getGroupsByUser($uid, true);
            $usergroups            = [];
            foreach ($groups as $group) {
                $usergroups[] = $group->getVar('name');
            }
            $userdata['groups'] = implode(', ', $usergroups);
            $xoopsTpl->append('users', $userdata);
        }
        $totalpages = ceil($total / $limit);
        if ($totalpages > 1) {
            $hiddenform = "<form name='findnext' action='searchmembers.php' method='post'>";
            foreach ($_POST as $k => $v) {
                $hiddenform .= "<input type='hidden' name='" . $myts->htmlSpecialChars($k) . "' value='" . $myts->htmlSpecialChars($v) . "'>\n";
            }
            if (!isset($_POST['limit'])) {
                $hiddenform .= "<input type='hidden' name='limit' value='" . $limit . "'>\n";
            }
            if (!isset($_POST['start'])) {
                $hiddenform .= "<input type='hidden' name='start' value='" . $start . "'>\n";
            }
            $prev = $start - $limit;
            if ($start - $limit >= 0) {
                $hiddenform .= "<a href='#0' onclick='document.findnext.start.value=" . $prev . ";document.findnext.submit();'>" . _MD_SUICO_PREVIOUS . "</a>&nbsp;\n";
            }
            $counter     = 1;
            $currentpage = ($start + $limit) / $limit;
            while ($counter <= $totalpages) {
                if ($counter === $currentpage) {
                    $hiddenform .= '<b>' . $counter . '</b> ';
                } elseif (($counter > $currentpage - 4 && $counter < $currentpage + 4) || 1 === $counter || $counter === $totalpages) {
                    if ($counter === $totalpages && $currentpage < $totalpages - 4) {
                        $hiddenform .= '... ';
                    }
                    $hiddenform .= "<a href='#" . $counter . "' onclick='document.findnext.start.value=" . ($counter - 1) * $limit . ";document.findnext.submit();'>" . $counter . '</a> ';
                    if (1 === $counter && $currentpage > 5) {
                        $hiddenform .= '... ';
                    }
                }
                $counter++;
            }
            $next = $start + $limit;
            if ($total > $next) {
                $hiddenform .= "&nbsp;<a href='#" . $total . "' onclick='document.findnext.start.value=" . $next . ";document.findnext.submit();'>" . _MD_SUICO_NEXT . "</a>\n";
            }
            $hiddenform .= '</form>';
            $xoopsTpl->assign('pagenav', $hiddenform);
            $xoopsTpl->assign('lang_numfound', sprintf(_MD_SUICO_USER_SFOUND, $total));
        }
    }
}
//requests to become friend
$xoopsTpl->assign('lang_askusertobefriend', _MD_SUICO_ASKBEFRIEND);
$xoopsTpl->assign('lang_addfriend', _MD_SUICO_ADDFRIEND);
$xoopsTpl->assign('lang_friendshippending', _MD_SUICO_FRIENDREQUEST_PENDING);
$xoopsTpl->assign('lang_cancelfriendrequest', _MD_SUICO_FRIENDREQUEST_CANCEL);
if (isset($_POST['addfriend'])) {
    $newFriendrequest = $friendrequestFactory->create(true);
    $newFriendrequest->setVar('friendrequester_uid', $controller->uidOwner);
    $newFriendrequest->setVar('friendrequestto_uid', 5, 0, 'POST');
    $friendrequestFactory->insert2($newFriendrequest);
    redirect_header(
        XOOPS_URL . '/modules/suico/index.php?uid=' . Request::getInt('friendrequestfrom_uid', 0, 'POST'),
        3,
        _MD_SUICO_FRIENDREQUEST_FROM
    );
}
$memberHandler = xoops_getHandler('member');
$thisUser      = $memberHandler->getUser($controller->uidOwner);
$myts          = \MyTextSanitizer::getInstance();
//navbar
$xoopsTpl->assign('lang_mysection', _MD_SUICO_SEARCH);
$xoopsTpl->assign('section_name', _MD_SUICO_SEARCH);
// temporary solution for profile module integration
if (xoops_isActiveModule('profile')) {
    $profileHandler = $helper->getHandler('Profile');
    $uid            = $controller->uidOwner;
    if ($uid <= 0) {
        if (is_object($xoopsUser)) {
            $profile = $profileHandler->get($uid);
        } else {
            header('location: ' . XOOPS_URL);
            exit();
        }
    } else {
        $profile = $profileHandler->get($uid);
    }
}
require __DIR__ . '/footer.php';
require_once XOOPS_ROOT_PATH . '/footer.php';
