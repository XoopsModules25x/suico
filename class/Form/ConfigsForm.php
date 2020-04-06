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
 * Class ConfigsForm
 */
class ConfigsForm extends \XoopsThemeForm
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

        $title = $this->targetObject->isNew() ? sprintf(AM_YOGURT_CONFIGS_ADD) : sprintf(AM_YOGURT_CONFIGS_EDIT);
        parent::__construct($title, 'form', xoops_getenv('PHP_SELF'), 'post', true);
        $this->setExtra('enctype="multipart/form-data"');

        //include ID field, it's needed so the module knows if it is a new form or an edited form

        $hidden = new \XoopsFormHidden('config_id', $this->targetObject->getVar('config_id'));
        $this->addElement($hidden);
        unset($hidden);

        // Config_id
        $this->addElement(new \XoopsFormLabel(AM_YOGURT_CONFIGS_CONFIG_ID, $this->targetObject->getVar('config_id'), 'config_id'));
        // Config_uid
        $this->addElement(new \XoopsFormSelectUser(AM_YOGURT_CONFIGS_CONFIG_UID, 'config_uid', false, $this->targetObject->getVar('config_uid'), 1, false), false);
        // Pictures
        //$imagesHandler = $this->helper->getHandler('Images');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $imagesHandler */
        $imagesHandler = $this->helper->getHandler('Images');

        $images_id_select = new \XoopsFormSelect(AM_YOGURT_CONFIGS_PICTURES, 'pictures', $this->targetObject->getVar('pictures'));
        $images_id_select->addOptionArray($imagesHandler->getList());
        $this->addElement($images_id_select, false);
        // Audio
        //$audioHandler = $this->helper->getHandler('Audio');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $audioHandler */
        $audioHandler = $this->helper->getHandler('Audio');

        $audio_id_select = new \XoopsFormSelect(AM_YOGURT_CONFIGS_AUDIO, 'audio', $this->targetObject->getVar('audio'));
        $audio_id_select->addOptionArray($audioHandler->getList());
        $this->addElement($audio_id_select, false);
        // Videos
        //$videoHandler = $this->helper->getHandler('Seutubo');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $videoHandler */
        $videoHandler = $this->helper->getHandler('Video');

        $video_id_select = new \XoopsFormSelect(AM_YOGURT_CONFIGS_VIDEOS, 'videos', $this->targetObject->getVar('videos'));
        $video_id_select->addOptionArray($videoHandler->getList());
        $this->addElement($video_id_select, false);
        // Groups
        //$groupsHandler = $this->helper->getHandler('Groups');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $groupsHandler */
        $groupsHandler = $this->helper->getHandler('Groups');

        $groups_id_select = new \XoopsFormSelect(AM_YOGURT_CONFIGS_GROUPS, 'groups', $this->targetObject->getVar('groups'));
        $groups_id_select->addOptionArray($groupsHandler->getList());
        $this->addElement($groups_id_select, false);
        // Notes
        //$notesHandler = $this->helper->getHandler('Notes');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $notesHandler */
        $notesHandler = $this->helper->getHandler('Notes');

        $notes_id_select = new \XoopsFormSelect(AM_YOGURT_CONFIGS_NOTES, 'notes', $this->targetObject->getVar('notes'));
        $notes_id_select->addOptionArray($notesHandler->getList());
        $this->addElement($notes_id_select, false);
        // Friends
        //$friendshipHandler = $this->helper->getHandler('Friendship');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $friendshipHandler */
        $friendshipHandler = $this->helper->getHandler('Friendship');

        $friendship_id_select = new \XoopsFormSelect(AM_YOGURT_CONFIGS_FRIENDS, 'friends', $this->targetObject->getVar('friends'));
        $friendship_id_select->addOptionArray($friendshipHandler->getList());
        $this->addElement($friendship_id_select, false);
        // Profile_contact
        $this->addElement(new \XoopsFormSelectUser(AM_YOGURT_CONFIGS_PROFILE_CONTACT, 'profile_contact', false, $this->targetObject->getVar('profile_contact'), 1, false), false);
        // Profile_general
        $this->addElement(new \XoopsFormSelectUser(AM_YOGURT_CONFIGS_PROFILE_GENERAL, 'profile_general', false, $this->targetObject->getVar('profile_general'), 1, false), false);
        // Profile_stats
        $this->addElement(new \XoopsFormSelectUser(AM_YOGURT_CONFIGS_PROFILE_STATS, 'profile_stats', false, $this->targetObject->getVar('profile_stats'), 1, false), false);
        // Suspension
        //$suspensionsHandler = $this->helper->getHandler('Suspensions');
        //$db     = \XoopsDatabaseFactory::getDatabaseConnection();
        /** @var \XoopsPersistableObjectHandler $suspensionsHandler */
        $suspensionsHandler = $this->helper->getHandler('Suspensions');

        $suspensions_id_select = new \XoopsFormSelect(AM_YOGURT_CONFIGS_SUSPENSION, 'suspension', $this->targetObject->getVar('suspension'));
        $suspensions_id_select->addOptionArray($suspensionsHandler->getList());
        $this->addElement($suspensions_id_select, false);
        // Backup_password
        $this->addElement(new \XoopsFormText(AM_YOGURT_CONFIGS_BACKUP_PASSWORD, 'backup_password', 50, 255, $this->targetObject->getVar('backup_password')), false);
        // Backup_email
        $this->addElement(new \XoopsFormText(AM_YOGURT_CONFIGS_BACKUP_EMAIL, 'backup_email', 50, 255, $this->targetObject->getVar('backup_email')), false);
        // End_suspension
        $this->addElement(new \XoopsFormTextDateSelect(AM_YOGURT_CONFIGS_END_SUSPENSION, 'end_suspension', 0, strtotime($this->targetObject->getVar('end_suspension'))));

        $this->addElement(new \XoopsFormHidden('op', 'save'));
        $this->addElement(new \XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
    }
}
