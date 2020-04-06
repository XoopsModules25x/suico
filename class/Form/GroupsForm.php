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
 * Class GroupsForm
 */
class GroupsForm extends \XoopsThemeForm
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

        $title = $this->targetObject->isNew() ? sprintf(AM_YOGURT_GROUPS_ADD) : sprintf(AM_YOGURT_GROUPS_EDIT);
        parent::__construct($title, 'form', xoops_getenv('PHP_SELF'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new \XoopsFormHidden('group_id', $this->targetObject->getVar('group_id'));
        $this->addElement($hidden);
        unset($hidden);

        // Group_id
        $this->addElement(new \XoopsFormLabel(AM_YOGURT_GROUPS_GROUP_ID, $this->targetObject->getVar('group_id'), 'group_id'));
        // Owner_uid
        $this->addElement(new \XoopsFormSelectUser(AM_YOGURT_GROUPS_OWNER_UID, 'owner_uid', false, $this->targetObject->getVar('owner_uid'), 1, false), false);
        // Group_title
        $this->addElement(new \XoopsFormText(AM_YOGURT_GROUPS_GROUP_TITLE, 'group_title', 50, 255, $this->targetObject->getVar('group_title')), false);
        // Group_desc
        if (class_exists('XoopsFormEditor')) {
            $editorOptions           = [];
            $editorOptions['name']   = 'group_desc';
            $editorOptions['value']  = $this->targetObject->getVar('group_desc', 'e');
            $editorOptions['rows']   = 5;
            $editorOptions['cols']   = 40;
            $editorOptions['width']  = '100%';
            $editorOptions['height'] = '400px';
            //$editorOptions['editor'] = xoops_getModuleOption('yogurt_editor', 'yogurt');
            //$this->addElement( new \XoopsFormEditor(AM_YOGURT_GROUPS_GROUP_DESC, 'group_desc', $editorOptions), false  );
            if ($this->helper->isUserAdmin()) {
                $descEditor = new \XoopsFormEditor(AM_YOGURT_GROUPS_GROUP_DESC, $this->helper->getConfig('yogurtEditorAdmin'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor(AM_YOGURT_GROUPS_GROUP_DESC, $this->helper->getConfig('yogurtEditorUser'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea(AM_YOGURT_GROUPS_GROUP_DESC, 'description', $this->targetObject->getVar('description', 'e'), 5, 50);
        }
        $this->addElement($descEditor);
        // Group_img
        $group_img = $this->targetObject->getVar('group_img') ?: 'blank.png';

        $uploadDir   = '/uploads/yogurt/groups/';
        $imgtray     = new \XoopsFormElementTray(AM_YOGURT_GROUPS_GROUP_IMG, '<br>');
        $imgpath     = sprintf(AM_YOGURT_FORMIMAGE_PATH, $uploadDir);
        $imageselect = new \XoopsFormSelect($imgpath, 'group_img', $group_img);
        $imageArray  = \XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $uploadDir);
        foreach ($imageArray as $image) {
            $imageselect->addOption((string)$image, $image);
        }
        $imageselect->setExtra("onchange='showImgSelected(\"image_group_img\", \"group_img\", \"" . $uploadDir . '", "", "' . XOOPS_URL . "\")'");
        $imgtray->addElement($imageselect);
        $imgtray->addElement(new \XoopsFormLabel('', "<br><img src='" . XOOPS_URL . '/' . $uploadDir . '/' . $group_img . "' name='image_group_img' id='image_group_img' alt='' style='max-width:300px' />"));
        $fileseltray = new \XoopsFormElementTray('', '<br>');
        $fileseltray->addElement(new \XoopsFormFile(AM_YOGURT_FORMUPLOAD, 'group_img', $this->helper->getConfig('maxsize')));
        $fileseltray->addElement(new \XoopsFormLabel(''));
        $imgtray->addElement($fileseltray);
        $this->addElement($imgtray);

        $this->addElement(new \XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    }
}
