<?php

namespace XoopsModules\Yogurt;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Marcello Brandão aka  Suico
 * @author       XOOPS Development Team
 * @since
 */
require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/criteria.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
/**
 * Module classes
 */
//require_once __DIR__ . '/Image.php';
//require_once __DIR__ . '/yogurt_visitors.php';
//require_once __DIR__ . '/Video.php';
//require_once __DIR__ . '/yogurt_audio.php';
//require_once __DIR__ . '/Friendpetition.php';
//require_once __DIR__ . '/Friendship.php';
//require_once __DIR__ . '/Reltribeuser.php';
//require_once __DIR__ . '/Tribes.php';
//require_once __DIR__ . '/Notes.php';
//require_once __DIR__ . '/Configs.php';
//require_once __DIR__ . '/Suspensions.php';
if (str_replace('.', '', PHP_VERSION) > 499) {
    require_once __DIR__ . '/class.Id3v1.php';
}

/**
 * Class ControllerNotes
 */
class ControllerNotes extends YogurtController
{
    //  function renderFormNewPost($tpl){
    //
    //
    //
    //      $form = new XoopsThemeForm("",'formNoteNew','submitNote.php','post',true);
    //      $fieldNote = new XoopsFormTextArea('','text',_MD_YOGURT_ENTERTEXTNOTE);
    //      $fieldNote->setExtra(' onclick="cleanNoteForm(text,\''._MD_YOGURT_ENTERTEXTNOTE.'\')"');
    //
    //
    //      $fieldScrabookUid = new XoopsFormHidden ("uid", $this->uidOwner);
    //
    //      $submitButton = new XoopsFormButton("","post_Note",_MD_YOGURT_SENDNOTE,"submit");
    //
    //      $form->addElement($fieldScrabookUid);
    //      $form->addElement($fieldNote,true);
    //      $form->addElement($submitButton);
    //
    //      //$form->display();
    //      $form->assign($tpl);
    //  }

    /**
     * @param $nb_Notes
     * @param $criteria
     * @return bool
     */
    public function fecthNotes($nb_Notes, $criteria)
    {
        $Notes = $this->NotesFactory->getNotes($nb_Notes, $criteria);
        if ($Notes) {
            return $Notes;
        }

        return false;
    }

    /**
     * @param string $privilegeType
     * @return bool|void
     */
    public function checkPrivilege($privilegeType = '')
    {
        global $xoopsModuleConfig;
        if (0 == $xoopsModuleConfig['enable_notes']) {
            redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, _MD_YOGURT_NOTESNOTENABLED);
        }
        if ('sendNotes' == $privilegeType) {
            $criteria = new \Criteria('config_uid', $this->owner->getVar('uid'));
            if (1 == $this->configsFactory->getCount($criteria)) {
                $configs = $this->configsFactory->getObjects($criteria);

                $config = $configs[0]->getVar('sendNotes');
            }
        }
        $criteria = new \Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configsFactory->getCount($criteria)) {
            $configs = $this->configsFactory->getObjects($criteria);

            $config = $configs[0]->getVar('Notes');

            if (!$this->checkPrivilegeLevel($config)) {
                redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
            }
        }

        return true;
    }
}
