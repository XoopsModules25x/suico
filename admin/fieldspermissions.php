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

use Xmf\Request;

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject->displayNavigation(basename(__FILE__));
$op        = Request::getCmd('op', 'edit');
$perm_desc = '';
switch ($op) {
    case 'visibility':
        //redirect_header("fieldsvisibility.php", 0, _AM_SUICO_PROF_VISIBLE);
        header('Location: fieldsvisibility.php');
        break;
    case 'edit':
        $title_of_form = _AM_SUICO_PROF_EDITABLE;
        $perm_name     = 'profile_edit';
        $restriction   = 'field_edit';
        $anonymous     = false;
        break;
    case 'search':
        $title_of_form = _AM_SUICO_PROF_SEARCH;
        $perm_name     = 'profile_search';
        $restriction   = '';
        $anonymous     = true;
        break;
    case 'access':
        $title_of_form = _AM_SUICO_PROF_ACCESS;
        $perm_name     = 'profile_access';
        $perm_desc     = _AM_SUICO_PROF_ACCESS_DESC;
        $restriction   = '';
        $anonymous     = true;
        break;
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
$module_id = $GLOBALS['xoopsModule']->getVar('mid');
require_once $GLOBALS['xoops']->path('/class/xoopsform/grouppermform.php');
$form = new \XoopsGroupPermForm($title_of_form, $module_id, $perm_name, $perm_desc, 'admin/fieldspermissions.php?op=' . $op, $anonymous);
if ('access' === $op) {
    /* @var XoopsMemberHandler $memberHandler */
    $memberHandler = xoops_getHandler('member');
    $glist         = $memberHandler->getGroupList();
    foreach (array_keys($glist) as $i) {
        if (XOOPS_GROUP_ANONYMOUS != $i) {
            $form->addItem($i, $glist[$i]);
        }
    }
} else {
    $profileHandler = $helper->getHandler('Profile');
    $fields         = $profileHandler->loadFields();
    if ('search' !== $op) {
        foreach (array_keys($fields) as $i) {
            if ('' == $restriction || $fields[$i]->getVar($restriction)) {
                $form->addItem($fields[$i]->getVar('field_id'), xoops_substr($fields[$i]->getVar('field_title'), 0, 25));
            }
        }
    } else {
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
            if (in_array($fields[$i]->getVar('field_type'), $searchable_types)) {
                $form->addItem($fields[$i]->getVar('field_id'), xoops_substr($fields[$i]->getVar('field_title'), 0, 25));
            }
        }
    }
}
$form->display();
require_once __DIR__ . '/admin_footer.php';
//xoops_cp_footer();
