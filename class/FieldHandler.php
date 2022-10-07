<?php declare(strict_types=1);

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
 * @license             GNU GPL 2 (https://www.gnu.org/licenses/gpl-2.0.html)
 * @since               2.3.0
 * @author              Jan Pedersen
 * @author              Taiwen Jiang <phppp@users.sourceforge.net>
 */

/**
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 */

use XoopsModules\Suico;

/**
 * Class FieldHandler
 */
class FieldHandler extends \XoopsPersistableObjectHandler
{
    /**
     * @param \XoopsDatabase $db
     */
    public function __construct(\XoopsDatabase $db)
    {
        parent::__construct($db, 'suico_profile_field', Field::class, 'field_id', 'field_title');
    }

    /**
     * Read field information from cached storage
     *
     * @param bool $force_update read fields from database and not cached storage
     *
     * @return array
     */
    public function loadFields($force_update = false)
    {
        static $fields = [];
        if (!empty($force_update) || 0 == \count($fields)) {
            $this->table_link = $this->db->prefix('suico_profile_category');
            $criteria         = new \Criteria('o.field_id', 0, '!=');
            $criteria->setSort('l.cat_weight ASC, o.field_weight');
            $field_objs = &$this->getByLink($criteria, ['o.*'], true, 'cat_id', 'cat_id');
            foreach (\array_keys($field_objs) as $i) {
                $fields[$field_objs[$i]->getVar('field_name')] = $field_objs[$i];
            }
        }

        return $fields;
    }

    /**
     * save a profile field in the database
     *
     * @param \XoopsObject $object   reference to the object
     * @param bool         $force whether to force the query execution despite security settings
     *
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     * @internal param bool $checkObject check if the object is dirty and clean the attributes
     */
    public function insert(\XoopsObject $object, $force = false)
    {
        if (!($object instanceof $this->className)) {
            return false;
        }
        /** @var Suico\ProfileHandler $profileHandler */
        $profileHandler = Helper::getInstance()->getHandler('Profile');
        $object->setVar('field_name', \str_replace(' ', '_', $object->getVar('field_name')));
        $object->cleanVars();
        $defaultstring = '';
        switch ($object->getVar('field_type')) {
            case 'datetime':
            case 'date':
                $object->setVar('field_valuetype', \XOBJ_DTYPE_INT);
                $object->setVar('field_maxlength', 10);
                break;
            case 'longdate':
                $object->setVar('field_valuetype', \XOBJ_DTYPE_MTIME);
                break;
            case 'yesno':
                $object->setVar('field_valuetype', \XOBJ_DTYPE_INT);
                $object->setVar('field_maxlength', 1);
                break;
            case 'textbox':
                if (\XOBJ_DTYPE_INT != $object->getVar('field_valuetype')) {
                    $object->setVar('field_valuetype', \XOBJ_DTYPE_TXTBOX);
                }
                break;
            case 'autotext':
                if (\XOBJ_DTYPE_INT != $object->getVar('field_valuetype')) {
                    $object->setVar('field_valuetype', \XOBJ_DTYPE_TXTAREA);
                }
                break;
            case 'group_multi':
            case 'select_multi':
            case 'checkbox':
                $object->setVar('field_valuetype', \XOBJ_DTYPE_ARRAY);
                break;
            case 'language':
            case 'timezone':
            case 'theme':
                $object->setVar('field_valuetype', \XOBJ_DTYPE_TXTBOX);
                break;
            case 'dhtml':
            case 'textarea':
                $object->setVar('field_valuetype', \XOBJ_DTYPE_TXTAREA);
                break;
        }
        if ('' === $object->getVar('field_valuetype')) {
            $object->setVar('field_valuetype', \XOBJ_DTYPE_TXTBOX);
        }
        if ((!\in_array($object->getVar('field_name'), $this->getUserVars(), true)) && isset($_REQUEST['field_required'])) {
            if ($object->isNew()) {
                //add column to table
                $changetype = 'ADD';
            } else {
                //update column information
                $changetype = 'MODIFY COLUMN';
            }
            $maxlengthstring = $object->getVar('field_maxlength') > 0 ? '(' . $object->getVar('field_maxlength') . ')' : '';
            //set type
            switch ($object->getVar('field_valuetype')) {
                default:
                case \XOBJ_DTYPE_ARRAY:
                case \XOBJ_DTYPE_UNICODE_ARRAY:
                    $type            = 'mediumtext';
                    $maxlengthstring = '';
                    break;
                case \XOBJ_DTYPE_UNICODE_EMAIL:
                case \XOBJ_DTYPE_UNICODE_TXTBOX:
                case \XOBJ_DTYPE_UNICODE_URL:
                case \XOBJ_DTYPE_EMAIL:
                case \XOBJ_DTYPE_TXTBOX:
                case \XOBJ_DTYPE_URL:
                    $type = 'varchar';
                    // varchars must have a maxlength
                    if (!$maxlengthstring) {
                        //so set it to max if maxlength is not set - or should it fail?
                        $maxlengthstring = '(255)';
                        $object->setVar('field_maxlength', 255);
                    }
                    break;
                case \XOBJ_DTYPE_INT:
                    $type = 'int';
                    break;
                case \XOBJ_DTYPE_DECIMAL:
                    $type = 'decimal(14,6)';
                    break;
                case \XOBJ_DTYPE_FLOAT:
                    $type = 'float(15,9)';
                    break;
                case \XOBJ_DTYPE_OTHER:
                case \XOBJ_DTYPE_UNICODE_TXTAREA:
                case \XOBJ_DTYPE_TXTAREA:
                    $type            = 'text';
                    $maxlengthstring = '';
                    break;
                case \XOBJ_DTYPE_MTIME:
                    $type            = 'date';
                    $maxlengthstring = '';
                    break;
            }
            $sql    = 'ALTER TABLE `' . $profileHandler->table . '` ' . $changetype . ' `' . $object->cleanVars['field_name'] . '` ' . $type . $maxlengthstring . ' NULL';
            $result = $force ? $this->db->queryF($sql) : $this->db->query($sql);
            if (!$result) {
                $object->setErrors($this->db->error());

                return false;
            }
        }
        //change this to also update the cached field information storage
        $object->setDirty();
        if (!parent::insert($object, $force)) {
            return false;
        }

        return $object->getVar('field_id');
    }

    /**
     * delete a profile field from the database
     *
     * @param \XoopsObject $object reference to the object to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $object, $force = false)
    {
        if (!($object instanceof $this->className)) {
            return false;
        }
        /** @var ProfileHandler $profileHandler */
        $profileHandler = Helper::getInstance()->getHandler('Profile');
        // remove column from table
        $sql = 'ALTER TABLE ' . $profileHandler->table . ' DROP `' . $object->getVar('field_name', 'n') . '`';
        if ($this->db->query($sql)) {
            //change this to update the cached field information storage
            if (!parent::delete($object, $force)) {
                return false;
            }
            if ($object->getVar('field_show') || $object->getVar('field_edit')) {
                $moduleSuico = Helper::getInstance()->getModule();
                if (\is_object($moduleSuico)) {
                    // Remove group permissions
                    /** @var \XoopsGroupPermHandler $grouppermHandler */
                    $grouppermHandler = \xoops_getHandler('groupperm');
                    $criteria         = new \CriteriaCompo(new \Criteria('gperm_modid', $moduleSuico->getVar('mid')));
                    $criteria->add(new \Criteria('gperm_itemid', $object->getVar('field_id')));

                    return $grouppermHandler->deleteAll($criteria);
                }
            }
        }

        return false;
    }

    /**
     * Get array of standard variable names (user table)
     *
     * @return array
     */
    public function getUserVars()
    {
        return [
            'uid',
            'uname',
            'name',
            'email',
            'url',
            'user_avatar',
            'user_regdate',
            'user_from',
            'user_sig',
            'user_viewemail',
            'actkey',
            'pass',
            'posts',
            'attachsig',
            'rank',
            'level',
            'theme',
            'timezone_offset',
            'last_login',
            'umode',
            'uorder',
            'notify_method',
            'notify_mode',
            'user_occ',
            'bio',
            'user_intrest',
            'user_mailok',
        ];
    }
}
