<?php

namespace XoopsModules\Yogurt;

/**
 * Protection against inclusion outside the site
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

// -------------------------------------------------------------------------
// ------------------Groups user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_groupshandler class.
 * This class provides simple mecanisme for Groups object
 */
class GroupsHandler extends \XoopsPersistableObjectHandler
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
        parent::__construct($db, 'yogurt_groups', Groups::class, 'group_id', 'group_title');
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
     * retrieve a Groups
     *
     * @param int $id of the Groups
     * @return mixed reference to the {@link Groups} object, FALSE if failed
     */
    public function get($id = null, $fields = null)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_groups') . ' WHERE group_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_groups = new Groups();
            $yogurt_groups->assignVars($this->db->fetchArray($result));

            return $yogurt_groups;
        }

        return false;
    }

    /**
     * insert a new Groups in the database
     *
     * @param \XoopsObject $yogurt_groups reference to the {@link Groups}
     *                                    object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(\XoopsObject $yogurt_groups, $force = false)
    {
        global $xoopsConfig;
        if (!$yogurt_groups instanceof Groups) {
            return false;
        }
        if (!$yogurt_groups->isDirty()) {
            return true;
        }
        if (!$yogurt_groups->cleanVars()) {
            return false;
        }
        foreach ($yogurt_groups->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_groups->isNew()) {
            // ajout/modification d'un Groups
            $yogurt_groups = new Groups();
            $format        = 'INSERT INTO %s (group_id, owner_uid, group_title, group_desc, group_img)';
            $format        .= 'VALUES (%u, %u, %s, %s, %s)';
            $sql           = sprintf($format, $this->db->prefix('yogurt_groups'), $group_id, $owner_uid, $this->db->quoteString($group_title), $this->db->quoteString($group_desc), $this->db->quoteString($group_img));
            $force         = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'group_id=%u, owner_uid=%u, group_title=%s, group_desc=%s, group_img=%s';
            $format .= ' WHERE group_id = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_groups'), $group_id, $owner_uid, $this->db->quoteString($group_title), $this->db->quoteString($group_desc), $this->db->quoteString($group_img), $group_id);
        }
        if ($force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($group_id)) {
            $group_id = $this->db->getInsertId();
        }
        $yogurt_groups->assignVar('group_id', $group_id);

        return true;
    }

    /**
     * delete a Groups from the database
     *
     * @param \XoopsObject $yogurt_groups reference to the Groups to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(\XoopsObject $yogurt_groups, $force = false)
    {
        if (!$yogurt_groups instanceof Groups) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE group_id = %u', $this->db->prefix('yogurt_groups'), $yogurt_groups->getVar('group_id'));
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
     * retrieve yogurt_groupss from the database
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link Groups} objects
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_groups');
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
            $yogurt_groups = new Groups();
            $yogurt_groups->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$yogurt_groups;
            } else {
                $ret[$myrow['group_id']] = &$yogurt_groups;
            }
            unset($yogurt_groups);
        }

        return $ret;
    }

    /**
     * retrieve yogurt_groupss from the database
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link Groups} objects
     */
    public function getGroups($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_groups');
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
            $ret[$i]['id']    = $myrow['group_id'];
            $ret[$i]['title'] = $myrow['group_title'];
            $ret[$i]['img']   = $myrow['group_img'];
            $ret[$i]['desc']  = $myrow['group_desc'];
            $ret[$i]['uid']   = $myrow['owner_uid'];
            $i++;
        }

        return $ret;
    }

    /**
     * count yogurt_groupss matching a condition
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement} to match
     * @return int count of yogurt_groupss
     */
    public function getCount(\CriteriaElement $criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_groups');
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
     * delete yogurt_groupss matching a set of conditions
     *
     * @param null|\CriteriaElement|\CriteriaCompo $criteria {@link \CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(\CriteriaElement $criteria = null, $force = true, $asObject = false)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_groups');
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
        $form = new \XoopsThemeForm(_MD_YOGURT_SUBMIT_GROUP, 'form_group', 'submit_group.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $field_url     = new \XoopsFormFile(_MD_YOGURT_GROUP_IMAGE, 'group_img', $maxbytes);
        $field_title   = new \XoopsFormText(_MD_YOGURT_GROUP_TITLE, 'group_title', 35, 55);
        $field_desc    = new \XoopsFormText(_MD_YOGURT_GROUP_DESC, 'group_desc', 35, 55);
        $field_marker  = new \XoopsFormHidden('marker', '1');
        $button_send   = new \XoopsFormButton('', 'submit_button', _MD_YOGURT_UPLOADGROUP, 'submit');
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
     * @param $group
     * @param $maxbytes
     * @return bool
     */
    public function renderFormEdit($group, $maxbytes)
    {
        $form = new \XoopsThemeForm(_MD_YOGURT_EDIT_GROUP, 'form_editgroup', 'editgroup.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $field_groupid = new \XoopsFormHidden('group_id', $group->getVar('group_id'));
        $field_url     = new \XoopsFormFile(_MD_YOGURT_GROUP_IMAGE, 'img', $maxbytes);
        $field_url->setExtra('style="visibility:hidden;"');
        $field_title   = new \XoopsFormText(_MD_YOGURT_GROUP_TITLE, 'title', 35, 55, $group->getVar('group_title'));
        $field_desc    = new \XoopsFormTextArea(_MD_YOGURT_GROUP_DESC, 'desc', $group->getVar('group_desc'));
        $field_marker  = new \XoopsFormHidden('marker', '1');
        $button_send   = new \XoopsFormButton('', 'submit_button', _MD_YOGURT_UPLOADGROUP, 'submit');
        $field_warning = new \XoopsFormLabel(sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxbytes / 1024));

        $field_oldpicture = new \XoopsFormLabel(_MD_YOGURT_GROUP_IMAGE, '<img src="' . XOOPS_UPLOAD_URL . '/' . $group->getVar('group_img') . '">');

        $field_maintainimage = new \XoopsFormLabel(_MD_YOGURT_MAINTAINOLDIMAGE, "<input type='checkbox' value='1' id='flag_oldimg' name='flag_oldimg' onclick=\"groupImgSwitch(img)\"  checked>");

        $form->addElement($field_oldpicture);
        $form->addElement($field_maintainimage);
        $form->addElement($field_warning);
        $form->addElement($field_url);
        $form->addElement($field_groupid);
        $form->addElement($field_title);
        $form->addElement($field_desc);
        $form->addElement($field_marker);
        $form->addElement($button_send);
        $form->display();
        echo "
        <!-- Start Form Validation JavaScript //-->
<script type='text/javascript'>
<!--//
function groupImgSwitch(img) {

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
     * @param        $group_title
     * @param        $group_desc
     * @param        $group_img
     * @param        $path_upload
     * @param        $maxfilebytes
     * @param        $maxfilewidth
     * @param        $maxfileheight
     * @param int    $change_img
     * @param string $group
     * @return bool
     */
    public function receiveGroup($group_title, $group_desc, $group_img, $path_upload, $maxfilebytes, $maxfilewidth, $maxfileheight, $change_img = 1, $group = '')
    {
        global $xoopsUser, $xoopsDB, $_POST, $_FILES;
        //search logged user id
        $uid = $xoopsUser->getVar('uid');
        if (!is_a($group, Groups::class)) {
            $group = $this->create();
        } else {
            $group->unsetNew();
        }
        if (1 == $change_img) {
            // mimetypes and settings put this in admin part later
            $allowed_mimetypes = Helper::getInstance()->getConfig('mimetypes');
            $maxfilesize       = $maxfilebytes;

            $uploadDir = XOOPS_UPLOAD_PATH . '/yogurt/groups/';
            // create the object to upload
            $uploader = new \XoopsMediaUploader($uploadDir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
            // fetch the media
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                //lets create a name for it
                $uploader->setPrefix('group_' . $uid . '_');
                //now let s upload the file

                if (!$uploader->upload()) {
                    // if there are errors lets return them

                    echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';

                    return false;
                }
                // now let s create a new object picture and set its variables
                $savedFilename = $uploader->getSavedFileName();
                $group->setVar('group_img', $savedFilename);
                $imageMimetype = $uploader->getMediaType();
                $group->setVar('group_img', $savedFilename);
                $maxWidth_grouplogo     = Helper::getInstance()->getConfig('groupslogo_width');
                $maxHeight_grouplogo    = Helper::getInstance()->getConfig('groupslogo_height');
                $resizer                = new Common\Resizer();
                $resizer->sourceFile    = $uploadDir . $savedFilename;
                $resizer->endFile       = $uploadDir . $savedFilename;
                $resizer->imageMimetype = $imageMimetype;
                $resizer->maxWidth      = $maxWidth_grouplogo;
                $resizer->maxHeight     = $maxHeight_grouplogo;
                $result                 = $resizer->resizeImage();
            } else {
                echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';

                return false;
            }
        }

        $group->setVar('group_title', $group_title);
        $group->setVar('group_desc', $group_desc);
        $group->setVar('owner_uid', $uid);

        $this->insert($group);

        return true;
    }

}
