<?php
/**
 * Extended User Profile
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @param mixed $action
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package             profile
 * @since               2.3.0
 * @author              Jan Pedersen
 * @author              Taiwen Jiang <phppp@users.sourceforge.net>
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 */

// defined('XOOPS_ROOT_PATH') || exit("XOOPS root path not defined");

/**
 * Get {@link XoopsThemeForm} for adding/editing fields
 *
 * @param Yogurt\Field $field  {@link Yogurt\Field} object to get edit form for
 * @param mixed        $action URL to submit to - or false for $_SERVER['REQUEST_URI']
 *
 * @return object
 */

use XoopsModules\Yogurt;

/**
 * @param Yogurt\Field $field
 * @param bool         $action
 * @return \XoopsThemeForm
 */
function yogurt_getFieldForm(Yogurt\Field $field, $action = false)
{
    if (!$action) {
        $action = $_SERVER['REQUEST_URI'];
    }
    $title = $field->isNew() ? sprintf(_AM_YOGURT_ADD, _AM_YOGURT_FIELD) : sprintf(_AM_YOGURT_EDIT, _AM_YOGURT_FIELD);

    include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
    $form = new XoopsThemeForm($title, 'form', $action, 'post', true);

    $form->addElement(new XoopsFormText(_AM_YOGURT_TITLE, 'field_title', 35, 255, $field->getVar('field_title', 'e')));
    $form->addElement(new XoopsFormTextArea(_AM_YOGURT_DESCRIPTION, 'field_description', $field->getVar('field_description', 'e')));

    $fieldcat_id = 0;
    if (!$field->isNew()) {
        $fieldcat_id = $field->getVar('cat_id');
    }
    $categoryHandler = $helper->getHandler('Category');
    $cat_select       = new XoopsFormSelect(_AM_YOGURT_CATEGORY, 'field_category', $fieldcat_id);
    $cat_select->addOption(0, _AM_YOGURT_DEFAULT);
    $cat_select->addOptionArray($categoryHandler->getList());
    $form->addElement($cat_select);
    $form->addElement(new XoopsFormText(_AM_YOGURT_WEIGHT, 'field_weight', 10, 10, $field->getVar('field_weight', 'e')));
    if ($field->getVar('field_config') || $field->isNew()) {
        if (!$field->isNew()) {
            $form->addElement(new XoopsFormLabel(_AM_YOGURT_NAME, $field->getVar('field_name')));
            $form->addElement(new XoopsFormHidden('id', $field->getVar('field_id')));
        } else {
            $form->addElement(new XoopsFormText(_AM_YOGURT_NAME, 'field_name', 35, 255, $field->getVar('field_name', 'e')));
        }

        //autotext and theme left out of this one as fields of that type should never be changed (valid assumption, I think)
        $fieldtypes = [
            'checkbox'     => _AM_YOGURT_CHECKBOX,
            'date'         => _AM_YOGURT_DATE,
            'datetime'     => _AM_YOGURT_DATETIME,
            'longdate'     => _AM_YOGURT_LONGDATE,
            'group'        => _AM_YOGURT_GROUP,
            'group_multi'  => _AM_YOGURT_GROUPMULTI,
            'language'     => _AM_YOGURT_LANGUAGE,
            'radio'        => _AM_YOGURT_RADIO,
            'select'       => _AM_YOGURT_SELECT,
            'select_multi' => _AM_YOGURT_SELECTMULTI,
            'textarea'     => _AM_YOGURT_TEXTAREA,
            'dhtml'        => _AM_YOGURT_DHTMLTEXTAREA,
            'textbox'      => _AM_YOGURT_TEXTBOX,
            'timezone'     => _AM_YOGURT_TIMEZONE,
            'yesno'        => _AM_YOGURT_YESNO,
        ];

        $element_select = new XoopsFormSelect(_AM_YOGURT_TYPE, 'field_type', $field->getVar('field_type', 'e'));
        $element_select->addOptionArray($fieldtypes);

        $form->addElement($element_select);

        switch ($field->getVar('field_type')) {
            case 'textbox':
                $valuetypes = [
                    XOBJ_DTYPE_TXTBOX          => _AM_YOGURT_TXTBOX,
                    XOBJ_DTYPE_EMAIL           => _AM_YOGURT_EMAIL,
                    XOBJ_DTYPE_INT             => _AM_YOGURT_INT,
                    XOBJ_DTYPE_FLOAT           => _AM_YOGURT_FLOAT,
                    XOBJ_DTYPE_DECIMAL         => _AM_YOGURT_DECIMAL,
                    XOBJ_DTYPE_TXTAREA         => _AM_YOGURT_TXTAREA,
                    XOBJ_DTYPE_URL             => _AM_YOGURT_URL,
                    XOBJ_DTYPE_OTHER           => _AM_YOGURT_OTHER,
                    XOBJ_DTYPE_ARRAY           => _AM_YOGURT_ARRAY,
                    XOBJ_DTYPE_UNICODE_ARRAY   => _AM_YOGURT_UNICODE_ARRAY,
                    XOBJ_DTYPE_UNICODE_TXTBOX  => _AM_YOGURT_UNICODE_TXTBOX,
                    XOBJ_DTYPE_UNICODE_TXTAREA => _AM_YOGURT_UNICODE_TXTAREA,
                    XOBJ_DTYPE_UNICODE_EMAIL   => _AM_YOGURT_UNICODE_EMAIL,
                    XOBJ_DTYPE_UNICODE_URL     => _AM_YOGURT_UNICODE_URL,
                ];

                $type_select = new XoopsFormSelect(_AM_YOGURT_VALUETYPE, 'field_valuetype', $field->getVar('field_valuetype', 'e'));
                $type_select->addOptionArray($valuetypes);
                $form->addElement($type_select);
                break;
            case 'select':
            case 'radio':
                $valuetypes = [
                    XOBJ_DTYPE_TXTBOX          => _AM_YOGURT_TXTBOX,
                    XOBJ_DTYPE_EMAIL           => _AM_YOGURT_EMAIL,
                    XOBJ_DTYPE_INT             => _AM_YOGURT_INT,
                    XOBJ_DTYPE_FLOAT           => _AM_YOGURT_FLOAT,
                    XOBJ_DTYPE_DECIMAL         => _AM_YOGURT_DECIMAL,
                    XOBJ_DTYPE_TXTAREA         => _AM_YOGURT_TXTAREA,
                    XOBJ_DTYPE_URL             => _AM_YOGURT_URL,
                    XOBJ_DTYPE_OTHER           => _AM_YOGURT_OTHER,
                    XOBJ_DTYPE_ARRAY           => _AM_YOGURT_ARRAY,
                    XOBJ_DTYPE_UNICODE_ARRAY   => _AM_YOGURT_UNICODE_ARRAY,
                    XOBJ_DTYPE_UNICODE_TXTBOX  => _AM_YOGURT_UNICODE_TXTBOX,
                    XOBJ_DTYPE_UNICODE_TXTAREA => _AM_YOGURT_UNICODE_TXTAREA,
                    XOBJ_DTYPE_UNICODE_EMAIL   => _AM_YOGURT_UNICODE_EMAIL,
                    XOBJ_DTYPE_UNICODE_URL     => _AM_YOGURT_UNICODE_URL,
                ];

                $type_select = new XoopsFormSelect(_AM_YOGURT_VALUETYPE, 'field_valuetype', $field->getVar('field_valuetype', 'e'));
                $type_select->addOptionArray($valuetypes);
                $form->addElement($type_select);
                break;
        }

        //$form->addElement(new XoopsFormRadioYN(_AM_YOGURT_NOTNULL, 'field_notnull', $field->getVar('field_notnull', 'e') ));

        if ('select' === $field->getVar('field_type') || 'select_multi' === $field->getVar('field_type') || 'radio' === $field->getVar('field_type') || 'checkbox' === $field->getVar('field_type')) {
            $options = $field->getVar('field_options');
            if (count($options) > 0) {
                $remove_options          = new XoopsFormCheckBox(_AM_YOGURT_REMOVEOPTIONS, 'removeOptions');
                $remove_options->columns = 3;
                asort($options);
                foreach (array_keys($options) as $key) {
                    $options[$key] .= "[{$key}]";
                }
                $remove_options->addOptionArray($options);
                $form->addElement($remove_options);
            }

            $option_text = "<table  cellspacing='1'><tr><td class='width20'>" . _AM_YOGURT_KEY . '</td><td>' . _AM_YOGURT_VALUE . '</td></tr>';
            for ($i = 0; $i < 3; ++$i) {
                $option_text .= "<tr><td><input type='text' name='addOption[{$i}][key]' id='addOption[{$i}][key]' size='15' /></td><td><input type='text' name='addOption[{$i}][value]' id='addOption[{$i}][value]' size='35' /></td></tr>";
                $option_text .= "<tr height='3px'><td colspan='2'> </td></tr>";
            }
            $option_text .= '</table>';
            $form->addElement(new XoopsFormLabel(_AM_YOGURT_ADDOPTION, $option_text));
        }
    }

    if ($field->getVar('field_edit')) {
        switch ($field->getVar('field_type')) {
            case 'textbox':
            case 'textarea':
            case 'dhtml':
                $form->addElement(new XoopsFormText(_AM_YOGURT_MAXLENGTH, 'field_maxlength', 35, 35, $field->getVar('field_maxlength', 'e')));
                $form->addElement(new XoopsFormTextArea(_AM_YOGURT_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                break;
            case 'checkbox':
            case 'select_multi':
                $def_value = null != $field->getVar('field_default', 'e') ? unserialize($field->getVar('field_default', 'n')) : null;
                $element   = new XoopsFormSelect(_AM_YOGURT_DEFAULT, 'field_default', $def_value, 8, true);
                $options   = $field->getVar('field_options');
                asort($options);
                // If options do not include an empty element, then add a blank option to prevent any default selection
                //                if (!in_array('', array_keys($options))) {
                if (!array_key_exists('', $options)) {
                    $element->addOption('', _NONE);
                }
                $element->addOptionArray($options);
                $form->addElement($element);
                break;
            case 'select':
            case 'radio':
                $def_value = null != $field->getVar('field_default', 'e') ? $field->getVar('field_default') : null;
                $element   = new XoopsFormSelect(_AM_YOGURT_DEFAULT, 'field_default', $def_value);
                $options   = $field->getVar('field_options');
                asort($options);
                // If options do not include an empty element, then add a blank option to prevent any default selection
                //                if (!in_array('', array_keys($options))) {
                if (!array_key_exists('', $options)) {
                    $element->addOption('', _NONE);
                }
                $element->addOptionArray($options);
                $form->addElement($element);
                break;
            case 'date':
                $form->addElement(new XoopsFormTextDateSelect(_AM_YOGURT_DEFAULT, 'field_default', 15, $field->getVar('field_default', 'e')));
                break;
            case 'longdate':
                $form->addElement(new XoopsFormTextDateSelect(_AM_YOGURT_DEFAULT, 'field_default', 15, strtotime($field->getVar('field_default', 'e'))));
                break;
            case 'datetime':
                $form->addElement(new XoopsFormDateTime(_AM_YOGURT_DEFAULT, 'field_default', 15, $field->getVar('field_default', 'e')));
                break;
            case 'yesno':
                $form->addElement(new XoopsFormRadioYN(_AM_YOGURT_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                break;
            case 'timezone':
                $form->addElement(new XoopsFormSelectTimezone(_AM_YOGURT_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                break;
            case 'language':
                $form->addElement(new XoopsFormSelectLang(_AM_YOGURT_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                break;
            case 'group':
                $form->addElement(new XoopsFormSelectGroup(_AM_YOGURT_DEFAULT, 'field_default', true, $field->getVar('field_default', 'e')));
                break;
            case 'group_multi':
                $form->addElement(new XoopsFormSelectGroup(_AM_YOGURT_DEFAULT, 'field_default', true, unserialize($field->getVar('field_default', 'n')), 5, true));
                break;
            case 'theme':
                $form->addElement(new XoopsFormSelectTheme(_AM_YOGURT_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                break;
            case 'autotext':
                $form->addElement(new XoopsFormTextArea(_AM_YOGURT_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                break;
        }
    }
    /* @var XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler = xoops_getHandler('groupperm');
    $searchable_types  = [
        'textbox',
        'select',
        'radio',
        'yesno',
        'date',
        'datetime',
        'timezone',
        'language',
    ];
    if (in_array($field->getVar('field_type'), $searchable_types)) {
        $search_groups = $grouppermHandler->getGroupIds('profile_search', $field->getVar('field_id'), $GLOBALS['xoopsModule']->getVar('mid'));
        $form->addElement(new XoopsFormSelectGroup(_AM_YOGURT_PROF_SEARCH, 'profile_search', true, $search_groups, 5, true));
    }
    if ($field->getVar('field_edit') || $field->isNew()) {
        $editable_groups = [];
        if (!$field->isNew()) {
            //Load groups
            $editable_groups = $grouppermHandler->getGroupIds('profile_edit', $field->getVar('field_id'), $GLOBALS['xoopsModule']->getVar('mid'));
        }
        $form->addElement(new XoopsFormSelectGroup(_AM_YOGURT_PROF_EDITABLE, 'profile_edit', false, $editable_groups, 5, true));
        $form->addElement(new XoopsFormRadioYN(_AM_YOGURT_REQUIRED, 'field_required', $field->getVar('field_required', 'e')));
        $regstep_select = new XoopsFormSelect(_AM_YOGURT_PROF_REGISTER, 'step_id', $field->getVar('step_id', 'e'));
        $regstep_select->addOption(0, _NO);
        $regstepHandler = $helper->getHandler('Regstep');
        $regstep_select->addOptionArray($regstepHandler->getList());
        $form->addElement($regstep_select);
    }
    $form->addElement(new XoopsFormHidden('op', 'save'));
    $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

    return $form;
}

/**
 * Get {@link XoopsThemeForm} for registering new users
 *
 * @param           $profile
 * @param XoopsUser $user {@link XoopsUser} to register
 * @param int       $step Which step we are at
 *
 * @return object
 * @internal param \profileRegstep $next_step
 */
function yogurt_getRegisterForm(XoopsUser $user, $profile, $step = null)
{
    global $opkey; // should be set in register.php
    if (empty($opkey)) {
        $opkey = 'profile_opname';
    }
    $next_opname      = 'op' . mt_rand(10000, 99999);
    $_SESSION[$opkey] = $next_opname;

    include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
    if (empty($GLOBALS['xoopsConfigUser'])) {
        /* @var XoopsConfigHandler $configHandler */
        $configHandler             = xoops_getHandler('config');
        $GLOBALS['xoopsConfigUser'] = $configHandler->getConfigsByCat(XOOPS_CONF_USER);
    }
    $action    = $_SERVER['REQUEST_URI'];
    $step_no   = $step['step_no'];
    $use_token = $step['step_no'] > 0; // ? true : false;
    $reg_form  = new XoopsThemeForm($step['step_name'], 'regform', $action, 'post', $use_token);

    if ($step['step_desc']) {
        $reg_form->addElement(new XoopsFormLabel('', $step['step_desc']));
    }

    if (1 == $step_no) {
        //$uname_size = $GLOBALS['xoopsConfigUser']['maxuname'] < 35 ? $GLOBALS['xoopsConfigUser']['maxuname'] : 35;

        $elements[0][] = [
            'element'  => new XoopsFormText(_MD_YOGURT_NICKNAME, 'uname', 35, $GLOBALS['xoopsConfigUser']['maxuname'], $user->getVar('uname', 'e')),
            'required' => true,
        ];
        $weights[0][]  = 0;

        $elements[0][] = ['element' => new XoopsFormText(_MD_YOGURT_EMAILADDRESS, 'email', 35, 255, $user->getVar('email', 'e')), 'required' => true];
        $weights[0][]  = 0;

        $elements[0][] = ['element' => new XoopsFormPassword(_MD_YOGURT_PASSWORD, 'pass', 35, 32, ''), 'required' => true];
        $weights[0][]  = 0;

        $elements[0][] = ['element' => new XoopsFormPassword(_US_VERIFYPASS, 'vpass', 35, 32, ''), 'required' => true];
        $weights[0][]  = 0;
    }

    // Dynamic fields
    $profileHandler              = \XoopsModules\Yogurt\Helper::getInstance()->getHandler('Profile');
    $fields                       = $profileHandler->loadFields();
    $_SESSION['profile_required'] = [];
    foreach (array_keys($fields) as $i) {
        if ($fields[$i]->getVar('step_id') == $step['step_id']) {
            $fieldinfo['element'] = $fields[$i]->getEditElement($user, $profile);
            //assign and check (=)
            if ($fieldinfo['required'] = $fields[$i]->getVar('field_required')) {
                $_SESSION['profile_required'][$fields[$i]->getVar('field_name')] = $fields[$i]->getVar('field_title');
            }

            $key              = $fields[$i]->getVar('cat_id');
            $elements[$key][] = $fieldinfo;
            $weights[$key][]  = $fields[$i]->getVar('field_weight');
        }
    }
    ksort($elements);

    // Get categories
    $categoryHandler = \XoopsModules\Yogurt\Helper::getInstance()->getHandler('Category');
    $categories  = $categoryHandler->getObjects(null, true, false);

    foreach (array_keys($elements) as $k) {
        array_multisort($weights[$k], SORT_ASC, array_keys($elements[$k]), SORT_ASC, $elements[$k]);
        //$title = isset($categories[$k]) ? $categories[$k]['cat_title'] : _MD_YOGURT_DEFAULT;
        //$desc = isset($categories[$k]) ? $categories[$k]['cat_description'] : "";
        //$reg_form->insertBreak("<p>{$title}</p>{$desc}");
        //$reg_form->addElement(new XoopsFormLabel("<h2>".$title."</h2>", $desc), false);
        foreach (array_keys($elements[$k]) as $i) {
            $reg_form->addElement($elements[$k][$i]['element'], $elements[$k][$i]['required']);
        }
    }
    //end of Dynamic User fields

    if (1 == $step_no && 0 != $GLOBALS['xoopsConfigUser']['reg_dispdsclmr'] && '' != $GLOBALS['xoopsConfigUser']['reg_disclaimer']) {
        $disc_tray = new XoopsFormElementTray(_US_DISCLAIMER, '<br>');
        $disc_text = new XoopsFormLabel('', '<div class="pad5">' . $GLOBALS['myts']->displayTarea($GLOBALS['xoopsConfigUser']['reg_disclaimer'], 1) . '</div>');
        $disc_tray->addElement($disc_text);
        $agree_chk = new XoopsFormCheckBox('', 'agree_disc');
        $agree_chk->addOption(1, _US_IAGREE);
        $disc_tray->addElement($agree_chk);
        $reg_form->addElement($disc_tray);
    }
    global $xoopsModuleConfig;
    $useCaptchaAfterStep2 = $xoopsModuleConfig['profileCaptchaAfterStep1'] + 1;

    if ($step_no <= $useCaptchaAfterStep2) {
        $reg_form->addElement(new XoopsFormCaptcha(), true);
    }

    $reg_form->addElement(new XoopsFormHidden($next_opname, 'register'));
    $reg_form->addElement(new XoopsFormHidden('uid', $user->getVar('uid')));
    $reg_form->addElement(new XoopsFormHidden('step', $step_no));
    $reg_form->addElement(new XoopsFormButton('', 'submitButton', _SUBMIT, 'submit'));

    return $reg_form;
}

/**
 * Get {@link XoopsThemeForm} for editing a user
 *
 * @param XoopsUser                    $user {@link XoopsUser} to edit
 * @param \XoopsModules\Yogurt\Profile $profile
 * @param bool                         $action
 *
 * @return object
 */
function yogurt_getUserForm(XoopsUser $user, Yogurt\Profile $profile = null, $action = false)
{
    $helper = \XoopsModules\Yogurt\Helper::getInstance();
    if (!$action) {
        $action = $_SERVER['REQUEST_URI'];
    }
    if (empty($GLOBALS['xoopsConfigUser'])) {
        /* @var XoopsConfigHandler $configHandler */
        $configHandler             = xoops_getHandler('config');
        $GLOBALS['xoopsConfigUser'] = $configHandler->getConfigsByCat(XOOPS_CONF_USER);
    }

    require_once $GLOBALS['xoops']->path('class/xoopsformloader.php');

    $title = $user->isNew() ? _AM_YOGURT_ADDUSER : _US_EDITPROFILE;

    $form = new XoopsThemeForm($title, 'userinfo', $action, 'post', true);

    /* @var ProfileHandler $profileHandler */

    $profileHandler = $helper->getHandler('Profile');
    // Dynamic fields
    if (!$profile) {
        /* @var ProfileHandler $profileHandler */

        $profileHandler = $helper->getHandler('Profile');
        $profile         = $profileHandler->get($user->getVar('uid'));
    }
    // Get fields
    $fields = $profileHandler->loadFields();
    // Get ids of fields that can be edited
    /* @var  XoopsGroupPermHandler $grouppermHandler */
    $grouppermHandler = xoops_getHandler('groupperm');
    $editable_fields  = $grouppermHandler->getItemIds('profile_edit', $GLOBALS['xoopsUser']->getGroups(), $GLOBALS['xoopsModule']->getVar('mid'));

    if ($user->isNew() || $GLOBALS['xoopsUser']->isAdmin()) {
        $elements[0][] = [
            'element'  => new XoopsFormText(_MD_YOGURT_NICKNAME, 'uname', 25, $GLOBALS['xoopsUser']->isAdmin() ? 60 : $GLOBALS['xoopsConfigUser']['maxuname'], $user->getVar('uname', 'e')),
            'required' => 1,
        ];
        $email_text    = new XoopsFormText('', 'email', 30, 60, $user->getVar('email'));
    } else {
        $elements[0][] = ['element' => new XoopsFormLabel(_MD_YOGURT_NICKNAME, $user->getVar('uname')), 'required' => 0];
        $email_text    = new XoopsFormLabel('', $user->getVar('email'));
    }
    $email_tray = new XoopsFormElementTray(_MD_YOGURT_EMAILADDRESS, '<br>');
    $email_tray->addElement($email_text, ($user->isNew() || $GLOBALS['xoopsUser']->isAdmin()) ? 1 : 0);
    $weights[0][]  = 0;
    $elements[0][] = ['element' => $email_tray, 'required' => 0];
    $weights[0][]  = 0;

    if ($GLOBALS['xoopsUser']->isAdmin() && $user->getVar('uid') != $GLOBALS['xoopsUser']->getVar('uid')) {
        //If the user is an admin and is editing someone else
        $pwd_text  = new XoopsFormPassword('', 'password', 10, 32);
        $pwd_text2 = new XoopsFormPassword('', 'vpass', 10, 32);
        $pwd_tray  = new XoopsFormElementTray(_MD_YOGURT_PASSWORD . '<br>' . _MD_YOGURT_CONFIRMPASSWORD);
        $pwd_tray->addElement($pwd_text);
        $pwd_tray->addElement($pwd_text2);
        $elements[0][] = ['element' => $pwd_tray, 'required' => 0]; //cannot set an element tray required
        $weights[0][]  = 0;

        $level_radio = new XoopsFormRadio(_MD_YOGURT_USERLEVEL, 'level', $user->getVar('level'));
        $level_radio->addOption(1, _MD_YOGURT_ACTIVE);
        $level_radio->addOption(0, _MD_YOGURT_INACTIVE);
        //$level_radio->addOption(-1, _MD_YOGURT_DISABLED);
        $elements[0][] = ['element' => $level_radio, 'required' => 0];
        $weights[0][]  = 0;
    }

    $elements[0][] = ['element' => new XoopsFormHidden('uid', $user->getVar('uid')), 'required' => 0];
    $weights[0][]  = 0;
    $elements[0][] = ['element' => new XoopsFormHidden('op', 'save'), 'required' => 0];
    $weights[0][]  = 0;

    $categoryHandler    = $helper->getHandler('Category');
    $categories     = [];
    $all_categories = $categoryHandler->getObjects(null, true, false);
    $count_fields   = count($fields);

    foreach (array_keys($fields) as $i) {
        if (in_array($fields[$i]->getVar('field_id'), $editable_fields)) {
            // Set default value for user fields if available
            if ($user->isNew()) {
                $default = $fields[$i]->getVar('field_default');
                if ('' !== $default && null !== $default) {
                    $user->setVar($fields[$i]->getVar('field_name'), $default);
                }
            }

            if (null === $profile->getVar($fields[$i]->getVar('field_name'), 'n')) {
                $default = $fields[$i]->getVar('field_default', 'n');
                $profile->setVar($fields[$i]->getVar('field_name'), $default);
            }

            $fieldinfo['element']  = $fields[$i]->getEditElement($user, $profile);
            $fieldinfo['required'] = $fields[$i]->getVar('field_required');

            $key              = @$all_categories[$fields[$i]->getVar('cat_id')]['cat_weight'] * $count_fields + $fields[$i]->getVar('cat_id');
            $elements[$key][] = $fieldinfo;
            $weights[$key][]  = $fields[$i]->getVar('field_weight');
            $categories[$key] = @$all_categories[$fields[$i]->getVar('cat_id')];
        }
    }

    if ($GLOBALS['xoopsUser'] && $GLOBALS['xoopsUser']->isAdmin()) {
        xoops_loadLanguage('admin', 'profile');
        /* @var  XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');
        //If user has admin rights on groups
        include_once $GLOBALS['xoops']->path('modules/system/constants.php');
        if ($grouppermHandler->checkRight('system_admin', XOOPS_SYSTEM_GROUP, $GLOBALS['xoopsUser']->getGroups(), 1)) {
            //add group selection
            $group_select  = new XoopsFormSelectGroup(_MD_YOGURT_USERGROUPS, 'groups', false, $user->getGroups(), 5, true);
            $elements[0][] = ['element' => $group_select, 'required' => 0];
            //set as latest;
            $weights[0][] = $count_fields + 1;
        }
    }

    ksort($elements);
    foreach (array_keys($elements) as $k) {
        array_multisort($weights[$k], SORT_ASC, array_keys($elements[$k]), SORT_ASC, $elements[$k]);
        $title = isset($categories[$k]) ? $categories[$k]['cat_title'] : _MD_YOGURT_DEFAULT;
        $desc  = isset($categories[$k]) ? $categories[$k]['cat_description'] : '';
        $form->addElement(new XoopsFormLabel("<h3>{$title}</h3>", $desc), false);
        foreach (array_keys($elements[$k]) as $i) {
            $form->addElement($elements[$k][$i]['element'], $elements[$k][$i]['required']);
        }
    }

    $form->addElement(new XoopsFormHidden('uid', $user->getVar('uid')));
    $form->addElement(new XoopsFormButton('', 'submit', _MD_YOGURT_SAVECHANGES, 'submit'));

    return $form;
}

/**
 * Get {@link XoopsThemeForm} for editing a step
 *
 * @param \XoopsModules\Yogurt\Regstep $step {@link Regstep} to edit
 * @param bool                         $action
 *
 * @return object
 */
function yogurt_getStepForm(Yogurt\Regstep $step = null, $action = false)
{
    if (!$action) {
        $action = $_SERVER['REQUEST_URI'];
    }
    if (empty($GLOBALS['xoopsConfigUser'])) {
        /* @var XoopsConfigHandler $configHandler */
        $configHandler             = xoops_getHandler('config');
        $GLOBALS['xoopsConfigUser'] = $configHandler->getConfigsByCat(XOOPS_CONF_USER);
    }
    include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');

    $form = new XoopsThemeForm(_AM_YOGURT_STEP, 'stepform', 'step.php', 'post', true);

    if (!$step->isNew()) {
        $form->addElement(new XoopsFormHidden('id', $step->getVar('step_id')));
    }
    $form->addElement(new XoopsFormHidden('op', 'save'));
    $form->addElement(new XoopsFormText(_AM_YOGURT_STEPNAME, 'step_name', 25, 255, $step->getVar('step_name', 'e')));
    $form->addElement(new XoopsFormText(_AM_YOGURT_STEPINTRO, 'step_desc', 25, 255, $step->getVar('step_desc', 'e')));
    $form->addElement(new XoopsFormText(_AM_YOGURT_STEPORDER, 'step_order', 10, 10, $step->getVar('step_order', 'e')));
    $form->addElement(new XoopsFormRadioYN(_AM_YOGURT_STEPSAVE, 'step_save', $step->getVar('step_save', 'e')));
    $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

    return $form;
}
