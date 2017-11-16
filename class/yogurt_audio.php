<?php
// yogurt_audio.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
include_once XOOPS_ROOT_PATH . '/class/uploader.php';

/**
 * yogurt_audio class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class yogurt_audio extends XoopsObject
{
    public $db;

    // constructor

    /**
     * yogurt_audio constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
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
        $db          = XoopsDatabaseFactory::getDatabaseConnection();
        $ret         = [];
        $where_query = '';
        if (is_array($criteria) && count($criteria) > 0) {
            $where_query = ' WHERE';
            foreach ($criteria as $c) {
                $where_query .= " $c AND";
            }
            $where_query = substr($where_query, 0, -4);
        } elseif (!is_array($criteria) && $criteria) {
            $where_query = ' WHERE ' . $criteria;
        }
        if (!$asobject) {
            $sql    = 'SELECT audio_id FROM ' . $db->prefix('yogurt_audio') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = $myrow['yogurt_audio_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_audio') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = new yogurt_audio($myrow);
            }
        }
        return $ret;
    }
}

// -------------------------------------------------------------------------
// ------------------yogurt_audio user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_audiohandler class.
 * This class provides simple mecanisme for yogurt_audio object
 */
class Xoopsyogurt_audioHandler extends XoopsObjectHandler
{

    /**
     * create a new yogurt_audio
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject yogurt_audio
     */
    public function create($isNew = true)
    {
        $yogurt_audio = new yogurt_audio();
        if ($isNew) {
            $yogurt_audio->setNew();
        } else {
            $yogurt_audio->unsetNew();
        }

        return $yogurt_audio;
    }

    /**
     * retrieve a yogurt_audio
     *
     * @param int $id of the yogurt_audio
     * @return mixed reference to the {@link yogurt_audio} object, FALSE if failed
     */
    public function &get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_audio') . ' WHERE audio_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_audio = new yogurt_audio();
            $yogurt_audio->assignVars($this->db->fetchArray($result));
            return $yogurt_audio;
        }
        return false;
    }

    /**
     * insert a new yogurt_audio in the database
     *
     * @param \XoopsObject $yogurt_audio reference to the {@link yogurt_audio}
     *                                   object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(XoopsObject $yogurt_audio, $force = false)
    {
        global $xoopsConfig;
        if ('yogurt_audio' != get_class($yogurt_audio)) {
            return false;
        }
        if (!$yogurt_audio->isDirty()) {
            return true;
        }
        if (!$yogurt_audio->cleanVars()) {
            return false;
        }
        foreach ($yogurt_audio->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_audio->isNew()) {
            // ajout/modification d'un yogurt_audio
            $yogurt_audio = new yogurt_audio();
            $format       = 'INSERT INTO %s (audio_id, title, author, url, uid_owner, data_creation, data_update)';
            $format       .= ' VALUES (%u, %s, %s, %s, %u, %s, %s)';
            $sql          = sprintf($format, $this->db->prefix('yogurt_audio'), $audio_id, $this->db->quoteString($title), $this->db->quoteString($author), $this->db->quoteString($url), $uid_owner, $now, $now);
            $force        = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'audio_id=%u, title=%s, author=%s, url=%s, uid_owner=%u, data_creation=%s, data_update=%s';
            $format .= ' WHERE audio_id = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_audio'), $audio_id, $this->db->quoteString($title), $this->db->quoteString($author), $this->db->quoteString($url), $uid_owner, $now, $now, $audio_id);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($audio_id)) {
            $audio_id = $this->db->getInsertId();
        }
        $yogurt_audio->assignVar('audio_id', $audio_id);
        return true;
    }

    /**
     * delete a yogurt_audio from the database
     *
     * @param \XoopsObject $yogurt_audio reference to the yogurt_audio to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(XoopsObject $yogurt_audio, $force = false)
    {
        if ('yogurt_audio' != get_class($yogurt_audio)) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE audio_id = %u', $this->db->prefix('yogurt_audio'), $yogurt_audio->getVar('audio_id'));
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
     * retrieve yogurt_audios from the database
     *
     * @param CriteriaElement $criteria  {@link CriteriaElement} conditions to be met
     * @param bool   $id_as_key use the UID as key for the array?
     * @return array array of {@link yogurt_audio} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_audio');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
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
            $yogurt_audio = new yogurt_audio();
            $yogurt_audio->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $yogurt_audio;
            } else {
                $ret[$myrow['audio_id']] =& $yogurt_audio;
            }
            unset($yogurt_audio);
        }
        return $ret;
    }

    /**
     * count yogurt_audios matching a condition
     *
     * @param CriteriaElement $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_audios
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_audio');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
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
     * delete yogurt_audios matching a set of conditions
     *
     * @param CriteriaElement $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_audio');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Upload the file and Save into database
     *
     * @param text $title       A litle description of the file
     * @param text $path_upload The path to where the file should be uploaded
     * @param text $author      the author of the music or audio file
     * @param      $maxfilebytes
     * @return bool FALSE if upload fails or database fails
     */
    public function receiveAudio($title, $path_upload, $author, $maxfilebytes)
    {
        global $xoopsUser, $xoopsDB, $_POST, $_FILES;
        //busca id do user logado
        $uid = $xoopsUser->getVar('uid');
        //create a hash so it does not erase another file
        //$hash1 = date();
        //$hash = substr($hash1,0,4);

        // mimetypes and settings put this in admin part later
        $allowed_mimetypes = ['audio/mp3', 'audio/x-mp3', 'audio/mpeg'];
        $maxfilesize       = $maxfilebytes;

        // create the object to upload
        $uploader = new XoopsMediaUploader($path_upload, $allowed_mimetypes, $maxfilesize);
        // fetch the media
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            //lets create a name for it
            $uploader->setPrefix('aud_' . $uid . '_');
            //now let s upload the file
            if (!$uploader->upload()) {
                // if there are errors lets return them
                echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';
                return false;
            } else {
                // now let s create a new object audio and set its variables
                //echo "passei aqui";
                $audio = $this->create();
                $url   = $uploader->getSavedFileName();
                $audio->setVar('url', $url);
                $audio->setVar('title', $title);
                $audio->setVar('author', $author);
                $uid = $xoopsUser->getVar('uid');
                $audio->setVar('uid_owner', $uid);
                $this->insert($audio);
                $saved_destination = $uploader->getSavedDestination();
                //print_r($_FILES);
            }
        } else {
            echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';
            return false;
        }
        return true;
    }
}
