<?php

namespace XoopsModules\Yogurt;

/**
 * Protection against inclusion outside the site
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

// -------------------------------------------------------------------------
// ------------------Seutubo user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_seutubohandler class.
 * This class provides simple mecanisme for Seutubo object
 */
class SeutuboHandler extends \XoopsObjectHandler
{
    /**
     * create a new Seutubo
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject Seutubo
     */
    public function create($isNew = true)
    {
        $yogurt_seutubo = new Seutubo();
        if ($isNew) {
            $yogurt_seutubo->setNew();
        } else {
            $yogurt_seutubo->unsetNew();
        }

        return $yogurt_seutubo;
    }

    /**
     * retrieve a Seutubo
     *
     * @param int $id of the Seutubo
     * @return mixed reference to the {@link Seutubo} object, FALSE if failed
     */
    public function get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_seutubo') . ' WHERE video_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_seutubo = new Seutubo();
            $yogurt_seutubo->assignVars($this->db->fetchArray($result));

            return $yogurt_seutubo;
        }

        return false;
    }

    /**
     * insert a new Seutubo in the database
     *
     * @param \XoopsObject $yogurt_seutubo reference to the {@link Seutubo}
     *                                     object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_seutubo, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_seutubo instanceof Seutubo) {
            return false;
        }
        if (!$yogurt_seutubo->isDirty()) {
            return true;
        }
        if (!$yogurt_seutubo->cleanVars()) {
            return false;
        }
        foreach ($yogurt_seutubo->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_seutubo->isNew()) {
            // ajout/modification d'un Seutubo
            $yogurt_seutubo = new Seutubo();
            $format = 'INSERT INTO %s (video_id, uid_owner, video_desc, youtube_code, main_video)';
            $format .= 'VALUES (%u, %u, %s, %s, %s)';
            $sql = sprintf($format, $this->db->prefix('yogurt_seutubo'), $video_id, $uid_owner, $this->db->quoteString($video_desc), $this->db->quoteString($youtube_code), $this->db->quoteString($main_video));
            $force = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'video_id=%u, uid_owner=%u, video_desc=%s, youtube_code=%s, main_video=%s';
            $format .= ' WHERE video_id = %u';
            $sql = sprintf($format, $this->db->prefix('yogurt_seutubo'), $video_id, $uid_owner, $this->db->quoteString($video_desc), $this->db->quoteString($youtube_code), $this->db->quoteString($main_video), $video_id);
        }
        if (false !== $force) {
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
        $yogurt_seutubo->assignVar('video_id', $video_id);

        return true;
    }

    /**
     * delete a Seutubo from the database
     *
     * @param \XoopsObject $yogurt_seutubo reference to the Seutubo to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_seutubo, $force = false)
    {
        if (!$yogurt_seutubo instanceof Seutubo) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE video_id = %u', $this->db->prefix('yogurt_seutubo'), $yogurt_seutubo->getVar('video_id'));
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
     * retrieve yogurt_seutubos from the database
     *
     * @param \CriteriaElement $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool            $id_as_key use the UID as key for the array?
     * @return array array of {@link Seutubo} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = [];
        $limit = $start = 0;
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_seutubo');
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
            $yogurt_seutubo = new Seutubo();
            $yogurt_seutubo->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_seutubo;
            } else {
                $ret[$myrow['video_id']] = &$yogurt_seutubo;
            }
            unset($yogurt_seutubo);
        }

        return $ret;
    }

    /**
     * count yogurt_seutubos matching a condition
     *
     * @param \CriteriaElement $criteria {@link \CriteriaElement} to match
     * @return int count of yogurt_seutubos
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_seutubo');
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
     * delete yogurt_seutubos matching a set of conditions
     *
     * @param \CriteriaElement $criteria {@link \CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_seutubo');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * Render a form to send videos
     *
     * @param object $xoopsTpl the one in which the form will be rendered
     * @return bool TRUE
     *
     * obs: Some functions wont work on php 4 so edit lines down under acording to your version
     */
    public function renderFormSubmit($xoopsTpl)
    {
        $form = new \XoopsThemeForm(_MD_YOGURT_ADDFAVORITEVIDEOS, 'form_videos', 'video_submited.php', 'post', true);
        $field_code = new \XoopsFormText(_MD_YOGURT_YOUTUBECODE, 'codigo', 50, 250);
        $field_desc = new \XoopsFormTextArea(_MD_YOGURT_CAPTION, 'caption');
        $form->setExtra('enctype="multipart/form-data"');
        $button_send = new \XoopsFormButton('', 'submit_button', _MD_YOGURT_ADDVIDEO, 'submit');

        $form->addElement($field_warning);
        $form->addElement($field_code, true);
        $form->addElement($field_desc);

        $form->addElement($button_send);
        if (str_replace('.', '', PHP_VERSION) > 499) {
            $form->assign($xoopsTpl); //If your server is php 5
            //$form->display();
        } else {
            $form->display(); //If your server is php 4.4
        }

        return true;
    }

    /**
     * Render a form to edit the description of the pictures
     *
     * @param string $caption  The description of the picture
     * @param int    $cod_img  the id of the image in database
     * @param string   $filename the url to the thumb of the image so it can be displayed
     * @return bool TRUE
     */
    public function renderFormEdit($caption, $cod_img, $filename)
    {
        $form = new \XoopsThemeForm(_MD_YOGURT_EDITDESC, 'form_picture', 'editdescvideo.php', 'post', true);
        $field_desc = new \XoopsFormText($caption, 'caption', 35, 55);
        $form->setExtra('enctype="multipart/form-data"');
        $button_send = new \XoopsFormButton('', 'submit_button', _MD_YOGURT_SUBMIT, 'submit');
        $field_warning = new \XoopsFormLabel(
            '<object width="425" height="353">
<param name="movie" value="http://www.youtube.com/v/' . $filename . '"></param>
<param name="wmode" value="transparent"></param>
<embed src="http://www.youtube.com/v/' . $filename . '" type="application/x-shockwave-flash" wmode="transparent" width="425" height="353"></embed>
</object>'
        );
        $field_video_id = new \XoopsFormHidden('video_id', $cod_img);
        $field_marker = new \XoopsFormHidden('marker', 1);
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
        $sql = 'UPDATE ' . $this->db->prefix('yogurt_seutubo') . ' SET main_video=0 WHERE uid_owner=' . $uid_owner;

        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }
}
