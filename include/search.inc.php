<?php
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

/**
 * Protection against inclusion outside the site
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Return search results and show images on userinfo page
 *
 * @param array  $queryarray the terms to look
 * @param string $andor      the conector between the terms to be looked
 * @param int    $limit      The number of maximum results
 * @param int    $offset     from wich register start
 * @param int    $userid     from which user to look
 * @return array $ret with all results
 */
function yogurt_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB, $module;
    //getting the url to the uploads directory
    $moduleHandler     = xoops_getHandler('module');
    $modulo            = $moduleHandler->getByDirname('yogurt');
    $configHandler     = xoops_getHandler('config');
    $moduleConfig      = $configHandler->getConfigsByCat(0, $modulo->getVar('mid'));
    $path_uploadimages = XOOPS_UPLOAD_URL;

    $ret = [];
    $sql = 'SELECT cod_img, title,  data_creation,  uid_owner, url FROM ' . $xoopsDB->prefix('yogurt_images') . ' WHERE ';
    if (0 != $userid) {
        $sql .= '(uid_owner =' . (int)$userid . ')';
    }

    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    $count = count($queryarray);
    if ($count > 0 && is_array($queryarray)) {
        $sql .= " ((title LIKE '%" . $queryarray[0] . "%')";
        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";
            $sql .= "(title LIKE '%" . $queryarray[$i] . "%')";
        }
        $sql .= ') ';
    }
    $sql .= 'ORDER BY cod_img DESC';
    //echo $sql;
    //printr($xoopsModules);
    $result        = $xoopsDB->query($sql, $limit, $offset);
    $i             = 0;
    $stringofimage = 'images/search.png">';
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        if (0 != $userid) {
            if ($limit > 5) {
                $ret[$i]['image'] = "assets/images/search.png'><a href='" . XOOPS_URL . '/modules/yogurt/album.php?uid=' . $myrow['uid_owner'] . "'><img src='" . $path_uploadimages . '/yogurt/images/thumb_' . $myrow['url'] . "'></a><br>" . '<img src=' . XOOPS_URL . '/modules/yogurt/images/search.png';
                $ret[$i]['link']  = 'album.php?uid=' . $myrow['uid_owner'];
                $ret[$i]['title'] = $myrow['title'];
                //$ret[$i]['time'] = $myrow['data_creation'];
                $ret[$i]['uid'] = $myrow['uid_owner'];
            } else {
                $stringofimage .= '<a href="' . XOOPS_URL . '/modules/yogurt/album.php?uid=' . $myrow['uid_owner'] . '" title="' . $myrow['title'] . '"><img src="' . $path_uploadimages . '/yogurt/images/thumb_' . $myrow['url'] . '"></a>&nbsp;';
            }
        } else {
            $ret[$i]['image'] = "assets/images/search.png'><a href='" . XOOPS_URL . '/modules/yogurt/album.php?uid=' . $myrow['uid_owner'] . "'><img src='" . $path_uploadimages . '/yogurt/images/thumb_' . $myrow['url'] . "'></a><br>" . "<img src='" . XOOPS_URL . '/modules/yogurt/images/search.png';
            $ret[$i]['link']  = 'album.php?uid=' . $myrow['uid_owner'];
            $ret[$i]['title'] = $myrow['title'];
            //$ret[$i]['time'] = $myrow['data_creation'];
            $ret[$i]['uid'] = $myrow['uid_owner'];
        }

        $i++;
    }
    if (0 != $userid && $i > 0) {
        if ($limit < 6) {
            $ret = [];

            $ret[0]['title'] = 'See its album';
            $ret[0]['time']  = time();
            $ret[0]['uid']   = $userid;
            $ret[0]['link']  = 'album.php?uid=' . $userid;
            $stringofimage   .= '<img src="' . XOOPS_URL . '/modules/yogurt/assets/images/search.png';
            $ret[0]['image'] = $stringofimage;
        }
    }

    return $ret;
}
