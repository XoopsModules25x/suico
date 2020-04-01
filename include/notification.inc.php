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
 * @param $category
 * @param $item_id
 * @return mixed
 */
function yogurt_iteminfo($category, $item_id)
{
    $moduleHandler = xoops_getHandler('module');
    $module        = $moduleHandler->getByDirname('yogurt');

    if ('global' == $category) {
        $item['name'] = '';
        $item['url']  = '';

        return $item;
    }

    global $xoopsDB;

    if ('picture' == $category) {
        $sql          = 'SELECT title,uid_owner,url FROM ' . $xoopsDB->prefix('yogurt_images') . ' WHERE uid_owner = ' . $item_id . ' LIMIT 1';
        $result       = $xoopsDB->query($sql);
        $result_array = $xoopsDB->fetchArray($result);
        /**
         * Let's get the user name of the owner of the album
         */
        $owner        = new \XoopsUser();
        $identifier   = $owner::getUnameFromId($result_array['uid_owner']);
        $item['name'] = $identifier . "'s Album";
        $item['url']  = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/album.php?uid=' . $result_array['uid_owner'];

        return $item;
    }

    if ('video' == $category) {
        $sql          = 'SELECT video_id,uid_owner,video_desc,youtube_code, mainvideo FROM ' . $xoopsDB->prefix('yogurt_images') . ' WHERE uid_owner = ' . $item_id . ' LIMIT 1';
        $result       = $xoopsDB->query($sql);
        $result_array = $xoopsDB->fetchArray($result);
        /**
         * Let's get the user name of the owner of the album
         */
        $owner        = new \XoopsUser();
        $identifier   = $owner::getUnameFromId($result_array['uid_owner']);
        $item['name'] = $identifier . "'s Videos";
        $item['url']  = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/video.php?uid=' . $result_array['uid_owner'];

        return $item;
    }

    if ('Note' == $category) {
        $sql          = 'SELECT note_id, note_from, note_to, note_text FROM ' . $xoopsDB->prefix('yogurt_notes') . ' WHERE note_from = ' . $item_id . ' LIMIT 1';
        $result       = $xoopsDB->query($sql);
        $result_array = $xoopsDB->fetchArray($result);
        /**
         * Let's get the user name of the owner of the album
         */
        $owner        = new \XoopsUser();
        $identifier   = $owner::getUnameFromId($result_array['note_from']);
        $item['name'] = $identifier . "'s Notes";
        $item['url']  = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/notebook.php?uid=' . $result_array['note_from'];

        return $item;
    }
}
