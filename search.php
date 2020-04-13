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

require __DIR__ . '/header.php';

$myts   = MyTextSanitizer::getInstance();
$op     = isset($_REQUEST['op']) ? htmlspecialchars($_REQUEST['op'], ENT_QUOTES | ENT_HTML5) : 'search';
$groups = $xoopsUser ? $xoopsUser->getGroups() : [XOOPS_GROUP_ANONYMOUS];
switch ($op) {
    default:
    case 'search':
        $xoopsOption['cache_group']              = implode('', $groups);
        $GLOBALS['xoopsOption']['template_main'] = 'yogurt_search.tpl';
        require XOOPS_ROOT_PATH . '/header.php';

        // Dynamic fields
        $profileHandler = xoops_getModuleHandler('profile');
        // Get fields
        $fields = $profileHandler->loadFields();
        // Get ids of fields that can be searched
        $gpermHandler      = xoops_getHandler('groupperm');
        $searchable_fields = $gpermHandler->getItemIds('smartprofile_search', $groups, $xoopsModule->getVar('mid'));

        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        $searchform = new XoopsThemeForm('', 'searchform', 'search.php', 'post');

        $name_tray = new XoopsFormElementTray(_PROFILE_MA_DISPLAYNAME);
        $name_tray->addElement(new XoopsFormSelectMatchOption('', 'uname_match'));
        $name_tray->addElement(new XoopsFormText('', 'uname', 35, 255));
        $searchform->addElement($name_tray);
        $sortby_arr['uname'] = _PROFILE_MA_DISPLAYNAME;

        $email_tray = new XoopsFormElementTray(_PROFILE_MA_EMAIL);
        $email_tray->addElement(new XoopsFormSelectMatchOption('', 'email_match'));
        $email_tray->addElement(new XoopsFormText('', 'email', 35, 255));
        $searchform->addElement($email_tray);
        $sortby_arr['email'] = _PROFILE_MA_EMAIL;

        $searchable_types = [
            'textbox',
            'select',
            'radio',
            'yesno',
            'date',
            'datetime',
            'timezone',
            'language',
        ];
        foreach (array_keys($fields) as $i) {
            if (in_array($fields[$i]->getVar('fieldid'), $searchable_fields, true)
                && in_array(
                    $fields[$i]->getVar('field_type'),
                    $searchable_types,
                    true
                )) {
                $sortby_arr[$fields[$i]->getVar('fieldid')] = $fields[$i]->getVar('field_title');
                switch ($fields[$i]->getVar('field_type')) {
                    case 'textbox':
                        if (XOBJ_DTYPE_INT === $fields[$i]->getVar('field_valuetype')) {
                            $searchform->addElement(
                                new XoopsFormText(
                                    sprintf(
                                        _PROFILE_MA_LARGERTHAN,
                                        $fields[$i]->getVar('field_title')
                                    ), $fields[$i]->getVar(
                                         'field_name'
                                     ) . '_larger', 35, 35
                                )
                            );
                            $searchform->addElement(
                                new XoopsFormText(
                                    sprintf(
                                        _PROFILE_MA_SMALLERTHAN,
                                        $fields[$i]->getVar('field_title')
                                    ), $fields[$i]->getVar(
                                         'field_name'
                                     ) . '_smaller', 35, 35
                                )
                            );
                        } else {
                            $tray = new XoopsFormElementTray($fields[$i]->getVar('field_title'));
                            $tray->addElement(
                                new XoopsFormSelectMatchOption('', $fields[$i]->getVar('field_name') . '_match')
                            );
                            $tray->addElement(
                                new XoopsFormText(
                                    '', $fields[$i]->getVar('field_name'), 35, $fields[$i]->getVar(
                                    'field_maxlength'
                                )
                                )
                            );
                            $searchform->addElement($tray);
                            unset($tray);
                        }
                        break;
                    case 'radio':
                    case 'select':
                        $size    = count($fields[$i]->getVar('field_options')) > 10 ? 10 : count(
                            $fields[$i]->getVar('field_options')
                        );
                        $element = new XoopsFormSelect(
                            $fields[$i]->getVar('field_title'), $fields[$i]->getVar(
                            'field_name'
                        ), null, $size, true
                        );
                        $options = $fields[$i]->getVar('field_options');
                        asort($options);
                        $element->addOptionArray($options);
                        $searchform->addElement($element);
                        unset($element);
                        break;
                    case 'yesno':
                        $element = new XoopsFormSelect(
                            $fields[$i]->getVar('field_title'), $fields[$i]->getVar(
                            'field_name'
                        ), null, 2, true
                        );
                        $element->addOption(1, _YES);
                        $element->addOption(0, _NO);
                        $searchform->addElement($element);
                        unset($element);
                        break;
                    case 'date':
                    case 'datetime':
                        $searchform->addElement(
                            new XoopsFormTextDateSelect(
                                sprintf(
                                    _PROFILE_MA_LATERTHAN,
                                    $fields[$i]->getVar('field_title')
                                ), $fields[$i]->getVar(
                                     'field_name'
                                 ) . '_larger', 15, 0
                            )
                        );
                        $searchform->addElement(
                            new XoopsFormTextDateSelect(
                                sprintf(
                                    _PROFILE_MA_EARLIERTHAN,
                                    $fields[$i]->getVar('field_title')
                                ), $fields[$i]->getVar(
                                     'field_name'
                                 ) . '_smaller', 15, time()
                            )
                        );
                        break;
                    //                    case "datetime":
                    //                        $searchform->addElement(new XoopsFormDateTime(sprintf(_PROFILE_MA_LATERTHAN, $fields[$i]->getVar('field_title')), $fields[$i]->getVar('field_name')."_larger", 15, 1));
                    //                        $searchform->addElement(new XoopsFormDateTime(sprintf(_PROFILE_MA_EARLIERTHAN, $fields[$i]->getVar('field_title')), $fields[$i]->getVar('field_name')."_smaller", 15, 0));
                    //                        break;

                    case 'timezone':
                        $element = new XoopsFormSelect(
                            $fields[$i]->getVar('field_title'), $fields[$i]->getVar(
                            'field_name'
                        ), null, 6, true
                        );
                        require_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
                        $element->addOptionArray(XoopsLists::getTimeZoneList());
                        $searchform->addElement($element);
                        unset($element);
                        break;
                    case 'language':
                        $element = new XoopsFormSelectLang(
                            $fields[$i]->getVar('field_title'), $fields[$i]->getVar(
                            'field_name'
                        ), null, 6
                        );
                        $searchform->addElement($element);
                        unset($element);
                        break;
                }
            }
        }
        asort($sortby_arr);
        $sortby_select = new XoopsFormSelect(_PROFILE_MA_SORTBY, 'sortby');
        $sortby_select->addOptionArray($sortby_arr);
        $searchform->addElement($sortby_select);

        $order_select = new XoopsFormRadio(_PROFILE_MA_ORDER, 'order', 0);
        $order_select->addOption(0, _ASCENDING);
        $order_select->addOption(1, _DESCENDING);
        $searchform->addElement($order_select);

        $limit_text = new XoopsFormText(_PROFILE_MA_PERPAGE, 'limit', 15, 10);
        $searchform->addElement($limit_text);
        $searchform->addElement(new XoopsFormHidden('op', 'results'));

        $searchform->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        $searchform->assign($xoopsTpl);
        break;
    case 'results':
        $GLOBALS['xoopsOption']['template_main'] = 'smartprofile_results.tpl';
        require_once XOOPS_ROOT_PATH . '/header.php';

        $memberHandler = xoops_getHandler('member');
        // Dynamic fields
        $profileHandler = xoops_getModuleHandler('profile');
        // Get fields
        $fields = $profileHandler->loadFields();
        // Get ids of fields that can be searched
        $gpermHandler      = xoops_getHandler('groupperm');
        $searchable_fields = $gpermHandler->getItemIds('smartprofile_search', $groups, $xoopsModule->getVar('mid'));
        $searchvars        = [];

        $criteria = new CriteriaCompo(new Criteria('level', 0, '>'));
        if (isset($_REQUEST['uname']) && '' !== $_REQUEST['uname']) {
            $string = $myts->addSlashes(trim($_REQUEST['uname']));
            switch ($_REQUEST['uname_match']) {
                case XOOPS_MATCH_START:
                    $string .= '%';
                    break;
                case XOOPS_MATCH_END:
                    $string = '%' . $string;
                    break;
                case XOOPS_MATCH_CONTAIN:
                    $string = '%' . $string . '%';
                    break;
            }
            $criteria->add(new Criteria('uname', $string, 'LIKE'));
            $searchvars[] = 'uname';
        }
        if (isset($_REQUEST['email']) && '' !== $_REQUEST['email']) {
            $string = $myts->addSlashes(trim($_REQUEST['email']));
            switch ($_REQUEST['email_match']) {
                case XOOPS_MATCH_START:
                    $string .= '%';
                    break;
                case XOOPS_MATCH_END:
                    $string = '%' . $string;
                    break;
                case XOOPS_MATCH_CONTAIN:
                    $string = '%' . $string . '%';
                    break;
            }
            $searchvars[] = 'email';
            $criteria->add(new Criteria('email', $string, 'LIKE'));
            $criteria->add(new Criteria('user_viewemail', 1));
        }
        $searchable_types = [
            'textbox',
            'select',
            'radio',
            'yesno',
            'date',
            'datetime',
            'timezone',
            'language',
        ];

        foreach (array_keys($fields) as $i) {
            if (in_array($fields[$i]->getVar('fieldid'), $searchable_fields, true)
                && in_array(
                    $fields[$i]->getVar('field_type'),
                    $searchable_types,
                    true
                )) {
                $fieldname = $fields[$i]->getVar('field_name');
                if (in_array($fields[$i]->getVar('field_type'), ['select', 'radio'], true)) {
                    if (isset($_REQUEST[$fieldname]) && $_REQUEST[$fieldname]) {
                        //If field value is sent through request and is not an empty value
                        switch ($fields[$i]->getVar(
                            'field_valuetype'
                        )) {
                            case XOBJ_DTYPE_OTHER:
                            case XOBJ_DTYPE_INT:
                                $value        = array_map('intval', $_REQUEST[$fieldname]);
                                $searchvars[] = $fieldname;
                                $criteria->add(new Criteria($fieldname, '(' . implode(',', $value) . ')', 'IN'));
                                break;
                            case XOBJ_DTYPE_URL:
                            case XOBJ_DTYPE_TXTBOX:
                            case XOBJ_DTYPE_TXTAREA:
                                $value        = array_map([$xoopsDB, 'quoteString'], $_REQUEST[$fieldname]);
                                $searchvars[] = $fieldname;
                                $criteria->add(new Criteria($fieldname, '(' . implode(',', $value) . ')', 'IN'));
                                break;
                        }
                    }
                } else {
                    switch ($fields[$i]->getVar('field_valuetype')) {
                        case XOBJ_DTYPE_OTHER:
                        case XOBJ_DTYPE_INT:
                            switch ($fields[$i]->getVar('field_type')) {
                                case 'date':
                                case 'datetime':
                                    $value = $_REQUEST[$fieldname . '_larger'];
                                    if (!($value = strtotime($_REQUEST[$fieldname . '_larger']))) {
                                        $value = (int)$_REQUEST[$fieldname . '_larger'];
                                    }
                                    if ($value > 0) {
                                        $search_url[] = $fieldname . '_larger=' . $value;
                                        $searchvars[] = $fieldname;
                                        $criteria->add(new Criteria($fieldname, $value, '>='));
                                    }

                                    $value = $_REQUEST[$fieldname . '_smaller'];
                                    if (!($value = strtotime($_REQUEST[$fieldname . '_smaller']))) {
                                        $value = (int)$_REQUEST[$fieldname . '_smaller'];
                                    }
                                    if ($value > 0) {
                                        $search_url[] = $fieldname . '_smaller=' . $value;
                                        $searchvars[] = $fieldname;
                                        $criteria->add(new Criteria($fieldname, $value, '<='));
                                    }
                                    break;
                                //                                case "datetime":
                                //                                    $value = $_REQUEST[$fieldname."_larger"]['date'];
                                //                                    if (intval($value) < 0) { //intval() of a date string is -1
                                //                                        $value = strtotime($_REQUEST[$fieldname."_larger"]['date']);
                                //                                    }
                                //                                    else {
                                //                                        $value = intval($_REQUEST[$fieldname."_larger"]['date']);
                                //                                    }
                                //                                    $search_url[] = $fieldname."_larger=".$value;
                                //                                    $searchvars[] = $fieldname;
                                //                                    $criteria->add(new Criteria($fieldname, $value, ">="));
                                //
                                //                                    $value = $_REQUEST[$fieldname."_smaller"]['date'];
                                //                                    if (intval($value) < 0) { //intval() of a date string is -1
                                //                                        $value = strtotime($_REQUEST[$fieldname."_smaller"]['date']);
                                //                                    }
                                //                                    else {
                                //                                        $value = intval($_REQUEST[$fieldname."_smaller"]['date']);
                                //                                    }
                                //                                    $search_url[] = $fieldname."_smaller=".$value;
                                //                                    $searchvars[] = $fieldname;
                                //                                    $criteria->add(new Criteria($fieldname, $value, "<="));
                                //                                    break;

                                default:
                                    if (isset($_REQUEST[$fieldname . '_larger']) && 0 !== (int)$_REQUEST[$fieldname . '_larger']) {
                                        $value        = (int)$_REQUEST[$fieldname . '_larger'];
                                        $search_url[] = $fieldname . '_larger=' . $value;
                                        $searchvars[] = $fieldname;
                                        $criteria->add(new Criteria($fieldname, $value, '>='));
                                    }

                                    if (isset($_REQUEST[$fieldname . '_smaller']) && 0 !== (int)$_REQUEST[$fieldname . '_smaller']) {
                                        $value        = (int)$_REQUEST[$fieldname . '_smaller'];
                                        $search_url[] = $fieldname . '_smaller=' . $value;
                                        $searchvars[] = $fieldname;
                                        $criteria->add(new Criteria($fieldname, $value, '<='));
                                    }
                                    break;
                            }

                            if (isset($_REQUEST[$fieldname]) && !isset($_REQUEST[$fieldname . '_smaller']) && !isset($_REQUEST[$fieldname . '_larger'])) {
                                if (!is_array($_REQUEST[$fieldname])) {
                                    $value        = (int)$_REQUEST[$fieldname];
                                    $search_url[] = $fieldname . '=' . $value;
                                    $criteria->add(new Criteria($fieldname, $value, '='));
                                } else {
                                    $value = array_map('intval', $_REQUEST[$fieldname]);
                                    foreach ($value as $thisvalue) {
                                        $search_url[] = $fieldname . '[]=' . $thisvalue;
                                    }
                                    $criteria->add(new Criteria($fieldname, '(' . implode(',', $value) . ')', 'IN'));
                                }

                                $searchvars[] = $fieldname;
                            }
                            break;
                        case XOBJ_DTYPE_URL:
                        case XOBJ_DTYPE_TXTBOX:
                        case XOBJ_DTYPE_TXTAREA:
                            if (isset($_REQUEST[$fieldname]) && '' !== $_REQUEST[$fieldname]) {
                                $value = $myts->addSlashes(trim($_REQUEST[$fieldname]));
                                switch ($_REQUEST[$fieldname . '_match']) {
                                    case XOOPS_MATCH_START:
                                        $value .= '%';
                                        break;
                                    case XOOPS_MATCH_END:
                                        $value = '%' . $value;
                                        break;
                                    case XOOPS_MATCH_CONTAIN:
                                        $value = '%' . $value . '%';
                                        break;
                                }
                                $search_url[] = $fieldname . '=' . $value;
                                $operator     = 'LIKE';
                                $criteria->add(new Criteria($fieldname, $value, $operator));
                                $searchvars[] = $fieldname;
                            }
                            break;
                    }
                }
            }
        }

        if ($searchvars === []) {
            break;
        }

        if ('name' === $_REQUEST['sortby']) {
            $criteria->setSort('name');
        } elseif ('email' === $_REQUEST['sortby']) {
            $criteria->setSort('email');
        } elseif ('uname' === $_REQUEST['sortby']) {
            $criteria->setSort('uname');
        } elseif (isset($fields[$_REQUEST['sortby']])) {
            $criteria->setSort($fields[$_REQUEST['sortby']]->getVar('field_name'));
        }
        $order = 0 === $_REQUEST['order'] ? 'ASC' : 'DESC';
        $criteria->setOrder($order);

        $limit = isset($_REQUEST['limit']) && (int)$_REQUEST['limit'] > 0 ? (int)$_REQUEST['limit'] : 20;
        $criteria->setLimit($limit);

        $start = Request::getInt('start', 0, 'REQUEST');
        $criteria->setStart($start);

        //Get users based on criteria
        $profileHandler = xoops_getModuleHandler('profile');
        [$users, $profiles, $total_users] = $profileHandler->search($criteria, $searchvars);

        //Sort information
        foreach (array_keys($users) as $k) {
            $userarray['output'][] = "<a href='userinfo.php?uid=" . (int)$users[$k]->getVar(
                    'uid'
                ) . "'>" . $users[$k]->getVar(
                    'uname'
                ) . '</a>';
            $userarray['output'][] = 1 === $users[$k]->getVar(
                'user_viewemail'
            )
                                     || $xoopsUser->isAdmin() ? $users[$k]->getVar(
                'email'
            ) : '';

            foreach (array_keys($fields) as $i) {
                if (in_array($fields[$i]->getVar('fieldid'), $searchable_fields, true)
                    && in_array(
                        $fields[$i]->getVar('field_type'),
                        $searchable_types,
                        true
                    )
                    && in_array(
                        $fields[$i]->getVar('field_name'),
                        $searchvars,
                        true
                    )) {
                    $userarray['output'][] = $fields[$i]->getOutputValue($users[$k], $profiles[$k]);
                }
            }
            $xoopsTpl->append('users', $userarray);
            unset($userarray);
        }

        //Get captions
        $captions[] = _PROFILE_MA_DISPLAYNAME;
        $captions[] = _PROFILE_MA_EMAIL;
        foreach (array_keys($fields) as $i) {
            if (in_array($fields[$i]->getVar('fieldid'), $searchable_fields, true)
                && in_array(
                    $fields[$i]->getVar('field_type'),
                    $searchable_types,
                    true
                )
                && in_array(
                    $fields[$i]->getVar('field_name'),
                    $searchvars,
                    true
                )) {
                $captions[] = $fields[$i]->getVar('field_title');
            }
        }
        $xoopsTpl->assign('captions', $captions);

        if ($total_users > $limit) {
            $search_url[] = 'op=results';
            $search_url[] = 'order=' . $order;
            $search_url[] = 'sortby=' . $_REQUEST['sortby'];
            $search_url[] = 'limit=' . $limit;
            if (isset($search_url)) {
                $args = implode('&amp;', $search_url);
            }
            require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $nav = new XoopsPageNav($total_users, $limit, $start, 'start', $args);
            $xoopsTpl->assign('nav', $nav->renderNav(5));
        }
        break;
}
require XOOPS_ROOT_PATH . '/footer.php';
