<?php

namespace XoopsModules\Yogurt;

//Notes.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
include_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';

// -------------------------------------------------------------------------
// ------------------Notes user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_Noteshandler class.
 * This class provides simple mecanisme forNotes object
 */
class NotesHandler extends \XoopsObjectHandler
{

    /**
     * create a new Notes
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsModules\Yogurt\Notes
     */
    public function create($isNew = true)
    {
        $yogurt_Notes = new Notes();
        if ($isNew) {
            $yogurt_Notes->setNew();
        } else {
            $yogurt_Notes->unsetNew();
        }

        return $yogurt_Notes;
    }

    /**
     * retrieve aNotes
     *
     * @param int $id of theNotes
     * @return mixed reference to the {@linkNotes} object, FALSE if failed
     */
    public function get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_Notes') . ' WHERE Note_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_Notes = new Notes();
            $yogurt_Notes->assignVars($this->db->fetchArray($result));
            return $yogurt_Notes;
        }
        return false;
    }

    /**
     * insert a new Notes in the database
     *
     * @param \XoopsObject $yogurt_Notes  reference to the {@linkNotes}
     *                                    object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_Notes, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_Notes instanceof \Notes) {
            return false;
        }
        if (!$yogurt_Notes->isDirty()) {
            return true;
        }
        if (!$yogurt_Notes->cleanVars()) {
            return false;
        }
        foreach ($yogurt_Notes->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_Notes->isNew()) {
            // ajout/modification d'unNotes
            $yogurt_Notes = new Notes();
            $format       = 'INSERT INTO %s (Note_id, Note_text, Note_from, Note_to, private)';
            $format       .= 'VALUES (%u, %s, %u, %u, %u)';
            $sql          = sprintf(
                $format,
                $this->db->prefix('yogurt_Notes'),
                $Note_id,
                $this->db->quoteString($Note_text),
                $Note_from,
                $Note_to,
                $private

            );
            $force        = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'Note_id=%u, Note_text=%s, Note_from=%u, Note_to=%u, private=%u';
            $format .= ' WHERE Note_id = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_Notes'), $Note_id, $this->db->quoteString($Note_text), $Note_from, $Note_to, $private, $Note_id);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($Note_id)) {
            $Note_id = $this->db->getInsertId();
        }
        $yogurt_Notes->assignVar('Note_id', $Note_id);
        return true;
    }

    /**
     * delete aNotes from the database
     *
     * @param \XoopsObject $yogurt_Notes reference to theNotes to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_Notes, $force = false)
    {
        if (!$yogurt_Notes instanceof \Notes) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE Note_id = %u', $this->db->prefix('yogurt_Notes'), $yogurt_Notes->getVar('Note_id'));
        if (false !== $force) {
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
     * retrieve yogurt_Notess from the database
     *
     * @param \XoopsObject $criteria  {@link CriteriaElement} conditions to be met
     * @param bool         $id_as_key use the UID as key for the array?
     * @return array array of {@linkNotes} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_Notes');
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
        while ($myrow = $this->db->fetchArray($result)) {
            $yogurt_Notes = new Notes();
            $yogurt_Notes->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $yogurt_Notes;
            } else {
                $ret[$myrow['Note_id']] =& $yogurt_Notes;
            }
            unset($yogurt_Notes);
        }
        return $ret;
    }

    /**
     * count yogurt_Notess matching a condition
     *
     * @param \XoopsObject $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_Notess
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_Notes');
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
     * delete yogurt_Notess matching a set of conditions
     *
     * @param \XoopsObject $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_Notes');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * @param $nbNotes
     * @param $criteria
     * @return array
     */
    public function getNotes($nbNotes, $criteria)
    {
        $myts = new MyTextSanitizer();
        $ret  = [];
        $sql  = 'SELECT Note_id, uid, uname, user_avatar, Note_from, Note_text FROM ' . $this->db->prefix('yogurt_Notes') . ', ' . $this->db->prefix('users');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = Note_from';
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();

            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;

            while ($myrow = $this->db->fetchArray($result)) {
                $vetor[$i]['uid']         = $myrow['uid'];
                $vetor[$i]['uname']       = $myrow['uname'];
                $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
                $temptext                 = $myts->xoopsCodeDecode($myrow['Note_text'], 1);
                $vetor[$i]['text']        = $myts->nl2Br($temptext);
                $vetor[$i]['id']          = $myrow['Note_id'];

                $i++;
            }

            return $vetor;
        }
    }
}
