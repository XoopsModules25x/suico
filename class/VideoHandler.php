<?php declare(strict_types=1);

namespace XoopsModules\Yogurt;

use CriteriaElement;
use XoopsDatabase;
use XoopsFormButton;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormText;
use XoopsFormTextArea;
use XoopsObject;
use XoopsPersistableObjectHandler;
use XoopsThemeForm;

/**
 * Protection against inclusion outside the site
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

// -------------------------------------------------------------------------
// ------------------Video user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_videohandler class.
 * This class provides simple mecanisme for Video object
 */
class VideoHandler extends XoopsPersistableObjectHandler
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
        parent::__construct($xoopsDatabase, 'yogurt_video', Video::class, 'video_id', 'video_desc');
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
        if ($isNew) {
            $obj->helper = $this->helper;
        }

        return $obj;
    }

    /**
     * retrieve a Video
     *
     * @param int  $id of the Video
     * @param null $fields
     * @return mixed reference to the {@link Video} object, FALSE if failed
     */
    public function get(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_video') . ' WHERE video_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $yogurt_video = new Video();
            $yogurt_video->assignVars($this->db->fetchArray($result));

            return $yogurt_video;
        }

        return false;
    }

    /**
     * insert a new Video in the database
     *
     * @param \XoopsObject $xoopsObject    reference to the {@link Video}
     *                                     object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Video) {
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
            // ajout/modification d'un Video
            $xoopsObject = new Video();
            $format      = 'INSERT INTO %s (video_id, uid_owner, video_desc, youtube_code, main_video)';
            $format      .= 'VALUES (%u, %u, %s, %s, %s)';
            $sql         = sprintf(
                $format,
                $this->db->prefix('yogurt_video'),
                $video_id,
                $uid_owner,
                $this->db->quoteString($video_desc),
                $this->db->quoteString($youtube_code),
                $this->db->quoteString($main_video)
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'video_id=%u, uid_owner=%u, video_desc=%s, youtube_code=%s, main_video=%s';
            $format .= ' WHERE video_id = %u';
            $sql    = sprintf(
                $format,
                $this->db->prefix('yogurt_video'),
                $video_id,
                $uid_owner,
                $this->db->quoteString($video_desc),
                $this->db->quoteString($youtube_code),
                $this->db->quoteString($main_video),
                $video_id
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
        if (empty($video_id)) {
            $video_id = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('video_id', $video_id);

        return true;
    }

    /**
     * delete a Video from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Video to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Video) {
            return false;
        }
        $sql = sprintf(
            'DELETE FROM %s WHERE video_id = %u',
            $this->db->prefix('yogurt_video'),
            $xoopsObject->getVar('video_id')
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
     * retrieve yogurt_videos from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Video} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_video');
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
            $yogurt_video = new Video();
            $yogurt_video->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_video;
            } else {
                $ret[$myrow['video_id']] = &$yogurt_video;
            }
            unset($yogurt_video);
        }

        return $ret;
    }

    /**
     * count yogurt_videos matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of yogurt_videos
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_video');
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
     * delete yogurt_videos matching a set of conditions
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement}
     * @param bool                                 $force
     * @param bool                                 $asObject
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(
        ?CriteriaElement $criteriaElement = null,
        $force = true,
        $asObject = false
    ) {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_video');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * Render a form to send videos
     *
     * @param \XoopsTpl $xoopsTpl the one in which the form will be rendered
     * @return bool TRUE
     *
     * obs: Some functions wont work on php 4 so edit lines down under acording to your version
     */
    public function renderFormSubmit(
        $xoopsTpl
    ) {
        $form       = new XoopsThemeForm(_MD_YOGURT_ADDFAVORITEVIDEOS, 'form_videos', 'video_submited.php', 'post', true);
        $field_code = new XoopsFormText(_MD_YOGURT_YOUTUBECODE, 'codigo', 50, 250);
        $field_desc = new XoopsFormTextArea(_MD_YOGURT_CAPTION, 'caption');
        $form->setExtra('enctype="multipart/form-data"');
        $button_send = new XoopsFormButton('', 'submit_button', _MD_YOGURT_ADDVIDEO, 'submit');

        $form->addElement($field_warning);
        $form->addElement($field_code, true);
        $form->addElement($field_desc);

        $form->addElement($button_send);
        $form->assign($xoopsTpl); //If your server is php 5
        //$form->display();

        return true;
    }

    /**
     * Render a form to edit the description of the pictures
     *
     * @param string $caption  The description of the picture
     * @param int    $cod_img  the id of the image in database
     * @param string $filename the url to the thumb of the image so it can be displayed
     * @return bool TRUE
     */
    public function renderFormEdit(
        $caption,
        $cod_img,
        $filename
    ) {
        $form       = new XoopsThemeForm(_MD_YOGURT_EDITDESC, 'form_picture', 'editdescvideo.php', 'post', true);
        $field_desc = new XoopsFormText($caption, 'caption', 35, 55);
        $form->setExtra('enctype="multipart/form-data"');
        $button_send    = new XoopsFormButton('', 'submit_button', _MD_YOGURT_SUBMIT, 'submit');
        $field_warning  = new XoopsFormLabel(
            '<object width="425" height="353">
<param name="movie" value="http://www.youtube.com/v/' . $filename . '"></param>
<param name="wmode" value="transparent"></param>
<embed src="http://www.youtube.com/v/' . $filename . '" type="application/x-shockwave-flash" wmode="transparent" width="425" height="353"></embed>
</object>'
        );
        $field_video_id = new XoopsFormHidden('video_id', $cod_img);
        $field_marker   = new XoopsFormHidden('marker', 1);
        $form->addElement($field_warning);
        $form->addElement($field_desc);
        $form->addElement($field_video_id, true);
        $form->addElement($field_marker);
        $form->addElement($button_send);
        $form->display();

        return true;
    }

    /**
     * @param null $uid_owner
     * @return bool
     */
    public function unsetAllMainsbyID($uid_owner = null)
    {
        $sql = 'UPDATE ' . $this->db->prefix('yogurt_video') . ' SET main_video=0 WHERE uid_owner=' . $uid_owner;

        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }
}
