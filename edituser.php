<?php
// $Id: edituser.php,v 1.1 2007/09/18 03:44:28 marcellobrandao Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include_once '../../mainfile.php';
if(!@ include_once XOOPS_ROOT_PATH.'/language/'.$GLOBALS['xoopsConfig']['language'].'/user.php')
{
	include_once XOOPS_ROOT_PATH.'/language/english/user.php';
}
include_once '../../header.php';
include_once '../../class/pagenav.php';

include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

if(!is_object($xoopsUser)) {redirect_header('index.php',3,_US_NOEDITRIGHT);}

// initialize $op variable
$op = (isset($_GET['op']))?trim(htmlspecialchars($_GET['op'])):((isset($_POST['op']))?trim(htmlspecialchars($_POST['op'])):'editprofile');


$config_handler =& xoops_gethandler('config');
//Fix for XOOPS 2.2 and SX
if (!defined("XOOPS_CONF_USER")) {
  $mod_handler =& xoops_gethandler('module');
  $mod_yogurt  =& $mod_handler->getByDirname('profile');
  if ($mod_yogurt->getVar('isactive')==1) {
     define("XOOPS_CONF_USER",0);
	 $xoopsConfigUser =& $config_handler->getConfigsByCat(0,$mod_yogurt->getVar('mid'));
	 unset($mod_handler);
	 unset($mod_yogurt);
  } else {
    if (defined("SXVERSION")) {
	  define("XOOPS_CONF_USER",1);
	  $xoopsConfigUser =& $config_handler->getConfigsByCat(0,XOOPS_CONF_USER);
	  unset($mod_handler);
	  unset($mod_yogurt);
	} else {
      redirect_header("index.php",3,_TAKINGBACK);
	  exit();
	} 
  }
} else {
  $xoopsConfigUser =& $config_handler->getConfigsByCat(XOOPS_CONF_USER);
}
$myts =& MyTextSanitizer::getInstance();

if($op == 'saveuser')
{
	if(!$GLOBALS['xoopsSecurity']->check()) {redirect_header('index.php',3,_US_NOEDITRIGHT.'<br />'.implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));}
	$uid = 0;
	if(!empty($_POST['uid'])) {$uid = intval($_POST['uid']);}
	if(empty($uid) || $xoopsUser->getVar('uid') != $uid) {redirect_header('index.php',3,_US_NOEDITRIGHT);}
	$errors = array();
	if($xoopsConfigUser['allow_chgmail'] == 1)
	{
		$email = '';
		if(!empty($_POST['email'])) {$email = $myts->stripSlashesGPC(trim($_POST['email']));}
		if($email == '' || !checkEmail($email)) {$errors[] = _US_INVALIDMAIL;}
	}
	$password = '';
	if(!empty($_POST['password'])) {$password = $myts->stripSlashesGPC(trim($_POST['password']));}
	if($password != '')
	{
		if(strlen($password) < $xoopsConfigUser['minpass']) {$errors[] = sprintf(_US_PWDTOOSHORT,$xoopsConfigUser['minpass']);}
		$vpass = '';
		if(!empty($_POST['vpass'])) {$vpass = $myts->stripSlashesGPC(trim($_POST['vpass']));}
		if($password != $vpass) {$errors[] = _US_PASSNOTSAME;}
	}
	if(count($errors) > 0)
	{
		include XOOPS_ROOT_PATH.'/header.php';
		echo '<div>';
		foreach($errors as $er) {echo '<span style="color: #ff0000; font-weight: bold;">'.$er.'</span><br />';}
		echo '</div><br />';
		$op = 'editprofile';
	}
	else
	{
		$member_handler =& xoops_gethandler('member');
		$edituser =& $member_handler->getUser($uid);
		$edituser->setVar('name', $_POST['name']);
		if($xoopsConfigUser['allow_chgmail'] == 1) {$edituser->setVar('email', $email, true);}
		$edituser->setVar('url', formatURL($_POST['url']));
		$edituser->setVar('user_icq', $_POST['user_icq']);
		$edituser->setVar('user_from', $_POST['user_from']);
		$edituser->setVar('user_sig', xoops_substr($_POST['user_sig'], 0, 255));
		$user_viewemail = (!empty($_POST['user_viewemail'])) ? 1 : 0;
		$edituser->setVar('user_viewemail', $user_viewemail);
		if(defined('ICMS_VERSION_NAME'))
		{
			$edituser->setVar('openid', isset($_POST['openid']) ? trim($_POST['openid']) : '');		
			$user_viewoid = (!empty($_POST['user_viewoid'])) ? 1 : 0;
			$edituser->setVar('user_viewoid', $user_viewoid);
		}
        	$edituser->setVar('user_viewoid', $user_viewoid);
		$edituser->setVar('user_aim', $_POST['user_aim']);
		$edituser->setVar('user_yim', $_POST['user_yim']);
		$edituser->setVar('user_msnm', $_POST['user_msnm']);
		if($password != '')
		{
			if(defined('ICMS_VERSION_NAME'))
			{
				$salt = icms_createSalt();
				$edituser->setVar('salt', $salt, true);
				$edituser->setVar('enc_type', $xoopsConfigUser['enc_type'], true);
				$pass = icms_encryptPass($password, $salt);
            		$edituser->setVar('pass', $pass, true);
				$edituser->setVar('pass_expired', 0);
			}
			else {$edituser->setVar('pass', md5($password), true);}
		}
		$attachsig = !empty($_POST['attachsig']) ? 1 : 0;
		$edituser->setVar('attachsig', $attachsig);
		$edituser->setVar('timezone_offset', $_POST['timezone_offset']);
		$edituser->setVar('uorder', $_POST['uorder']);
		$edituser->setVar('umode', $_POST['umode']);
		$edituser->setVar('notify_method', $_POST['notify_method']);
		$edituser->setVar('notify_mode', $_POST['notify_mode']);
		$edituser->setVar('bio', xoops_substr($_POST['bio'], 0, 255));
		$edituser->setVar('user_occ', $_POST['user_occ']);
		$edituser->setVar('user_intrest', $_POST['user_intrest']);
		$edituser->setVar('user_mailok', $_POST['user_mailok']);
		if(!empty($_POST['usecookie'])) {setcookie($xoopsConfig['usercookie'], $xoopsUser->getVar('uname'), time()+ 31536000);}
		else {setcookie($xoopsConfig['usercookie']);}
		if(!$member_handler->insertUser($edituser))
		{
			include XOOPS_ROOT_PATH.'/header.php';
			echo $edituser->getHtmlErrors();
			include XOOPS_ROOT_PATH.'/footer.php';
		}
		else {redirect_header('index.php?uid='.intval($uid), 1, _US_PROFUPDATED);}
		exit();
	}
}

if ($op == 'editprofile')
{
	include_once XOOPS_ROOT_PATH.'/header.php';
	include_once XOOPS_ROOT_PATH.'/include/comment_constants.php';
	$uid = intval($xoopsUser->getVar('uid'));
	echo '<a href="index.php?uid='.$uid.'">'._US_PROFILE.'</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;'._US_EDITPROFILE.'<br /><br />';
	$form = new XoopsThemeForm(_US_EDITPROFILE, 'userinfo', 'edituser.php', 'post', true);
	$uname_label = new XoopsFormLabel(_US_NICKNAME, $xoopsUser->getVar('uname'));
	$form->addElement($uname_label);
	$name_text = new XoopsFormText(_US_REALNAME, 'name', 30, 60, $xoopsUser->getVar('name', 'E'));
	$form->addElement($name_text);
	$email_tray = new XoopsFormElementTray(_US_EMAIL, '<br />');
	if($xoopsConfigUser['allow_chgmail'] == 1) {$email_text = new XoopsFormText('', 'email', 30, 60, $xoopsUser->getVar('email'));}
	else {$email_text = new XoopsFormLabel('', $xoopsUser->getVar('email'));}
	$email_tray->addElement($email_text);
	$email_cbox_value = $xoopsUser->user_viewemail() ? 1 : 0;
	$email_cbox = new XoopsFormCheckBox('', 'user_viewemail', $email_cbox_value);
	$email_cbox->addOption(1, _US_ALLOWVIEWEMAIL);
	$email_tray->addElement($email_cbox);
	if(defined('ICMS_VERSION_NAME'))
	{
		$config_handler =& xoops_gethandler('config');
   		$icmsauthConfig =& $config_handler->getConfigsByCat(XOOPS_CONF_AUTH);
     	if($icmsauthConfig['auth_openid'] == 1)
		{
			$openid_tray = new XoopsFormElementTray(_US_OPENID_FORM_CAPTION, '<br />');
			$openid_text = new XoopsFormText('', 'openid', 30, 255, $xoopsUser->getVar('openid'));
			$openid_tray->setDescription(_US_OPENID_FORM_DSC);
			$openid_tray->addElement($openid_text);
			$openid_cbox_value = $xoopsUser->user_viewoid() ? 1 : 0;
			$openid_cbox = new XoopsFormCheckBox('', 'user_viewoid', $openid_cbox_value);
			$openid_cbox->addOption(1, _US_ALLOWVIEWEMAILOPENID);
			$openid_tray->addElement($openid_cbox);
			$form->addElement($openid_tray);
		}
	}
	$form->addElement($email_tray);
	$url_text = new XoopsFormText(_US_WEBSITE, 'url', 30, 100, $xoopsUser->getVar('url', 'E'));
	$form->addElement($url_text);
	
	$timezone_select = new XoopsFormSelectTimezone(_US_TIMEZONE, 'timezone_offset', $xoopsUser->getVar('timezone_offset'));
	$icq_text = new XoopsFormText(_US_ICQ, 'user_icq', 15, 15, $xoopsUser->getVar('user_icq', 'E'));
	$aim_text = new XoopsFormText(_US_AIM, 'user_aim', 18, 18, $xoopsUser->getVar('user_aim', 'E'));
	$yim_text = new XoopsFormText(_US_YIM, 'user_yim', 25, 25, $xoopsUser->getVar('user_yim', 'E'));
	$msnm_text = new XoopsFormText(_US_MSNM, 'user_msnm', 30, 100, $xoopsUser->getVar('user_msnm', 'E'));
	$location_text = new XoopsFormText(_US_LOCATION, 'user_from', 30, 100, $xoopsUser->getVar('user_from', 'E'));
	$occupation_text = new XoopsFormText(_US_OCCUPATION, 'user_occ', 30, 100, $xoopsUser->getVar('user_occ', 'E'));
	$interest_text = new XoopsFormText(_US_INTEREST, 'user_intrest', 30, 150, $xoopsUser->getVar('user_intrest', 'E'));
	$sig_tray = new XoopsFormElementTray(_US_SIGNATURE, '<br />');
	include_once XOOPS_ROOT_PATH.'/include/xoopscodes.php';
	$sig_tarea = new XoopsFormDhtmlTextArea('', 'user_sig', $xoopsUser->getVar('user_sig', 'E'));
	$sig_tray->addElement($sig_tarea);
	$sig_cbox_value = $xoopsUser->getVar('attachsig') ? 1 : 0;
	$sig_cbox = new XoopsFormCheckBox('', 'attachsig', $sig_cbox_value);
	$sig_cbox->addOption(1, _US_SHOWSIG);
	$sig_tray->addElement($sig_cbox);
	$umode_select = new XoopsFormSelect(_US_CDISPLAYMODE, 'umode', $xoopsUser->getVar('umode'));
	$umode_select->addOptionArray(array('nest'=>_NESTED, 'flat'=>_FLAT, 'thread'=>_THREADED));
	$uorder_select = new XoopsFormSelect(_US_CSORTORDER, 'uorder', $xoopsUser->getVar('uorder'));
	$uorder_select->addOptionArray(array(XOOPS_COMMENT_OLD1ST => _OLDESTFIRST, XOOPS_COMMENT_NEW1ST => _NEWESTFIRST));
	// RMV-NOTIFY
	// TODO: add this to admin user-edit functions...
	include_once XOOPS_ROOT_PATH . "/language/" . $xoopsConfig['language'] . '/notification.php';
	include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
	$notify_method_select = new XoopsFormSelect(_NOT_NOTIFYMETHOD, 'notify_method', $xoopsUser->getVar('notify_method'));
	$notify_method_select->addOptionArray(array(XOOPS_NOTIFICATION_METHOD_DISABLE=>_NOT_METHOD_DISABLE, XOOPS_NOTIFICATION_METHOD_PM=>_NOT_METHOD_PM, XOOPS_NOTIFICATION_METHOD_EMAIL=>_NOT_METHOD_EMAIL));
	$notify_mode_select = new XoopsFormSelect(_NOT_NOTIFYMODE, 'notify_mode', $xoopsUser->getVar('notify_mode'));
	$notify_mode_select->addOptionArray(array(XOOPS_NOTIFICATION_MODE_SENDALWAYS=>_NOT_MODE_SENDALWAYS, XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE=>_NOT_MODE_SENDONCE, XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT=>_NOT_MODE_SENDONCEPERLOGIN));
	$bio_tarea = new XoopsFormTextArea(_US_EXTRAINFO, 'bio', $xoopsUser->getVar('bio', 'E'));
	$cookie_radio_value = empty($_COOKIE[$xoopsConfig['usercookie']]) ? 0 : 1;
	$cookie_radio = new XoopsFormRadioYN(_US_USECOOKIE, 'usecookie', $cookie_radio_value, _YES, _NO);
	$pwd_text = new XoopsFormPassword('', 'password', 10, 255);
	$pwd_text2 = new XoopsFormPassword('', 'vpass', 10, 255);
	$pwd_tray = new XoopsFormElementTray(_US_PASSWORD.'<br />'._US_TYPEPASSTWICE);
	$pwd_tray->addElement($pwd_text);
	$pwd_tray->addElement($pwd_text2);
	$mailok_radio = new XoopsFormRadioYN(_US_MAILOK, 'user_mailok', $xoopsUser->getVar('user_mailok'));
	if(defined('ICMS_VERSION_NAME'))
	{
		$salt_hidden = new XoopsFormHidden('salt', $xoopsUser->getVar('salt'));
	}
	$uid_hidden = new XoopsFormHidden('uid', $uid);
	$op_hidden = new XoopsFormHidden('op', 'saveuser');
	$submit_button = new XoopsFormButton('', 'submit', _US_SAVECHANGES, 'submit');
	
	$form->addElement($timezone_select);
	$form->addElement($icq_text);
	$form->addElement($aim_text);
	$form->addElement($yim_text);
	$form->addElement($msnm_text);
	$form->addElement($location_text);
	$form->addElement($occupation_text);
	$form->addElement($interest_text);
	$form->addElement($sig_tray);
	$form->addElement($umode_select);
	$form->addElement($uorder_select);
	$form->addElement($notify_method_select);
	$form->addElement($notify_mode_select);
	$form->addElement($bio_tarea);
	$form->addElement($pwd_tray);
	$form->addElement($cookie_radio);
	$form->addElement($mailok_radio);
	if(defined('ICMS_VERSION_NAME'))
	{
		$form->addElement($salt_hidden);
	}
	$form->addElement($uid_hidden);
	$form->addElement($op_hidden);
	$form->addElement($token_hidden);
	$form->addElement($submit_button);
	if($xoopsConfigUser['allow_chgmail'] == 1) {$form->setRequired($email_text);}
	$form->display();
	include XOOPS_ROOT_PATH.'/footer.php';
}


if($op == 'avatarform')
{
	include XOOPS_ROOT_PATH.'/header.php';
	$uid = intval($xoopsUser->getVar('uid'));
	echo '<a href="index.php?uid='.$uid.'">'._US_PROFILE.'</a>&nbsp;<span style="font-weight:bold;">&raquo;&raquo;</span>&nbsp;'._US_UPLOADMYAVATAR.'<br /><br />';
	$oldavatar = $xoopsUser->getVar('user_avatar');
	if(!empty($oldavatar) && $oldavatar != 'blank.gif')
	{
		echo '<div style="text-align:center;"><h4 style="color:#ff0000; font-weight:bold;">'._US_OLDDELETED.'</h4>';
		echo '<img src="'.XOOPS_UPLOAD_URL.'/'.$oldavatar.'" alt="" /></div>';
	}
	if($xoopsConfigUser['avatar_allow_upload'] == 1 && $xoopsUser->getVar('posts') >= $xoopsConfigUser['avatar_minposts'])
	{
		include_once 'class/xoopsformloader.php';
		$form = new XoopsThemeForm(_US_UPLOADMYAVATAR, 'uploadavatar', 'edituser.php', 'post', true);
		$form->setExtra('enctype="multipart/form-data"');
		$form->addElement(new XoopsFormLabel(_US_MAXPIXEL, $xoopsConfigUser['avatar_width'].' x '.$xoopsConfigUser['avatar_height']));
		$form->addElement(new XoopsFormLabel(_US_MAXIMGSZ, $xoopsConfigUser['avatar_maxsize']));
		$form->addElement(new XoopsFormFile(_US_SELFILE, 'avatarfile', $xoopsConfigUser['avatar_maxsize']), true);
		$form->addElement(new XoopsFormHidden('op', 'avatarupload'));
		$form->addElement(new XoopsFormHidden('uid', $uid));
		$form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
		$form->display();
	}
	$avatar_handler =& xoops_gethandler('avatar');
	$form2 = new XoopsThemeForm(_US_CHOOSEAVT, 'uploadavatar', 'edituser.php', 'post', true);
	$avatar_select = new XoopsFormSelect('', 'user_avatar', $xoopsUser->getVar('user_avatar'));
	$avatar_select->addOptionArray($avatar_handler->getList('S'));
	$avatar_select->setExtra("onchange='showImgSelected(\"avatar\", \"user_avatar\", \"uploads\", \"\", \"".XOOPS_URL."\")'");
	$avatar_tray = new XoopsFormElementTray(_US_AVATAR, '&nbsp;');
	$avatar_tray->addElement($avatar_select);
	$avatar_tray->addElement(new XoopsFormLabel('', "<img src='".XOOPS_UPLOAD_URL."/".$xoopsUser->getVar("user_avatar", "E")."' name='avatar' id='avatar' alt='' /> <a href=\"javascript:openWithSelfMain('".XOOPS_URL."/misc.php?action=showpopups&amp;type=avatars','avatars',600,400);\">"._LIST."</a>"));
	$form2->addElement($avatar_tray);
	$form2->addElement(new XoopsFormHidden('uid', $uid));
	$form2->addElement(new XoopsFormHidden('op', 'avatarchoose'));
	$form2->addElement(new XoopsFormButton('', 'submit2', _SUBMIT, 'submit'));
	$form2->display();
	include XOOPS_ROOT_PATH.'/footer.php';
}

if($op == 'avatarupload')
{
	if(!$GLOBALS['xoopsSecurity']->check()) {redirect_header('index.php',3,_US_NOEDITRIGHT.'<br />'.implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));}
	$xoops_upload_file = array();
	$uid = 0;
	if(!empty($_POST['xoops_upload_file']) && is_array($_POST['xoops_upload_file'])) {$xoops_upload_file = $_POST['xoops_upload_file'];}
	if(!empty($_POST['uid'])) {$uid = intval($_POST['uid']);}
	if(empty($uid) || $xoopsUser->getVar('uid') != $uid) {redirect_header('index.php',3,_US_NOEDITRIGHT);}
	if($xoopsConfigUser['avatar_allow_upload'] == 1 && $xoopsUser->getVar('posts') >= $xoopsConfigUser['avatar_minposts'])
	{
		include_once XOOPS_ROOT_PATH.'/class/uploader.php';
		$uploader = new XoopsMediaUploader(XOOPS_UPLOAD_PATH, array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'), $xoopsConfigUser['avatar_maxsize'], $xoopsConfigUser['avatar_width'], $xoopsConfigUser['avatar_height']);
		if($uploader->fetchMedia($_POST['xoops_upload_file'][0]))
		{
			$uploader->setPrefix('cavt');
			if($uploader->upload())
			{
				$avt_handler =& xoops_gethandler('avatar');
				$avatar =& $avt_handler->create();
				$avatar->setVar('avatar_file', $uploader->getSavedFileName());
				$avatar->setVar('avatar_name', $xoopsUser->getVar('uname'));
				$avatar->setVar('avatar_mimetype', $uploader->getMediaType());
				$avatar->setVar('avatar_display', 1);
				$avatar->setVar('avatar_type', 'C');
				if(!$avt_handler->insert($avatar)) {@unlink($uploader->getSavedDestination());}
				else
				{
					$oldavatar = $xoopsUser->getVar('user_avatar');
					if(!empty($oldavatar) && preg_match("/^cavt/", strtolower($oldavatar)))
					{
						$avatars =& $avt_handler->getObjects(new Criteria('avatar_file', $oldavatar));
						if(!empty($avatars) && count($avatars) == 1 && is_object($avatars[0]))
						{
							$avt_handler->delete($avatars[0]);
							$oldavatar_path = str_replace('\\', '/', realpath(XOOPS_UPLOAD_PATH.'/'.$oldavatar));
							if(0 === strpos($oldavatar_path, XOOPS_UPLOAD_PATH) && is_file($oldavatar_path)) {unlink($oldavatar_path);}
						}
					}
					$sql = sprintf("UPDATE %s SET user_avatar = %s WHERE uid = '%u'", $xoopsDB->prefix('users'), $xoopsDB->quoteString($uploader->getSavedFileName()), $uid);
					$xoopsDB->query($sql);
					$avt_handler->addUser($avatar->getVar('avatar_id'), $uid);
					redirect_header('index.php?t='.time().'&amp;uid='.$uid,2, _US_PROFUPDATED);
				}
			}
		}
		include XOOPS_ROOT_PATH.'/header.php';
		echo $uploader->getErrors();
		include XOOPS_ROOT_PATH.'/footer.php';
	}
}

if($op == 'avatarchoose')
{
	if(!$GLOBALS['xoopsSecurity']->check()) {redirect_header('index.php',3,_US_NOEDITRIGHT.'<br />'.implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));}
	$uid = 0;
	if(!empty($_POST['uid'])) {$uid = intval($_POST['uid']);}
	if(empty($uid) || $xoopsUser->getVar('uid') != $uid ) {redirect_header('index.php', 3, _US_NOEDITRIGHT);}
	$user_avatar = '';
	$avt_handler =& xoops_gethandler('avatar');
	if(!empty($_POST['user_avatar']))
	{
		$user_avatar = $myts->addSlashes(trim($_POST['user_avatar']));
		$criteria_avatar = new CriteriaCompo(new Criteria('avatar_file', $user_avatar));
		$criteria_avatar->add(new Criteria('avatar_type', 'S'));
		$avatars =& $avt_handler->getObjects($criteria_avatar);
		if(!is_array($avatars) || !count($avatars)) {$user_avatar = 'blank.gif';}
		unset($avatars, $criteria_avatar);
	}
	$user_avatarpath = str_replace('\\', '/', realpath(XOOPS_UPLOAD_PATH.'/'.$user_avatar));
	if(0 === strpos($user_avatarpath, XOOPS_UPLOAD_PATH) && is_file($user_avatarpath))
	{
		$oldavatar = $xoopsUser->getVar('user_avatar');
		$xoopsUser->setVar('user_avatar', $user_avatar);
		$member_handler =& xoops_gethandler('member');
		if(!$member_handler->insertUser($xoopsUser))
		{
			include XOOPS_ROOT_PATH.'/header.php';
			echo $xoopsUser->getHtmlErrors();
			include XOOPS_ROOT_PATH.'/footer.php';
			exit();
		}
		if($oldavatar && preg_match('/^cavt/', strtolower($oldavatar)))
		{
			$avatars =& $avt_handler->getObjects(new Criteria('avatar_file', $oldavatar));
			if(!empty($avatars) && count($avatars) == 1 && is_object($avatars[0]))
			{
				$avt_handler->delete($avatars[0]);
				$oldavatar_path = str_replace('\\', '/', realpath(XOOPS_UPLOAD_PATH.'/'.$oldavatar));
				if(0 === strpos($oldavatar_path, XOOPS_UPLOAD_PATH) && is_file($oldavatar_path)) {unlink($oldavatar_path);}
			}
		}
		if($user_avatar != 'blank.gif')
		{
			$avatars =& $avt_handler->getObjects(new Criteria('avatar_file', $user_avatar));
			if(is_object($avatars[0])) {$avt_handler->addUser($avatars[0]->getVar('avatar_id'), $uid);}
		}
	}
	redirect_header('index.php?uid='.$uid, 0, _US_PROFUPDATED);
}
?>