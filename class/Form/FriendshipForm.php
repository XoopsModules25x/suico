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
 * Class FriendshipForm
 */
class FriendshipForm extends \XoopsThemeForm
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

        $title = $this->targetObject->isNew() ? sprintf(AM_YOGURT_FRIENDSHIP_ADD) : sprintf(AM_YOGURT_FRIENDSHIP_EDIT);
        parent::__construct($title, 'form', xoops_getenv('PHP_SELF'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new \XoopsFormHidden('friendship_id', $this->targetObject->getVar('friendship_id'));
        $this->addElement($hidden);
        unset($hidden);

        // Friendship_id
        $this->addElement(new \XoopsFormLabel(AM_YOGURT_FRIENDSHIP_FRIENDSHIP_ID, $this->targetObject->getVar('friendship_id'), 'friendship_id'));
        // Friend1_uid
        $this->addElement(new \XoopsFormSelectUser(AM_YOGURT_FRIENDSHIP_FRIEND1_UID, 'friend1_uid', false, $this->targetObject->getVar('friend1_uid'), 1, false), false);
        // Friend2_uid
        $this->addElement(new \XoopsFormSelectUser(AM_YOGURT_FRIENDSHIP_FRIEND2_UID, 'friend2_uid', false, $this->targetObject->getVar('friend2_uid'), 1, false), false);
        // Level
        $this->addElement(new \XoopsFormText(AM_YOGURT_FRIENDSHIP_LEVEL, 'level', 50, 255, $this->targetObject->getVar('level')), false);
        // Hot
        $this->addElement(new \XoopsFormText(AM_YOGURT_FRIENDSHIP_HOT, 'hot', 50, 255, $this->targetObject->getVar('hot')), false);
        // Trust
        $this->addElement(new \XoopsFormText(AM_YOGURT_FRIENDSHIP_TRUST, 'trust', 50, 255, $this->targetObject->getVar('trust')), false);
        // Cool
        $this->addElement(new \XoopsFormText(AM_YOGURT_FRIENDSHIP_COOL, 'cool', 50, 255, $this->targetObject->getVar('cool')), false);
        // Fan
        $this->addElement(new \XoopsFormText(AM_YOGURT_FRIENDSHIP_FAN, 'fan', 50, 255, $this->targetObject->getVar('fan')), false);

        $this->addElement(new \XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    }
}