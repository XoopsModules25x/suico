<?php

declare(strict_types=1);
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
//Present in many files (videos pictures etc...)
define('_MD_SUICO_DELETE', 'Delete');
define('_MD_SUICO_EDIT_VIDEO', 'Edit Video');
define('_MD_SUICO_TOKENEXPIRED', 'Your Security Token has Expired<br>Please Try Again');
define('_MD_SUICO_DESC_EDITED', 'The description was edited successfully');
define('_MD_SUICO_CAPTION', 'Caption');
define('_MD_SUICO_PHOTOTITLE', 'Photo Title');
define('_MD_SUICO_YOU_CAN_UPLOAD', "You can only upload jpg's files and up to %s KBytes in size");
define('_MD_SUICO_UPLOADPICTURE', 'Upload Picture');
define(
    '_MD_SUICO_ERROR',
    'Error : Unfortunately, this module has acted in an unexpected way. Please try again. '
); //Funny general error message
define('_MD_SUICO_PAGETITLE', "%s - %s's Social Network");
define('_MD_SUICO_SUBMIT', 'Submit');
define('_MD_SUICO_VIDEOS', 'Videos');
define('_MD_SUICO_NOTEBOOK', 'Notes');
define('_MD_SUICO_PHOTOS', 'Photos');
define('_MD_SUICO_FRIENDS', 'Friends');
define('_MD_SUICO_GROUPS', 'Groups');
define('_MD_SUICO_NOGROUPSYET', 'No Groups yet');
define('_MD_SUICO_MYGROUPS', 'My Groups');
//define('_MD_SUICO_ALLGROUPS', 'All Groups');
define('_MD_SUICO_PROFILE', 'Profile');
define('_MD_SUICO_HOME', 'Home');
define('_MD_SUICO_CONFIGS_TITLE', 'Settings');
##################################################### PICTURES #######################################################
//submitImage.php (for pictures submission
define('_MD_SUICO_UPLOADED', 'Upload Successful');
//delpicture.php
define('_MD_SUICO_ASK_CONFIRM_DELETION', 'Are you sure you want to delete this picture?');
define('_MD_SUICO_CONFIRM_DELETION', 'Yes please delete it!');
//album.php
define('_MD_SUICO_YOUHAVE', 'You have %s picture(s) in your album.');
define('_MD_SUICO_YOUCANHAVE', 'You can have up to %s picture(s).');
define('_MD_SUICO_DELETED', 'Image deleted successfully');
define('_MD_SUICO_SUBMIT_PIC_TITLE', 'Upload photo');
define('_MD_SUICO_SELECT_PHOTO', 'Select Photo');
define('_MD_SUICO_NOTHINGYET', 'No pictures in this album yet');
define('_MD_SUICO_AVATARCHANGE', 'Make this picture your new avatar');
define('_MD_SUICO_PRIVATIZE', 'Only you will see this image in your album');
define('_MD_SUICO_UNPRIVATIZE', 'Everyone will be able to see this image in your album');
define('_MD_SUICO_MYPHOTOS', 'My Photos');
//avatar.php
define('_MD_SUICO_AVATAR_EDITED', 'You changed your avatar!');
//private.php
define('_MD_SUICO_PRIVATIZED', 'From now on only you can see this image in your album');
define('_MD_SUICO_UNPRIVATIZED', 'From now everyone can see this image in your album');
########################################################## FRIENDS ###################################################
//friends.php
define('_MD_SUICO_FRIENDSTITLE', "%s's Friends");
define('_MD_SUICO_NOFRIENDSYET', 'No friends yet'); //also present in index.php
define('_MD_SUICO_MYFRIENDS', 'My Friends');
define('_MD_SUICO_FRIENDSHIP_CONFIGS', 'Set the configs of this friendship.');
//class/suicofriendship.php
define('_MD_SUICO_EDIT_FRIENDSHIP', 'Your friendship with this member:');
define('_MD_SUICO_FRIENDNAME', 'Username');
define('_MD_SUICO_LEVEL', 'Friendship level:');
define('_MD_SUICO_UNKNOWN_ACCEPTED', 'Unknown Friend');
define('_MD_SUICO_AQUAITANCE', 'Acquaintances'); //also present in index.php
define('_MD_SUICO_FRIEND', 'Friend'); //also present in index.php
define('_MD_SUICO_BESTFRIEND', 'Best Friend'); //also present in index.php
define('_MD_SUICO_FAN', 'Fan'); //also present in index.php
define('_MD_SUICO_FRIENDLY', 'Friendly'); //also present in index.php
define('_MD_SUICO_FRIENDLYNO', 'Nope');
define('_MD_SUICO_FRIENDLYYES', 'Yes');
define('_MD_SUICO_FRIENDLYALOT', 'Very much!');
define('_MD_SUICO_FUNNY', 'Funny');
define('_MD_SUICO_FUNNYNO', 'Nope');
define('_MD_SUICO_FUNNYYES', 'Yes');
define('_MD_SUICO_FUNNYALOT', 'Very much');
define('_MD_SUICO_COOL', 'Cool');
define('_MD_SUICO_COOLNO', 'Nope');
define('_MD_SUICO_COOLYES', 'Yes');
define('_MD_SUICO_COOLALOT', 'Very much');
define('_MD_SUICO_PHOTO', "Friend's Photo");
define('_MD_SUICO_UPDATEFRIEND', 'Update Friendship');
//editfriendship.php
define('_MD_SUICO_FRIENDSHIP_UPDATED', 'Friendship Updated');
//submitfriendrequest.php
define(
    '_MD_SUICO_FRIENDREQUEST_FROM',
    'A friend request has been sent to this user, Wait until he accepts to have him in your friends list.'
);
define(
    '_MD_SUICO_ALREADY_FRIEND_REQUESTFROM',
    'You have already sent a friendship request to this user or vice-versa <br>, Wait untill he accepts or rejects it or check if he has asked you as a friend visiting your profile page.'
);
define(
    '_MD_SUICO_FRIENDREQUEST_TO',
    'A friend request has been sent to this user, Wait until he accepts to have him in your friends list.'
);
define(
    '_MD_SUICO_ALREADY_FRIEND_REQUESTTO',
    'You have already sent a friendship request to this user or vice-versa <br>, Wait untill he accepts or rejects it or check if he has asked you as a friend visiting your profile page.'
);
//makefriends.php
define('_MD_SUICO_FRIENDMADE', 'Added as a friend!');
//delfriendship.php
define('_MD_SUICO_FRIENDSHIP_TERMINATED', 'You have broken your friendship with this user!');
############################################ VIDEOS ############################################################
//featuredvideo.php
define('_MD_SUICO_SETFEATUREDVIDEO', 'This video is featured on your profile page from now on');
define('_MD_SUICO_FEATUREDVIDEOPROFILE', 'This video is featured on your profile');
//videos.php
define('_MD_SUICO_YOUTUBECODE', 'YouTube code');
define('_MD_SUICO_ADDVIDEO', 'Add video');
define('_MD_SUICO_VIDEOTITLE', 'Video Title');
define('_MD_SUICO_ADDFAVORITEVIDEOS', 'Add favourite videos');
define(
    '_MD_SUICO_ADDVIDEOSHELP',
    'If you want to upload your own video for sharing, upload your videos to
<a href=https://www.youtube.com>YouTube</a> and then add the URL here in'
); //The name of the site will show after this
define('_MD_SUICO_MYVIDEOS', 'My Videos');
define('_MD_SUICO_FEATURETHISVIDEO', 'Feature this video in your main page');
define('_MD_SUICO_NOVIDEOSYET', 'No videos yet!');
//delvideo.php
define('_MD_SUICO_ASKCONFIRMVIDEODELETION', 'Are you sure you want to delete this video?');
define('_MD_SUICO_CONFIRMVIDEODELETION', 'Yes I am!');
define('_MD_SUICO_VIDEO_DELETED', 'Your video was deleted');
//submitVideo.php
define('_MD_SUICO_VIDEOSAVED', 'Your video was saved');
############################## GROUPS ########################################################
//class/Groups.php
define('_MD_SUICO_SUBMIT_GROUP', 'Create a new group');
define('_MD_SUICO_UPLOADGROUP', 'Save Group'); //also present in many groups related areas
define('_MD_SUICO_GROUP_IMAGE', 'Group Image'); //also present in many groups related areas
define('_MD_SUICO_GROUP_SAVED', 'Your Group was saved');
define('_MD_SUICO_GROUP_SAVED_ERROR', 'Error : Unfortunately, We could not save your group. Please try again. ');
define(
    '_MD_SUICO_GROUP_TITLE',
    'Title'
); //also present in many groups related areas
define(
    '_MD_SUICO_GROUP_DESC',
    'Description'
); //also present in many groups related areas
define(
    '_MD_SUICOCREATEYOURGROUP',
    'Create your own Group'
); //also present in many ther groups related
//abandongroup.php
define('_MD_SUICO_ASKCONFIRMABANDONGROUP', 'Are you sure you want to leave this Group?');
define('_MD_SUICO_CONFIRMABANDON', 'Yes please remove me from this Group!');
define('_MD_SUICO_GROUPABANDONED', "You don't belong to this Group anymore.");
//becomemembergroup.php
define('_MD_SUICO_YOUAREMEMBERNOW', 'You are now member of this community');
define('_MD_SUICO_YOUAREMEMBERALREADY', 'You are already a member of this Group');
//delete_group.php
define(
    '_MD_SUICO_ASKCONFIRMGROUPDELETION',
    'Are you sure you want to delete this Group permanently?'
);
define('_MD_SUICO_CONFIRMGROUPDELETION', 'Yes, please delete this Group!');
define('_MD_SUICO_GROUP_DELETED', 'Group deleted!');
//edit_group.php
define('_MD_SUICO_MAINTAIN_OLD_IMAGE', 'Keep this image'); //also present in other groups related
define('_MD_SUICO_GROUPEDITED', 'Group edited');
define('_MD_SUICO_EDIT_GROUP', 'Edit your Group'); //also present in other groups related
define(
    '_MD_SUICO_GROUPOWNER',
    'You are the owner of this Group!'
); //also present in other groups related
define(
    '_MD_SUICO_MEMBERSOFGROUP',
    'Members of Group'
); //also present in other groups related
//submitGroup.php
define('_MD_SUICO_GROUP_CREATED', 'Your Group was created');
//kickfromgroup.php
define('_MD_SUICO_KICKOUT', 'Remove');
define('_MD_SUICO_CONFIRMKICK', 'Yes remove this member');
define('_MD_SUICO_ASKCONFIRMKICKFROMGROUP', 'Are you sure you want to remove this person out of the Group?');
define(
    '_MD_SUICO_GROUPKICKED',
    "You've banished this user from the Group, but who knows when he'll try and comeback!"
);
//Groups.php
define('_MD_SUICO_GROUP_ABANDON', 'Leave');
define('_MD_SUICO_GROUP_JOIN', 'Join');
define('_MD_SUICO_GROUP_SEARCH', 'Search a Group');
define('_MD_SUICO_GROUP_SEARCHKEYWORD', 'Keyword');
define('_MD_SUICO_GROUPSEARCHRESULT', 'Group Search Result');
######################################### NOTES #####################################################
//notebook.php
define('_MD_SUICO_ENTERTEXTNOTE', 'Enter Text or Xoops Codes');
define('_MD_SUICO_SENDNOTE', 'Post Note');
define('_MD_SUICO_ANSWERNOTE', 'Reply'); //also present in configs.php
define('_MD_SUICO_MYNOTEBOOK', 'My Notebook');
define('_MD_SUICO_CANCEL', 'Cancel'); //also present in configs.php
define('_MD_SUICO_NOTETIPS', 'Note Tips');
define('_MD_SUICO_BOLD', 'bold');
define('_MD_SUICO_ITALIC', 'italic');
define('_MD_SUICO_UNDERLINE', 'underline');
define('_MD_SUICO_NONOTESYET', 'No Notes created in this Notebook yet');
define('_MD_SUICO_SENDNOTESTO', 'Send notes to');
//submitNote.php
define('_MD_SUICO_NOTE_SENT', 'Thanks for participating, Note sent');
//delete_note.php
define('_MD_SUICO_ASKCONFIRMNOTEDELETION', 'Are you sure you want to delete this Note?');
define('_MD_SUICO_CONFIRMNOTEDELETION', 'Yes please delete this Note.');
define('_MD_SUICO_NOTE_DELETED', 'The Note was deleted');
############################ CONFIGS ##############################################
//configs.php
define('_MD_SUICO_CONFIGS_EVERYONE', 'Everyone');
define('_MD_SUICO_CONFIGS_ONLYEUSERS', 'Only Registered Members');
define('_MD_SUICO_CONFIGS_ONLYEFRIENDS', 'My friends.');
define('_MD_SUICO_CONFIGS_ONLYME', 'Only Me');
define('_MD_SUICO_CONFIGS_PICTURES', 'See your Photos');
define('_MD_SUICO_CONFIGS_VIDEOS', 'See your Videos');
define('_MD_SUICO_CONFIGS_GROUPS', 'See your Groups');
define('_MD_SUICO_CONFIGS_NOTES', 'See your Notes');
define('_MD_SUICO_CONFIGS_NOTESSEND', 'Send you Notes');
define('_MD_SUICO_CONFIGS_FRIENDS', 'See your Friends');
define('_MD_SUICO_CONFIGS_PROFILECONTACT', 'See your Contact Information');
define('_MD_SUICO_CONFIGS_PROFILEGENERAL', 'See your Personal Information');
define('_MD_SUICO_CONFIGS_PROFILESTATS', 'See your Contributions');
define('_MD_SUICO_WHOCAN', 'Who can:');
//submitConfigs.php
define('_MD_SUICO_CONFIGS_SAVE', 'Configuration saved!');
define('_MD_SUICO_CONFIGS_SAVE_FAILED', 'ERROR: Configuration has not been saved');
//class/suico_controller.php
define(
    '_MD_SUICO_NOPRIVILEGE_PHOTOS',
    "The owner of this profile has set the privileges to see it, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it."
);
define(
    '_MD_SUICO_NOPRIVILEGE_NOTES',
    "The owner of this profile has set the privileges to see it, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it."
);
define(
    '_MD_SUICO_NOPRIVILEGE_AUDIOS',
    "The owner of this profile has set the privileges to see it, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it."
);
define(
    '_MD_SUICO_NOPRIVILEGE_VIDEOS',
    "The owner of this profile has set the privileges to see it, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it."
);
define(
    '_MD_SUICO_NOPRIVILEGE_FRIENDS',
    "The owner of this profile has set the privileges to see it, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it."
);
define(
    '_MD_SUICO_NOPRIVILEGE_GROUPS',
    "The owner of this profile has set the privileges to see it, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it."
);
define(
    '_MD_SUICO_NOPRIVILEGE',
    "The owner of this profile has set the privileges to see %s, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it."
);
###################################### OTHERS ##############################
//index.php
define('_MD_SUICO_VISITORS', 'Visitors (who visited your profile recently)');
define('_MD_SUICO_USER_DETAILS', 'Member Details');
define('_MD_SUICO_USER_CONTRIBUTIONS', 'Member Contributions');
define('_MD_SUICO_FANS', 'Fans');
define('_MD_SUICO_UNKNOWN_REJECTING', "I don't know this person, Do not add them to my friends list");
define('_MD_SUICO_UNKNOWN_ACCEPTING', "I don't know this person, Yet add them to my friends list");
define('_MD_SUICO_ASKINGFRIEND', 'Is %s your friend?');
define('_MD_SUICO_ASKBEFRIEND', 'Ask this user to be your friend?');
define('_MD_SUICO_EDITPROFILE', 'Edit Profile');
define('_MD_SUICO_SELECTAVATAR', 'Upload pictures to your album and select one as your avatar.');
define('_MD_SUICO_SELECTFEATUREDVIDEO', 'Then you can select a video to feature in your profile page');
define('_MD_SUICO_NOAVATARYET', 'No avatar yet');
define('_MD_SUICO_NOFEATUREDVIDEOYET', 'No featured video yet');
define('_MD_SUICO_MYPROFILE', 'My Profile');
define('_MD_SUICO_YOU_HAVE_X_FRIENDREQUESTS', 'You have %u requests for friendship.');
define('_MD_SUICO_CONTACTINFO', 'Contact Info');
define('_MD_SUICO_SUSPENDUSER', 'Suspend User');
define('_MD_SUICO_SUSPEND', 'Suspend');
define('_MD_SUICO_SUSPENDTIME', 'Time of suspension(in secs)');
define('_MD_SUICO_UNSUSPEND', 'Unsuspend ');
define('_MD_SUICO_SUSPENSIONADMIN', 'Suspension Admin Tools');
define('_MD_SUICO_USER_PERSONAL', 'Personal');
define('_MD_SUICO_ACTIVITY', 'Activity');
define('_MD_SUICO_COMMUNITY', 'Community');
//suspend.php
define('_MD_SUICO_SUSPENDED', 'User under suspension until %s');
define('_MD_SUICO_USER_SUSPENDED', 'User suspended!'); //als0 present in index.php
//unsuspend.php
define('_MD_SUICO_USER_UNSUSPENDED', 'User Unsuspended');
//searchmembers.php
define('_MD_SUICO_SEARCH', 'Search Members');
define('_MD_SUICO_AVATAR', 'Avatar');
define('_MD_SUICO_REALNAME', 'Real Name');
define('_MD_SUICO_REGDATE', 'Joined Date');
define('_MD_SUICO_EMAIL', 'Email');
define('_MD_SUICO_PM', 'PM');
define('_MD_SUICO_URL', 'URL');
define('_MD_SUICO_ADMIN', 'Admin');
define('_MD_SUICO_PREVIOUS', 'Previous');
define('_MD_SUICO_NEXT', 'Next');
define('_MD_SUICO_USER_SFOUND', '%s member(s) found');
define('_MD_SUICO_TOTALUSERS', 'Total Members');
define('_MD_SUICO_NOFOUND', 'No Members Found');
define('_MD_SUICO_UNAME', 'User Name');
define('_MD_SUICO_LOCATION_CONTAINS', 'Location contains');
define('_MD_SUICO_OCCUPATION_CONTAINS', 'Occupation contains');
define('_MD_SUICO_INTEREST_CONTAINS', 'Interest contains');
define('_MD_SUICO_URL_CONTAINS', 'URL contains');
define('_MD_SUICO_LASTLOGMORE', "Last login is more than <span style='color:#ff0000;'>X</span> days ago");
define('_MD_SUICO_LASTLOGLESS', "Last login is less than <span style='color:#ff0000;'>X</span> days ago");
define('_MD_SUICO_REGMORE', "Joined date is more than <span style='color:#ff0000;'>X</span> days ago");
define('_MD_SUICO_REGLESS', "Joined date is less than <span style='color:#ff0000;'>X</span> days ago");
define('_MD_SUICO_POSTSMORE', "Number of Posts is greater than <span style='color:#ff0000;'>X</span>");
define('_MD_SUICO_POSTSLESS', "Number of Posts is less than <span style='color:#ff0000;'>X</span>");
define('_MD_SUICO_SORT', 'Sort by');
define('_MD_SUICO_ORDER', 'Order');
define('_MD_SUICO_LASTLOGIN', 'Last login');
define('_MD_SUICO_POSTS', 'Number of posts');
define('_MD_SUICO_ASC', 'Ascending order');
define('_MD_SUICO_DESC', 'Descending order');
define('_MD_SUICO_LIMIT', 'Number of members per page');
define('_MD_SUICO_RESULTS', 'Search results');
//26/10/2007
define('_MD_SUICO_VIDEOS_ENABLED_NOT', 'The administrator of the site has disabled videos feature');
define('_MD_SUICO_FRIENDS_ENABLED_NOT', 'The administrator of the site has disabled friends feature');
define('_MD_SUICO_GROUPS_ENABLED_NOT', 'The administrator of the site has disabled groups feature');
define('_MD_SUICO_PICTURES_ENABLED_NOT', 'The administrator of the site has disabled pictures feature');
define('_MD_SUICO_NOTES_ENABLED_NOT', 'The administrator of the site has disabled Notes feature');
//26/01/2008
define('_MD_SUICO_ALLFRIENDS', 'View all friends');
define('_MD_SUICO_ALLGROUPS', 'View all groups');
//31/01/2008
define('_MD_SUICO_FRIENDSHIP_NOTACCEPTED', 'Friendship rejected');
//07/04/2008
define('_MD_SUICO_USER_DOESNTEXIST', "This user doesn't exist or was deleted");
define('_MD_SUICO_FANSTITLE', "%s's Fans");
define('_MD_SUICO_NOFANSYET', 'No fans yet');
//17/04/2008
define('_MD_SUICO_AUDIO_ENABLED_NOT', 'The administrator of the site has disabled audio feature');
define('_MD_SUICO_NOAUDIOYET', "This user hasn't uploaded any audio files yet");
define('_MD_SUICO_AUDIOS', 'Audio');
define('_MD_SUICO_CONFIGS_AUDIOS', 'See your Audio files');
define('_MD_SUICO_UPLOADEDAUDIO', 'Audio file uploaded');
define('_MD_SUICO_AUDIO_SELECT', 'Browse for your mp3 file');
define('_MD_SUICO_AUDIO_AUTHOR', 'Author/Singer');
define('_MD_SUICO_AUDIO_TITLE', 'Title of file or song');
define('_MD_SUICO_AUDIO_ADD', 'Add an mp3 file');
define('_MD_SUICO_AUDIO_SUBMIT', 'Upload file');
define(
    '_MD_SUICO_AUDIO_ADD_HELP',
    'Choose an mp3 file on your computer, max size %s .'
);
//19/04/2008
define('_MD_SUICO_AUDIO_DELETED', 'Your mp3 file was deleted!');
define('_MD_SUICO_AUDIO_DELETE_CONFIRM_ASK', 'Do you really want to delete your audio file?');
define('_MD_SUICO_AUDIO_DELETE_CONFIRM', 'Yes please delete it!');
define('_MD_SUICO_META', 'Meta Info');
define('_MD_SUICO_META_TITLE', 'Title');
define('_MD_SUICO_META_ALBUM', 'Album');
define('_MD_SUICO_META_ARTIST', 'Artist');
define('_MD_SUICO_META_YEAR', 'Year');
// v3.3RC2
define('_MD_SUICO_PLAYER', 'Your audio player');
// 3.5
define('_MD_SUICO_ADDFRIEND', 'Add Friend');
define('_MD_SUICO_FRIENDREQUEST_PENDING', 'Friend Request Pending');
define('_MD_SUICO_MYFRIEND', 'Friend');
define('_MD_SUICO_FRIENDREQUEST_SENT', 'Friend Request Sent');
define('_MD_SUICO_FRIENDREQUEST_CANCEL', 'Cancel Friend Request');
define('_MD_SUICO_FRIENDSHIP_STATUS', 'Friendship Status');
define('_MD_SUICO_PROFILEVISITORS', 'Latest Visitors');
define('_MD_SUICO_VIDEO_FEATURED', 'Featured Video');
define('_MD_SUICO_ALLVIDEOS', 'View all videos');
define('_MD_SUICO_OWNEROFGROUP', 'Group Owner');
define('_MD_SUICO_MEMBERSLIST', 'Members List');
define('_MD_SUICO_LATESTMEMBER', 'Latest Member');
define('_MD_SUICO_MEMBERSLISTSECTION', 'Welcome to Members List');
define('_MD_SUICO_NEVERLOGIN', 'Never Login');
define('_MD_SUICO_MEMBERSINCE', 'Member Since');
define('_MD_SUICO_CONTACT', 'Contact');
define('_MD_SUICO_RANK', 'Rank');
define('_MD_SUICO_FRIEND_ACCEPT', 'Accept');
define('_MD_SUICO_FRIEND_REJECT', 'Reject');
define('_MD_SUICO_ONLINESTATUS', 'Online Status');
define('_MD_SUICO_ONLINE', 'Online');
define('_MD_SUICO_OFFLINE', 'Offline');
define('_MD_SUICO_SIGNATURE', 'Signature');
define('_MD_SUICO_BIOGRAPHY', 'Biography');
define('_MD_SUICO_EXTRAINFO', 'Extra Information');
define('_MD_SUICO_GROUP', 'Group');
define('_MD_SUICO_PRIVATEMESSAGE', 'Private Message');
define('_MD_SUICO_WEBSITE', 'Website');
define('_MD_SUICO_WWW', 'WWW');
define('_MD_SUICO_LOCATION', 'Location');
define('_MD_SUICO_OCCUPATION', 'Occupation');
define('_MD_SUICO_INTEREST', 'Interest');
define('_MD_SUICO_MYAUDIOS', 'My Audios');
define('_MD_SUICO_MYFANS', 'My Fans');
define('_MD_SUICO_EXTRAINFO_CONTAINS', 'Extra Info Contains');
define('_MD_SUICO_BIOGRAPHYINFO_CONTAINS', 'Biography Contains');
define('_MD_SUICO_SIGNATURE_CONTAINS', 'Signature Contains');
define('_MD_SUICO_MEMBEROFGROUP', 'Member');
define('_MD_SUICO_RECENTNOTES', 'Recent Notes');
define('_MD_SUICO_LATESTNOTES', 'Latest Notes by Members');
define('_MD_SUICO_EDIT', 'Edit');
define('_MD_SUICO_DESCRIPTION', 'Description');
define('_MD_SUICO_AVAILABLEGROUPS', 'All Groups');
define('_MD_SUICO_GROUPSLIST', 'Groups List');
define('_MD_SUICO_NOMATCHGROUP', 'No Match Found for your Query. ');
//users
define('_MD_SUICO_USER_NAME', 'Username');
define('_MD_SUICO_PASSWORD', 'Password');
define('_MD_SUICO_REMEMBERME', 'Remember Me');
define('_MD_SUICO_LOGIN', 'Login');
define('_MD_SUICO_USER_LOGIN', 'Members Login');
define('_MD_SUICO_LOSTPASSWORD', 'Lost Your Password ?');
define('_MD_SUICO_NOPROBLEM', 'No problem. Simply enter the e-mail address we have on file for your account.');
define('_MD_SUICO_NOTREGISTERED', 'Not registered? Click.');
define('_MD_SUICO_SENDPASSWORD', 'Send Password.');
define('_MD_SUICO_YOURUSERNAME', 'Your Username');
define('_MD_SUICO_YOURPASSWORD', 'Your Password.');
define('_MD_SUICO_YOUREMAIL', 'Your Email');
define('_MD_SUICO_SIGNUP', 'Sign Up Now !');
define('_MD_SUICO_NOTAMEMBER', 'Not a member?');
define('_MD_SUICO_SOCIALNETWORK', 'Social Network');
define('_MD_SUICO_USER_WELCOME', 'Enlarge friends network.');
define('_MD_SUICO_JOINUS', 'Join our community today and start to search for new friends!');
define('_MD_SUICO_FINDFRIENDS', 'Find Friends');
define('_MD_SUICO_FINDMOREFRIENDS', 'Find More Friends');
define('_MD_SUICO_METAINFOHELP', 'Leave title and author fields blank if your file has metainfo already');
define('_MD_SUICO_GROUPDESCRIPTION', 'Group Description');
define('_MD_SUICO_PRIVATEPHOTO', 'Private Photo');
define('_MD_SUICO_FRIENDSHIP_SETTINGS', 'Friend Settings');
define('_MD_SUICO_FRIENDSHIP_DELETE', 'Delete Friend ');
define('_MD_SUICO_FRIENDREQUEST_CANCELLED', 'You have cancel your friendship request with this user!');
define('_MD_SUICO_GROUPTOTALMEMBERS', 'Group Total Members');
define('_MD_SUICO_GROUPDATECREATED', 'Founded Date');
define('_MD_SUICO_GROUPMEMBERS', 'members');
//Data Tables
define('_MD_SUICO_DTABLE_DECIMAL', '');
define('_MD_SUICO_DTABLE_EMPTYTABLE', 'No data available in table');
define('_MD_SUICO_DTABLE_INFOSHOWING', 'Showing');
define('_MD_SUICO_DTABLE_INFOTO', 'to');
define('_MD_SUICO_DTABLE_INFOOF', 'of');
define('_MD_SUICO_DTABLE_INFOENTRIES', 'entries');
define('_MD_SUICO_DTABLE_INFOEMPTY', 'Showing 0 to 0 of 0 entries');
define('_MD_SUICO_DTABLE_INFOFILTEREDFROM', 'filtered from');
define('_MD_SUICO_DTABLE_INFOFILTEREDTOTALENTRIES', 'total entries');
define('_MD_SUICO_DTABLE_INFOPOSTFIX', '');
define('_MD_SUICO_DTABLE_THOUSANDS', ',');
define('_MD_SUICO_DTABLE_LENGTHMENUSHOW', 'Show');
define('_MD_SUICO_DTABLE_LENGTHMENUENTRIES', 'entries');
define('_MD_SUICO_DTABLE_LOADINGRECORDS', 'Loading...');
define('_MD_SUICO_DTABLE_PROCESSING', 'Processing...');
define('_MD_SUICO_DTABLE_SEARCH', 'Search');
define('_MD_SUICO_DTABLE_ZERORECORDS', 'No matching records found');
define('_MD_SUICO_DTABLE_FIRST', 'First');
define('_MD_SUICO_DTABLE_LAST', 'Last');
define('_MD_SUICO_DTABLE_NEXT', 'Next');
define('_MD_SUICO_DTABLE_PREVIOUS', 'Previous');
define('_MD_SUICO_DTABLE_SORT_ASCENDING', ': activate to sort column ascending');
define('_MD_SUICO_DTABLE_SORT_DESCENSING', ': activate to sort column descending');
define('_MD_SUICO_CANTVOTEOWN', 'You can not vote for yourself');
define('_MD_SUICO_VOTED', 'Vote');
define('_MD_SUICO_ALREADYVOTED', 'Sorry, you have already voted once.');
//Profile Module
define('_MD_SUICO_DISPLAYNAME', 'Display Name');
define('_MD_SUICO_SORTBY', 'Sort by');
define('_MD_SUICO_PERPAGE', 'Items per page');
define('_MD_SUICO_LATERTHAN', ' %s  is later than');
define('_MD_SUICO_EARLIERTHAN', ' %s  is earlier than');
define('_MD_SUICO_LARGERTHAN', ' %s  is greater than');
define('_MD_SUICO_SMALLERTHAN', ' %s  is smaller than');
define('_MD_SUICO_REGISTER_NOTGROUP', 'New user is not registered to corresponding groups.');
define('_MD_SUICO_FINISH_LOGIN', 'Your account has been created successfully, please click to log on.');
define('_MD_SUICO_REGISTER_FINISH', 'Thanks for registering');
define('_MD_SUICO_REGISTER_STEPS', 'Register steps:');
define('_MD_SUICO_DEFAULT', 'Basic Information');
define('_MD_SUICO_ERRORDURINGSAVE', 'Error during save');
define('_MD_SUICO_NOSTEPSAVAILABLE', 'Registration is not allowed at this moment, please come back later.');
define('_MD_SUICO_EXPIRED', 'The process has been expired, please go back to try again.');
define('_MD_SUICO_RECENTACTIVITY', 'Recent Activities');
define('_MD_SUICO_THEME', 'Theme');
define('_MD_SUICO_ACTIVATE', 'Activate');
define('_MD_SUICO_DEACTIVATE', 'Deactivate');
define('_MD_SUICO_SENDPM', 'Send Message');
define('_MD_SUICO_CHANGEPASSWORD', 'Change Password');
define('_MD_SUICO_PASSWORDCHANGED', 'Password Changed Successfully');
define('_MD_SUICO_OLDPASSWORD', 'Current Password');
define('_MD_SUICO_NEWPASSWORD', 'New Password');
define('_MD_SUICO_WRONGPASSWORD', 'Old password is wrong');
define('_MD_SUICO_CHANGEMAIL', 'Change Email Address');
define('_MD_SUICO_NEWMAIL', 'New Email Address');
define('_MD_SUICO_NEWEMAIL', 'New email address at %s');
define('_MD_SUICO_EMAILCHANGED', 'Your Email Address Has Been Changed');
define('_MD_SUICO_SITEDEFAULT', 'Site default');
define('_MD_SUICO_USERINFO', 'User profile');
define('_MD_SUICO_REGISTER', 'Registration form');
define('_MD_SUICO_ACTUS', 'Active Users: %s');
define('_MD_SUICO_FOUNDUSER', '%s users found');
define('_MD_SUICO_USERLEVEL', 'Status');
define('_MD_SUICO_ACTIVE', 'Active');
define('_MD_SUICO_INACTIVE', 'Inactive');
define('_MD_SUICO_NICKNAME', 'Username');
define('_MD_SUICO_EMAILADDRESS', 'Email Address');
define('_MD_SUICO_SAVECHANGES', 'Submit');
define('_MD_SUICO_USERGROUPS', 'Users Groups');
define('_MD_SUICO_CONFIRMPASSWORD', 'Type again to confirm your password');
define('_MD_SUICO_LOGOUT', 'Logout');
define('_MD_SUICO_CHANGEAVATAR', 'Change Avatar');
define('_MD_SUICO_CHANGEAVATARHELP', 'You can also change your avatar by selecting any of the photos upload in your photo album section.');
define('_MD_SUICO_EDIT_PICTURE', 'Edit Picture');
define('_MD_SUICO_EDIT_AUDIO', 'Edit Audio');
define('_MD_SUICO_NO_MEMBER', 'No members');
define('_MD_SUICO_ONEMEMBER', '1 member');
define('_MD_SUICO_GROUPTOTALCOMMENTS', 'Group Total Comments');
define('_MD_SUICO_ONECOMMENT', '1 comment');
define('_MD_SUICO_NO_COMMENTS', 'No comments');
define('_MD_SUICO_COMMENTS', 'Comments');
define('_MD_SUICO_YOUTUBE_CODEHELP', '<strong>Example:</strong> https://www.youtube.com/watch?v=jNQXAC9IVRw');
