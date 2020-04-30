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

use XoopsModules\Suico;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new \Xmf\Module\Helper\Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class PrivacyForm
 */
class PrivacyForm extends \XoopsThemeForm
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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_PRIVACY_ADD) : \sprintf(\AM_SUICO_PRIVACY_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('PHP_SELF'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new \XoopsFormHidden('id', $this->targetObject->getVar('id'));
        $this->addElement($hidden);
        unset($hidden);
        // Id
        $this->addElement(new \XoopsFormLabel(\AM_SUICO_PRIVACY_ID, $this->targetObject->getVar('id'), 'id'));
        // Level
        $this->addElement(new \XoopsFormText(\AM_SUICO_PRIVACY_LEVEL, 'level', 50, 255, $this->targetObject->getVar('level')), false);
        // Name
        $this->addElement(new \XoopsFormText(\AM_SUICO_PRIVACY_NAME, 'name', 50, 255, $this->targetObject->getVar('name')), false);
        // Description
        if (\class_exists('XoopsFormEditor')) {
            $editorOptions           = [];
            $editorOptions['name']   = 'description';
            $editorOptions['value']  = $this->targetObject->getVar('description', 'e');
            $editorOptions['rows']   = 5;
            $editorOptions['cols']   = 40;
            $editorOptions['width']  = '100%';
            $editorOptions['height'] = '400px';
            //$editorOptions['editor'] = xoops_getModuleOption('suico_editor', 'suico');
            //$this->addElement( new \XoopsFormEditor(AM_SUICO_PRIVACY_DESCRIPTION, 'description', $editorOptions), false  );
            if ($this->helper->isUserAdmin()) {
                $descEditor = new \XoopsFormEditor(\AM_SUICO_PRIVACY_DESCRIPTION, $this->helper->getConfig('suicoEditorAdmin'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            } else {
                $descEditor = new \XoopsFormEditor(\AM_SUICO_PRIVACY_DESCRIPTION, $this->helper->getConfig('suicoEditorUser'), $editorOptions, $nohtml = false, $onfailure = 'textarea');
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea(\AM_SUICO_PRIVACY_DESCRIPTION, 'description', $this->targetObject->getVar('description', 'e'), 5, 50);
        }
        $this->addElement($descEditor);
        $this->addElement(new \XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
