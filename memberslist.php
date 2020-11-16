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
$op = 'form';
//require_once __DIR__ . '/class/suico_controller.php';
$controller = new IndexController($xoopsDB, $xoopsUser);
/**
 * Fetching numbers of groups friends videos pictures etc...
 */
$nbSections                              = $controller->getNumbersSections();
$GLOBALS['xoopsOption']['template_main'] = 'suico_memberslist_datatables.tpl';
require XOOPS_ROOT_PATH . '/header.php';
$iamadmin = $xoopsUserIsAdmin;
$myts     = \MyTextSanitizer::getInstance();
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('level', 0, '>'));
$validsort = ['uname', 'email', 'last_login', 'user_regdate', 'posts'];
$sort      = (!in_array($xoopsModuleConfig['sortmembers'], $validsort)) ? 'uname' : $xoopsModuleConfig['sortmembers'];
$order     = 'ASC';
if (isset($xoopsModuleConfig['membersorder']) && 'DESC' == $xoopsModuleConfig['membersorder']) {
    $order = 'DESC';
}
if ('normal' == $xoopsModuleConfig['memberslisttemplate']) {
    $limit = (!empty($xoopsModuleConfig['membersperpage'])) ? (int)$xoopsModuleConfig['membersperpage'] : 20;
    if (0 === $limit || $limit > 50) {
        $limit = 50;
    }
}
$start = Request::getInt('start', 0, 'POST');
/** @var \XoopsMemberHandler $memberHandler */
$memberHandler = xoops_getHandler('member');
$total         = $memberHandler->getUserCount($criteria);
$xoopsTpl->assign('totalmember', $total);
//Show last member
$result = $GLOBALS['xoopsDB']->query('SELECT uid, uname FROM ' . $GLOBALS['xoopsDB']->prefix('users') . ' WHERE level > 0 ORDER BY uid DESC', 1, 0);
[$latestuid, $latestuser] = $GLOBALS['xoopsDB']->fetchRow($result);
$xoopsTpl->assign('latestmember', " <a href='" . XOOPS_URL . '/modules/suico/index.php?uid=' . $latestuid . "'>" . $latestuser . '</a>');
$xoopsTpl->assign('welcomemessage', $xoopsModuleConfig['welcomemessage']);
$xoopsTpl->assign('lang_search', _MD_SUICO_SEARCH);
$xoopsTpl->assign('lang_results', _MD_SUICO_RESULTS);
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
    if ('normal' == $xoopsModuleConfig['memberslisttemplate']) {
        $criteria->setLimit($limit);
    }
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
    if ('normal' == $xoopsModuleConfig['memberslisttemplate']) {
        $totalpages = ceil($total / $limit);
        if ($totalpages > 1) {
            $hiddenform = "<form name='findnext' action='memberslist.php' method='post'>";
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
$xoopsTpl->assign('lang_askusertobefriend', _MD_SUICO_ASKBEFRIEND);
$xoopsTpl->assign('lang_addfriend', _MD_SUICO_ADDFRIEND);
$xoopsTpl->assign('lang_friendshippending', _MD_SUICO_FRIENDREQUEST_PENDING);
$xoopsTpl->assign('lang_cancelfriendrequest', _MD_SUICO_FRIENDREQUEST_CANCEL);
if (isset($_POST['addfriend'])) {
    $newFriendrequest = $friendrequestFactory->create(true);
    $newFriendrequest->setVar('friendrequester_uid', $controller->uidOwner);
    $newFriendrequest->setVar('friendrequestto_uid', 5, 0);
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
$xoopsTpl->assign('lang_mysection', _MD_SUICO_MEMBERSLIST);
$xoopsTpl->assign('section_name', _MD_SUICO_MEMBERSLIST);
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
