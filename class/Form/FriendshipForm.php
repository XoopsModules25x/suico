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
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class FriendshipForm
 */
class FriendshipForm extends XoopsThemeForm
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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_FRIENDSHIP_ADD) : \sprintf(
            \AM_SUICO_FRIENDSHIP_EDIT
        );
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new XoopsFormHidden(
            'friendship_id', $this->targetObject->getVar(
            'friendship_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);
        // Friendship_id
        $this->addElement(
            new XoopsFormLabel(
                \AM_SUICO_FRIENDSHIP_FRIENDSHIP_ID, $this->targetObject->getVar(
                'friendship_id'
            ), 'friendship_id'
            )
        );
        // Friend1_uid
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_FRIENDSHIP_FRIEND1_UID, 'friend1_uid', false, $this->targetObject->getVar(
                'friend1_uid'
            ), 1, false
            ),
            false
        );
        // Friend2_uid
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_FRIENDSHIP_FRIEND2_UID, 'friend2_uid', false, $this->targetObject->getVar(
                'friend2_uid'
            ), 1, false
            ),
            false
        );
        // Level
        $this->addElement(
            new XoopsFormText(\AM_SUICO_FRIENDSHIP_LEVEL, 'level', 50, 255, $this->targetObject->getVar('level')),
            false
        );
        // Hot
        $this->addElement(
            new XoopsFormText(\AM_SUICO_FRIENDSHIP_HOT, 'hot', 50, 255, $this->targetObject->getVar('hot')),
            false
        );
        // Trust
        $this->addElement(
            new XoopsFormText(\AM_SUICO_FRIENDSHIP_TRUST, 'trust', 50, 255, $this->targetObject->getVar('trust')),
            false
        );
        // Cool
        $this->addElement(
            new XoopsFormText(\AM_SUICO_FRIENDSHIP_COOL, 'cool', 50, 255, $this->targetObject->getVar('cool')),
            false
        );
        // Fan
        $this->addElement(
            new XoopsFormText(\AM_SUICO_FRIENDSHIP_FAN, 'fan', 50, 255, $this->targetObject->getVar('fan')),
            false
        );
        // Data_creation
        $this->addElement(
            new \XoopsFormTextDateSelect(
                \AM_SUICO_FRIENDSHIP_DATE_CREATED, 'date_created', 0, \formatTimestamp($this->targetObject->getVar('date_created'), 's')
            )
        );
        $this->addElement(
            new \XoopsFormTextDateSelect(
                \AM_SUICO_FRIENDSHIP_DATE_UPDATED, 'date_updated', 0, \formatTimestamp($this->targetObject->getVar('date_updated'), 's')
            )
        );
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
