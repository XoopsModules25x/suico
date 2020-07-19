<?php

declare(strict_types=1);

namespace XoopsModules\Suico\Form;

use XoopsModules\Suico;
use XoopsModules\Suico\Regstep;
use XoopsThemeForm;
use XoopsFormButton;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormSelectUser;

/**
 *
 * @param Regstep $step {@link Regstep} to edit
 * @param bool    $action
 */
class StepForm extends XoopsThemeForm
{
    /**
     * StepForm constructor.
     * @param \XoopsModules\Suico\Regstep|null $step
     * @param bool                             $action
     */
    public function __construct(Regstep $step = null, $action = false)
    {
        if (!$action) {
            $action = $_SERVER['REQUEST_URI'];
        }
        if (empty($GLOBALS['xoopsConfigUser'])) {
            /* @var \XoopsConfigHandler $configHandler */
            $configHandler              = \xoops_getHandler('config');
            $GLOBALS['xoopsConfigUser'] = $configHandler->getConfigsByCat(\XOOPS_CONF_USER);
        }
        require_once $GLOBALS['xoops']->path('class/xoopsformloader.php');
        parent::__construct(\_AM_SUICO_STEP, 'stepform', 'step.php', 'post', true);
        if (!$step->isNew()) {
            $this->addElement(new XoopsFormHidden('id', $step->getVar('step_id')));
        }
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormText(\_AM_SUICO_STEPNAME, 'step_name', 25, 255, $step->getVar('step_name', 'e')));
        $this->addElement(new \XoopsFormText(\_AM_SUICO_STEPINTRO, 'step_desc', 25, 255, $step->getVar('step_desc', 'e')));
        $this->addElement(new \XoopsFormText(\_AM_SUICO_STEPORDER, 'step_order', 10, 10, $step->getVar('step_order', 'e')));
        $this->addElement(new \XoopsFormRadioYN(\_AM_SUICO_STEPSAVE, 'step_save', $step->getVar('step_save', 'e')));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
