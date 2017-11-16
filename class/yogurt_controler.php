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

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH."/class/criteria.php";
include_once ("../../class/pagenav.php");
/**
 * Module classes
 */
include_once("class/yogurt_images.php");
include_once("class/yogurt_visitors.php");
include_once("class/yogurt_seutubo.php");
include_once("class/yogurt_audio.php");
include_once("class/yogurt_friendpetition.php");
include_once("class/yogurt_friendship.php");
include_once("class/yogurt_reltribeuser.php");
include_once("class/yogurt_tribes.php");
include_once("class/yogurt_scraps.php");
include_once("class/yogurt_configs.php");
include_once("class/yogurt_suspensions.php");
if ( (str_replace('.', '', PHP_VERSION)) > 499 ){
  include_once("class/class.Id3v1.php");
} 


class YogurtControler extends XoopsObject
{
	var $db;
	var $user;
	var $isOwner;
	var $isUser;
	var $isAnonym;
	var $isFriend;
	var $uidOwner;
	var $nameOwner;
	var $owner;
	var $album_factory;
	var $visitors_factory;
    var $audio_factory;
	var $videos_factory;
	var $petitions_factory;
	var $friendships_factory;
	var $reltribeusers_factory;
	var $suspensions_factory;
	var $tribes_factory;
	var $scraps_factory;
	var $configs_factory;
	var $section;
	var $privilegeLevel;
	var $isSuspended;

	
/**
* Constructor
* 
* @param object $xoopsDatabase
* @param object $xoopsUser
* @return void
*/
	function YogurtControler($db,$user)
	{
		$this->db = $db;
		$this->user=$user;
		$this->isOwner=0;
		$this->isAnonym=1;
		$this->isFriend=0;
		$this->isUser=0;
		$this->createFactories();
		$this->getPermissions();
		$this->checkPrivilege("");
		$this->checkSuspension();
	}
	
    function checkSuspension(){
	  $criteria_suspended = new Criteria("uid",$this->uidOwner);
	  if ($this->isSuspended==1){
		$suspensions = $this->suspensions_factory->getObjects($criteria_suspended);
		$suspension = $suspensions[0];
		if (time()>$suspension->getVar('suspension_time')){					
          $suspension = $this->suspensions_factory->create(false);
          $suspension->load($this->uidOwner);    
          $this->owner->setVar('email',$suspension->getVar('old_email',"n"));
          $this->owner->setVar('pass',    $suspension->getVar('old_pass',"n"));
          $this->owner->setVar('user_sig',$suspension->getVar('old_signature',"n"));
          $user_handler = new XoopsUserHandler($this->db);
          $user_handler->insert($this->owner,true);    
          $criteria = new Criteria("uid",$this->uidOwner);
          $this->suspensions_factory->deleteAll($criteria);
		}
	}
}
	function checkPrivilege(){
		
	}

/**
* Checkinf privilege levels
* 
* @param int $privilegeNeeded 0 anonym 1 member 2 friend 3 owner
* @return bool true if privilege enough
*/
	function checkPrivilegeLevel($privilegeNeeded=0){
		
		
		if ($privilegeNeeded <= $this->privilegeLevel){
			return true;
		}else{
			return false;
		}
		
	}

	

	/**
	 * Set permissions acording to user is logged or not , is owner or not etc..
	 * 
	 * @return void
	 */
	function getPermissions(){

		global $_GET,$xoopsUser;
     /**
      * @desc Check if the user uid exists if not redirect back to where he was
	 */
      if ( !empty($_GET['uid'])){
        $member_handler =& xoops_gethandler('member');
        $user =& $member_handler->getUser(intval($_GET['uid']));
        if (!(is_object($user))) {
          redirect_header("index.php",3,_MD_YOGURT_USERDOESNTEXIST);  
        }    
      }
 

	   /**
 		* If anonym and uid not set then redirect to admins profile
 		* Else redirects to own profile
 		*/
		if (empty($this->user)){

			$this->isAnonym=1;
			$this->isUser=0;

			if ( !empty($_GET['uid'])){
				$this->uidOwner = intval($_GET['uid']);
			} else {
				$this->uidOwner = 1;
				$this->isOwner=0;
			}

		} else {
						
			$this->isAnonym=0;
			$this->isUser=1;

			if ( !empty($_GET['uid'])){
				$this->uidOwner= intval($_GET['uid']);
				$this->isOwner = ($this->user->getVar('uid')==intval($_GET['uid']))?1:0;
			} else {
				$this->uidOwner = $this->user->getVar('uid');
				$this->isOwner =1;
			}

		}

		$this->owner = new XoopsUser($this->uidOwner);
		$criteria_suspended = new Criteria("uid",$this->uidOwner);
			
		$this->isSuspended = ($this->suspensions_factory->getCount($criteria_suspended)>0)?1:0;			
			
		if ($this->owner->getVar('name')=="") {
			$this->nameOwner = $this->owner->getVar('uname');
		}else{
			$this->nameOwner = $this->owner->getVar('name');
		}
			
		
     //isfriend?
     $criteria_friends = new criteria('friend1_uid',$this->uidOwner);

    if (!$xoopsUser) {
      $controler->isFriend = 0;	
    }else{
      $criteria_isfriend = new criteriaCompo (new criteria ('friend2_uid',$this->user->getVar('uid')));
      $criteria_isfriend->add($criteria_friends);
      $this->isFriend = $this->friendships_factory->getCount($criteria_isfriend);
    }
		
		
	$this->privilegeLevel =0;
	if ($this->isAnonym==1){
		$this->privilegeLevel =0;
	}
	if ($this->isUser==1){
		$this->privilegeLevel =1;
	}
	if ($this->isFriend==1){
		$this->privilegeLevel =2;
	}
	if ($this->isOwner==1){
		$this->privilegeLevel =3;
	}

	}
	
	/**
	 * Get for each section the number of objects the user possess
	 * 
	 * @return array(nbTribes=>"",nbPhotos=>"",nbFriends=>"",nbVideos=>"")
	 */	
	function getNumbersSections(){

		$criteriaTribes 		= new Criteria('rel_user_uid',$this->uidOwner);
		$nbSections['nbTribes']	= $this->reltribeusers_factory->getCount($criteriaTribes);
		$criteriaUid       		= new Criteria('uid_owner',$this->uidOwner);
		$criteriaAlbum     		= new CriteriaCompo($criteriaUid);
		if ($this->isOwner==0){
			$criteriaPrivate   = new criteria('private',0);
			$criteriaAlbum->add($criteriaPrivate);
		}
		$nbSections['nbPhotos']	= $this->album_factory->getCount($criteriaAlbum);
		$criteriaFriends 		= new criteria('friend1_uid',$this->uidOwner);
		$nbSections['nbFriends']= $this->friendships_factory->getCount($criteriaFriends);
        $criteriaUidAudio          = new criteria('uid_owner',$this->uidOwner);
        $nbSections['nbAudio'] = $this->audio_factory->getCount($criteriaUidAudio);
		$criteriaUidVideo  		= new criteria('uid_owner',$this->uidOwner);
		$nbSections['nbVideos'] = $this->videos_factory->getCount($criteriaUidVideo);
		$criteriaUidScraps  		= new criteria('scrap_to',$this->uidOwner);
		$nbSections['nbScraps'] = $this->scraps_factory->getCount($criteriaUidScraps);

		return $nbSections;
	}
	
	
	/**
	 * This creates the module factories
	 * 
	 * @return void
	 */		
		function createFactories()
	{
 
$this->album_factory 			= new Xoopsyogurt_imagesHandler($this->db);
$this->visitors_factory 		= new Xoopsyogurt_visitorsHandler($this->db);
$this->audio_factory           = new Xoopsyogurt_audioHandler($this->db); 
$this->videos_factory 			= new Xoopsyogurt_seutuboHandler($this->db);
$this->petitions_factory 		= new Xoopsyogurt_friendpetitionHandler($this->db);
$this->friendships_factory 		= new Xoopsyogurt_friendshipHandler($this->db);
$this->reltribeusers_factory 	= new Xoopsyogurt_reltribeuserHandler($this->db);
$this->scraps_factory 			= new Xoopsyogurt_scrapsHandler($this->db);
$this->tribes_factory 	   		= new Xoopsyogurt_tribesHandler($this->db);
$this->configs_factory 	   		= new Xoopsyogurt_configsHandler($this->db);
$this->suspensions_factory 		= new Xoopsyogurt_suspensionsHandler($this->db);

	
	}

	function checkPrivilegeBySection($section){
		global $xoopsModuleConfig;
		$configsectionname = 'enable_'.$section;
		if (array_key_exists($configsectionname,$xoopsModuleConfig)){
	  if ($xoopsModuleConfig[$configsectionname]==0){
	 
	  	return -1;
	  }
		}
	  	
//	if ($section=="scraps" && $xoopsModuleConfig['enable_scraps']==0){
//	  		return false;
//		}
//		if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
//	  		return false;
//		}
//		
//		if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
//	  		return false;
//		}
		$criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
		if ($this->configs_factory->getCount($criteria)==1){
			$configs = $this->configs_factory->getObjects($criteria);

			$config = $configs[0]->getVar($section);


			if (!$this->checkPrivilegeLevel($config)){
				return 0;
			}
		}return 1;
	  }
	

	
	
	

}


class YogurtVideoControler extends YogurtControler {

	
		/**
	 * Fecth videos
	 * @param object $criteria
	 * @return array of video objects
	 */		
	function getVideos($criteria)
	{

		$videos = $this->videos_factory->getObjects($criteria);
		return $videos;
	}
	
	/**
	 * Assign Videos Submit Form to theme
	 * @param int $maxNbVideos the maximum number of videos a user can have
	 * @param int $presentNbr the present number of videos the user has
	 * @return void
	 */	
	function showFormSubmitVideos($maxNbVideos,$presentNb)
	{
		global $xoopsTpl;

		if ($this->isUser){
			if (($this->isOwner==1) && ($maxNbVideos > $presentNb)){
				echo "&nbsp;";
				$this->videos_factory->renderFormSubmit($xoopsTpl);
			}
		}
	}
	
	
	/**
	 * Assign Video Content to Template
	 * @param int $NbVideos the number of videos this user have
	 * @param object $tpl Xoops Template
	 * @param array of objects 
	 * @return void
	 */	
	function assignVideoContent($nbVideos, $videos)
	{
		if ($nbVideos==0)
		{

			return false;

		} else {

			/**
     * Lets populate an array with the dati from the videos
     */  
			$i = 0;
			foreach ($videos as $video){
				$videos_array[$i]['url']      = $video->getVar("youtube_code","s");
				$videos_array[$i]['desc']     = $video->getVar("video_desc","s");
				$videos_array[$i]['id']  	  = $video->getVar("video_id","s");
				
				$i++;
			}
		return $videos_array;
		}

	}
		
	
	/**
	 * Create a page navbar for videos
	 * @param int $NbVideos the number of videos this user have
	 * @param int $videosPerPage the number of videos in a page
	 * @param int $start at which position of the array we start
	 * @param int $interval how many pages between the first link and the next one
	 * @return void
	 */	
		function VideosNavBar($nbVideos,$videosPerPage,$start,$interval){
		
	$pageNav = new XoopsPageNav($nbVideos, $videosPerPage,$start,"start","uid=".$this->uidOwner);
	$navBar = $pageNav->renderImageNav($interval);
	return $navBar;
	}
	
	
	

	function checkPrivilege(){
		global $xoopsModuleConfig;
		if ($xoopsModuleConfig['enable_videos']==0){
			redirect_header("index.php?uid=".$this->owner->getVar('uid'),3,_MD_YOGURT_VIDEOSNOTENABLED);
		}
		$criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
		if ($this->configs_factory->getCount($criteria)==1){
			$configs = $this->configs_factory->getObjects($criteria);

			$config = $configs[0]->getVar('videos');


			if (!$this->checkPrivilegeLevel($config)){
				redirect_header("index.php?uid=".$this->owner->getVar('uid'),10,_MD_YOGURT_NOPRIVILEGE);
			}
		}return true;
	}
}



class YogurtControlerScraps extends YogurtControler {

//	function renderFormNewPost($tpl){
//		
//		
//		
//		$form = new XoopsThemeForm("",'formScrapNew','submit_scrap.php','post',true);
//		$fieldScrap = new XoopsFormTextArea('','text',_MD_YOGURT_ENTERTEXTSCRAP);
//		$fieldScrap->setExtra(' onclick="cleanScrapForm(text,\''._MD_YOGURT_ENTERTEXTSCRAP.'\')"');
//		
//		
//		$fieldScrabookUid = new XoopsFormHidden ("uid", $this->uidOwner);
//		
//		$submitButton = new XoopsFormButton("","post_scrap",_MD_YOGURT_SENDSCRAP,"submit");
//	
//		$form->addElement($fieldScrabookUid);
//		$form->addElement($fieldScrap,true);
//		$form->addElement($submitButton);
//		
//		//$form->display();
//		$form->assign($tpl);
//	}

	function fecthScraps($nb_scraps, $criteria){


		if ($scraps = $this->scraps_factory->getScraps($nb_scraps, $criteria)){
			return $scraps;} else{ return false;
			}


	}
	
function checkPrivilege($privilegeType=""){
global $xoopsModuleConfig;
		if ($xoopsModuleConfig['enable_scraps']==0){
			redirect_header("index.php?uid=".$this->owner->getVar('uid'),3,_MD_YOGURT_SCRAPSNOTENABLED);
		}
		if ($privilegeType=="sendscraps"){
			$criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
		if ($this->configs_factory->getCount($criteria)==1){
			$configs = $this->configs_factory->getObjects($criteria);

			$config = $configs[0]->getVar('sendscraps');
		}
		}
		$criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
		if ($this->configs_factory->getCount($criteria)==1){
			$configs = $this->configs_factory->getObjects($criteria);

			$config = $configs[0]->getVar('scraps');


			if (!$this->checkPrivilegeLevel($config)){
				redirect_header("index.php?uid=".$this->owner->getVar('uid'),10,_MD_YOGURT_NOPRIVILEGE);
			}
		}return true;
	}

}



class YogurtControlerPhotos extends YogurtControler {
	
	function checkPrivilege(){
global $xoopsModuleConfig;
		if ($xoopsModuleConfig['enable_pictures']==0){
			redirect_header("index.php?uid=".$this->owner->getVar('uid'),3,_MD_YOGURT_PICTURESNOTENABLED);
		}
		$criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
		if ($this->configs_factory->getCount($criteria)==1){
			$configs = $this->configs_factory->getObjects($criteria);

			$config = $configs[0]->getVar('pictures');


			if (!$this->checkPrivilegeLevel($config)){
				redirect_header("index.php?uid=".$this->owner->getVar('uid'),10,_MD_YOGURT_NOPRIVILEGE);
			}
		}return true;
	}

}


class YogurtAudioControler extends YogurtControler {


/**
     * Fecth audios
     * @param object $criteria
     * @return array of video objects
     */        
    function getAudio($criteria)
    {

        $audios = $this->audio_factory->getObjects($criteria);
        return $audios;
    }
    
    
    /**
     * Assign Audio Content to Template
     * @param int $NbAudios the number of videos this user have
     * @param object $tpl Xoops Template
     * @param array of objects 
     * @return void
     */    
    function assignAudioContent($nbAudios, $audios)
    {
	
        if ($nbAudios==0) {
            return false;
        } else {            
          //audio info
            /**
             * Lets populate an array with the dati from the audio
            */  
            $i = 0;
            foreach ($audios as $audio){
                $audios_array[$i]['url']      = $audio->getVar("url","s");
                $audios_array[$i]['title']    = $audio->getVar("title","s");
                $audios_array[$i]['id']       = $audio->getVar("audio_id","s");
                $audios_array[$i]['author']   = $audio->getVar("author","s");

                if ( (str_replace('.', '', PHP_VERSION)) > 499 ){  
                  $audio_path = XOOPS_ROOT_PATH.'/uploads/yogurt/mp3/'.$audio->getVar("url","s");
                  // echo $audio_path;
                  $mp3filemetainfo = new Id3v1($audio_path, true);
                  $mp3filemetainfoarray = array();
                  $mp3filemetainfoarray['Title'] = $mp3filemetainfo->getTitle();
                  $mp3filemetainfoarray['Artist'] = $mp3filemetainfo->getArtist();
                  $mp3filemetainfoarray['Album'] = $mp3filemetainfo->getAlbum();
                  $mp3filemetainfoarray['Year'] =  $mp3filemetainfo->getYear();
                  $audios_array[$i]['meta'] = $mp3filemetainfoarray;
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
     * @param int $NbAudios the number of videos this user have
     * @param int $audiosPerPage the number of videos in a page
     * @param int $start at which position of the array we start
     * @param int $interval how many pages between the first link and the next one
     * @return void
     */    
        function AudiosNavBar($nbAudios,$audiosPerPage,$start,$interval){
        
    $pageNav = new XoopsPageNav($nbAudios, $audiosPerPage,$start,"start","uid=".$this->uidOwner);
    $navBar = $pageNav->renderImageNav($interval);
    return $navBar;
    }
    
    function checkPrivilege(){
global $xoopsModuleConfig;
        if ($xoopsModuleConfig['enable_audio']==0){
            redirect_header("index.php?uid=".$this->owner->getVar('uid'),3,_MD_YOGURT_AUDIONOTENABLED);
        }
        $criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
        if ($this->configs_factory->getCount($criteria)==1){
            $configs = $this->configs_factory->getObjects($criteria);

            $config = $configs[0]->getVar('audio');


            if (!$this->checkPrivilegeLevel($config)){
                redirect_header("index.php?uid=".$this->owner->getVar('uid'),10,_MD_YOGURT_NOPRIVILEGE);
            }
        }return true;
    }

}

class YogurtControlerFriends extends YogurtControler  {
	
	function checkPrivilege(){
global $xoopsModuleConfig;
		if ($xoopsModuleConfig['enable_friends']==0){
			redirect_header("index.php?uid=".$this->owner->getVar('uid'),3,_MD_YOGURT_FRIENDSNOTENABLED);
		}
		$criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
		if ($this->configs_factory->getCount($criteria)==1){
			$configs = $this->configs_factory->getObjects($criteria);

			$config = $configs[0]->getVar('friends');


			if (!$this->checkPrivilegeLevel($config)){
				redirect_header("index.php?uid=".$this->owner->getVar('uid'),10,_MD_YOGURT_NOPRIVILEGE);
			}
		}return true;
	}
	
}

class YogurtControlerTribes extends YogurtControler  {
	
	function checkPrivilege(){
global $xoopsModuleConfig;
		if ($xoopsModuleConfig['enable_tribes']==0){
			redirect_header("index.php?uid=".$this->owner->getVar('uid'),3,_MD_YOGURT_TRIBESNOTENABLED);
		}
		$criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
		if ($this->configs_factory->getCount($criteria)==1){
			$configs = $this->configs_factory->getObjects($criteria);

			$config = $configs[0]->getVar('tribes');


			if (!$this->checkPrivilegeLevel($config)){
				redirect_header("index.php?uid=".$this->owner->getVar('uid'),10,_MD_YOGURT_NOPRIVILEGE);
			}
		}return true;
	}
	
}

class YogurtControlerIndex extends YogurtControler  {

	function checkPrivilege($section){
		global $xoopsModuleConfig;
		if (trim($section)=="") return -1;
		$configsectionname = 'enable_'.$section;
		if (array_key_exists($configsectionname,$xoopsModuleConfig)){
	       if ($xoopsModuleConfig[$configsectionname]==0){
	  	      return -1;
	       }
		}
	  	
//	if ($section=="scraps" && $xoopsModuleConfig['enable_scraps']==0){
//	  		return false;
//		}
//		if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
//	  		return false;
//		}
//		
//		if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
//	  		return false;
//		}
		$criteria = new Criteria('config_uid',$this->owner->getVar('uid'));
		if ($this->configs_factory->getCount($criteria)==1){
			$configs = $this->configs_factory->getObjects($criteria);

			$config = $configs[0]->getVar($section);


			if (!$this->checkPrivilegeLevel($config)){
				return 0;
			}
		}return 1;
	  }	
}

class YogurtControlerConfigs extends YogurtControler{
	function checkPrivilege(){
		return true;
	}
}

?>