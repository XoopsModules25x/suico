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
//index.php
define(
    '_MD_SUICO_FRAMEWORKSFALSE',
    "You need to install this package, in order to make this module work correctly:<br><br>
<a href='http://dev.xoops.org/modules/xfmod/project/showfiles.php?group_id=1357'>Frameworks v 1.1 or newer</a><br>"
);
define('_MD_SUICO_FRAMEWORKSTRUE', 'You have version %s of the Frameworks package');
define('_MD_SUICO_BY', 'By');
define('_MD_SUICO_CREDITS', 'Credits');
define('_MD_SUICO_CONTRIBUTORS', 'Contributors Information');
define('_MD_SUICO_DEVELOPERS', 'Developers');
define('_MD_SUICO_TESTERS', 'Testers');
define('_MD_SUICO_TRANSLATIONS', 'Translations');
define('_MD_SUICO_MODDEVDET', 'Module Development details');
define('_MD_SUICO_RELEASEDATE', 'Release date');
define('_MD_SUICO_STATUS', 'Status');
define('_MD_SUICO_OFCSUPORTSITE', 'Official Support Site');
define('_MD_SUICO_VERSIONHIST', 'Version History');
define('_MD_SUICO_CONFIGEVERYTHING', "Make sure you've configured everything under the preferences tab ");
define('_MD_SUICO_ALLTESTSOK', 'All tests must be OK for this module to work 100%:');
define('_MD_SUICO_GDEXTENSIONOK', 'GD extension loaded: OK!');
define('_MD_SUICO_MOREINFO', 'Here is more info on:');
define('_MD_SUICO_GDEXTENSIONFALSE', 'GD extension loaded: FAILED ');
define(
    '_MD_SUICO_CONFIGPHPINI',
    'Configure your php.ini or ask your server manager to install it and enable it for you.'
);
define('_MD_SUICO_PHP5PRESENT', 'You have a compatible version of PHP:');
define(
    '_MD_SUICO_PHP5NOTPRESENT',
    'Your PHP version is compatible, but many details would work better on a php5 server and above.'
);
define('_MD_SUICO_MAXBYTESPHPINI', 'Your server limits the size of uploads to %s');
define('_MD_SUICO_MEMORYLIMIT', 'The Memory Limit of your server is:');
//3.4
define('_AM_SUICO_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('_AM_SUICO_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('_AM_SUICO_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('_AM_SUICO_ERROR_COLUMN', 'Could not create column in database : %s');
define('_AM_SUICO_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('_AM_SUICO_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('_AM_SUICO_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');
define('_AM_SUICO_FOLDERS_DELETED_OK', 'Upload Folders have been deleted');
// Error Msgs
define('_AM_SUICO_ERROR_BAD_DEL_PATH', 'Could not delete %s directory');
define('_AM_SUICO_ERROR_BAD_REMOVE', 'Could not delete %s');
define('_AM_SUICO_ERROR_NO_PLUGIN', 'Could not load plugin');
//2.0
//Index
define('AM_SUICO_STATISTICS', 'Suico statistics');
define('AM_SUICO_THEREARE_IMAGES', "There are <span class='bold'>%s</span> Images in the database");
define('AM_SUICO_THEREARE_FRIENDS', "There are <span class='bold'>%s</span> Friends in the database");
define('AM_SUICO_THEREARE_VISITORS', "There are <span class='bold'>%s</span> Visitors in the database");
define('AM_SUICO_THEREARE_VIDEO', "There are <span class='bold'>%s</span> Video in the database");
define(
    'AM_SUICO_THEREARE_FRIENDREQUEST',
    "There are <span class='bold'>%s</span> Friendship Requests in the database"
);
define('AM_SUICO_THEREARE_GROUPS', "There are <span class='bold'>%s</span> Groups in the database");
define('AM_SUICO_THEREARE_MEMBERS', "There are <span class='bold'>%s</span> Memberships in the database");
define('AM_SUICO_THEREARE_NOTES', "There are <span class='bold'>%s</span> Notes in the database");
define('AM_SUICO_THEREARE_CONFIGS', "There are <span class='bold'>%s</span> Configs in the database");
define('AM_SUICO_THEREARE_SUSPENSIONS', "There are <span class='bold'>%s</span> Suspensions in the database");
define('AM_SUICO_THEREARE_AUDIO', "There are <span class='bold'>%s</span> Audio in the database");
define('AM_SUICO_THEREARE_PRIVACY', "There are <span class='bold'>%s</span> Privacy in the database");
//Buttons
define('AM_SUICO_ADD_IMAGES', 'Add new Images');
define('AM_SUICO_IMAGES_LIST', 'List of Images');
define('AM_SUICO_ADD_FRIENDSHIP', 'Add new Friends');
define('AM_SUICO_FRIENDSHIP_LIST', 'List of Friends');
define('AM_SUICO_ADD_VISITORS', 'Add new Visitors');
define('AM_SUICO_VISITORS_LIST', 'List of Visitors');
define('AM_SUICO_ADD_VIDEO', 'Add new Video');
define('AM_SUICO_VIDEO_LIST', 'List of Video');
define('AM_SUICO_ADD_FRIENDREQUEST', 'Add new Friendship Request');
define('AM_SUICO_FRIENDREQUEST_LIST', 'List of Friendship Request');
define('AM_SUICO_ADD_GROUPS', 'Add new Groups');
define('AM_SUICO_GROUPS_LIST', 'List of Groups');
define('AM_SUICO_ADD_RELGROUPUSER', 'Add new Members');
define('AM_SUICO_RELGROUPUSER_LIST', 'List of Members');
define('AM_SUICO_ADD_NOTES', 'Add new Notes');
define('AM_SUICO_NOTES_LIST', 'List of Notes');
define('AM_SUICO_ADD_CONFIGS', 'Add new Configs');
define('AM_SUICO_CONFIGS_LIST', 'List of Configs');
define('AM_SUICO_ADD_SUSPENSIONS', 'Add new Suspensions');
define('AM_SUICO_SUSPENSIONS_LIST', 'List of Suspensions');
define('AM_SUICO_ADD_AUDIO', 'Add new Audio');
define('AM_SUICO_AUDIO_LIST', 'List of Audio');
//General
define('AM_SUICO_FORMOK', 'Registered successfull');
define('AM_SUICO_FORMDELOK', 'Deleted successfull');
define('AM_SUICO_FORMSUREDEL', "Are you sure to Delete: <span class='bold red'>%s</span></b>");
define('AM_SUICO_FORMSURERENEW', "Are you sure to Renew: <span class='bold red'>%s</span></b>");
define('AM_SUICO_FORMUPLOAD', 'Upload');
define('AM_SUICO_FORMIMAGE_PATH', 'File presents in %s');
define('AM_SUICO_FORM_ACTION', 'Action');
define('AM_SUICO_SELECT', 'Select action for selected item(s)');
define('AM_SUICO_SELECTED_DELETE', 'Delete selected item(s)');
define('AM_SUICO_SELECTED_ACTIVATE', 'Activate selected item(s)');
define('AM_SUICO_SELECTED_DEACTIVATE', 'De-activate selected item(s)');
define('AM_SUICO_SELECTED_ERROR', 'You selected nothing to delete');
define('AM_SUICO_CLONED_OK', 'Record cloned successfully');
define('AM_SUICO_CLONED_FAILED', 'Cloning of the record has failed');
// Images
define('AM_SUICO_IMAGES_ADD', 'Add a images');
define('AM_SUICO_IMAGES_EDIT', 'Edit images');
define('AM_SUICO_IMAGES_DELETE', 'Delete images');
define('AM_SUICO_IMAGES_IMAGE_ID', 'ID');
define('AM_SUICO_IMAGES_TITLE', 'Title');
define('AM_SUICO_IMAGES_CAPTION', 'Caption');
define('AM_SUICO_IMAGES_DATE_CREATED', 'Created');
define('AM_SUICO_IMAGES_DATE_UPDATED', 'Updated');
define('AM_SUICO_IMAGES_UID_OWNER', 'Owner');
define('AM_SUICO_IMAGES_URL', 'URL');
define('AM_SUICO_IMAGES_PRIVATE', 'Private');
// Friendship
define('AM_SUICO_FRIENDSHIP_ADD', 'Add a friendship');
define('AM_SUICO_FRIENDSHIP_EDIT', 'Edit friendship');
define('AM_SUICO_FRIENDSHIP_DELETE', 'Delete friendship');
define('AM_SUICO_FRIENDSHIP_FRIENDSHIP_ID', 'ID');
define('AM_SUICO_FRIENDSHIP_FRIEND1_UID', 'Friend1');
define('AM_SUICO_FRIENDSHIP_FRIEND2_UID', 'Friend2');
define('AM_SUICO_FRIENDSHIP_LEVEL', 'Level');
define('AM_SUICO_FRIENDSHIP_HOT', 'Hot');
define('AM_SUICO_FRIENDSHIP_TRUST', 'Trust');
define('AM_SUICO_FRIENDSHIP_COOL', 'Cool');
define('AM_SUICO_FRIENDSHIP_FAN', 'Fan');
define('AM_SUICO_FRIENDSHIP_DATE_CREATED', 'Created');
define('AM_SUICO_FRIENDSHIP_DATE_UPDATED', 'Updated');
// Visitors
define('AM_SUICO_VISITORS_ADD', 'Add a visitors');
define('AM_SUICO_VISITORS_EDIT', 'Edit visitors');
define('AM_SUICO_VISITORS_DELETE', 'Delete visitors');
define('AM_SUICO_VISITORS_VISIT_ID', 'ID');
define('AM_SUICO_VISITORS_UID_OWNER', 'Owner');
define('AM_SUICO_VISITORS_UID_VISITOR', 'Visitor');
define('AM_SUICO_VISITORS_UNAME_VISITOR', 'Name');
define('AM_SUICO_VISITORS_DATETIME', 'Date');
// Video
define('AM_SUICO_VIDEO_ADD', 'Add a video');
define('AM_SUICO_VIDEO_EDIT', 'Edit video');
define('AM_SUICO_VIDEO_DELETE', 'Delete video');
define('AM_SUICO_VIDEO_VIDEO_ID', 'ID');
define('AM_SUICO_VIDEO_UID_OWNER', 'Owner');
define('AM_SUICO_VIDEO_TITLE', 'Video Title');
define('AM_SUICO_VIDEO_VIDEO_DESC', 'Description');
define('AM_SUICO_VIDEO_YOUTUBE_CODE', 'YouTube_Code');
define('AM_SUICO_VIDEO_MAIN_VIDEO', 'MainVideo');
define('AM_SUICO_VIDEO_DATE_CREATED', 'Created');
define('AM_SUICO_VIDEO_DATE_UPDATED', 'Updated');
// Friendrequest
define('AM_SUICO_FRIENDREQUEST_ADD', 'Add a friendrequest');
define('AM_SUICO_FRIENDREQUEST_EDIT', 'Edit friendrequest');
define('AM_SUICO_FRIENDREQUEST_DELETE', 'Delete friendrequest');
define('AM_SUICO_FRIENDREQUEST_FRIENDPET_ID', 'ID');
define('AM_SUICO_FRIENDREQUEST_FRIENDREQUESTER_UID', 'From');
define('AM_SUICO_FRIENDREQUEST_FRIENDREQUESTTO_UID', 'To');
define('AM_SUICO_FRIENDREQUEST_DATE_CREATED', 'Created');
// Groups
define('AM_SUICO_GROUPS_ADD', 'Add a groups');
define('AM_SUICO_GROUPS_EDIT', 'Edit groups');
define('AM_SUICO_GROUPS_DELETE', 'Delete groups');
define('AM_SUICO_GROUPS_GROUP_ID', 'ID');
define('AM_SUICO_GROUPS_OWNER_UID', 'Owner');
define('AM_SUICO_GROUPS_GROUP_TITLE', 'Group');
define('AM_SUICO_GROUPS_GROUP_DESC', 'Description');
define('AM_SUICO_GROUPS_GROUP_IMG', 'Image');
define('AM_SUICO_GROUPS_DATE_CREATED', 'Created');
define('AM_SUICO_GROUPS_DATE_UPDATED', 'Updated');
// Relgroupuser
define('AM_SUICO_RELGROUPUSER_ADD', 'Add a relgroupuser');
define('AM_SUICO_RELGROUPUSER_EDIT', 'Edit relgroupuser');
define('AM_SUICO_RELGROUPUSER_DELETE', 'Delete relgroupuser');
define('AM_SUICO_RELGROUPUSER_REL_ID', 'ID');
define('AM_SUICO_RELGROUPUSER_REL_GROUP_ID', 'Group');
define('AM_SUICO_RELGROUPUSER_REL_USER_UID', 'User');
// Notes
define('AM_SUICO_NOTES_ADD', 'Add a notes');
define('AM_SUICO_NOTES_EDIT', 'Edit notes');
define('AM_SUICO_NOTES_DELETE', 'Delete notes');
define('AM_SUICO_NOTES_NOTE_ID', 'ID');
define('AM_SUICO_NOTES_NOTE_TEXT', 'Text');
define('AM_SUICO_NOTES_NOTE_FROM', 'From');
define('AM_SUICO_NOTES_NOTE_TO', 'To');
define('AM_SUICO_NOTES_PRIVATE', 'Private');
define('AM_SUICO_NOTES_DATE', 'Date');
// Configs
define('AM_SUICO_CONFIGS_ADD', 'Add a configs');
define('AM_SUICO_CONFIGS_EDIT', 'Edit configs');
define('AM_SUICO_CONFIGS_DELETE', 'Delete configs');
define('AM_SUICO_CONFIGS_CONFIG_ID', 'ID');
define('AM_SUICO_CONFIGS_CONFIG_UID', 'User');
define('AM_SUICO_CONFIGS_PICTURES', 'Pictures');
define('AM_SUICO_CONFIGS_AUDIO', 'Audio');
define('AM_SUICO_CONFIGS_VIDEOS', 'Videos');
define('AM_SUICO_CONFIGS_GROUPS', 'Groups');
define('AM_SUICO_CONFIGS_NOTES', 'Notes');
define('AM_SUICO_CONFIGS_FRIENDS', 'Friends');
define('AM_SUICO_CONFIGS_PROFILE_CONTACT', 'Contact');
define('AM_SUICO_CONFIGS_PROFILE_GENERAL', 'Profile Info');
define('AM_SUICO_CONFIGS_PROFILE_STATS', 'Profile Stats');
define('AM_SUICO_CONFIGS_SUSPENSION', 'Suspension');
define('AM_SUICO_CONFIGS_BACKUP_PASSWORD', 'BackupPassword');
define('AM_SUICO_CONFIGS_BACKUP_EMAIL', 'BackupEmail');
define('AM_SUICO_CONFIGS_END_SUSPENSION', 'End_Suspension');
// Suspensions
define('AM_SUICO_SUSPENSIONS_ADD', 'Add a suspensions');
define('AM_SUICO_SUSPENSIONS_EDIT', 'Edit suspensions');
define('AM_SUICO_SUSPENSIONS_DELETE', 'Delete suspensions');
define('AM_SUICO_SUSPENSIONS_UID', 'ID');
define('AM_SUICO_SUSPENSIONS_OLD_PASS', 'OldPass');
define('AM_SUICO_SUSPENSIONS_OLD_EMAIL', 'OldEmail');
define('AM_SUICO_SUSPENSIONS_OLD_SIGNATURE', 'OldSignature');
define('AM_SUICO_SUSPENSIONS_SUSPENSION_TIME', 'SuspensionTime');
define('AM_SUICO_SUSPENSIONS_OLD_ENC_TYPE', 'OldEncType');
define('AM_SUICO_SUSPENSIONS_OLD_PASS_EXPIRED', 'OldPassExpired');
// Audio
define('AM_SUICO_AUDIO_ADD', 'Add a audio');
define('AM_SUICO_AUDIO_EDIT', 'Edit audio');
define('AM_SUICO_AUDIO_DELETE', 'Delete audio');
define('AM_SUICO_AUDIO_AUDIO_ID', 'ID');
define('AM_SUICO_AUDIO_TITLE', 'Name');
define('AM_SUICO_AUDIO_AUTHOR', 'Author');
define('AM_SUICO_AUDIO_URL', 'File');
define('AM_SUICO_AUDIO_UID_OWNER', 'Owner');
define('AM_SUICO_AUDIO_DATE_CREATED', 'Created');
define('AM_SUICO_AUDIO_DATE_UPDATED', 'Updated');
define('AM_SUICO_AUDIO_DESCRIPTION', 'Description');
// Privacy
define('AM_SUICO_PRIVACY_ADD', 'Add a privacy');
define('AM_SUICO_PRIVACY_EDIT', 'Edit privacy');
define('AM_SUICO_PRIVACY_DELETE', 'Delete privacy');
define('AM_SUICO_PRIVACY_ID', 'ID');
define('AM_SUICO_PRIVACY_LEVEL', 'Level');
define('AM_SUICO_PRIVACY_NAME', 'Name');
define('AM_SUICO_PRIVACY_DESCRIPTION', 'Description');
//Blocks.php
//Permissions
define('AM_SUICO_PERMISSIONS_GLOBAL', 'Global permissions');
define('AM_SUICO_PERMISSIONS_GLOBAL_DESC', 'Only users in the group that you select may global this');
define('AM_SUICO_PERMISSIONS_GLOBAL_4', 'Rate from user');
define('AM_SUICO_PERMISSIONS_GLOBAL_8', 'Submit from user side');
define('AM_SUICO_PERMISSIONS_GLOBAL_16', 'Auto approve');
define('AM_SUICO_PERMISSIONS_APPROVE', 'Permissions to approve');
define('AM_SUICO_PERMISSIONS_APPROVE_DESC', 'Only users in the group that you select may approve this');
define('AM_SUICO_PERMISSIONS_VIEW', 'Permissions to view');
define('AM_SUICO_PERMISSIONS_VIEW_DESC', 'Only users in the group that you select may view this');
define('AM_SUICO_PERMISSIONS_SUBMIT', 'Permissions to submit');
define('AM_SUICO_PERMISSIONS_SUBMIT_DESC', 'Only users in the group that you select may submit this');
define('AM_SUICO_PERMISSIONS_GPERMUPDATED', 'Permissions have been changed successfully');
define('AM_SUICO_PERMISSIONS_NOPERMSSET', 'Permission cannot be set: No privacy created yet! Please create a privacy first.');
//Errors
define('AM_SUICO_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('AM_SUICO_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('AM_SUICO_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('AM_SUICO_ERROR_COLUMN', 'Could not create column in database : %s');
define('AM_SUICO_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('AM_SUICO_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('AM_SUICO_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');
//directories
define('AM_SUICO_AVAILABLE', "<span style='color : #008000;'>Available. </span>");
define('AM_SUICO_NOTAVAILABLE', "<span style='color : #ff0000;'>is not available. </span>");
define(
    'AM_SUICO_NOTWRITABLE',
    "<span style='color : #ff0000;'>" . ' should have permission ( %1$d ), but it has ( %2$d )' . '</span>'
);
define('AM_SUICO_CREATETHEDIR', 'Create it');
define('AM_SUICO_SETMPERM', 'Set the permission');
define('AM_SUICO_DIRCREATED', 'The directory has been created');
define('AM_SUICO_DIRNOTCREATED', 'The directory can not be created');
define('AM_SUICO_PERMSET', 'The permission has been set');
define('AM_SUICO_PERMNOTSET', 'The permission can not be set');
define('AM_SUICO_VIDEO_EXPIREWARNING', 'The publishing date is after expiration date!!!');
//Sample Data
define('AM_SUICO_ADD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
define('AM_SUICO_SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');

define('AM_SUICO_MAINTAINEDBY', 'is maintained by the');
define('AM_SUICO_ADD_PRIVACY', 'Add new Privacy');
define('AM_SUICO_PRIVACY_LIST', 'List of Privacy');
define('_AM_SUICO_UPLOAD_ERROR', 'Upload Error');
//Profile Module
define('_AM_SUICO_FIELD', 'Add Field');
define('_AM_SUICO_FIELDS', 'Fields');
define('_AM_SUICO_CATEGORY', 'Add Category');
define('_AM_SUICO_STEP', 'Add Step');
define('_AM_SUICO_SAVEDSUCCESS', '%s saved successfully');
define('_AM_SUICO_DELETEDSUCCESS', '%s deleted successfully');
define('_AM_SUICO_RUSUREDEL', 'Are you sure you want to delete %s');
define('_AM_SUICO_FIELDNOTCONFIGURABLE', 'The field is not configurable.');
define('_AM_SUICO_ADD', 'Add %s');
define('_AM_SUICO_EDIT', 'Edit %s');
define('_AM_SUICO_TYPE', 'Field Type');
define('_AM_SUICO_VALUETYPE', 'Value Type');
define('_AM_SUICO_NAME', 'Name');
define('_AM_SUICO_TITLE', 'Title');
define('_AM_SUICO_DESCRIPTION', 'Description');
define('_AM_SUICO_REQUIRED', 'Required?');
define('_AM_SUICO_MAXLENGTH', 'Maximum Length');
define('_AM_SUICO_WEIGHT', 'Weight');
define('_AM_SUICO_DEFAULT', 'Default');
define('_AM_SUICO_NOTNULL', 'Not Null?');
define('_AM_SUICO_ARRAY', 'Array');
define('_AM_SUICO_EMAIL', 'Email');
define('_AM_SUICO_INT', 'Integer');
define('_AM_SUICO_TXTAREA', 'Text Area');
define('_AM_SUICO_TXTBOX', 'Text field');
define('_AM_SUICO_URL', 'URL');
define('_AM_SUICO_OTHER', 'Other');
define('_AM_SUICO_FLOAT', 'Floating Point');
define('_AM_SUICO_DECIMAL', 'Decimal Number');
define('_AM_SUICO_UNICODE_ARRAY', 'Unicode Array');
define('_AM_SUICO_UNICODE_EMAIL', 'Unicode Email');
define('_AM_SUICO_UNICODE_TXTAREA', 'Unicode Text Area');
define('_AM_SUICO_UNICODE_TXTBOX', 'Unicode Text field');
define('_AM_SUICO_UNICODE_URL', 'Unicode URL');
define('_AM_SUICO_PROF_VISIBLE_ON', "Field visible on these groups' profile");
define('_AM_SUICO_PROF_VISIBLE_FOR', 'Field visible on profile for these groups');
define('_AM_SUICO_PROF_VISIBLE', 'Visibility');
define('_AM_SUICO_PROF_EDITABLE', 'Field editable from profile');
define('_AM_SUICO_PROF_REGISTER', 'Show in registration form');
define('_AM_SUICO_PROF_SEARCH', 'Searchable by these groups');
define('_AM_SUICO_PROF_ACCESS', 'Profile accessible by these groups');
define(
    '_AM_SUICO_PROF_ACCESS_DESC',
    '<ul>'
    . "<li>Admin groups: If a user belongs to admin groups, the current user has access if and only if one of the current user's groups is allowed to access admin group; else</li>"
    . "<li>Non basic groups: If a user belongs to one or more non basic groups (NOT admin, user, anonymous), the current user has access if and only if one of the current user's groups is allowed to allowed to any of the non basic groups; else</li>"
    . '<li>User group: If a user belongs to User group only, the current user has access if and only if one of his groups is allowed to access User group</li>'
    . '</ul>'
);
define('_AM_SUICO_FIELDVISIBLE', 'The field ');
define('_AM_SUICO_FIELDVISIBLEFOR', ' is visible for ');
define('_AM_SUICO_FIELDVISIBLEON', ' viewing a profile of ');
define('_AM_SUICO_FIELDVISIBLETOALL', '- Everyone');
define('_AM_SUICO_FIELDNOTVISIBLE', 'is not visible');
define('_AM_SUICO_CHECKBOX', 'Checkbox');
define('_AM_SUICO_GROUP', 'Group Select');
define('_AM_SUICO_GROUPMULTI', 'Group Multi Select');
define('_AM_SUICO_LANGUAGE', 'Language Select');
define('_AM_SUICO_RADIO', 'Radio Buttons');
define('_AM_SUICO_SELECT', 'Select');
define('_AM_SUICO_SELECTMULTI', 'Multi Select');
define('_AM_SUICO_TEXTAREA', 'Text Area');
define('_AM_SUICO_DHTMLTEXTAREA', 'DHTML Text Area');
define('_AM_SUICO_TEXTBOX', 'Text Field');
define('_AM_SUICO_TIMEZONE', 'Time zone');
define('_AM_SUICO_YESNO', 'Radio Yes/No');
define('_AM_SUICO_DATE', 'Date');
define('_AM_SUICO_AUTOTEXT', 'Auto Text');
define('_AM_SUICO_DATETIME', 'Date and Time');
define('_AM_SUICO_LONGDATE', 'Long Date');
define('_AM_SUICO_ADDOPTION', 'Add Option');
define('_AM_SUICO_REMOVEOPTIONS', 'Remove Options');
define('_AM_SUICO_KEY', 'Value to be stored');
define('_AM_SUICO_VALUE', 'Text to be displayed');
define('_AM_SUICO_EDITUSER', 'Edit User');
define('_AM_SUICO_SELECTUSER', 'Select User');
define('_AM_SUICO_ADDUSER', 'Add User');
define('_AM_SUICO_THEME', 'Theme');
define('_AM_SUICO_RANK', 'Rank');
define('_AM_SUICO_USERDONEXIT', "User doesn't exist!");
define('_SUICO_MD_USERLEVEL', 'User Level');
define('_SUICO_MD_ACTIVE', 'Active');
define('_SUICO_MD_INACTIVE', 'Inactive');
define('_AM_SUICO_USERCREATED', 'User Created');
define('_AM_SUICO_CANNOTDELETESELF', 'Deleting your own account is not allowed - use your profile page to delete your own account');
define('_AM_SUICO_CANNOTDELETEADMIN', 'Deleting an administrator account is not allowed');
define('_AM_SUICO_NOSELECTION', 'No user selected');
define('_AM_SUICO_USER_ACTIVATED', 'User activated');
define('_AM_SUICO_USER_DEACTIVATED', 'User deactivated');
define('_AM_SUICO_USER_NOT_ACTIVATED', 'Error: User NOT activated');
define('_AM_SUICO_USER_NOT_DEACTIVATED', 'Error: User NOT deactivated');
define('_AM_SUICO_STEPNAME', 'Step name');
define('_AM_SUICO_STEPORDER', 'Step order');
define('_AM_SUICO_STEPSAVE', 'Save after step');
define('_AM_SUICO_STEPINTRO', 'Step description');
define('_AM_SUICO_ACTION', 'Action');
define('_AM_SUICO_REQUIRED_TOGGLE', 'Toggle Required Field');
define('_AM_SUICO_REQUIRED_TOGGLE_SUCCESS', 'Successfully Changed Required Field ');
define('_AM_SUICO_REQUIRED_TOGGLE_FAILED', 'Changing Required Field Failed');
define('_AM_SUICO_SAVESTEP_TOGGLE', 'Toggle Save');
define('_AM_SUICO_SAVESTEP_TOGGLE_SUCCESS', 'Successfully Changed Save After Step');
define('_AM_SUICO_SAVESTEP_TOGGLE_FAILED', "Changing 'Save After Step' Failed");
define('_AM_SUICO_CANNOTDEACTIVATEWEBMASTERS', 'You cannot deactivate Webmaster account');

