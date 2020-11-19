<?php

declare(strict_types=1);

namespace XoopsModules\Suico;

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @category        Module
 * @package         suico
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Bruno Barthez, Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use CriteriaElement;
use XoopsDatabase;
use XoopsObject;
use XoopsPersistableObjectHandler;
use XoopsModules\Suico\Helper;

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * suico_friendrequesthandler class.
 * This class provides simple mechanism for Friendrequest object
 */
class FriendrequestHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var \XoopsModules\Suico\Helper
     */
    public $helper;
    public $isAdmin;

    /**
     * Constructor
     * @param \XoopsDatabase|null $xoopsDatabase
     * @param Helper|null         $helper
     */
    public function __construct(
        ?XoopsDatabase $xoopsDatabase = null,
        $helper = null
    ) {
        if (null === $helper) {
            $this->helper = Helper::getInstance();
        } else {
            $this->helper = $helper;
        }
        $isAdmin = $this->helper->isUserAdmin();
        parent::__construct($xoopsDatabase, 'suico_friendrequests', Friendrequest::class, 'friendreq_id', 'friendreq_id');
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
     * @param int|null $id of the Friendrequest
     * @param null $fields
     * @return mixed reference to the {@link Friendrequest} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('suico_friendrequests') . ' WHERE friendreq_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $suico_friendrequest = new Friendrequest();
            $suico_friendrequest->assignVars($this->db->fetchArray($result));
            return $suico_friendrequest;
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
                $this->db->prefix('suico_friendrequests'),
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
                $this->db->prefix('suico_friendrequests'),
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
            $this->db->prefix('suico_friendrequests'),
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
     * retrieve suico_friendrequests from the database
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('suico_friendrequests');
        if (isset($criteriaElement) && $criteriaElement instanceof \CriteriaElement) {
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
            $suico_friendrequest = new Friendrequest();
            $suico_friendrequest->assignVars($myrow);
            if ($id_as_key) {
                $ret[$myrow['friendreq_id']] = &$suico_friendrequest;
            } else {
                $ret[] = &$suico_friendrequest;
            }
            unset($suico_friendrequest);
        }
        return $ret;
    }

    /**
     * count suico_friendrequests matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of suico_friendrequests
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('suico_friendrequests');
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
     * delete suico_friendrequests matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('suico_friendrequests');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }
}
