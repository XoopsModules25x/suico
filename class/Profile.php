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
 * @package             kernel
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 */
class Profile extends \XoopsObject
{
    /**
     * @param $fields
     */
    public function __construct($fields)
    {
        $this->initVar('profile_id', \XOBJ_DTYPE_INT, null, true);
        $this->init($fields);
    }

    /**
     * Initiate variables
     * @param array $fields field information array of {@link XoopsField} objects
     */
    public function init($fields)
    {
        if (\is_array($fields) && \count($fields) > 0) {
            foreach (\array_keys($fields) as $key) {
                $this->initVar($key, $fields[$key]->getVar('field_valuetype'), $fields[$key]->getVar('field_default', 'n'), $fields[$key]->getVar('field_required'), $fields[$key]->getVar('field_maxlength'));
            }
        }
    }
}
