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
include_once XOOPS_ROOT_PATH . '/kernel/object.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/class/criteria.php';
include_once '../../class/pagenav.php';
/**
 * Module classes
 */
//include_once 'class/Image.php';
//include_once 'class/yogurt_visitors.php';
//include_once 'class/Seutubo.php';
//include_once 'class/yogurt_audio.php';
//include_once 'class/Friendpetition.php';
//include_once 'class/Friendship.php';
//include_once 'class/Reltribeuser.php';
//include_once 'class/Tribes.php';
//include_once 'class/Notes.php';
//include_once 'class/Configs.php';
//include_once 'class/Suspensions.php';
if (str_replace('.', '', PHP_VERSION) > 499) {
    include_once 'class/class.Id3v1.php';
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
    //      $form = new XoopsThemeForm("",'formNoteNew','submit_Note.php','post',true);
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
