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
 * @category        Module
 * @package         yogurt
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Bruno Barthez, Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */
 
use CriteriaElement;
use XoopsDatabase;
use XoopsObject;
use XoopsPersistableObjectHandler;

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

// -------------------------------------------------------------------------
// ------------------Configs user handler class -------------------
// -------------------------------------------------------------------------

/**
 * ConfigsHandler class.
 * This class provides simple mecanisme for Configs object
 */
class ConfigsHandler extends XoopsPersistableObjectHandler
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

        parent::__construct($xoopsDatabase, 'yogurt_configs', Configs::class, 'config_id', 'config_id');
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
     * retrieve a Configs
     *
     * @param int  $id of the Configs
     * @param null $fields
     * @return mixed reference to the {@link Configs} object, FALSE if failed
     */

    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_configs') . ' WHERE config_id=' . $id;

        if (!$result = $this->db->query($sql)) {
            return false;
        }

        $numrows = $this->db->getRowsNum($result);

        if (1 === $numrows) {
            $yogurt_configs = new Configs();

            $yogurt_configs->assignVars($this->db->fetchArray($result));

            return $yogurt_configs;
        }

        return false;
    }

    /**
     * insert a new Configs in the database
     *
     * @param \XoopsObject $xoopsObject    reference to the {@link Configs}
     *                                     object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */

    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;

        if (!$xoopsObject instanceof Configs) {
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
            // addition / modification of a Configs

            //            $config_id = null;

            $xoopsObject = new Configs();

            $format = 'INSERT INTO %s (config_id, config_uid, pictures, audio, videos, groups, notes, friends, profile_contact, profile_general, profile_stats, suspension, backup_password, backup_email, end_suspension)';

            $format .= 'VALUES (%u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %s, %s, %s)';

            $sql = \sprintf(
                $format,
                $this->db->prefix('yogurt_configs'),
                $config_id,
                $config_uid,
                $pictures,
                $audio,
                $videos,
                $groups,
                $notes,
                $friends,
                $profile_contact,
                $profile_general,
                $profile_stats,
                $suspension,
                $this->db->quoteString($backup_password),
                $this->db->quoteString($backup_email),
                $this->db->quoteString($end_suspension)
            );

            $force = true;
        } else {
            $format = 'UPDATE %s SET ';

            $format .= 'config_id=%u, config_uid=%u, pictures=%u, audio=%u, videos=%u, groups=%u, notes=%u, friends=%u, profile_contact=%u, profile_general=%u, profile_stats=%u, suspension=%u, backup_password=%s, backup_email=%s, end_suspension=%s';

            $format .= ' WHERE config_id = %u';

            $sql = \sprintf(
                $format,
                $this->db->prefix('yogurt_configs'),
                $config_id,
                $config_uid,
                $pictures,
                $audio,
                $videos,
                $groups,
                $notes,
                $friends,
                $profile_contact,
                $profile_general,
                $profile_stats,
                $suspension,
                $this->db->quoteString($backup_password),
                $this->db->quoteString($backup_email),
                $this->db->quoteString($end_suspension),
                $config_id
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

        if (empty($config_id)) {
            $config_id = $this->db->getInsertId();
        }

        $xoopsObject->assignVar('config_id', $config_id);

        return true;
    }

    /**
     * delete a Configs from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Configs to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */

    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Configs) {
            return false;
        }

        $sql = \sprintf(
            'DELETE FROM %s WHERE config_id = %u',
            $this->db->prefix('yogurt_configs'),
            $xoopsObject->getVar('config_id')
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
     * retrieve yogurt_configs from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Configs} objects
     */

    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret = [];

        $limit = $start = 0;

        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_configs');

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
            $yogurt_configs = new Configs();

            $yogurt_configs->assignVars($myrow);

            if (!$id_as_key) {
                $ret[] = &$yogurt_configs;
            } else {
                $ret[$myrow['config_id']] = &$yogurt_configs;
            }

            unset($yogurt_configs);
        }

        return $ret;
    }

    /**
     * count yogurt_configs matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of yogurt_configs
     */

    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_configs');

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
     * delete yogurt_configs matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_configs');

        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }

        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }
}
