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
use XoopsModules\Suico;
use XoopsThemeForm;

require_once \dirname(__DIR__, 2) . '/include/common.php';
$moduleDirName = \basename(\dirname(__DIR__, 2));
//$helper = Suico\Helper::getInstance();
$permHelper = new Permission();
\xoops_load('XoopsFormLoader');

/**
 * Class ConfigsForm
 */
class ConfigsForm extends XoopsThemeForm
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
        $title              = $this->targetObject->isNew() ? \sprintf(\AM_SUICO_CONFIGS_ADD) : \sprintf(\AM_SUICO_CONFIGS_EDIT);
        parent::__construct($title, 'form', \xoops_getenv('SCRIPT_NAME'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');
        //include ID field, it's needed so the module knows if it is a new form or an edited form
        $hidden = new XoopsFormHidden(
            'config_id', $this->targetObject->getVar(
            'config_id'
        )
        );
        $this->addElement($hidden);
        unset($hidden);
        // Config_id
        $this->addElement(
            new XoopsFormLabel(\AM_SUICO_CONFIGS_CONFIG_ID, $this->targetObject->getVar('config_id'), 'config_id')
        );
        // Config_uid
        $this->addElement(
            new XoopsFormSelectUser(
                \AM_SUICO_CONFIGS_CONFIG_UID, 'config_uid', false, $this->targetObject->getVar(
                'config_uid'
            ), 1, false
            ),
            false
        );
        // Pictures
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_PICTURES, 'pictures', $this->targetObject->getVar('pictures'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Audio
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_AUDIO, 'audio', $this->targetObject->getVar('audio'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Videos
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_VIDEOS, 'videos', $this->targetObject->getVar('videos'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Groups
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_GROUPS, 'groups', $this->targetObject->getVar('groups'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Notes
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_NOTES, 'notes', $this->targetObject->getVar('notes'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Friends
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_FRIENDS, 'friends', $this->targetObject->getVar('friends'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Profile_contact
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_PROFILE_CONTACT, 'profile_contact', $this->targetObject->getVar('profile_contact'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Profile_general
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_PROFILE_GENERAL, 'profile_general', $this->targetObject->getVar('profile_general'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Profile_stats
        //$privacyHandler = $this->helper->getHandler('Privacy');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $privacyHandler */
        $privacyHandler    = $this->helper->getHandler('Privacy');
        $privacy_id_select = new \XoopsFormSelect(\AM_SUICO_CONFIGS_PROFILE_STATS, 'profile_stats', $this->targetObject->getVar('profile_stats'));
        $privacy_id_select->addOptionArray($privacyHandler->getList());
        $this->addElement($privacy_id_select, false);
        // Suspension
        $suspension       = $this->targetObject->isNew() ? 0 : $this->targetObject->getVar('suspension');
        $check_suspension = new \XoopsFormCheckBox(\AM_SUICO_CONFIGS_SUSPENSION, 'suspension', $suspension);
        $check_suspension->addOption(1, ' ');
        $this->addElement($check_suspension);
        // Backup_password
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_CONFIGS_BACKUP_PASSWORD, 'backup_password', 50, 255, $this->targetObject->getVar(
                'backup_password'
            )
            ),
            false
        );
        // Backup_email
        $this->addElement(
            new XoopsFormText(
                \AM_SUICO_CONFIGS_BACKUP_EMAIL, 'backup_email', 50, 255, $this->targetObject->getVar(
                'backup_email'
            )
            ),
            false
        );
        // End_suspension
        //        $this->addElement(new \XoopsFormDateTime(AM_SUICO_CONFIGS_END_SUSPENSION, 'end_suspension', '', \strtotime($this->targetObject->getVar('end_suspension'))));
        $endSuspension = $this->targetObject->isNew() ? 0 : $this->targetObject->getVar('end_suspension');
        $this->addElement(new \XoopsFormTextDateSelect(\AM_SUICO_CONFIGS_END_SUSPENSION, 'end_suspension', 0, $endSuspension), true);
        $this->addElement(new XoopsFormHidden('op', 'save'));
        $this->addElement(new XoopsFormButton('', 'submit', \_SUBMIT, 'submit'));
    }
}
