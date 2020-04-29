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
 * @package         yogurt
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

//Present in many files (videos pictures etc...)
define('_MD_YOGURT_DELETE', 'Delete');
define('_MD_YOGURT_EDIT_DESC', 'Edit description');
define('_MD_YOGURT_TOKENEXPIRED', 'Your Security Token has Expired<br>Please Try Again');
define('_MD_YOGURT_DESC_EDITED', 'The description was edited successfully');
define('_MD_YOGURT_CAPTION', 'Caption');
define('_MD_YOGURT_PHOTOTITLE', 'Photo Title');
define('_MD_YOGURT_YOU_CAN_UPLOAD', "You can only upload jpg's files and up to %s KBytes in size");
define('_MD_YOGURT_UPLOADPICTURE', 'Upload Picture');
define(
    '_MD_YOGURT_ERROR',
    'Error : Unfortunately, this module has acted in an unexpected way. Please try again. '
); //Funny general error message
define('_MD_YOGURT_PAGETITLE', "%s - %s's Social Network");
define('_MD_YOGURT_SUBMIT', 'Submit');
define('_MD_YOGURT_VIDEOS', 'Videos');
define('_MD_YOGURT_NOTEBOOK', 'Notes');
define('_MD_YOGURT_PHOTOS', 'Photos');
define('_MD_YOGURT_FRIENDS', 'Friends');
define('_MD_YOGURT_GROUPS', 'Groups');
define('_MD_YOGURT_NOGROUPSYET', 'No Groups yet');
define('_MD_YOGURT_MYGROUPS', 'My Groups');
//define('_MD_YOGURT_ALLGROUPS', 'All Groups');
define('_MD_YOGURT_PROFILE', 'Profile');
define('_MD_YOGURT_HOME', 'Home');
define('_MD_YOGURT_CONFIGS_TITLE', 'Settings');

##################################################### PICTURES #######################################################
//submitImage.php (for pictures submission
define('_MD_YOGURT_UPLOADED', 'Upload Successful');

//delpicture.php
define('_MD_YOGURT_ASK_CONFIRM_DELETION', 'Are you sure you want to delete this picture?');
define('_MD_YOGURT_CONFIRM_DELETION', 'Yes please delete it!');

//album.php
define('_MD_YOGURT_YOUHAVE', 'You have %s picture(s) in your album.');
define('_MD_YOGURT_YOUCANHAVE', 'You can have up to %s picture(s).');
define('_MD_YOGURT_DELETED', 'Image deleted successfully');
define('_MD_YOGURT_SUBMIT_PIC_TITLE', 'Upload photo');
define('_MD_YOGURT_SELECT_PHOTO', 'Select Photo');
define('_MD_YOGURT_NOTHINGYET', 'No pictures in this album yet');
define('_MD_YOGURT_AVATARCHANGE', 'Make this picture your new avatar');
define('_MD_YOGURT_PRIVATIZE', 'Only you will see this image in your album');
define('_MD_YOGURT_UNPRIVATIZE', 'Everyone will be able to see this image in your album');
define('_MD_YOGURT_MYPHOTOS', 'My Photos');

//avatar.php
define('_MD_YOGURT_AVATAR_EDITED', 'You changed your avatar!');

//private.php
define('_MD_YOGURT_PRIVATIZED', 'From now on only you can see this image in your album');
define('_MD_YOGURT_UNPRIVATIZED', 'From now everyone can see this image in your album');

########################################################## FRIENDS ###################################################
//friends.php
define('_MD_YOGURT_FRIENDSTITLE', "%s's Friends");
define('_MD_YOGURT_NOFRIENDSYET', 'No friends yet'); //also present in index.php
define('_MD_YOGURT_MYFRIENDS', 'My Friends');
define('_MD_YOGURT_FRIENDSHIP_CONFIGS', 'Set the configs of this friendship.');

//class/yogurtfriendship.php
define('_MD_YOGURT_EDIT_FRIENDSHIP', 'Your friendship with this member:');
define('_MD_YOGURT_FRIENDNAME', 'Username');
define('_MD_YOGURT_LEVEL', 'Friendship level:');
define('_MD_YOGURT_UNKNOWN_ACCEPTED', 'Unknown Friend');
define('_MD_YOGURT_AQUAITANCE', 'Acquaintances'); //also present in index.php
define('_MD_YOGURT_FRIEND', 'Friend'); //also present in index.php
define('_MD_YOGURT_BESTFRIEND', 'Best Friend'); //also present in index.php
define('_MD_YOGURT_FAN', 'Fan'); //also present in index.php
define('_MD_YOGURT_FRIENDLY', 'Friendly'); //also present in index.php
define('_MD_YOGURT_FRIENDLYNO', 'Nope');
define('_MD_YOGURT_FRIENDLYYES', 'Yes');
define('_MD_YOGURT_FRIENDLYALOT', 'Very much!');
define('_MD_YOGURT_FUNNY', 'Funny');
define('_MD_YOGURT_FUNNYNO', 'Nope');
define('_MD_YOGURT_FUNNYYES', 'Yes');
define('_MD_YOGURT_FUNNYALOT', 'Very much');
define('_MD_YOGURT_COOL', 'Cool');
define('_MD_YOGURT_COOLNO', 'Nope');
define('_MD_YOGURT_COOLYES', 'Yes');
define('_MD_YOGURT_COOLALOT', 'Very much');
define('_MD_YOGURT_PHOTO', "Friend's Photo");
define('_MD_YOGURT_UPDATEFRIEND', 'Update Friendship');

//editfriendship.php
define('_MD_YOGURT_FRIENDSHIP_UPDATED', 'Friendship Updated');

//submitfriendrequest.php
define(
    '_MD_YOGURT_FRIENDREQUEST_FROM',
    'A friend request has been sent to this user, Wait until he accepts to have him in your friends list.'
);
define(
    '_MD_YOGURT_ALREADY_FRIEND_REQUESTFROM',
    'You have already sent a friendship request to this user or vice-versa <br>, Wait untill he accepts or rejects it or check if he has asked you as a friend visiting your profile page.'
);

define(
    '_MD_YOGURT_FRIENDREQUEST_TO',
    'A friend request has been sent to this user, Wait until he accepts to have him in your friends list.'
);
define(
    '_MD_YOGURT_ALREADY_FRIEND_REQUESTTO',
    'You have already sent a friendship request to this user or vice-versa <br>, Wait untill he accepts or rejects it or check if he has asked you as a friend visiting your profile page.'
);

//makefriends.php
define('_MD_YOGURT_FRIENDMADE', 'Added as a friend!');

//delfriendship.php
define('_MD_YOGURT_FRIENDSHIP_TERMINATED', 'You have broken your friendship with this user!');

############################################ VIDEOS ############################################################
//mainvideo.php
define('_MD_YOGURT_SETMAINVIDEO', 'This video is featured on your profile page from now on');

//videos.php
define('_MD_YOGURT_YOUTUBECODE', 'YouTube code or URL');
define('_MD_YOGURT_ADDVIDEO', 'Add video');
define('_MD_YOGURT_ADDFAVORITEVIDEOS', 'Add favourite videos');
define(
    '_MD_YOGURT_ADDVIDEOSHELP',
    'If you want to upload your own video for sharing, upload your videos to
<a href=https://www.youtube.com>YouTube</a> and then add the URL here in'
); //The name of the site will show after this
define('_MD_YOGURT_MYVIDEOS', 'My Videos');
define('_MD_YOGURT_MAKEMAIN', 'Feature this video in your main page');
define('_MD_YOGURT_NOVIDEOSYET', 'No videos yet!');

//delvideo.php
define('_MD_YOGURT_ASKCONFIRMVIDEODELETION', 'Are you sure you want to delete this video?');
define('_MD_YOGURT_CONFIRMVIDEODELETION', 'Yes I am!');
define('_MD_YOGURT_VIDEO_DELETED', 'Your video was deleted');

//submitVideo.php
define('_MD_YOGURT_VIDEOSAVED', 'Your video was saved');

############################## GROUPS ########################################################
//class/Groups.php
define('_MD_YOGURT_SUBMIT_GROUP', 'Create a new group');
define('_MD_YOGURT_UPLOADGROUP', 'Save Group'); //also present in many ther groups related
define(
    '_MD_YOGURT_GROUP_IMAGE',
    'Group Image'
); //also present in many ther groups related
define(
    '_MD_YOGURT_GROUP_TITLE',
    'Title'
); //also present in many ther groups related
define(
    '_MD_YOGURT_GROUP_DESC',
    'Description'
); //also present in many ther groups related
define(
    '_MD_YOGURTCREATEYOURGROUP',
    'Create your own Group'
); //also present in many ther groups related

//abandongroup.php
define('_MD_YOGURT_ASKCONFIRMABANDONGROUP', 'Are you sure you want to leave this Group?');
define('_MD_YOGURT_CONFIRMABANDON', 'Yes please remove me from this Group!');
define('_MD_YOGURT_GROUPABANDONED', "You don't belong to this Group anymore.");

//becomemembergroup.php
define('_MD_YOGURT_YOUAREMEMBERNOW', 'You are now member of this community');
define('_MD_YOGURT_YOUAREMEMBERALREADY', 'You are already a member of this Group');

//delete_group.php
define(
    '_MD_YOGURT_ASKCONFIRMGROUPDELETION',
    'Are you sure you want to delete this Group permanently?'
);
define('_MD_YOGURT_CONFIRMGROUPDELETION', 'Yes, please delete this Group!');
define('_MD_YOGURT_GROUP_DELETED', 'Group deleted!');

//edit_group.php
define('_MD_YOGURT_MAINTAIN_OLD_IMAGE', 'Keep this image'); //also present in other groups related
define('_MD_YOGURT_GROUPEDITED', 'Group edited');
define('_MD_YOGURT_EDIT_GROUP', 'Edit your Group'); //also present in other groups related
define(
    '_MD_YOGURT_GROUPOWNER',
    'You are the owner of this Group!'
); //also present in other groups related
define(
    '_MD_YOGURT_MEMBERSOFGROUP',
    'Members of Group'
); //also present in other groups related

//submitGroup.php
define('_MD_YOGURT_GROUP_CREATED', 'Your Group was created');

//kickfromgroup.php
define('_MD_YOGURT_KICKOUT', 'Remove');
define('_MD_YOGURT_CONFIRMKICK', 'Yes remove this member');
define('_MD_YOGURT_ASKCONFIRMKICKFROMGROUP', 'Are you sure you want to remove this person out of the Group?');
define(
    '_MD_YOGURT_GROUPKICKED',
    "You've banished this user from the Group, but who knows when he'll try and comeback!"
);

//Groups.php
define('_MD_YOGURT_GROUP_ABANDON', 'Leave');
define('_MD_YOGURT_GROUP_JOIN', 'Join');
define('_MD_YOGURT_GROUP_SEARCH', 'Search a Group');
define('_MD_YOGURT_GROUP_SEARCHKEYWORD', 'Keyword');
define('_MD_YOGURT_GROUPSEARCHRESULT', 'Group Search Result');

######################################### NOTES #####################################################
//notebook.php
define('_MD_YOGURT_ENTERTEXTNOTE', 'Enter Text or Xoops Codes');
define('_MD_YOGURT_SENDNOTE', 'Post Note');
define('_MD_YOGURT_ANSWERNOTE', 'Reply'); //also present in configs.php
define('_MD_YOGURT_MYNOTEBOOK', 'My Notebook');
define('_MD_YOGURT_CANCEL', 'Cancel'); //also present in configs.php
define('_MD_YOGURT_NOTETIPS', 'Note Tips');
define('_MD_YOGURT_BOLD', 'bold');
define('_MD_YOGURT_ITALIC', 'italic');
define('_MD_YOGURT_UNDERLINE', 'underline');
define('_MD_YOGURT_NONOTESYET', 'No Notes created in this Notebook yet');
define('_MD_YOGURT_SENDNOTESTO', 'Send notes to');

//submitNote.php
define('_MD_YOGURT_NOTE_SENT', 'Thanks for participating, Note sent');

//delete_note.php
define('_MD_YOGURT_ASKCONFIRMNOTEDELETION', 'Are you sure you want to delete this Note?');
define('_MD_YOGURT_CONFIRMNOTEDELETION', 'Yes please delete this Note.');
define('_MD_YOGURT_NOTE_DELETED', 'The Note was deleted');

############################ CONFIGS ##############################################
//configs.php
define('_MD_YOGURT_CONFIGS_EVERYONE', 'Everyone');
define('_MD_YOGURT_CONFIGS_ONLYEUSERS', 'Only Registered Members');
define('_MD_YOGURT_CONFIGS_ONLYEFRIENDS', 'My friends.');
define('_MD_YOGURT_CONFIGS_ONLYME', 'Only Me');
define('_MD_YOGURT_CONFIGS_PICTURES', 'See your Photos');
define('_MD_YOGURT_CONFIGS_VIDEOS', 'See your Videos');
define('_MD_YOGURT_CONFIGS_GROUPS', 'See your Groups');
define('_MD_YOGURT_CONFIGS_NOTES', 'See your Notes');
define('_MD_YOGURT_CONFIGS_NOTESSEND', 'Send you Notes');
define('_MD_YOGURT_CONFIGS_FRIENDS', 'See your Friends');
define('_MD_YOGURT_CONFIGS_PROFILECONTACT', 'See your contact info');
define('_MD_YOGURT_CONFIGS_PROFILEGENERAL', 'See your Info');
define('_MD_YOGURT_CONFIGS_PROFILESTATS', 'See your Stats');
define('_MD_YOGURT_WHOCAN', 'Who can:');

//submitConfigs.php
define('_MD_YOGURT_CONFIGS_SAVE', 'Configuration saved!');
define('_MD_YOGURT_CONFIGS_SAVE_FAILED', 'ERROR: Configuration has not been saved');

//class/yogurt_controller.php
define(
    '_MD_YOGURT_NOPRIVILEGE',
    "The owner of this profile has set the privileges to see it, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it."
);

###################################### OTHERS ##############################

//index.php
define('_MD_YOGURT_VISITORS', 'Visitors (who visited your profile recently)');
define('_MD_YOGURT_USER_DETAILS', 'Member Details');
define('_MD_YOGURT_USER_CONTRIBUTIONS', 'Member Contributions');
define('_MD_YOGURT_FANS', 'Fans');
define('_MD_YOGURT_UNKNOWN_REJECTING', "I don't know this person, Do not add them to my friends list");
define('_MD_YOGURT_UNKNOWN_ACCEPTING', "I don't know this person, Yet add them to my friends list");
define('_MD_YOGURT_ASKINGFRIEND', 'Is %s your friend?');
define('_MD_YOGURT_ASKBEFRIEND', 'Ask this user to be your friend?');
define('_MD_YOGURT_EDITPROFILE', 'Edit Profile');
define('_MD_YOGURT_SELECTAVATAR', 'Upload pictures to your album and select one as your avatar.');
define('_MD_YOGURT_SELECTMAINVIDEO', 'Then you can select a video to feature in your profile page');
define('_MD_YOGURT_NOAVATARYET', 'No avatar yet');
define('_MD_YOGURT_NOMAINVIDEOYET', 'No featured video yet');
define('_MD_YOGURT_MYPROFILE', 'My Profile');
define('_MD_YOGURT_YOUHAVEXFRIENDREQUESTS', 'You have %u requests for friendship.');
define('_MD_YOGURT_CONTACTINFO', 'Contact Info');
define('_MD_YOGURT_SUSPENDUSER', 'Suspend User');
define('_MD_YOGURT_SUSPEND', 'Suspend');
define('_MD_YOGURT_SUSPENDTIME', 'Time of suspension(in secs)');
define('_MD_YOGURT_UNSUSPEND', 'Unsuspend ');
define('_MD_YOGURT_SUSPENSIONADMIN', 'Suspension Admin Tools');
define('_MD_YOGURT_USER_PERSONAL', 'Personal');
define('_MD_YOGURT_ACTIVITY', 'Activity');
define('_MD_YOGURT_COMMUNITY', 'Community');

//suspend.php
define('_MD_YOGURT_SUSPENDED', 'User under suspension until %s');
define('_MD_YOGURT_USER_SUSPENDED', 'User suspended!'); //als0 present in index.php

//unsuspend.php
define('_MD_YOGURT_USER_UNSUSPENDED', 'User Unsuspended');

//searchmembers.php
define('_MD_YOGURT_SEARCH', 'Search Members');
define('_MD_YOGURT_AVATAR', 'Avatar');
define('_MD_YOGURT_REALNAME', 'Real Name');
define('_MD_YOGURT_REGDATE', 'Joined Date');
define('_MD_YOGURT_EMAIL', 'Email');
define('_MD_YOGURT_PM', 'PM');
define('_MD_YOGURT_URL', 'URL');
define('_MD_YOGURT_ADMIN', 'Admin');
define('_MD_YOGURT_PREVIOUS', 'Previous');
define('_MD_YOGURT_NEXT', 'Next');
define('_MD_YOGURT_USER_SFOUND', '%s member(s) found');
define('_MD_YOGURT_TOTALUSERS', 'Total Members');
define('_MD_YOGURT_NOFOUND', 'No Members Found');
define('_MD_YOGURT_UNAME', 'User Name');
define('_MD_YOGURT_LOCATION_CONTAINS', 'Location contains');
define('_MD_YOGURT_OCCUPATION_CONTAINS', 'Occupation contains');
define('_MD_YOGURT_INTEREST_CONTAINS', 'Interest contains');
define('_MD_YOGURT_URL_CONTAINS', 'URL contains');
define('_MD_YOGURT_LASTLOGMORE', "Last login is more than <span style='color:#ff0000;'>X</span> days ago");
define('_MD_YOGURT_LASTLOGLESS', "Last login is less than <span style='color:#ff0000;'>X</span> days ago");
define('_MD_YOGURT_REGMORE', "Joined date is more than <span style='color:#ff0000;'>X</span> days ago");
define('_MD_YOGURT_REGLESS', "Joined date is less than <span style='color:#ff0000;'>X</span> days ago");
define('_MD_YOGURT_POSTSMORE', "Number of Posts is greater than <span style='color:#ff0000;'>X</span>");
define('_MD_YOGURT_POSTSLESS', "Number of Posts is less than <span style='color:#ff0000;'>X</span>");
define('_MD_YOGURT_SORT', 'Sort by');
define('_MD_YOGURT_ORDER', 'Order');
define('_MD_YOGURT_LASTLOGIN', 'Last login');
define('_MD_YOGURT_POSTS', 'Number of posts');
define('_MD_YOGURT_ASC', 'Ascending order');
define('_MD_YOGURT_DESC', 'Descending order');
define('_MD_YOGURT_LIMIT', 'Number of members per page');
define('_MD_YOGURT_RESULTS', 'Search results');

//26/10/2007
define('_MD_YOGURT_VIDEOS_ENABLED_NOT', 'The administrator of the site has disabled videos feature');
define('_MD_YOGURT_FRIENDS_ENABLED_NOT', 'The administrator of the site has disabled friends feature');
define('_MD_YOGURT_GROUPS_ENABLED_NOT', 'The administrator of the site has disabled groups feature');
define('_MD_YOGURT_PICTURES_ENABLED_NOT', 'The administrator of the site has disabled pictures feature');
define('_MD_YOGURT_NOTES_ENABLED_NOT', 'The administrator of the site has disabled Notes feature');

//26/01/2008
define('_MD_YOGURT_ALLFRIENDS', 'View all friends');
define('_MD_YOGURT_ALLGROUPS', 'View all groups');

//31/01/2008
define('_MD_YOGURT_FRIENDSHIP_NOTACCEPTED', 'Friendship rejected');

//07/04/2008
define('_MD_YOGURT_USER_DOESNTEXIST', "This user doesn't exist or was deleted");
define('_MD_YOGURT_FANSTITLE', "%s's Fans");
define('_MD_YOGURT_NOFANSYET', 'No fans yet');

//17/04/2008
define('_MD_YOGURT_AUDIO_ENABLED_NOT', 'The administrator of the site has disabled audio feature');
define('_MD_YOGURT_NOAUDIOYET', "This user hasn't uploaded any audio files yet");
define('_MD_YOGURT_AUDIOS', 'Audio');
define('_MD_YOGURT_CONFIGS_AUDIOS', 'See your Audio files');
define('_MD_YOGURT_UPLOADEDAUDIO', 'Audio file uploaded');

define('_MD_YOGURT_AUDIO_SELECT', 'Browse for your mp3 file');
define('_MD_YOGURT_AUDIO_AUTHOR', 'Author/Singer');
define('_MD_YOGURT_AUDIO_TITLE', 'Title of file or song');
define('_MD_YOGURT_AUDIO_ADD', 'Add an mp3 file');
define('_MD_YOGURT_AUDIO_SUBMIT', 'Upload file');
define(
    '_MD_YOGURT_AUDIO_ADD_HELP',
    'Choose an mp3 file on your computer, max size %s .'
);

//19/04/2008
define('_MD_YOGURT_AUDIO_DELETED', 'Your mp3 file was deleted!');
define('_MD_YOGURT_AUDIO_DELETE_CONFIRM_ASK', 'Do you really want to delete your audio file?');
define('_MD_YOGURT_AUDIO_DELETE_CONFIRM', 'Yes please delete it!');

define('_MD_YOGURT_META', 'Meta Info');
define('_MD_YOGURT_META_TITLE', 'Title');
define('_MD_YOGURT_META_ALBUM', 'Album');
define('_MD_YOGURT_META_ARTIST', 'Artist');
define('_MD_YOGURT_META_YEAR', 'Year');

// v3.3RC2
define('_MD_YOGURT_PLAYER', 'Your audio player');

// 3.5
define('_MD_YOGURT_ADDFRIEND', 'Add Friend');
define('_MD_YOGURT_FRIENDREQUEST_PENDING', 'Friend Request Pending');
define('_MD_YOGURT_MYFRIEND', 'Friend');
define('_MD_YOGURT_FRIENDREQUEST_SENT', 'Friend Request Sent');
define('_MD_YOGURT_FRIENDREQUEST_CANCEL', 'Cancel Friend Request');
define('_MD_YOGURT_FRIENDSHIP_STATUS', 'Friendship Status');
define('_MD_YOGURT_PROFILEVISITORS', 'Profile Visitors');
define('_MD_YOGURT_VIDEO_FEATURED', 'Featured Video');
define('_MD_YOGURT_ALLVIDEOS', 'View all videos');
define('_MD_YOGURT_OWNEROFGROUP', 'Group Owner');
define('_MD_YOGURT_MEMBERSLIST', 'Members List');
define('_MD_YOGURT_LATESTMEMBER', 'Latest Member');
define('_MD_YOGURT_MEMBERSLISTSECTION', 'Welcome to Members List');
define('_MD_YOGURT_NEVERLOGIN', 'Never Login');
define('_MD_YOGURT_MEMBERSINCE', 'Member Since');
define('_MD_YOGURT_CONTACT', 'Contact');
define('_MD_YOGURT_RANK', 'Rank');
define('_MD_YOGURT_FRIEND_ACCEPT', 'Accept');
define('_MD_YOGURT_FRIEND_REJECT', 'Reject');
define('_MD_YOGURT_ONLINESTATUS', 'Online Status');
define('_MD_YOGURT_ONLINE', 'Online');
define('_MD_YOGURT_OFFLINE', 'Offline');
define('_MD_YOGURT_SIGNATURE', 'Signature');
define('_MD_YOGURT_BIOGRAPHY', 'Biography');
define('_MD_YOGURT_EXTRAINFO', 'Extra Information');
define('_MD_YOGURT_GROUP', 'Group');
define('_MD_YOGURT_PRIVATEMESSAGE', 'Private Message');
define('_MD_YOGURT_WEBSITE', 'Website');
define('_MD_YOGURT_WWW', 'WWW');
define('_MD_YOGURT_LOCATION', 'Location');
define('_MD_YOGURT_OCCUPATION', 'Occupation');
define('_MD_YOGURT_INTEREST', 'Interest');
define('_MD_YOGURT_MYAUDIOS', 'My Audios');
define('_MD_YOGURT_MYFANS', 'My Fans');
define('_MD_YOGURT_EXTRAINFO_CONTAINS', 'Extra Info Contains');
define('_MD_YOGURT_BIOGRAPHYINFO_CONTAINS', 'Biography Contains');
define('_MD_YOGURT_SIGNATURE_CONTAINS', 'Signature Contains');
define('_MD_YOGURT_MEMBEROFGROUP', 'Member');
define('_MD_YOGURT_RECENTNOTES', 'Recent Notes');
define('_MD_YOGURT_LATESTNOTES', 'Latest Notes by Members');
define('_MD_YOGURT_EDIT', 'Edit');
define('_MD_YOGURT_DESCRIPTION', 'Description');
define('_MD_YOGURT_AVAILABLEGROUPS', 'All Groups');
define('_MD_YOGURT_GROUPSLIST', 'Groups List');
define('_MD_YOGURT_NOMATCHGROUP', 'No Match Found for your Query. ');
//users
define('_MD_YOGURT_USER_NAME', 'Username');
define('_MD_YOGURT_PASSWORD', 'Password');
define('_MD_YOGURT_REMEMBERME', 'Remember Me');
define('_MD_YOGURT_LOGIN', 'Login');
define('_MD_YOGURT_USER_LOGIN', 'Members Login');
define('_MD_YOGURT_LOSTPASSWORD', 'Lost Your Password ?');
define('_MD_YOGURT_NOPROBLEM', 'No problem. Simply enter the e-mail address we have on file for your account.');
define('_MD_YOGURT_NOTREGISTERED', 'Not registered? Click.');
define('_MD_YOGURT_SENDPASSWORD', 'Send Password.');
define('_MD_YOGURT_YOURUSERNAME', 'Your Username');
define('_MD_YOGURT_YOURPASSWORD', 'Your Password.');
define('_MD_YOGURT_YOUREMAIL', 'Your Email');
define('_MD_YOGURT_SIGNUP', 'Sign Up Now !');
define('_MD_YOGURT_NOTAMEMBER', 'Not a member?');
define('_MD_YOGURT_SOCIALNETWORK', 'Social Network');
define('_MD_YOGURT_USER_WELCOME', 'Enlarge friends network.');
define('_MD_YOGURT_JOINUS', 'Join our community today and start to search for new friends!');
define('_MD_YOGURT_FINDFRIENDS', 'Find Friends');
define('_MD_YOGURT_FINDMOREFRIENDS', 'Find More Friends');
define('_MD_YOGURT_METAINFOHELP', 'Leave title and author fields blank if your file has metainfo already');
define('_MD_YOGURT_GROUPDESCRIPTION', 'Group Description');
define('_MD_YOGURT_PRIVATEPHOTO', 'Private Photo');
define('_MD_YOGURT_FRIENDSHIP_SETTINGS', 'Friend Settings');
define('_MD_YOGURT_FRIENDSHIP_DELETE', 'Delete Friend ');
define('_MD_YOGURT_FRIENDREQUEST_CANCELLED', 'You have cancel your friendship request with this user!');
define('_MD_YOGURT_GROUPTOTALMEMBERS', 'Group Total Members');
define('_MD_YOGURT_GROUPDATECREATED', 'Founded Date');
define('_MD_YOGURT_GROUPMEMBERS', 'member(s)');

//Data Tables
define('_MD_YOGURT_DTABLE_DECIMAL', '');
define('_MD_YOGURT_DTABLE_EMPTYTABLE', 'No data available in table');
define('_MD_YOGURT_DTABLE_INFOSHOWING', 'Showing');
define('_MD_YOGURT_DTABLE_INFOTO', 'to');
define('_MD_YOGURT_DTABLE_INFOOF', 'of');
define('_MD_YOGURT_DTABLE_INFOENTRIES', 'entries');
define('_MD_YOGURT_DTABLE_INFOEMPTY', 'Showing 0 to 0 of 0 entries');
define('_MD_YOGURT_DTABLE_INFOFILTEREDFROM', 'filtered from');
define('_MD_YOGURT_DTABLE_INFOFILTEREDTOTALENTRIES', 'total entries');
define('_MD_YOGURT_DTABLE_INFOPOSTFIX', '');
define('_MD_YOGURT_DTABLE_THOUSANDS', ',');
define('_MD_YOGURT_DTABLE_LENGTHMENUSHOW', 'Show');
define('_MD_YOGURT_DTABLE_LENGTHMENUENTRIES', 'entries');
define('_MD_YOGURT_DTABLE_LOADINGRECORDS', 'Loading...');
define('_MD_YOGURT_DTABLE_PROCESSING', 'Processing...');
define('_MD_YOGURT_DTABLE_SEARCH', 'Search');
define('_MD_YOGURT_DTABLE_ZERORECORDS', 'No matching records found');
define('_MD_YOGURT_DTABLE_FIRST', 'First');
define('_MD_YOGURT_DTABLE_LAST', 'Last');
define('_MD_YOGURT_DTABLE_NEXT', 'Next');
define('_MD_YOGURT_DTABLE_PREVIOUS', 'Previous');
define('_MD_YOGURT_DTABLE_SORT_ASCENDING', ': activate to sort column ascending');
define('_MD_YOGURT_DTABLE_SORT_DESCENSING', ': activate to sort column descending');

define('_MD_YOGURT_CANTVOTEOWN', 'You can not vote for yourself');
define('_MD_YOGURT_VOTED', 'Vote');
define('_MD_YOGURT_ALREADYVOTED', 'Sorry, you have already voted once.');

//Profile Module
define('_MD_YOGURT_DISPLAYNAME', 'Display Name');
define('_MD_YOGURT_SORTBY', 'Sort by');
define('_MD_YOGURT_PERPAGE', 'Items per page');
define('_MD_YOGURT_LATERTHAN', ' %s  is later than');
define('_MD_YOGURT_EARLIERTHAN', ' %s  is earlier than');
define('_MD_YOGURT_LARGERTHAN', ' %s  is greater than');
define('_MD_YOGURT_SMALLERTHAN', ' %s  is smaller than');
define('_MD_YOGURT_REGISTER_NOTGROUP', 'New user is not registered to corresponding groups.');
define('_MD_YOGURT_FINISH_LOGIN', 'Your account has been created successfully, please click to log on.');
define('_MD_YOGURT_REGISTER_FINISH', 'Thanks for registering');
define('_MD_YOGURT_REGISTER_STEPS', 'Register steps:');
define('_MD_YOGURT_DEFAULT', 'Basic Information');
define('_MD_YOGURT_ERRORDURINGSAVE', 'Error during save');
define('_MD_YOGURT_NOSTEPSAVAILABLE', 'Registration is not allowed at this moment, please come back later.');
define('_MD_YOGURT_EXPIRED', 'The process has been expired, please go back to try again.');
define('_MD_YOGURT_RECENTACTIVITY', 'Recent Activities');
define('_MD_YOGURT_THEME', 'Theme');
define('_MD_YOGURT_ACTIVATE', 'Activate');
define('_MD_YOGURT_DEACTIVATE', 'Deactivate');
define('_MD_YOGURT_SENDPM', 'Send Message');
define('_MD_YOGURT_CHANGEPASSWORD', 'Change Password');
define('_MD_YOGURT_PASSWORDCHANGED', 'Password Changed Successfully');
define('_MD_YOGURT_OLDPASSWORD', 'Current Password');
define('_MD_YOGURT_NEWPASSWORD', 'New Password');
define('_MD_YOGURT_WRONGPASSWORD', 'Old password is wrong');
define('_MD_YOGURT_CHANGEMAIL', 'Change Email Address');
define('_MD_YOGURT_NEWMAIL', 'New Email Address');
define('_MD_YOGURT_NEWEMAIL', 'New email address at %s');
define('_MD_YOGURT_EMAILCHANGED', 'Your Email Address Has Been Changed');
define('_MD_YOGURT_SITEDEFAULT', 'Site default');
define('_MD_YOGURT_USERINFO', 'User profile');
define('_MD_YOGURT_REGISTER', 'Registration form');
define('_MD_YOGURT_ACTUS', 'Active Users: %s');
define('_MD_YOGURT_FOUNDUSER', '%s users found');
define('_MD_YOGURT_USERLEVEL', 'Status');
define('_MD_YOGURT_ACTIVE', 'Active');
define('_MD_YOGURT_INACTIVE', 'Inactive');
define('_MD_YOGURT_NICKNAME', 'Username');
define('_MD_YOGURT_EMAILADDRESS', 'Email Address');
define('_MD_YOGURT_SAVECHANGES', 'Submit');
define('_MD_YOGURT_USERGROUPS', 'Users Groups');
define('_MD_YOGURT_CONFIRMPASSWORD', 'Type again to confirm your password');
define('_MD_YOGURT_LOGOUT', 'Logout');
define('_MD_YOGURT_CHANGEAVATAR', 'Change Avatar');
define('_MD_YOGURT_CHANGEAVATARHELP', 'You can also change your avatar by selecting any of the photos upload in your photo album section.');

