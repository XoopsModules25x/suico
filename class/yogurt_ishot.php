<?php
// $Id: yogurt_ishot.php,v 1.5 2007/08/31 00:47:04 marcellobrandao Exp $ //
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
include_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * yogurt_ishot class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class yogurt_ishot extends XoopsObject
{
    public $db;

    // constructor

    /**
     * yogurt_ishot constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
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
            $sql    = 'SELECT cod_ishot FROM ' . $db->prefix('yogurt_ishot') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = $myrow['yogurt_ishot_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_ishot') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = new yogurt_ishot($myrow);
            }
        }
        return $ret;
    }
}

// -------------------------------------------------------------------------
// ------------------yogurt_ishot user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_ishothandler class.
 * This class provides simple mecanisme for yogurt_ishot object
 */
class Xoopsyogurt_ishotHandler extends XoopsObjectHandler
{

    /**
     * create a new yogurt_ishot
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject yogurt_ishot
     */
    public function create($isNew = true)
    {
        $yogurt_ishot = new yogurt_ishot();
        if ($isNew) {
            $yogurt_ishot->setNew();
        } else {
            $yogurt_ishot->unsetNew();
        }

        return $yogurt_ishot;
    }

    /**
     * retrieve a yogurt_ishot
     *
     * @param int $id of the yogurt_ishot
     * @return mixed reference to the {@link yogurt_ishot} object, FALSE if failed
     */
    public function &get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_ishot') . ' WHERE cod_ishot=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_ishot = new yogurt_ishot();
            $yogurt_ishot->assignVars($this->db->fetchArray($result));
            return $yogurt_ishot;
        }
        return false;
    }

    /**
     * insert a new yogurt_ishot in the database
     *
     * @param \XoopsObject $yogurt_ishot reference to the {@link yogurt_ishot}
     *                                   object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(XoopsObject $yogurt_ishot, $force = false)
    {
        global $xoopsConfig;
        if ('yogurt_ishot' != get_class($yogurt_ishot)) {
            return false;
        }
        if (!$yogurt_ishot->isDirty()) {
            return true;
        }
        if (!$yogurt_ishot->cleanVars()) {
            return false;
        }
        foreach ($yogurt_ishot->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_ishot->isNew()) {
            // ajout/modification d'un yogurt_ishot
            $yogurt_ishot = new yogurt_ishot();
            $format       = 'INSERT INTO %s (cod_ishot, uid_voter, uid_voted, ishot, DATE)';
            $format       .= 'VALUES (%u, %u, %u, %u, %s)';
            $sql          = sprintf($format, $this->db->prefix('yogurt_ishot'), $cod_ishot, $uid_voter, $uid_voted, $ishot, $this->db->quoteString($date));
            $force        = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'cod_ishot=%u, uid_voter=%u, uid_voted=%u, ishot=%u, date=%s';
            $format .= ' WHERE cod_ishot = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_ishot'), $cod_ishot, $uid_voter, $uid_voted, $ishot, $this->db->quoteString($date), $cod_ishot);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($cod_ishot)) {
            $cod_ishot = $this->db->getInsertId();
        }
        $yogurt_ishot->assignVar('cod_ishot', $cod_ishot);
        return true;
    }

    /**
     * delete a yogurt_ishot from the database
     *
     * @param \XoopsObject $yogurt_ishot reference to the yogurt_ishot to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(XoopsObject $yogurt_ishot, $force = false)
    {
        if ('yogurt_ishot' != get_class($yogurt_ishot)) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE cod_ishot = %u', $this->db->prefix('yogurt_ishot'), $yogurt_ishot->getVar('cod_ishot'));
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
     * retrieve yogurt_ishots from the database
     *
     * @param \XoopsObject $criteria  {@link CriteriaElement} conditions to be met
     * @param bool   $id_as_key use the UID as key for the array?
     * @return array array of {@link yogurt_ishot} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_ishot');
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
            $yogurt_ishot = new yogurt_ishot();
            $yogurt_ishot->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $yogurt_ishot;
            } else {
                $ret[$myrow['cod_ishot']] =& $yogurt_ishot;
            }
            unset($yogurt_ishot);
        }
        return $ret;
    }

    /**
     * count yogurt_ishots matching a condition
     *
     * @param \XoopsObject $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_ishots
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_ishot');
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
     * delete yogurt_ishots matching a set of conditions
     *
     * @param \XoopsObject $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_ishot');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * @param null $criteria
     * @return array
     */
    public function getHottest($criteria = null)
    {
        $sql = 'SELECT DISTINCTROW uname, user_avatar, uid_voted, COUNT(cod_ishot) AS qtd FROM ' . $this->db->prefix('yogurt_ishot') . ', ' . $this->db->prefix('users');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        //attention here this is kind of a hack
        $sql .= ' AND uid = uid_voted';
        if ('' != $criteria->getGroupby()) {
            $sql .= $criteria->getGroupby();
        }
        if ('' != $criteria->getSort()) {
            $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
        }
        $limit = $criteria->getLimit();
        $start = $criteria->getStart();

        $result = $this->db->query($sql, $limit, $start);
        $vetor  = [];
        $i      = 0;
        while ($myrow = $this->db->fetchArray($result)) {
            $vetor[$i]['qtd']         = $myrow['qtd'];
            $vetor[$i]['uid_voted']   = $myrow['uid_voted'];
            $vetor[$i]['uname']       = $myrow['uname'];
            $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
            $i++;
        }

        return $vetor;
    }

    /**
     * @param null $criteria
     * @param bool $id_as_key
     * @return array
     */
    public function getHotFriends($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT uname, user_avatar, uid_voted FROM ' . $this->db->prefix('yogurt_ishot') . ', ' . $this->db->prefix('users');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = uid_voted AND ishot=1';
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();

            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;
            while ($myrow = $this->db->fetchArray($result)) {
                $vetor[$i]['uid_voted']   = $myrow['uid_voted'];
                $vetor[$i]['uname']       = $myrow['uname'];
                $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
                $i++;
            }

            return $vetor;
        }
    }
}
