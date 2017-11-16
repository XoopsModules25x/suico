<?php
/**
* Protection against inclusion outside the site 
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

/**
* Includes of form objects and uploader 
*/
include_once XOOPS_ROOT_PATH."/class/uploader.php";
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";


/**
* yogurt_seutubo class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/
class yogurt_seutubo extends XoopsObject
{ 
	var $db;

// constructor
	function yogurt_seutubo ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("video_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uid_owner",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("video_desc",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("youtube_code",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("main_video",XOBJ_DTYPE_TXTBOX, null, false);
		if ( !empty($id) ) {
			if ( is_array($id) ) {
				$this->assignVars($id);
			} else {
					$this->load(intval($id));
			}
		} else {
			$this->setNew();
		}
		
	}

	function load($id)
	{
		$sql = 'SELECT * FROM '.$this->db->prefix("yogurt_seutubo").' WHERE video_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllyogurt_seutubos($criteria=array(), $asobject=false, $sort="video_id", $order="ASC", $limit=0, $start=0)
	{
		$db =& Database::getInstance();
		$ret = array();
		$where_query = "";
		if ( is_array($criteria) && count($criteria) > 0 ) {
			$where_query = " WHERE";
			foreach ( $criteria as $c ) {
				$where_query .= " $c AND";
			}
			$where_query = substr($where_query, 0, -4);
		} elseif ( !is_array($criteria) && $criteria) {
			$where_query = " WHERE ".$criteria;
		}
		if ( !$asobject ) {
			$sql = "SELECT video_id FROM ".$db->prefix("yogurt_seutubo")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['yogurt_seutubo_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("yogurt_seutubo")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new yogurt_seutubo ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------yogurt_seutubo user handler class -------------------
// -------------------------------------------------------------------------
/**
* yogurt_seutubohandler class.  
* This class provides simple mecanisme for yogurt_seutubo object
*/

class Xoopsyogurt_seutuboHandler extends XoopsObjectHandler
{

	/**
	* create a new yogurt_seutubo
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object yogurt_seutubo
	*/
	function &create($isNew = true)	{
		$yogurt_seutubo = new yogurt_seutubo();
		if ($isNew) {
			$yogurt_seutubo->setNew();
		}
		else{
		$yogurt_seutubo->unsetNew();
		}

		
		return $yogurt_seutubo;
	}

	/**
	* retrieve a yogurt_seutubo
	* 
	* @param int $id of the yogurt_seutubo
	* @return mixed reference to the {@link yogurt_seutubo} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('yogurt_seutubo').' WHERE video_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$yogurt_seutubo = new yogurt_seutubo();
				$yogurt_seutubo->assignVars($this->db->fetchArray($result));
				return $yogurt_seutubo;
			}
				return false;
	}

        /**
	* insert a new yogurt_seutubo in the database
	* 
	* @param object $yogurt_seutubo reference to the {@link yogurt_seutubo} object
	* @param bool $force
	* @return bool FALSE if failed, TRUE if already present and unchanged or successful
	*/
	function insert(&$yogurt_seutubo, $force = false) {
		Global $xoopsConfig;
		if (get_class($yogurt_seutubo) != 'yogurt_seutubo') {
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
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($yogurt_seutubo->isNew()) {
			// ajout/modification d'un yogurt_seutubo
			$yogurt_seutubo = new yogurt_seutubo();
			$format = "INSERT INTO %s (video_id, uid_owner, video_desc, youtube_code, main_video)";
			$format .= "VALUES (%u, %u, %s, %s, %s)";
			$sql = sprintf($format , 
			$this->db->prefix('yogurt_seutubo'), 
			$video_id
			,$uid_owner
			,$this->db->quoteString($video_desc)
			,$this->db->quoteString($youtube_code)
			,$this->db->quoteString($main_video)
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="video_id=%u, uid_owner=%u, video_desc=%s, youtube_code=%s, main_video=%s";
			$format .=" WHERE video_id = %u";
			$sql = sprintf($format, $this->db->prefix('yogurt_seutubo'),
			$video_id
			,$uid_owner
			,$this->db->quoteString($video_desc)
			,$this->db->quoteString($youtube_code)
			,$this->db->quoteString($main_video)
			, $video_id);
		}
		if (false != $force) {
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
	 * delete a yogurt_seutubo from the database
	 * 
	 * @param object $yogurt_seutubo reference to the yogurt_seutubo to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$yogurt_seutubo, $force = false)
	{
		if (get_class($yogurt_seutubo) != 'yogurt_seutubo') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE video_id = %u", $this->db->prefix("yogurt_seutubo"), $yogurt_seutubo->getVar('video_id'));
		if (false != $force) {
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
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link yogurt_seutubo} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('yogurt_seutubo');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		if ($criteria->getSort() != '') {
			$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
		}
		$limit = $criteria->getLimit();
		$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$yogurt_seutubo = new yogurt_seutubo();
			$yogurt_seutubo->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $yogurt_seutubo;
			} else {
				$ret[$myrow['video_id']] =& $yogurt_seutubo;
			}
			unset($yogurt_seutubo);
		}
		return $ret;
	}

	/**
	* count yogurt_seutubos matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of yogurt_seutubos
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('yogurt_seutubo');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
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
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('yogurt_seutubo');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
/**
	* Render a form to send videos
	* 
	* @param int $maxbytes the maximum size of a picture
	* @param object $xoopsTpl the one in which the form will be rendered
	* @return bool TRUE
	*
	* obs: Some functions wont work on php 4 so edit lines down under acording to your version
	*/
	function renderFormSubmit($xoopsTpl)
	{
				
		$form 				= new XoopsThemeForm(_MD_YOGURT_ADDFAVORITEVIDEOS, "form_videos", "video_submited.php", "post", true);
		$field_code 			= new XoopsFormText(_MD_YOGURT_YOUTUBECODE, "codigo", 50, 250);
		$field_desc 			= new XoopsFormTextArea(_MD_YOGURT_CAPTION, "caption");
		$form->setExtra('enctype="multipart/form-data"');
		$button_send 	= new XoopsFormButton("", "submit_button", _MD_YOGURT_ADDVIDEO, "submit");
		
		$form->addElement($field_warning);
		$form->addElement($field_code,true);
		$form->addElement($field_desc);
		
		$form->addElement($button_send);
		if ( (str_replace('.', '', PHP_VERSION)) > 499 )

		{
			$form->assign($xoopsTpl);//If your server is php 5
			//$form->display();
		} else {
		 
		$form->display(); //If your server is php 4.4 
		}
		
		return true;
	}
/**
	* Render a form to edit the description of the pictures
	* 
	* @param string $caption The description of the picture
	* @param int $cod_img the id of the image in database
	* @param text $filename the url to the thumb of the image so it can be displayed
	* @return bool TRUE
	*/
	function renderFormEdit($caption,$cod_img,$filename)
	{
				
		$form 		= new XoopsThemeForm(_MD_YOGURT_EDITDESC, "form_picture", "editdescvideo.php", "post", true);
		$field_desc 	= new XoopsFormText($caption, "caption", 35, 55);
		$form->setExtra('enctype="multipart/form-data"');
		$button_send 	= new XoopsFormButton("", "submit_button", _MD_YOGURT_SUBMIT, "submit");
		$field_warning = new XoopsFormLabel('<object width="425" height="353">
<param name="movie" value="http://www.youtube.com/v/'.$filename.'"></param>
<param name="wmode" value="transparent"></param>
<embed src="http://www.youtube.com/v/'.$filename.'" type="application/x-shockwave-flash" wmode="transparent" width="425" height="353"></embed>
</object>');
		$field_video_id = new XoopsFormHidden("video_id",$cod_img);
		$field_marker = new XoopsFormHidden("marker",1);
		$form->addElement($field_warning);
		$form->addElement($field_desc);
		$form->addElement($field_video_id,true);
		$form->addElement($field_marker);
		$form->addElement($button_send);
		$form->display();
		
		
		return true;
	}
	
	function unsetAllMainsbyID($uid_owner=null)
	{
		$sql = 'UPDATE '.$this->db->prefix('yogurt_seutubo').' SET main_video=0 WHERE uid_owner='.$uid_owner;
		
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
	

}


?>