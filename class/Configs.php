<?php

namespace XoopsModules\Yogurt;

// Configs.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Configs class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class Configs extends \XoopsObject
{
    public $db;

    // constructor

    /**
     * Configs constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        /** @var  Helper $helper */
        $this->helper     = Helper::getInstance();
        $this->permHelper = new \Xmf\Module\Helper\Permission();
        $this->db         = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('config_id', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('config_uid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('pictures', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('audio', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('videos', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('groups', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('notes', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('friends', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('profile_contact', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('profile_general', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('profile_stats', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('suspension', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('backup_password', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('backup_email', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('end_suspension', XOBJ_DTYPE_TXTBOX, null, false);
        if (!empty($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            } else {
                $this->load((int)$id);
            }
        } else {
            $this->setNew();
        }
    }

    /**
     * @param $id
     */
    public function load($id)
    {
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_configs') . ' WHERE config_id=' . $id;
        $myrow = $this->db->fetchArray($this->db->query($sql));
        $this->assignVars($myrow);
        if (!$myrow) {
            $this->setNew();
        }
    }

    /**
     * @param array  $criteria
     * @param bool   $asobject
     * @param string $sort
     * @param string $order
     * @param int    $limit
     * @param int    $start
     * @return array
     */
    public function getAllyogurt_configs($criteria = [], $asobject = false, $sort = 'config_id', $order = 'ASC', $limit = 0, $start = 0)
    {
        $db          = \XoopsDatabaseFactory::getDatabaseConnection();
        $ret         = [];
        $where_query = '';
        if (is_array($criteria) && count($criteria) > 0) {
            $where_query = ' WHERE';
            foreach ($criteria as $c) {
                $where_query .= " $c AND";
            }
            $where_query = mb_substr($where_query, 0, -4);
        } elseif (!is_array($criteria) && $criteria) {
            $where_query = ' WHERE ' . $criteria;
        }
        if (!$asobject) {
            $sql    = 'SELECT config_id FROM ' . $db->prefix('yogurt_configs') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while (false !== ($myrow = $db->fetchArray($result))) {
                $ret[] = $myrow['yogurt_configs_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_configs') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while (false !== ($myrow = $db->fetchArray($result))) {
                $ret[] = new self($myrow);
            }
        }

        return $ret;
    }

    /**
     * Get form
     *
     * @param null
     * @return Yogurt\Form\ConfigsForm
     */
    public function getForm()
    {
        $form = new Form\ConfigsForm($this);
        return $form;
    }

    /**
     * @return array|null
     */
    public function getGroupsRead()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_read', $this->getVar('config_id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsSubmit()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_submit', $this->getVar('config_id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsModeration()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_moderation', $this->getVar('config_id'));
    }
}
