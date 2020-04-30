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
use XoopsFormSelectUser;
use XoopsFormText;
use XoopsFormTextDateSelect;
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class VisitorsForm
 */
class VisitorsForm extends XoopsThemeForm
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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_VISITORS_ADD) : \sprintf(\AM_SUICO_VISITORS_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new XoopsFormHidden(
            'visit_id', $this->targetObject->getVar(
            'visit_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);
        // Cod_visit
        $this->addElement(
            new XoopsFormLabel(\AM_SUICO_VISITORS_VISIT_ID, $this->targetObject->getVar('visit_id'), 'visit_id')
        );
        // Uid_owner
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_VISITORS_UID_OWNER, 'uid_owner', false, $this->targetObject->getVar(
                'uid_owner'
            ), 1, false
            ),
            false
        );
        // Uid_visitor
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_VISITORS_UID_VISITOR, 'uid_visitor', false, $this->targetObject->getVar(
                'uid_visitor'
            ), 1, false
            ),
            false
        );
        // Uname_visitor
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_VISITORS_UNAME_VISITOR, 'uname_visitor', 50, 255, $this->targetObject->getVar(
                'uname_visitor'
            )
            ),
            false
        );
        // Datetime
        $this->addElement(
            new XoopsFormTextDateSelect(
                \AM_SUICO_VISITORS_DATETIME, 'date_visited', 0, \formatTimestamp($this->targetObject->getVar('date_visited'), 's')
            )
        );
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
