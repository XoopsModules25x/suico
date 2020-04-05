<?php

namespace XoopsModules\Yogurt;

// Audio.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/uploader.php';

/**
 * Audio class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class Audio extends \XoopsObject
{
    public $db;

    // constructor

    /**
     * Audio constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        /** @var  Helper $helper */
        $this->helper     = Helper::getInstance();
        $this->permHelper = new \Xmf\Module\Helper\Permission();
        $this->db         = \XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('audio_id', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('author', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('url', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('uid_owner', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('data_creation', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('data_update', XOBJ_DTYPE_TXTBOX, null, false);
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_audio') . ' WHERE audio_id=' . $id;
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
    public function getAllyogurt_audios($criteria = [], $asobject = false, $sort = 'audio_id', $order = 'ASC', $limit = 0, $start = 0)
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
            $sql    = 'SELECT audio_id FROM ' . $db->prefix('yogurt_audio') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while (false !== ($myrow = $db->fetchArray($result))) {
                $ret[] = $myrow['yogurt_audio_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_audio') . "$where_query ORDER BY $sort $order";
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
     * @return Yogurt\Form\AudioForm
     */
    public function getForm()
    {
        $form = new Form\AudioForm($this);
        return $form;
    }

    /**
     * @return array|null
     */
    public function getGroupsRead()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_read', $this->getVar('audio_id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsSubmit()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_submit', $this->getVar('audio_id'));
    }

    /**
     * @return array|null
     */
    public function getGroupsModeration()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem('sbcolumns_moderation', $this->getVar('audio_id'));
    }
}
