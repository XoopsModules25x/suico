<?php
// $Id: yogurt_controler.php,v 1.13 2008/04/19 16:39:11 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/class/criteria.php';
include_once '../../class/pagenav.php';
/**
 * Module classes
 */
include_once 'class/yogurt_images.php';
include_once 'class/yogurt_visitors.php';
include_once 'class/yogurt_seutubo.php';
include_once 'class/yogurt_audio.php';
include_once 'class/yogurt_friendpetition.php';
include_once 'class/yogurt_friendship.php';
include_once 'class/yogurt_reltribeuser.php';
include_once 'class/yogurt_tribes.php';
include_once 'class/yogurt_Notes.php';
include_once 'class/yogurt_configs.php';
include_once 'class/yogurt_suspensions.php';
if (str_replace('.', '', PHP_VERSION) > 499) {
    include_once 'class/class.Id3v1.php';
}

/**
 * Class YogurtControler
 */
class YogurtControler extends XoopsObject
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
    public $album_factory;
    public $visitors_factory;
    public $audio_factory;
    public $videos_factory;
    public $petitions_factory;
    public $friendships_factory;
    public $reltribeusers_factory;
    public $suspensions_factory;
    public $tribes_factory;
    public $Notes_factory;
    public $configs_factory;
    public $section;
    public $privilegeLevel;
    public $isSuspended;

    /**
     * Constructor
     *
     * @param $db
     * @param $user
     */
    public function __construct($db, $user)
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
        $criteria_suspended = new Criteria('uid', $this->uidOwner);
        if (1 == $this->isSuspended) {
            $suspensions = $this->suspensions_factory->getObjects($criteria_suspended);
            $suspension  = $suspensions[0];
            if (time() > $suspension->getVar('suspension_time')) {
                $suspension = $this->suspensions_factory->create(false);
                $suspension->load($this->uidOwner);
                $this->owner->setVar('email', $suspension->getVar('old_email', 'n'));
                $this->owner->setVar('pass', $suspension->getVar('old_pass', 'n'));
                $this->owner->setVar('user_sig', $suspension->getVar('old_signature', 'n'));
                $userHandler = new XoopsUserHandler($this->db);
                $userHandler->insert($this->owner, true);
                $criteria = new Criteria('uid', $this->uidOwner);
                $this->suspensions_factory->deleteAll($criteria);
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
        } else {
            return false;
        }
    }

    /**
     * Set permissions acording to user is logged or not , is owner or not etc..
     *
     * @return void
     */
    public function getPermissions()
    {
        global $_GET, $xoopsUser;
        /**
         * @desc Check if the user uid exists if not redirect back to where he was
         */
        if (!empty($_GET['uid'])) {
            $memberHandler = xoops_getHandler('member');
            $user          = $memberHandler->getUser((int)$_GET['uid']);
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
                $this->uidOwner = (int)$_GET['uid'];
            } else {
                $this->uidOwner = 1;
                $this->isOwner  = 0;
            }
        } else {
            $this->isAnonym = 0;
            $this->isUser   = 1;

            if (!empty($_GET['uid'])) {
                $this->uidOwner = (int)$_GET['uid'];
                $this->isOwner  = ($this->user->getVar('uid') == (int)$_GET['uid']) ? 1 : 0;
            } else {
                $this->uidOwner = $this->user->getVar('uid');
                $this->isOwner  = 1;
            }
        }

        $this->owner        = new XoopsUser($this->uidOwner);
        $criteria_suspended = new Criteria('uid', $this->uidOwner);

        $this->isSuspended = ($this->suspensions_factory->getCount($criteria_suspended) > 0) ? 1 : 0;

        if ('' == $this->owner->getVar('name')) {
            $this->nameOwner = $this->owner->getVar('uname');
        } else {
            $this->nameOwner = $this->owner->getVar('name');
        }

        //isfriend?
        $criteria_friends = new criteria('friend1_uid', $this->uidOwner);

        if (!$xoopsUser) {
            $controler->isFriend = 0;
        } else {
            $criteria_isfriend = new criteriaCompo(new criteria('friend2_uid', $this->user->getVar('uid')));
            $criteria_isfriend->add($criteria_friends);
            $this->isFriend = $this->friendships_factory->getCount($criteria_isfriend);
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
     * @return array(nbTribes=>"",nbPhotos=>"",nbFriends=>"",nbVideos=>"")
     */
    public function getNumbersSections()
    {
        $criteriaTribes         = new Criteria('rel_user_uid', $this->uidOwner);
        $nbSections['nbTribes'] = $this->reltribeusers_factory->getCount($criteriaTribes);
        $criteriaUid            = new Criteria('uid_owner', $this->uidOwner);
        $criteriaAlbum          = new CriteriaCompo($criteriaUid);
        if (0 == $this->isOwner) {
            $criteriaPrivate = new criteria('private', 0);
            $criteriaAlbum->add($criteriaPrivate);
        }
        $nbSections['nbPhotos']  = $this->album_factory->getCount($criteriaAlbum);
        $criteriaFriends         = new criteria('friend1_uid', $this->uidOwner);
        $nbSections['nbFriends'] = $this->friendships_factory->getCount($criteriaFriends);
        $criteriaUidAudio        = new criteria('uid_owner', $this->uidOwner);
        $nbSections['nbAudio']   = $this->audio_factory->getCount($criteriaUidAudio);
        $criteriaUidVideo        = new criteria('uid_owner', $this->uidOwner);
        $nbSections['nbVideos']  = $this->videos_factory->getCount($criteriaUidVideo);
        $criteriaUidNotes       = new criteria('Note_to', $this->uidOwner);
        $nbSections['nbNotes']  = $this->Notes_factory->getCount($criteriaUidNotes);

        return $nbSections;
    }

    /**
     * This creates the module factories
     *
     * @return void
     */
    public function createFactories()
    {
        $this->album_factory         = new Xoopsyogurt_imagesHandler($this->db);
        $this->visitors_factory      = new Xoopsyogurt_visitorsHandler($this->db);
        $this->audio_factory         = new Xoopsyogurt_audioHandler($this->db);
        $this->videos_factory        = new Xoopsyogurt_seutuboHandler($this->db);
        $this->petitions_factory     = new Xoopsyogurt_friendpetitionHandler($this->db);
        $this->friendships_factory   = new Xoopsyogurt_friendshipHandler($this->db);
        $this->reltribeusers_factory = new Xoopsyogurt_reltribeuserHandler($this->db);
        $this->Notes_factory        = new Xoopsyogurt_NotesHandler($this->db);
        $this->tribes_factory        = new Xoopsyogurt_tribesHandler($this->db);
        $this->configs_factory       = new Xoopsyogurt_configsHandler($this->db);
        $this->suspensions_factory   = new Xoopsyogurt_suspensionsHandler($this->db);
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

        //	if ($section=="Notes" && $xoopsModuleConfig['enable_Notes']==0){
        //	  		return false;
        //		}
        //		if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
        //	  		return false;
        //		}
        //
        //		if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
        //	  		return false;
        //		}
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configs_factory->getCount($criteria)) {
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar($section);

            if (!$this->checkPrivilegeLevel($config)) {
                return 0;
            }
        }
        return 1;
    }
}

/**
 * Class YogurtVideoControler
 */
class YogurtVideoControler extends YogurtControler
{

    /**
     * Fecth videos
     * @param object $criteria
     * @return array of video objects
     */
    public function getVideos($criteria)
    {
        $videos = $this->videos_factory->getObjects($criteria);
        return $videos;
    }

    /**
     * Assign Videos Submit Form to theme
     * @param int $maxNbVideos the maximum number of videos a user can have
     * @param     $presentNb
     * @return void
     */
    public function showFormSubmitVideos($maxNbVideos, $presentNb)
    {
        global $xoopsTpl;

        if ($this->isUser) {
            if ((1 == $this->isOwner) && ($maxNbVideos > $presentNb)) {
                echo '&nbsp;';
                $this->videos_factory->renderFormSubmit($xoopsTpl);
            }
        }
    }

    /**
     * Assign Video Content to Template
     * @param $nbVideos
     * @param $videos
     * @return bool
     */
    public function assignVideoContent($nbVideos, $videos)
    {
        if (0 == $nbVideos) {
            return false;
        } else {

            /**
             * Lets populate an array with the dati from the videos
             */
            $i = 0;
            foreach ($videos as $video) {
                $videos_array[$i]['url']  = $video->getVar('youtube_code', 's');
                $videos_array[$i]['desc'] = $video->getVar('video_desc', 's');
                $videos_array[$i]['id']   = $video->getVar('video_id', 's');

                $i++;
            }
            return $videos_array;
        }
    }

    /**
     * Create a page navbar for videos
     * @param     $nbVideos
     * @param int $videosPerPage the number of videos in a page
     * @param int $start         at which position of the array we start
     * @param int $interval      how many pages between the first link and the next one
     * @return void
     */
    public function VideosNavBar($nbVideos, $videosPerPage, $start, $interval)
    {
        $pageNav = new XoopsPageNav($nbVideos, $videosPerPage, $start, 'start', 'uid=' . $this->uidOwner);
        $navBar  = $pageNav->renderImageNav($interval);
        return $navBar;
    }

    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        global $xoopsModuleConfig;
        if (0 == $xoopsModuleConfig['enable_videos']) {
            redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, _MD_YOGURT_VIDEOSNOTENABLED);
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configs_factory->getCount($criteria)) {
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar('videos');

            if (!$this->checkPrivilegeLevel($config)) {
                redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
            }
        }
        return true;
    }
}

/**
 * Class YogurtControlerNotes
 */
class YogurtControlerNotes extends YogurtControler
{

    //	function renderFormNewPost($tpl){
    //
    //
    //
    //		$form = new XoopsThemeForm("",'formNoteNew','submit_Note.php','post',true);
    //		$fieldNote = new XoopsFormTextArea('','text',_MD_YOGURT_ENTERTEXTNOTE);
    //		$fieldNote->setExtra(' onclick="cleanNoteForm(text,\''._MD_YOGURT_ENTERTEXTNOTE.'\')"');
    //
    //
    //		$fieldScrabookUid = new XoopsFormHidden ("uid", $this->uidOwner);
    //
    //		$submitButton = new XoopsFormButton("","post_Note",_MD_YOGURT_SENDNOTE,"submit");
    //
    //		$form->addElement($fieldScrabookUid);
    //		$form->addElement($fieldNote,true);
    //		$form->addElement($submitButton);
    //
    //		//$form->display();
    //		$form->assign($tpl);
    //	}

    /**
     * @param $nb_Notes
     * @param $criteria
     * @return bool
     */
    public function fecthNotes($nb_Notes, $criteria)
    {
        if ($Notes = $this->Notes_factory->getNotes($nb_Notes, $criteria)) {
            return $Notes;
        } else {
            return false;
        }
    }

    /**
     * @param string $privilegeType
     * @return bool|void
     */
    public function checkPrivilege($privilegeType = '')
    {
        global $xoopsModuleConfig;
        if (0 == $xoopsModuleConfig['enable_Notes']) {
            redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, _MD_YOGURT_NOTESNOTENABLED);
        }
        if ('sendNotes' == $privilegeType) {
            $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
            if (1 == $this->configs_factory->getCount($criteria)) {
                $configs = $this->configs_factory->getObjects($criteria);

                $config = $configs[0]->getVar('sendNotes');
            }
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configs_factory->getCount($criteria)) {
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar('Notes');

            if (!$this->checkPrivilegeLevel($config)) {
                redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
            }
        }
        return true;
    }
}

/**
 * Class YogurtControlerPhotos
 */
class YogurtControlerPhotos extends YogurtControler
{
    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        global $xoopsModuleConfig;
        if (0 == $xoopsModuleConfig['enable_pictures']) {
            redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, _MD_YOGURT_PICTURESNOTENABLED);
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configs_factory->getCount($criteria)) {
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar('pictures');

            if (!$this->checkPrivilegeLevel($config)) {
                redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
            }
        }
        return true;
    }
}

/**
 * Class YogurtAudioControler
 */
class YogurtAudioControler extends YogurtControler
{

    /**
     * Fecth audios
     * @param object $criteria
     * @return array of video objects
     */
    public function getAudio($criteria)
    {
        $audios = $this->audio_factory->getObjects($criteria);
        return $audios;
    }

    /**
     * Assign Audio Content to Template
     * @param $nbAudios
     * @param $audios
     * @return bool
     */
    public function assignAudioContent($nbAudios, $audios)
    {
        if (0 == $nbAudios) {
            return false;
        } else {
            //audio info
            /**
             * Lets populate an array with the dati from the audio
             */
            $i = 0;
            foreach ($audios as $audio) {
                $audios_array[$i]['url']    = $audio->getVar('url', 's');
                $audios_array[$i]['title']  = $audio->getVar('title', 's');
                $audios_array[$i]['id']     = $audio->getVar('audio_id', 's');
                $audios_array[$i]['author'] = $audio->getVar('author', 's');

                if (str_replace('.', '', PHP_VERSION) > 499) {
                    $audio_path = XOOPS_ROOT_PATH . '/uploads/yogurt/mp3/' . $audio->getVar('url', 's');
                    // echo $audio_path;
                    $mp3filemetainfo                = new Id3v1($audio_path, true);
                    $mp3filemetainfoarray           = [];
                    $mp3filemetainfoarray['Title']  = $mp3filemetainfo->getTitle();
                    $mp3filemetainfoarray['Artist'] = $mp3filemetainfo->getArtist();
                    $mp3filemetainfoarray['Album']  = $mp3filemetainfo->getAlbum();
                    $mp3filemetainfoarray['Year']   = $mp3filemetainfo->getYear();
                    $audios_array[$i]['meta']       = $mp3filemetainfoarray;
                } else {
                    $audios_array[$i]['nometa'] = 1;
                }
                $i++;
            }
            return $audios_array;
        }
    }

    /**
     * Create a page navbar for videos
     * @param     $nbAudios
     * @param int $audiosPerPage the number of videos in a page
     * @param int $start         at which position of the array we start
     * @param int $interval      how many pages between the first link and the next one
     * @return void
     */
    public function AudiosNavBar($nbAudios, $audiosPerPage, $start, $interval)
    {
        $pageNav = new XoopsPageNav($nbAudios, $audiosPerPage, $start, 'start', 'uid=' . $this->uidOwner);
        $navBar  = $pageNav->renderImageNav($interval);
        return $navBar;
    }

    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        global $xoopsModuleConfig;
        if (0 == $xoopsModuleConfig['enable_audio']) {
            redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, _MD_YOGURT_AUDIONOTENABLED);
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configs_factory->getCount($criteria)) {
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar('audio');

            if (!$this->checkPrivilegeLevel($config)) {
                redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
            }
        }
        return true;
    }
}

/**
 * Class YogurtControlerFriends
 */
class YogurtControlerFriends extends YogurtControler
{
    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        global $xoopsModuleConfig;
        if (0 == $xoopsModuleConfig['enable_friends']) {
            redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, _MD_YOGURT_FRIENDSNOTENABLED);
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configs_factory->getCount($criteria)) {
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar('friends');

            if (!$this->checkPrivilegeLevel($config)) {
                redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
            }
        }
        return true;
    }
}

/**
 * Class YogurtControlerTribes
 */
class YogurtControlerTribes extends YogurtControler
{
    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        global $xoopsModuleConfig;
        if (0 == $xoopsModuleConfig['enable_tribes']) {
            redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, _MD_YOGURT_TRIBESNOTENABLED);
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configs_factory->getCount($criteria)) {
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar('tribes');

            if (!$this->checkPrivilegeLevel($config)) {
                redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
            }
        }
        return true;
    }
}

/**
 * Class YogurtControlerIndex
 */
class YogurtControlerIndex extends YogurtControler
{
    /**
     * @param null|string $section
     * @return int|void
     */
    public function checkPrivilege($section = null)
    {
        global $xoopsModuleConfig;
        if ('' == trim($section)) {
            return -1;
        }
        $configsectionname = 'enable_' . $section;
        if (array_key_exists($configsectionname, $xoopsModuleConfig)) {
            if (0 == $xoopsModuleConfig[$configsectionname]) {
                return -1;
            }
        }

        //	if ($section=="Notes" && $xoopsModuleConfig['enable_Notes']==0){
        //	  		return false;
        //		}
        //		if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
        //	  		return false;
        //		}
        //
        //		if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
        //	  		return false;
        //		}
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configs_factory->getCount($criteria)) {
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar($section);

            if (!$this->checkPrivilegeLevel($config)) {
                return 0;
            }
        }
        return 1;
    }
}

/**
 * Class YogurtControlerConfigs
 */
class YogurtControlerConfigs extends YogurtControler
{
    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        return true;
    }
}
