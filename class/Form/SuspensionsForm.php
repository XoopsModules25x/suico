<?php

declare(strict_types=1);

namespace XoopsModules\Suico\Form;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @category        Module
 * @package         suico
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use Xmf\Module\Helper\Permission;
use XoopsFormButton;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormText;
use XoopsFormTextArea;
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class SuspensionsForm
 */
class SuspensionsForm extends XoopsThemeForm
{
    public $targetObject;
    public $helper;

    /**
     * Constructor
     *
     * @param $target
     */
    public function __construct($target)
    {
        $this->helper       = $target->helper;
        $this->targetObject = $target;
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_SUSPENSIONS_ADD) : \sprintf(
            \AM_SUICO_SUSPENSIONS_EDIT
        );
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new XoopsFormHidden(
            'uid', $this->targetObject->getVar(
            'uid'
        )
        );
        $this->addElement($hidden);
        unset($hidden);
        // Uid
        $this->addElement(
            new XoopsFormLabel(\AM_SUICO_SUSPENSIONS_UID, $this->targetObject->getVar('uid'), 'uid')
        );
        // Old_pass
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_SUSPENSIONS_OLD_PASS, 'old_pass', 50, 255, $this->targetObject->getVar(
                'old_pass'
            )
            ),
            false
        );
        // Old_email
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_SUSPENSIONS_OLD_EMAIL, 'old_email', 50, 255, $this->targetObject->getVar(
                'old_email'
            )
            ),
            false
        );
        // Old_signature
        $this->addElement(
            new XoopsFormTextArea(
                \AM_SUICO_SUSPENSIONS_OLD_SIGNATURE, 'old_signature', $this->targetObject->getVar(
                'old_signature'
            ), 4, 47
            ),
            false
        );
        // Suspension_time
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_SUSPENSIONS_SUSPENSION_TIME, 'suspension_time', 50, 255, $this->targetObject->getVar(
                'suspension_time'
            )
            ),
            false
        );
        // Old_enc_type
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_SUSPENSIONS_OLD_ENC_TYPE, 'old_enc_type', 50, 255, $this->targetObject->getVar(
                'old_enc_type'
            )
            ),
            false
        );
        // Old_pass_expired
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_SUSPENSIONS_OLD_PASS_EXPIRED, 'old_pass_expired', 50, 255, $this->targetObject->getVar(
                'old_pass_expired'
            )
            ),
            false
        );
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
