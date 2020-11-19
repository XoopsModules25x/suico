<?php

declare(strict_types=1);

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
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package             profile
 * @since               2.3.0
 * @author              Jan Pedersen
 * @author              Taiwen Jiang <phppp@users.sourceforge.net>
 */

use XoopsModules\Suico\{CategoryHandler,
    Form\FieldForm,
    Field,
    FieldHandler
};

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject->addItemButton(_AM_SUICO_FIELD, 'fieldslist.php?op=new', 'add');
$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayButton('left');
$op = $_REQUEST['op'] ?? (isset($_REQUEST['id']) ? 'edit' : 'list');
/* @var FieldHandler $fieldHandler */
$fieldHandler = $helper->getHandler('Field');
switch ($op) {
    default:
    case 'list':
        $fields = $fieldHandler->getObjects(null, true, false);
        /* @var \XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $modules       = $moduleHandler->getObjects(null, true);
        /* @var CategoryHandler $categoryHandler */
        $categoryHandler = $helper->getHandler('Category');
        $criteria        = new \CriteriaCompo();
        $criteria->setSort('cat_weight');
        $cats = $categoryHandler->getObjects($criteria, true);
        unset($criteria);
        $categories[0] = _AM_SUICO_DEFAULT;
        if (count($cats) > 0) {
            foreach (array_keys($cats) as $i) {
                $categories[$cats[$i]->getVar('cat_id')] = $cats[$i]->getVar('cat_title');
            }
        }
        $GLOBALS['xoopsTpl']->assign('categories', $categories);
        unset($categories);
        $valuetypes = [
            XOBJ_DTYPE_ARRAY   => _AM_SUICO_ARRAY,
            XOBJ_DTYPE_EMAIL   => _AM_SUICO_EMAIL,
            XOBJ_DTYPE_INT     => _AM_SUICO_INT,
            XOBJ_DTYPE_TXTAREA => _AM_SUICO_TXTAREA,
            XOBJ_DTYPE_TXTBOX  => _AM_SUICO_TXTBOX,
            XOBJ_DTYPE_URL     => _AM_SUICO_URL,
            XOBJ_DTYPE_OTHER   => _AM_SUICO_OTHER,
            XOBJ_DTYPE_MTIME   => _AM_SUICO_DATE,
        ];
        $fieldtypes = [
            'checkbox'     => _AM_SUICO_CHECKBOX,
            'group'        => _AM_SUICO_GROUP,
            'group_multi'  => _AM_SUICO_GROUPMULTI,
            'language'     => _AM_SUICO_LANGUAGE,
            'radio'        => _AM_SUICO_RADIO,
            'select'       => _AM_SUICO_SELECT,
            'select_multi' => _AM_SUICO_SELECTMULTI,
            'textarea'     => _AM_SUICO_TEXTAREA,
            'dhtml'        => _AM_SUICO_DHTMLTEXTAREA,
            'textbox'      => _AM_SUICO_TEXTBOX,
            'timezone'     => _AM_SUICO_TIMEZONE,
            'yesno'        => _AM_SUICO_YESNO,
            'date'         => _AM_SUICO_DATE,
            'datetime'     => _AM_SUICO_DATETIME,
            'longdate'     => _AM_SUICO_LONGDATE,
            'theme'        => _AM_SUICO_THEME,
            'autotext'     => _AM_SUICO_AUTOTEXT,
            'rank'         => _AM_SUICO_RANK,
        ];
        foreach (array_keys($fields) as $i) {
            $fields[$i]['canEdit']               = $fields[$i]['field_config'] || $fields[$i]['field_show'] || $fields[$i]['field_edit'];
            $fields[$i]['canDelete']             = $fields[$i]['field_config'];
            $fields[$i]['fieldtype']             = $fieldtypes[$fields[$i]['field_type']];
            $fields[$i]['valuetype']             = $valuetypes[$fields[$i]['field_valuetype']];
            $categories[$fields[$i]['cat_id']][] = $fields[$i];
            $weights[$fields[$i]['cat_id']][]    = $fields[$i]['field_weight'];
        }
        //sort fields order in categories
        foreach (array_keys($categories) as $i) {
            array_multisort($weights[$i], SORT_ASC, array_keys($categories[$i]), SORT_ASC, $categories[$i]);
        }
        ksort($categories);
        $GLOBALS['xoopsTpl']->assign('fieldcategories', $categories);
        $GLOBALS['xoopsTpl']->assign('token', $GLOBALS['xoopsSecurity']->getTokenHTML());
        $template_main = 'admin/suico_admin_fieldslist.tpl';
        break;
    case 'new':
        /** @var Field $obj */
        $obj  = $fieldHandler->create();
        $form = new FieldForm($obj);
        $form->display();
        break;
    case 'edit':
        $obj = $fieldHandler->get($_REQUEST['id']);
        if (!$obj->getVar('field_config') && !$obj->getVar('field_show') && !$obj->getVar('field_edit')) { //If no configs exist
            redirect_header('fieldslist.php', 2, _AM_SUICO_FIELDNOTCONFIGURABLE);
        }
        $form = new FieldForm($obj);
        $form->display();
        break;
    case 'reorder':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('fieldslist.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        if (isset($_POST['field_ids']) && count($_POST['field_ids']) > 0) {
            $oldweight = $_POST['oldweight'];
            $oldcat    = $_POST['oldcat'];
            $category  = $_POST['category'];
            $weight    = $_POST['weight'];
            $ids       = [];
            foreach ($_POST['field_ids'] as $field_id) {
                if ($oldweight[$field_id] != $weight[$field_id] || $oldcat[$field_id] != $category[$field_id]) {
                    //if field has changed
                    $ids[] = (int)$field_id;
                }
            }
            if (count($ids) > 0) {
                $errors = [];
                //if there are changed fields, fetch the fieldcategory objects
                /* @var FieldHandler $fieldHandler */
                $fieldHandler = $helper->getHandler('Field');
                $fields       = $fieldHandler->getObjects(new \Criteria('field_id', '(' . implode(',', $ids) . ')', 'IN'), true);
                foreach ($ids as $i) {
                    $fields[$i]->setVar('field_weight', (int)$weight[$i]);
                    $fields[$i]->setVar('cat_id', (int)$category[$i]);
                    if (!$fieldHandler->insert($fields[$i])) {
                        $errors = array_merge($errors, $fields[$i]->getErrors());
                    }
                }
                if (0 == count($errors)) {
                    //no errors
                    redirect_header('fieldslist.php', 2, sprintf(_AM_SUICO_SAVEDSUCCESS, _AM_SUICO_FIELDS));
                } else {
                    redirect_header('fieldslist.php', 3, implode('<br>', $errors));
                }
            }
        }
        break;
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('fieldslist.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $redirect_to_edit = false;
        if (isset($_REQUEST['id'])) {
            $obj = $fieldHandler->get($_REQUEST['id']);
            if (!$obj->getVar('field_config') && !$obj->getVar('field_show') && !$obj->getVar('field_edit')) { //If no configs exist
                redirect_header('admin.php', 2, _AM_SUICO_FIELDNOTCONFIGURABLE);
            }
        } else {
            $obj = $fieldHandler->create();
            $obj->setVar('field_name', $_REQUEST['field_name']);
            $obj->setVar('field_moduleid', $GLOBALS['xoopsModule']->getVar('mid'));
            $obj->setVar('field_show', 1);
            $obj->setVar('field_edit', 1);
            $obj->setVar('field_config', 1);
            $redirect_to_edit = true;
        }
        $obj->setVar('field_title', $_REQUEST['field_title']);
        $obj->setVar('field_description', $_REQUEST['field_description']);
        if ($obj->getVar('field_config')) {
            $obj->setVar('field_type', $_REQUEST['field_type']);
            if (isset($_REQUEST['field_valuetype'])) {
                $obj->setVar('field_valuetype', $_REQUEST['field_valuetype']);
            }
            $options = $obj->getVar('field_options');
            if (isset($_REQUEST['removeOptions']) && is_array($_REQUEST['removeOptions'])) {
                foreach ($_REQUEST['removeOptions'] as $index) {
                    unset($options[$index]);
                }
                $redirect_to_edit = true;
            }
            if (!empty($_REQUEST['addOption'])) {
                foreach ($_REQUEST['addOption'] as $option) {
                    if (empty($option['value'])) {
                        continue;
                    }
                    $options[$option['key']] = $option['value'];
                    $redirect_to_edit        = true;
                }
            }
            $obj->setVar('field_options', $options);
        }
        if ($obj->getVar('field_edit')) {
            $required = $_REQUEST['field_required'] ?? 0;
            $obj->setVar('field_required', $required); //0 = no, 1 = yes
            if (isset($_REQUEST['field_maxlength'])) {
                $obj->setVar('field_maxlength', $_REQUEST['field_maxlength']);
            }
            if (isset($_REQUEST['field_default'])) {
                $field_default = $obj->getValueForSave($_REQUEST['field_default']);
                //Check for multiple selections
                if (is_array($field_default)) {
                    $obj->setVar('field_default', serialize($field_default));
                } else {
                    $obj->setVar('field_default', $field_default);
                }
            }
        }
        if ($obj->getVar('field_show')) {
            $obj->setVar('field_weight', $_REQUEST['field_weight']);
            $obj->setVar('cat_id', $_REQUEST['field_category']);
        }
        if (/*$obj->getVar('field_edit') && */
        isset($_REQUEST['step_id'])) {
            $obj->setVar('step_id', $_REQUEST['step_id']);
        }
        if ($fieldHandler->insert($obj)) {
            /* @var \XoopsGroupPermHandler $grouppermHandler */
            $grouppermHandler = xoops_getHandler('groupperm');
            $perm_arr         = [];
            if ($obj->getVar('field_show')) {
                $perm_arr[] = 'profile_show';
                $perm_arr[] = 'profile_visible';
            }
            if ($obj->getVar('field_edit')) {
                $perm_arr[] = 'profile_edit';
            }
            if ($obj->getVar('field_edit') || $obj->getVar('field_show')) {
                $perm_arr[] = 'profile_search';
            }
            if (count($perm_arr) > 0) {
                foreach ($perm_arr as $perm) {
                    $criteria = new \CriteriaCompo(new \Criteria('gperm_name', $perm));
                    $criteria->add(new \Criteria('gperm_itemid', (int)$obj->getVar('field_id')));
                    $criteria->add(new \Criteria('gperm_modid', (int)$GLOBALS['xoopsModule']->getVar('mid')));
                    if (isset($_REQUEST[$perm]) && is_array($_REQUEST[$perm])) {
                        $perms = $grouppermHandler->getObjects($criteria);
                        if (count($perms) > 0) {
                            foreach (array_keys($perms) as $i) {
                                $groups[$perms[$i]->getVar('gperm_groupid')] = &$perms[$i];
                            }
                        } else {
                            $groups = [];
                        }
                        foreach ($_REQUEST[$perm] as $groupid) {
                            $groupid = (int)$groupid;
                            if (!isset($groups[$groupid])) {
                                $perm_obj = $grouppermHandler->create();
                                $perm_obj->setVar('gperm_name', $perm);
                                $perm_obj->setVar('gperm_itemid', (int)$obj->getVar('field_id'));
                                $perm_obj->setVar('gperm_modid', $GLOBALS['xoopsModule']->getVar('mid'));
                                $perm_obj->setVar('gperm_groupid', $groupid);
                                $grouppermHandler->insert($perm_obj);
                                unset($perm_obj);
                            }
                        }
                        $removed_groups = array_diff(array_keys($groups), $_REQUEST[$perm]);
                        if (count($removed_groups) > 0) {
                            $criteria->add(new \Criteria('gperm_groupid', '(' . implode(',', $removed_groups) . ')', 'IN'));
                            $grouppermHandler->deleteAll($criteria);
                        }
                        unset($groups);
                    } else {
                        $grouppermHandler->deleteAll($criteria);
                    }
                    unset($criteria);
                }
            }
            $url = $redirect_to_edit ? 'fieldslist.php?op=edit&amp;id=' . $obj->getVar('field_id') : 'fieldslist.php';
            redirect_header($url, 3, sprintf(_AM_SUICO_SAVEDSUCCESS, _AM_SUICO_FIELD));
        }
        echo $obj->getHtmlErrors();
        $form = new FieldForm($obj);
        $form->display();
        break;
    case 'delete':
        $obj = $fieldHandler->get($_REQUEST['id']);
        if (!$obj->getVar('field_config')) {
            redirect_header('index.php', 2, _AM_SUICO_FIELDNOTCONFIGURABLE);
        }
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('fieldslist.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            if ($fieldHandler->delete($obj)) {
                redirect_header('fieldslist.php', 3, sprintf(_AM_SUICO_DELETEDSUCCESS, _AM_SUICO_FIELD));
            } else {
                echo $obj->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok' => 1,
                    'id' => $_REQUEST['id'],
                    'op' => 'delete',
                ],
                $_SERVER['REQUEST_URI'],
                sprintf(_AM_SUICO_RUSUREDEL, $obj->getVar('field_title'))
            );
        }
        break;
    case 'toggle':
        if (isset($_REQUEST['field_id'])) {
            $field_id = (int)$_REQUEST['field_id'];
            if (isset($_REQUEST['field_required'])) {
                $field_required = (int)$_REQUEST['field_required'];
                suico_visible_toggle($field_id, $field_required, $helper);
            }
        }
        break;
}
if (isset($template_main)) {
    $GLOBALS['xoopsTpl']->display("db:{$template_main}");
}
/**
 * @param $field_id
 * @param $field_required
 * @param $helper
 */
function suico_visible_toggle($field_id, $field_required, $helper)
{
    $field_required = (1 == $field_required) ? 0 : 1;
    /** @var FieldHandler $fieldHandler */
    $fieldHandler = $helper->getHandler('Field');
    $obj          = $fieldHandler->get($field_id);
    $obj->setVar('field_required', $field_required);
    if ($fieldHandler->insert($obj, true)) {
        redirect_header('fieldslist.php', 1, _AM_SUICO_REQUIRED_TOGGLE_SUCCESS);
    } else {
        redirect_header('fieldslist.php', 1, _AM_SUICO_REQUIRED_TOGGLE_FAILED);
    }
}

require_once __DIR__ . '/admin_footer.php';
