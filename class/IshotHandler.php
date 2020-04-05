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

// -------------------------------------------------------------------------
// ------------------Ishot user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_ishothandler class.
 * This class provides simple mecanisme for Ishot object
 */
class IshotHandler extends \XoopsPersistableObjectHandler
{
    /**
     * @var Helper
     */
    public $helper;
    public $isAdmin;

    /**
     * Constructor
     * @param null|\XoopsDatabase              $db
     * @param null|\XoopsModules\Yogurt\Helper $helper
     */

    public function __construct(\XoopsDatabase $db = null, $helper = null)
    {
        /** @var \XoopsModules\Yogurt\Helper $this ->helper */
        if (null === $helper) {
            $this->helper = \XoopsModules\Yogurt\Helper::getInstance();
        } else {
            $this->helper = $helper;
        }
        $isAdmin = $this->helper->isUserAdmin();
        //        parent::__construct($db, 'yogurt_groups', Image::class, 'group_id', 'group_title');
    }

    /**
     * create a new Groups
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject Groups
     */
    public function create($isNew = true)
    {
        {
            $obj = parent::create($isNew);
            if ($isNew) {
                $obj->setNew();
            } else {
                $obj->unsetNew();
            }
            $obj->helper = $this->helper;

            return $obj;
        }
    }

    /**
     * retrieve a Ishot
     *
     * @param int $id of the Ishot
     * @return mixed reference to the {@link Ishot} object, FALSE if failed
     */
    public function get($id = null, $fields = null)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_ishot') . ' WHERE cod_ishot=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_ishot = new Ishot();
            $yogurt_ishot->assignVars($this->db->fetchArray($result));

            return $yogurt_ishot;
        }

        return false;
    }

    /**
     * insert a new Ishot in the database
     *
     * @param \XoopsObject $yogurt_ishot reference to the {@link Ishot}
     *                                   object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_ishot, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_ishot instanceof Ishot) {
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
            // ajout/modification d'un Ishot
            $yogurt_ishot = new Ishot();
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
        if ($force) {
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
     * delete a Ishot from the database
     *
     * @param \XoopsObject $yogurt_ishot reference to the Ishot to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_ishot, $force = false)
    {
        if (!$yogurt_ishot instanceof Ishot) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE cod_ishot = %u', $this->db->prefix('yogurt_ishot'), $yogurt_ishot->getVar('cod_ishot'));
        if ($force) {
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
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link Ishot} objects
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_ishot');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
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
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $yogurt_ishot = new Ishot();
            $yogurt_ishot->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_ishot;
            } else {
                $ret[$myrow['cod_ishot']] = &$yogurt_ishot;
            }
            unset($yogurt_ishot);
        }

        return $ret;
    }

    /**
     * count yogurt_ishots matching a condition
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_ishots
     */
    public function getCount(\CriteriaElement $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_ishot');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
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
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(\CriteriaElement $criteria = null, $force = true, $asObject = false)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_ishot');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
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
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
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
        while (false !== ($myrow = $this->db->fetchArray($result))) {
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
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
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
            while (false !== ($myrow = $this->db->fetchArray($result))) {
                $vetor[$i]['uid_voted']   = $myrow['uid_voted'];
                $vetor[$i]['uname']       = $myrow['uname'];
                $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
                $i++;
            }

            return $vetor;
        }
    }
}
