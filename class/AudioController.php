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
 * Class YogurtAudioController
 */
class AudioController extends YogurtController
{
    /**
     * Fetch audios
     * @param object $criteria
     * @return array of video objects
     */
    public function getAudio($criteria)
    {
        $audios = $this->audioFactory->getObjects($criteria);

        return $audios;
    }

    /**
     * Assign Audio Content to Template
     * @param $nbAudios
     * @param $audios
     * @return bool
     * @throws \Exception
     * @throws \Exception
     */
    public function assignAudioContent($nbAudios, $audios)
    {
        if (0 == $nbAudios) {
            return false;
        }
        //audio info
        /**
         * Lets populate an array with the data from the audio
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

    /**
     * Create a page navbar for videos
     * @param     $nbAudios
     * @param int $audiosPerPage the number of videos in a page
     * @param int $start         at which position of the array we start
     * @param int $interval      how many pages between the first link and the next one
     * @return string|null
     * @return string|null
     */
    public function AudiosNavBar($nbAudios, $audiosPerPage, $start, $interval)
    {
        $pageNav = new \XoopsPageNav($nbAudios, $audiosPerPage, $start, 'start', 'uid=' . $this->uidOwner);
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
        $criteria = new \Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 == $this->configsFactory->getCount($criteria)) {
            $configs = $this->configsFactory->getObjects($criteria);

            $config = $configs[0]->getVar('audio');

            if (!$this->checkPrivilegeLevel($config)) {
                redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
            }
        }

        return true;
    }
}
