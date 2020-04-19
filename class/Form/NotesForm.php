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
use XoopsFormCheckBox;
use XoopsFormDhtmlTextArea;
use XoopsFormEditor;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormSelectUser;
use XoopsFormTextDateSelect;
use XoopsModules\Yogurt;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';

$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Yogurt\Helper::getInstance();
$permHelper = new Permission();

\xoops_load('XoopsFormLoader');

/**
 * Class NotesForm
 */
class NotesForm extends XoopsThemeForm
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

        $title = $this->targetObject->isNew() ? \sprintf(AM_YOGURT_NOTES_ADD) : \sprintf(AM_YOGURT_NOTES_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new XoopsFormHidden(
            'note_id', $this->targetObject->getVar(
            'note_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);

        // Note_id
        $this->addElement(
            new XoopsFormLabel(AM_YOGURT_NOTES_NOTE_ID, $this->targetObject->getVar('note_id'), 'note_id')
        );
        // Note_text
        if (\class_exists('XoopsFormEditor')) {
            $editorOptions           = [];
            $editorOptions['name']   = 'note_text';
            $editorOptions['value']  = $this->targetObject->getVar('note_text', 'e');
            $editorOptions['rows']   = 5;
            $editorOptions['cols']   = 40;
            $editorOptions['width']  = '100%';
            $editorOptions['height'] = '400px';
            //$editorOptions['editor'] = xoops_getModuleOption('yogurt_editor', 'yogurt');
            //$this->addElement( new \XoopsFormEditor(AM_YOGURT_NOTES_NOTE_TEXT, 'note_text', $editorOptions), false  );
            if ($this->helper->isUserAdmin()) {
                $descEditor = new XoopsFormEditor(
                    AM_YOGURT_NOTES_NOTE_TEXT, $this->helper->getConfig(
                    'yogurtEditorAdmin'
                ), $editorOptions, $nohtml = false, $onfailure = 'textarea'
                );
            } else {
                $descEditor = new XoopsFormEditor(
                    AM_YOGURT_NOTES_NOTE_TEXT, $this->helper->getConfig(
                    'yogurtEditorUser'
                ), $editorOptions, $nohtml = false, $onfailure = 'textarea'
                );
            }
        } else {
            $descEditor = new XoopsFormDhtmlTextArea(
                AM_YOGURT_NOTES_NOTE_TEXT, 'description', $this->targetObject->getVar(
                'description',
                'e'
            ), 5, 50
            );
        }
        $this->addElement($descEditor);
        // Note_from
        $this->addElement(
            new XoopsFormSelectUser(
                AM_YOGURT_NOTES_NOTE_FROM, 'note_from', false, $this->targetObject->getVar(
                'note_from'
            ), 1, false
            ),
            false
        );
        // Note_to
        $this->addElement(
            new XoopsFormSelectUser(
                AM_YOGURT_NOTES_NOTE_TO, 'note_to', false, $this->targetObject->getVar(
                'note_to'
            ), 1, false
            ),
            false
        );
        // Private
        $private       = $this->targetObject->isNew() ? 0 : $this->targetObject->getVar('private');
        $check_private = new XoopsFormCheckBox(AM_YOGURT_NOTES_PRIVATE, 'private', $private);
        $check_private->addOption(1, ' ');
        $this->addElement($check_private);
        // Date
        $this->addElement(
            new XoopsFormTextDateSelect(
                AM_YOGURT_NOTES_DATE, 'date', 0, \strtotime(
                                        $this->targetObject->getVar('date')
                                    )
            )
        );

        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
