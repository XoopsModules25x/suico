<?php declare(strict_types=1);

namespace XoopsModules\Yogurt;

//Notes.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

use CriteriaElement;
use MyTextSanitizer;
use XoopsDatabase;
use XoopsObject;
use XoopsPersistableObjectHandler;

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';

// -------------------------------------------------------------------------
// ------------------Notes user handler class -------------------
// -------------------------------------------------------------------------

/**
 * NotesHandler class.
 * This class provides simple mecanisme forNotes object
 */
class NotesHandler extends XoopsPersistableObjectHandler
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
        parent::__construct($xoopsDatabase, 'yogurt_notes', Notes::class, 'note_id', 'note_id');
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
     * retrieve aNotes
     *
     * @param int  $id of theNotes
     * @param null $fields
     * @return mixed reference to the {@linkNotes} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_notes') . ' WHERE note_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $yogurt_notes = new Notes();
            $yogurt_notes->assignVars($this->db->fetchArray($result));

            return $yogurt_notes;
        }

        return false;
    }

    /**
     * insert a new Notes in the database
     *
     * @param \XoopsObject $xoopsObject   reference to the {@linkNotes}
     *                                    object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Notes) {
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
            // add / modify a Notes
            $xoopsObject = new Notes();
            $format      = 'INSERT INTO %s (note_id, note_text, note_from, note_to, date_created, private)';
            $format      .= 'VALUES (%u, %s, %u, %u, %u,%u)';
            $sql         = \sprintf(
                $format,
                $this->db->prefix('yogurt_notes'),
                $note_id,
                $this->db->quoteString($note_text),
                $note_from,
                $note_to,
                $date,
                $private
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'note_id=%u, note_text=%s, note_from=%u, note_to=%u, date_created=%u, private=%u';
            $format .= ' WHERE note_id = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('yogurt_notes'),
                $note_id,
                $this->db->quoteString($note_text),
                $note_from,
                $note_to,
                $date,
                $private,
                $note_id
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
        if (empty($note_id)) {
            $note_id = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('note_id', $note_id);

        return true;
    }

    /**
     * delete aNotes from the database
     *
     * @param \XoopsObject $xoopsObject reference to theNotes to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Notes) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE note_id = %u',
            $this->db->prefix('yogurt_notes'),
            $xoopsObject->getVar('note_id')
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
     * retrieve yogurt_notes from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@linkNotes} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_notes');
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
            $yogurt_notes = new Notes();
            $yogurt_notes->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_notes;
            } else {
                $ret[$myrow['note_id']] = &$yogurt_notes;
            }
            unset($yogurt_notes);
        }

        return $ret;
    }

    /**
     * count yogurt_notes matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link CriteriaElement} to match
     * @return int count of yogurt_notes
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_notes');
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
     * delete yogurt_notes matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_notes');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * @param                                      $nbNotes
     * @param \CriteriaElement|\CriteriaCompo|null $criteria
     * @return array
     */
    public function getNotes(
        $nbNotes,
        $criteria
    ) {
        $myts = new MyTextSanitizer();
        $ret  = [];
        $sql  = 'SELECT note_id, uid, uname, user_avatar, note_from, note_text, date_created FROM ' . $this->db->prefix(
            'yogurt_notes'
        ) . ', ' . $this->db->prefix(
                'users'
            );
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = note_from';
            if ('' !== $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();

            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;

            while (false !== ($myrow = $this->db->fetchArray($result))) {
                $vetor[$i]['uid']         = $myrow['uid'];
                $vetor[$i]['uname']       = $myrow['uname'];
                $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
                $temptext                 = $myts->xoopsCodeDecode($myrow['note_text'], 1);
                $vetor[$i]['text']        = $myts->nl2Br($temptext);
                $vetor[$i]['id']          = $myrow['note_id'];
                $vetor[$i]['date_created']        = formatTimeStamp($myrow['date_created'], 's');

                $i++;
            }

            return $vetor;
        }
    }
}
