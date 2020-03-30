<?php

namespace XoopsModules\Yogurt;

// Friendpetition.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';

// -------------------------------------------------------------------------
// ------------------Friendpetition user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_friendpetitionhandler class.
 * This class provides simple mecanisme for Friendpetition object
 */
class FriendpetitionHandler extends \XoopsObjectHandler
{
    /**
     * create a new Friendpetition
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject Friendpetition
     */
    public function create($isNew = true)
    {
        $yogurt_friendpetition = new Friendpetition();
        if ($isNew) {
            $yogurt_friendpetition->setNew();
        } else {
            $yogurt_friendpetition->unsetNew();
        }

        return $yogurt_friendpetition;
    }

    /**
     * retrieve a Friendpetition
     *
     * @param int $id of the Friendpetition
     * @return mixed reference to the {@link Friendpetition} object, FALSE if failed
     */
    public function get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendpetition') . ' WHERE friendpet_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_friendpetition = new Friendpetition();
            $yogurt_friendpetition->assignVars($this->db->fetchArray($result));

            return $yogurt_friendpetition;
        }

        return false;
    }

    /**
     * insert a new Friendpetition in the database
     *
     * @param \XoopsObject $yogurt_friendpetition reference to the {@link Friendpetition}
     *                                            object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_friendpetition, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_friendpetition instanceof Friendpetition) {
            return false;
        }
        if (!$yogurt_friendpetition->isDirty()) {
            return true;
        }
        if (!$yogurt_friendpetition->cleanVars()) {
            return false;
        }
        foreach ($yogurt_friendpetition->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_friendpetition->isNew()) {
            // ajout/modification d'un Friendpetition
            $yogurt_friendpetition = new Friendpetition();
            $format = 'INSERT INTO %s (friendpet_id, petitioner_uid, petioned_uid)';
            $format .= 'VALUES (%u, %u, %u)';
            $sql = sprintf($format, $this->db->prefix('yogurt_friendpetition'), $friendpet_id, $petitioner_uid, $petioned_uid);
            $force = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'friendpet_id=%u, petitioner_uid=%u, petioned_uid=%u';
            $format .= ' WHERE friendpet_id = %u';
            $sql = sprintf($format, $this->db->prefix('yogurt_friendpetition'), $friendpet_id, $petitioner_uid, $petioned_uid, $friendpet_id);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($friendpet_id)) {
            $friendpet_id = $this->db->getInsertId();
        }
        $yogurt_friendpetition->assignVar('friendpet_id', $friendpet_id);

        return true;
    }

    /**
     * delete a Friendpetition from the database
     *
     * @param \XoopsObject $yogurt_friendpetition reference to the Friendpetition to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_friendpetition, $force = false)
    {
        if (!$yogurt_friendpetition instanceof Friendpetition) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE friendpet_id = %u', $this->db->prefix('yogurt_friendpetition'), $yogurt_friendpetition->getVar('friendpet_id'));
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
     * retrieve yogurt_friendpetitions from the database
     *
     * @param \CriteriaElement $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool            $id_as_key use the UID as key for the array?
     * @return array array of {@link Friendpetition} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = [];
        $limit = $start = 0;
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendpetition');
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
            $yogurt_friendpetition = new Friendpetition();
            $yogurt_friendpetition->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_friendpetition;
            } else {
                $ret[$myrow['friendpet_id']] = &$yogurt_friendpetition;
            }
            unset($yogurt_friendpetition);
        }

        return $ret;
    }

    /**
     * count yogurt_friendpetitions matching a condition
     *
     * @param \CriteriaElement $criteria {@link \CriteriaElement} to match
     * @return int count of yogurt_friendpetitions
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_friendpetition');
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
     * delete yogurt_friendpetitions matching a set of conditions
     *
     * @param \CriteriaElement $criteria {@link \CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_friendpetition');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }
}
