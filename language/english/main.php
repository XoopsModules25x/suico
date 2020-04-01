<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author       Marcello Brandão aka  Suico
 * @author       XOOPS Development Team
 * @since
 */
//Present in many files (videos pictures etc...)
define('_MD_YOGURT_DELETE', 'Delete');
define('_MD_YOGURT_EDITDESC', 'Edit description');
define('_MD_YOGURT_TOKENEXPIRED', 'Your Security Token has Expired<br>Please Try Again');
define('_MD_YOGURT_DESC_EDITED', 'The description was edited successfully');
define('_MD_YOGURT_CAPTION', 'Caption');
define('_MD_YOGURT_YOUCANUPLOAD', "You can only upload jpg's files and up to %s KBytes in size");
define('_MD_YOGURT_UPLOADPICTURE', 'Upload Picture');
define(
    '_MD_YOGURT_NOCACHACA',
    'Bad, Bad Module...No cacha�a for you!<br>
Unfortunately, this module has acted in an unexpected way. Hopefully it will return to its helpful self if you try again. '
); //Funny general error message
define('_MD_YOGURT_PAGETITLE', "%s - %s's Social Network");
define('_MD_YOGURT_SUBMIT', 'Submit');
define('_MD_YOGURT_VIDEOS', 'Videos');
define('_MD_YOGURT_NOTEBOOK', 'Notes');
define('_MD_YOGURT_PHOTOS', 'Photos');
define('_MD_YOGURT_FRIENDS', 'Friends');
define('_MD_YOGURT_TRIBES', 'Tribes');
define('_MD_YOGURT_NOTRIBESYET', 'No Tribes yet');
define('_MD_YOGURT_MYTRIBES', 'My Tribes');
define('_MD_YOGURT_ALLTRIBES', 'All Tribes');
define('_MD_YOGURT_PROFILE', 'Profile');
define('_MD_YOGURT_HOME', 'Home');
define('_MD_YOGURT_CONFIGSTITLE', 'My settings');

##################################################### PICTURES #######################################################
//submit.php (for pictures submission
define('_MD_YOGURT_UPLOADED', 'Upload Successful');


//delpicture.php
define('_MD_YOGURT_ASKCONFIRMDELETION', 'Are you sure you want to delete this picture?');
define('_MD_YOGURT_CONFIRMDELETION', 'Yes please delete it!');

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
define('_MD_YOGURT_FRIENDSHIPCONFIGS', 'Set the configs of this friendship. Evaluate your friend.');

//class/yogurtfriendship.php
define('_MD_YOGURT_EDITFRIENDSHIP', 'Your friendship with this member:');
define('_MD_YOGURT_FRIENDNAME', 'Username');
define('_MD_YOGURT_LEVEL', 'Friendship level:');
define('_MD_YOGURT_UNKNOWNACCEPTED', "Haven't met accepted");
define('_MD_YOGURT_AQUAITANCE', 'Acquaintances'); //also present in index.php
define('_MD_YOGURT_FRIEND', 'Friend'); //also present in index.php
define('_MD_YOGURT_BESTFRIEND', 'Best Friend'); //also present in index.php
define('_MD_YOGURT_FAN', 'Fan'); //also present in index.php
define('_MD_YOGURT_SEXY', 'Sexy'); //also present in index.php
define('_MD_YOGURT_SEXYNO', 'Nope');
define('_MD_YOGURT_SEXYYES', 'Yes');
define('_MD_YOGURT_SEXYALOT', 'Very much!');
define('_MD_YOGURT_TRUSTY', 'Trusty');
define('_MD_YOGURT_TRUSTYNO', 'Nope');
define('_MD_YOGURT_TRUSTYYES', 'Yes');
define('_MD_YOGURT_TRUSTYALOT', 'Very much');
define('_MD_YOGURT_COOL', 'Cool');
define('_MD_YOGURT_COOLNO', 'Nope');
define('_MD_YOGURT_COOLYES', 'Yes');
define('_MD_YOGURT_COOLALOT', 'Very much');
define('_MD_YOGURT_PHOTO', "Friend's Photo");
define('_MD_YOGURT_UPDATEFRIEND', 'Update Friendship');

//editfriendship.php
define('_MD_YOGURT_FRIENDSHIPUPDATED', 'Friendship Updated');

//submitfriendpetition.php
define('_MD_YOGURT_PETITIONED', 'A friend request has been sent to this user, Wait until he accepts to have him in your friends list.');
define('_MD_YOGURT_ALREADY_PETITIONED', 'You have already sent a friendship request to this user or vice-versa <br>, Wait untill he accepts or rejects it or check if he has asked you as a friend visiting your profile page.');

//makefriends.php
define('_MD_YOGURT_FRIENDMADE', 'Added as a friend!');

//delfriendship.php
define('_MD_YOGURT_FRIENDSHIPTERMINATED', 'You have broken your friendship with this user!');

############################################ VIDEOS ############################################################
//mainvideo.php
define('_MD_YOGURT_SETMAINVIDEO', 'This video is selected on your front page from now on');

//video.php
define('_MD_YOGURT_YOUTUBECODE', 'YouTube code or URL');
define('_MD_YOGURT_ADDVIDEO', 'Add video');
define('_MD_YOGURT_ADDFAVORITEVIDEOS', 'Add favourite videos');
define(
    '_MD_YOGURT_ADDVIDEOSHELP',
    'If you want to upload your own video for sharing, then upload your videos to
<a href=http://www.youtube.com>YouTube</a> and then add the URL to here '
); //The name of the site will show after this
define('_MD_YOGURT_MYVIDEOS', 'My Videos');
define('_MD_YOGURT_MAKEMAIN', 'Make this video your main video');
define('_MD_YOGURT_NOVIDEOSYET', 'No videos yet!');

//delvideo.php
define('_MD_YOGURT_ASKCONFIRMVIDEODELETION', 'Are you sure you want to delete this video?');
define('_MD_YOGURT_CONFIRMVIDEODELETION', 'Yes I am!');
define('_MD_YOGURT_VIDEODELETED', 'Your video was deleted');

//video_submited.php
define('_MD_YOGURT_VIDEOSAVED', 'Your video was saved');

############################## TRIBES ########################################################
//class/Tribes.php
define('_MD_YOGURT_SUBMIT_TRIBE', 'Create a new tribe');
define('_MD_YOGURT_UPLOADTRIBE', 'Save Tribe'); //also present in many ther tribes related
define('_MD_YOGURT_TRIBE_IMAGE', 'Tribe Image'); //also present in many ther tribes related
define('_MD_YOGURT_TRIBE_TITLE', 'Title'); //also present in many ther tribes related
define('_MD_YOGURT_TRIBE_DESC', 'Description'); //also present in many ther tribes related
define('_MD_YOGURTCREATEYOURTRIBE', 'Create your own Tribe!'); //also present in many ther tribes related

//abandontribe.php
define('_MD_YOGURT_ASKCONFIRMABANDONTRIBE', 'Are you sure you want to leave this Tribe?');
define('_MD_YOGURT_CONFIRMABANDON', 'Yes please remove me from this Tribe!');
define('_MD_YOGURT_TRIBEABANDONED', "You don't belong to this Tribe anymore.");

//becomemembertribe.php
define('_MD_YOGURT_YOUAREMEMBERNOW', 'You are now member of this community');
define('_MD_YOGURT_YOUAREMEMBERALREADY', 'You are already a member of this Tribe');

//delete_tribe.php
define('_MD_YOGURT_ASKCONFIRMTRIBEDELETION', 'Are you sure you want to delete this Tribe permanently?');
define('_MD_YOGURT_CONFIRMTRIBEDELETION', 'Yes, please delete this Tribe!');
define('_MD_YOGURT_TRIBEDELETED', 'Tribe deleted!');

//edit_tribe.php
define('_MD_YOGURT_MAINTAINOLDIMAGE', 'Keep this image'); //also present in other tribes related
define('_MD_YOGURT_TRIBEEDITED', 'Tribe edited');
define('_MD_YOGURT_EDIT_TRIBE', 'Edit your Tribe'); //also present in other tribes related
define('_MD_YOGURT_TRIBEOWNER', 'You are the owner of this Tribe!'); //also present in other tribes related
define('_MD_YOGURT_MEMBERSDOFTRIBE', 'Members of Tribe'); //also present in other tribes related

//submit_tribe.php
define('_MD_YOGURT_TRIBE_CREATED', 'Your Tribe was created');

//kickfromtribe.php
define('_MD_YOGURT_CONFIRMKICK', 'Yes kick him out!');
define('_MD_YOGURT_ASKCONFIRMKICKFROMTRIBE', 'Are you sure you want to kick this person out of the Tribe?');
define('_MD_YOGURT_TRIBEKICKED', "You've banished this user from the Tribe, but who knows when he'll try and comeback!");

//Tribes.php
define('_MD_YOGURT_TRIBE_ABANDON', 'Leave this Tribe');
define('_MD_YOGURT_TRIBE_JOIN', 'Join this Tribe and show everyone who you are!');
define('_MD_YOGURT_TRIBE_SEARCH', 'Search a Tribe');
define('_MD_YOGURT_TRIBE_SEARCHKEYWORD', 'Keyword');

######################################### NOTES #####################################################
//notebook.php
define('_MD_YOGURT_ENTERTEXTNOTE', 'Enter Text or Xoops Codes');
define('_MD_YOGURT_SENDNOTE', 'post Note');
define('_MD_YOGURT_ANSWERNOTE', 'Reply'); //also present in configs.php
define('_MD_YOGURT_MYNOTEBOOK', 'My Notebook');
define('_MD_YOGURT_CANCEL', 'Cancel'); //also present in configs.php
define('_MD_YOGURT_NOTETIPS', 'Note tips');
define('_MD_YOGURT_BOLD', 'bold');
define('_MD_YOGURT_ITALIC', 'italic');
define('_MD_YOGURT_UNDERLINE', 'underline');
define('_MD_YOGURT_NONOTESYET', 'No Notes created in this Notebook yet');

//submitNote.php
define('_MD_YOGURT_NOTE_SENT', 'Thanks for participating, Note sent');

//delete_Note.php
define('_MD_YOGURT_ASKCONFIRMNOTEDELETION', 'Are you sure you want to delete this Note?');
define('_MD_YOGURT_CONFIRMNOTEDELETION', 'Yes please delete this Note.');
define('_MD_YOGURT_NOTEDELETED', 'The Note was deleted');

############################ CONFIGS ##############################################
//configs.php
define('_MD_YOGURT_CONFIGSEVERYONE', 'Everyone');
define('_MD_YOGURT_CONFIGSONLYEUSERS', 'Only Registered Members');
define('_MD_YOGURT_CONFIGSONLYEFRIENDS', 'My friends.');
define('_MD_YOGURT_CONFIGSONLYME', 'Only Me');
define('_MD_YOGURT_CONFIGSPICTURES', 'See your Photos');
define('_MD_YOGURT_CONFIGSVIDEOS', 'See your Videos');
define('_MD_YOGURT_CONFIGSTRIBES', 'See your Tribes');
define('_MD_YOGURT_CONFIGSNOTES', 'See your Notes');
define('_MD_YOGURT_CONFIGSNOTESSEND', 'Send you Notes');
define('_MD_YOGURT_CONFIGSFRIENDS', 'See your Friends');
define('_MD_YOGURT_CONFIGSPROFILECONTACT', 'See your contact info');
define('_MD_YOGURT_CONFIGSPROFILEGENERAL', 'See your Info');
define('_MD_YOGURT_CONFIGSPROFILESTATS', 'See your Stats');
define('_MD_YOGURT_WHOCAN', 'Who can:');

//submit_configs.php
define('_MD_YOGURT_CONFIGSSAVE', 'Configuration saved!');
define('_MD_YOGURT_CONFIGSSAVE_FAILED', 'ERROR: Configuration has not been saved');

//class/yogurt_controller.php
define('_MD_YOGURT_NOPRIVILEGE', "The owner of this profile has set the privileges to see it, <br>higher than you have now. <br>Login to become their friend. <br>If they haven't set it, so only they can see, <br>then you will be able to view it.");

###################################### OTHERS ##############################

//index.php
define('_MD_YOGURT_VISITORS', 'Visitors (who visited your profile recently)');
define('_MD_YOGURT_USERDETAILS', 'User details');
define('_MD_YOGURT_USERCONTRIBUTIONS', 'User contributions');
define('_MD_YOGURT_FANS', 'Fans');
define('_MD_YOGURT_UNKNOWNREJECTING', "I don't know this person, Do not add them to my friends list");
define('_MD_YOGURT_UNKNOWNACCEPTING', "I don't know this person, Yet add them to my friends list");
define('_MD_YOGURT_ASKINGFRIEND', 'Is %s your friend?');
define('_MD_YOGURT_ASKBEFRIEND', 'Ask this user to be your friend?');
define('_MD_YOGURT_EDITPROFILE', 'Edit your profile');
define('_MD_YOGURT_SELECTAVATAR', 'Upload pictures to your album and select one as your avatar.');
define('_MD_YOGURT_SELECTMAINVIDEO', 'Add a video to your videos album and then select it as your main video');
define('_MD_YOGURT_NOAVATARYET', 'No avatar yet');
define('_MD_YOGURT_NOMAINVIDEOYET', 'No main video yet');
define('_MD_YOGURT_MYPROFILE', 'My Profile');
define('_MD_YOGURT_YOUHAVEXPETITIONS', 'You have %u requests for friendship.');
define('_MD_YOGURT_CONTACTINFO', 'Contact Info');
define('_MD_YOGURT_SUSPENDUSER', 'Suspend user');
define('_MD_YOGURT_SUSPENDTIME', 'Time of suspension(in secs)');
define('_MD_YOGURT_UNSUSPEND', 'Unsuspend User');
define('_MD_YOGURT_SUSPENSIONADMIN', 'Suspension Admin Tools');

//suspend.php
define('_MD_YOGURT_SUSPENDED', 'User under suspension until %s');
define('_MD_YOGURT_USERSUSPENDED', 'User suspended!'); //als0 present in index.php

//unsuspend.php
define('_MD_YOGURT_USERUNSUSPENDED', 'User Unsuspended');

//searchmembers.php
define('_MD_YOGURT_SEARCH', 'Search Members');
define('_MD_YOGURT_AVATAR', 'Avatar');
define('_MD_YOGURT_REALNAME', 'Real Name');
define('_MD_YOGURT_REGDATE', 'Joined Date');
define('_MD_YOGURT_EMAIL', 'Email');
define('_MD_YOGURT_PM', 'PM');
define('_MD_YOGURT_URL', 'URL');
define('_MD_YOGURT_ADMIN', 'ADMIN');
define('_MD_YOGURT_PREVIOUS', 'Previous');
define('_MD_YOGURT_NEXT', 'Next');
define('_MD_YOGURT_USERSFOUND', '%s member(s) found');
define('_MD_YOGURT_TOTALUSERS', 'Total: %s members');
define('_MD_YOGURT_NOFOUND', 'No Members Found');
define('_MD_YOGURT_UNAME', 'User Name');
define('_MD_YOGURT_ICQ', 'ICQ Number');
define('_MD_YOGURT_AIM', 'AIM Handle');
define('_MD_YOGURT_YIM', 'YIM Handle');
define('_MD_YOGURT_MSNM', 'MSNM Handle');
define('_MD_YOGURT_LOCATION', 'Location contains');
define('_MD_YOGURT_OCCUPATION', 'Occupation contains');
define('_MD_YOGURT_INTEREST', 'Interest contains');
define('_MD_YOGURT_URLC', 'URL contains');
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
define('_MD_YOGURT_VIDEOSNOTENABLED', 'The administrator of the site has disabled videos feature');
define('_MD_YOGURT_FRIENDSNOTENABLED', 'The administrator of the site has disabled friends feature');
define('_MD_YOGURT_TRIBESNOTENABLED', 'The administrator of the site has disabled tribes feature');
define('_MD_YOGURT_PICTURESNOTENABLED', 'The administrator of the site has disabled pictures feature');
define('_MD_YOGURT_NOTESNOTENABLED', 'The administrator of the site has disabled Notes feature');

//26/01/2008
define('_MD_YOG_ALLFRIENDS', 'View all friends');
define('_MD_YOG_ALLTRIBES', 'View all tribes');

//31/01/2008
define('_MD_YOGURT_FRIENDSHIPNOTACCEPTED', 'Friendship rejected');

//07/04/2008
define('_MD_YOGURT_USERDOESNTEXIST', "This user doesn't exist or was deleted");
define('_MD_YOGURT_FANSTITLE', "%s's Fans");
define('_MD_YOGURT_NOFANSYET', 'No fans yet');

//17/04/2008
define('_MD_YOGURT_AUDIONOTENABLED', 'The administrator of the site has disabled audio feature');
define('_MD_YOGURT_NOAUDIOYET', "This user hasn't uploaded any audio files yet");
define('_MD_YOGURT_AUDIOS', 'Audio');
define('_MD_YOGURT_CONFIGSAUDIOS', 'See your Audio files');
define('_MD_YOGURT_UPLOADEDAUDIO', 'Audio file uploaded');

define('_MD_YOGURT_SELECTAUDIO', 'Browse for your mp3 file');
define('_MD_YOGURT_AUTHORAUDIO', 'Author/Singer');
define('_MD_YOGURT_TITLEAUDIO', 'Title of file or song');
define('_MD_YOGURT_ADDAUDIO', 'Add an mp3 file');
define('_MD_YOGURT_SUBMITAUDIO', 'Upload file');
define('_MD_YOGURT_ADDAUDIOHELP', 'Choose an mp3 file on your computer, max size %s ,<br> Leave title and author fields blank if your file has metainfo already');

//19/04/2008
define('_MD_YOGURT_AUDIODELETED', 'Your mp3 file was deleted!');
define('_MD_YOGURT_ASKCONFIRMAUDIODELETION', 'Do you really want to delete your audio file?');
define('_MD_YOGURT_CONFIRMAUDIODELETION', 'Yes please delete it!');

define('_MD_YOGURT_META', 'Meta Info');
define('_MD_YOGURT_META_TITLE', 'Title');
define('_MD_YOGURT_META_ALBUM', 'Album');
define('_MD_YOGURT_META_ARTIST', 'Artist');
define('_MD_YOGURT_META_YEAR', 'Year');

// v3.3RC2
define('_MD_YOGURT_PLAYER', 'Your audio player');
