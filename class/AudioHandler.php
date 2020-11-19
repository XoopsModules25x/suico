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
 * @author          Bruno Barthez, Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use CriteriaCompo;
use CriteriaElement;
use Xmf\Request;
use XoopsDatabase;
use XoopsMediaUploader;
use XoopsObject;
use XoopsPersistableObjectHandler;
use XoopsModules\Suico\{
    Helper
};
/** @var Helper $helper */

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/uploader.php';

/**
 * AudioHandler class.
 * This class provides simple mechanism for suico_audio object
 */
class AudioHandler extends XoopsPersistableObjectHandler
{
    public $isAdmin;
    public $helper;

    /**
     * Constructor
     * @param \XoopsDatabase|null $xoopsDatabase
     * @param Helper|null         $helper
     */
    public function __construct(
        ?XoopsDatabase $xoopsDatabase = null,
        $helper = null
    ) {
        /** @var Helper $this->helper */
        if (null === $helper) {
            $this->helper = Helper::getInstance();
        } else {
            $this->helper = $helper;
        }
        $isAdmin = $this->helper->isUserAdmin();
        parent::__construct($xoopsDatabase, 'suico_audios', Audio::class, 'audio_id', 'title');
    }

    /**
     * @param bool $isNew
     *
     * @return XoopsObject
     */
    public function create($isNew = true)
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

    /**
     * retrieve a suico_audio
     *
     * @param int|null $id of the suico_audio
     * @return mixed reference to the {@link suico_audio} object, FALSE if failed
     */
    public function get2(
        $id = null
        //        $fields = null
    )
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('suico_audios') . ' WHERE audio_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $suicoAudio = new Audio();
            $suicoAudio->assignVars($this->db->fetchArray($result));
            return $suicoAudio;
        }
        return false;
    }

    /**
     * insert a new Audio in the database
     *
     * @param XoopsObject $xoopsObject reference to the {@link suico_audio}
     *                                 object
     * @param bool        $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (Audio::class !== \get_class($xoopsObject)) {
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
        $audio_id     = Request::getString('audio_id', '', 'POST');
        $uid_owner    = Request::getInt('audio_id', 0, 'POST');
        $title        = Request::getString('title', '', 'POST');
        $author       = Request::getString('author', '', 'POST');
        $description  = Request::getText('description', '', 'POST');
        $filename     = Request::getString('filename', '', 'POST');
        $date_created = Request::getString('date_created', \time(), 'POST');
        $date_updated = Request::getString('date_updated', \time(), 'POST');
        //        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($xoopsObject->isNew()) {
            // adding / modifying a suico_audio
            $xoopsObject = new Audio();
            $format      = 'INSERT INTO %s (audio_id, title, author, description, filename, uid_owner, date_created, date_updated)';
            $format      .= ' VALUES (%u, %s, %s, %s, %s, %u, %s, %s)';
            $sql         = \sprintf(
                $format,
                $this->db->prefix('suico_audios'),
                $audio_id,
                $this->db->quoteString($author),
                $this->db->quoteString($title),
                $this->db->quoteString($description),
                $this->db->quoteString($filename),
                $uid_owner,
                $date_created,
                $date_updated
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'audio_id=%u, title=%s, author=%s, filename=%s, description=%s,uid_owner=%u, date_created=%s, date_updated=%s';
            $format .= ' WHERE audio_id = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('suico_audios'),
                $audio_id,
                $this->db->quoteString($title),
                $this->db->quoteString($author),
                $this->db->quoteString($filename),
                $uid_owner,
                $date_created,
                $date_updated,
                $audio_id
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
        if (empty($audio_id)) {
            $audio_id = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('audio_id', $audio_id);
        return true;
    }

    /**
     * delete a suico_audio from the database
     *
     * @param XoopsObject $xoopsObject reference to the suico_audio to delete
     * @param bool        $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if ('suico_audio' !== \get_class($xoopsObject)) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE audio_id = %u',
            $this->db->prefix('suico_audios'),
            $xoopsObject->getVar('audio_id')
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
     * retrieve suico_audios from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link suico_audio} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('suico_audios');
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
            $suicoAudio = new Audio();
            $suicoAudio->assignVars($myrow);
            if ($id_as_key) {
                $ret[$myrow['audio_id']] = &$suicoAudio;
            } else {
                $ret[] = &$suicoAudio;
            }
            unset($suicoAudio);
        }
        return $ret;
    }

    /**
     * count suico_audios matching a condition
     *
     * @param CriteriaElement|CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of suico_audios
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('suico_audios');
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
     * delete suico_audios matching a set of conditions
     *
     * @param CriteriaElement|CriteriaCompo|null $criteriaElement {@link \CriteriaElement}
     * @param bool                               $force
     * @param bool                               $asObject
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(
        ?CriteriaElement $criteriaElement = null,
        $force = true,
        $asObject = false
    ) {
        $sql = 'DELETE FROM ' . $this->db->prefix('suico_audios');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
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
     * @param        $description
     * @return bool FALSE if upload fails or database fails
     */
    public function receiveAudio(
        $title,
        $path_upload,
        $author,
        $maxfilebytes,
        $description
    ) {
        global $xoopsUser, $xoopsDB, $_POST, $_FILES;
        //busca id do user logado
        $uid = $xoopsUser->getVar('uid');
        //create a hash so it does not erase another file
        //$hash1 = date();
        //$hash = substr($hash1,0,4);
        // mimetypes and settings put this in admin part later
        $allowed_mimetypes = [
            'audio/mp3',
            'audio/x-mp3',
            'audio/mpeg',
        ];
        $maxfilesize       = $maxfilebytes;
        $uploadDir         = $path_upload;
        // create the object to upload
        $uploader = new \XoopsMediaUploader(
            $uploadDir, $allowed_mimetypes, $maxfilesize
        );
        // fetch the media
        if ($uploader->fetchMedia((Request::getArray('xoops_upload_file', '', 'POST')[0]))) {
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
            $audio->setVar('uid_owner', $xoopsUser->getVar('uid'));
            $audio->setVar('title', $title);
            $audio->setVar('author', $author);
            $audio->setVar('description', $description);
            $audio->setVar(
                'filename',
                $uploader->getSavedFileName()
            );
            $audio->setVar('date_created', \time());
            $audio->setVar('date_updated', \time());
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
