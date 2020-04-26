<?php

declare(strict_types=1);

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
 * Module: Yogurt
 *
 * @category        Module
 * @package         yogurt
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */


// Visitors.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

use CriteriaElement;
use XoopsDatabase;
use XoopsObject;
use XoopsPersistableObjectHandler;

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

// -------------------------------------------------------------------------
// ------------------Yogurt\Visitors user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_visitorshandler class.
 * This class provides simple mecanisme for Yogurt\Visitors object
 */
class VisitorsHandler extends XoopsPersistableObjectHandler
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
        parent::__construct($xoopsDatabase, 'yogurt_visitors', Visitors::class, 'cod_visit', 'uname_visitor');
    }

    /**
     * create a new Groups
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject Groups
     */
    public function create(
        $isNew = true
    ) {
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
     * retrieve a Yogurt\Visitors
     *
     * @param int  $id of the Yogurt\Visitors
     * @param null $fields
     * @return mixed reference to the {@link yogurt_visitors} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_visitors') . ' WHERE cod_visit=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $visitors = new Visitors();
            $visitors->assignVars($this->db->fetchArray($result));

            return $visitors;
        }

        return false;
    }

    /**
     * insert a new Visitors in the database
     *
     * @param \XoopsObject $xoopsObject     reference to the {@link Visitors}
     *                                      object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Visitors) {
            return false;
        }
        if (!$xoopsObject->isDirty()) {
            return true;
        }
        if (!$xoopsObject->cleanVars()) {
            return false;
        }
        $cod_visit = $uid_owner = $uid_visitor = '';

        foreach ($xoopsObject->cleanVars as $k => $v) {
            ${$k} = $v;
        }
//        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';

        if ($xoopsObject->isNew()) {
            // ajout/modification d'un Yogurt\Visitors
            $xoopsObject = new Visitors();
            $format      = 'INSERT INTO %s (cod_visit, uid_owner, uid_visitor,uname_visitor)';
            $format      .= 'VALUES (%u, %u, %u, %s)';
            $sql         = \sprintf(
                $format,
                $this->db->prefix('yogurt_visitors'),
                $cod_visit,
                $uid_owner,
                $uid_visitor,
                $this->db->quoteString($uname_visitor)
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'cod_visit=%u, uid_owner=%u, uid_visitor=%u, uname_visitor=%s ';
            $format .= ' WHERE cod_visit = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('yogurt_visitors'),
                $cod_visit,
                $uid_owner,
                $uid_visitor,
                $this->db->quoteString($uname_visitor),
                $cod_visit
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
        if (empty($cod_visit)) {
            $cod_visit = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('cod_visit', $cod_visit);

        return true;
    }

    /**
     * delete a yogurt_visitors from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Yogurt\Visitors to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Visitors) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE cod_visit = %u',
            $this->db->prefix('yogurt_visitors'),
            $xoopsObject->getVar('cod_visit')
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
     * retrieve yogurt_visitorss from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Visitors} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_visitors');
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
            $visitors = new Visitors();
            $visitors->assignVars($myrow);
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
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of yogurt_visitorss
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_visitors');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        [$count] = $this->db->fetchRow($result);

        return $count;
    }

    /**
     * delete yogurt_visitorss matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_visitors');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if ($force) {
            if (!$result = $this->db->queryF($sql)) {
                return false;
            }
        } elseif (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function purgeVisits()
    {
        $sql = 'DELETE FROM ' . $this->db->prefix(
            'yogurt_visitors'
        ) . ' WHERE (date_visited<(DATE_SUB(NOW(), INTERVAL 7 DAY))) ';

        if (!$result = $this->db->queryF($sql)) {
            return false;
        }

        return true;
    }
}
