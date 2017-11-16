<?php
// yogurt_reltribeuser.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * yogurt_reltribeuser class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class yogurt_reltribeuser extends XoopsObject
{
    public $db;

    // constructor

    /**
     * yogurt_reltribeuser constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('rel_id', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('rel_tribe_id', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('rel_user_uid', XOBJ_DTYPE_INT, null, false, 10);
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_reltribeuser') . ' WHERE rel_id=' . $id;
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
    public function getAllyogurt_reltribeusers($criteria = [], $asobject = false, $sort = 'rel_id', $order = 'ASC', $limit = 0, $start = 0)
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
            $sql    = 'SELECT rel_id FROM ' . $db->prefix('yogurt_reltribeuser') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = $myrow['yogurt_reltribeuser_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_reltribeuser') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = new yogurt_reltribeuser($myrow);
            }
        }
        return $ret;
    }
}

// -------------------------------------------------------------------------
// ------------------yogurt_reltribeuser user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_reltribeuserhandler class.
 * This class provides simple mecanisme for yogurt_reltribeuser object
 */
class Xoopsyogurt_reltribeuserHandler extends XoopsObjectHandler
{

    /**
     * create a new yogurt_reltribeuser
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject yogurt_reltribeuser
     */
    public function create($isNew = true)
    {
        $yogurt_reltribeuser = new yogurt_reltribeuser();
        if ($isNew) {
            $yogurt_reltribeuser->setNew();
        } else {
            $yogurt_reltribeuser->unsetNew();
        }

        return $yogurt_reltribeuser;
    }

    /**
     * retrieve a yogurt_reltribeuser
     *
     * @param int $id of the yogurt_reltribeuser
     * @return mixed reference to the {@link yogurt_reltribeuser} object, FALSE if failed
     */
    public function &get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_reltribeuser') . ' WHERE rel_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_reltribeuser = new yogurt_reltribeuser();
            $yogurt_reltribeuser->assignVars($this->db->fetchArray($result));
            return $yogurt_reltribeuser;
        }
        return false;
    }

    /**
     * insert a new yogurt_reltribeuser in the database
     *
     * @param \XoopsObject $yogurt_reltribeuser reference to the {@link yogurt_reltribeuser}
     *                                          object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(XoopsObject $yogurt_reltribeuser, $force = false)
    {
        global $xoopsConfig;
        if ('yogurt_reltribeuser' != get_class($yogurt_reltribeuser)) {
            return false;
        }
        if (!$yogurt_reltribeuser->isDirty()) {
            return true;
        }
        if (!$yogurt_reltribeuser->cleanVars()) {
            return false;
        }
        foreach ($yogurt_reltribeuser->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_reltribeuser->isNew()) {
            // ajout/modification d'un yogurt_reltribeuser
            $yogurt_reltribeuser = new yogurt_reltribeuser();
            $format              = 'INSERT INTO %s (rel_id, rel_tribe_id, rel_user_uid)';
            $format              .= 'VALUES (%u, %u, %u)';
            $sql                 = sprintf($format, $this->db->prefix('yogurt_reltribeuser'), $rel_id, $rel_tribe_id, $rel_user_uid);
            $force               = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'rel_id=%u, rel_tribe_id=%u, rel_user_uid=%u';
            $format .= ' WHERE rel_id = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_reltribeuser'), $rel_id, $rel_tribe_id, $rel_user_uid, $rel_id);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($rel_id)) {
            $rel_id = $this->db->getInsertId();
        }
        $yogurt_reltribeuser->assignVar('rel_id', $rel_id);
        return true;
    }

    /**
     * delete a yogurt_reltribeuser from the database
     *
     * @param \XoopsObject $yogurt_reltribeuser reference to the yogurt_reltribeuser to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(XoopsObject $yogurt_reltribeuser, $force = false)
    {
        if ('yogurt_reltribeuser' != get_class($yogurt_reltribeuser)) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE rel_id = %u', $this->db->prefix('yogurt_reltribeuser'), $yogurt_reltribeuser->getVar('rel_id'));
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
     * retrieve yogurt_reltribeusers from the database
     *
     * @param CriteriaElement $criteria  {@link CriteriaElement} conditions to be met
     * @param bool   $id_as_key use the UID as key for the array?
     * @return array array of {@link yogurt_reltribeuser} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_reltribeuser');
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
            $yogurt_reltribeuser = new yogurt_reltribeuser();
            $yogurt_reltribeuser->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $yogurt_reltribeuser;
            } else {
                $ret[$myrow['rel_id']] =& $yogurt_reltribeuser;
            }
            unset($yogurt_reltribeuser);
        }
        return $ret;
    }

    /**
     * count yogurt_reltribeusers matching a condition
     *
     * @param CriteriaElement $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_reltribeusers
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_reltribeuser');
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
     * delete yogurt_reltribeusers matching a set of conditions
     *
     * @param CriteriaElement $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_reltribeuser');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * @param      $nbtribes
     * @param null $criteria
     * @param int  $shuffle
     * @return array
     */
    public function getTribes($nbtribes, $criteria = null, $shuffle = 1)
    {
        $ret = [];

        $sql = 'SELECT rel_id, rel_tribe_id, rel_user_uid, tribe_title, tribe_desc, tribe_img, owner_uid FROM ' . $this->db->prefix('yogurt_tribes') . ', ' . $this->db->prefix('yogurt_reltribeuser');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND tribe_id = rel_tribe_id ';
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();

            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;

            while ($myrow = $this->db->fetchArray($result)) {
                $vetor[$i]['title']    = $myrow['tribe_title'];
                $vetor[$i]['desc']     = $myrow['tribe_desc'];
                $vetor[$i]['img']      = $myrow['tribe_img'];
                $vetor[$i]['id']       = $myrow['rel_id'];
                $vetor[$i]['uid']      = $myrow['owner_uid'];
                $vetor[$i]['tribe_id'] = $myrow['rel_tribe_id'];

                $i++;
            }

            if (1 == $shuffle) {
                shuffle($vetor);
                $vetor = array_slice($vetor, 0, $nbtribes);
            }
            return $vetor;
        }
    }

    /**
     * @param     $tribeId
     * @param     $start
     * @param     $nbUsers
     * @param int $isShuffle
     * @return array
     */
    public function getUsersFromTribe($tribeId, $start, $nbUsers, $isShuffle = 0)
    {
        $ret = [];

        $sql = 'SELECT rel_tribe_id, rel_user_uid, owner_uid, uname, user_avatar, uid FROM ' . $this->db->prefix('users') . ', ' . $this->db->prefix('yogurt_tribes') . ', ' . $this->db->prefix('yogurt_reltribeuser');
        $sql .= ' WHERE rel_user_uid = uid AND rel_tribe_id = tribe_id AND tribe_id =' . $tribeId . ' GROUP BY rel_user_uid ';

        $result = $this->db->query($sql, $nbUsers, $start);
        $ret    = [];
        $i      = 0;

        while ($myrow = $this->db->fetchArray($result)) {
            $ret[$i]['uid']     = $myrow['uid'];
            $ret[$i]['uname']   = $myrow['uname'];
            $ret[$i]['avatar']  = $myrow['user_avatar'];
            $isOwner            = ($myrow['rel_user_uid'] == $myrow['owner_uid']) ? 1 : 0;
            $ret[$i]['isOwner'] = $isOwner;
            $i++;
        }

        if (1 == $isShuffle) {
            shuffle($ret);
            $ret = array_slice($ret, 0, $nbUsers);
        }

        return $ret;
    }
}
