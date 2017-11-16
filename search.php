<?php
// $Id: search.php,v 1.1 2007/10/20 01:27:28 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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

include '../../mainfile.php';
$myts =& MyTextSanitizer::getInstance();
$op = isset($_REQUEST['op']) ? htmlspecialchars($_REQUEST['op']) : 'search';
$groups = $xoopsUser ? $xoopsUser->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
switch ($op) {
    default:
    case "search":
        $xoopsOption['cache_group'] = implode('', $groups);
        $xoopsOption['template_main'] = "yogurt_search.html";
        include XOOPS_ROOT_PATH."/header.php";

        // Dynamic fields
        $profile_handler =& xoops_getmodulehandler('profile');
        // Get fields
        $fields =& $profile_handler->loadFields();
        // Get ids of fields that can be searched
        $gperm_handler =& xoops_gethandler('groupperm');
        $searchable_fields =& $gperm_handler->getItemIds('smartprofile_search', $groups, $xoopsModule->getVar('mid'));

        include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
        $searchform = new XoopsThemeForm("", "searchform", "search.php", "post");

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

        $searchable_types = array('textbox',
        'select',
        'radio',
        'yesno',
        'date',
        'datetime',
        'timezone',
        'language');
        foreach (array_keys($fields) as $i) {
            if (in_array($fields[$i]->getVar('fieldid'), $searchable_fields) && in_array($fields[$i]->getVar('field_type'), $searchable_types)) {
                $sortby_arr[$fields[$i]->getVar('fieldid')] = $fields[$i]->getVar('field_title');
                switch ($fields[$i]->getVar('field_type')) {
                    case "textbox":
                        if ($fields[$i]->getVar('field_valuetype') == XOBJ_DTYPE_INT) {
                            $searchform->addElement(new XoopsFormText(sprintf(_PROFILE_MA_LARGERTHAN, $fields[$i]->getVar('field_title')), $fields[$i]->getVar('field_name')."_larger", 35, 35));
                            $searchform->addElement(new XoopsFormText(sprintf(_PROFILE_MA_SMALLERTHAN, $fields[$i]->getVar('field_title')), $fields[$i]->getVar('field_name')."_smaller", 35, 35));
                        }
                        else {
                            $tray = new XoopsFormElementTray($fields[$i]->getVar('field_title'));
                            $tray->addElement(new XoopsFormSelectMatchOption('', $fields[$i]->getVar('field_name')."_match"));
                            $tray->addElement(new XoopsFormText('', $fields[$i]->getVar('field_name'), 35, $fields[$i]->getVar('field_maxlength')));
                            $searchform->addElement($tray);
                            unset($tray);
                        }
                        break;

                    case "radio":
                    case "select":
                        $size = count($fields[$i]->getVar('field_options')) > 10 ? 10 : count($fields[$i]->getVar('field_options'));
                        $element = new XoopsFormSelect($fields[$i]->getVar('field_title'), $fields[$i]->getVar('field_name'), null, $size, true);
                        $options = $fields[$i]->getVar('field_options');
                        asort($options);
                        $element->addOptionArray($options);
                        $searchform->addElement($element);
                        unset($element);
                        break;

                    case "yesno":
                        $element = new XoopsFormSelect($fields[$i]->getVar('field_title'), $fields[$i]->getVar('field_name'), null, 2, true);
                        $element->addOption(1, _YES);
                        $element->addOption(0, _NO);
                        $searchform->addElement($element);
                        unset($element);
                        break;

                    case "date":
                    case "datetime":
                        $searchform->addElement(new XoopsFormTextDateSelect(sprintf(_PROFILE_MA_LATERTHAN, $fields[$i]->getVar('field_title')), $fields[$i]->getVar('field_name')."_larger", 15, 0));
                        $searchform->addElement(new XoopsFormTextDateSelect(sprintf(_PROFILE_MA_EARLIERTHAN, $fields[$i]->getVar('field_title')), $fields[$i]->getVar('field_name')."_smaller", 15, time()));
                        break;

//                    case "datetime":
//                        $searchform->addElement(new XoopsFormDateTime(sprintf(_PROFILE_MA_LATERTHAN, $fields[$i]->getVar('field_title')), $fields[$i]->getVar('field_name')."_larger", 15, 1));
//                        $searchform->addElement(new XoopsFormDateTime(sprintf(_PROFILE_MA_EARLIERTHAN, $fields[$i]->getVar('field_title')), $fields[$i]->getVar('field_name')."_smaller", 15, 0));
//                        break;

                    case "timezone":
                        $element = new XoopsFormSelect($fields[$i]->getVar('field_title'), $fields[$i]->getVar('field_name'), null, 6, true);
                        include_once XOOPS_ROOT_PATH."/class/xoopslists.php";
                        $element->addOptionArray(XoopsLists::getTimeZoneList());
                        $searchform->addElement($element);
                        unset($element);
                        break;

                    case "language":
                        $element = new XoopsFormSelectLang($fields[$i]->getVar('field_title'), $fields[$i]->getVar('field_name'), null, 6);
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

    case "results":
        $xoopsOption['template_main'] = "smartprofile_results.html";
        include_once XOOPS_ROOT_PATH."/header.php";

        $member_handler =& xoops_gethandler('member');
        // Dynamic fields
        $profile_handler =& xoops_getmodulehandler('profile');
        // Get fields
        $fields =& $profile_handler->loadFields();
        // Get ids of fields that can be searched
        $gperm_handler =& xoops_gethandler('groupperm');
        $searchable_fields =& $gperm_handler->getItemIds('smartprofile_search', $groups, $xoopsModule->getVar('mid'));
        $searchvars = array();

        $criteria = new CriteriaCompo(new Criteria('level', 0, ">"));
        if (isset($_REQUEST['uname']) && $_REQUEST['uname'] != "") {
            $string = $myts->addSlashes(trim($_REQUEST['uname']));
            switch ($_REQUEST['uname_match']) {
                case XOOPS_MATCH_START:
                    $string .= "%";
                    break;

                case XOOPS_MATCH_END:
                    $string = "%".$string;
                    break;

                case XOOPS_MATCH_CONTAIN:
                    $string = "%".$string."%";
                    break;
            }
            $criteria->add(new Criteria('uname', $string, "LIKE"));
            $searchvars[] = "uname";
        }
        if (isset($_REQUEST['email']) && $_REQUEST['email'] != "") {
            $string = $myts->addSlashes(trim($_REQUEST['email']));
            switch ($_REQUEST['email_match']) {
                case XOOPS_MATCH_START:
                    $string .= "%";
                    break;

                case XOOPS_MATCH_END:
                    $string = "%".$string;
                    break;

                case XOOPS_MATCH_CONTAIN:
                    $string = "%".$string."%";
                    break;
            }
            $searchvars[] = "email";
            $criteria->add(new Criteria('email', $string, "LIKE"));
            $criteria->add(new Criteria('user_viewemail', 1));
        }
        $searchable_types = array('textbox',
        'select',
        'radio',
        'yesno',
        'date',
        'datetime',
        'timezone',
        'language');

        foreach (array_keys($fields) as $i) {
            if (in_array($fields[$i]->getVar('fieldid'), $searchable_fields) && in_array($fields[$i]->getVar('field_type'), $searchable_types)) {
                $fieldname = $fields[$i]->getVar('field_name');
                if (in_array($fields[$i]->getVar('field_type'), array("select", "radio"))) {
                    if (isset($_REQUEST[$fieldname]) && $_REQUEST[$fieldname]) {
                        //If field value is sent through request and is not an empty value
                        switch ($fields[$i]->getVar('field_valuetype')) {
                            case XOBJ_DTYPE_OTHER:
                            case XOBJ_DTYPE_INT:
                                $value = array_map('intval', $_REQUEST[$fieldname]);
                                $searchvars[] = $fieldname;
                                $criteria->add(new Criteria($fieldname, "(".implode(',', $value).")", "IN"));
                                break;

                            case XOBJ_DTYPE_URL:
                            case XOBJ_DTYPE_TXTBOX:
                            case XOBJ_DTYPE_TXTAREA:
                                $value = array_map(array($xoopsDB, "quoteString"), $_REQUEST[$fieldname]);
                                $searchvars[] = $fieldname;
                                $criteria->add(new Criteria($fieldname, "(".implode(',', $value).")", "IN"));
                                break;
                        }
                    }
                }
                else {
                    switch ($fields[$i]->getVar('field_valuetype')) {
                        case XOBJ_DTYPE_OTHER:
                        case XOBJ_DTYPE_INT:
                            switch ($fields[$i]->getVar('field_type')) {
                                case "date":
                                case "datetime":
                                    $value = $_REQUEST[$fieldname."_larger"];
                                    if (!($value = strtotime($_REQUEST[$fieldname."_larger"]))) {
                                        $value = intval($_REQUEST[$fieldname."_larger"]);
                                    }
                                    if ($value > 0) {
                                        $search_url[] = $fieldname."_larger=".$value;
                                        $searchvars[] = $fieldname;
                                        $criteria->add(new Criteria($fieldname, $value, ">="));
                                    }
                                    
                                    $value = $_REQUEST[$fieldname."_smaller"];
                                    if (!($value = strtotime($_REQUEST[$fieldname."_smaller"]))) {
                                        $value = intval($_REQUEST[$fieldname."_smaller"]);
                                    }
                                    if ($value > 0) {
                                        $search_url[] = $fieldname."_smaller=".$value;
                                        $searchvars[] = $fieldname;
                                        $criteria->add(new Criteria($fieldname, $value, "<="));
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
                                    if (isset($_REQUEST[$fieldname."_larger"]) && intval($_REQUEST[$fieldname."_larger"]) != 0) {
                                        $value = intval($_REQUEST[$fieldname."_larger"]);
                                        $search_url[] = $fieldname."_larger=".$value;
                                        $searchvars[] = $fieldname;
                                        $criteria->add(new Criteria($fieldname, $value, ">="));
                                    }
                                    
                                    if (isset($_REQUEST[$fieldname."_smaller"]) && intval($_REQUEST[$fieldname."_smaller"]) != 0) {
                                        $value = intval($_REQUEST[$fieldname."_smaller"]);
                                        $search_url[] = $fieldname."_smaller=".$value;
                                        $searchvars[] = $fieldname;
                                        $criteria->add(new Criteria($fieldname, $value, "<="));
                                    }
                                    break;
                            }
                         
                            if (isset($_REQUEST[$fieldname]) && !isset($_REQUEST[$fieldname."_smaller"]) && !isset($_REQUEST[$fieldname."_larger"])) {
                                if (!is_array($_REQUEST[$fieldname])) {
                                    $value = intval($_REQUEST[$fieldname]);
                                    $search_url[] = $fieldname."=".$value;
                                    $criteria->add(new Criteria($fieldname, $value, "="));
                                }
                                else {
                                    $value = array_map("intval", $_REQUEST[$fieldname]);
                                    foreach ($value as $thisvalue) {
                                        $search_url[] = $fieldname."[]=".$thisvalue;
                                    }
                                    $criteria->add(new Criteria($fieldname, "(".implode(',', $value).")", "IN"));
                                }

                                $searchvars[] = $fieldname;
                            }
                            break;

                        case XOBJ_DTYPE_URL:
                        case XOBJ_DTYPE_TXTBOX:
                        case XOBJ_DTYPE_TXTAREA:
                            if (isset($_REQUEST[$fieldname]) && $_REQUEST[$fieldname] != "") {
                                $value = $myts->addSlashes(trim($_REQUEST[$fieldname]));
                                switch ($_REQUEST[$fieldname.'_match']) {
                                    case XOOPS_MATCH_START:
                                        $value .= "%";
                                        break;

                                    case XOOPS_MATCH_END:
                                        $value = "%".$value;
                                        break;

                                    case XOOPS_MATCH_CONTAIN:
                                        $value = "%".$value."%";
                                        break;
                                }
                                $search_url[] = $fieldname."=".$value;
                                $operator = "LIKE";
                                $criteria->add(new Criteria($fieldname, $value, $operator));
                                $searchvars[] = $fieldname;
                            }
                            break;
                    }
                }
            }
        }

        if ($searchvars == array()) {
            break;
        }

        if ($_REQUEST['sortby'] == "name") {
            $criteria->setSort("name");
        }
        elseif ($_REQUEST['sortby'] == "email") {
            $criteria->setSort("email");
        }
        elseif ($_REQUEST['sortby'] == "uname") {
            $criteria->setSort("uname");
        }
        elseif (isset($fields[$_REQUEST['sortby']])) {
            $criteria->setSort($fields[$_REQUEST['sortby']]->getVar('field_name'));
        }
        $order = $_REQUEST['order'] == 0 ? "ASC" : "DESC";
        $criteria->setOrder($order);

        $limit = isset($_REQUEST['limit']) && intval($_REQUEST['limit']) > 0 ? intval($_REQUEST['limit']) : 20;
        $criteria->setLimit($limit);

        $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
        $criteria->setStart($start);

        //Get users based on criteria
        $profile_handler = xoops_getmodulehandler('profile');
        list($users, $profiles, $total_users) = $profile_handler->search($criteria, $searchvars);

        //Sort information
        foreach (array_keys($users) as $k) {
            $userarray["output"][] = "<a href='userinfo.php?uid=".intval($users[$k]->getVar('uid'))."'>".$users[$k]->getVar('uname')."</a>";
            $userarray["output"][] = $users[$k]->getVar('user_viewemail') == 1 || $xoopsUser->isAdmin() ? $users[$k]->getVar('email') : "";

            foreach (array_keys($fields) as $i) {
                if (in_array($fields[$i]->getVar('fieldid'), $searchable_fields) && in_array($fields[$i]->getVar('field_type'), $searchable_types) && in_array($fields[$i]->getVar('field_name'), $searchvars)) {
                    $userarray["output"][] = $fields[$i]->getOutputValue($users[$k], $profiles[$k]);
                }
            }
            $xoopsTpl->append('users', $userarray);
            unset($userarray);
        }

        //Get captions
        $captions[] = _PROFILE_MA_DISPLAYNAME;
        $captions[] = _PROFILE_MA_EMAIL;
        foreach (array_keys($fields) as $i) {
            if (in_array($fields[$i]->getVar('fieldid'), $searchable_fields) && in_array($fields[$i]->getVar('field_type'), $searchable_types) && in_array($fields[$i]->getVar('field_name'), $searchvars)) {
                $captions[] = $fields[$i]->getVar('field_title');
            }
        }
        $xoopsTpl->assign('captions', $captions);

        if ($total_users > $limit) {
            $search_url[] = "op=results";
            $search_url[] = "order=".$order;
            $search_url[] = "sortby=".$_REQUEST['sortby'];
            $search_url[] = "limit=".$limit;
            if (isset($search_url)) {
                $args = implode("&amp;", $search_url);
            }
            include_once XOOPS_ROOT_PATH."/class/pagenav.php";
            $nav = new XoopsPageNav($total_users, $limit, $start, "start", $args);
            $xoopsTpl->assign('nav', $nav->renderNav(5));
        }
        break;
}
include XOOPS_ROOT_PATH."/footer.php";
?>