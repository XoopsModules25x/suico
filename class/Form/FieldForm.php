<?php

declare(strict_types=1);

namespace XoopsModules\Suico\Form;

use XoopsThemeForm;
use XoopsFormButton;
use XoopsFormText;
use XoopsFormTextArea;
use XoopsFormHidden;
use XoopsFormSelect;
use XoopsFormLabel;
use XoopsFormTextDateSelect;
use XoopsModules\Suico\{
    Helper
};
/** @var Helper $helper */

/**
 * Class FieldForm
 * @package XoopsModules\Suico\Form
 */
class FieldForm extends XoopsThemeForm
{
    /**
     * @param Suico\Field $field  {@link Suico\Field} object to get edit form for
     * @param mixed       $action URL to submit to - or false for $_SERVER['REQUEST_URI']
     */
    public function __construct(Suico\Field $field, $action = false)
    {
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        $title = $field->isNew() ? \sprintf(\_AM_SUICO_ADD, \_AM_SUICO_FIELD) : \sprintf(\_AM_SUICO_EDIT, \_AM_SUICO_FIELD);
        require_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
        parent::__construct($title, 'form', $action, 'post', true);
        $this->addElement(new XoopsFormText(\_AM_SUICO_TITLE, 'field_title', 35, 255, $field->getVar('field_title', 'e')));
        $this->addElement(new XoopsFormTextArea(\_AM_SUICO_DESCRIPTION, 'field_description', $field->getVar('field_description', 'e')));
        $fieldcat_id = 0;
        if (!$field->isNew()) {
            $fieldcat_id = $field->getVar('cat_id');
        }
        $categoryHandler = Helper::getInstance()->getHandler('Category');
        $cat_select      = new XoopsFormSelect(\_AM_SUICO_CATEGORY, 'field_category', $fieldcat_id);
        $cat_select->addOption(0, \_AM_SUICO_DEFAULT);
        $cat_select->addOptionArray($categoryHandler->getList());
        $this->addElement($cat_select);
        $this->addElement(new XoopsFormText(\_AM_SUICO_WEIGHT, 'field_weight', 10, 10, $field->getVar('field_weight', 'e')));
        if ($field->getVar('field_config') || $field->isNew()) {
            if ($field->isNew()) {
                $this->addElement(new XoopsFormText(\_AM_SUICO_NAME, 'field_name', 35, 255, $field->getVar('field_name', 'e')));
            } else {
                $this->addElement(new XoopsFormLabel(\_AM_SUICO_NAME, $field->getVar('field_name')));
                $this->addElement(new XoopsFormHidden('id', $field->getVar('field_id')));
            }
            //autotext and theme left out of this one as fields of that type should never be changed (valid assumption, I think)
            $fieldtypes     = [
                'checkbox'     => \_AM_SUICO_CHECKBOX,
                'date'         => \_AM_SUICO_DATE,
                'datetime'     => \_AM_SUICO_DATETIME,
                'longdate'     => \_AM_SUICO_LONGDATE,
                'group'        => \_AM_SUICO_GROUP,
                'group_multi'  => \_AM_SUICO_GROUPMULTI,
                'language'     => \_AM_SUICO_LANGUAGE,
                'radio'        => \_AM_SUICO_RADIO,
                'select'       => \_AM_SUICO_SELECT,
                'select_multi' => \_AM_SUICO_SELECTMULTI,
                'textarea'     => \_AM_SUICO_TEXTAREA,
                'dhtml'        => \_AM_SUICO_DHTMLTEXTAREA,
                'textbox'      => \_AM_SUICO_TEXTBOX,
                'timezone'     => \_AM_SUICO_TIMEZONE,
                'yesno'        => \_AM_SUICO_YESNO,
            ];
            $element_select = new XoopsFormSelect(\_AM_SUICO_TYPE, 'field_type', $field->getVar('field_type', 'e'));
            $element_select->addOptionArray($fieldtypes);
            $this->addElement($element_select);
            switch ($field->getVar('field_type')) {
                case 'textbox':
                    $valuetypes  = [
                        \XOBJ_DTYPE_TXTBOX          => \_AM_SUICO_TXTBOX,
                        \XOBJ_DTYPE_EMAIL           => \_AM_SUICO_EMAIL,
                        \XOBJ_DTYPE_INT             => \_AM_SUICO_INT,
                        \XOBJ_DTYPE_FLOAT           => \_AM_SUICO_FLOAT,
                        \XOBJ_DTYPE_DECIMAL         => \_AM_SUICO_DECIMAL,
                        \XOBJ_DTYPE_TXTAREA         => \_AM_SUICO_TXTAREA,
                        \XOBJ_DTYPE_URL             => \_AM_SUICO_URL,
                        \XOBJ_DTYPE_OTHER           => \_AM_SUICO_OTHER,
                        \XOBJ_DTYPE_ARRAY           => \_AM_SUICO_ARRAY,
                        \XOBJ_DTYPE_UNICODE_ARRAY   => \_AM_SUICO_UNICODE_ARRAY,
                        \XOBJ_DTYPE_UNICODE_TXTBOX  => \_AM_SUICO_UNICODE_TXTBOX,
                        \XOBJ_DTYPE_UNICODE_TXTAREA => \_AM_SUICO_UNICODE_TXTAREA,
                        \XOBJ_DTYPE_UNICODE_EMAIL   => \_AM_SUICO_UNICODE_EMAIL,
                        \XOBJ_DTYPE_UNICODE_URL     => \_AM_SUICO_UNICODE_URL,
                    ];
                    $type_select = new XoopsFormSelect(\_AM_SUICO_VALUETYPE, 'field_valuetype', $field->getVar('field_valuetype', 'e'));
                    $type_select->addOptionArray($valuetypes);
                    $this->addElement($type_select);
                    break;
                case 'select':
                case 'radio':
                    $valuetypes  = [
                        \XOBJ_DTYPE_TXTBOX          => \_AM_SUICO_TXTBOX,
                        \XOBJ_DTYPE_EMAIL           => \_AM_SUICO_EMAIL,
                        \XOBJ_DTYPE_INT             => \_AM_SUICO_INT,
                        \XOBJ_DTYPE_FLOAT           => \_AM_SUICO_FLOAT,
                        \XOBJ_DTYPE_DECIMAL         => \_AM_SUICO_DECIMAL,
                        \XOBJ_DTYPE_TXTAREA         => \_AM_SUICO_TXTAREA,
                        \XOBJ_DTYPE_URL             => \_AM_SUICO_URL,
                        \XOBJ_DTYPE_OTHER           => \_AM_SUICO_OTHER,
                        \XOBJ_DTYPE_ARRAY           => \_AM_SUICO_ARRAY,
                        \XOBJ_DTYPE_UNICODE_ARRAY   => \_AM_SUICO_UNICODE_ARRAY,
                        \XOBJ_DTYPE_UNICODE_TXTBOX  => \_AM_SUICO_UNICODE_TXTBOX,
                        \XOBJ_DTYPE_UNICODE_TXTAREA => \_AM_SUICO_UNICODE_TXTAREA,
                        \XOBJ_DTYPE_UNICODE_EMAIL   => \_AM_SUICO_UNICODE_EMAIL,
                        \XOBJ_DTYPE_UNICODE_URL     => \_AM_SUICO_UNICODE_URL,
                    ];
                    $type_select = new XoopsFormSelect(\_AM_SUICO_VALUETYPE, 'field_valuetype', $field->getVar('field_valuetype', 'e'));
                    $type_select->addOptionArray($valuetypes);
                    $this->addElement($type_select);
                    break;
            }
            //$this->addElement(new XoopsFormRadioYN(_AM_SUICO_NOTNULL, 'field_notnull', $field->getVar('field_notnull', 'e') ));
            if ('select' === $field->getVar('field_type') || 'select_multi' === $field->getVar('field_type') || 'radio' === $field->getVar('field_type') || 'checkbox' === $field->getVar('field_type')) {
                $options = $field->getVar('field_options');
                if (\count($options) > 0) {
                    $remove_options          = new \XoopsFormCheckBox(\_AM_SUICO_REMOVEOPTIONS, 'removeOptions');
                    $remove_options->columns = 3;
                    \asort($options);
                    foreach (\array_keys($options) as $key) {
                        $options[$key] .= "[{$key}]";
                    }
                    $remove_options->addOptionArray($options);
                    $this->addElement($remove_options);
                }
                $option_text = "<table  cellspacing='1'><tr><td class='width20'>" . \_AM_SUICO_KEY . '</td><td>' . \_AM_SUICO_VALUE . '</td></tr>';
                for ($i = 0; $i < 3; ++$i) {
                    $option_text .= "<tr><td><input type='text' name='addOption[{$i}][key]' id='addOption[{$i}][key]' size='15'></td><td><input type='text' name='addOption[{$i}][value]' id='addOption[{$i}][value]' size='35'></td></tr>";
                    $option_text .= "<tr height='3px'><td colspan='2'> </td></tr>";
                }
                $option_text .= '</table>';
                $this->addElement(new XoopsFormLabel(\_AM_SUICO_ADDOPTION, $option_text));
            }
        }
        if ($field->getVar('field_edit')) {
            switch ($field->getVar('field_type')) {
                case 'textbox':
                case 'textarea':
                case 'dhtml':
                    $this->addElement(new XoopsFormText(\_AM_SUICO_MAXLENGTH, 'field_maxlength', 35, 35, $field->getVar('field_maxlength', 'e')));
                    $this->addElement(new XoopsFormTextArea(\_AM_SUICO_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                    break;
                case 'checkbox':
                case 'select_multi':
                    $def_value = null != $field->getVar('field_default', 'e') ? \unserialize($field->getVar('field_default', 'n')) : null;
                    $element   = new XoopsFormSelect(\_AM_SUICO_DEFAULT, 'field_default', $def_value, 8, true);
                    $options   = $field->getVar('field_options');
                    \asort($options);
                    // If options do not include an empty element, then add a blank option to prevent any default selection
                    //                if (!in_array('', array_keys($options))) {
                    if (!\array_key_exists('', $options)) {
                        $element->addOption('', \_NONE);
                    }
                    $element->addOptionArray($options);
                    $this->addElement($element);
                    break;
                case 'select':
                case 'radio':
                    $def_value = null != $field->getVar('field_default', 'e') ? $field->getVar('field_default') : null;
                    $element   = new XoopsFormSelect(\_AM_SUICO_DEFAULT, 'field_default', $def_value);
                    $options   = $field->getVar('field_options');
                    \asort($options);
                    // If options do not include an empty element, then add a blank option to prevent any default selection
                    //                if (!in_array('', array_keys($options))) {
                    if (!\array_key_exists('', $options)) {
                        $element->addOption('', \_NONE);
                    }
                    $element->addOptionArray($options);
                    $this->addElement($element);
                    break;
                case 'date':
                    $this->addElement(new XoopsFormTextDateSelect(\_AM_SUICO_DEFAULT, 'field_default', 15, $field->getVar('field_default', 'e')));
                    break;
                case 'longdate':
                    $this->addElement(new XoopsFormTextDateSelect(\_AM_SUICO_DEFAULT, 'field_default', 15, \strtotime($field->getVar('field_default', 'e'))));
                    break;
                case 'datetime':
                    $this->addElement(new \XoopsFormDateTime(\_AM_SUICO_DEFAULT, 'field_default', 15, $field->getVar('field_default', 'e')));
                    break;
                case 'yesno':
                    $this->addElement(new \XoopsFormRadioYN(\_AM_SUICO_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                    break;
                case 'timezone':
                    $this->addElement(new \XoopsFormSelectTimezone(\_AM_SUICO_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                    break;
                case 'language':
                    $this->addElement(new \XoopsFormSelectLang(\_AM_SUICO_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                    break;
                case 'group':
                    $this->addElement(new \XoopsFormSelectGroup(\_AM_SUICO_DEFAULT, 'field_default', true, $field->getVar('field_default', 'e')));
                    break;
                case 'group_multi':
                    $this->addElement(new \XoopsFormSelectGroup(\_AM_SUICO_DEFAULT, 'field_default', true, \unserialize($field->getVar('field_default', 'n')), 5, true));
                    break;
                case 'theme':
                    $this->addElement(new \XoopsFormSelectTheme(\_AM_SUICO_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                    break;
                case 'autotext':
                    $this->addElement(new XoopsFormTextArea(\_AM_SUICO_DEFAULT, 'field_default', $field->getVar('field_default', 'e')));
                    break;
            }
        }
        /* @var \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = \xoops_getHandler('groupperm');
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
        if (\in_array($field->getVar('field_type'), $searchable_types)) {
            $search_groups = $grouppermHandler->getGroupIds('profile_search', $field->getVar('field_id'), $GLOBALS['xoopsModule']->getVar('mid'));
            $this->addElement(new \XoopsFormSelectGroup(\_AM_SUICO_PROF_SEARCH, 'profile_search', true, $search_groups, 5, true));
        }
        if ($field->getVar('field_edit') || $field->isNew()) {
            $editable_groups = [];
            if (!$field->isNew()) {
                //Load groups
                $editable_groups = $grouppermHandler->getGroupIds('profile_edit', $field->getVar('field_id'), $GLOBALS['xoopsModule']->getVar('mid'));
            }
            $this->addElement(new \XoopsFormSelectGroup(\_AM_SUICO_PROF_EDITABLE, 'profile_edit', false, $editable_groups, 5, true));
            $this->addElement(new \XoopsFormRadioYN(\_AM_SUICO_REQUIRED, 'field_required', $field->getVar('field_required', 'e')));
            $regstep_select = new XoopsFormSelect(\_AM_SUICO_PROF_REGISTER, 'step_id', $field->getVar('step_id', 'e'));
            $regstep_select->addOption(0, \_NO);
            $regstepHandler = Helper::getInstance()->getHandler('Regstep');
            $regstep_select->addOptionArray($regstepHandler->getList());
            $this->addElement($regstep_select);
        }
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
