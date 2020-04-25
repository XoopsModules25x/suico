<?php declare(strict_types=1);

namespace XoopsModules\Yogurt;

// Friendship.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

use Xmf\Module\Helper\Permission;
use XoopsDatabaseFactory;
use XoopsObject;

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
/**
 * Includes of form objects and uploader
 */
require_once XOOPS_ROOT_PATH . '/class/uploader.php';
require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Friendship class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class Friendship extends XoopsObject
{
    public $db;
    public $helper;
    public $permHelper;

    // constructor

    /**
     * Friendship constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        parent::__construct();
        /** @var Helper $helper */
        $this->helper     = Helper::getInstance();
        $this->permHelper = new Permission();

        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('friendship_id', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('friend1_uid', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('friend2_uid', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('level', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('hot', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('trust', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('cool', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('fan', \XOBJ_DTYPE_INT, null, false, 10);
        if (!empty($id)) {
            if (\is_array($id)) {
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendship') . ' WHERE friendship_id=' . $id;
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
    public function getAllFriendships(
        $criteria = [],
        $asobject = false,
        $sort = 'friendship_id',
        $order = 'ASC',
        $limit = 0,
        $start = 0
    ) {
        $db          = XoopsDatabaseFactory::getDatabaseConnection();
        $ret         = [];
        $whereQuery = '';
        if (\is_array($criteria) && \count($criteria) > 0) {
            $whereQuery = ' WHERE';
            foreach ($criteria as $c) {
                $whereQuery .= " ${c} AND";
            }
            $whereQuery = mb_substr($whereQuery, 0, -4);
        } elseif (!\is_array($criteria) && $criteria) {
            $whereQuery = ' WHERE ' . $criteria;
        }
        if (!$asobject) {
            $sql    = 'SELECT friendship_id FROM ' . $db->prefix(
                'yogurt_friendship'
            ) . "${where_query} ORDER BY ${sort} ${order}";
            $result = $db->query($sql, $limit, $start);
            while (false !== ($myrow = $db->fetchArray($result))) {
                $ret[] = $myrow['yogurt_friendship_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_friendship') . "${where_query} ORDER BY ${sort} ${order}";
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
     * @return \XoopsModules\Yogurt\Form\FriendshipForm
     */
    public function getForm()
    {
        return new Form\FriendshipForm($this);
    }

    /**
     * @return array|null
     */
    public function getGroupsRead()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem(
            'sbcolumns_read',
            $this->getVar('friendship_id')
        );
    }

    /**
     * @return array|null
     */
    public function getGroupsSubmit()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem(
            'sbcolumns_submit',
            $this->getVar('friendship_id')
        );
    }

    /**
     * @return array|null
     */
    public function getGroupsModeration()
    {
        //$permHelper = new \Xmf\Module\Helper\Permission();
        return $this->permHelper->getGroupsForItem(
            'sbcolumns_moderation',
            $this->getVar('friendship_id')
        );
    }
}
