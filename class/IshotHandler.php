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

use CriteriaElement;
use XoopsDatabase;
use XoopsObject;
use XoopsPersistableObjectHandler;

/**
 * @category        Module
 * @package         suico
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * suico_ishothandler class.
 * This class provides simple mechanism for Ishot object
 */
class IshotHandler extends XoopsPersistableObjectHandler
{
    public $helper;
    public $isAdmin;

    /**
     * Constructor
     * @param \XoopsDatabase|null             $xoopsDatabase
     * @param \XoopsModules\Suico\Helper|null $helper
     */
    public function __construct(
        ?XoopsDatabase $xoopsDatabase = null,
        $helper = null
    ) {
        /** @var \XoopsModules\Suico\Helper $this->helper */
        if (null === $helper) {
            $this->helper = Helper::getInstance();
        } else {
            $this->helper = $helper;
        }
        $isAdmin = $this->helper->isUserAdmin();
        //        parent::__construct($db, 'suico_groups', Image::class, 'group_id', 'group_title');
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
     * retrieve a Ishot
     *
     * @param int|null $id of the Ishot
     * @param null $fields
     * @return mixed reference to the {@link Ishot} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('suico_ishot') . ' WHERE cod_ishot=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $suico_ishot = new Ishot();
            $suico_ishot->assignVars($this->db->fetchArray($result));
            return $suico_ishot;
        }
        return false;
    }

    /**
     * insert a new Ishot in the database
     *
     * @param \XoopsObject $xoopsObject  reference to the {@link Ishot}
     *                                   object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Ishot) {
            return false;
        }
        if (!$xoopsObject->isDirty()) {
            return true;
        }
        if (!$xoopsObject->cleanVars()) {
            return false;
        }
        $cod_ishot = $uid_voter = $uid_voted = $ishot = '';
        foreach ($xoopsObject->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        //        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($xoopsObject->isNew()) {
            // ajout/modification d'un Ishot
            $xoopsObject = new Ishot();
            $format      = 'INSERT INTO %s (cod_ishot, uid_voter, uid_voted, ishot, DATE)';
            $format      .= 'VALUES (%u, %u, %u, %u, %s)';
            $sql         = \sprintf(
                $format,
                $this->db->prefix('suico_ishot'),
                $cod_ishot,
                $uid_voter,
                $uid_voted,
                $ishot,
                $this->db->quoteString($date)
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'cod_ishot=%u, uid_voter=%u, uid_voted=%u, ishot=%u, date_created=%s';
            $format .= ' WHERE cod_ishot = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('suico_ishot'),
                $cod_ishot,
                $uid_voter,
                $uid_voted,
                $ishot,
                $this->db->quoteString($date),
                $cod_ishot
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
        if (empty($cod_ishot)) {
            $cod_ishot = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('cod_ishot', $cod_ishot);
        return true;
    }

    /**
     * delete a Ishot from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Ishot to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Ishot) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE cod_ishot = %u',
            $this->db->prefix('suico_ishot'),
            $xoopsObject->getVar('cod_ishot')
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
     * retrieve suico_ishots from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Ishot} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('suico_ishot');
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
            $suico_ishot = new Ishot();
            $suico_ishot->assignVars($myrow);
            if ($id_as_key) {
                $ret[$myrow['cod_ishot']] = &$suico_ishot;
            } else {
                $ret[] = &$suico_ishot;
            }
            unset($suico_ishot);
        }
        return $ret;
    }

    /**
     * count suico_ishots matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link CriteriaElement} to match
     * @return int count of suico_ishots
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('suico_ishot');
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
     * delete suico_ishots matching a set of conditions
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link CriteriaElement}
     * @param bool                                 $force
     * @param bool                                 $asObject
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(
        ?CriteriaElement $criteriaElement = null,
        $force = true,
        $asObject = false
    ) {
        $sql = 'DELETE FROM ' . $this->db->prefix('suico_ishot');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
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
        $sql = 'SELECT DISTINCTROW uname, user_avatar, uid_voted, COUNT(cod_ishot) AS qtd FROM ' . $this->db->prefix(
                'suico_ishot'
            ) . ', ' . $this->db->prefix(
                'users'
            );
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        //attention here this is kind of a hack
        $sql .= ' AND uid = uid_voted';
        if ('' !== $criteria->getGroupby()) {
            $sql .= $criteria->getGroupby();
        }
        if ('' !== $criteria->getSort()) {
            $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
        }
        $limit  = $criteria->getLimit();
        $start  = $criteria->getStart();
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
    public function getHotFriends(
        $criteria = null,
        $id_as_key = false
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT uname, user_avatar, uid_voted FROM ' . $this->db->prefix(
                'suico_ishot'
            ) . ', ' . $this->db->prefix(
                'users'
            );
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = uid_voted AND ishot=1';
            if ('' !== $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit  = $criteria->getLimit();
            $start  = $criteria->getStart();
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
