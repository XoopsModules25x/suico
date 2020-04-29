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
use XoopsFormDhtmlTextArea;
use XoopsFormEditor;
use XoopsFormElementTray;
use XoopsFormFile;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormSelect;
use XoopsFormSelectUser;
use XoopsFormText;
use XoopsLists;
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class GroupsForm
 */
class GroupsForm extends XoopsThemeForm
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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_GROUPS_ADD) : \sprintf(\AM_SUICO_GROUPS_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new XoopsFormHidden(
            'group_id', $this->targetObject->getVar(
            'group_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);
        // Group_id
        $this->addElement(
            new XoopsFormLabel(\AM_SUICO_GROUPS_GROUP_ID, $this->targetObject->getVar('group_id'), 'group_id')
        );
        // Owner_uid
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_GROUPS_OWNER_UID, 'owner_uid', false, $this->targetObject->getVar(
                'owner_uid'
            ), 1, false
            ),
            false
        );
        // Group_title
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_GROUPS_GROUP_TITLE, 'group_title', 50, 255, $this->targetObject->getVar(
                'group_title'
            )
            ),
            false
        );
        // Group_desc
        if (\class_exists('XoopsFormEditor')) {
            $editorOptions           = [];
            $editorOptions['name']   = 'group_desc';
            $editorOptions['value']  = $this->targetObject->getVar('group_desc', 'e');
            $editorOptions['rows']   = 5;
            $editorOptions['cols']   = 40;
            $editorOptions['width']  = '100%';
            $editorOptions['height'] = '400px';
            //$editorOptions['editor'] = xoops_getModuleOption('suico_editor', 'suico');
            //$this->addElement( new \XoopsFormEditor(AM_SUICO_GROUPS_GROUP_DESC, 'group_desc', $editorOptions), false  );
            if ($this->helper->isUserAdmin()) {
                $descEditor = new XoopsFormEditor(
                    \AM_SUICO_GROUPS_GROUP_DESC, $this->helper->getConfig(
                    'suicoEditorAdmin'
                ), $editorOptions, $nohtml = false, $onfailure = 'textarea'
                );
            } else {
                $descEditor = new XoopsFormEditor(
                    \AM_SUICO_GROUPS_GROUP_DESC, $this->helper->getConfig(
                    'suicoEditorUser'
                ), $editorOptions, $nohtml = false, $onfailure = 'textarea'
                );
            }
        } else {
            $descEditor = new XoopsFormDhtmlTextArea(
                \AM_SUICO_GROUPS_GROUP_DESC, 'description', $this->targetObject->getVar(
                'description',
                'e'
            ), 5, 50
            );
        }
        $this->addElement($descEditor);
        // Group_img
        $group_img   = $this->targetObject->getVar('group_img') ?: 'blank.png';
        $uploadDir   = '/uploads/suico/groups/';
        $imgtray     = new XoopsFormElementTray(\AM_SUICO_GROUPS_GROUP_IMG, '<br>');
        $imgpath     = \sprintf(\AM_SUICO_FORMIMAGE_PATH, $uploadDir);
        $imageselect = new XoopsFormSelect($imgpath, 'group_img', $group_img);
        $imageArray  = XoopsLists::getImgListAsArray(XOOPS_ROOT_PATH . $uploadDir);
        foreach ($imageArray as $image) {
            $imageselect->addOption($image, $image);
        }
        $imageselect->setExtra(
            "onchange='showImgSelected(\"image_group_img\", \"group_img\", \"" . $uploadDir . '", "", "' . XOOPS_URL . "\")'"
        );
        $imgtray->addElement($imageselect);
        $imgtray->addElement(
            new XoopsFormLabel(
                '', "<br><img src='" . XOOPS_URL . '/' . $uploadDir . '/' . $group_img . "' name='image_group_img' id='image_group_img' alt='' style='max-width:300px'>"
            )
        );
        $fileseltray = new XoopsFormElementTray('', '<br>');
        $fileseltray->addElement(
            new XoopsFormFile(\AM_SUICO_FORMUPLOAD, 'group_img', $this->helper->getConfig('maxsize'))
        );
        $fileseltray->addElement(new XoopsFormLabel(''));
        $imgtray->addElement($fileseltray);
        $this->addElement($imgtray);
        // Data_creation
        $this->addElement(
            new \XoopsFormTextDateSelect(
                \AM_SUICO_GROUPS_DATE_CREATED, 'date_created', 0, \formatTimestamp($this->targetObject->getVar('date_created'), 's')
            )
        );
        // Data_update
        $this->addElement(
            new \XoopsFormTextDateSelect(
                \AM_SUICO_GROUPS_DATE_UPDATED, 'date_updated', 0, \formatTimestamp($this->targetObject->getVar('date_updated'), 's')
            )
        );
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
