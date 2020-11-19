<?php

declare(strict_types=1);

namespace XoopsModules\Suico\Form;

use XoopsModules\Suico;
use XoopsThemeForm;
use XoopsFormButton;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsModules\Suico\{
    Helper
};
/** @var Helper $helper */

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
class RegisterForm extends XoopsThemeForm
{
    /**
     * RegisterForm constructor.
     * @param \XoopsUser $user
     * @param            $profile
     * @param null       $step
     */
    public function __construct(\XoopsUser $user, $profile, $step = null)
    {
        global $opkey; // should be set in register.php
        if (empty($opkey)) {
            $opkey = 'profile_opname';
        }
        $next_opname      = 'op' . \mt_rand(10000, 99999);
        $_SESSION[$opkey] = $next_opname;
        require_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
        if (empty($GLOBALS['xoopsConfigUser'])) {
            /* @var \XoopsConfigHandler $configHandler */
            $configHandler              = \xoops_getHandler('config');
            $GLOBALS['xoopsConfigUser'] = $configHandler->getConfigsByCat(\XOOPS_CONF_USER);
        }
        $action    = $_SERVER['REQUEST_URI'];
        $step_no   = $step['step_no'];
        $use_token = $step['step_no'] > 0; // ? true : false;
        parent::__construct($step['step_name'], 'regform', $action, 'post', $use_token);
        if ($step['step_desc']) {
            $this->addElement(new XoopsFormLabel('', $step['step_desc']));
        }
        if (1 == $step_no) {
            //$uname_size = $GLOBALS['xoopsConfigUser']['maxuname'] < 35 ? $GLOBALS['xoopsConfigUser']['maxuname'] : 35;
            $elements[0][] = [
                'element'  => new \XoopsFormText(\_MD_SUICO_NICKNAME, 'uname', 35, $GLOBALS['xoopsConfigUser']['maxuname'], $user->getVar('uname', 'e')),
                'required' => true,
            ];
            $weights[0][]  = 0;
            $elements[0][] = ['element' => new \XoopsFormText(\_MD_SUICO_EMAILADDRESS, 'email', 35, 255, $user->getVar('email', 'e')), 'required' => true];
            $weights[0][]  = 0;
            $elements[0][] = ['element' => new \XoopsFormPassword(\_MD_SUICO_PASSWORD, 'pass', 35, 32, ''), 'required' => true];
            $weights[0][]  = 0;
            $elements[0][] = ['element' => new \XoopsFormPassword(\_US_VERIFYPASS, 'vpass', 35, 32, ''), 'required' => true];
            $weights[0][]  = 0;
        }
        // Dynamic fields
        $profileHandler               = Helper::getInstance()->getHandler('Profile');
        $fields                       = $profileHandler->loadFields();
        $_SESSION['profile_required'] = [];
        foreach (\array_keys($fields) as $i) {
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
        \ksort($elements);
        // Get categories
        $categoryHandler = \XoopsModules\Suico\Helper::getInstance()->getHandler('Category');
        $categories      = $categoryHandler->getObjects(null, true, false);
        foreach (\array_keys($elements) as $k) {
            \array_multisort($weights[$k], \SORT_ASC, \array_keys($elements[$k]), \SORT_ASC, $elements[$k]);
            //$title = isset($categories[$k]) ? $categories[$k]['cat_title'] : _MD_SUICO_DEFAULT;
            //$desc = isset($categories[$k]) ? $categories[$k]['cat_description'] : "";
            //$this->insertBreak("<p>{$title}</p>{$desc}");
            //$this->addElement(new XoopsFormLabel("<h2>".$title."</h2>", $desc), false);
            foreach (\array_keys($elements[$k]) as $i) {
                $this->addElement($elements[$k][$i]['element'], $elements[$k][$i]['required']);
            }
        }
        //end of Dynamic User fields
        if (1 == $step_no && 0 != $GLOBALS['xoopsConfigUser']['reg_dispdsclmr'] && '' != $GLOBALS['xoopsConfigUser']['reg_disclaimer']) {
            $disc_tray = new \XoopsFormElementTray(\_US_DISCLAIMER, '<br>');
            $disc_text = new \XoopsFormLabel('', '<div class="pad5">' . $GLOBALS['myts']->displayTarea($GLOBALS['xoopsConfigUser']['reg_disclaimer'], 1) . '</div>');
            $disc_tray->addElement($disc_text);
            $agree_chk = new \XoopsFormCheckBox('', 'agree_disc');
            $agree_chk->addOption(1, \_US_IAGREE);
            $disc_tray->addElement($agree_chk);
            $this->addElement($disc_tray);
        }
        global $xoopsModuleConfig;
        $useCaptchaAfterStep2 = $xoopsModuleConfig['profileCaptchaAfterStep1'] + 1;
        if ($step_no <= $useCaptchaAfterStep2) {
            $this->addElement(new \XoopsFormCaptcha(), true);
        }
        $this->addElement(new XoopsFormHidden($next_opname, 'register'));
        $this->addElement(new XoopsFormHidden('uid', $user->getVar('uid')));
        $this->addElement(new XoopsFormHidden('step', $step_no));
        $this->addElement(new XoopsFormButton('', 'submitButton', \_SUBMIT, 'submit'));
    }
}
