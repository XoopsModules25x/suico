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

use CriteriaElement;
use Xmf\Request;
use XoopsDatabase;
use XoopsFormButton;
use XoopsFormFile;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormText;
use XoopsMediaUploader;
use XoopsObject;
use XoopsPersistableObjectHandler;
use XoopsThemeForm;

/**
 * @category        Module
 * @package         suico
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

/**
 * Includes of form objects and uploader
 */
require_once XOOPS_ROOT_PATH . '/class/uploader.php';
require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

/**
 * suico_imageshandler class.
 * This class provides simple mechanism for Image object and generate forms for inclusion etc
 */
class ImageHandler extends XoopsPersistableObjectHandler
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
        parent::__construct($xoopsDatabase, 'suico_images', Image::class, 'image_id', 'title', 'caption');
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
        //        if ($isNew) {
        //            $obj->setDefaultPermissions();
        //        }
        if ($isNew) {
            $obj->setNew();
        } else {
            $obj->unsetNew();
        }
        $obj->helper = $this->helper;
        return $obj;
    }

    /**
     * retrieve a Image
     *
     * @param int|null $id of the Image
     * @param null $fields
     * @return mixed reference to the {@link Image} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('suico_images') . ' WHERE image_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $image = new Image();
            $image->assignVars($this->db->fetchArray($result));
            return $image;
        }
        return false;
    }

    /**
     * insert a new Image in the database
     *
     * @param \XoopsObject $xoopsObject reference to the {@link Image} object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Image) {
            return false;
        }
        if (!$xoopsObject->isDirty()) {
            return true;
        }
        if (!$xoopsObject->cleanVars()) {
            return false;
        }
        $image_id = '';
        foreach ($xoopsObject->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        //        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($xoopsObject->isNew()) {
            // ajout/modification d'un Image
            $xoopsObject = new Image();
            $format      = 'INSERT INTO %s (image_id, title, caption, date_created, date_updated, uid_owner, filename, private)';
            $format      .= 'VALUES (%u, %s, %s, %s, %s, %s, %s, 0)';
            $sql         = \sprintf(
                $format,
                $this->db->prefix('suico_images'),
                $image_id,
                $this->db->quoteString($title),
                $this->db->quoteString($caption),
                \time(),//$now,
                \time(),//$now,
                $this->db->quoteString($uid_owner),
                $this->db->quoteString($filename)
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'image_id=%u, title=%s, caption=%s, date_created=%s, date_updated=%s, uid_owner=%s, filename=%s, private=%s';
            $format .= ' WHERE image_id = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('suico_images'),
                $image_id,
                $this->db->quoteString($title),
                $this->db->quoteString($caption),
                $xoopsObject->getVar('date_created'), // $now,
                $xoopsObject->getVar('date_updated'), // $now,
                $this->db->quoteString($uid_owner),
                $this->db->quoteString($filename),
                $this->db->quoteString($private),
                $image_id
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
        if (empty($image_id)) {
            $image_id = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('image_id', $image_id);
        return true;
    }

    /**
     * delete a Image from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Image to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Image) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE image_id = %u',
            $this->db->prefix('suico_images'),
            $xoopsObject->getVar('image_id')
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
     * retrieve suico_imagess from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Image} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('suico_images');
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
            $image = new Image();
            $image->assignVars($myrow);
            if ($id_as_key) {
                $ret[$myrow['image_id']] = &$image;
            } else {
                $ret[] = &$image;
            }
            unset($image);
        }
        return $ret;
    }

    /**
     * count suico_imagess matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of suico_imagess
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('suico_images');
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
     * delete suico_imagess matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('suico_images');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Render a form to send pictures
     *
     * @param int       $maxbytes the maximum size of a picture
     * @param \XoopsTpl $xoopsTpl the one in which the form will be rendered
     * @return bool TRUE
     *
     * obs: Some functions wont work on php 4 so edit lines down under acording to your version
     */
    public function renderFormSubmit(
        $maxbytes,
        $xoopsTpl
    ) {
        $form          = new XoopsThemeForm(\_MD_SUICO_SUBMIT_PIC_TITLE, 'form_picture', 'submitImage.php', 'post', true);
        $field_url     = new XoopsFormFile(\_MD_SUICO_SELECT_PHOTO, 'sel_photo', 2000000);
        $field_title   = new XoopsFormText(\_MD_SUICO_PHOTOTITLE, 'title', 35, 55);
        $field_caption = new XoopsFormText(\_MD_SUICO_CAPTION, 'caption', 35, 55);
        $form->setExtra('enctype="multipart/form-data"');
        $buttonSend    = new XoopsFormButton('', 'submit_button', \_MD_SUICO_UPLOADPICTURE, 'submit');
        $field_warning = new XoopsFormLabel(\sprintf(\_MD_SUICO_YOU_CAN_UPLOAD, $maxbytes / 1024));
        $form->addElement($field_warning);
        $form->addElement($field_url, true);
        $form->addElement($field_title);
        $form->addElement($field_caption);
        $form->addElement($buttonSend);
        $form->assign($xoopsTpl); //If your server is php 5
        return true;
    }

    /**
     * Render a form to edit the description of the pictures
     *
     * @param        $title
     * @param string $caption  The description of the picture
     * @param int    $image_id the id of the image in database
     * @param string $filename the url to the thumb of the image so it can be displayed
     * @return bool TRUE
     */
    public function renderFormEdit(
        $title,
        $caption,
        $image_id,
        $filename
    ) {
        $form          = new XoopsThemeForm(\_MD_SUICO_EDIT_PICTURE, 'form_picture', 'editpicture.php', 'post', true);
        $field_title   = new XoopsFormText($title, 'title', 35, 55);
        $field_caption = new XoopsFormText($caption, 'caption', 35, 55);
        $form->setExtra('enctype="multipart/form-data"');
        $buttonSend     = new XoopsFormButton('', 'submit_button', \_MD_SUICO_SUBMIT, 'submit');
        $field_warning  = new XoopsFormLabel("<img src='" . $filename . "' alt='thumb'>");
        $field_image_id = new XoopsFormHidden('image_id', $image_id);
        $field_marker   = new XoopsFormHidden('marker', 1);
        $form->addElement($field_warning);
        $form->addElement($field_title);
        $form->addElement($field_caption);
        $form->addElement($field_image_id);
        $form->addElement($field_marker);
        $form->addElement($buttonSend);
        $form->display();
        return true;
    }

    /**
     * Upload the file and Save into database
     *
     * @param string $title         A litle title of the file
     * @param string $caption       A litle description of the file
     * @param string $pathUpload    The path to where the file should be uploaded
     * @param int    $thumbwidth    the width in pixels that the thumbnail will have
     * @param int    $thumbheight   the height in pixels that the thumbnail will have
     * @param int    $pictwidth     the width in pixels that the pic will have
     * @param int    $pictheight    the height in pixels that the pic will have
     * @param int    $maxfilebytes  the maximum size a file can have to be uploaded in bytes
     * @param int    $maxfilewidth  the maximum width in pixels that a pic can have
     * @param int    $maxfileheight the maximum height in pixels that a pic can have
     * @return bool FALSE if upload fails or database fails
     */
    public function receivePicture(
        $title,
        $caption,
        $pathUpload,
        $thumbwidth,
        $thumbheight,
        $pictwidth,
        $pictheight,
        $maxfilebytes,
        $maxfilewidth,
        $maxfileheight
    ) {
        global $xoopsUser, $xoopsDB;
        //search logged user id
        $uid = $xoopsUser->getVar('uid');
        //create a hash so it does not erase another file
        //$hash1 = date();
        //$hash = substr($hash1,0,4);
        // mimetypes and settings put this in admin part later
        $allowed_mimetypes = Helper::getInstance()->getConfig(
            'mimetypes'
        );
        $maxfilesize       = $maxfilebytes;
        //        $uploadDir = \XOOPS_UPLOAD_PATH . '/suico/images/';
        // create the object to upload
        $uploader = new XoopsMediaUploader(
            $pathUpload, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight
        );
        // fetch the media
        if ($uploader->fetchMedia(Request::getArray('xoops_upload_file', '', 'POST')[0])) {
            //lets create a name for it
            $uploader->setPrefix('pic_' . $uid . '_');
            //now let s upload the file
            if (!$uploader->upload()) {
                // if there are errors lets return them
                echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';
                return false;
            }
            // now let s create a new object picture and set its variables
            $picture  = $this->create();
            $filename = $uploader->getSavedFileName();
            $picture->setVar('filename', $filename);
            $picture->setVar('title', $title);
            $picture->setVar('caption', $caption);
            $picture->setVar('date_created', \time());
            $picture->setVar('date_updated', \time());
            $picture->setVar('private', 0);
            $uid = $xoopsUser->getVar('uid');
            $picture->setVar('uid_owner', $uid);
            $this->insert($picture);
            $saved_destination = $uploader->getSavedDestination();
            //print_r($_FILES);
            //$this->resizeImage($saved_destination,false, $thumbwidth, $thumbheight, $pictwidth, $pictheight,$pathUpload);
            //$this->resizeImage($saved_destination,true, $thumbwidth, $thumbheight, $pictwidth, $pictheight,$pathUpload);
            $this->resizeImage(
                $saved_destination,
                $thumbwidth,
                $thumbheight,
                $pictwidth,
                $pictheight,
                $pathUpload
            );
        } else {
            echo '<div style="color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center"><p>' . $uploader->getErrors() . '</p></div>';
            return false;
        }
        return true;
    }

    /**
     * Resize a picture and save it to $pathUpload
     *
     * @param string $img         the path to the file
     * @param int    $thumbwidth  the width in pixels that the thumbnail will have
     * @param int    $thumbheight the height in pixels that the thumbnail will have
     * @param int    $pictwidth   the width in pixels that the pic will have
     * @param int    $pictheight  the height in pixels that the pic will have
     * @param string $pathUpload  The path to where the files should be saved after resizing
     */
    public function resizeImage(
        $img,
        $thumbwidth,
        $thumbheight,
        $pictwidth,
        $pictheight,
        $pathUpload
    ) {
        $img2   = $img;
        $path   = \pathinfo($img);
        $img    = \imagecreatefromjpeg($img);
        $xratio = $thumbwidth / \imagesx($img);
        $yratio = $thumbheight / \imagesy($img);
        if ($xratio < 1 || $yratio < 1) {
            if ($xratio < $yratio) {
                $resized = \imagecreatetruecolor($thumbwidth, (int)\floor(\imagesy($img) * $xratio));
            } else {
                $resized = \imagecreatetruecolor((int)\floor(\imagesx($img) * $yratio), $thumbheight);
            }
            \imagecopyresampled(
                $resized,
                $img,
                0,
                0,
                0,
                0,
                \imagesx($resized) + 1,
                \imagesy($resized) + 1,
                \imagesx($img),
                \imagesy($img)
            );
            \imagejpeg($resized, $pathUpload . '/thumb_' . $path['basename']);
            \imagedestroy($resized);
        } else {
            \imagejpeg($img, $pathUpload . '/thumb_' . $path['basename']);
        }
        \imagedestroy($img);
        $path2   = \pathinfo($img2);
        $img2    = \imagecreatefromjpeg($img2);
        $xratio2 = $pictwidth / \imagesx($img2);
        $yratio2 = $pictheight / \imagesy($img2);
        if ($xratio2 < 1 || $yratio2 < 1) {
            if ($xratio2 < $yratio2) {
                $resized2 = \imagecreatetruecolor($pictwidth, (int)\floor(\imagesy($img2) * $xratio2));
            } else {
                $resized2 = \imagecreatetruecolor((int)\floor(\imagesx($img2) * $yratio2), $pictheight);
            }
            \imagecopyresampled(
                $resized2,
                $img2,
                0,
                0,
                0,
                0,
                \imagesx($resized2) + 1,
                \imagesy($resized2) + 1,
                \imagesx($img2),
                \imagesy($img2)
            );
            \imagejpeg($resized2, $pathUpload . '/resized_' . $path2['basename']);
            \imagedestroy($resized2);
        } else {
            \imagejpeg($img2, $pathUpload . '/resized_' . $path2['basename']);
        }
        \imagedestroy($img2);
    }

    /**
     * @param $limit
     * @return array
     */
    public function getLastPictures($limit)
    {
        $ret    = [];
        $sql    = 'SELECT uname, t.uid_owner, t.filename FROM ' . $this->db->prefix(
                'suico_images'
            ) . ' AS t, ' . $this->db->prefix(
                'users'
            );
        $sql    .= ' WHERE uid_owner = uid AND private=0 ORDER BY image_id DESC';
        $result = $this->db->query($sql, $limit, 0);
        $vetor  = [];
        $i      = 0;
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $vetor[$i]['uid_owner']    = $myrow['uid_owner'];
            $vetor[$i]['uname']        = $myrow['uname'];
            $vetor[$i]['img_filename'] = $myrow['filename'];
            $i++;
        }
        return $vetor;
    }

    /**
     * @param $limit
     * @return array
     */
    public function getLastPicturesForBlock($limit)
    {
        global $xoopsUser, $xoopsDB;
        if (\is_object($xoopsUser)) {
            $uid = $xoopsUser->getVar('uid');
        }

        $controller = new PhotosController($xoopsDB, $xoopsUser);

        $isUser      = $controller->isUser;
        $isAnonymous = $controller->isAnonym;

        if (1 == $isAnonymous) {
            $sql = 'SELECT uname, t.uid_owner, t.filename, t.title, t.caption, t.date_created, t.date_updated  FROM ' . $this->db->prefix('suico_images') . ' AS t';
            $sql .= ' INNER JOIN ' . $this->db->prefix('users') . ' u ON t.uid_owner=u.uid';
            $sql .= ' INNER JOIN ' . $this->db->prefix('suico_configs') . ' c on t.uid_owner=c.config_uid';
            $sql .= ' WHERE private=0 AND c.pictures < 2 ';
            $sql .= ' ORDER BY image_id DESC';
        }
        if (1 == $isUser) {
            $sql0 = 'SELECT f.friend2_uid FROM ' . $this->db->prefix('suico_friendships') . ' AS f';
            $sql0 .= ' WHERE f.friend1_uid = '. $uid ;
            $sql = 'SELECT uname, t.uid_owner, t.filename, t.title, t.caption, t.date_created, t.date_updated  FROM ' . $this->db->prefix('suico_images') . ' AS t';
            $sql .= ' INNER JOIN ' . $this->db->prefix('users') . ' u ON t.uid_owner=u.uid';
            $sql .= ' INNER JOIN ' . $this->db->prefix('suico_configs') . ' c on t.uid_owner=c.config_uid';
            $sql .= ' WHERE (private=0 AND c.pictures < 3 )'; //all pictures visible to members
            $sql .= ' OR ( private=0 AND c.pictures = 3 AND c.config_uid IN ( '. $sql0 .')) '; //pictures visible to friends
            $sql .= ' OR ( c.config_uid = '. $uid .' ) '; //my private pictures
            $sql .= ' ORDER BY image_id DESC';
        }

        $result = $this->db->query($sql, $limit, 0);


        $vetor  = [];
        $i      = 0;
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $vetor[$i]['uid_owner']    = $myrow['uid_owner'];
            $vetor[$i]['uname']        = $myrow['uname'];
            $vetor[$i]['img_filename'] = $myrow['filename'];
            $vetor[$i]['title']        = $myrow['title'];
            $vetor[$i]['caption']      = $myrow['caption'];
            $vetor[$i]['date_created'] = \formatTimestamp($myrow['date_created']);
            $vetor[$i]['date_updated'] = \formatTimestamp($myrow['date_updated']);
            $i++;
        }
        return $vetor;
    }

    /**
     * Resize a picture and save it to $pathUpload
     *
     * @param string $img        the path to the file
     * @param        $width
     * @param        $height
     * @param string $pathUpload The path to where the files should be saved after resizing
     */
    public function makeAvatar(
        $img,
        $width,
        $height,
        $pathUpload
    ) {
        $img2   = $img;
        $path   = \pathinfo($img);
        $img    = \imagecreatefromjpeg($img);
        $xratio = $thumbwidth / \imagesx($img);
        $yratio = $thumbheight / \imagesy($img);
        if ($xratio < 1 || $yratio < 1) {
            if ($xratio < $yratio) {
                $resized = \imagecreatetruecolor($thumbwidth, (int)\floor(\imagesy($img) * $xratio));
            } else {
                $resized = \imagecreatetruecolor((int)\floor(\imagesx($img) * $yratio), $thumbheight);
            }
            \imagecopyresampled(
                $resized,
                $img,
                0,
                0,
                0,
                0,
                \imagesx($resized) + 1,
                \imagesy($resized) + 1,
                \imagesx($img),
                \imagesy($img)
            );
            \imagejpeg($resized, $pathUpload . '/thumb_' . $path['basename']);
            \imagedestroy($resized);
        } else {
            \imagejpeg($img, $pathUpload . '/thumb_' . $path['basename']);
        }
        \imagedestroy($img);
        $path2   = \pathinfo($img2);
        $img2    = \imagecreatefromjpeg($img2);
        $xratio2 = $pictwidth / \imagesx($img2);
        $yratio2 = $pictheight / \imagesy($img2);
        if ($xratio2 < 1 || $yratio2 < 1) {
            if ($xratio2 < $yratio2) {
                $resized2 = \imagecreatetruecolor($pictwidth, (int)\floor(\imagesy($img2) * $xratio2));
            } else {
                $resized2 = \imagecreatetruecolor((int)\floor(\imagesx($img2) * $yratio2), $pictheight);
            }
            \imagecopyresampled(
                $resized2,
                $img2,
                0,
                0,
                0,
                0,
                \imagesx($resized2) + 1,
                \imagesy($resized2) + 1,
                \imagesx($img2),
                \imagesy($img2)
            );
            \imagejpeg($resized2, $pathUpload . '/resized_' . $path2['basename']);
            \imagedestroy($resized2);
        } else {
            \imagejpeg($img2, $pathUpload . '/resized_' . $path2['basename']);
        }
        \imagedestroy($img2);
    }
}

