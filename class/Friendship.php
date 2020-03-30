<?php

namespace XoopsModules\Yogurt;

// Friendship.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
/**
 * Includes of form objects and uploader
 */
include_once XOOPS_ROOT_PATH . '/class/uploader.php';
include_once XOOPS_ROOT_PATH . '/kernel/object.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Friendship class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class Friendship extends \XoopsObject
{
    public $db;

    // constructor

    /**
     * Friendship constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('friendship_id', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('friend1_uid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('friend2_uid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('level', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('hot', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('trust', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('cool', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('fan', XOBJ_DTYPE_INT, null, false, 10);
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendship') . ' WHERE friendship_id=' . $id;
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
    public function getAllyogurt_friendships($criteria = [], $asobject = false, $sort = 'friendship_id', $order = 'ASC', $limit = 0, $start = 0)
    {
        $db          = \XoopsDatabaseFactory::getDatabaseConnection();
        $ret         = [];
        $where_query = '';
        if (is_array($criteria) && count($criteria) > 0) {
            $where_query = ' WHERE';
            foreach ($criteria as $c) {
                $where_query .= " $c AND";
            }
            $where_query = substr($where_query, 0, -4);
        } elseif (!is_array($criteria) && $criteria) {
            $where_query = ' WHERE ' . $criteria;
        }
        if (!$asobject) {
            $sql    = 'SELECT friendship_id FROM ' . $db->prefix('yogurt_friendship') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
                while (false !== ($myrow = $db->fetchArray($result))) {
                $ret[] = $myrow['yogurt_friendship_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_friendship') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
                while (false !== ($myrow = $db->fetchArray($result))) {
                $ret[] = new Friendship($myrow);
            }
        }
        return $ret;
    }
}
