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
use XoopsFormTextDateSelect;
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class ImagesForm
 */
class ImagesForm extends XoopsThemeForm
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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_IMAGES_ADD) : \sprintf(\AM_SUICO_IMAGES_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new XoopsFormHidden(
            'image_id', $this->targetObject->getVar(
            'image_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);
        // image_id
        $this->addElement(
            new XoopsFormLabel(\AM_SUICO_IMAGES_IMAGE_ID, $this->targetObject->getVar('image_id'), 'image_id')
        );
        // Title
        $this->addElement(
            new XoopsFormText(\AM_SUICO_IMAGES_TITLE, 'title', 50, 255, $this->targetObject->getVar('title')),
            false
        );
        // Caption
        $this->addElement(
            new XoopsFormText(\AM_SUICO_IMAGES_CAPTION, 'caption', 50, 255, $this->targetObject->getVar('caption')),
            false
        );
        // Data_creation
        $this->addElement(
            new XoopsFormTextDateSelect(
                \AM_SUICO_IMAGES_DATE_CREATED, 'date_created', 0, \formatTimestamp($this->targetObject->getVar('date_created'), 's')
            )
        );
        // Data_update
        $this->addElement(
            new XoopsFormTextDateSelect(
                \AM_SUICO_IMAGES_DATE_UPDATED, 'date_updated', 0, \formatTimestamp($this->targetObject->getVar('date_updated'), 's')
            )
        );
        // Uid_owner
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_IMAGES_UID_OWNER, 'uid_owner', false, $this->targetObject->getVar(
                'uid_owner'
            ), 1, false
            ),
            false
        );
        // Url
        //        $this->addElement(
        //            new XoopsFormTextArea(AM_SUICO_IMAGES_URL, 'filename', $this->targetObject->getVar('filename'), 4, 47),
        //            false
        //        );
        $filename    = $this->targetObject->getVar('filename') ?: 'blank.png';
        $uploadDir   = '/uploads/suico/images/';
        $imgtray     = new \XoopsFormElementTray(\AM_SUICO_IMAGES_URL, '<br>');
        $imgpath     = \sprintf(\AM_SUICO_FORMIMAGE_PATH, $uploadDir);
        $imageselect = new \XoopsFormSelect($imgpath, 'filename', $filename);
        $imageArray  = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $uploadDir);
        foreach ($imageArray as $image) {
            $imageselect->addOption($image, $image);
        }
        $imageselect->setExtra("onchange='showImgSelected(\"image_url\", \"filename\", \"" . $uploadDir . '", "", "' . XOOPS_URL . "\")'");
        $imgtray->addElement($imageselect);
        $imgtray->addElement(new \XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $uploadDir . '/' . $url . "' name='image_url' id='image_url' alt='' style='max-width:300px'>"));
        $fileseltray = new \XoopsFormElementTray('', '<br>');
        $fileseltray->addElement(new \XoopsFormFile(\AM_SUICO_FORMUPLOAD, 'filename', $this->helper->getConfig('maxsize')));
        $fileseltray->addElement(new \XoopsFormLabel(''));
        $imgtray->addElement($fileseltray);
        $this->addElement($imgtray);
        // Private
        //        $this->addElement(
        //            new XoopsFormText(AM_SUICO_IMAGES_PRIVATE, 'private', 50, 255, $this->targetObject->getVar('private')),
        //            false
        //        );
        $private       = $this->targetObject->isNew() ? 0 : $this->targetObject->getVar('private');
        $check_private = new \XoopsFormCheckBox(\AM_SUICO_IMAGES_PRIVATE, 'private', $private);
        $check_private->addOption(1, ' ');
        $this->addElement($check_private);
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
