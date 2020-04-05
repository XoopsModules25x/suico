<?php

namespace XoopsModules\Yogurt;

/**
 * Protection against inclusion outside the site
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

// -------------------------------------------------------------------------
// ------------------Tribes user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_tribeshandler class.
 * This class provides simple mecanisme for Tribes object
 */
class TribesHandler extends \XoopsPersistableObjectHandler
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
        parent::__construct($db, 'yogurt_tribes', Tribes::class, 'tribe_id', 'tribe_title');
    }

    /**
     * create a new Tribes
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject Tribes
     */
    public function create($isNew = true)
    {
        {
            $obj = parent::create($isNew);
            //        if ($isNew) {
            //            $obj->setDefaultPermissions();
            //        }
            $obj->helper = $this->helper;

            return $obj;
        }
    }

    /**
     * retrieve a Tribes
     *
     * @param int $id of the Tribes
     * @return mixed reference to the {@link Tribes} object, FALSE if failed
     */
    public function get($id = null, $fields = null)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_tribes') . ' WHERE tribe_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_tribes = new Tribes();
            $yogurt_tribes->assignVars($this->db->fetchArray($result));

            return $yogurt_tribes;
        }

        return false;
    }

    /**
     * insert a new Tribes in the database
     *
     * @param \XoopsObject $yogurt_tribes reference to the {@link Tribes}
     *                                    object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_tribes, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_tribes instanceof Tribes) {
            return false;
        }
        if (!$yogurt_tribes->isDirty()) {
            return true;
        }
        if (!$yogurt_tribes->cleanVars()) {
            return false;
        }
        foreach ($yogurt_tribes->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_tribes->isNew()) {
            // ajout/modification d'un Tribes
            $yogurt_tribes = new Tribes();
            $format        = 'INSERT INTO %s (tribe_id, owner_uid, tribe_title, tribe_desc, tribe_img)';
            $format        .= 'VALUES (%u, %u, %s, %s, %s)';
            $sql           = sprintf($format, $this->db->prefix('yogurt_tribes'), $tribe_id, $owner_uid, $this->db->quoteString($tribe_title), $this->db->quoteString($tribe_desc), $this->db->quoteString($tribe_img));
            $force         = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'tribe_id=%u, owner_uid=%u, tribe_title=%s, tribe_desc=%s, tribe_img=%s';
            $format .= ' WHERE tribe_id = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_tribes'), $tribe_id, $owner_uid, $this->db->quoteString($tribe_title), $this->db->quoteString($tribe_desc), $this->db->quoteString($tribe_img), $tribe_id);
        }
        if ($force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($tribe_id)) {
            $tribe_id = $this->db->getInsertId();
        }
        $yogurt_tribes->assignVar('tribe_id', $tribe_id);

        return true;
    }

    /**
     * delete a Tribes from the database
     *
     * @param \XoopsObject $yogurt_tribes reference to the Tribes to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_tribes, $force = false)
    {
        if (!$yogurt_tribes instanceof Tribes) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE tribe_id = %u', $this->db->prefix('yogurt_tribes'), $yogurt_tribes->getVar('tribe_id'));
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
     * retrieve yogurt_tribess from the database
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link Tribes} objects
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_tribes');
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
            $yogurt_tribes = new Tribes();
            $yogurt_tribes->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_tribes;
            } else {
                $ret[$myrow['tribe_id']] = &$yogurt_tribes;
            }
            unset($yogurt_tribes);
        }

        return $ret;
    }

    /**
     * retrieve yogurt_tribess from the database
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link Tribes} objects
     */
    public function getTribes($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_tribes');
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

        $i = 0;
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $ret[$i]['id']    = $myrow['tribe_id'];
            $ret[$i]['title'] = $myrow['tribe_title'];
            $ret[$i]['img']   = $myrow['tribe_img'];
            $ret[$i]['desc']  = $myrow['tribe_desc'];
            $ret[$i]['uid']   = $myrow['owner_uid'];
            $i++;
        }

        return $ret;
    }

    /**
     * count yogurt_tribess matching a condition
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement} to match
     * @return int count of yogurt_tribess
     */
    public function getCount(\CriteriaElement $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_tribes');
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
     * delete yogurt_tribess matching a set of conditions
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(\CriteriaElement $criteria = null, $force = true, $asObject = false)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_tribes');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }

        return true;
    }

    /**
     * @param $maxbytes
     * @param $xoopsTpl
     * @return bool
     */
    public function renderFormSubmit($maxbytes, $xoopsTpl)
    {
        $form = new \XoopsThemeForm(_MD_YOGURT_SUBMIT_TRIBE, 'form_tribe', 'submit_tribe.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $field_url     = new \XoopsFormFile(_MD_YOGURT_TRIBE_IMAGE, 'tribe_img', $maxbytes);
        $field_title   = new \XoopsFormText(_MD_YOGURT_TRIBE_TITLE, 'tribe_title', 35, 55);
        $field_desc    = new \XoopsFormText(_MD_YOGURT_TRIBE_DESC, 'tribe_desc', 35, 55);
        $field_marker  = new \XoopsFormHidden('marker', '1');
        $button_send   = new \XoopsFormButton('', 'submit_button', _MD_YOGURT_UPLOADTRIBE, 'submit');
        $field_warning = new \XoopsFormLabel(sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxbytes / 1024));

        $form->addElement($field_warning);
        $form->addElement($field_url, true);

        $form->addElement($field_title);
        $form->addElement($field_desc);
        $form->addElement($field_marker);
        $form->addElement($button_send);
        $form->display();

        return true;
    }

    /**
     * @param $tribe
     * @param $maxbytes
     * @return bool
     */
    public function renderFormEdit($tribe, $maxbytes)
    {
        $form = new \XoopsThemeForm(_MD_YOGURT_EDIT_TRIBE, 'form_edittribe', 'edittribe.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $field_tribeid = new \XoopsFormHidden('tribe_id', $tribe->getVar('tribe_id'));
        $field_url     = new \XoopsFormFile(_MD_YOGURT_TRIBE_IMAGE, 'img', $maxbytes);
        $field_url->setExtra('style="visibility:hidden;"');
        $field_title   = new \XoopsFormText(_MD_YOGURT_TRIBE_TITLE, 'title', 35, 55, $tribe->getVar('tribe_title'));
        $field_desc    = new \XoopsFormTextArea(_MD_YOGURT_TRIBE_DESC, 'desc', $tribe->getVar('tribe_desc'));
        $field_marker  = new \XoopsFormHidden('marker', '1');
        $button_send   = new \XoopsFormButton('', 'submit_button', _MD_YOGURT_UPLOADTRIBE, 'submit');
        $field_warning = new \XoopsFormLabel(sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxbytes / 1024));

        $field_oldpicture = new \XoopsFormLabel(_MD_YOGURT_TRIBE_IMAGE, '<img src="' . XOOPS_UPLOAD_URL . '/' . $tribe->getVar('tribe_img') . '">');

        $field_maintainimage = new \XoopsFormLabel(_MD_YOGURT_MAINTAINOLDIMAGE, "<input type='checkbox' value='1' id='flag_oldimg' name='flag_oldimg' onclick=\"tribeImgSwitch(img)\"  checked>");

        $form->addElement($field_oldpicture);
        $form->addElement($field_maintainimage);
        $form->addElement($field_warning);
        $form->addElement($field_url);
        $form->addElement($field_tribeid);
        $form->addElement($field_title);
        $form->addElement($field_desc);
        $form->addElement($field_marker);
        $form->addElement($button_send);
        $form->display();
        echo "
        <!-- Start Form Validation JavaScript //-->
<script type='text/javascript'>
<!--//
function tribeImgSwitch(img) {

var elestyle = xoopsGetElementById(img).style;

    if (elestyle.visibility == \"hidden\") {
        elestyle.visibility = \"visible\";
    } else {
        elestyle.visibility = \"hidden\";
    }


}
//--></script>
<!-- End Form Validation JavaScript //-->





        ";

        return true;
    }

    /**
     * @param        $tribe_title
     * @param        $tribe_desc
     * @param        $tribe_img
     * @param        $path_upload
     * @param        $maxfilebytes
     * @param        $maxfilewidth
     * @param        $maxfileheight
     * @param int    $change_img
     * @param string $tribe
     * @return bool
     */
    public function receiveTribe($tribe_title, $tribe_desc, $tribe_img, $path_upload, $maxfilebytes, $maxfilewidth, $maxfileheight, $change_img = 1, $tribe = '')
    {
        global $xoopsUser, $xoopsDB, $_POST, $_FILES;
        //search logged user id
        $uid = $xoopsUser->getVar('uid');
        if (!is_a($tribe, Tribes::class)) {
            $tribe = $this->create();
        } else {
            $tribe->unsetNew();
        }
        if (1 == $change_img) {
            // mimetypes and settings put this in admin part later
            $allowed_mimetypes = Helper::getInstance()->getConfig('mimetypes');
            $maxfilesize       = $maxfilebytes;

            $uploadDir = XOOPS_UPLOAD_PATH . '/yogurt/tribes/';
            // create the object to upload
            $uploader = new \XoopsMediaUploader($uploadDir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
            // fetch the media
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                //lets create a name for it
                $uploader->setPrefix('tribe_' . $uid . '_');
                //now let s upload the file

                if (!$uploader->upload()) {
                    // if there are errors lets return them

                    echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';

                    return false;
                }
                // now let s create a new object picture and set its variables
                $savedFilename = $uploader->getSavedFileName();
                $tribe->setVar('tribe_img', $savedFilename);
                $imageMimetype = $uploader->getMediaType();
                $tribe->setVar('tribe_img', $savedFilename);
                $maxWidth_tribelogo     = Helper::getInstance()->getConfig('tribeslogo_width');
                $maxHeight_tribelogo    = Helper::getInstance()->getConfig('tribeslogo_height');
                $resizer                = new Common\Resizer();
                $resizer->sourceFile    = $uploadDir . $savedFilename;
                $resizer->endFile       = $uploadDir . $savedFilename;
                $resizer->imageMimetype = $imageMimetype;
                $resizer->maxWidth      = $maxWidth_tribelogo;
                $resizer->maxHeight     = $maxHeight_tribelogo;
                $result                 = $resizer->resizeImage();
            } else {
                echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';

                return false;
            }
        }

        $tribe->setVar('tribe_title', $tribe_title);
        $tribe->setVar('tribe_desc', $tribe_desc);
        $tribe->setVar('owner_uid', $uid);

        $this->insert($tribe);

        return true;
    }

}
