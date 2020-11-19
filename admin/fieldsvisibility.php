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
require_once __DIR__ . '/admin_header.php';
//there is no way to override current tabs when using system menu
//this dirty hack will have to do it
$_SERVER['REQUEST_URI'] = 'admin/fieldspermissions.php';
xoops_cp_header();
$op                = $_REQUEST['op'] ?? 'visibility';
$visibilityHandler = $helper->getHandler('Visibility');
$fieldHandler      = $helper->getHandler('Field');
$fields            = $fieldHandler->getList();
if (isset($_REQUEST['submit'])) {
    $visibility = $visibilityHandler->create();
    $visibility->setVar('field_id', $_REQUEST['field_id']);
    $visibility->setVar('user_group', $_REQUEST['ug']);
    $visibility->setVar('profile_group', $_REQUEST['pg']);
    $visibilityHandler->insert($visibility, true);
    redirect_header('fieldsvisibility.php', 2, sprintf(_AM_SUICO_SAVEDSUCCESS, _AM_SUICO_PROF_VISIBLE));
}
if ('del' === $op) {
    $criteria = new CriteriaCompo(new Criteria('field_id', (int)$_REQUEST['field_id']));
    $criteria->add(new Criteria('user_group', (int)$_REQUEST['ug']));
    $criteria->add(new Criteria('profile_group', (int)$_REQUEST['pg']));
    $visibilityHandler->deleteAll($criteria, true);
    redirect_header('fieldsvisibility.php', 2, sprintf(_AM_SUICO_DELETEDSUCCESS, _AM_SUICO_PROF_VISIBLE));
}
require_once $GLOBALS['xoops']->path('/class/xoopsformloader.php');
$opform    = new \XoopsSimpleForm('', 'opform', 'fieldspermissions.php', 'get');
$op_select = new \XoopsFormSelect('', 'op', $op);
$op_select->setExtra('onchange="document.forms.opform.submit()"');
$op_select->addOption('visibility', _AM_SUICO_PROF_VISIBLE);
$op_select->addOption('edit', _AM_SUICO_PROF_EDITABLE);
$op_select->addOption('search', _AM_SUICO_PROF_SEARCH);
$op_select->addOption('access', _AM_SUICO_PROF_ACCESS);
$opform->addElement($op_select);
$opform->display();
$criteria = new CriteriaCompo();
//$criteria->setGroupBy('field_id, user_group, profile_group');
$criteria->setSort('field_id, user_group, profile_group');
$criteria->setOrder('DESC');
$visibilities = $visibilityHandler->getAllByFieldId($criteria);
/* @var \XoopsMemberHandler $memberHandler */
$memberHandler = xoops_getHandler('member');
$groups        = $memberHandler->getGroupList();
$groups[0]     = _AM_SUICO_FIELDVISIBLETOALL;
asort($groups);
$GLOBALS['xoopsTpl']->assign('fields', $fields);
$GLOBALS['xoopsTpl']->assign('visibilities', $visibilities);
$GLOBALS['xoopsTpl']->assign('groups', $groups);
$add_form  = new \XoopsSimpleForm('', 'addform', 'fieldsvisibility.php');
$sel_field = new \XoopsFormSelect(_AM_SUICO_FIELDVISIBLE, 'field_id');
$sel_field->setExtra("style='width: 200px;'");
$sel_field->addOptionArray($fields);
$add_form->addElement($sel_field);
$sel_ug = new \XoopsFormSelect(_AM_SUICO_FIELDVISIBLEFOR, 'ug');
$sel_ug->addOptionArray($groups);
$add_form->addElement($sel_ug);
unset($groups[XOOPS_GROUP_ANONYMOUS]);
$sel_pg = new \XoopsFormSelect(_AM_SUICO_FIELDVISIBLEON, 'pg');
$sel_pg->addOptionArray($groups);
$add_form->addElement($sel_pg);
$add_form->addElement(new \XoopsFormButton('', 'submit', _ADD, 'submit'));
$add_form->assign($GLOBALS['xoopsTpl']);
$GLOBALS['xoopsTpl']->display('db:admin/suico_admin_fieldsvisibility.tpl');
require_once __DIR__ . '/admin_footer.php';
//xoops_cp_footer();
