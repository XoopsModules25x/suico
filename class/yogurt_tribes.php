<?php
/**
 * Protection against inclusion outside the site
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Includes of form objects and uploader
 */
include_once XOOPS_ROOT_PATH . '/class/uploader.php';
include_once XOOPS_ROOT_PATH . '/kernel/object.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/kernel/object.php';
include_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * yogurt_tribes class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class yogurt_tribes extends XoopsObject
{
    public $db;

    // constructor

    /**
     * yogurt_tribes constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('tribe_id', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('owner_uid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('tribe_title', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('tribe_desc', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('tribe_img', XOBJ_DTYPE_TXTBOX, null, false);
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_tribes') . ' WHERE tribe_id=' . $id;
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
    public function getAllyogurt_tribess($criteria = [], $asobject = false, $sort = 'tribe_id', $order = 'ASC', $limit = 0, $start = 0)
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
            $sql    = 'SELECT tribe_id FROM ' . $db->prefix('yogurt_tribes') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = $myrow['yogurt_tribes_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_tribes') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = new yogurt_tribes($myrow);
            }
        }
        return $ret;
    }
}

// -------------------------------------------------------------------------
// ------------------yogurt_tribes user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_tribeshandler class.
 * This class provides simple mecanisme for yogurt_tribes object
 */
class Xoopsyogurt_tribesHandler extends XoopsObjectHandler
{

    /**
     * create a new yogurt_tribes
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject yogurt_tribes
     */
    public function create($isNew = true)
    {
        $yogurt_tribes = new yogurt_tribes();
        if ($isNew) {
            $yogurt_tribes->setNew();
        } else {
            $yogurt_tribes->unsetNew();
        }

        return $yogurt_tribes;
    }

    /**
     * retrieve a yogurt_tribes
     *
     * @param int $id of the yogurt_tribes
     * @return mixed reference to the {@link yogurt_tribes} object, FALSE if failed
     */
    public function &get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_tribes') . ' WHERE tribe_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_tribes = new yogurt_tribes();
            $yogurt_tribes->assignVars($this->db->fetchArray($result));
            return $yogurt_tribes;
        }
        return false;
    }

    /**
     * insert a new yogurt_tribes in the database
     *
     * @param \XoopsObject $yogurt_tribes reference to the {@link yogurt_tribes}
     *                                    object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(XoopsObject $yogurt_tribes, $force = false)
    {
        global $xoopsConfig;
        if ('yogurt_tribes' != get_class($yogurt_tribes)) {
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
            // ajout/modification d'un yogurt_tribes
            $yogurt_tribes = new yogurt_tribes();
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
        if (false !== $force) {
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
     * delete a yogurt_tribes from the database
     *
     * @param \XoopsObject $yogurt_tribes reference to the yogurt_tribes to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(XoopsObject $yogurt_tribes, $force = false)
    {
        if ('yogurt_tribes' != get_class($yogurt_tribes)) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE tribe_id = %u', $this->db->prefix('yogurt_tribes'), $yogurt_tribes->getVar('tribe_id'));
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
     * retrieve yogurt_tribess from the database
     *
     * @param CriteriaElement $criteria  {@link CriteriaElement} conditions to be met
     * @param bool   $id_as_key use the UID as key for the array?
     * @return array array of {@link yogurt_tribes} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_tribes');
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
            $yogurt_tribes = new yogurt_tribes();
            $yogurt_tribes->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $yogurt_tribes;
            } else {
                $ret[$myrow['tribe_id']] =& $yogurt_tribes;
            }
            unset($yogurt_tribes);
        }
        return $ret;
    }

    /**
     * retrieve yogurt_tribess from the database
     *
     * @param CriteriaElement $criteria  {@link CriteriaElement} conditions to be met
     * @param bool   $id_as_key use the UID as key for the array?
     * @return array array of {@link yogurt_tribes} objects
     */
    public function getTribes($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_tribes');
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

        $i = 0;
        while ($myrow = $this->db->fetchArray($result)) {
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
     * @param CriteriaElement $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_tribess
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_tribes');
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
     * delete yogurt_tribess matching a set of conditions
     *
     * @param CriteriaElement $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_tribes');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
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
        $form = new XoopsThemeForm(_MD_YOGURT_SUBMIT_TRIBE, 'form_tribe', 'submit_tribe.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        $field_url     = new XoopsFormFile(_MD_YOGURT_TRIBE_IMAGE, 'tribe_img', $maxbytes);
        $field_title   = new XoopsFormText(_MD_YOGURT_TRIBE_TITLE, 'tribe_title', 35, 55);
        $field_desc    = new XoopsFormText(_MD_YOGURT_TRIBE_DESC, 'tribe_desc', 35, 55);
        $field_marker  = new XoopsFormHidden('marker', '1');
        $button_send   = new XoopsFormButton('', 'submit_button', _MD_YOGURT_UPLOADTRIBE, 'submit');
        $field_warning = new XoopsFormLabel(sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxbytes / 1024));

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
        $form = new XoopsThemeForm(_MD_YOGURT_EDIT_TRIBE, 'form_edittribe', 'edittribe.php', 'post', true);
        $form->setExtra('enctype="multipart/form-data"');
        $field_tribeid = new XoopsFormHidden('tribe_id', $tribe->getVar('tribe_id'));
        $field_url     = new XoopsFormFile(_MD_YOGURT_TRIBE_IMAGE, 'img', $maxbytes);
        $field_url->setExtra('style="visibility:hidden;"');
        $field_title   = new XoopsFormText(_MD_YOGURT_TRIBE_TITLE, 'title', 35, 55, $tribe->getVar('tribe_title'));
        $field_desc    = new XoopsFormTextArea(_MD_YOGURT_TRIBE_DESC, 'desc', $tribe->getVar('tribe_desc'));
        $field_marker  = new XoopsFormHidden('marker', '1');
        $button_send   = new XoopsFormButton('', 'submit_button', _MD_YOGURT_UPLOADTRIBE, 'submit');
        $field_warning = new XoopsFormLabel(sprintf(_MD_YOGURT_YOUCANUPLOAD, $maxbytes / 1024));

        $field_oldpicture = new XoopsFormLabel(_MD_YOGURT_TRIBE_IMAGE, '<img src="' . XOOPS_UPLOAD_URL . '/' . $tribe->getVar('tribe_img') . '" />');

        $field_maintainimage = new XoopsFormLabel(_MD_YOGURT_MAINTAINOLDIMAGE, "<input type='checkbox' value='1' id='flag_oldimg' name='flag_oldimg' onclick=\"tribeImgSwitch(img)\"  checked/>");

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
<!-- End Form Vaidation JavaScript //-->
		
		
		
		
		
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
        //busca id do user logado
        $uid = $xoopsUser->getVar('uid');
        if (!is_a($tribe, 'yogurt_tribes')) {
            $tribe = $this->create();
        } else {
            $tribe->unsetNew();
        }
        if (1 == $change_img) {
            // mimetypes and settings put this in admin part later
            $allowed_mimetypes = ['image/jpeg', 'image/pjpeg'];
            $maxfilesize       = $maxfilebytes;

            // create the object to upload
            $uploader = new XoopsMediaUploader($path_upload, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
            // fetch the media
            if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
                //lets create a name for it
                $uploader->setPrefix('tribe_' . $uid . '_');
                //now let s upload the file

                if (!$uploader->upload()) {
                    // if there are errors lets return them

                    echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';
                    return false;
                } else {
                    // now let s create a new object picture and set its variables

                    $url               = $uploader->getSavedFileName();
                    $saved_destination = $uploader->getSavedDestination();
                    $image_name        = $this->resizeImage2($saved_destination, 125, 80, $path_upload);
                    $tribe->setVar('tribe_img', $image_name);
                }
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

    /**
     * Resize a picture and save it to $path_upload
     *
     * @param      $img_path
     * @param int  $thumbwidth  the width in pixels that the thumbnail will have
     * @param int  $thumbheight the height in pixels that the thumbnail will have
     * @param text $path_upload The path to where the files should be saved after resizing
     * @return void
     */
    public function resizeImage($img_path, $thumbwidth, $thumbheight, $path_upload)
    {
        $path   = pathinfo($img_path);
        $img    = imagecreatefromjpeg($img_path);
        $xratio = $thumbwidth / imagesx($img);
        $yratio = $thumbheight / imagesy($img);

        if ($xratio < 1 || $yratio < 1) {
            if ($xratio < $yratio) {
                $resized = imagecreatetruecolor($thumbwidth, floor(imagesy($img) * $xratio));
            } else {
                $resized = imagecreatetruecolor(floor(imagesx($img) * $yratio), $thumbheight);
            }
            imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized) + 1, imagesy($resized) + 1, imagesx($img), imagesy($img));
            imagejpeg($resized, $path_upload . '/thumb_' . $path['basename']);
            imagedestroy($resized);
        } else {
            imagejpeg($img, $path_upload . '/thumb_' . $path['basename']);
        }

        imagedestroy($img);
    }

    /**
     * Resize a picture and save it to $path_upload
     *
     * @param      $img_path
     * @param int  $thumbwidth  the width in pixels that the thumbnail will have
     * @param int  $thumbheight the height in pixels that the thumbnail will have
     * @param text $path_upload The path to where the files should be saved after resizing
     * @return nothing
     */
    public function resizeImage2($img_path, $thumbwidth, $thumbheight, $path_upload)
    {
        global $xoopsUser, $xoopsModule;

        $path = pathinfo($img_path);
        $img  = imagecreatefromjpeg($img_path);
        if (imagesx($img) < 128) {
            $x1 = (128 - imagesx($img)) / 2;
            $x2 = 0;
            $w  = imagesx($img);
        } else {
            $x1 = 0;
            $x2 = (imagesx($img) - 128) / 2;
            $w  = 125;
        }

        if (imagesy($img) < 80) {
            $y1 = (80 - imagesy($img)) / 2;
            $y2 = 0;
            $h  = imagesy($img);
        } else {
            $y1 = 0;
            $y2 = (imagesy($img) - 80) / 2;
            $h  = 80;
        }

        $xratio = $thumbwidth / imagesx($img);
        $yratio = $thumbheight / imagesy($img);

        $resized = imagecreatefromgif('images/tribetemplate.gif');

        $imagem   = imagecopymerge($resized, $img, $x1, $y1, $x2, $y2, $w, $h, 90);
        $gif_name = 'tribe_' . $xoopsUser->getVar('uid') . rand(1000000, 9999999) . '.gif';
        imagegif($resized, $path_upload . '/' . $gif_name);
        imagedestroy($resized);
        imagedestroy($img);
        return $gif_name;
    }
}
