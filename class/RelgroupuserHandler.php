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

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * suico_relgroupuserhandler class.
 * This class provides simple mechanism for Relgroupuser object
 */
class RelgroupuserHandler extends XoopsPersistableObjectHandler
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
        parent::__construct($xoopsDatabase, 'suico_relgroupuser', Relgroupuser::class, 'rel_id', 'rel_id');
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
     * retrieve a Relgroupuser
     *
     * @param int|null $id of the Relgroupuser
     * @param null $fields
     * @return mixed reference to the {@link Relgroupuser} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('suico_relgroupuser') . ' WHERE rel_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $suico_relgroupuser = new Relgroupuser();
            $suico_relgroupuser->assignVars($this->db->fetchArray($result));
            return $suico_relgroupuser;
        }
        return false;
    }

    /**
     * insert a new Relgroupuser in the database
     *
     * @param \XoopsObject $xoopsObject         reference to the {@link Relgroupuser}
     *                                          object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Relgroupuser) {
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
            // ajout/modification d'un Relgroupuser
            $xoopsObject = new Relgroupuser();
            $format      = 'INSERT INTO %s (rel_id, rel_group_id, rel_user_uid)';
            $format      .= 'VALUES (%u, %u, %u)';
            $sql         = \sprintf($format, $this->db->prefix('suico_relgroupuser'), $rel_id, $rel_group_id, $rel_user_uid);
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'rel_id=%u, rel_group_id=%u, rel_user_uid=%u';
            $format .= ' WHERE rel_id = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('suico_relgroupuser'),
                $rel_id,
                $rel_group_id,
                $rel_user_uid,
                $rel_id
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
        if (empty($rel_id)) {
            $rel_id = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('rel_id', $rel_id);
        return true;
    }

    /**
     * delete a Relgroupuser from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Relgroupuser to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Relgroupuser) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE rel_id = %u',
            $this->db->prefix('suico_relgroupuser'),
            $xoopsObject->getVar('rel_id')
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
     * retrieve suico_relgroupusers from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Relgroupuser} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('suico_relgroupuser');
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
            $suico_relgroupuser = new Relgroupuser();
            $suico_relgroupuser->assignVars($myrow);
            if ($id_as_key) {
                $ret[$myrow['rel_id']] = &$suico_relgroupuser;
            } else {
                $ret[] = &$suico_relgroupuser;
            }
            unset($suico_relgroupuser);
        }
        return $ret;
    }

    /**
     * count suico_relgroupusers matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of suico_relgroupusers
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('suico_relgroupuser');
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
     * delete suico_relgroupusers matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('suico_relgroupuser');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * @param      $countGroups
     * @param null $criteria
     * @param int  $shuffle
     * @return array
     */
    public function getGroups(
        $countGroups,
        $criteria = null,
        $shuffle = 1
    ) {
        $ret = [];
        $sql = 'SELECT rel_id, rel_group_id, rel_user_uid, group_title, group_desc, group_img, owner_uid FROM ' . $this->db->prefix(
                'suico_groups'
            ) . ', ' . $this->db->prefix(
                'suico_relgroupuser'
            );
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql   .= ' AND group_id = rel_group_id ';
            $sort  = 'group_title';
            $order = 'ASC';
            if ('' !== $sort) {
                $sql .= ' ORDER BY ' . $sort . ' ' . $order;
            }
            $limit  = $criteria->getLimit();
            $start  = $criteria->getStart();
            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;
            while (false !== ($myrow = $this->db->fetchArray($result))) {
                $vetor[$i]['title']    = $myrow['group_title'];
                $vetor[$i]['desc']     = $myrow['group_desc'];
                $vetor[$i]['img']      = $myrow['group_img'];
                $vetor[$i]['id']       = $myrow['rel_id'];
                $vetor[$i]['uid']      = $myrow['owner_uid'];
                $vetor[$i]['group_id'] = $myrow['rel_group_id'];
                $i++;
            }
            if (1 === $shuffle) {
                \shuffle($vetor);
                $vetor = \array_slice($vetor, 0, $countGroups);
            }
            return $vetor;
        }
    }

    /**
     * @param     $groupId
     * @param     $start
     * @param     $nbUsers
     * @param int $isShuffle
     * @return array
     */
    public function getUsersFromGroup(
        $groupId,
        $start,
        $nbUsers,
        $isShuffle = 0
    ) {
        $ret    = [];
        $sql    = 'SELECT rel_group_id, rel_user_uid, owner_uid, uname, user_avatar, uid FROM ' . $this->db->prefix(
                'users'
            ) . ', ' . $this->db->prefix(
                'suico_groups'
            ) . ', ' . $this->db->prefix(
                'suico_relgroupuser'
            );
        $sql    .= ' WHERE rel_user_uid = uid AND rel_group_id = group_id AND group_id =' . $groupId . ' GROUP BY rel_user_uid ';
        $result = $this->db->query($sql, $nbUsers, $start);
        $ret    = [];
        $i      = 0;
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $ret[$i]['uid']     = $myrow['uid'];
            $ret[$i]['uname']   = $myrow['uname'];
            $ret[$i]['avatar']  = $myrow['user_avatar'];
            $isOwner            = $myrow['rel_user_uid'] === $myrow['owner_uid'] ? 1 : 0;
            $ret[$i]['isOwner'] = $isOwner;
            $i++;
        }
        if (1 === $isShuffle) {
            \shuffle($ret);
            $ret = \array_slice($ret, 0, $nbUsers);
        }
        return $ret;
    }
}
