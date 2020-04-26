<?php declare(strict_types=1);

namespace XoopsModules\Yogurt;

// Friendrequest.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

use CriteriaElement;
use XoopsDatabase;
use XoopsObject;
use XoopsPersistableObjectHandler;

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

// -------------------------------------------------------------------------
// ------------------Friendrequest user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_friendrequesthandler class.
 * This class provides simple mecanisme for Friendrequest object
 */
class FriendrequestHandler extends XoopsPersistableObjectHandler
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
        parent::__construct($xoopsDatabase, 'yogurt_friendrequest', Friendrequest::class, 'friendreq_id', 'friendreq_id');
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
     * retrieve a Friendrequest
     *
     * @param int  $id of the Friendrequest
     * @param null $fields
     * @return mixed reference to the {@link Friendrequest} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendrequest') . ' WHERE friendreq_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $yogurt_friendrequest = new Friendrequest();
            $yogurt_friendrequest->assignVars($this->db->fetchArray($result));

            return $yogurt_friendrequest;
        }

        return false;
    }

    /**
     * insert a new Friendrequest in the database
     *
     * @param \XoopsObject $xoopsObject           reference to the {@link Friendrequest}
     *                                            object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Friendrequest) {
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
            // ajout/modification d'un Friendrequest
            $xoopsObject = new Friendrequest();
            $format      = 'INSERT INTO %s (friendreq_id, friendrequester_uid, friendrequestto_uid, date_created)';
            $format      .= 'VALUES (%u, %u, %u, %u)';
            $sql         = \sprintf(
                $format,
                $this->db->prefix('yogurt_friendrequest'),
                $friendreq_id,
                $friendrequester_uid,
                $friendrequestto_uid,
                $date_created
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'friendreq_id=%u, friendrequester_uid=%u, friendrequestto_uid=%u, date_created=%u';
            $format .= ' WHERE friendreq_id = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('yogurt_friendrequest'),
                $friendreq_id,
                $friendrequester_uid,
                $friendrequestto_uid,
                $date_created,
                $friendreq_id
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
        if (empty($friendreq_id)) {
            $friendreq_id = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('friendreq_id', $friendreq_id);

        return true;
    }

    /**
     * delete a Friendrequest from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Friendrequest to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Friendrequest) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE friendreq_id = %u',
            $this->db->prefix('yogurt_friendrequest'),
            $xoopsObject->getVar('friendreq_id')
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
     * retrieve yogurt_friendrequests from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Friendrequest} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendrequest');
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
            $yogurt_friendrequest = new Friendrequest();
            $yogurt_friendrequest->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_friendrequest;
            } else {
                $ret[$myrow['friendreq_id']] = &$yogurt_friendrequest;
            }
            unset($yogurt_friendrequest);
        }

        return $ret;
    }

    /**
     * count yogurt_friendrequests matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of yogurt_friendrequests
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_friendrequest');
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
     * delete yogurt_friendrequests matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_friendrequest');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }
}
