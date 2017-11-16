<?php
// yogurt_suspensions.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * yogurt_suspensions class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class yogurt_suspensions extends XoopsObject
{
    public $db;

    // constructor

    /**
     * yogurt_suspensions constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('old_pass', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('old_email', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('old_signature', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('suspension_time', XOBJ_DTYPE_INT, null, false, 10);
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_suspensions') . ' WHERE uid=' . $id;
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
    public function getAllyogurt_suspensionss($criteria = [], $asobject = false, $sort = 'uid', $order = 'ASC', $limit = 0, $start = 0)
    {
        $db          = XoopsDatabaseFactory::getDatabaseConnection();
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
            $sql    = 'SELECT uid FROM ' . $db->prefix('yogurt_suspensions') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = $myrow['yogurt_suspensions_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_suspensions') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = new yogurt_suspensions($myrow);
            }
        }
        return $ret;
    }
}

// -------------------------------------------------------------------------
// ------------------yogurt_suspensions user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_suspensionshandler class.
 * This class provides simple mecanisme for yogurt_suspensions object
 */
class Xoopsyogurt_suspensionsHandler extends XoopsObjectHandler
{

    /**
     * create a new yogurt_suspensions
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject yogurt_suspensions
     */
    public function create($isNew = true)
    {
        $yogurt_suspensions = new yogurt_suspensions();
        if ($isNew) {
            $yogurt_suspensions->setNew();
        } else {
            $yogurt_suspensions->unsetNew();
        }

        return $yogurt_suspensions;
    }

    /**
     * retrieve a yogurt_suspensions
     *
     * @param int $id of the yogurt_suspensions
     * @return mixed reference to the {@link yogurt_suspensions} object, FALSE if failed
     */
    public function &get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_suspensions') . ' WHERE uid=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_suspensions = new yogurt_suspensions();
            $yogurt_suspensions->assignVars($this->db->fetchArray($result));
            return $yogurt_suspensions;
        }
        return false;
    }

    /**
     * insert a new yogurt_suspensions in the database
     *
     * @param \XoopsObject $yogurt_suspensions reference to the {@link yogurt_suspensions}
     *                                         object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(XoopsObject $yogurt_suspensions, $force = false)
    {
        global $xoopsConfig;
        if ('yogurt_suspensions' != get_class($yogurt_suspensions)) {
            return false;
        }
        if (!$yogurt_suspensions->isDirty()) {
            return true;
        }
        if (!$yogurt_suspensions->cleanVars()) {
            return false;
        }
        foreach ($yogurt_suspensions->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_suspensions->isNew()) {
            // ajout/modification d'un yogurt_suspensions
            $yogurt_suspensions = new yogurt_suspensions();
            $format             = 'INSERT INTO %s (uid, old_pass, old_email, old_signature, suspension_time)';
            $format             .= 'VALUES (%u, %s, %s, %s, %u)';
            $sql                = sprintf($format, $this->db->prefix('yogurt_suspensions'), $uid, $this->db->quoteString($old_pass), $this->db->quoteString($old_email), $this->db->quoteString($old_signature), $suspension_time);
            $force              = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'uid=%u, old_pass=%s, old_email=%s, old_signature=%s, suspension_time=%u';
            $format .= ' WHERE uid = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_suspensions'), $uid, $this->db->quoteString($old_pass), $this->db->quoteString($old_email), $this->db->quoteString($old_signature), $suspension_time, $uid);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($uid)) {
            $uid = $this->db->getInsertId();
        }
        $yogurt_suspensions->assignVar('uid', $uid);
        return true;
    }

    /**
     * delete a yogurt_suspensions from the database
     *
     * @param \XoopsObject $yogurt_suspensions reference to the yogurt_suspensions to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(XoopsObject $yogurt_suspensions, $force = false)
    {
        if ('yogurt_suspensions' != get_class($yogurt_suspensions)) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE uid = %u', $this->db->prefix('yogurt_suspensions'), $yogurt_suspensions->getVar('uid'));
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * retrieve yogurt_suspensionss from the database
     *
     * @param CriteriaElement $criteria  {@link CriteriaElement} conditions to be met
     * @param bool   $id_as_key use the UID as key for the array?
     * @return array array of {@link yogurt_suspensions} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_suspensions');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $yogurt_suspensions = new yogurt_suspensions();
            $yogurt_suspensions->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $yogurt_suspensions;
            } else {
                $ret[$myrow['uid']] =& $yogurt_suspensions;
            }
            unset($yogurt_suspensions);
        }
        return $ret;
    }

    /**
     * count yogurt_suspensionss matching a condition
     *
     * @param CriteriaElement $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_suspensionss
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_suspensions');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);
        return $count;
    }

    /**
     * delete yogurt_suspensionss matching a set of conditions
     *
     * @param CriteriaElement $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_suspensions');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }
}
