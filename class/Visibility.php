<?php

declare(strict_types=1);

namespace XoopsModules\Suico;

/**
 * Extended User Profile
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package             profile
 * @since               2.3.0
 * @author              Jan Pedersen
 * @author              Taiwen Jiang <phppp@users.sourceforge.net>
 */

/**
 * Class Visibility
 */
class Visibility extends \XoopsObject
{
    public function __construct()
    {
        $this->initVar('field_id', \XOBJ_DTYPE_INT);
        $this->initVar('user_group', \XOBJ_DTYPE_INT);
        $this->initVar('profile_group', \XOBJ_DTYPE_INT);
    }
}
