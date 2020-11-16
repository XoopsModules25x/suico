<?php

declare(strict_types=1);

namespace XoopsModules\Suico;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

use Criteria;
use XoopsPageNav;

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
 * Class SuicoVideoController
 */
class VideoController extends SuicoController
{
    /**
     * Fetch videos
     * @param object $criteria
     * @return array of video objects
     */
    public function getVideos(
        $criteria
    ) {
        return $this->videosFactory->getObjects($criteria);
    }

    /**
     * Assign Videos Submit Form to theme
     * @param int $maxNbVideos the maximum number of videos a user can have
     * @param     $presentNb
     */
    public function showFormSubmitVideos(
        $maxNbVideos,
        $presentNb
    ) {
        global $xoopsTpl;
        if ($this->isUser) {
            if ((1 === $this->isOwner) && ($maxNbVideos > $presentNb)) {
                echo '&nbsp;';
                $this->videosFactory->renderFormSubmit($xoopsTpl);
            }
        }
    }

    /**
     * Assign Video Content to Template
     * @param $countVideos
     * @param $videos
     * @return bool
     */
    public function assignVideoContent(
        $countVideos,
        $videos
    ) {
        if (0 === $countVideos) {
            return false;
        }
        /**
         * Lets populate an array with the dati from the videos
         */
        $i = 0;
        foreach ($videos as $video) {
            $videosArray[$i]['url']            = $video->getVar('youtube_code', 's');
            $videosArray[$i]['title']          = $video->getVar('video_title', 's');
            $videosArray[$i]['desc']           = $video->getVar('video_desc', 's');
            $videosArray[$i]['id']             = $video->getVar('video_id', 's');
			$videosArray[$i]['featured_video'] = $video->getVar('featured_video', 's');
            $videosArray[$i]['date_created']   = \formatTimestamp($video->getVar('date_created', 's'));
            $videosArray[$i]['date_updated']   = \formatTimestamp($video->getVar('date_updated', 's'));
            $i++;
        }
        return $videosArray;
    }

    /**
     * Create a page navbar for videos
     * @param     $countVideos
     * @param int $videosPerPage the number of videos in a page
     * @param int $start         at which position of the array we start
     * @param int $interval      how many pages between the first link and the next one
     * @return string|null
     * @return string|null
     */
    public function videosNavBar(
        $countVideos,
        $videosPerPage,
        $start,
        $interval
    ) {
        $pageNav = new XoopsPageNav($countVideos, $videosPerPage, $start, 'start', 'uid=' . $this->uidOwner);
        return $pageNav->renderImageNav($interval);
    }

    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        if (0 === $this->helper->getConfig('enable_videos')) {
            \redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, \_MD_SUICO_VIDEOS_ENABLED_NOT);
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 === $this->configsFactory->getCount($criteria)) {
            $configs = $this->configsFactory->getObjects($criteria);
            $config  = $configs[0]->getVar('videos');
            /*
            if (!$this->checkPrivilegeLevel($config)) {
                \redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, sprintf(_MD_SUICO_NOPRIVILEGE,'Videos'));
            }
            */
        }
        return true;
    }
}
