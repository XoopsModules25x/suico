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
 * Class GroupController
 */
class GroupController extends SuicoController
{
    /**
     * @return bool|void
     */
    public function checkPrivilege()
    {
        if (0 === $this->helper->getConfig('enable_groups')) {
            \redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 3, \_MD_SUICO_GROUPS_ENABLED_NOT);
        }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 === $this->configsFactory->getCount($criteria)) {
            $configs = $this->configsFactory->getObjects($criteria);
            $config  = $configs[0]->getVar('groups');
            /*
            if (!$this->checkPrivilegeLevel($config)) {
                \redirect_header('index.php?uid=' . $this->owner->getVar('uid'), 10, sprintf(_MD_SUICO_NOPRIVILEGE,'Groups'));
            }
            */
        }
        return true;
    }
}
