<?php
// yogurt_visitors.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
/**
* yogurt_visitors class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class yogurt_visitors extends XoopsObject
{ 
	var $db;

// constructor
	function yogurt_visitors ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("cod_visit",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uid_owner",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uid_visitor",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uname_visitor",XOBJ_DTYPE_TXTBOX, null, false);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("yogurt_visitors").' WHERE cod_visit='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllyogurt_visitorss($criteria=array(), $asobject=false, $sort="cod_visit", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT cod_visit FROM ".$db->prefix("yogurt_visitors")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['yogurt_visitors_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("yogurt_visitors")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new yogurt_visitors ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------yogurt_visitors user handler class -------------------
// -------------------------------------------------------------------------
/**
* yogurt_visitorshandler class.  
* This class provides simple mecanisme for yogurt_visitors object
*/

class Xoopsyogurt_visitorsHandler extends XoopsObjectHandler
{

	/**
	* create a new yogurt_visitors
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object yogurt_visitors
	*/
	function &create($isNew = true)	{
		$yogurt_visitors = new yogurt_visitors();
		if ($isNew) {
			$yogurt_visitors->setNew();
		}
		else{
		$yogurt_visitors->unsetNew();
		}

		
		return $yogurt_visitors;
	}

	/**
	* retrieve a yogurt_visitors
	* 
	* @param int $id of the yogurt_visitors
	* @return mixed reference to the {@link yogurt_visitors} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('yogurt_visitors').' WHERE cod_visit='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$yogurt_visitors = new yogurt_visitors();
				$yogurt_visitors->assignVars($this->db->fetchArray($result));
				return $yogurt_visitors;
			}
				return false;
	}

/**
* insert a new yogurt_visitors in the database
* 
* @param object $yogurt_visitors reference to the {@link yogurt_visitors} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$yogurt_visitors, $force = false) {
		Global $xoopsConfig;
		if (get_class($yogurt_visitors) != 'yogurt_visitors') {
				return false;
		}
		if (!$yogurt_visitors->isDirty()) {
				return true;
		}
		if (!$yogurt_visitors->cleanVars()) {
				return false;
		}
		foreach ($yogurt_visitors->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($yogurt_visitors->isNew()) {
			// ajout/modification d'un yogurt_visitors
			$yogurt_visitors = new yogurt_visitors();
			$format = "INSERT INTO %s (cod_visit, uid_owner, uid_visitor,uname_visitor)";
			$format .= "VALUES (%u, %u, %u, %s)";
			$sql = sprintf($format , 
			$this->db->prefix('yogurt_visitors'), 
			$cod_visit
			,$uid_owner
			,$uid_visitor
			,$this->db->quoteString($uname_visitor)
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="cod_visit=%u, uid_owner=%u, uid_visitor=%u, uname_visitor=%s ";
			$format .=" WHERE cod_visit = %u";
			$sql = sprintf($format, $this->db->prefix('yogurt_visitors'),
			$cod_visit
			,$uid_owner
			,$uid_visitor
			,$this->db->quoteString($uname_visitor)
			, $cod_visit);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($cod_visit)) {
			$cod_visit = $this->db->getInsertId();
		}
		$yogurt_visitors->assignVar('cod_visit', $cod_visit);
		return true;
	}

	/**
	 * delete a yogurt_visitors from the database
	 * 
	 * @param object $yogurt_visitors reference to the yogurt_visitors to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$yogurt_visitors, $force = false)
	{
		if (get_class($yogurt_visitors) != 'yogurt_visitors') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE cod_visit = %u", $this->db->prefix("yogurt_visitors"), $yogurt_visitors->getVar('cod_visit'));
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
	* retrieve yogurt_visitorss from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link yogurt_visitors} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('yogurt_visitors');
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
			$yogurt_visitors = new yogurt_visitors();
			$yogurt_visitors->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $yogurt_visitors;
			} else {
				$ret[$myrow['cod_visit']] =& $yogurt_visitors;
			}
			unset($yogurt_visitors);
		}
		return $ret;
	}

	/**
	* count yogurt_visitorss matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of yogurt_visitorss
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('yogurt_visitors');
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
	* delete yogurt_visitorss matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null, $force=false)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('yogurt_visitors');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (false != $force) {
			if (!$result = $this->db->queryF($sql)) {
			return false;
		};
		} else {
			if (!$result = $this->db->query($sql)) {
			return false;
		}
		}
		
		return true;
	}
	
	function purgeVisits(){
		
		$sql = 'DELETE FROM '.$this->db->prefix('yogurt_visitors').' WHERE (datetime<(DATE_SUB(NOW(), INTERVAL 7 DAY))) ';

			if (!$result = $this->db->queryF($sql)) {
			return false;
		}
		
		
		return true;
		
	}
}


?>