<?php declare(strict_types=1);

namespace XoopsModules\Yogurt\Form;

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

use Xmf\Module\Helper\Permission;
use XoopsFormButton;
use XoopsFormDateTime;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormSelectUser;
use XoopsFormText;
use XoopsFormTextDateSelect;
use XoopsModules\Yogurt;
use XoopsThemeForm;

require_once dirname(dirname(__DIR__)) . '/include/common.php';

$moduleDirName = basename(dirname(dirname(__DIR__)));
//$helper = Yogurt\Helper::getInstance();
$permHelper = new Permission();

xoops_load('XoopsFormLoader');

/**
 * Class AudioForm
 */
class AudioForm extends XoopsThemeForm
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

        $title = $this->targetObject->isNew() ? sprintf(AM_YOGURT_AUDIO_ADD) : sprintf(AM_YOGURT_AUDIO_EDIT);
        parent::__construct($title, 'form', xoops_getenv('PHP_SELF'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new XoopsFormHidden(
            'audio_id', $this->targetObject->getVar(
            'audio_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);

        // Audio_id
        $this->addElement(
            new XoopsFormLabel(AM_YOGURT_AUDIO_AUDIO_ID, $this->targetObject->getVar('audio_id'), 'audio_id')
        );
        // Title
        $this->addElement(
            new XoopsFormText(AM_YOGURT_AUDIO_TITLE, 'title', 50, 255, $this->targetObject->getVar('title')),
            false
        );
        // Author
        $this->addElement(
            new XoopsFormText(AM_YOGURT_AUDIO_AUTHOR, 'author', 50, 255, $this->targetObject->getVar('author')),
            false
        );
        // Url
        $this->addElement(
            new XoopsFormText(AM_YOGURT_AUDIO_URL, 'url', 50, 255, $this->targetObject->getVar('url')),
            false
        );
        // Uid_owner
        $this->addElement(
            new XoopsFormSelectUser(
                AM_YOGURT_AUDIO_UID_OWNER, 'uid_owner', false, $this->targetObject->getVar(
                'uid_owner'
            ), 1, false
            ),
            false
        );
        // Data_creation
        $this->addElement(
            new XoopsFormTextDateSelect(
                AM_YOGURT_AUDIO_DATA_CREATION, 'data_creation', 0, strtotime(
                                                 $this->targetObject->getVar('data_creation')
                                             )
            )
        );
        // Data_update
        $this->addElement(
            new XoopsFormDateTime(
                AM_YOGURT_AUDIO_DATA_UPDATE, 'data_update', '', strtotime(
                                               $this->targetObject->getVar('data_update')
                                           )
            )
        );

        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    }
}
