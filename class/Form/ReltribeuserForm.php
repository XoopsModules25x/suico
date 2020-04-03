<?php namespace XoopsModules\Yogurt\Form;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * Module: Yogurt
 *
 * @category        Module
 * @package         yogurt
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GPL 2.0 or later
 * @link            https://xoops.org/
 * @since           1.0.0
 */

use Xmf\Request;
use XoopsModules\Yogurt;

require_once dirname(dirname(__DIR__)) . '/include/common.php';

$moduleDirName = basename(dirname(dirname(__DIR__)));
//$helper = Yogurt\Helper::getInstance();
$permHelper = new \Xmf\Module\Helper\Permission();

xoops_load('XoopsFormLoader');

/**
 * Class ReltribeuserForm
 */
class ReltribeuserForm extends \XoopsThemeForm
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

        $title = $this->targetObject->isNew() ? sprintf(AM_YOGURT_RELTRIBEUSER_ADD) : sprintf(AM_YOGURT_RELTRIBEUSER_EDIT);
        parent::__construct($title, 'form', xoops_getenv('PHP_SELF'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new \XoopsFormHidden('rel_id', $this->targetObject->getVar('rel_id'));
        $this->addElement($hidden);
        unset($hidden);

        // Rel_id
        $this->addElement(new \XoopsFormLabel(AM_YOGURT_RELTRIBEUSER_REL_ID, $this->targetObject->getVar('rel_id'), 'rel_id'));
        // Rel_tribe_id
        //$tribesHandler = $this->helper->getHandler('Tribes');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $tribesHandler */
        $tribesHandler = $this->helper->getHandler('Tribes');

        $tribes_id_select = new \XoopsFormSelect(AM_YOGURT_RELTRIBEUSER_REL_TRIBE_ID, 'rel_tribe_id', $this->targetObject->getVar('rel_tribe_id'));
        $tribes_id_select->addOptionArray($tribesHandler->getList());
        $this->addElement($tribes_id_select, false);
        // Rel_user_uid
        $this->addElement(new \XoopsFormSelectUser(AM_YOGURT_RELTRIBEUSER_REL_USER_UID, 'rel_user_uid', false, $this->targetObject->getVar('rel_user_uid'), 1, false), false);

        $this->addElement(new \XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    }
}
