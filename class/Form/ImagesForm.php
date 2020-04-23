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
use XoopsFormTextDateSelect;
use XoopsModules\Yogurt;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';

$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Yogurt\Helper::getInstance();
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

        $title = $this->targetObject->isNew() ? \sprintf(AM_YOGURT_IMAGES_ADD) : \sprintf(AM_YOGURT_IMAGES_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new XoopsFormHidden(
            'cod_img',
            $this->targetObject->getVar(
            'cod_img'
        )
        );
        $this->addElement($hidden);
        unset($hidden);

        // Cod_img
        $this->addElement(
            new XoopsFormLabel(AM_YOGURT_IMAGES_COD_IMG, $this->targetObject->getVar('cod_img'), 'cod_img')
        );
        // Title
        $this->addElement(
            new XoopsFormText(AM_YOGURT_IMAGES_TITLE, 'title', 50, 255, $this->targetObject->getVar('title')),
            false
        );
        // Data_creation
        $this->addElement(
            new XoopsFormTextDateSelect(
                AM_YOGURT_IMAGES_DATA_CREATION, 'data_creation', 0, formatTimeStamp($this->targetObject->getVar('data_creation'), 's')
            )
        );
        // Data_update
        $this->addElement(
            new XoopsFormTextDateSelect(
                AM_YOGURT_IMAGES_DATA_UPDATE, 'data_update', 0, formatTimeStamp($this->targetObject->getVar('data_update'), 's')
            )
        );
        // Uid_owner
        $this->addElement(
            new XoopsFormSelectUser(
                AM_YOGURT_IMAGES_UID_OWNER, 'uid_owner', false, $this->targetObject->getVar(
                'uid_owner'
            ), 1, false
            ),
            false
        );
        // Url
        //        $this->addElement(
        //            new XoopsFormTextArea(AM_YOGURT_IMAGES_URL, 'url', $this->targetObject->getVar('url'), 4, 47),
        //            false
        //        );

        $url = $this->targetObject->getVar('url') ?: 'blank.png';

        $uploadDir   = '/uploads/yogurt/images/';
        $imgtray     = new \XoopsFormElementTray(AM_YOGURT_IMAGES_URL, '<br>');
        $imgpath     = \sprintf(AM_YOGURT_FORMIMAGE_PATH, $uploadDir);
        $imageselect = new \XoopsFormSelect($imgpath, 'url', $url);
        $imageArray  = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $uploadDir);
        foreach ($imageArray as $image) {
            $imageselect->addOption($image, $image);
        }
        $imageselect->setExtra("onchange='showImgSelected(\"image_url\", \"url\", \"" . $uploadDir . '", "", "' . XOOPS_URL . "\")'");
        $imgtray->addElement($imageselect);
        $imgtray->addElement(new \XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $uploadDir . '/' . $url . "' name='image_url' id='image_url' alt='' style='max-width:300px'>"));
        $fileseltray = new \XoopsFormElementTray('', '<br>');
        $fileseltray->addElement(new \XoopsFormFile(AM_YOGURT_FORMUPLOAD, 'url', $this->helper->getConfig('maxsize')));
        $fileseltray->addElement(new \XoopsFormLabel(''));
        $imgtray->addElement($fileseltray);
        $this->addElement($imgtray);
        // Private
        //        $this->addElement(
        //            new XoopsFormText(AM_YOGURT_IMAGES_PRIVATE, 'private', 50, 255, $this->targetObject->getVar('private')),
        //            false
        //        );

        $private       = $this->targetObject->isNew() ? 0 : $this->targetObject->getVar('private');
        $check_private = new \XoopsFormCheckBox(AM_YOGURT_IMAGES_PRIVATE, 'private', $private);
        $check_private->addOption(1, ' ');
        $this->addElement($check_private);

        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
