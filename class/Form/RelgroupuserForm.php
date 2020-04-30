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
use XoopsFormSelect;
use XoopsFormSelectUser;
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class RelgroupuserForm
 */
class RelgroupuserForm extends XoopsThemeForm
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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_RELGROUPUSER_ADD) : \sprintf(
            \AM_SUICO_RELGROUPUSER_EDIT
        );
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new XoopsFormHidden(
            'rel_id', $this->targetObject->getVar(
            'rel_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);
        // Rel_id
        $this->addElement(
            new XoopsFormLabel(\AM_SUICO_RELGROUPUSER_REL_ID, $this->targetObject->getVar('rel_id'), 'rel_id')
        );
        // Rel_group_id
        //$groupsHandler = $this->helper->getHandler('Groups');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $groupsHandler */
        $groupsHandler    = $this->helper->getHandler('Groups');
        $groups_id_select = new XoopsFormSelect(
            \AM_SUICO_RELGROUPUSER_REL_GROUP_ID, 'rel_group_id', $this->targetObject->getVar(
            'rel_group_id'
        )
        );
        $groups_id_select->addOptionArray($groupsHandler->getList());
        $this->addElement($groups_id_select, false);
        // Rel_user_uid
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_RELGROUPUSER_REL_USER_UID, 'rel_user_uid', false, $this->targetObject->getVar(
                'rel_user_uid'
            ), 1, false
            ),
            false
        );
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
