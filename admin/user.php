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

use XoopsModules\Suico\{
    Form\UserForm,
    Profile,
    ProfileHandler
};

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject->addItemButton(_AM_SUICO_ADDUSER, 'user.php?op=new', 'add');
$adminObject->displayNavigation(basename(__FILE__));
$adminObject->displayButton('left');
$op = $_REQUEST['op'] ?? 'list';
if ('editordelete' === $op) {
    $op = isset($_REQUEST['delete']) ? 'delete' : 'edit';
}
/* @var \XoopsMemberHandler $memberHandler */
$memberHandler = xoops_getHandler('member');
switch ($op) {
    default:
    case 'list':
        require_once $GLOBALS['xoops']->path('/class/xoopsformloader.php');
        $form    = new \XoopsThemeForm(_AM_SUICO_EDITUSER, 'form', 'user.php');
        $lastUid = \Xmf\Request::getInt('lastuid', null, 'GET');
        $form->addElement(new \XoopsFormSelectUser(_AM_SUICO_SELECTUSER, 'id', false, $lastUid));
        $form->addElement(new \XoopsFormHidden('op', 'editordelete'));
        $button_tray = new \XoopsFormElementTray('');
        $button_tray->addElement(new \XoopsFormButton('', 'edit', _EDIT, 'submit'));
        $button_tray->addElement(new \XoopsFormButton('', 'delete', _DELETE, 'submit'));
        $form->addElement($button_tray);
        $form->display();
        break;
    case 'new':
        xoops_loadLanguage('main', $GLOBALS['xoopsModule']->getVar('dirname', 'n'));
        $obj = $memberHandler->createUser();
        $obj->setGroups([XOOPS_GROUP_USERS]);
        $form = new UserForm($obj);
        $form->display();
        break;
    case 'edit':
        xoops_loadLanguage('main', $GLOBALS['xoopsModule']->getVar('dirname', 'n'));
        $obj = $memberHandler->getUser($_REQUEST['id']);
        if (in_array(XOOPS_GROUP_ADMIN, $obj->getGroups()) && !in_array(XOOPS_GROUP_ADMIN, $GLOBALS['xoopsUser']->getGroups())) {
            // If not webmaster trying to edit a webmaster - disallow
            redirect_header('user.php', 3, _US_NOEDITRIGHT);
        }
        $form = new UserForm($obj);
        $form->display();
        break;
    case 'save':
        xoops_loadLanguage('main', $GLOBALS['xoopsModule']->getVar('dirname', 'n'));
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('user.php', 3, _US_NOEDITRIGHT . '<br>' . implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
            exit;
        }
        // Dynamic fields
        /* @var  ProfileHandler $profileHandler */
        $profileHandler = $helper->getHandler('Profile');
        // Get fields
        $fields     = $profileHandler->loadFields();
        $userfields = $profileHandler->getUserVars();
        // Get ids of fields that can be edited
        /* @var  \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = xoops_getHandler('groupperm');
        $editable_fields  = $grouppermHandler->getItemIds('profile_edit', $GLOBALS['xoopsUser']->getGroups(), $GLOBALS['xoopsModule']->getVar('mid'));
        $uid              = empty($_POST['uid']) ? 0 : (int)$_POST['uid'];
        if (!empty($uid)) {
            $user    = $memberHandler->getUser($uid);
            /** @var Profile $profile */
            $profile = $profileHandler->get($uid);
            if (!is_object($profile)) {
                $profile = $profileHandler->create();
                $profile->setVar('profile_id', $uid);
            }
        } else {
            $user    = $memberHandler->createUser();
            $profile = $profileHandler->create();
            if (count($fields) > 0) {
                foreach (array_keys($fields) as $i) {
                    $fieldname = $fields[$i]->getVar('field_name');
                    if (in_array($fieldname, $userfields)) {
                        $default = $fields[$i]->getVar('field_default');
                        if ('' === $default || null === $default) {
                            continue;
                        }
                        $user->setVar($fieldname, $default);
                    }
                }
            }
            $user->setVar('user_regdate', time());
            $user->setVar('level', 1);
            $user->setVar('user_avatar', 'avatars/blank.gif');
        }
        $myts = \MyTextSanitizer::getInstance();
        $user->setVar('uname', $_POST['uname']);
        $user->setVar('email', trim($_POST['email']));
        if (isset($_POST['level']) && $user->getVar('level') != (int)$_POST['level']) {
            $user->setVar('level', (int)$_POST['level']);
        }
        $password = $vpass = null;
        if (!empty($_POST['password'])) {
            $password = Request::getString('password', '', 'POST');
            $vpass    = Request::getString('vpass', '', 'POST');
            $user->setVar('pass', password_hash($password, PASSWORD_DEFAULT));
        } elseif ($user->isNew()) {
            $password = $vpass = '';
        }
        xoops_load('xoopsuserutility');
        $stop   = XoopsUserUtility::validate($user, $password, $vpass);
        $errors = [];
        if ('' != $stop) {
            $errors[] = $stop;
        }
        foreach (array_keys($fields) as $i) {
            $fieldname = $fields[$i]->getVar('field_name');
            if (in_array($fields[$i]->getVar('field_id'), $editable_fields) && isset($_REQUEST[$fieldname])) {
                if (in_array($fieldname, $userfields)) {
                    $value = $fields[$i]->getValueForSave($_REQUEST[$fieldname], $user->getVar($fieldname, 'n'));
                    $user->setVar($fieldname, $value);
                } else {
                    $value = $fields[$i]->getValueForSave(($_REQUEST[$fieldname] ?? ''), $profile->getVar($fieldname, 'n'));
                    $profile->setVar($fieldname, $value);
                }
            }
        }
        $new_groups = $_POST['groups'] ?? [];
        if (0 == count($errors)) {
            if ($memberHandler->insertUser($user)) {
                $profile->setVar('profile_id', $user->getVar('uid'));
                $profileHandler->insert($profile);
                require_once $GLOBALS['xoops']->path('/modules/system/constants.php');
                if ($grouppermHandler->checkRight('system_admin', XOOPS_SYSTEM_GROUP, $GLOBALS['xoopsUser']->getGroups(), 1)) {
                    //Update group memberships
                    $cur_groups     = $user->getGroups();
                    $added_groups   = array_diff($new_groups, $cur_groups);
                    $removed_groups = array_diff($cur_groups, $new_groups);
                    if (count($added_groups) > 0) {
                        foreach ($added_groups as $groupid) {
                            $memberHandler->addUserToGroup($groupid, $user->getVar('uid'));
                        }
                    }
                    if (count($removed_groups) > 0) {
                        foreach ($removed_groups as $groupid) {
                            $memberHandler->removeUsersFromGroup($groupid, [$user->getVar('uid')]);
                        }
                    }
                }
                XoopsLoad::load('XoopsCache');
                $queryCache = XoopsCache::delete('formselectuser');
                if ($user->isNew()) {
                    redirect_header('user.php?lastuid=' . $user->getVar('uid'), 2, _AM_SUICO_USERCREATED, false);
                } else {
                    redirect_header('user.php?lastuid=' . $user->getVar('uid'), 2, _US_PROFUPDATED, false);
                }
            }
        } else {
            foreach ($errors as $err) {
                $user->setErrors($err);
            }
        }
        $user->setGroups($new_groups);
        echo $user->getHtmlErrors();
        $form = new UserForm($user, $profile);
        $form->display();
        break;
    case 'delete':
        if ($_REQUEST['id'] == $GLOBALS['xoopsUser']->getVar('uid')) {
            redirect_header('user.php', 2, _AM_SUICO_CANNOTDELETESELF);
        }
        $obj    = $memberHandler->getUser($_REQUEST['id']);
        $groups = $obj->getGroups();
        if (in_array(XOOPS_GROUP_ADMIN, $groups)) {
            redirect_header('user.php', 3, _AM_SUICO_CANNOTDELETEADMIN, false);
        }
        if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('user.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()), false);
            }
            $profileHandler = $helper->getHandler('Profile');
            $profile        = $profileHandler->get($obj->getVar('uid'));
            if (!$profile || $profile->isNew() || $profileHandler->delete($profile)) {
                if ($memberHandler->deleteUser($obj)) {
                    redirect_header('user.php', 3, sprintf(_AM_SUICO_DELETEDSUCCESS, $obj->getVar('uname') . ' (' . $obj->getVar('email') . ')'), false);
                } else {
                    echo $obj->getHtmlErrors();
                }
            } else {
                echo $profile->getHtmlErrors();
            }
        } else {
            xoops_confirm(
                [
                    'ok' => 1,
                    'id' => $_REQUEST['id'],
                    'op' => 'delete',
                ],
                $_SERVER['REQUEST_URI'],
                sprintf(_AM_SUICO_RUSUREDEL, $obj->getVar('uname') . ' (' . $obj->getVar('email') . ')')
            );
        }
        break;
}
require_once __DIR__ . '/admin_footer.php';
//xoops_cp_footer();
