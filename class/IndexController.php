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
 * Class IndexController
 */
class IndexController extends SuicoController
{
    /**
     * @param string|null $section
     * @return int|void
     */
    public function checkPrivilege($section = null)
    {
        global $xoopsModuleConfig;
        if ('' === \trim($section)) {
            return -1;
        }
        $configsectionname = 'enable_' . $section;
        if (\array_key_exists($configsectionname, $xoopsModuleConfig)) {
            if (0 === $this->helper->getConfig($configsectionname)) {
                return -1;
            }
        }
        //  if ($section=="Notes" && $xoopsModuleConfig['enable_notes']==0){
        //          return false;
        //      }
        //      if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
        //          return false;
        //      }
        //
        //      if ($section=="pictures" && $xoopsModuleConfig['enable_pictures']==0){
        //          return false;
        //      }
        $criteria = new Criteria('config_uid', $this->owner->getVar('uid'));
        if (1 === $this->configsFactory->getCount($criteria)) {
            $configs = $this->configsFactory->getObjects($criteria);
            $config  = $configs[0]->getVar($section);
            if (!$this->checkPrivilegeLevel($config)) {
                return 0;
            }
        }
        return 1;
    }
}
