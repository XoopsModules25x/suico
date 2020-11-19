<?php

declare(strict_types=1);

namespace XoopsModules\Suico;

use Criteria;
use Exception;
use XoopsPageNav;

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
require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/class/criteria.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

/**
 * Class SuicoAudioController
 */
class AudioController extends SuicoController
{
    /**
     * Fetch audios
     * @param object $criteria
     * @return array of video objects
     */
    public function getAudio(
        $criteria
    ) {
        return $this->audioFactory->getObjects($criteria);
    }

    /**
     * Assign Audio Content to Template
     * @param int   $countAudios
     * @param array $audios
     * @return bool|array
     * @throws Exception
     * @throws Exception
     */
    public function assignAudioContent(
        $countAudios,
        $audios
    ) {
        if (0 === $countAudios) {
            return false;
        }
        //audio info
        /**
         * Lets populate an array with the data from the audio
         */
        $i           = 0;
        $audiosArray = [];
        foreach ($audios as $audio) {
            $audiosArray[$i]['filename']     = $audio->getVar('filename', 's');
            $audiosArray[$i]['title']        = $audio->getVar('title', 's');
            $audiosArray[$i]['id']           = $audio->getVar('audio_id', 's');
            $audiosArray[$i]['author']       = $audio->getVar('author', 's');
            $audiosArray[$i]['date_created'] = \formatTimestamp($audio->getVar('date_created', 's'));
            $audiosArray[$i]['date_updated'] = \formatTimestamp($audio->getVar('date_updated', 's'));
            $audio_path                      = XOOPS_ROOT_PATH . '/uploads/suico/audio/' . $audio->getVar('filename', 's');
            // echo $audio_path;
            $mp3filemetainfo                = new Id3v1($audio_path, true);
            $mp3filemetainfoarray           = [];
            $mp3filemetainfoarray['Title']  = $mp3filemetainfo->getTitle();
            $mp3filemetainfoarray['Artist'] = $mp3filemetainfo->getArtist();
            $mp3filemetainfoarray['Album']  = $mp3filemetainfo->getAlbum();
            $mp3filemetainfoarray['Year']   = $mp3filemetainfo->getYear();
            $audiosArray[$i]['meta']        = $mp3filemetainfoarray;
            $i++;
        }
        return $audiosArray;
    }

    /**
     * Create a page navbar for videos
     * @param     $countAudios
     * @param int $audiosPerPage the number of videos in a page
     * @param int $start         at which position of the array we start
     * @param int $interval      how many pages between the first link and the next one
     * @return string|null
     * @return string|null
     */
    public function getAudiosNavBar(
        $countAudios,
        $audiosPerPage,
        $start,
        $interval
    ) {
        $pageNav = new \XoopsPageNav($countAudios, $audiosPerPage, $start, 'start', 'uid=' . $this->uidOwner);
        return $pageNav->renderImageNav($interval);
    }

    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        if (0 === $this->helper->getConfig('enable_audio')) {
            \redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, \_MD_SUICO_AUDIO_ENABLED_NOT);
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 === $this->configsFactory->getCount($criteria)) {
            $configs = $this->configsFactory->getObjects($criteria);
            $config  = $configs[0]->getVar('audio');
            if (!$this->checkPrivilegeLevel($config)) {
                \redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, \_MD_SUICO_NOPRIVILEGE);
            }
        }
        return true;
    }
}
