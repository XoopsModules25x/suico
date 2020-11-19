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
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use CriteriaElement;
use XoopsDatabase;
use XoopsFormButton;
use XoopsFormFile;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormText;
use XoopsFormTextArea;
use XoopsMediaUploader;
use XoopsObject;
use XoopsPersistableObjectHandler;
use XoopsThemeForm;


/**
 * suico_groupshandler class.
 * This class provides simple mechanism for Groups object
 */
class GroupsHandler extends XoopsPersistableObjectHandler
{
    public $helper;
    public $isAdmin;

    /**
     * Constructor
     * @param \XoopsDatabase|null             $xoopsDatabase
     * @param \XoopsModules\Suico\Helper|null $helper
     */
    public function __construct(
        ?XoopsDatabase $xoopsDatabase = null,
        $helper = null
    ) {
        /** @var \XoopsModules\Suico\Helper $this->helper */
        if (null === $helper) {
            $this->helper = Helper::getInstance();
        } else {
            $this->helper = $helper;
        }
        $isAdmin = $this->helper->isUserAdmin();
        parent::__construct($xoopsDatabase, 'suico_groups', Groups::class, 'group_id', 'group_title');
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
     * retrieve a Groups
     *
     * @param int  $id of the Groups
     * @param null $fields
     * @return mixed reference to the {@link Groups} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('suico_groups') . ' WHERE group_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $suico_groups = new Groups();
            $suico_groups->assignVars($this->db->fetchArray($result));
            return $suico_groups;
        }
        return false;
    }

    /**
     * insert a new Groups in the database
     *
     * @param \XoopsObject $xoopsObject   reference to the {@link Groups}
     *                                    object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Groups) {
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
        //        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($xoopsObject->isNew()) {
            // ajout/modification d'un Groups
            $xoopsObject = new Groups();
            $format      = 'INSERT INTO %s (group_id, owner_uid, group_title, group_desc, group_img)';
            $format      .= 'VALUES (%u, %u, %s, %s, %s)';
            $sql         = \sprintf(
                $format,
                $this->db->prefix('suico_groups'),
                $group_id,
                $owner_uid,
                $this->db->quoteString($group_title),
                $this->db->quoteString($group_desc),
                $this->db->quoteString($group_img)
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'group_id=%u, owner_uid=%u, group_title=%s, group_desc=%s, group_img=%s';
            $format .= ' WHERE group_id = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('suico_groups'),
                $group_id,
                $owner_uid,
                $this->db->quoteString($group_title),
                $this->db->quoteString($group_desc),
                $this->db->quoteString($group_img),
                $group_id
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
        if (empty($group_id)) {
            $group_id = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('group_id', $group_id);
        return true;
    }

    /**
     * delete a Groups from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Groups to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Groups) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE group_id = %u',
            $this->db->prefix('suico_groups'),
            $xoopsObject->getVar('group_id')
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
     * retrieve suico_groupss from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Groups} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('suico_groups');
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
            $suico_groups = new Groups();
            $suico_groups->assignVars($myrow);
            if ($id_as_key) {
                $ret[$myrow['group_id']] = &$suico_groups;
            } else {
                $ret[] = &$suico_groups;
            }
            unset($suico_groups);
        }
        return $ret;
    }

    /**
     * retrieve suico_groupss from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteria  {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key use the UID as key for the array?
     * @return array array of {@link Groups} objects
     */
    public function getGroups(
        $criteria = null,
        $id_as_key = false
    ) {
        $ret   = [];
        $sort  = 'group_title';
        $order = 'ASC';
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('suico_groups');
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
            if ('' !== $sort) {
                $sql .= ' ORDER BY ' . $sort . ' ' . $order;
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
            $ret[$i]['id']       = $myrow['group_id'];
            $ret[$i]['title']    = $myrow['group_title'];
            $ret[$i]['img']      = $myrow['group_img'];
            $ret[$i]['desc']     = $myrow['group_desc'];
            $ret[$i]['uid']      = $myrow['owner_uid'];
            $groupid             = $myrow['group_id'];
            $query               = 'SELECT COUNT(rel_id) AS grouptotalmembers FROM ' . $GLOBALS['xoopsDB']->prefix('suico_relgroupuser') . ' WHERE rel_group_id=' . $groupid . '';
            $queryresult         = $GLOBALS['xoopsDB']->query($query);
            $row                 = $GLOBALS['xoopsDB']->fetchArray($queryresult);
            $group_total_members = $row['grouptotalmembers'];
            if ($group_total_members > 0) {
                if (1 == $group_total_members) {
                    $ret[$i]['group_total_members'] = '' . _MD_SUICO_ONEMEMBER . '&nbsp;';
                } else {
                    $ret[$i]['group_total_members'] = '' . $group_total_members . '&nbsp;' . _MD_SUICO_GROUPMEMBERS . '&nbsp;';
                }
            } else {
                $ret[$i]['group_total_members'] = '' . _MD_SUICO_NO_MEMBER . '&nbsp;';
            }
            $i++;
        }
        return $ret;
    }

    /**
     * count suico_groupss matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of suico_groupss
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('suico_groups');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        [$count] = $this->db->fetchRow($result);
        return $count;
    }

    /**
     * delete suico_groupss matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('suico_groups');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
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
    public function renderFormSubmit(
        $maxbytes,
        $xoopsTpl
    ) {
        $form = new XoopsThemeForm(\_MD_SUICO_SUBMIT_GROUP, 'form_group', 'submitGroup.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $field_url     = new XoopsFormFile(\_MD_SUICO_GROUP_IMAGE, 'group_img', $maxbytes);
        $field_title   = new XoopsFormText(\_MD_SUICO_GROUP_TITLE, 'group_title', 35, 55);
        $field_desc    = new XoopsFormText(\_MD_SUICO_GROUP_DESC, 'group_desc', 35, 55);
        $field_marker  = new XoopsFormHidden('marker', '1');
        $buttonSend    = new XoopsFormButton('', 'submit_button', \_MD_SUICO_UPLOADGROUP, 'submit');
        $field_warning = new XoopsFormLabel(\sprintf(\_MD_SUICO_YOU_CAN_UPLOAD, $maxbytes / 1024));
        $form->addElement($field_warning);
        $form->addElement($field_url, true);
        $form->addElement($field_title);
        $form->addElement($field_desc);
        $form->addElement($field_marker);
        $form->addElement($buttonSend);
        $form->display();
        return true;
    }

    /**
     * @param $group
     * @param $maxbytes
     * @return bool
     */
    public function renderFormEdit(
        $group,
        $maxbytes
    ) {
        $form = new XoopsThemeForm(\_MD_SUICO_EDIT_GROUP, 'form_editgroup', 'editgroup.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $field_groupid = new XoopsFormHidden('group_id', $group->getVar('group_id'));
        $field_url     = new XoopsFormFile(\_MD_SUICO_GROUP_IMAGE, 'img', $maxbytes);
        $field_url->setExtra('style="visibility:hidden;"');
        $field_title         = new XoopsFormText(\_MD_SUICO_GROUP_TITLE, 'title', 35, 55, $group->getVar('group_title'));
        $field_desc          = new XoopsFormTextArea(\_MD_SUICO_GROUP_DESC, 'desc', $group->getVar('group_desc'));
        $field_marker        = new XoopsFormHidden('marker', '1');
        $buttonSend          = new XoopsFormButton('', 'submit_button', \_MD_SUICO_UPLOADGROUP, 'submit');
        $field_warning       = new XoopsFormLabel(\sprintf(\_MD_SUICO_YOU_CAN_UPLOAD, $maxbytes / 1024));
        $field_oldpicture    = new XoopsFormLabel(
            \_MD_SUICO_GROUP_IMAGE, '<img src="' . \XOOPS_UPLOAD_URL . '/' . $group->getVar(
                                      'group_img'
                                  ) . '">'
        );
        $field_maintainimage = new XoopsFormLabel(
            \_MD_SUICO_MAINTAIN_OLD_IMAGE, "<input type='checkbox' value='1' id='flag_oldimg' name='flag_oldimg' onclick=\"groupImgSwitch(img)\"  checked>"
        );
        $form->addElement($field_oldpicture);
        $form->addElement($field_maintainimage);
        $form->addElement($field_warning);
        $form->addElement($field_url);
        $form->addElement($field_groupid);
        $form->addElement($field_title);
        $form->addElement($field_desc);
        $form->addElement($field_marker);
        $form->addElement($buttonSend);
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
     * @param string $group_title
     * @param string $group_desc
     * @param string $group_img
     * @param string $path_upload
     * @param int    $maxfilebytes
     * @param int    $maxfilewidth
     * @param int    $maxfileheight
     * @param int    $change_img
     * @param string $group
     * @return bool
     */
    public function receiveGroup(
        $group_title,
        $group_desc,
        $group_img,
        $path_upload,
        $maxfilebytes,
        $maxfilewidth,
        $maxfileheight,
        $change_img = 1,
        $group = ''
        //        $pictwidth,
        //        $pictheight,
        //        $thumbwidth,
        //        $thumbheight
    )
    {
        global $xoopsUser, $xoopsDB, $_POST, $_FILES;
        /** @var Groups $group */
        //search logged user id
        $uid = $xoopsUser->getVar('uid');
        if ('' === $group || Groups::class !== \get_class($group)) {
            $group = $this->create();
        } else {
            $group->unsetNew();
        }
        $helper      = Helper::getInstance();
        $pictwidth   = $helper->getConfig('resized_width');
        $pictheight  = $helper->getConfig('resized_height');
        $thumbwidth  = $helper->getConfig('thumb_width');
        $thumbheight = $helper->getConfig('thumb_height');
        if (1 === $change_img) {
            // mimetypes and settings put this in admin part later
            $allowed_mimetypes = Helper::getInstance()->getConfig(
                'mimetypes'
            );
            $maxfilesize       = $maxfilebytes;
            $uploadDir         = \XOOPS_UPLOAD_PATH . '/suico/groups/';
            // create the object to upload
            $uploader = new XoopsMediaUploader(
                $uploadDir, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight
            );
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
                $maxWidth_grouplogo     = Helper::getInstance()->getConfig('thumb_width');
                $maxHeight_grouplogo    = Helper::getInstance()->getConfig('thumb_height');
                $resizer->endFile       = $uploadDir . '/thumb_' . $savedFilename;
                $resizer->imageMimetype = $imageMimetype;
                $resizer->maxWidth      = $maxWidth_grouplogo;
                $resizer->maxHeight     = $maxHeight_grouplogo;
                $result                 = $resizer->resizeImage();
                $maxWidth_grouplogo     = Helper::getInstance()->getConfig('resized_width');
                $maxHeight_grouplogo    = Helper::getInstance()->getConfig('resized_height');
                $resizer->endFile       = $uploadDir . '/resized_' . $savedFilename;
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

    /**
     * @param $owner_id
     * @return mixed
     */
    public function isGroupMember($owner_id)
    {
        $query               = 'SELECT COUNT(rel_id) AS grouptotalmembers FROM ' . $GLOBALS['xoopsDB']->prefix('suico_relgroupuser') . ' WHERE rel_group_id=' . $group_id . '';
        $queryresult         = $GLOBALS['xoopsDB']->query($query);
        $row                 = $GLOBALS['xoopsDB']->fetchArray($queryresult);
        $group_total_members = $row['grouptotalmembers'];
        return $group_total_members;
    }

    /**
     * @param $group_id
     * @return mixed
     */
    public function getComment($group_id)
    {
        $moduleSuico = Helper::getInstance()->getModule();
        $sql         = 'SELECT count(com_id) FROM ' . $GLOBALS['xoopsDB']->prefix('xoopscomments') . " WHERE com_modid = '" . $moduleSuico->getVar('mid') . "' AND com_itemid = '" . $group_id . "'";
        $result      = $GLOBALS['xoopsDB']->query($sql);
        while (false !== ($row = $GLOBALS['xoopsDB']->fetchArray($result))) {
            $group_total_comments = $row['count(com_id)'];
        }
        return $group_total_comments;
    }

    /**
     * @param $group_id
     * @return mixed
     */
    public function getGroupTotalMembers($group_id)
    {
        $query               = 'SELECT COUNT(rel_id) AS grouptotalmembers FROM ' . $GLOBALS['xoopsDB']->prefix('suico_relgroupuser') . ' WHERE rel_group_id=' . $group_id . '';
        $queryresult         = $GLOBALS['xoopsDB']->query($query);
        $row                 = $GLOBALS['xoopsDB']->fetchArray($queryresult);
        $group_total_members = $row['grouptotalmembers'];
        return $group_total_members;
    }
}
