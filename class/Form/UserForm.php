<?php

declare(strict_types=1);

namespace XoopsModules\Suico\Form;

use XoopsModules\Suico;
use XoopsModules\Suico\Profile;
use XoopsModules\Suico\ProfileHandler;
use XoopsThemeForm;
use XoopsFormButton;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormSelectUser;

/**
 * Get {@link XoopsThemeForm} for editing a user
 *
 * @param \XoopsUser $user {@link \XoopsUser} to edit
 * @param Profile    $profile
 * @param bool       $action
 *
 */
class UserForm extends XoopsThemeForm
{
    /**
     * UserForm constructor.
     * @param \XoopsUser                       $user
     * @param \XoopsModules\Suico\Profile|null $profile
     * @param bool                             $action
     */
    public function __construct(\XoopsUser $user, Profile $profile = null, $action = false)
    {
        $helper = \XoopsModules\Suico\Helper::getInstance();
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        if (empty($GLOBALS['xoopsConfigUser'])) {
            /* @var \XoopsConfigHandler $configHandler */
            $configHandler              = \xoops_getHandler('config');
            $GLOBALS['xoopsConfigUser'] = $configHandler->getConfigsByCat(\XOOPS_CONF_USER);
        }
        require_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
        $title = $user->isNew() ? \_AM_SUICO_ADDUSER : \_US_EDITPROFILE;
        parent::__construct($title, 'userinfo', $action, 'post', true);
        /* @var ProfileHandler $profileHandler */
        $profileHandler = \XoopsModules\Suico\Helper::getInstance()->getHandler('Profile');
        // Dynamic fields
        if (!$profile) {
            /* @var ProfileHandler $profileHandler */
            $profileHandler = \XoopsModules\Suico\Helper::getInstance()->getHandler('Profile');
            $profile        = $profileHandler->get($user->getVar('uid'));
        }
        // Get fields
        $fields = $profileHandler->loadFields();
        // Get ids of fields that can be edited
        /* @var  \XoopsGroupPermHandler $grouppermHandler */
        $grouppermHandler = \xoops_getHandler('groupperm');
        $editable_fields  = $grouppermHandler->getItemIds('profile_edit', $GLOBALS['xoopsUser']->getGroups(), $GLOBALS['xoopsModule']->getVar('mid'));
        if ($user->isNew() || $GLOBALS['xoopsUser']->isAdmin()) {
            $elements[0][] = [
                'element'  => new \XoopsFormText(\_MD_SUICO_NICKNAME, 'uname', 25, $GLOBALS['xoopsUser']->isAdmin() ? 60 : $GLOBALS['xoopsConfigUser']['maxuname'], $user->getVar('uname', 'e')),
                'required' => 1,
            ];
            $email_text    = new \XoopsFormText('', 'email', 30, 60, $user->getVar('email'));
        } else {
            $elements[0][] = ['element' => new XoopsFormLabel(\_MD_SUICO_NICKNAME, $user->getVar('uname')), 'required' => 0];
            $email_text    = new XoopsFormLabel('', $user->getVar('email'));
        }
        $email_tray = new \XoopsFormElementTray(\_MD_SUICO_EMAILADDRESS, '<br>');
        $email_tray->addElement($email_text, ($user->isNew() || $GLOBALS['xoopsUser']->isAdmin()) ? 1 : 0);
        $weights[0][]  = 0;
        $elements[0][] = ['element' => $email_tray, 'required' => 0];
        $weights[0][]  = 0;
        if ($GLOBALS['xoopsUser']->isAdmin() && $user->getVar('uid') != $GLOBALS['xoopsUser']->getVar('uid')) {
            //If the user is an admin and is editing someone else
            $pwd_text  = new \XoopsFormPassword('', 'password', 10, 32);
            $pwd_text2 = new \XoopsFormPassword('', 'vpass', 10, 32);
            $pwd_tray  = new \XoopsFormElementTray(\_MD_SUICO_PASSWORD . '<br>' . \_MD_SUICO_CONFIRMPASSWORD);
            $pwd_tray->addElement($pwd_text);
            $pwd_tray->addElement($pwd_text2);
            $elements[0][] = ['element' => $pwd_tray, 'required' => 0]; //cannot set an element tray required
            $weights[0][]  = 0;
            $level_radio   = new \XoopsFormRadio(\_MD_SUICO_USERLEVEL, 'level', $user->getVar('level'));
            $level_radio->addOption(1, \_MD_SUICO_ACTIVE);
            $level_radio->addOption(0, \_MD_SUICO_INACTIVE);
            //$level_radio->addOption(-1, _MD_SUICO_DISABLED);
            $elements[0][] = ['element' => $level_radio, 'required' => 0];
            $weights[0][]  = 0;
        }
        $elements[0][]   = ['element' => new XoopsFormHidden('uid', $user->getVar('uid')), 'required' => 0];
        $weights[0][]    = 0;
        $elements[0][]   = ['element' => new XoopsFormHidden('op', 'save'), 'required' => 0];
        $weights[0][]    = 0;
        $categoryHandler = \XoopsModules\Suico\Helper::getInstance()->getHandler('Category');
        $categories      = [];
        $all_categories  = $categoryHandler->getObjects(null, true, false);
        $count_fields    = \count($fields);
        foreach (\array_keys($fields) as $i) {
            if (\in_array($fields[$i]->getVar('field_id'), $editable_fields)) {
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
                $key                   = @$all_categories[$fields[$i]->getVar('cat_id')]['cat_weight'] * $count_fields + $fields[$i]->getVar('cat_id');
                $elements[$key][]      = $fieldinfo;
                $weights[$key][]       = $fields[$i]->getVar('field_weight');
                $categories[$key]      = @$all_categories[$fields[$i]->getVar('cat_id')];
            }
        }
        if ($GLOBALS['xoopsUser'] && $GLOBALS['xoopsUser']->isAdmin()) {
            \xoops_loadLanguage('admin', 'profile');
            /* @var  \XoopsGroupPermHandler $grouppermHandler */
            $grouppermHandler = \xoops_getHandler('groupperm');
            //If user has admin rights on groups
            require_once $GLOBALS['xoops']->path('modules/system/constants.php');
            if ($grouppermHandler->checkRight('system_admin', \XOOPS_SYSTEM_GROUP, $GLOBALS['xoopsUser']->getGroups(), 1)) {
                //add group selection
                $group_select  = new \XoopsFormSelectGroup(\_MD_SUICO_USERGROUPS, 'groups', false, $user->getGroups(), 5, true);
                $elements[0][] = ['element' => $group_select, 'required' => 0];
                //set as latest;
                $weights[0][] = $count_fields + 1;
            }
        }
        \ksort($elements);
        foreach (\array_keys($elements) as $k) {
            \array_multisort($weights[$k], \SORT_ASC, \array_keys($elements[$k]), \SORT_ASC, $elements[$k]);
            $title = isset($categories[$k]) ? $categories[$k]['cat_title'] : \_MD_SUICO_DEFAULT;
            $desc  = isset($categories[$k]) ? $categories[$k]['cat_description'] : '';
            $this->addElement(new XoopsFormLabel("<h3>{$title}</h3>", $desc), false);
            foreach (\array_keys($elements[$k]) as $i) {
                $this->addElement($elements[$k][$i]['element'], $elements[$k][$i]['required']);
            }
        }
        $this->addElement(new XoopsFormHidden('uid', $user->getVar('uid')));
        $this->addElement(new XoopsFormButton('', 'submit', \_MD_SUICO_SAVECHANGES, 'submit'));
    }
}
