<?php
// yogurt_friendship.php,v 1
//  ---------------------------------------------------------------- //
// Author: Bruno Barthez	                                           //
// ----------------------------------------------------------------- //

include_once XOOPS_ROOT_PATH . '/kernel/object.php';
/**
 * Includes of form objects and uploader
 */
include_once XOOPS_ROOT_PATH . '/class/uploader.php';
include_once XOOPS_ROOT_PATH . '/kernel/object.php';
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * yogurt_friendship class.
 * $this class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 */
class yogurt_friendship extends XoopsObject
{
    public $db;

    // constructor

    /**
     * yogurt_friendship constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->db = XoopsDatabaseFactory::getDatabaseConnection();
        $this->initVar('friendship_id', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('friend1_uid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('friend2_uid', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('level', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('hot', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('trust', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('cool', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('fan', XOBJ_DTYPE_INT, null, false, 10);
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
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendship') . ' WHERE friendship_id=' . $id;
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
    public function getAllyogurt_friendships($criteria = [], $asobject = false, $sort = 'friendship_id', $order = 'ASC', $limit = 0, $start = 0)
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
            $sql    = 'SELECT friendship_id FROM ' . $db->prefix('yogurt_friendship') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = $myrow['yogurt_friendship_id'];
            }
        } else {
            $sql    = 'SELECT * FROM ' . $db->prefix('yogurt_friendship') . "$where_query ORDER BY $sort $order";
            $result = $db->query($sql, $limit, $start);
            while ($myrow = $db->fetchArray($result)) {
                $ret[] = new yogurt_friendship($myrow);
            }
        }
        return $ret;
    }
}

// -------------------------------------------------------------------------
// ------------------yogurt_friendship user handler class -------------------
// -------------------------------------------------------------------------

/**
 * yogurt_friendshiphandler class.
 * This class provides simple mecanisme for yogurt_friendship object
 */
class Xoopsyogurt_friendshipHandler extends XoopsObjectHandler
{

    /**
     * create a new yogurt_friendship
     *
     * @param bool $isNew flag the new objects as "new"?
     * @return \XoopsObject yogurt_friendship
     */
    public function create($isNew = true)
    {
        $yogurt_friendship = new yogurt_friendship();
        if ($isNew) {
            $yogurt_friendship->setNew();
        } else {
            $yogurt_friendship->unsetNew();
        }

        return $yogurt_friendship;
    }

    /**
     * retrieve a yogurt_friendship
     *
     * @param int $id of the yogurt_friendship
     * @return mixed reference to the {@link yogurt_friendship} object, FALSE if failed
     */
    public function &get($id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendship') . ' WHERE friendship_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 == $numrows) {
            $yogurt_friendship = new yogurt_friendship();
            $yogurt_friendship->assignVars($this->db->fetchArray($result));
            return $yogurt_friendship;
        }
        return false;
    }

    /**
     * insert a new yogurt_friendship in the database
     *
     * @param \XoopsObject $yogurt_friendship reference to the {@link yogurt_friendship}
     *                                        object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(XoopsObject $yogurt_friendship, $force = false)
    {
        global $xoopsConfig;
        if ('yogurt_friendship' != get_class($yogurt_friendship)) {
            return false;
        }
        if (!$yogurt_friendship->isDirty()) {
            return true;
        }
        if (!$yogurt_friendship->cleanVars()) {
            return false;
        }
        foreach ($yogurt_friendship->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($yogurt_friendship->isNew()) {
            // ajout/modification d'un yogurt_friendship
            $yogurt_friendship = new yogurt_friendship();
            $format            = 'INSERT INTO %s (friendship_id, friend1_uid, friend2_uid, LEVEL, hot, trust, cool, fan)';
            $format            .= 'VALUES (%u, %u, %u, %u, %u, %u, %u, %u)';
            $sql               = sprintf($format, $this->db->prefix('yogurt_friendship'), $friendship_id, $friend1_uid, $friend2_uid, $level, $hot, $trust, $cool, $fan);
            $force             = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'friendship_id=%u, friend1_uid=%u, friend2_uid=%u, level=%u, hot=%u, trust=%u, cool=%u, fan=%u';
            $format .= ' WHERE friendship_id = %u';
            $sql    = sprintf($format, $this->db->prefix('yogurt_friendship'), $friendship_id, $friend1_uid, $friend2_uid, $level, $hot, $trust, $cool, $fan, $friendship_id);
        }
        if (false !== $force) {
            $result = $this->db->queryF($sql);
        } else {
            $result = $this->db->query($sql);
        }
        if (!$result) {
            return false;
        }
        if (empty($friendship_id)) {
            $friendship_id = $this->db->getInsertId();
        }
        $yogurt_friendship->assignVar('friendship_id', $friendship_id);
        return true;
    }

    /**
     * delete a yogurt_friendship from the database
     *
     * @param \XoopsObject $yogurt_friendship reference to the yogurt_friendship to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(XoopsObject $yogurt_friendship, $force = false)
    {
        if ('yogurt_friendship' != get_class($yogurt_friendship)) {
            return false;
        }
        $sql = sprintf('DELETE FROM %s WHERE friendship_id = %u', $this->db->prefix('yogurt_friendship'), $yogurt_friendship->getVar('friendship_id'));
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
     * retrieve yogurt_friendships from the database
     *
     * @param CriteriaElement $criteria  {@link CriteriaElement} conditions to be met
     * @param bool   $id_as_key use the UID as key for the array?
     * @return array array of {@link yogurt_friendship} objects
     */
    public function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('yogurt_friendship');
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
            $yogurt_friendship = new yogurt_friendship();
            $yogurt_friendship->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] =& $yogurt_friendship;
            } else {
                $ret[$myrow['friendship_id']] =& $yogurt_friendship;
            }
            unset($yogurt_friendship);
        }
        return $ret;
    }

    /**
     * count yogurt_friendships matching a condition
     *
     * @param CriteriaElement $criteria {@link CriteriaElement} to match
     * @return int count of yogurt_friendships
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('yogurt_friendship');
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
     * delete yogurt_friendships matching a set of conditions
     *
     * @param CriteriaElement $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('yogurt_friendship');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * @param      $nbfriends
     * @param null $criteria
     * @param int  $shuffle
     * @return array
     */
    public function getFriends($nbfriends, $criteria = null, $shuffle = 1)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT uname, user_avatar, friend2_uid FROM ' . $this->db->prefix('yogurt_friendship') . ', ' . $this->db->prefix('users');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = friend2_uid ';
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }

            $limit = $criteria->getLimit();
            $start = $criteria->getStart();

            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;

            while ($myrow = $this->db->fetchArray($result)) {
                $vetor[$i]['uid']         = $myrow['friend2_uid'];
                $vetor[$i]['uname']       = $myrow['uname'];
                $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
                $i++;
            }
            if (1 == $shuffle) {
                shuffle($vetor);
                $vetor = array_slice($vetor, 0, $nbfriends);
            }
            return $vetor;
        }
    }

    /**
     * @param      $nbfriends
     * @param null $criteria
     * @param int  $shuffle
     * @return array
     */
    public function getFans($nbfriends, $criteria = null, $shuffle = 1)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT uname, user_avatar, friend1_uid FROM ' . $this->db->prefix('yogurt_friendship') . ', ' . $this->db->prefix('users');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = friend1_uid ';
            if ('' != $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }

            $limit = $criteria->getLimit();
            $start = $criteria->getStart();

            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;

            while ($myrow = $this->db->fetchArray($result)) {
                $vetor[$i]['uid']         = $myrow['friend1_uid'];
                $vetor[$i]['uname']       = $myrow['uname'];
                $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
                $i++;
            }
            if (1 == $shuffle) {
                shuffle($vetor);
                $vetor = array_slice($vetor, 0, $nbfriends);
            }
            return $vetor;
        }
    }

    /**
     * @param $friend
     */
    public function renderFormSubmit($friend)
    {
        global $xoopsUser;
        /**
         * criteria fetch friendship to be edited
         */
        $criteria_friend1    = new criteria('friend1_uid', $xoopsUser->getVar('uid'));
        $criteria_friend2    = new criteria('friend2_uid', $friend->getVar('uid'));
        $criteria_friendship = new criteriaCompo($criteria_friend1);
        $criteria_friendship->add($criteria_friend2);
        $friendships = $this->getObjects($criteria_friendship);
        $friendship  = $friendships[0];

        $form = new XoopsThemeForm(_MD_YOGURT_EDITFRIENDSHIP, 'form_editfriendship', 'editfriendship.php', 'post', true);
        //$field_friend_avatar 		= new XoopsFormLabel(_MD_YOGURT_PHOTO, "<img src=../../uploads/".$friend->getVar('user_avatar')." />");
        if ('blank.gif' == $friend->getVar('user_avatar')) {
            $field_friend_avatar = new XoopsFormLabel(_MD_YOGURT_PHOTO, '<img src=images/noavatar.gif />');
        } else {
            $field_friend_avatar = new XoopsFormLabel(_MD_YOGURT_PHOTO, '<img src=../../uploads/' . $friend->getVar('user_avatar') . ' />');
        }
        $field_friend_name = new XoopsFormLabel(_MD_YOGURT_FRIENDNAME, $friend->getVar('uname'));

        $field_friend_fan = new XoopsFormRadioYN(_MD_YOGURT_FAN, 'fan', $friendship->getVar('fan'), '<img src="images/fans.gif" alt="' . _YES . '" title="' . _YES . '" />', '<img src="images/fansbw.gif" alt="' . _NO . '" title="' . _NO . '" />');

        $field_friend_level = new XoopsFormRadio(_MD_YOGURT_LEVEL, 'level', $friendship->getVar('level'), '<br />');

        $field_friend_level->addOption('1', _MD_YOGURT_UNKNOWNACCEPTED);
        $field_friend_level->addOption('3', _MD_YOGURT_AQUAITANCE);
        $field_friend_level->addOption('5', _MD_YOGURT_FRIEND);
        $field_friend_level->addOption('7', _MD_YOGURT_BESTFRIEND);

        $field_friend_sexy = new XoopsFormRadio(_MD_YOGURT_SEXY, 'hot', $friendship->getVar('hot'));
        $field_friend_sexy->addOption('1', '<img src="images/sexya.gif" alt="' . _MD_YOGURT_SEXYNO . '" title="' . _MD_YOGURT_SEXYNO . '" />');
        $field_friend_sexy->addOption('2', '<img src="images/sexyb.gif" alt="' . _MD_YOGURT_SEXYYES . '" title="' . _MD_YOGURT_SEXYYES . '" />');
        $field_friend_sexy->addOption('3', '<img src="images/sexyc.gif" alt="' . _MD_YOGURT_SEXYALOT . '" title="' . _MD_YOGURT_SEXYALOT . '" />');

        $field_friend_trusty = new XoopsFormRadio(_MD_YOGURT_TRUSTY, 'trust', $friendship->getVar('trust'));
        $field_friend_trusty->addOption('1', '<img src="images/trustya.gif" alt="' . _MD_YOGURT_TRUSTYNO . '" title="' . _MD_YOGURT_TRUSTYNO . '" />');
        $field_friend_trusty->addOption('2', '<img src="images/trustyb.gif" alt="' . _MD_YOGURT_TRUSTYYES . '" title="' . _MD_YOGURT_TRUSTYYES . '" />');
        $field_friend_trusty->addOption('3', '<img src="images/trustyc.gif" alt="' . _MD_YOGURT_TRUSTYALOT . '" title="' . _MD_YOGURT_TRUSTYALOT . '" />');

        $field_friend_cool = new XoopsFormRadio(_MD_YOGURT_COOL, 'cool', $friendship->getVar('cool'));
        $field_friend_cool->addOption('1', '<img src="images/coola.gif" alt="' . _MD_YOGURT_COOLNO . '" title="' . _MD_YOGURT_COOLNO . '" />');
        $field_friend_cool->addOption('2', '<img src="images/coolb.gif" alt="' . _MD_YOGURT_COOLYES . '" title="' . _MD_YOGURT_COOLYES . '" />');
        $field_friend_cool->addOption('3', '<img src="images/coolc.gif" alt="' . _MD_YOGURT_COOLALOT . '" title="' . _MD_YOGURT_COOLALOT . '" />');

        $form->setExtra('enctype="multipart/form-data"');
        $button_send                = new XoopsFormButton('', 'submit_button', _MD_YOGURT_UPDATEFRIEND, 'submit');
        $field_friend_friendid      = new XoopsFormHidden('friend_uid', $friend->getVar('uid'));
        $field_friend_marker        = new XoopsFormHidden('marker', '1');
        $field_friend_friendshio_id = new XoopsFormHidden('friendship_id', $friendship->getVar('friendship_id'));
        $form->addElement($field_friend_friendid);
        $form->addElement($field_friend_friendshio_id);
        $form->addElement($field_friend_marker);
        $form->addElement($field_friend_avatar);
        $form->addElement($field_friend_name);
        $form->addElement($field_friend_level);
        $form->addElement($field_friend_fan);
        $form->addElement($field_friend_sexy);
        $form->addElement($field_friend_trusty);
        $form->addElement($field_friend_cool);

        $form->addElement($button_send);

        $form->display(); //If your server is php 4.4
    }

    /**
     * Get the averages of each evaluation hot trusty etc...
     *
     * @param int $user_uid
     * @return array $vetor with averages
     */

    public function getMoyennes($user_uid)
    {
        global $xoopsUser;

        $vetor               = [];
        $vetor['mediahot']   = 0;
        $vetor['mediatrust'] = 0;
        $vetor['mediacool']  = 0;
        $vetor['sumfan']     = 0;

        //Calculating avg(hot)
        $sql    = 'SELECT friend2_uid, Avg(hot) AS mediahot FROM ' . $this->db->prefix('yogurt_friendship');
        $sql    .= ' WHERE  (hot>0) GROUP BY friend2_uid HAVING (friend2_uid=' . $user_uid . ') ';
        $result = $this->db->query($sql);
        while ($myrow = $this->db->fetchArray($result)) {
            $vetor['mediahot'] = $myrow['mediahot'] * 16;
        }

        //Calculating avg(trust)
        $sql    = 'SELECT friend2_uid, Avg(trust) AS mediatrust FROM ' . $this->db->prefix('yogurt_friendship');
        $sql    .= ' WHERE  (trust>0) GROUP BY friend2_uid HAVING (friend2_uid=' . $user_uid . ') ';
        $result = $this->db->query($sql);
        while ($myrow = $this->db->fetchArray($result)) {
            $vetor['mediatrust'] = $myrow['mediatrust'] * 16;
        }
        //Calculating avg(cool)
        $sql    = 'SELECT friend2_uid, Avg(cool) AS mediacool FROM ' . $this->db->prefix('yogurt_friendship');
        $sql    .= ' WHERE  (cool>0) GROUP BY friend2_uid HAVING (friend2_uid=' . $user_uid . ') ';
        $result = $this->db->query($sql);
        while ($myrow = $this->db->fetchArray($result)) {
            $vetor['mediacool'] = $myrow['mediacool'] * 16;
        }

        //Calculating sum(fans)
        $sql    = 'SELECT friend2_uid, Sum(fan) AS sumfan FROM ' . $this->db->prefix('yogurt_friendship');
        $sql    .= ' GROUP BY friend2_uid HAVING (friend2_uid=' . $user_uid . ') ';
        $result = $this->db->query($sql);
        while ($myrow = $this->db->fetchArray($result)) {
            $vetor['sumfan'] = $myrow['sumfan'];
        }

        return $vetor;
    }
}
