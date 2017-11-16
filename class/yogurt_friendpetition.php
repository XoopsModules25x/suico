<?php
// yogurt_friendpetition.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
/**
* yogurt_friendpetition class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class yogurt_friendpetition extends XoopsObject
{ 
	var $db;

// constructor
	function yogurt_friendpetition ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("friendpet_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("petitioner_uid",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("petioned_uid",XOBJ_DTYPE_INT,null,false,10);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("yogurt_friendpetition").' WHERE friendpet_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllyogurt_friendpetitions($criteria=array(), $asobject=false, $sort="friendpet_id", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT friendpet_id FROM ".$db->prefix("yogurt_friendpetition")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['yogurt_friendpetition_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("yogurt_friendpetition")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new yogurt_friendpetition ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------yogurt_friendpetition user handler class -------------------
// -------------------------------------------------------------------------
/**
* yogurt_friendpetitionhandler class.  
* This class provides simple mecanisme for yogurt_friendpetition object
*/

class Xoopsyogurt_friendpetitionHandler extends XoopsObjectHandler
{

	/**
	* create a new yogurt_friendpetition
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object yogurt_friendpetition
	*/
	function &create($isNew = true)	{
		$yogurt_friendpetition = new yogurt_friendpetition();
		if ($isNew) {
			$yogurt_friendpetition->setNew();
		}
		else{
		$yogurt_friendpetition->unsetNew();
		}

		
		return $yogurt_friendpetition;
	}

	/**
	* retrieve a yogurt_friendpetition
	* 
	* @param int $id of the yogurt_friendpetition
	* @return mixed reference to the {@link yogurt_friendpetition} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('yogurt_friendpetition').' WHERE friendpet_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$yogurt_friendpetition = new yogurt_friendpetition();
				$yogurt_friendpetition->assignVars($this->db->fetchArray($result));
				return $yogurt_friendpetition;
			}
				return false;
	}

/**
* insert a new yogurt_friendpetition in the database
* 
* @param object $yogurt_friendpetition reference to the {@link yogurt_friendpetition} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$yogurt_friendpetition, $force = false) {
		Global $xoopsConfig;
		if (get_class($yogurt_friendpetition) != 'yogurt_friendpetition') {
				return false;
		}
		if (!$yogurt_friendpetition->isDirty()) {
				return true;
		}
		if (!$yogurt_friendpetition->cleanVars()) {
				return false;
		}
		foreach ($yogurt_friendpetition->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($yogurt_friendpetition->isNew()) {
			// ajout/modification d'un yogurt_friendpetition
			$yogurt_friendpetition = new yogurt_friendpetition();
			$format = "INSERT INTO %s (friendpet_id, petitioner_uid, petioned_uid)";
			$format .= "VALUES (%u, %u, %u)";
			$sql = sprintf($format , 
			$this->db->prefix('yogurt_friendpetition'), 
			$friendpet_id
			,$petitioner_uid
			,$petioned_uid
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="friendpet_id=%u, petitioner_uid=%u, petioned_uid=%u";
			$format .=" WHERE friendpet_id = %u";
			$sql = sprintf($format, $this->db->prefix('yogurt_friendpetition'),
			$friendpet_id
			,$petitioner_uid
			,$petioned_uid
			, $friendpet_id);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($friendpet_id)) {
			$friendpet_id = $this->db->getInsertId();
		}
		$yogurt_friendpetition->assignVar('friendpet_id', $friendpet_id);
		return true;
	}

	/**
	 * delete a yogurt_friendpetition from the database
	 * 
	 * @param object $yogurt_friendpetition reference to the yogurt_friendpetition to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$yogurt_friendpetition, $force = false)
	{
		if (get_class($yogurt_friendpetition) != 'yogurt_friendpetition') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE friendpet_id = %u", $this->db->prefix("yogurt_friendpetition"), $yogurt_friendpetition->getVar('friendpet_id'));
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
	* retrieve yogurt_friendpetitions from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link yogurt_friendpetition} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('yogurt_friendpetition');
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
			$yogurt_friendpetition = new yogurt_friendpetition();
			$yogurt_friendpetition->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $yogurt_friendpetition;
			} else {
				$ret[$myrow['friendpet_id']] =& $yogurt_friendpetition;
			}
			unset($yogurt_friendpetition);
		}
		return $ret;
	}

	/**
	* count yogurt_friendpetitions matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of yogurt_friendpetitions
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('yogurt_friendpetition');
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
	* delete yogurt_friendpetitions matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('yogurt_friendpetition');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
}


?>