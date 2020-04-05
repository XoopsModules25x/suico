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
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Ishot class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class Ishot extends \XoopsObject
{
    public $db;

    // constructor

    /**
     * Ishot constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        /** @var  Helper $helper */
        $this->helper     = Helper::getInstance();
        $this->permHelper = new \Xmf\Module\Helper\Permission();
        $this->db         = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('cod_ishot', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('uid_voter', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('uid_voted', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('ishot', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('date', XOBJ_DTYPE_TXTBOX, null, false);
        if (!empty($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            } else {
                $this->load((int)$id);
            }
        } else {
            $this->setNew();
        }
    }

    /**
     * @param $id
     */
    public function load($id)
    {
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_ishot') . ' WHERE cod_ishot=' . $id;
        $myrow = $this->db->fetchArray($this->db->query($sql));
        $this->assignVars($myrow);
        if (!$myrow) {
            $this->setNew();
        }
    }

    /**
     * @param array  $criteria
     * @param bool   $asobject
     * @param string $sort
     * @param string $order
     * @param int    $limit
     * @param int    $start
     * @return array
     */
    public function getAllyogurt_ishots($criteria = [], $asobject = false, $sort = 'cod_ishot', $order = 'ASC', $limit = 0, $start = 0)
    {
        $db          = \XoopsDatabaseFactory::getDatabaseConnection();
        $ret         = [];
        $where_query = '';
        if (is_array($criteria) && count($criteria) > 0) {
            $where_query = ' WHERE';
            foreach ($criteria as $c) {
                $where_query .= " $c AND";
            }
            $where_query = mb_substr($where_query, 0, -4);
        } elseif (!is_array($criteria) && $criteria) {
            $where_query = ' WHERE ' . $criteria;
        }
        if (!$asobject) {
            $sql    = 'SELECT cod_ishot FROM ' . $db->prefix('yogurt_ishot') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while (false !== ($myrow = $db->fetchArray($result))) {
                $ret[] = $myrow['yogurt_ishot_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_ishot') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while (false !== ($myrow = $db->fetchArray($result))) {
                $ret[] = new self($myrow);
            }
        }

        return $ret;
    }
}
