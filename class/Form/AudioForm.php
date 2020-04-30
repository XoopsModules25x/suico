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
use XoopsFormEditor;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormSelectUser;
use XoopsFormText;
use XoopsFormTextDateSelect;
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_AUDIO_ADD) : \sprintf(\AM_SUICO_AUDIO_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
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
            new XoopsFormLabel(\AM_SUICO_AUDIO_AUDIO_ID, $this->targetObject->getVar('audio_id'), 'audio_id')
        );
        // Uid_owner
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_AUDIO_UID_OWNER, 'uid_owner', false, $this->targetObject->getVar(
                'uid_owner'
            ), 1, false
            ),
            false
        );
        // Title
        $this->addElement(
            new XoopsFormText(\AM_SUICO_AUDIO_TITLE, 'title', 50, 255, $this->targetObject->getVar('title')),
            false
        );
        // Author
        $this->addElement(
            new XoopsFormText(\AM_SUICO_AUDIO_AUTHOR, 'author', 50, 255, $this->targetObject->getVar('author')),
            false
        );
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
            //$this->addElement( new \XoopsFormEditor(AM_SUICO_AUDIO_DESCRIPTION, 'description', $editorOptions), false  );
            if ($this->helper->isUserAdmin()) {
                $descEditor = new XoopsFormEditor(
                    \AM_SUICO_AUDIO_DESCRIPTION, $this->helper->getConfig(
                    'suicoEditorAdmin'
                ), $editorOptions, $nohtml = false, $onfailure = 'textarea'
                );
            } else {
                $descEditor = new XoopsFormEditor(
                    \AM_SUICO_AUDIO_DESCRIPTION, $this->helper->getConfig(
                    'suicoEditorUser'
                ), $editorOptions, $nohtml = false, $onfailure = 'textarea'
                );
            }
        } else {
            $descEditor = new \XoopsFormDhtmlTextArea(
                \AM_SUICO_AUDIO_DESCRIPTION, 'description', $this->targetObject->getVar(
                'description',
                'e'
            ), 5, 50
            );
        }
        $this->addElement($descEditor);
        // Url
        $this->addElement(new \XoopsFormFile(\AM_SUICO_AUDIO_URL, 'filename', $this->helper->getConfig('maxsize')), false);
        // Data_creation
        $this->addElement(
            new XoopsFormTextDateSelect(
                \AM_SUICO_AUDIO_DATE_CREATED, 'date_created', 0, \formatTimestamp($this->targetObject->getVar('date_created'), 's')
            )
        );
        $this->addElement(
            new XoopsFormTextDateSelect(
                \AM_SUICO_AUDIO_DATE_UPDATED, 'date_updated', 0, \formatTimestamp($this->targetObject->getVar('date_updated'), 's')
            )
        );
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
