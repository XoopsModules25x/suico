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

use Xmf\Request;
use XoopsModules\Suico\{
    ConfigsHandler
};

require __DIR__ . '/header.php';
/**
 * Factories of groups
 */
$configsFactory = new ConfigsHandler($xoopsDB);
/**
 * Verify Token
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_SUICO_TOKENEXPIRED);
}
//      $this->initVar("config_id",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("config_uid",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("pictures",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("videos",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("groups",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("Notes",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("friends",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("profile_contact",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("profile_general",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("profile_stats",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("suspension",XOBJ_DTYPE_INT,null,false,10);
//      $this->initVar("backup_password",XOBJ_DTYPE_TXTBOX, null, false);
//      $this->initVar("backup_email",XOBJ_DTYPE_TXTBOX, null, false);
//      $this->initVar("end_suspension",XOBJ_DTYPE_TXTBOX, null, false);
//$pic  = $_POST['pic'];
//$vid  = $_POST['vid'];
//$aud    = $_POST['aud'];
//$tri  = $_POST['groups'];
//$fri  = $_POST['friends'];
//$scr  = $_POST['notes'];
//$pcon   = $_POST['profileContact'];
//$pgen   = $_POST['gen'];
//$psta   = $_POST['stat'];
$criteria = new Criteria('config_uid', $xoopsUser->getVar('uid'));
if ($configsFactory->getCount($criteria) > 0) {
    $configs = $configsFactory->getObjects($criteria);
    $config  = $configs[0];
    $config->unsetNew();
} else {
    $config = $configsFactory->create();
}
$config->setVar('config_uid', $xoopsUser->getVar('uid'));
if (isset($_POST['pic'])) {
    $config->setVar('pictures', Request::getInt('pic', 0, 'POST'));
}
if (isset($_POST['aud'])) {
    $config->setVar('audio', Request::getInt('aud', 0, 'POST'));
}
if (isset($_POST['vid'])) {
    $config->setVar('videos', Request::getInt('vid', 0, 'POST'));
}
if (isset($_POST['groups'])) {
    $config->setVar('groups', Request::getInt('groups', 0, 'POST'));
}
if (isset($_POST['notes'])) {
    $config->setVar('notes', Request::getInt('notes', 0, 'POST'));
}
if (isset($_POST['friends'])) {
    $config->setVar('friends', Request::getInt('friends', 0, 'POST'));
}
if (isset($_POST['profileContact'])) {
    $config->setVar('profile_contact', Request::getInt('profileContact', 0, 'POST'));
}
if (isset($_POST['gen'])) {
    $config->setVar('profile_general', Request::getInt('gen', 0, 'POST'));
}
if (isset($_POST['stat'])) {
    $config->setVar('profile_stats', Request::getInt('stat', 0, 'POST'));
}
if ($configsFactory->insert2($config)) {
    redirect_header('configs.php?uid=' . $xoopsUser->getVar('uid'), 3, _MD_SUICO_CONFIGS_SAVE);
} else {
    redirect_header('configs.php?uid=' . $xoopsUser->getVar('uid'), 3, _MD_SUICO_CONFIGS_SAVE_FAILED);
}
/**
 * Close page
 */
require dirname(__DIR__, 2) . '/footer.php';
