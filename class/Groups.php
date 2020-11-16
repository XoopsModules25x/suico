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
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use Xmf\Module\Helper\Permission;
use XoopsDatabaseFactory;
use XoopsObject;

const GROUPID     = 'group_id';
const SUICOGROUPS = 'suico_groups'; //table
/**
 * Includes of form objects and uploader
 */
require_once XOOPS_ROOT_PATH . '/class/uploader.php';
require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * Groups class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class Groups extends XoopsObject
{
    public $xoopsDb;
    public $helper;
    public $permHelper;

    /**
     * Groups constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        /** @var Helper $helper */
        $this->helper     = Helper::getInstance();
        $this->permHelper = new Permission();
        $this->xoopsDb    = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar(GROUPID, \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('owner_uid', \XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('group_title', \XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('group_desc', \XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('group_img', \XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('date_created', \XOBJ_DTYPE_INT);
        $this->initVar('date_updated', \XOBJ_DTYPE_INT);
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
        $sql   = 'SELECT * FROM ' . $this->xoopsDb->prefix(SUICOGROUPS) . ' WHERE group_id=' . $id;
        $myrow = $this->xoopsDb->fetchArray($this->xoopsDb->query($sql));
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
    public function getAllGroups(
        $criteria = [],
        $asobject = false,
        $sort = GROUPID,
        $order = 'ASC',
        $limit = 0,
        $start = 0
    ) {
        $ret        = [];
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
        if ($asobject) {
            $sql    = 'SELECT * FROM ' . $this->xoopsDb->prefix(SUICOGROUPS) . "${whereQuery} ORDER BY ${sort} ${order}";
            $result = $this->xoopsDb->query($sql, $limit, $start);
            while (false !== ($myrow = $this->xoopsDb->fetchArray($result))) {
                $ret[] = new self($myrow);
            }
        } else {
            $sql    = 'SELECT group_id FROM ' . $this->xoopsDb->prefix(
                    SUICOGROUPS
                ) . "${whereQuery} ORDER BY ${sort} ${order}";
            $result = $this->xoopsDb->query($sql, $limit, $start);
            while (false !== ($myrow = $this->xoopsDb->fetchArray($result))) {
                $ret[] = $myrow['suico_groups_id'];
            }
        }
        return $ret;
    }

    /**
     * Get form
     *
     * @return \XoopsModules\Suico\Form\GroupsForm
     */
    public function getForm()
    {
        return new Form\GroupsForm($this);
    }

    /**
     * @return array|null
     */
    public function getGroupsRead()
    {
        return $this->permHelper->getGroupsForItem(
            'sbcolumns_read',
            $this->getVar(GROUPID)
        );
    }

    /**
     * @return array|null
     */
    public function getGroupsSubmit()
    {
        return $this->permHelper->getGroupsForItem(
            'sbcolumns_submit',
            $this->getVar(GROUPID)
        );
    }

    /**
     * @return array|null
     */
    public function getGroupsModeration()
    {
        return $this->permHelper->getGroupsForItem(
            'sbcolumns_moderation',
            $this->getVar(GROUPID)
        );
    }
}
