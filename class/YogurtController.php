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
//require_once __DIR__ . '/Visitors.php';
//require_once __DIR__ . '/Video.php';
//require_once __DIR__ . '/Audio.php';
//require_once __DIR__ . '/Friendpetition.php';
//require_once __DIR__ . '/Friendship.php';
//require_once __DIR__ . '/Relgroupuser.php';
//require_once __DIR__ . '/Groups.php';
//require_once __DIR__ . '/Notes.php';
//require_once __DIR__ . '/Configs.php';
//require_once __DIR__ . '/Suspensions.php';
if (str_replace('.', '', PHP_VERSION) > 499) {
    require_once __DIR__ . '/Id3v1.php';
}

/**
 * Class YogurtController
 */
class YogurtController extends \XoopsObject
{
    public $db;
    public $user;
    public $isOwner;
    public $isUser;
    public $isAnonym;
    public $isFriend;
    public $uidOwner;
    public $nameOwner;
    public $owner;
    public $imageFactory;
    public $visitorsFactory;
    public $audioFactory;
    public $videosFactory;
    public $petitionsFactory;
    public $friendshipsFactory;
    public $relgroupusersFactory;
    public $suspensionsFactory;
    public $groupsFactory;
    public $notesFactory;
    public $configsFactory;
    public $section;
    public $privilegeLevel;
    public $isSuspended;

    /**
     * Constructor
     *
     * @param \XoopsDatabase $db
     * @param                $user
     */
    public function __construct(\XoopsDatabase $db, $user)
    {
        $this->db       = $db;
        $this->user     = $user;
        $this->isOwner  = 0;
        $this->isAnonym = 1;
        $this->isFriend = 0;
        $this->isUser   = 0;
        $this->createFactories();
        $this->getPermissions();
        $this->checkPrivilege('');
        $this->checkSuspension();
    }

    public function checkSuspension()
    {
        $criteria_suspended = new \Criteria('uid', $this->uidOwner);
        if (1 == $this->isSuspended) {
            $suspensions = $this->suspensionsFactory->getObjects($criteria_suspended);
            $suspension  = $suspensions[0];
            if (time() > $suspension->getVar('suspension_time')) {
                $suspension = $this->suspensionsFactory->create(false);
                $suspension->load($this->uidOwner);
                $this->owner->setVar('email', $suspension->getVar('old_email', 'n'));
                $this->owner->setVar('pass', $suspension->getVar('old_pass', 'n'));
                $this->owner->setVar('user_sig', $suspension->getVar('old_signature', 'n'));
                $userHandler = new \XoopsUserHandler($this->db);
                $userHandler->insert($this->owner, true);
                $criteria = new \Criteria('uid', $this->uidOwner);
                $this->suspensionsFactory->deleteAll($criteria);
            }
        }
    }

    public function checkPrivilege()
    {
    }

    /**
     * Checkinf privilege levels
     *
     * @param int $privilegeNeeded 0 anonym 1 member 2 friend 3 owner
     * @return bool true if privilege enough
     */
    public function checkPrivilegeLevel($privilegeNeeded = 0)
    {
        if ($privilegeNeeded <= $this->privilegeLevel) {
            return true;
        }

        return false;
    }

    /**
     * Set permissions according to user is logged or not , is owner or not etc..
     */
    public function getPermissions()
    {
        global $_GET, $xoopsUser;
        /**
         * @desc Check if the user uid exists if not redirect back to where he was
         */
        if (!empty($_GET['uid'])) {
            /** @var \XoopsMemberHandler $memberHandler */
            $memberHandler = xoops_getHandler('member');
            $user          = $memberHandler->getUser(\Xmf\Request::getInt('uid', 0, 'GET'));
            if (!is_object($user)) {
                redirect_header('index.php', 3, _MD_YOGURT_USERDOESNTEXIST);
            }
        }

        /**
         * If anonym and uid not set then redirect to admins profile
         * Else redirects to own profile
         */
        if (empty($this->user)) {
            $this->isAnonym = 1;
            $this->isUser   = 0;

            if (!empty($_GET['uid'])) {
                $this->uidOwner = \Xmf\Request::getInt('uid', 0, 'GET');
            } else {
                $this->uidOwner = 1;
                $this->isOwner  = 0;
            }
        } else {
            $this->isAnonym = 0;
            $this->isUser   = 1;

            if (!empty($_GET['uid'])) {
                $this->uidOwner = \Xmf\Request::getInt('uid', 0, 'GET');
                $this->isOwner  = ($this->user->getVar('uid') == (int)$_GET['uid']) ? 1 : 0;
            } else {
                $this->uidOwner = $this->user->getVar('uid');
                $this->isOwner  = 1;
            }
        }

        $this->owner        = new \XoopsUser($this->uidOwner);
        $criteria_suspended = new \Criteria('uid', $this->uidOwner);

        $this->isSuspended = ($this->suspensionsFactory->getCount($criteria_suspended) > 0) ? 1 : 0;

        if ('' == $this->owner->getVar('name')) {
            $this->nameOwner = $this->owner->getVar('uname');
        } else {
            $this->nameOwner = $this->owner->getVar('name');
        }

        //isfriend?
        $criteria_friends = new \Criteria('friend1_uid', $this->uidOwner);

        if (!$xoopsUser) {
            $this->isFriend = 0;
        } else {
            $criteria_isfriend = new \CriteriaCompo(new \Criteria('friend2_uid', $this->user->getVar('uid')));
            $criteria_isfriend->add($criteria_friends);
            $this->isFriend = $this->friendshipsFactory->getCount($criteria_isfriend);
        }

        $this->privilegeLevel = 0;
        if (1 == $this->isAnonym) {
            $this->privilegeLevel = 0;
        }
        if (1 == $this->isUser) {
            $this->privilegeLevel = 1;
        }
        if (1 == $this->isFriend) {
            $this->privilegeLevel = 2;
        }
        if (1 == $this->isOwner) {
            $this->privilegeLevel = 3;
        }
    }

    /**
     * Get for each section the number of objects the user possess
     *
     * @return array(nbGroups=>"",nbPhotos=>"",nbFriends=>"",nbVideos=>"")
     */
    public function getNumbersSections()
    {
        $criteriaGroups         = new \Criteria('rel_user_uid', $this->uidOwner);
        $nbSections['nbGroups'] = $this->relgroupusersFactory->getCount($criteriaGroups);
        $criteriaUid            = new \Criteria('uid_owner', $this->uidOwner);
        $criteriaAlbum          = new \CriteriaCompo($criteriaUid);
        if (0 == $this->isOwner) {
            $criteriaPrivate = new \Criteria('private', 0);
            $criteriaAlbum->add($criteriaPrivate);
        }
        $nbSections['nbPhotos']  = $this->albumFactory->getCount($criteriaAlbum);
        $criteriaFriends         = new \Criteria('friend1_uid', $this->uidOwner);
        $nbSections['nbFriends'] = $this->friendshipsFactory->getCount($criteriaFriends);
        $criteriaUidAudio        = new \Criteria('uid_owner', $this->uidOwner);
        $nbSections['nbAudio']   = $this->audioFactory->getCount($criteriaUidAudio);
        $criteriaUidVideo        = new \Criteria('uid_owner', $this->uidOwner);
        $nbSections['nbVideos']  = $this->videosFactory->getCount($criteriaUidVideo);
        $criteriaUidNotes        = new \Criteria('note_to', $this->uidOwner);
        $nbSections['nbNotes']   = $this->notesFactory->getCount($criteriaUidNotes);

        return $nbSections;
    }

    /**
     * This creates the module factories
     */
    public function createFactories()
    {
        $this->albumFactory         = new ImageHandler($this->db);
        $this->visitorsFactory      = new VisitorsHandler($this->db);
        $this->audioFactory         = new AudioHandler($this->db);
        $this->videosFactory        = new VideoHandler($this->db);
        $this->petitionsFactory     = new FriendpetitionHandler($this->db);
        $this->friendshipsFactory   = new FriendshipHandler($this->db);
        $this->relgroupusersFactory = new RelgroupuserHandler($this->db);
        $this->notesFactory         = new NotesHandler($this->db);
        $this->groupsFactory        = new GroupsHandler($this->db);
        $this->configsFactory       = new ConfigsHandler($this->db);
        $this->suspensionsFactory   = new SuspensionsHandler($this->db);
    }

    /**
     * @param $section
     * @return int
     */
    public function checkPrivilegeBySection($section)
    {
        global $xoopsModuleConfig;
        $configsectionname = 'enable_' . $section;
        if (array_key_exists($configsectionname, $xoopsModuleConfig)) {
            if (0 == $xoopsModuleConfig[$configsectionname]) {
                return -1;
            }
        }

        //  if ($section=="Notes" && $xoopsModuleConfig['enable_notes']==0){
        //          return false;
        //      }
        //      if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
        //          return false;
        //      }
        //
        //      if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
        //          return false;
        //      }
        $criteria = new \Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configsFactory->getCount($criteria)) {
            $configs = $this->configsFactory->getObjects($criteria);

            $config = $configs[0]->getVar($section);

            if (!$this->checkPrivilegeLevel($config)) {
                return 0;
            }
        }

        return 1;
    }
}
