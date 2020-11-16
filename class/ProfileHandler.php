<?php

declare(strict_types=1);

namespace XoopsModules\Suico;

/**
 * Extended User Profile
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package             profile
 * @since               2.3.0
 * @author              Jan Pedersen
 * @author              Taiwen Jiang <phppp@users.sourceforge.net>
 */

/**
 * @package             kernel
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 */

use XoopsModules\Suico;

/**
 * Class ProfileHandler
 * @package XoopsModules\Suico
 */
class ProfileHandler extends \XoopsPersistableObjectHandler
{
    /**
     * holds reference to {@link ProfileFieldHandler} object
     */
    public $fieldHandler;
    /**
     * Array of {@link Suico\Field} objects
     * @var array
     */
    public $_fields = [];

    /**
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'suico_profile', Profile::class, 'profile_id');
        $this->fieldHandler = Helper::getInstance()->getHandler('Field');
    }

    /**
     * create a new {@link ProfileProfile}
     *
     * @param bool $isNew Flag the new objects as "new"?
     *
     * @return object {@link ProfileProfile}
     */
    public function create($isNew = true)
    {
        $obj          = new $this->className($this->loadFields());
        $obj->handler = $this;
        if ($isNew) {
            $obj->setNew();
        }
        return $obj;
    }

    /**
     * Get a ProfileProfile object for a user id.
     *
     * We will create an empty profile if none exists. This behavior allows user objects
     * created outside of profile to be edited correctly in the profile module.
     *
     * @param int|null      $uid
     * @param string[]|null $fields array of field names to fetch, null for all
     *
     * @return object {@link ProfileProfile}
     *
     * @internal This was get($uid, $createOnFailure = true). No callers found using the extra parameter.
     * @internal Modified to match parent signature.
     */
    public function get($uid = null, $fields = null)
    {
        $obj = parent::get($uid, $fields);
        if (!\is_object($obj)) {
            $obj = $this->create();
        }
        return $obj;
    }

    /**
     * Create new {@link Suico\Field} object
     *
     * @param bool $isNew
     *
     * @return \XoopsModules\Suico\Field|\XoopsObject
     */
    public function createField($isNew = true)
    {
        $return = $this->fieldHandler->create($isNew);
        return $return;
    }

    /**
     * Load field information
     *
     * @return array
     */
    public function loadFields()
    {
        if (0 == \count($this->_fields)) {
            $this->_fields = $this->fieldHandler->loadFields();
        }
        return $this->_fields;
    }

    /**
     * Fetch fields
     *
     * @param \CriteriaElement $criteria  {@link CriteriaElement} object
     * @param bool             $id_as_key return array with field IDs as key?
     * @param bool             $as_object return array of objects?
     *
     * @return array
     */
    public function getFields(\CriteriaElement $criteria, $id_as_key = true, $as_object = true)
    {
        return $this->fieldHandler->getObjects($criteria, $id_as_key, $as_object);
    }

    /**
     * Insert a field in the database
     *
     * @param \XoopsModules\Suico\Field $field
     * @param bool                      $force
     *
     * @return bool
     */
    public function insertField(Suico\Field $field, $force = false)
    {
        return $this->fieldHandler->insert($field, $force);
    }

    /**
     * Delete a field from the database
     *
     * @param \XoopsModules\Suico\Field $field
     * @param bool                      $force
     *
     * @return bool
     */
    public function deleteField(Suico\Field $field, $force = false)
    {
        return $this->fieldHandler->delete($field, $force);
    }

    /**
     * Save a new field in the database
     *
     * @param array $vars array of variables, taken from $module->loadInfo('profile')['field']
     * @param int   $weight
     *
     * @return string
     * @internal param int $type valuetype of the field
     * @internal param int $moduleid ID of the module, this field belongs to
     * @internal param int $categoryid ID of the category to add it to
     */
    public function saveField($vars, $weight = 0)
    {
        $field = $this->createField();
        $field->setVar('field_name', $vars['name']);
        $field->setVar('field_valuetype', $vars['valuetype']);
        $field->setVar('field_type', $vars['type']);
        $field->setVar('field_weight', $weight);
        if (isset($vars['title'])) {
            $field->setVar('field_title', $vars['title']);
        }
        if (isset($vars['description'])) {
            $field->setVar('field_description', $vars['description']);
        }
        if (isset($vars['required'])) {
            $field->setVar('field_required', $vars['required']); //0 = no, 1 = yes
        }
        if (isset($vars['maxlength'])) {
            $field->setVar('field_maxlength', $vars['maxlength']);
        }
        if (isset($vars['default'])) {
            $field->setVar('field_default', $vars['default']);
        }
        if (isset($vars['notnull'])) {
            $field->setVar('field_notnull', $vars['notnull']);
        }
        if (isset($vars['show'])) {
            $field->setVar('field_show', $vars['show']);
        }
        if (isset($vars['edit'])) {
            $field->setVar('field_edit', $vars['edit']);
        }
        if (isset($vars['config'])) {
            $field->setVar('field_config', $vars['config']);
        }
        if (isset($vars['options'])) {
            $field->setVar('field_options', $vars['options']);
        } else {
            $field->setVar('field_options', []);
        }
        if ($this->insertField($field)) {
            $msg = '&nbsp;&nbsp;Field <strong>' . $vars['name'] . '</strong> added to the database';
        } else {
            $msg = '&nbsp;&nbsp;<span class="red">ERROR: Could not insert field <strong>' . $vars['name'] . '</strong> into the database. ' . \implode(' ', $field->getErrors()) . $this->db->error() . '</span>';
        }
        unset($field);
        return $msg;
    }

    /**
     * insert a new object in the database
     *
     * @param \XoopsObject $obj   reference to the object
     * @param bool         $force whether to force the query execution despite security settings
     *
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $obj, $force = false)
    {
        if (!($obj instanceof $this->className)) {
            return false;
        }
        $uservars = $this->getUserVars();
        foreach ($uservars as $var) {
            unset($obj->vars[$var]);
        }
        if (0 == \count($obj->vars)) {
            return true;
        }
        return parent::insert($obj, $force);
    }

    /**
     * Get array of standard variable names (user table)
     *
     * @return array
     */
    public function getUserVars()
    {
        return $this->fieldHandler->getUserVars();
    }

    /**
     * Search profiles and users
     *
     * @param \CriteriaElement $criteria   CriteriaElement
     * @param array            $searchvars Fields to be fetched
     * @param array|null             $groups     for Usergroups is selected (only admin!)
     *
     * @return array
     */
    public function search(\CriteriaElement $criteria, $searchvars = [], $groups = null)
    {
        $uservars           = $this->getUserVars();
        $searchvars_user    = \array_intersect($searchvars, $uservars);
        $searchvars_profile = \array_diff($searchvars, $uservars);
        $sv                 = ['u.uid, u.uname, u.email, u.user_viewemail'];
        if (!empty($searchvars_user)) {
            $sv[0] .= ',u.' . \implode(', u.', $searchvars_user);
        }
        if (!empty($searchvars_profile)) {
            $sv[] = 'p.' . \implode(', p.', $searchvars_profile);
        }
        $sql_select = 'SELECT ' . (empty($searchvars) ? 'u.*, p.*' : \implode(', ', $sv));
        $sql_from   = ' FROM ' . $this->db->prefix('users') . ' AS u LEFT JOIN ' . $this->table . ' AS p ON u.uid=p.profile_id' . (empty($groups) ? '' : ' LEFT JOIN ' . $this->db->prefix('groups_users_link') . ' AS g ON u.uid=g.uid');
        $sql_clause = ' WHERE 1=1';
        $sql_order  = '';
        $limit      = $start = 0;
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql_clause .= ' AND ' . $criteria->render();
            if ('' !== $criteria->getSort()) {
                $sql_order = ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        if (!empty($groups)) {
            $sql_clause .= ' AND g.groupid IN (' . \implode(', ', $groups) . ')';
        }
        $sql_users = $sql_select . $sql_from . $sql_clause . $sql_order;
        $result    = $this->db->query($sql_users, $limit, $start);
        if (!$result) {
            return [[], [], 0];
        }
        $userHandler = \xoops_getHandler('user');
        $uservars    = $this->getUserVars();
        $users       = [];
        $profiles    = [];
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $profile = $this->create(false);
            $user    = $userHandler->create(false);
            foreach ($myrow as $name => $value) {
                if (\in_array($name, $uservars)) {
                    $user->assignVar($name, $value);
                } else {
                    $profile->assignVar($name, $value);
                }
            }
            $profiles[$myrow['uid']] = $profile;
            $users[$myrow['uid']]    = $user;
        }
        $count = \count($users);
        if ((!empty($limit) && $count >= $limit) || !empty($start)) {
            $sql_count = 'SELECT COUNT(*)' . $sql_from . $sql_clause;
            $result    = $this->db->query($sql_count);
            [$count] = $this->db->fetchRow($result);
        }
        return [$users, $profiles, (int)$count];
    }
}
