<?php

namespace XoopsModules\Yogurt;

// Configs.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

// -------------------------------------------------------------------------
// ------------------Configs user handler class -------------------
// -------------------------------------------------------------------------

/**
 * ConfigsHandler class.
 * This class provides simple mecanisme for Configs object
 */
class ConfigsHandler extends \XoopsPersistableObjectHandler
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
        parent::__construct($db, 'yogurt_configs', Configs::class, 'config_id', 'config_id');
    }

    /**
     * @param bool $isNew
     *
     * @return \XoopsObject
     */
    public function create($isNew = true)
    {
        $obj         = parent::create($isNew);
        $obj->helper = $this->helper;

        return $obj;
    }

    /**
     * retrieve a Configs
     *
     * @param int $id of the Configs
     * @return mixed reference to the {@link Configs} object, FALSE if failed
     */
    public function get($id = null, $fields = null)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_configs') . ' WHERE config_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_configs = new Configs();
            $yogurt_configs->assignVars($this->db->fetchArray($result));

            return $yogurt_configs;
        }

        return false;
    }

    /**
     * insert a new Configs in the database
     *
     * @param \XoopsObject $yogurt_configs reference to the {@link Configs}
     *                                     object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_configs, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_configs instanceof Configs) {
            return false;
        }
        if (!$yogurt_configs->isDirty()) {
            return true;
        }
        if (!$yogurt_configs->cleanVars()) {
            return false;
        }
        foreach ($yogurt_configs->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_configs->isNew()) {
            // addition / modification of a Configs
            //            $config_id = null;
            $yogurt_configs = new Configs();
            $format         = 'INSERT INTO %s (config_id, config_uid, pictures, audio, videos, groups, notes, friends, profile_contact, profile_general, profile_stats, suspension, backup_password, backup_email, end_suspension)';
            $format         .= 'VALUES (%u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %s, %s, %s)';
            $sql            = sprintf(
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
            $force          = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'config_id=%u, config_uid=%u, pictures=%u, audio=%u, videos=%u, groups=%u, notes=%u, friends=%u, profile_contact=%u, profile_general=%u, profile_stats=%u, suspension=%u, backup_password=%s, backup_email=%s, end_suspension=%s';
            $format .= ' WHERE config_id = %u';
            $sql    = sprintf(
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
        $yogurt_configs->assignVar('config_id', $config_id);

        return true;
    }

    /**
     * delete a Configs from the database
     *
     * @param \XoopsObject $yogurt_configs reference to the Configs to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_configs, $force = false)
    {
        if (!$yogurt_configs instanceof Configs) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE config_id = %u', $this->db->prefix('yogurt_configs'), $yogurt_configs->getVar('config_id'));
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
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link Configs} objects
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_configs');
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
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement} to match
     * @return int count of yogurt_configs
     */
    public function getCount(\CriteriaElement $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_configs');
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
     * delete yogurt_configs matching a set of conditions
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(\CriteriaElement $criteria = null, $force = true, $asObject = false)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_configs');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }
}
