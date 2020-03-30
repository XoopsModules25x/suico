<?php

namespace XoopsModules\Yogurt;

// Visitors.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Visitors class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class Visitors extends \XoopsObject
{
    public $db;

    // constructor

    /**
     * Visitors constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('cod_visit', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('uid_owner', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('uid_visitor', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('uname_visitor', XOBJ_DTYPE_TXTBOX, null, false);
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_visitors') . ' WHERE cod_visit=' . $id;
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
    public function getAllyogurt_visitorss($criteria = [], $asobject = false, $sort = 'cod_visit', $order = 'ASC', $limit = 0, $start = 0)
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
            $sql    = 'SELECT cod_visit FROM ' . $db->prefix('yogurt_visitors') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
                while ($false !== (myrow = $db->fetchArray($result))))) {
                $ret[] = $myrow['yogurt_visitors_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_visitors') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
                while ($false !== (myrow = $db->fetchArray($result))))) {
                $ret[] = new Yogurt\Visitors($myrow);
            }
        }
        return $ret;
    }
}
