<?php
include_once '../../header.php';
include_once '../../class/pagenav.php';

include_once 'class/yogurt_images.php';
include_once 'class/yogurt_visitors.php';
include_once 'class/yogurt_seutubo.php';
include_once 'class/yogurt_friendpetition.php';
include_once 'class/yogurt_friendship.php';
if(!@ include_once XOOPS_ROOT_PATH.'/language/'.$GLOBALS['xoopsConfig']['language'].'/user.php')
{
	include_once XOOPS_ROOT_PATH.'/language/english/user.php';
}

$album_factory	= new Xoopsyogurt_imagesHandler($xoopsDB);
$visitors_factory = new Xoopsyogurt_visitorsHandler($xoopsDB);
$videos_factory = new Xoopsyogurt_seutuboHandler($xoopsDB);
$friendpetition_factory = new Xoopsyogurt_friendpetitionHandler($xoopsDB);
$friendship_factory = new Xoopsyogurt_friendshipHandler($xoopsDB);

$isOwner=0;
$isanonym =1;
$isfriend =0;

/**
* If anonym and uid not set then redirect to admins profile
* Else redirects to own profile
*/
if(empty($xoopsUser))
{
	$isanonym =1;
	if(isset($_GET['uid'])) {$uid_owner = intval($_GET['uid']);}
	else
	{
		$uid_owner=1;
		$isOwner = 0;
	}
}
else
{
	$isanonym =0;
	if( isset($_GET['uid']))
	{
		$uid_owner = intval($_GET['uid']);
		$isOwner = ($xoopsUser->getVar('uid')==$uid_owner)?1:0;
	}
	else
	{
		$uid_owner = intval($xoopsUser->getVar('uid'));
		$isOwner = 1;
	}
	
}
?>