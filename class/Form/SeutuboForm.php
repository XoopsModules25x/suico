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
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormSelectUser;
use XoopsFormText;
use XoopsFormTextArea;
use XoopsModules\Yogurt;
use XoopsThemeForm;

require_once dirname(dirname(__DIR__)) . '/include/common.php';

$moduleDirName = basename(dirname(dirname(__DIR__)));
//$helper = Yogurt\Helper::getInstance();
$permHelper = new Permission();

xoops_load('XoopsFormLoader');

/**
 * Class SeutuboForm
 */
class SeutuboForm extends XoopsThemeForm
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

        $title = $this->targetObject->isNew() ? sprintf(AM_YOGURT_SEUTUBO_ADD) : sprintf(AM_YOGURT_SEUTUBO_EDIT);
        parent::__construct($title, 'form', xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new XoopsFormHidden(
            'video_id', $this->targetObject->getVar(
            'video_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);

        // Video_id
        $this->addElement(
            new XoopsFormLabel(AM_YOGURT_SEUTUBO_VIDEO_ID, $this->targetObject->getVar('video_id'), 'video_id')
        );
        // Uid_owner
        $this->addElement(
            new XoopsFormSelectUser(
                AM_YOGURT_SEUTUBO_UID_OWNER, 'uid_owner', false, $this->targetObject->getVar(
                'uid_owner'
            ), 1, false
            ),
            false
        );
        // Video_desc
        $this->addElement(
            new XoopsFormTextArea(
                AM_YOGURT_SEUTUBO_VIDEO_DESC, 'video_desc', $this->targetObject->getVar(
                'video_desc'
            ), 4, 47
            ),
            false
        );
        // Youtube_code
        $this->addElement(
            new XoopsFormText(
                AM_YOGURT_SEUTUBO_YOUTUBE_CODE, 'youtube_code', 50, 255, $this->targetObject->getVar(
                'youtube_code'
            )
            ),
            false
        );
        // Main_video
        $this->addElement(
            new XoopsFormText(
                AM_YOGURT_SEUTUBO_MAIN_VIDEO, 'main_video', 50, 255, $this->targetObject->getVar(
                'main_video'
            )
            ),
            false
        );

        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    }
}
