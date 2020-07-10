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
define(
    '_MI_SUICO_NUMBPICT_TITLE',
    'Number of Pictures'
);
define('_MI_SUICO_NUMBPICT_DESC', 'Number of pictures a user can have in their page');
define('_MI_SUICO_ADMENU1', 'Home');
define('_MI_SUICO_ADMENU2', 'About');
define('_MI_SUICO_SMNAME1', 'Submit');
define('_MI_SUICO_THUMW_TITLE', 'Thumb Width');
define(
    '_MI_SUICO_THUMBW_DESC',
    'Thumbnails width in pixels<br>This means your picture thumbnail will be most of this size in width<br>All proportions are maintained'
);
define('_MI_SUICO_THUMBH_TITLE', 'Thumb Height');
define(
    '_MI_SUICO_THUMBH_DESC',
    'Thumbnails Height in pixels<br>This means your picture thumbnail will be most of this size in height<br>All proportions are maintained'
);
define('_MI_SUICO_RESIZEDW_TITLE', 'Resized picture width');
define(
    '_MI_SUICO_RESIZEDW_DESC',
    'Resized picture width in pixels<br>This means your picture will be most of this size in width<br>All proportions are maintained<br> The original picture if bigger than this size will be resized, so it wont break your template'
);
define('_MI_SUICO_RESIZEDH_TITLE', 'Resized picture height');
define(
    '_MI_SUICO_RESIZEDH_DESC',
    'Resized picture height in pixels<br>This means your picture will be most of this size in height<br>All proportions are maintained<br> The original picture if bigger than this size will be resized, so it wont break your template design'
);
define('_MI_SUICO_ORIGINALW_TITLE', 'Max original picture width');
define(
    '_MI_SUICO_ORIGINALW_DESC',
    "Maximum original picture width in pixels<br>This means the user's original picture can't exceed this size in height else it won't be uploaded"
);
define('_MI_SUICO_ORIGINALH_TITLE', 'Max original picture height');
define(
    '_MI_SUICO_ORIGINALH_DESC',
    "Maximum original picture height in pixels<br>This means the user's original picture can't exceed this size in height else it won't be uploaded"
);
define('_MI_SUICO_PATHUPLOAD_TITLE', 'Path Uploads');
define(
    '_MI_SUICO_PATHUPLOAD_DESC',
    'Path to the uploads directory<br>in Linux it should look like this /var/www/uploads<br>in Windows like this C:/Program Files/www'
);
define('_MI_SUICO_LINKPATHUPLOAD_TITLE', 'Link to your uploads directory');
define(
    '_MI_SUICO_LINKPATHUPLOAD_DESC',
    'This is the address of the root path to uploads <br>like http://www.yoursite.com/uploads'
);
define('_MI_SUICO_MAXFILEBYTES_TITLE', 'Max size in bytes');
define(
    '_MI_SUICO_MAXFILEBYTES_DESC',
    'This is the maximum size a picture file can be<br> You can set it in bytes like this: 512000 for 500 KB<br> Be careful that the maximum size is also set in the php.ini file. The server is currently set to ' . ini_get('post_max_size')
);
define('_MI_SUICO_PICTURE_NOTIFYTIT', 'Album');
define('_MI_SUICO_PICTURE_NOTIFYDSC', "Notifications related to user's album");
define('_MI_SUICO_PICTURE_NEWPIC_NOTIFY', 'New Picture');
define('_MI_SUICO_PICTURE_NEWPIC_NOTIFYCAP', 'Tell me when this user submits a new picture');
define('_MI_SUICO_PICTURE_NEWPOST_NOTIFYDSC', 'Tell me when this user submits a new picture');
define('_MI_SUICO_PICTURE_NEWPIC_NOTIFYSBJ', '{X_OWNER_NAME} has submitted a new picture to their album');
//define("_MI_SUICO_HOTTEST","Hottest Albums");
//define("_MI_SUICO_HOTTEST_DESC","This block will show the hottest albums");
//define("_MI_SUICO_HOTFRIENDS","Hot Friends");
//define("_MI_SUICO_HOTFRIENDS_DESC","This block shows the users hot friends that have been added");
define(
    '_MI_SUICO_TEMPLATE_INDEXDESC',
    'This template shows the pictures of the user'
);
define('_MI_SUICO_TEMPLATE_FRIENDSDESC', 'This template shows the friends of the user');
define('_MI_SUICO_MYFRIENDS', 'My Friends');
define('_MI_SUICO_FRIENDSPERPAGE_TITLE', 'Friends per page');
define('_MI_SUICO_FRIENDSPERPAGE_DESC', 'Set the number of friends to show per page<br>In the my Friends page');
define('_MI_SUICO_PICTURESPERPAGE_TITLE', 'Pictures showing per page before pagination');
define('_MI_SUICO_LAST', 'Last pictures block');
define('_MI_SUICO_LAST_DESC', 'Last pictures sent independently of the album');
define('_MI_SUICO_DELETEPHYSICAL_TITLE', 'Delete files from the upload folder to');
define(
    '_MI_SUICO_DELETEPHYSICAL_DESC',
    "Confirming yes here, will allow the script to delete the files from the uploaded data in the database as well.<br> Be careful about this feature, if you exclude the files from the folder and not only in the database, some people who may have linked to the image directly in another part of the site may also lose their content;<br> at the same time if you don't exclude them, you may use to much space in the server hard disk.<br>Configure this item well for your needs."
);
define('_MI_SUICO_MYVIDEOS', 'My Videos');
define('_MI_SUICO_TEMPLATE_ALBUMDESC', 'Template for the picture gallery');
define('_MI_SUICO_MYPICTURES', 'My Photos');
define('_MI_SUICO_MODULEDESC', 'This module simulates a social network software like MySpace or Orkut.');
define('_MI_SUICO_TUBEW_TITLE', 'Width of the YouTube videos');
define('_MI_SUICO_TUBEW_DESC', 'The width in pixels of the YouTube video player');
define('_MI_SUICO_TUBEH_TITLE', 'Height of the YouTube videos');
define('_MI_SUICO_TUBEH_DESC', 'The height in pixels of the YouTube video player');
define('_MI_SUICO_TEMPLATE_NOTEBOOKDESC', 'Template for the Notebook');
define('_MI_SUICO_TEMPLATE_VIDEOSDESC', 'Template for the videos section');
define('_MI_SUICO_TEMPLATE_GROUPSDESC', 'Template for the Groups');
define('_MI_SUICO_MYNOTES', 'My Notes');
define('_MI_SUICO_MYGROUPS', 'My Groups');
define('_MI_SUICO_TEMPLATE_NAVBARDESC', 'Template for the upper navbar used in all pages');
define('_MI_SUICO_VIDEOSPERPAGE_TITLE', 'Videos per Page');
define('_MI_SUICO_VIDEO_NOTIFYTIT', 'Videos');
define('_MI_SUICO_VIDEO_NOTIFYDSC', 'Video notifications');
define('_MI_SUICO_VIDEO_NEWVIDEO_NOTIFY', 'New video');
define('_MI_SUICO_VIDEO_NEWVIDEO_NOTIFYCAP', 'Notify me when a new video is submitted by this user');
define('_MI_SUICO_VIDEO_NEWVIDEO_NOTIFYDSC', 'New video notify description');
define('_MI_SUICO_VIDEO_NEWVIDEO_NOTIFYSBJ', '{X_OWNER_NAME} has submitted a new video to their profile');
define('_MI_SUICO_NOTE_NOTIFYTIT', 'Notes');
define('_MI_SUICO_NOTE_NOTIFYDSC', 'Notebook notifications');
define('_MI_SUICO_NOTE_NEWNOTE_NOTIFY', 'New Note');
define('_MI_SUICO_NOTE_NEWNOTE_NOTIFYCAP', 'Notify me when a new Note is sent to this Notebook');
define('_MI_SUICO_NOTE_NEWNOTE_NOTIFYDSC', 'New Note notification description');
define('_MI_SUICO_NOTE_NEWNOTE_NOTIFYSBJ', '{X_OWNER_NAME} has received a new Note into their Notebook');
define('_MI_SUICO_MAINTUBEW_TITLE', 'Main Video width');
define('_MI_SUICO_MAINTUBEW_DESC', 'Width of the video, which shows in the front page of the module');
define('_MI_SUICO_MAINTUBEH_TITLE', 'Main Video height');
define('_MI_SUICO_MAINTUBEH_DESC', 'Height of the video, that shows in the front page of the module');
//24/09/2007
define('_MI_SUICO_MYCONFIGS', 'My Settings');
define('_MI_SUICO_TEMPLATE_CONFIGSDESC', 'Template settings for the user');
define('_MI_SUICO_TEMPLATE_FOOTERDESC', 'Template for the footer of the module');
define('_MI_SUICO_TEMPLATE_EDITGROUP', 'Template for the Groups page atributes');
//define('_MI_SUICO_LICENSE', 'Suico by Marcello Brand�o is licensed under a Attribution-No Derivative Works 2.5 Brazil.');
//19/10/2007
define('_MI_SUICO_GROUPSPERPAGE_TITLE', 'Groups per page');
define('_MI_SUICO_GROUPSPERPAGE_DESC', 'Groups per page before pagination show up');
define('_MI_SUICO_TEMPLATE_SEARCHRESULTDESC', 'This template shows the results of a search for comunities');
define('_MI_SUICO_TEMPLATE_GROUPDESC', 'This template shows a Group and its members');
//22/10/2007
define('_MI_SUICO_MYPROFILE', 'My Profile');
define('_MI_SUICO_SEARCH', 'Search Members');
define('_MI_SUICO_TEMPLATE_SEARCHRESULTSDESC', 'Template for the search results');
define('_MI_SUICO_TEMPLATE_SEARCHFORMDESC', 'Template for the search form');
//26/10/2007
define('_MI_SUICO_ENABLEPICT_TITLE', 'Enable pictures section');
define('_MI_SUICO_ENABLEPICT_DESC', 'Enabling the pictures section for the users, will enable the pictures gallery');
define('_MI_SUICO_ENABLEFRIENDS_TITLE', 'Enable friends section');
define('_MI_SUICO_ENABLEFRIENDS_DESC', 'Enabling friends section for the users, will enable friends agenda');
define('_MI_SUICO_ENABLEVIDEOS_TITLE', 'Enable videos section');
define('_MI_SUICO_ENABLEVIDEOS_DESC', 'Enabling videos section for the users, will enable the video gallery');
define('_MI_SUICO_ENABLENOTES_TITLE', 'Enable Notes section');
define(
    '_MI_SUICO_ENABLENOTES_DESC',
    'Enabling Notes section, will enable members to leave public messages to other users. This feature is like the Wall on Facebook'
);
define('_MI_SUICO_ENABLEGROUPS_TITLE', 'Enable Groups section');
define(
    '_MI_SUICO_ENABLEGROUPS_DESC',
    'Enabling Groups section for the users, will enable them to create Groups, which group users that have similar interests'
);
define('_MI_SUICO_NOTESPERPAGE_TITLE', 'Number of Notes per page');
define('_MI_SUICO_NOTESPERPAGE_DESC', 'Number of Notes in a page before the page navigation shows ');
//25/11/2007
define('_MI_SUICO_FRIENDS', 'My Friends');
define('_MI_SUICO_FRIENDS_DESC', 'This block shows the user friends');
//26/01/2008
define('_MI_SUICO_IMGORDER_TITLE', 'Pictures Order');
define('_MI_SUICO_IMGORDER_DESC', 'Show the newest pictures first?');
//08/04/2008
define('_MI_SUICO_TEMPLATE_NOTIFICATIONS', 'Template for the notifications');
//11/04/2008
define('_MI_SUICO_FRIENDSHIP_NOTIFYTIT', 'Friendships');
define('_MI_SUICO_FRIENDSHIP_NOTIFYDSC', 'Friends Requests');
define('_MI_SUICO_FRIEND_NEWFRIENDREQUEST_NOTIFY', 'New Friend Requests');
define('_MI_SUICO_FRIEND_NEWFRIENDREQUEST_NOTIFYCAP', 'Notify me when someone ask for friendship');
define('_MI_SUICO_FRIEND_NEWFRIENDREQUEST_NOTIFYDSC', 'Notify me when someone ask for friendship');
define('_MI_SUICO_FRIEND_NEWFRIENDREQUEST_NOTIFYSBJ', 'Someone has just asked to be your friend');
//13/04/2008
define('_MI_SUICO_TEMPLATE_FANS', 'Template for the fans page');
//17/07/2008
define('_MI_SUICO_ENABLEAUDIO_TITLE', 'Enable audio section');
define('_MI_SUICO_ENABLEAUDIO_DESC', 'Enabling audio section for the users, will enable the audio playlist');
define('_MI_SUICO_TEMPLATE_AUDIOSDESC', 'Template of audios page');
define('_MI_SUICO_NUMBAUDIO_TITLE', 'Max number of audio for a user');
define('_MI_SUICO_AUDIOSPERPAGE_TITLE', 'Number of mp3 files per page');
//19/04/2008
define('_MI_SUICO_MYAUDIOS', 'My Audios');
//3.4
define('_MI_SUICO_MODULE_NAME', 'Social Network');
define('_MI_SUICO_NAME', _MI_SUICO_MODULE_NAME);
define('_MI_SUICO_MENU_02', 'Admin');
//Help
define('_MI_SUICO_DIRNAME', basename(dirname(__DIR__, 2)));
define('_MI_SUICO_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_SUICO_BACK_2_ADMIN', 'Back to Administration of ');
define('_MI_SUICO_OVERVIEW', 'Overview');
//define('_MI_SUICO_HELP_DIR', __DIR__);
//help multi-page
define('_MI_SUICO_DISCLAIMER', 'Disclaimer');
define('_MI_SUICO_LICENSE', 'License');
define('_MI_SUICO_SUPPORT', 'Support');
//Menu
define('MI_SUICO_ADMENU1', 'Home');
define('MI_SUICO_ADMENU2', 'Images');
define('MI_SUICO_ADMENU3', 'Friends');
define('MI_SUICO_ADMENU4', 'Visitors');
define('MI_SUICO_ADMENU5', 'Video');
define('MI_SUICO_ADMENU6', 'Invitations');
define('MI_SUICO_ADMENU7', 'Groups');
define('MI_SUICO_ADMENU8', 'Members');
define('MI_SUICO_ADMENU9', 'Notes');
define('MI_SUICO_ADMENU10', 'Configs');
define('MI_SUICO_ADMENU11', 'Suspensions');
define('MI_SUICO_ADMENU12', 'Audio');
define('MI_SUICO_ADMENU13', 'Privacy');
define('MI_SUICO_ADMENU14', 'Feedback');
define('MI_SUICO_ADMENU15', 'Migrate');
define('MI_SUICO_ADMENU16', 'About');
define('MI_SUICO_ADMENU17', 'User');
define('MI_SUICO_ADMENU18', 'Category');
define('MI_SUICO_ADMENU19', 'Fields');
define('MI_SUICO_ADMENU20', 'Reg-Steps');
define('MI_SUICO_ADMENU21', 'Fields Permission');
//Config
define('MI_SUICO_EDITOR_ADMIN', 'Editor: Admin');
define('MI_SUICO_EDITOR_ADMIN_DESC', 'Select the Editor to use by the Admin');
define('MI_SUICO_EDITOR_USER', 'Editor: User');
define('MI_SUICO_EDITOR_USER_DESC', 'Select the Editor to use by the User');
define('MI_SUICO_MIMETYPES', 'Mime Types');
define('MI_SUICO_MIMETYPES_DESC', 'Set the mime types selected');
// Permissions Groups
define('MI_SUICO_GROUPS', 'Groups access');
define('MI_SUICO_GROUPS_DESC', 'Select general access permission for groups.');
define('MI_SUICO_ADMINGROUPS', 'Admin Group Permissions');
define('MI_SUICO_ADMINGROUPS_DESC', 'Which groups have access to tools and permissions page');
//3.5
define('_MI_SUICO_GROUPS_LOGO_WIDTH', 'Group Logo Width');
define(
    '_MI_SUICO_GROUPS_LOGO_WIDTH_DESC',
    'Group Logo width in pixels<br>This means that the logo will be most of this size in width<br>All proportions are maintained'
);
define('_MI_SUICO_GROUPS_LOGO_HEIGHT', 'Group Logo Height');
define(
    '_MI_SUICO_GROUPS_LOGO_HEIGHT_DESC',
    'Group Logo Height in pixels<br>This means your logo will be most of this size in height<br>All proportions are maintained'
);
define('_MI_SUICO_ENABLEFRIENDSHIPLEVEL_TITLE', 'Enable Friendship Level');
define('_MI_SUICO_ENABLEFRIENDSHIPLEVEL_DESC', 'Options to set level of friendship');
define('_MI_SUICO_ENABLEFANSSEVALUATION_TITLE', 'Enable Fans Evaluation Ranking');
define('_MI_SUICO_ENABLEFANSSEVALUATION_DESC', 'Options to evaluate fans ranking');
define('_MI_SUICO_MEMBERSLIST', 'Members List');
define('_MI_SUICO_TEMPLATE_MEMBERSDESC', 'Template of members list page');
define('_MI_SUICO_TEMPLATE_USERDESC', 'Template for Guest');
define('_MI_SUICO_ENABLEUSERSUSPENSION_TITLE', 'Enable user suspension');
define('_MI_SUICO_ENABLEUSERSUSPENSION_DESC', 'Option to enable user suspension');
define('_MI_SUICO_ENABLEGUESTACCESS_TITLE', 'Enable access by Guest');
define('_MI_SUICO_ENABLEGUESTACCESS_DESC', 'Option to enable access by guest user');
//Config Categories
define('_MI_SUICO_CONFCAT_NOTES', 'Notes Preferences');
define('_MI_SUICO_CONFCAT_NOTES_DSC', '');
define('_MI_SUICO_CONFCAT_PHOTOS', 'Photos Preferences');
define('_MI_SUICO_CONFCAT_PHOTOS_DSC', '');
define('_MI_SUICO_CONFCAT_AUDIOS', 'Audios Preferences');
define('_MI_SUICO_CONFCAT_AUDIOS_DSC', '');
define('_MI_SUICO_CONFCAT_VIDEOS', 'Videos Preferences');
define('_MI_SUICO_CONFCAT_VIDEOS_DSC', '');
define('_MI_SUICO_CONFCAT_FRIENDS', 'Friends Preferences');
define('_MI_SUICO_CONFCAT_FRIENDS_DSC', '');
define('_MI_SUICO_CONFCAT_GROUPS', 'Groups Preferences');
define('_MI_SUICO_CONFCAT_GROUPS_DSC', '');
define('_MI_SUICO_CONFCAT_EDITOR', 'Editor Preferences');
define('_MI_SUICO_CONFCAT_EDITOR_DSC', '');
define('_MI_SUICO_CONFCAT_UPLOAD', 'Upload Preferences');
define('_MI_SUICO_CONFCAT_UPLOAD_DSC', '');
define('_MI_SUICO_CONFCAT_ADMIN', 'Admin Preferences');
define('_MI_SUICO_CONFCAT_ADMIN_DSC', '');
define('_MI_SUICO_CONFCAT_MEMBERSLIST', 'Members List Preferences');
define('_MI_SUICO_CONFCAT_MEMBERSLIST_DSC', '');
define('_MI_SUICO_CONFCAT_MEMBERSLISTSEARCH', 'Members List & Search  Members Preferences');
define('_MI_SUICO_CONFCAT_MEMBERSLISTSEARCH_DSC', '');
define('_MI_SUICO_CONFCAT_GENERAL', 'General Preferences');
define('_MI_SUICO_CONFCAT_GENERAL_DSC', '');
define('_MI_SUICO_CONFCAT_COMMENTANDNOTIFICATION', 'Comment & Notification Preferences');
define('_MI_SUICO_CONFCAT_COMMENTANDNOTIFICATION_DSC', '');
define('_MI_SUICO_MEMBER_LIST_LATESTMEMBER', 'Display Latest Member');
define('_MI_SUICO_MEMBER_LIST_LATESTMEMBER_DSC', 'Display last register member in index page ?');
define('_MI_SUICO_MEMBER_LIST_DISPLAYWELCOMEMSG', 'Display Welcome Message');
define('_MI_SUICO_MEMBER_LIST_DISPLAYWELCOMEMSG_DSC', 'Display Welcome Message in index page ?');
define('_MI_SUICO_MEMBER_LIST_WELCOMEMSG', 'Index Page Welcome Message');
define('_MI_SUICO_MEMBER_LIST_WELCOMEMSG_DSC', 'Welcome message to be displayed in the index page of the module');
define('_MI_SUICO_MEMBER_LIST_DEFAULTWELCOMEMSG', 'Here you can view a list of our current members');
define('_MI_SUICO_MEMBER_LIST_MPAGE', 'Member per page');
define('_MI_SUICO_MEMBER_LIST_MPAGE_DSC', 'How many members will we show per page in index page ?');
define('_MI_SUICO_MEMBER_LIST_SORT', 'Sort By Option');
define('_MI_SUICO_MEMBER_LIST_SORT_DSC', 'Sorting option for the members list in index page?');
define('_MI_SUICO_MEMBER_LIST_ORDER', 'Order By Option');
define('_MI_SUICO_MEMBER_LIST_ORDER_DSC', 'Order by option for the members list in index page?');
define('_MI_SUICO_MEMBER_LIST_TEMPSTYLE', 'Member List Template Style');
define('_MI_SUICO_MEMBER_LIST_TEMPSTYLE_DSC', 'Change Member List template style in index page?');
define('_MI_SUICO_DATATABLESBASICTEMPLATE', 'Data Tables Basic');
define('_MI_SUICO_TEMPLATE_NORMAL', 'Normal');
define('_MI_SUICO_REALNAME', 'Real Name');
define('_MI_SUICO_REGDATE', 'Joined Date');
define('_MI_SUICO_EMAIL', 'Email');
define('_MI_SUICO_UNAME', 'User Name');
define('_MI_SUICO_LASTLOGIN', 'Last login');
define('_MI_SUICO_POSTS', 'Number of posts');
define('_MI_SUICO_ASCORDER', 'Ascending order');
define('_MI_SUICO_DESCORDER', 'Descending order');
define('_MI_SUICO_DISPLAYREALNAME', 'Display Real Name');
define('_MI_SUICO_DISPLAYREALNAME_DSC', 'Hide or Display Members Real Name');
define('_MI_SUICO_DISPLAYEMAIL', 'Display Email');
define('_MI_SUICO_DISPLAYEMAIL_DSC', 'Hide or Display Members Email');
define('_MI_SUICO_DISPLAYPM', 'Display Private Message Button');
define('_MI_SUICO_DISPLAYPM_DSC', 'Hide or Display Private Message Button');
define('_MI_SUICO_DISPLAYURL', 'Display Website URL');
define('_MI_SUICO_DISPLAYURL_DSC', 'Hide or Display Members Website URL Field');
define('_MI_SUICO_DISPLAYAVATAR', 'Display Avatar');
define('_MI_SUICO_DISPLAYAVATAR_DSC', 'Hide or Display Members Avatar');
define('_MI_SUICO_DISPLAYREGDATE', 'Display Joined Date');
define('_MI_SUICO_DISPLAYREGDATE_DSC', 'Hide or Display Members Joined Date');
define('_MI_SUICO_DISPLAYFROM', 'Display From/Location');
define('_MI_SUICO_DISPLAYFROM_DSC', 'Hide or Display Members From/Location');
define('_MI_SUICO_DISPLAYPOSTS', 'Display Comment/Post Total');
define('_MI_SUICO_DISPLAYPOSTS_DSC', 'Hide or Display Members Comment/Post Level');
define('_MI_SUICO_DISPLAYLASTLOGIN', 'Display Last Login');
define('_MI_SUICO_DISPLAYLASTLOGIN_DSC', 'Hide or Display Members Last Login');
define('_MI_SUICO_DISPLAYOCC', 'Display Occupation');
define('_MI_SUICO_DISPLAYOCC_DSC', 'Hide or Display Members Occupation');
define('_MI_SUICO_DISPLAYINTEREST', 'Display Interest');
define('_MI_SUICO_DISPLAYINTEREST_DSC', 'Hide or Display Members Interest');
define('_MI_SUICO_DISPLAYBREADCRUMB', 'Display Breadcrumb');
define('_MI_SUICO_DISPLAYBREADCRUMB_DSC', 'Hide or Display Breadcrumb');
define('_MI_SUICO_DISPLAYTOTALMEMBER', 'Display Total Member');
define('_MI_SUICO_DISPLAYTOTALMEMBER_DSC', 'Hide or Display Total Member');
define('_MI_SUICO_DISPLAYBIO', 'Display Bio/Extra Info');
define('_MI_SUICO_DISPLAYBIO_DSC', 'Hide or Display Bio/Extra Info');
define('_MI_SUICO_DISPLAYSIGNATURE', 'Display Signature');
define('_MI_SUICO_DISPLAYSIGNATURE_DSC', 'Hide or Display Signature');
define('_MI_SUICO_DISPLAYRANK', 'Display Members Rank');
define('_MI_SUICO_DISPLAYRANK_DSC', 'Hide or Display Members Rank');
define('_MI_SUICO_DISPLAYGROUPS', 'Display Groups');
define('_MI_SUICO_DISPLAYGROUPS_DSC', 'Hide or Display Members Groups');
define('_MI_SUICO_DISPLAYONLINESTATUS', 'Display Members Online Status');
define('_MI_SUICO_DISPLAYONLINESTATUS_DSC', 'Hide or Display Members Online Status');
//define('_MI_SUICO_CONFIG_GENERAL', '<h4>:: General Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_GENERAL_DSC', '');
//define('_MI_SUICO_CONFIG_NOTES', '<h4>:: Notes Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_NOTES_DSC', '');
//define('_MI_SUICO_CONFIG_PHOTOS', '<h4>:: Photos Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_PHOTOS_DSC', '');
//define('_MI_SUICO_CONFIG_AUDIOS', '<h4>:: Audios Preferences::</h4>');
//define('_MI_SUICO_CONFIG_AUDIOS_DSC', '');
//define('_MI_SUICO_CONFIG_VIDEOS', '<h4>:: Videos Preferences::</h4>');
//define('_MI_SUICO_CONFIG_VIDEOS_DSC', '');
//define('_MI_SUICO_CONFIG_FRIENDS', '<h4>:: Friends Preferences::</h4>');
//define('_MI_SUICO_CONFIG_FRIENDS_DSC', '');
//define('_MI_SUICO_CONFIG_GROUPS', '<h4>:: Groups Preferences::</h4>');
//define('_MI_SUICO_CONFIG_GROUPS_DSC', '');
//define('_MI_SUICO_CONFIG_EDITOR', '<h4>:: Editor Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_EDITOR_DSC', '');
//define('_MI_SUICO_CONFIG_UPLOAD', '<h4>:: Upload Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_UPLOAD_DSC', '');
//define('_MI_SUICO_CONFIG_MEMBER_LIST', '<h4>:: Members List Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_MEMBER_LIST_DSC', '');
//define('_MI_SUICO_CONFIG_MEMBER_LIST_SEARCH', '<h4>:: Members List & Member Search Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_MEMBER_LIST_SEARCH_DSC', '');
//define('_MI_SUICO_CONFIG_ADMIN', '<h4>:: Administrator Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_ADMIN_DSC', '');
//define('_MI_SUICO_CONFIG_COMMENTANDNOTIFICATION', '<h4>:: Comment & Notification Preferences ::</h4>');
//define('_MI_SUICO_CONFIG_COMMENTANDNOTIFICATION_DSC', '');
//Config Categories Styling:
define('_MI_SUICO_CONFIG_STYLING_START', '<span style="color: #FF0000; font-size: Small;  font-weight: bold;">:: ');
define('_MI_SUICO_CONFIG_STYLING_END', ' ::</span> ');
define('_MI_SUICO_CONFIG_STYLING_DESC_START', '<span style="color: #FF0000; font-size: Small;">');
define('_MI_SUICO_CONFIG_STYLING_DESC_END', '</span> ');
define('_MI_SUICO_CONFIG_GENERAL', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_GENERAL . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_GENERAL_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_GENERAL_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_NOTES', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_NOTES . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_NOTES_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_NOTES_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_PHOTOS', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_PHOTOS . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_PHOTOS_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_PHOTOS_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_AUDIOS', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_AUDIOS . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_AUDIOS_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_AUDIOS_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_VIDEOS', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_VIDEOS . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_VIDEOS_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_VIDEOS_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_FRIENDS', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_FRIENDS . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_FRIENDS_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_FRIENDS_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_GROUPS', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_GROUPS . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_GROUPS_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_GROUPS_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_EDITOR', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_EDITOR . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_EDITOR_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_EDITOR_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_UPLOAD', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_UPLOAD . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_UPLOAD_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_UPLOAD_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_MEMBER_LIST', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_MEMBERSLIST . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_MEMBER_LIST_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_GENERAL_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_MEMBER_LIST_SEARCH', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_MEMBERSLISTSEARCH . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_MEMBER_LIST_SEARCH_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_MEMBERSLISTSEARCH_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_ADMIN', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_ADMIN . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_ADMIN_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_ADMIN_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
define('_MI_SUICO_CONFIG_COMMENTANDNOTIFICATION', _MI_SUICO_CONFIG_STYLING_START . _MI_SUICO_CONFCAT_COMMENTANDNOTIFICATION . _MI_SUICO_CONFIG_STYLING_END);
define('_MI_SUICO_CONFIG_COMMENTANDNOTIFICATION_DSC', _MI_SUICO_CONFIG_STYLING_DESC_START . _MI_SUICO_CONFCAT_COMMENTANDNOTIFICATION_DSC . _MI_SUICO_CONFIG_STYLING_DESC_END);
//Profile Module
define('_MI_SUICO_EDITACCOUNT', 'Edit Profile');
define('_MI_SUICO_CHANGEPASS', 'Change Password');
define('_MI_SUICO_CHANGEMAIL', 'Change Email');
define('_MI_SUICO_INDEX', 'Index');
define('_MI_SUICO_CATEGORIES', 'Categories');
define('_MI_SUICO_FIELDS', 'Fields');
define('_MI_SUICO_USERS', 'Users');
define('_MI_SUICO_STEPS', 'Registration Steps');
define('_MI_SUICO_PERMISSIONS', 'Permissions');
define('_MI_SUICO_CATEGORY_TITLE', 'User Profile');
define('_MI_SUICO_CATEGORY_DESC', 'For those user fields');
define('_MI_SUICO_URL_TITLE', 'Website');
define('_MI_SUICO_CAT_SETTINGS', 'General Settings');
define('_MI_SUICO_CAT_SETTINGS_DSC', '');
define('_MI_SUICO_CAT_USER', 'User Settings');
define('_MI_SUICO_CAT_USER_DSC', '');
define('_MI_SUICO_PROFILE_SEARCH', 'Show latest activities on user profile');
define('_MI_SUICO_PAGE_INFO', 'User Info');
define('_MI_SUICO_PAGE_EDIT', 'Edit User');
define('_MI_SUICO_PAGE_SEARCH', 'Search');
define('_MI_SUICO_STEP_BASIC', 'Basic');
define('_MI_SUICO_STEP_COMPLEMENTARY', 'Advanced');
define('_MI_SUICO_CATEGORY_PERSONAL', 'Personal');
define('_MI_SUICO_CATEGORY_MESSAGING', 'Messaging');
define('_MI_SUICO_CATEGORY_SETTINGS', 'Settings');
define('_MI_SUICO_CATEGORY_COMMUNITY', 'Community');
define('_MI_SUICO_NEVER_LOGGED_IN', 'Never logged in');
define('_MI_SUICO_PROFILE_CAPTCHA_STEP1', 'Use Captcha after the second Registration step?');
define('_MI_SUICO_PROFILE_CAPTCHA_STEP1_DESC', "Select 'Yes' to add extra measure against Spam registration by bots");
define('_MI_SUICO_EDITPROFILE', 'Edit Profile');
define('_MI_SUICO_CHANGEAVATAR', 'Change Avatar');
define('MI_SUICO_ADMINPAGER', 'Admin: records / page');
define('MI_SUICO_ADMINPAGER_DESC', 'Admin: # of records shown per page');
define('MI_SUICO_USERPAGER', 'User: records / page');
define('MI_SUICO_USERPAGER_DESC', 'User: # of records shown per page');

