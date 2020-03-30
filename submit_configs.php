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

use XoopsModules\Yogurt;

require __DIR__ . '/header.php';

/**
 * Factories of tribes
 */
$configsFactory = new Yogurt\ConfigsHandler($xoopsDB);

/**
 * Verify Token
 */
if (!$GLOBALS['xoopsSecurity']->check()) {
    redirect_header(\Xmf\Request::getString('HTTP_REFERER', '', 'SERVER'), 3, _MD_YOGURT_TOKENEXPIRED);
}
/**
 *
 */
//		$this->initVar("config_id",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("config_uid",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("pictures",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("videos",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("tribes",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("Notes",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("friends",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("profile_contact",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("profile_general",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("profile_stats",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("suspension",XOBJ_DTYPE_INT,null,false,10);
//		$this->initVar("backup_password",XOBJ_DTYPE_TXTBOX, null, false);
//		$this->initVar("backup_email",XOBJ_DTYPE_TXTBOX, null, false);
//		$this->initVar("end_suspension",XOBJ_DTYPE_TXTBOX, null, false);

//$pic 	= $_POST['pic'];
//$vid	= $_POST['vid'];
//$aud    = $_POST['aud'];
//$tri	= $_POST['tribes'];
//$fri	= $_POST['friends'];
//$scr	= $_POST['Notes'];
//$pcon   = $_POST['profileContact'];
//$pgen   = $_POST['gen'];
//$psta   = $_POST['stat'];

$criteria = new \Criteria('config_uid', $xoopsUser->getVar('uid'));
if ($configsFactory->getCount($criteria) > 0) {
    $configs = $configsFactory->getObjects($criteria);
    $config  = $configs[0];
    $config->unsetNew();
} else {
    $config = $configsFactory->create();
}

$config->setVar('config_uid', $xoopsUser->getVar('uid'));
if (isset($_POST['pic'])) {
    $config->setVar('pictures', $_POST['pic']);
}
if (isset($_POST['aud'])) {
    $config->setVar('audio', $_POST['aud']);
}
if (isset($_POST['vid'])) {
    $config->setVar('videos', $_POST['vid']);
}
if (isset($_POST['tribes'])) {
    $config->setVar('tribes', $_POST['tribes']);
}
if (isset($_POST['Notes'])) {
    $config->setVar('Notes', $_POST['Notes']);
}
if (isset($_POST['friends'])) {
    $config->setVar('friends', $_POST['friends']);
}
if (isset($_POST['profileContact'])) {
    $config->setVar('profile_contact', $_POST['profileContact']);
}
if (isset($_POST['gen'])) {
    $config->setVar('profile_general', $_POST['gen']);
}
if (isset($_POST['stat'])) {
    $config->setVar('profile_stats', $_POST['stat']);
}
if (!$configsFactory->insert($config)) {
}
redirect_header('configs.php?uid=' . $xoopsUser->getVar('uid'), 3, _MD_YOGURT_CONFIGSSAVE);

/**
 * Close page
 */
include '../../footer.php';
