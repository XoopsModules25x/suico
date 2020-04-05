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
define('_MI_YOGURT_NUMBPICT_TITLE', 'Number of Pictures');
define('_MI_YOGURT_NUMBPICT_DESC', 'Number of pictures a user can have in their page');
define('_MI_YOGURT_ADMENU1', 'Home');
define('_MI_YOGURT_ADMENU2', 'About');
define('_MI_YOGURT_SMNAME1', 'Submit');
define('_MI_YOGURT_THUMW_TITLE', 'Thumb Width');
define('_MI_YOGURT_THUMBW_DESC', 'Thumbnails width in pixels<br>This means your picture thumbnail will be<br>most of this size in width<br>All proportions are maintained');
define('_MI_YOGURT_THUMBH_TITLE', 'Thumb Height');
define('_MI_YOGURT_THUMBH_DESC', 'Thumbnails Height in pixels<br>This means your picture thumbnail will be<br>most of this size in height<br>All proportions are maintained');
define('_MI_YOGURT_RESIZEDW_TITLE', 'Resized picture width');
define('_MI_YOGURT_RESIZEDW_DESC', 'Resized picture width in pixels<br>This means your picture will be<br>most of this size in width<br>All proportions are maintained<br> The original picture if bigger than this size will <br>be resized, so it wont break your template');
define('_MI_YOGURT_RESIZEDH_TITLE', 'Resized picture height');
define('_MI_YOGURT_RESIZEDH_DESC', 'Resized picture height in pixels<br>This means your picture will be<br>most of this size in height<br>All proportions are maintained<br> The original picture if bigger than this size will <br>be resized, so it wont break your template design');
define('_MI_YOGURT_ORIGINALW_TITLE', 'Max original picture width');
define('_MI_YOGURT_ORIGINALW_DESC', "Maximum original picture width in pixels<br>This means the user's original picture can't exceed <br>this size in height<br> else it won't be uploaded");
define('_MI_YOGURT_ORIGINALH_TITLE', 'Max original picture height');
define('_MI_YOGURT_ORIGINALH_DESC', "Maximum original picture height in pixels<br>This means the user's original picture can't exceed <br>this size in height<br> else it won't be uploaded");
define('_MI_YOGURT_PATHUPLOAD_TITLE', 'Path Uploads');
define('_MI_YOGURT_PATHUPLOAD_DESC', 'Path to the uploads directory<br>in Linux it should look like this /var/www/uploads<br>in Windows like this C:/Program Files/www');
define('_MI_YOGURT_LINKPATHUPLOAD_TITLE', 'Link to your uploads directory');
define('_MI_YOGURT_LINKPATHUPLOAD_DESC', 'This is the address of the root path to uploads <br>like http://www.yoursite.com/uploads');
define('_MI_YOGURT_MAXFILEBYTES_TITLE', 'Max size in bytes');
define('_MI_YOGURT_MAXFILEBYTES_DESC', 'This is the maximum size a picture file can be<br> You can set it in bytes like this: 512000 for 500 KB<br> Be careful that the maximum size is also set in the php.ini file. The server is currently set to ' . ini_get('post_max_size'));

define('_MI_YOGURT_PICTURE_NOTIFYTIT', 'Album');
define('_MI_YOGURT_PICTURE_NOTIFYDSC', "Notifications related to user's album");
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFY', 'New Picture');
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFYCAP', 'Tell me when this user submits a new picture');
define('_MI_YOGURT_PICTURE_NEWPOST_NOTIFYDSC', 'Tell me when this user submits a new picture');
define('_MI_YOGURT_PICTURE_NEWPIC_NOTIFYSBJ', '{X_OWNER_NAME} has submitted a new picture to their album');
//define("_MI_YOGURT_HOTTEST","Hottest Albums");
//define("_MI_YOGURT_HOTTEST_DESC","This block will show the hottest albums");
//define("_MI_YOGURT_HOTFRIENDS","Hot Friends");
//define("_MI_YOGURT_HOTFRIENDS_DESC","This block shows the users hot friends that have been added");
define('_MI_YOGURT_PICTURE_TEMPLATEINDEXDESC', 'This template shows the pictures of the user');
define('_MI_YOGURT_PICTURE_TEMPLATEFRIENDSDESC', 'This template shows the friends of the user');
define('_MI_YOGURT_MYFRIENDS', 'My Friends');
define('_MI_YOGURT_FRIENDSPERPAGE_TITLE', 'Friends per page');
define('_MI_YOGURT_FRIENDSPERPAGE_DESC', 'Set the number of friends to show per page<br>In the my Friends page');
define('_MI_YOGURT_PICTURESPERPAGE_TITLE', 'Pictures showing per page before pagination');

define('_MI_YOGURT_LAST', 'Last pictures block');
define('_MI_YOGURT_LAST_DESC', 'Last pictures sent independently of the album');
define('_MI_YOGURT_DELETEPHYSICAL_TITLE', 'DELETE files FROM the upload folder TO');
define(
    '_MI_YOGURT_DELETEPHYSICAL_DESC',
    "Confirming yes here, will allow the script to delete the files from the uploaded data in the database as well.<br> Be careful about this feature, if you exclude the files from the folder and not only in the database, some people who may have linked to the image directly in another part of the site may also lose their content;<br> at the same time if you don't exclude them, you may use to much space in the server hard disk.<br>Configure this item well for your needs."
);

define('_MI_YOGURT_MYVIDEOS', 'My Videos');
define('_MI_YOGURT_PICTURE_TEMPLATEALBUMDESC', 'Template for the picture gallery');
define('_MI_YOGURT_MYPICTURES', 'My Photos');
define('_MI_YOGURT_MODULEDESC', 'This module simulates a social network software like MySpace or Orkut.');
define('_MI_YOGURT_TUBEW_TITLE', 'Width of the YouTube videos');
define('_MI_YOGURT_TUBEW_DESC', 'The width in pixels of the YouTube video player');
define('_MI_YOGURT_TUBEH_TITLE', 'Height of the YouTube videos');
define('_MI_YOGURT_TUBEH_DESC', 'The height in pixels of the YouTube video player');
define('_MI_YOGURT_PICTURE_TEMPLATENOTEBOOKDESC', 'Template for the Notebook');
define('_MI_YOGURT_PICTURE_TEMPLATESEUTUBODESC', 'Template for the videos section');
define('_MI_YOGURT_PICTURE_TEMPLATEGROUPSDESC', 'Template for the Groups');
define('_MI_YOGURT_MYNOTES', 'My Notes');
define('_MI_YOGURT_MYGROUPS', 'My Groups');
define('_MI_YOGURT_TEMPLATENAVBARDESC', 'Template for the upper navbar used in all pages');

define('_MI_YOGURT_VIDEOSPERPAGE_TITLE', 'Videos per Page');
define('_MI_YOGURT_VIDEO_NOTIFYTIT', 'Videos');
define('_MI_YOGURT_VIDEO_NOTIFYDSC', 'Video notifications');
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFY', 'New video');
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYCAP', 'Notify me when a new video is submitted by this user');
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYDSC', 'New video notify description');
define('_MI_YOGURT_VIDEO_NEWVIDEO_NOTIFYSBJ', '{X_OWNER_NAME} has submitted a new video to their profile');

define('_MI_YOGURT_NOTE_NOTIFYTIT', 'Notes');
define('_MI_YOGURT_NOTE_NOTIFYDSC', 'Notebook notifications');
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFY', 'New Note');
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYCAP', 'Notify me when a new Note is sent to this Notebook');
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYDSC', 'New Note notification description');
define('_MI_YOGURT_NOTE_NEWNOTE_NOTIFYSBJ', '{X_OWNER_NAME} has received a new Note into their Notebook');

define('_MI_YOGURT_MAINTUBEW_TITLE', 'Main Video width');
define('_MI_YOGURT_MAINTUBEW_DESC', 'Width of the video, which shows in the front page of the module');
define('_MI_YOGURT_MAINTUBEH_TITLE', 'Main Video height');
define('_MI_YOGURT_MAINTUBEH_DESC', 'Height of the video, that shows in the front page of the module');

//24/09/2007
define('_MI_YOGURT_MYCONFIGS', 'My Settings');
define('_MI_YOGURT_PICTURE_TEMPLATECONFIGSDESC', 'Template settings for the user');
define('_MI_YOGURT_PICTURE_TEMPLATEFOOTERDESC', 'Template for the footer of the module');
define('_MI_YOGURT_PICTURE_TEMPLATEEDITGROUP', 'Template for the Groups page atributes');
define('_MI_YOGURT_LICENSE', 'Yogurt by Marcello Brand�o is licensed under a Attribution-No Derivative Works 2.5 Brazil.');

//19/10/2007
define('_MI_YOGURT_GROUPSPERPAGE_TITLE', 'Groups per page');
define('_MI_YOGURT_GROUPSPERPAGE_DESC', 'Groups per page before pagination show up');
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHRESULTDESC', 'This template shows the results of a search for comunities');
define('_MI_YOGURT_PICTURE_TEMPLATEGROUPDESC', 'This template shows a Group and its members');

//22/10/2007
define('_MI_YOGURT_MYPROFILE', 'My Profile');
define('_MI_YOGURT_SEARCH', 'Search Members');
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHRESULTSDESC', 'Template for the search results');
define('_MI_YOGURT_PICTURE_TEMPLATESEARCHFORMDESC', 'Template for the search form');

//26/10/2007
define('_MI_YOGURT_ENABLEPICT_TITLE', 'Enable pictures section');
define('_MI_YOGURT_ENABLEPICT_DESC', 'Enabling the pictures section for the users, will enable the pictures gallery');
define('_MI_YOGURT_ENABLEFRIENDS_TITLE', 'Enable friends section');
define('_MI_YOGURT_ENABLEFRIENDS_DESC', 'Enabling friends section for the users, will enable friends agenda');
define('_MI_YOGURT_ENABLEVIDEOS_TITLE', 'Enable videos section');
define('_MI_YOGURT_ENABLEVIDEOS_DESC', 'Enabling videos section for the users, will enable the video gallery');
define('_MI_YOGURT_ENABLENOTES_TITLE', 'Enable Notes section');
define('_MI_YOGURT_ENABLENOTES_DESC', 'Enabling Notes section, will enable members to leave public messages to other users. This feature is like the Wall on Facebook');
define('_MI_YOGURT_ENABLEGROUPS_TITLE', 'Enable Groups section');
define('_MI_YOGURT_ENABLEGROUPS_DESC', 'Enabling Groups section for the users, will enable them to create Groups, which group users that have similar interests');
define('_MI_YOGURT_NOTESPERPAGE_TITLE', 'Number of Notes per page');
define('_MI_YOGURT_NOTESPERPAGE_DESC', 'Number of Notes in a page before the page navigation shows ');

//25/11/2007
define('_MI_YOGURT_FRIENDS', 'My Friends');
define('_MI_YOGURT_FRIENDS_DESC', 'This block shows the user friends');

//26/01/2008
define('_MI_YOGURT_IMGORDER_TITLE', 'Pictures Order');
define('_MI_YOGURT_IMGORDER_DESC', 'Show the newest pictures first?');

//08/04/2008
define('_MI_YOGURT_PICTURE_TEMPLATENOTIFICATIONS', 'Template for the notifications');

//11/04/2008
define('_MI_YOGURT_FRIENDSHIP_NOTIFYTIT', 'Friendships');
define('_MI_YOGURT_FRIENDSHIP_NOTIFYDSC', 'Petitions of friendship');
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFY', 'Petition');
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYCAP', 'Notify me when someone ask for friendship');
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYDSC', 'Notify me when someone ask for friendship');
define('_MI_YOGURT_FRIEND_NEWPETITION_NOTIFYSBJ', 'Someone has just asked to be your friend');

//13/04/2008
define('_MI_YOGURT_PICTURE_TEMPLATEFANS', 'Template for the fans page');
