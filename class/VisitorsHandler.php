<?php

namespace XoopsModules\Yogurt;

// Visitors.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

// -------------------------------------------------------------------------
// ------------------Yogurt\Visitors user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_visitorshandler class.
 * This class provides simple mecanisme for Yogurt\Visitors object
 */
class VisitorsHandler extends \XoopsPersistableObjectHandler
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
        parent::__construct($db, 'yogurt_visitors', Visitors::class, 'cod_visit', 'uname_visitor');
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
     * retrieve a Yogurt\Visitors
     *
     * @param int $id of the Yogurt\Visitors
     * @return mixed reference to the {@link yogurt_visitors} object, FALSE if failed
     */
    public function get($id = null, $fields = null)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_visitors') . ' WHERE cod_visit=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_visitors = new Visitors();
            $yogurt_visitors->assignVars($this->db->fetchArray($result));

            return $yogurt_visitors;
        }

        return false;
    }

    /**
     * insert a new Visitors in the database
     *
     * @param \XoopsObject $yogurt_visitors reference to the {@link Yogurt\Visitors}
     *                                      object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_visitors, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_visitors instanceof Visitors) {
            return false;
        }
        if (!$yogurt_visitors->isDirty()) {
            return true;
        }
        if (!$yogurt_visitors->cleanVars()) {
            return false;
        }
        foreach ($yogurt_visitors->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_visitors->isNew()) {
            // ajout/modification d'un Yogurt\Visitors
            $yogurt_visitors = new Visitors();
            $format          = 'INSERT INTO %s (cod_visit, uid_owner, uid_visitor,uname_visitor)';
            $format          .= 'VALUES (%u, %u, %u, %s)';
            $sql             = sprintf($format, $this->db->prefix('yogurt_visitors'), $cod_visit, $uid_owner, $uid_visitor, $this->db->quoteString($uname_visitor));
            $force           = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'cod_visit=%u, uid_owner=%u, uid_visitor=%u, uname_visitor=%s ';
            $format .= ' WHERE cod_visit = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_visitors'), $cod_visit, $uid_owner, $uid_visitor, $this->db->quoteString($uname_visitor), $cod_visit);
        }
        if ($force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($cod_visit)) {
            $cod_visit = $this->db->getInsertId();
        }
        $yogurt_visitors->assignVar('cod_visit', $cod_visit);

        return true;
    }

    /**
     * delete a yogurt_visitors from the database
     *
     * @param \XoopsObject $yogurt_visitors reference to the Yogurt\Visitors to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_visitors, $force = false)
    {
        if (!$yogurt_visitors instanceof Visitors) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE cod_visit = %u', $this->db->prefix('yogurt_visitors'), $yogurt_visitors->getVar('cod_visit'));
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
     * retrieve yogurt_visitorss from the database
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link Yogurt\Visitors} objects
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_visitors');
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
            $yogurt_visitors = new Visitors();
            $yogurt_visitors->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_visitors;
            } else {
                $ret[$myrow['cod_visit']] = &$yogurt_visitors;
            }
            unset($yogurt_visitors);
        }

        return $ret;
    }

    /**
     * count yogurt_visitorss matching a condition
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement} to match
     * @return int count of yogurt_visitorss
     */
    public function getCount(\CriteriaElement $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_visitors');
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
     * delete yogurt_visitorss matching a set of conditions
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement}
     * @param bool                                 $force
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(\CriteriaElement $criteria = null, $force = true, $asObject = false)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_visitors');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if ($force) {
            if (!$result = $this->db->queryF($sql)) {
                return false;
            }
        } else {
            if (!$result = $this->db->query($sql)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function purgeVisits()
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_visitors') . ' WHERE (datetime<(DATE_SUB(NOW(), INTERVAL 7 DAY))) ';

        if (!$result = $this->db->queryF($sql)) {
            return false;
        }

        return true;
    }
}
