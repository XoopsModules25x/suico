<?php

namespace XoopsModules\Yogurt;

// Audio.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez                                               //
// ----------------------------------------------------------------- //

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/uploader.php';

// -------------------------------------------------------------------------
// ------------------yogurt_audio user handler class -------------------
// -------------------------------------------------------------------------

/**
 * AudioHandler class.
 * This class provides simple mecanisme for yogurt_audio object
 */
class AudioHandler extends \XoopsPersistableObjectHandler
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
        parent::__construct($db, 'yogurt_audio', Audio::class, 'audio_id', 'title');
    }

    /**
     * @param bool $isNew
     *
     * @return \XoopsObject
     */
    public function create($isNew = true)
    {
        $obj         = parent::create($isNew);
        $obj->helper = $this->helper;

        return $obj;
    }

    /**
     * retrieve a yogurt_audio
     *
     * @param int $id of the yogurt_audio
     * @return mixed reference to the {@link yogurt_audio} object, FALSE if failed
     */
    public function get($id = null, $fields = null)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_audio') . ' WHERE audio_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurtAudio = new Audio();
            $yogurtAudio->assignVars($this->db->fetchArray($result));

            return $yogurtAudio;
        }

        return false;
    }

    /**
     * insert a new Audio in the database
     *
     * @param \XoopsObject $yogurtAudio  reference to the {@link yogurt_audio}
     *                                   object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurtAudio, $force = false)
    {
        global $xoopsConfig;
        if ('yogurt_audio' != get_class($yogurtAudio)) {
            return false;
        }
        if (!$yogurtAudio->isDirty()) {
            return true;
        }
        if (!$yogurtAudio->cleanVars()) {
            return false;
        }
        foreach ($yogurtAudio->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurtAudio->isNew()) {
            // ajout/modification d'un yogurt_audio
            $yogurtAudio = new Audio();
            $format      = 'INSERT INTO %s (audio_id, title, author, url, uid_owner, data_creation, data_update)';
            $format      .= ' VALUES (%u, %s, %s, %s, %u, %s, %s)';
            $sql         = sprintf($format, $this->db->prefix('yogurt_audio'), $audio_id, $this->db->quoteString($title), $this->db->quoteString($author), $this->db->quoteString($url), $uid_owner, $now, $now);
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'audio_id=%u, title=%s, author=%s, url=%s, uid_owner=%u, data_creation=%s, data_update=%s';
            $format .= ' WHERE audio_id = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_audio'), $audio_id, $this->db->quoteString($title), $this->db->quoteString($author), $this->db->quoteString($url), $uid_owner, $now, $now, $audio_id);
        }
        if ($force) {
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
        $yogurtAudio->assignVar('audio_id', $audio_id);

        return true;
    }

    /**
     * delete a yogurt_audio from the database
     *
     * @param \XoopsObject $yogurtAudio reference to the yogurt_audio to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurtAudio, $force = false)
    {
        if ('yogurt_audio' != get_class($yogurtAudio)) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE audio_id = %u', $this->db->prefix('yogurt_audio'), $yogurtAudio->getVar('audio_id'));
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
     * retrieve yogurt_audios from the database
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link yogurt_audio} objects
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_audio');
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
            $yogurtAudio = new Audio();
            $yogurtAudio->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurtAudio;
            } else {
                $ret[$myrow['audio_id']] = &$yogurtAudio;
            }
            unset($yogurtAudio);
        }

        return $ret;
    }

    /**
     * count yogurt_audios matching a condition
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement} to match
     * @return int count of yogurt_audios
     */
    public function getCount(\CriteriaElement $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_audio');
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
     * delete yogurt_audios matching a set of conditions
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(\CriteriaElement $criteria = null, $force = true, $asObject = false)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_audio');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
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
     * @param string $title       A litle description of the file
     * @param string $path_upload The path to where the file should be uploaded
     * @param string $author      the author of the music or audio file
     * @param        $maxfilebytes
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

        $uploadDir = XOOPS_UPLOAD_PATH . '/yogurt/audio/';
        // create the object to upload
        $uploader = new \XoopsMediaUploader($uploadDir, $allowed_mimetypes, $maxfilesize);
        // fetch the media
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            //lets create a name for it
            $uploader->setPrefix('aud_' . $uid . '_');
            //now let s upload the file
            if (!$uploader->upload()) {
                // if there are errors lets return them
                echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';

                return false;
            }
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
        } else {
            echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';

            return false;
        }

        return true;
    }
}
