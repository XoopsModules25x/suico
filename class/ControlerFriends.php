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

include_once XOOPS_ROOT_PATH.'/kernel/object.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH.'/class/criteria.php';
include_once '../../class/pagenav.php';
/**
 * Module classes
 */
//include_once 'class/Image.php';
//include_once 'class/yogurt_visitors.php';
//include_once 'class/Seutubo.php';
//include_once 'class/yogurt_audio.php';
//include_once 'class/Friendpetition.php';
//include_once 'class/Friendship.php';
//include_once 'class/Reltribeuser.php';
//include_once 'class/Tribes.php';
//include_once 'class/Notes.php';
//include_once 'class/Configs.php';
//include_once 'class/Suspensions.php';
if (str_replace('.', '', PHP_VERSION) > 499) {
	include_once 'class/class.Id3v1.php';
}

/**
 * Class ControlerFriends
 */
class ControlerFriends extends YogurtControler
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
		$criteria = new \Criteria('config_uid', $this->owner->getVar('uid'));
		if (1 == $this->configsFactory->getCount($criteria)) {
			$configs = $this->configsFactory->getObjects($criteria);

			$config = $configs[0]->getVar('friends');

			if (!$this->checkPrivilegeLevel($config)) {
				redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, _MD_YOGURT_NOPRIVILEGE);
			}
		}
		return true;
	}
}
