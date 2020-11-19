<?php

declare(strict_types=1);
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
/**
 * Protection against inclusion outside the site
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit('XOOPS root path not defined');
}
/**
 * Return search results and show images on userinfo page
 *
 * @param array  $queryarray the terms to look
 * @param string $andor      the conector between the terms to be looked
 * @param int    $limit      The number of maximum results
 * @param int    $offset     from wich register start
 * @param int    $userid     from which user to look
 * @return array with all results
 */
function suico_search(
    $queryarray,
    $andor,
    $limit,
    $offset,
    $userid
) {
    global $xoopsDB, $module;
    //getting the url to the uploads directory
    $moduleHandler = xoops_getHandler('module');
    $modulo        = $moduleHandler->getByDirname('suico');
    /** @var \XoopsConfigHandler $configHandler */
    $configHandler     = xoops_getHandler('config');
    $moduleConfig      = $configHandler->getConfigsByCat(0, $modulo->getVar('mid'));
    $path_uploadimages = XOOPS_UPLOAD_URL;
    $ret               = [];
    $sql               = 'SELECT image_id, title, caption,  date_created,  uid_owner, filename FROM ' . $xoopsDB->prefix(
            'suico_images'
        ) . ' WHERE ';
    if (0 !== $userid) {
        $sql .= '(uid_owner =' . (int)$userid . ')';
    }
    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    $count = count($queryarray);
    if ($count > 0 && is_array($queryarray)) {
        $sql .= " ((title LIKE '%" . $queryarray[0] . "%')";
        for ($i = 1; $i < $count; ++$i) {
            $sql .= " ${andor} ";
            $sql .= "(title LIKE '%" . $queryarray[$i] . "%')";
        }
        $sql .= ') ';
    }
    $sql .= 'ORDER BY image_id DESC';
    //echo $sql;
    //printr($xoopsModules);
    $result        = $xoopsDB->query($sql, $limit, $offset);
    $i             = 0;
    $stringofimage = 'images/search.png">';
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        if (0 !== $userid) {
            if ($limit > 5) {
                $ret[$i]['image'] = "assets/images/search.png'><a href='"
                                    . XOOPS_URL
                                    . '/modules/suico/album.php?uid='
                                    . $myrow['uid_owner']
                                    . "'><img src='"
                                    . $path_uploadimages
                                    . '/suico/images/thumb_'
                                    . $myrow['filename']
                                    . "'></a><br>"
                                    . '<img src='
                                    . XOOPS_URL
                                    . '/modules/suico/images/search.png';
                $ret[$i]['link']  = 'album.php?uid=' . $myrow['uid_owner'];
                $ret[$i]['title'] = $myrow['title'];
                //$ret[$i]['time'] = $myrow['date_created'];
                $ret[$i]['uid'] = $myrow['uid_owner'];
            } else {
                $stringofimage .= '<a href="' . XOOPS_URL . '/modules/suico/album.php?uid=' . $myrow['uid_owner'] . '" title="' . $myrow['title'] . '"><img src="' . $path_uploadimages . '/suico/images/thumb_' . $myrow['filename'] . '"></a>&nbsp;';
            }
        } else {
            $ret[$i]['image'] = "assets/images/search.png'><a href='"
                                . XOOPS_URL
                                . '/modules/suico/album.php?uid='
                                . $myrow['uid_owner']
                                . "'><img src='"
                                . $path_uploadimages
                                . '/suico/images/thumb_'
                                . $myrow['filename']
                                . "'></a><br>"
                                . "<img src='"
                                . XOOPS_URL
                                . '/modules/suico/images/search.png';
            $ret[$i]['link']  = 'album.php?uid=' . $myrow['uid_owner'];
            $ret[$i]['title'] = $myrow['title'];
            //$ret[$i]['time'] = $myrow['date_created'];
            $ret[$i]['uid'] = $myrow['uid_owner'];
        }
        $i++;
    }
    if (0 !== $userid && $i > 0) {
        if ($limit < 6) {
            $ret             = [];
            $ret[0]['title'] = 'See its album';
            $ret[0]['time']  = time();
            $ret[0]['uid']   = $userid;
            $ret[0]['link']  = 'album.php?uid=' . $userid;
            $stringofimage   .= '<img src="' . XOOPS_URL . '/modules/suico/assets/images/search.png';
            $ret[0]['image'] = $stringofimage;
        }
    }
    return $ret;
}
