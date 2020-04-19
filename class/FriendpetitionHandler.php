<?php declare(strict_types=1);

namespace XoopsModules\Yogurt;

// Friendpetition.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

use CriteriaElement;
use XoopsDatabase;
use XoopsObject;
use XoopsPersistableObjectHandler;

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

// -------------------------------------------------------------------------
// ------------------Friendpetition user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_friendpetitionhandler class.
 * This class provides simple mecanisme for Friendpetition object
 */
class FriendpetitionHandler extends XoopsPersistableObjectHandler
{
    public $helper;

    public $isAdmin;

    /**
     * Constructor
     * @param \XoopsDatabase|null              $xoopsDatabase
     * @param \XoopsModules\Yogurt\Helper|null $helper
     */
    public function __construct(
        ?XoopsDatabase $xoopsDatabase = null,
        $helper = null
    ) {
        /** @var \XoopsModules\Yogurt\Helper $this ->helper */
        if (null === $helper) {
            $this->helper = Helper::getInstance();
        } else {
            $this->helper = $helper;
        }
        $isAdmin = $this->helper->isUserAdmin();
        parent::__construct($xoopsDatabase, 'yogurt_friendpetition', Friendpetition::class, 'friendpet_id', 'friendpet_id');
    }

    /**
     * @param bool $isNew
     *
     * @return \XoopsObject
     */
    public function create($isNew = true)
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

    /**
     * retrieve a Friendpetition
     *
     * @param int  $id of the Friendpetition
     * @param null $fields
     * @return mixed reference to the {@link Friendpetition} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendpetition') . ' WHERE friendpet_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $yogurt_friendpetition = new Friendpetition();
            $yogurt_friendpetition->assignVars($this->db->fetchArray($result));

            return $yogurt_friendpetition;
        }

        return false;
    }

    /**
     * insert a new Friendpetition in the database
     *
     * @param \XoopsObject $xoopsObject           reference to the {@link Friendpetition}
     *                                            object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Friendpetition) {
            return false;
        }
        if (!$xoopsObject->isDirty()) {
            return true;
        }
        if (!$xoopsObject->cleanVars()) {
            return false;
        }
        foreach ($xoopsObject->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($xoopsObject->isNew()) {
            // ajout/modification d'un Friendpetition
            $xoopsObject = new Friendpetition();
            $format      = 'INSERT INTO %s (friendpet_id, petitioner_uid, petitionto_uid)';
            $format      .= 'VALUES (%u, %u, %u)';
            $sql         = sprintf(
                $format,
                $this->db->prefix('yogurt_friendpetition'),
                $friendpet_id,
                $petitioner_uid,
                $petitionto_uid
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'friendpet_id=%u, petitioner_uid=%u, petitionto_uid=%u';
            $format .= ' WHERE friendpet_id = %u';
            $sql    = sprintf(
                $format,
                $this->db->prefix('yogurt_friendpetition'),
                $friendpet_id,
                $petitioner_uid,
                $petitionto_uid,
                $friendpet_id
            );
        }
        if ($force) {
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
        $xoopsObject->assignVar('friendpet_id', $friendpet_id);

        return true;
    }

    /**
     * delete a Friendpetition from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Friendpetition to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Friendpetition) {
            return false;
        }
        $sql = sprintf(
            'DELETE FROM %s WHERE friendpet_id = %u',
            $this->db->prefix('yogurt_friendpetition'),
            $xoopsObject->getVar('friendpet_id')
        );
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
     * retrieve yogurt_friendpetitions from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Friendpetition} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendpetition');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
            if ('' !== $criteriaElement->getSort()) {
                $sql .= ' ORDER BY ' . $criteriaElement->getSort() . ' ' . $criteriaElement->getOrder();
            }
            $limit = $criteriaElement->getLimit();
            $start = $criteriaElement->getStart();
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
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of yogurt_friendpetitions
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_friendpetition');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        [$count] = $this->db->fetchRow($result);

        return (int)$count;
    }

    /**
     * delete yogurt_friendpetitions matching a set of conditions
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement}
     * @param bool                                 $force
     * @param bool                                 $asObject
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(
        ?CriteriaElement $criteriaElement = null,
        $force = true,
        $asObject = false
    ) {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_friendpetition');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }
}
