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
 * @author          Bruno Barthez, Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

use Criteria;
use CriteriaCompo;
use CriteriaElement;
use XoopsDatabase;
use XoopsFormButton;
use XoopsFormHidden;
use XoopsFormLabel;
use XoopsFormRadio;
use XoopsFormRadioYN;
use XoopsObject;
use XoopsPersistableObjectHandler;
use XoopsThemeForm;

require_once XOOPS_ROOT_PATH . '/kernel/object.php';
/**
 * Includes of form objects and uploader
 */
require_once XOOPS_ROOT_PATH . '/class/uploader.php';
require_once XOOPS_ROOT_PATH . '/kernel/object.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/kernel/object.php';

/**
 * suico_friendshiphandler class.
 * This class provides simple mechanism for Friendship object
 */
class FriendshipHandler extends XoopsPersistableObjectHandler
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
        /** @var \XoopsModules\Suico\Helper $this- >helper */
        if (null === $helper) {
            $this->helper = Helper::getInstance();
        } else {
            $this->helper = $helper;
        }
        $isAdmin = $this->helper->isUserAdmin();
        parent::__construct($xoopsDatabase, 'suico_friendships', Friendship::class, 'friendship_id', 'friendship_id');
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
     * retrieve a Friendship
     *
     * @param int|null $id of the Friendship
     * @param null     $fields
     * @return mixed reference to the {@link Friendship} object, FALSE if failed
     */
    public function get2(
        $id = null,
        $fields = null
    ) {
        $sql = 'SELECT * FROM ' . $this->db->prefix('suico_friendships') . ' WHERE friendship_id=' . $id;
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        $numrows = $this->db->getRowsNum($result);
        if (1 === $numrows) {
            $suico_friendship = new Friendship();
            $suico_friendship->assignVars($this->db->fetchArray($result));
            return $suico_friendship;
        }
        return false;
    }

    /**
     * insert a new Friendship in the database
     *
     * @param \XoopsObject $xoopsObject       reference to the {@link Friendship}
     *                                        object
     * @param bool         $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert2(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        global $xoopsConfig;
        if (!$xoopsObject instanceof Friendship) {
            return false;
        }
        if (!$xoopsObject->isDirty()) {
            return true;
        }
        if (!$xoopsObject->cleanVars()) {
            return false;
        }
        $friendship_id = $friend1_uid = $friend2_uid = $level = $hot = $trust = $cool = $fan = '';
        foreach ($xoopsObject->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        //        $now = 'date_add(now(), interval ' . $xoopsConfig['server_TZ'] . ' hour)';
        if ($xoopsObject->isNew()) {
            // ajout/modification d'un Friendship
            $xoopsObject = new Friendship();
            $format      = 'INSERT INTO %s (friendship_id, friend1_uid, friend2_uid, LEVEL, hot, trust, cool, fan)';
            $format      .= 'VALUES (%u, %u, %u, %u, %u, %u, %u, %u)';
            $sql         = \sprintf(
                $format,
                $this->db->prefix('suico_friendships'),
                $friendship_id,
                $friend1_uid,
                $friend2_uid,
                $level,
                $hot,
                $trust,
                $cool,
                $fan
            );
            $force       = true;
        } else {
            $format = 'UPDATE %s SET ';
            $format .= 'friendship_id=%u, friend1_uid=%u, friend2_uid=%u, level=%u, hot=%u, trust=%u, cool=%u, fan=%u';
            $format .= ' WHERE friendship_id = %u';
            $sql    = \sprintf(
                $format,
                $this->db->prefix('suico_friendships'),
                $friendship_id,
                $friend1_uid,
                $friend2_uid,
                $level,
                $hot,
                $trust,
                $cool,
                $fan,
                $friendship_id
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
        if (empty($friendship_id)) {
            $friendship_id = $this->db->getInsertId();
        }
        $xoopsObject->assignVar('friendship_id', $friendship_id);
        return true;
    }

    /**
     * delete a Friendship from the database
     *
     * @param \XoopsObject $xoopsObject reference to the Friendship to delete
     * @param bool         $force
     * @return bool FALSE if failed.
     */
    public function delete(
        XoopsObject $xoopsObject,
        $force = false
    ) {
        if (!$xoopsObject instanceof Friendship) {
            return false;
        }
        $sql = \sprintf(
            'DELETE FROM %s WHERE friendship_id = %u',
            $this->db->prefix('suico_friendships'),
            $xoopsObject->getVar('friendship_id')
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
     * retrieve suico_friendships from the database
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} conditions to be met
     * @param bool                                 $id_as_key       use the UID as key for the array?
     * @param bool                                 $as_object
     * @return array array of {@link Friendship} objects
     */
    public function &getObjects(
        ?CriteriaElement $criteriaElement = null,
        $id_as_key = false,
        $as_object = true
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('suico_friendships');
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
            $suico_friendship = new Friendship();
            $suico_friendship->assignVars($myrow);
            if ($id_as_key) {
                $ret[$myrow['friendship_id']] = &$suico_friendship;
            } else {
                $ret[] = &$suico_friendship;
            }
            unset($suico_friendship);
        }
        return $ret;
    }

    /**
     * count suico_friendships matching a condition
     *
     * @param \CriteriaElement|\CriteriaCompo|null $criteriaElement {@link \CriteriaElement} to match
     * @return int count of suico_friendships
     */
    public function getCount(
        ?CriteriaElement $criteriaElement = null
    ) {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('suico_friendships');
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
     * delete suico_friendships matching a set of conditions
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
        $sql = 'DELETE FROM ' . $this->db->prefix('suico_friendships');
        if (isset($criteriaElement) && $criteriaElement instanceof CriteriaElement) {
            $sql .= ' ' . $criteriaElement->renderWhere();
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * @param int  $countFriends
     * @param null $criteria
     * @param int  $shuffle
     * @return array
     */
    public function getFriends(
        $countFriends,
        $criteria = null,
        $shuffle = 1
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT uname, user_avatar, friend2_uid FROM ' . $this->db->prefix(
                'suico_friendships'
            ) . ', ' . $this->db->prefix(
                'users'
            );
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = friend2_uid ';
            if ('' !== $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit  = $criteria->getLimit();
            $start  = $criteria->getStart();
            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;
            while (false !== ($myrow = $this->db->fetchArray($result))) {
                $vetor[$i]['uid']         = $myrow['friend2_uid'];
                $vetor[$i]['uname']       = $myrow['uname'];
                $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
                $i++;
            }
            if (1 === $shuffle) {
                \shuffle($vetor);
                $vetor = \array_slice($vetor, 0, (int)$countFriends);
            }
            return $vetor;
        }
    }

    /**
     * @param      $countFriends
     * @param null $criteria
     * @param int  $shuffle
     * @return array
     */
    public function getFans(
        $countFriends,
        $criteria = null,
        $shuffle = 1
    ) {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT uname, user_avatar, friend1_uid FROM ' . $this->db->prefix(
                'suico_friendships'
            ) . ', ' . $this->db->prefix(
                'users'
            );
        if (isset($criteria) && $criteria instanceof CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
            //attention here this is kind of a hack
            $sql .= ' AND uid = friend1_uid ';
            if ('' !== $criteria->getSort()) {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit  = $criteria->getLimit();
            $start  = $criteria->getStart();
            $result = $this->db->query($sql, $limit, $start);
            $vetor  = [];
            $i      = 0;
            while (false !== ($myrow = $this->db->fetchArray($result))) {
                $vetor[$i]['uid']         = $myrow['friend1_uid'];
                $vetor[$i]['uname']       = $myrow['uname'];
                $vetor[$i]['user_avatar'] = $myrow['user_avatar'];
                $i++;
            }
            if (1 === $shuffle) {
                \shuffle($vetor);
                $vetor = \array_slice($vetor, 0, $countFriends);
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
        $criteria_friend1    = new Criteria(
            'friend1_uid', $xoopsUser->getVar(
            'uid'
        )
        );
        $field_friend_fan    = $field_friend_friendly = $field_friend_funny = $field_friend_cool = '';
        $criteria_friend2    = new Criteria('friend2_uid', $friend->getVar('uid'));
        $criteria_friendship = new CriteriaCompo($criteria_friend1);
        $criteria_friendship->add($criteria_friend2);
        $friendships = $this->getObjects($criteria_friendship);
        $friendship  = $friendships[0];
        $form        = new XoopsThemeForm(
            \_MD_SUICO_EDIT_FRIENDSHIP, 'form_editfriendship', 'editfriendship.php', 'post', true
        );
        //$field_friend_avatar      = new XoopsFormLabel(_MD_SUICO_PHOTO, "<img src=../../uploads/".$friend->getVar('user_avatar').">");
        if ('avatars/blank.gif' === $friend->getVar(
                'user_avatar'
            )) {
            $field_friend_avatar = new XoopsFormLabel(\_MD_SUICO_PHOTO, '<img src=assets/images/noavatar.gif>');
        } else {
            $field_friend_avatar = new XoopsFormLabel(
                \_MD_SUICO_PHOTO, '<img src=../../uploads/' . $friend->getVar(
                                    'user_avatar'
                                ) . '>'
            );
        }
        $field_friend_name = new XoopsFormLabel(\_MD_SUICO_FRIENDNAME, $friend->getVar('uname'));
        if (1 === $this->helper->getConfig('allow_friendshiplevel')) {
            $field_friend_level = new XoopsFormRadio(\_MD_SUICO_LEVEL, 'level', $friendship->getVar('level'), '<br>');
            $field_friend_level->addOption('1', \_MD_SUICO_UNKNOWN_ACCEPTED);
            $field_friend_level->addOption('3', \_MD_SUICO_AQUAITANCE);
            $field_friend_level->addOption('5', \_MD_SUICO_FRIEND);
            $field_friend_level->addOption('7', \_MD_SUICO_BESTFRIEND);
        }
        if (1 === $this->helper->getConfig('allow_fanssevaluation')) {
            $field_friend_fan      = new XoopsFormRadioYN(
                \_MD_SUICO_FAN, 'fan', $friendship->getVar(
                'fan'
            ), '<img src="assets/images/fans.gif" alt="' . \_YES . '" title="' . \_YES . '">', '<img src="assets/images/fansbw.gif" alt="' . \_NO . '" title="' . \_NO . '">'
            );
            $field_friend_friendly = new XoopsFormRadio(\_MD_SUICO_FRIENDLY, 'hot', $friendship->getVar('hot'));
            $field_friend_friendly->addOption(
                '1',
                '<img src="assets/images/friendlya.gif" alt="' . \_MD_SUICO_FRIENDLYNO . '" title="' . \_MD_SUICO_FRIENDLYNO . '">'
            );
            $field_friend_friendly->addOption(
                '2',
                '<img src="assets/images/friendlyb.gif" alt="' . \_MD_SUICO_FRIENDLYYES . '" title="' . \_MD_SUICO_FRIENDLYYES . '">'
            );
            $field_friend_friendly->addOption(
                '3',
                '<img src="assets/images/friendlyc.gif" alt="' . \_MD_SUICO_FRIENDLYALOT . '" title="' . \_MD_SUICO_FRIENDLYALOT . '">'
            );
            $field_friend_funny = new XoopsFormRadio(\_MD_SUICO_FUNNY, 'trust', $friendship->getVar('trust'));
            $field_friend_funny->addOption(
                '1',
                '<img src="assets/images/funnya.gif" alt="' . \_MD_SUICO_FUNNYNO . '" title="' . \_MD_SUICO_FUNNYNO . '">'
            );
            $field_friend_funny->addOption(
                '2',
                '<img src="assets/images/funnyb.gif" alt="' . \_MD_SUICO_FUNNYYES . '" title="' . \_MD_SUICO_FUNNYYES . '">'
            );
            $field_friend_funny->addOption(
                '3',
                '<img src="assets/images/funnyc.gif" alt="' . \_MD_SUICO_FUNNYALOT . '" title="' . \_MD_SUICO_FUNNYALOT . '">'
            );
            $field_friend_cool = new XoopsFormRadio(\_MD_SUICO_COOL, 'cool', $friendship->getVar('cool'));
            $field_friend_cool->addOption(
                '1',
                '<img src="assets/images/coola.gif" alt="' . \_MD_SUICO_COOLNO . '" title="' . \_MD_SUICO_COOLNO . '">'
            );
            $field_friend_cool->addOption(
                '2',
                '<img src="assets/images/coolb.gif" alt="' . \_MD_SUICO_COOLYES . '" title="' . \_MD_SUICO_COOLYES . '">'
            );
            $field_friend_cool->addOption(
                '3',
                '<img src="assets/images/coolc.gif" alt="' . \_MD_SUICO_COOLALOT . '" title="' . \_MD_SUICO_COOLALOT . '">'
            );
        }
        $form->setExtra('enctype="multipart/form-data"');
        $buttonSend                 = new XoopsFormButton('', 'submit_button', \_MD_SUICO_UPDATEFRIEND, 'submit');
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
        $form->addElement($field_friend_friendly);
        $form->addElement($field_friend_funny);
        $form->addElement($field_friend_cool);
        $form->addElement($buttonSend);
        $form->display();
    }

    /**
     * Get the averages of each evaluation hot funny etc...
     *
     * @param int $user_uid
     * @return array with averages
     */
    public function getMoyennes(
        $user_uid
    ) {
        global $xoopsUser;
        $vetor               = [];
        $vetor['mediahot']   = 0;
        $vetor['mediatrust'] = 0;
        $vetor['mediacool']  = 0;
        $vetor['sumfan']     = 0;
        //Calculating avg(hot)
        $sql    = 'SELECT friend2_uid, Avg(hot) AS mediahot FROM ' . $this->db->prefix(
                'suico_friendships'
            );
        $sql    .= ' WHERE  (hot>0) GROUP BY friend2_uid HAVING (friend2_uid=' . $user_uid . ') ';
        $result = $this->db->query($sql);
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $vetor['mediahot'] = $myrow['mediahot'] * 16;
        }
        //Calculating avg(trust)
        $sql    = 'SELECT friend2_uid, Avg(trust) AS mediatrust FROM ' . $this->db->prefix(
                'suico_friendships'
            );
        $sql    .= ' WHERE  (trust>0) GROUP BY friend2_uid HAVING (friend2_uid=' . $user_uid . ') ';
        $result = $this->db->query($sql);
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $vetor['mediatrust'] = $myrow['mediatrust'] * 16;
        }
        //Calculating avg(cool)
        $sql    = 'SELECT friend2_uid, Avg(cool) AS mediacool FROM ' . $this->db->prefix(
                'suico_friendships'
            );
        $sql    .= ' WHERE  (cool>0) GROUP BY friend2_uid HAVING (friend2_uid=' . $user_uid . ') ';
        $result = $this->db->query($sql);
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $vetor['mediacool'] = $myrow['mediacool'] * 16;
        }
        //Calculating sum(fans)
        $sql    = 'SELECT friend2_uid, Sum(fan) AS sumfan FROM ' . $this->db->prefix(
                'suico_friendships'
            );
        $sql    .= ' GROUP BY friend2_uid HAVING (friend2_uid=' . $user_uid . ') ';
        $result = $this->db->query($sql);
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $vetor['sumfan'] = $myrow['sumfan'];
        }
        return $vetor;
    }
}
