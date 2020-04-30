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
use XoopsFormTextArea;
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class VideoForm
 */
class VideoForm extends XoopsThemeForm
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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_VIDEO_ADD) : \sprintf(\AM_SUICO_VIDEO_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
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
            new XoopsFormLabel(\AM_SUICO_VIDEO_VIDEO_ID, $this->targetObject->getVar('video_id'), 'video_id')
        );
        // Uid_owner
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_VIDEO_UID_OWNER, 'uid_owner', false, $this->targetObject->getVar(
                'uid_owner'
            ), 1, false
            ),
            false
        );
        // Video Title
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_VIDEO_TITLE, 'video_title', 50, 255, $this->targetObject->getVar(
                'video_title'
            )
            ),
            false
        );
        // Video_desc
        $this->addElement(
            new XoopsFormTextArea(
                \AM_SUICO_VIDEO_VIDEO_DESC, 'video_desc', $this->targetObject->getVar(
                'video_desc'
            ), 4, 47
            ),
            false
        );
        // Youtube_code
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_VIDEO_YOUTUBE_CODE, 'youtube_code', 50, 255, $this->targetObject->getVar(
                'youtube_code'
            )
            ),
            false
        );
        // Main_video
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_VIDEO_MAIN_VIDEO, 'featured_video', 50, 255, $this->targetObject->getVar(
                'featured_video'
            )
            ),
            false
        );
        // Data_creation
        $this->addElement(new \XoopsFormTextDateSelect(\AM_SUICO_VIDEO_DATE_CREATED, 'date_created', 0, \formatTimestamp($this->targetObject->getVar('date_created'), 's')));
        $this->addElement(
            new \XoopsFormTextDateSelect(
                \AM_SUICO_VIDEO_DATE_UPDATED, 'date_updated', 0, \formatTimestamp($this->targetObject->getVar('date_updated'), 's')
            )
        );
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
