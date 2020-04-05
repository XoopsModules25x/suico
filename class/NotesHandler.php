<?php

namespace XoopsModules\Yogurt;

//Notes.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';

// -------------------------------------------------------------------------
// ------------------Notes user handler class -------------------
// -------------------------------------------------------------------------

/**
 * NotesHandler class.
 * This class provides simple mecanisme forNotes object
 */
class NotesHandler extends \XoopsPersistableObjectHandler
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
        parent::__construct($db, 'yogurt_notes', Notes::class, 'note_id', 'note_id');
    }

    /**
     * create a new Groups
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject Groups
     */
    public function create($isNew = true)
    {
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
    }

    /**
     * retrieve aNotes
     *
     * @param int $id of theNotes
     * @return mixed reference to the {@linkNotes} object, FALSE if failed
     */
    public function get($id = null, $fields = null)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_notes') . ' WHERE note_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_notes = new Notes();
            $yogurt_notes->assignVars($this->db->fetchArray($result));

            return $yogurt_notes;
        }

        return false;
    }

    /**
     * insert a new Notes in the database
     *
     * @param \XoopsObject $yogurt_notes  reference to the {@linkNotes}
     *                                    object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_notes, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_notes instanceof Notes) {
            return false;
        }
        if (!$yogurt_notes->isDirty()) {
            return true;
        }
        if (!$yogurt_notes->cleanVars()) {
            return false;
        }
        foreach ($yogurt_notes->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_notes->isNew()) {
            // ajout/modification d'unNotes
            $yogurt_notes = new Notes();
            $format       = 'INSERT INTO %s (note_id, note_text, note_from, note_to, private)';
            $format       .= 'VALUES (%u, %s, %u, %u, %u)';
            $sql          = sprintf(
                $format,
                $this->db->prefix('yogurt_notes'),
                $note_id,
                $this->db->quoteString($note_text),
                $note_from,
                $note_to,
                $private
            );
            $force        = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'note_id=%u, note_text=%s, note_from=%u, note_to=%u, private=%u';
            $format .= ' WHERE note_id = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_notes'), $note_id, $this->db->quoteString($note_text), $note_from, $note_to, $private, $note_id);
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
        $yogurt_notes->assignVar('note_id', $note_id);

        return true;
    }

    /**
     * delete aNotes from the database
     *
     * @param \XoopsObject $yogurt_notes reference to theNotes to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_notes, $force = false)
    {
        if (!$yogurt_notes instanceof Notes) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE note_id = %u', $this->db->prefix('yogurt_notes'), $yogurt_notes->getVar('note_id'));
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
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@linkNotes} objects
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_notes');
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
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_notes
     */
    public function getCount(\CriteriaElement $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_notes');
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
     * delete yogurt_notes matching a set of conditions
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(\CriteriaElement $criteria = null, $force = true, $asObject = false)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_notes');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * @param                                      $nbNotes
     * @param null|\CriteriaElement|\CriteriaCompo $criteria
     * @return array
     */
    public function getNotes($nbNotes, $criteria)
    {
        $myts = new \MyTextSanitizer();
        $ret  = [];
        $sql  = 'SELECT note_id, uid, uname, user_avatar, note_from, note_text, date FROM ' . $this->db->prefix('yogurt_notes') . ', ' . $this->db->prefix('users');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = note_from';
            if ('' != $criteria->getSort()) {
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
                $vetor[$i]['date']        = $myrow['date'];

                $i++;
            }

            return $vetor;
        }
    }
}
