<?php
// $Id: xoops_version.php,v 1.44 2008/04/20 18:02:48 marcellobrandao Exp $
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
$modversion['name'] = 'Social Network';
$modversion['version'] = '3.3';
$modversion['description'] = _MI_YOGURT_MODULEDESC;
$modversion['credits'] = 'The XOOPS Project, The ImpressCMS Project, Jquery Lightbox, Komeia, vaughan,';
$modversion['author'] = 'Marcello Brandao';
$modversion['help'] = 'help.html';
$modversion['license'] = _MI_YOGURT_LICENSE;
$modversion['official'] = 1;
$modversion['image'] = 'images/slogo.png';
$modversion['dirname'] = 'yogurt';
// SX Updater/Installer
$modversion['simpleversion']= "3.3.1";
$modversion['simplename'] 	= "yogurt";
$modversion['simpleid'] 	= 22;

//Adicionado para rodar no about
$modversion['developer_website_url'] = 'https://sourceforge.net/projects/galeriayogurt/';
$modversion['developer_website_name'] = 'Sourceforge - galeriayogurt';
$modversion['developer_email'] = 'marcello.brandao@gmail.com';
$modversion['status_version'] = 'RC2';
$modversion['status'] = 'RC2';
$modversion['date'] = '2007-08-26';

$modversion['people']['developers'][] = 'Suico (Dev)';
$modversion['people']['developers'][] = 'Alfred (Dev)';
$modversion['people']['developers'][] = 'm0nty_ (Dev)';
$modversion['people']['developers'][] = 'sato-san (Design)';

$modversion['people']['testers'][] = 'Luix (xoopstotal.com.br)';
$modversion['people']['testers'][] = 'BoOot (xoopstotal.com.br)';
$modversion['people']['testers'][] = 'Rodrigo (komeia)';
$modversion['people']['testers'][] = 'Casar Felipe (komeia)';

$modversion['people']['translators'][] = 'Wizanda (english)';
$modversion['people']['translators'][] = 'Daniel Woo (simplified chinese)';
$modversion['people']['translators'][] = 'Werner Feichtlbauer (german)';
$modversion['people']['translators'][] = 'Francesco (italian)';
$modversion['people']['translators'][] = 'Erik Philippe (french)';
//$modversion['people']['documenters'][] = "documenter 1";

$modversion['people']['other'][] = 'Komeia (patrocanio)';

$modversion['demo_site_url'] = 'http://www.marcellobrandao.eti.br';
$modversion['demo_site_name'] = 'Marcello Brandao Site';
$modversion['support_site_url'] = 'http://sourceforge.net/projects/galeriayogurt/';
$modversion['support_site_name'] = 'Sourceforge';
$modversion['submit_bug'] = 'http://sourceforge.net/tracker/?func=add&group_id=204109&atid=988288';
$modversion['submit_feature'] = 'http://sourceforge.net/tracker/?func=add&group_id=204109&atid=988291';

$modversion['hasMain'] = 1;

$modversion['sub'][1]['name'] = _MI_YOGURT_SEARCH;
$modversion['sub'][1]['url'] = 'searchmembers.php';
$modversion['sub'][2]['name'] = _MI_YOGURT_MYPROFILE;
$modversion['sub'][2]['url'] = 'index.php';

global $xoopsModule;
if (is_object($xoopsModule) && $xoopsModule->dirname() == $modversion['dirname']) {
  $mod_handler =& xoops_gethandler('module');
  $mod_yogurt  =& $mod_handler->getByDirname('yogurt');
  $conf_handler =& xoops_gethandler('config');
  $moduleConfig   =& $conf_handler->getConfigsByCat(0, $mod_yogurt->getVar('mid'));


  if ($moduleConfig['enable_scraps']==1){ 
    $modversion['sub'][3]['name'] = _MI_YOGURT_MYSCRAPS;
    $modversion['sub'][3]['url'] = "scrapbook.php";
  }
  if ($moduleConfig['enable_pictures']==1){
    $modversion['sub'][4]['name'] = _MI_YOGURT_MYPICTURES;
    $modversion['sub'][4]['url'] = "album.php";
  }
  if ($moduleConfig['enable_audio']==1){
    $modversion['sub'][5]['name'] = _MI_YOGURT_MYAUDIOS;
    $modversion['sub'][5]['url'] = "audio.php";
  }
  if ($moduleConfig['enable_videos']==1){ 
    $modversion['sub'][6]['name'] = _MI_YOGURT_MYVIDEOS;
    $modversion['sub'][6]['url'] = "seutubo.php";
  }
  if ($moduleConfig['enable_friends']==1){ 
    $modversion['sub'][7]['name'] = _MI_YOGURT_MYFRIENDS;
    $modversion['sub'][7]['url'] = "friends.php";
  }
  if ($moduleConfig['enable_tribes']==1){ 
    $modversion['sub'][8]['name'] = _MI_YOGURT_MYTRIBES;
    $modversion['sub'][8]['url'] = "tribes.php";
  }
}
$modversion['sub'][9]['name'] = _MI_YOGURT_MYCONFIGS;
$modversion['sub'][9]['url'] = "configs.php";


$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

//$modversion['config'][1]['valuetype'] = 'int';
//can be 'int', 'float', 'textarea' or 'array'. All items with formtype 'multi_xxx' must have the valuetype 'array'
$i=1;
$modversion['config'][$i]['name'] = 'enable_pictures';
$modversion['config'][$i]['title'] = '_MI_YOG_ENABLEPICT_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_ENABLEPICT_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'nb_pict';
$modversion['config'][$i]['title'] = '_MI_YOG_NUMBPICT_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_NUMBPICT_DESC';
$modversion['config'][$i]['default'] = 12;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
/*
$modversion['config'][$i]['name'] = 'path_upload';
$modversion['config'][$i]['title'] = '_MI_YOG_PATHUPLOAD_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_PATHUPLOAD_DESC';
$modversion['config'][$i]['default'] = XOOPS_ROOT_PATH."/uploads/";
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$i++;
$modversion['config'][$i]['name'] = 'link_path_upload';
$modversion['config'][$i]['title'] = '_MI_YOG_LINKPATHUPLOAD_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_LINKPATHUPLOAD_DESC';
$modversion['config'][$i]['default'] = XOOPS_UPLOAD_URL;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$i++;*/
$modversion['config'][$i]['name'] = 'thumb_width';
$modversion['config'][$i]['title'] = '_MI_YOG_THUMW_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_THUMBW_DESC';
$modversion['config'][$i]['default'] = 125;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'thumb_height';
$modversion['config'][$i]['title'] = '_MI_YOG_THUMBH_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_THUMBH_DESC';
$modversion['config'][$i]['default'] = 175;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'resized_width';
$modversion['config'][$i]['title'] = '_MI_YOG_RESIZEDW_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_RESIZEDW_DESC';
$modversion['config'][$i]['default'] = 650;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'resized_height';
$modversion['config'][$i]['title'] = '_MI_YOG_RESIZEDH_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_RESIZEDH_DESC';
$modversion['config'][$i]['default'] = 450;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'max_original_width';
$modversion['config'][$i]['title'] = '_MI_YOG_ORIGINALW_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_ORIGINALW_DESC';
$modversion['config'][$i]['default'] = 2048;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'max_original_height';
$modversion['config'][$i]['title'] = '_MI_YOG_ORIGINALH_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_ORIGINALH_DESC';
$modversion['config'][$i]['default'] = 1600;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'maxfilesize';
$modversion['config'][$i]['title'] = '_MI_YOG_MAXFILEBYTES_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_MAXFILEBYTES_DESC';
$modversion['config'][$i]['default'] = 512000;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'picturesperpage';
$modversion['config'][$i]['title'] = '_MI_YOG_PICTURESPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_PICTURESPERPAGE_DESC';
$modversion['config'][$i]['default'] = 6;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'physical_delete';
$modversion['config'][$i]['title'] = '_MI_YOG_DELETEPHYSICAL_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_DELETEPHYSICAL_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'images_order';
$modversion['config'][$i]['title'] = '_MI_YOG_IMGORDER_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_IMGORDER_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_friends';
$modversion['config'][$i]['title'] = '_MI_YOG_ENABLEFRIENDS_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_ENABLEFRIENDS_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'friendsperpage';
$modversion['config'][$i]['title'] = '_MI_YOG_FRIENDSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_FRIENDSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 12;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_audio';
$modversion['config'][$i]['title'] = '_MI_YOG_ENABLEAUDIO_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_ENABLEAUDIO_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'nb_audio';
$modversion['config'][$i]['title'] = '_MI_YOG_NUMBAUDIO_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_NUMBAUDIO_DESC';
$modversion['config'][$i]['default'] = 12;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'audiosperpage';
$modversion['config'][$i]['title'] = '_MI_YOG_AUDIOSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_AUDIOSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 20;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_videos';
$modversion['config'][$i]['title'] = '_MI_YOG_ENABLEVIDEOS_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_ENABLEVIDEOS_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'videosperpage';
$modversion['config'][$i]['title'] = '_MI_YOG_VIDEOSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_VIDEOSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 6;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;


$modversion['config'][$i]['name'] = 'width_tube';
$modversion['config'][$i]['title'] = '_MI_YOG_TUBEW_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_TUBEW_DESC';
$modversion['config'][$i]['default'] = 450;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'height_tube';
$modversion['config'][$i]['title'] = '_MI_YOG_TUBEH_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_TUBEH_DESC';
$modversion['config'][$i]['default'] = 350;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'width_maintube';
$modversion['config'][$i]['title'] = '_MI_YOG_MAINTUBEW_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_MAINTUBEW_DESC';
$modversion['config'][$i]['default'] = 250;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'height_maintube';
$modversion['config'][$i]['title'] = '_MI_YOG_MAINTUBEH_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_MAINTUBEH_DESC';
$modversion['config'][$i]['default'] = 210;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_tribes';
$modversion['config'][$i]['title'] = '_MI_YOG_ENABLETRIBES_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_ENABLETRIBES_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'tribesperpage';
$modversion['config'][$i]['title'] = '_MI_YOG_TRIBESPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_TRIBESPERPAGE_DESC';
$modversion['config'][$i]['default'] = 6;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'enable_scraps';
$modversion['config'][$i]['title'] = '_MI_YOG_ENABLESCRAPS_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_ENABLESCRAPS_DESC';
$modversion['config'][$i]['default'] = 1;
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$i++;
$modversion['config'][$i]['name'] = 'scrapsperpage';
$modversion['config'][$i]['title'] = '_MI_YOG_SCRAPSPERPAGE_TITLE';
$modversion['config'][$i]['description'] = '_MI_YOG_SCRAPSPERPAGE_DESC';
$modversion['config'][$i]['default'] = 20;
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';


$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['tables'][0] = "yogurt_images";
$modversion['tables'][1] = "yogurt_friendship";
$modversion['tables'][2] = "yogurt_visitors";
$modversion['tables'][3] = "yogurt_seutubo";
$modversion['tables'][4] = "yogurt_friendpetition";
$modversion['tables'][5] = "yogurt_tribes";
$modversion['tables'][6] = "yogurt_reltribeuser";
$modversion['tables'][7] = "yogurt_scraps";
$modversion['tables'][8] = "yogurt_configs";
$modversion['tables'][9] = "yogurt_suspensions";
$modversion['tables'][10] = "yogurt_audio";

$i=1;
$modversion['templates'][$i]['file'] = 'yogurt_navbar.html';
$modversion['templates'][$i]['description'] = _MI_YOG_TEMPLATENAVBARDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_index.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATEINDEXDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_friends.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATEFRIENDSDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_scrapbook.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATESCRAPBOOKDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_audio.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATEAUDIODESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_seutubo.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATESEUTUBODESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_album.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATEALBUMDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_tribes.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATETRIBESDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_configs.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATECONFIGSDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_footer.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATEFOOTERDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_edittribe.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATEEDITTRIBE;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_tribes_results.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATESEARCHRESULTDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_tribe.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATETRIBEDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_searchresults.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATESEARCHRESULTSDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_searchform.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATESEARCHFORMDESC;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_notifications.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATENOTIFICATIONS;
$i++;
$modversion['templates'][$i]['file'] = 'yogurt_fans.html';
$modversion['templates'][$i]['description'] = _MI_YOG_PICTURE_TEMPLATEFANS;

$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'tribe_id';
$modversion['comments']['pageName'] = 'tribe.php';

// Search
$modversion['hasSearch'] = 0;//disabled for version 3.0 will come back in a next release
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "yogurt_search";

//Notifications
$modversion['hasNotification'] = 1;
$modversion['notification']['category'][1]['name'] = 'picture';
$modversion['notification']['category'][1]['title'] = _MI_YOG_PICTURE_NOTIFYTIT;
$modversion['notification']['category'][1]['description'] = _MI_YOG_PICTURE_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = 'album.php';
$modversion['notification']['category'][1]['item_name'] = 'uid';
$modversion['notification']['category'][1]['allow_bookmark'] = 1;
        $modversion['notification']['event'][1]['name'] = 'new_picture';
        $modversion['notification']['event'][1]['category'] = 'picture';
        $modversion['notification']['event'][1]['title'] = _MI_YOG_PICTURE_NEWPIC_NOTIFY;
        $modversion['notification']['event'][1]['caption'] = _MI_YOG_PICTURE_NEWPIC_NOTIFYCAP;
        $modversion['notification']['event'][1]['description'] = _MI_YOG_PICTURE_NEWPOST_NOTIFYDSC;
        $modversion['notification']['event'][1]['mail_template'] = 'picture_newpic_notify';
        $modversion['notification']['event'][1]['mail_subject'] = _MI_YOG_PICTURE_NEWPIC_NOTIFYSBJ;

$modversion['notification']['category'][2]['name'] = 'video';
$modversion['notification']['category'][2]['title'] = _MI_YOG_VIDEO_NOTIFYTIT;
$modversion['notification']['category'][2]['description'] = _MI_YOG_VIDEO_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = 'seutubo.php';
$modversion['notification']['category'][2]['item_name'] = 'uid';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;
        $modversion['notification']['event'][2]['name'] = 'new_video';
        $modversion['notification']['event'][2]['category'] = 'video';
        $modversion['notification']['event'][2]['title'] = _MI_YOG_VIDEO_NEWVIDEO_NOTIFY;
        $modversion['notification']['event'][2]['caption'] = _MI_YOG_VIDEO_NEWVIDEO_NOTIFYCAP;
        $modversion['notification']['event'][2]['description'] = _MI_YOG_VIDEO_NEWVIDEO_NOTIFYDSC;
        $modversion['notification']['event'][2]['mail_template'] = 'video_newvideo_notify';
        $modversion['notification']['event'][2]['mail_subject'] = _MI_YOG_VIDEO_NEWVIDEO_NOTIFYSBJ;

$modversion['notification']['category'][3]['name'] = 'scrap';
$modversion['notification']['category'][3]['title'] = _MI_YOG_SCRAP_NOTIFYTIT;
$modversion['notification']['category'][3]['description'] = _MI_YOG_SCRAP_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = 'scrapbook.php';
$modversion['notification']['category'][3]['item_name'] = 'uid';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;
        $modversion['notification']['event'][3]['name'] = 'new_scrap';
        $modversion['notification']['event'][3]['category'] = 'scrap';
        $modversion['notification']['event'][3]['title'] = _MI_YOG_SCRAP_NEWSCRAP_NOTIFY;
        $modversion['notification']['event'][3]['caption'] = _MI_YOG_SCRAP_NEWSCRAP_NOTIFYCAP;
        $modversion['notification']['event'][3]['description'] = _MI_YOG_SCRAP_NEWSCRAP_NOTIFYDSC;
        $modversion['notification']['event'][3]['mail_template'] = 'scrap_newscrap_notify';
        $modversion['notification']['event'][3]['mail_subject'] = _MI_YOG_SCRAP_NEWSCRAP_NOTIFYSBJ;

$modversion['notification']['category'][4]['name'] = 'friendship';
$modversion['notification']['category'][4]['title'] = _MI_YOG_FRIENDSHIP_NOTIFYTIT;
$modversion['notification']['category'][4]['description'] = _MI_YOG_FRIENDSHIP_NOTIFYDSC;
$modversion['notification']['category'][4]['subscribe_from'] = 'friends.php';
$modversion['notification']['category'][4]['item_name'] = 'uid';
$modversion['notification']['category'][4]['allow_bookmark'] = 0;
        $modversion['notification']['event'][4]['name'] = 'new_friendship';
        $modversion['notification']['event'][4]['category'] = 'friendship';
        $modversion['notification']['event'][4]['title'] = _MI_YOG_FRIEND_NEWPETITION_NOTIFY;
        $modversion['notification']['event'][4]['caption'] = _MI_YOG_FRIEND_NEWPETITION_NOTIFYCAP;
        $modversion['notification']['event'][4]['description'] = _MI_YOG_FRIEND_NEWPETITION_NOTIFYDSC;
        $modversion['notification']['event'][4]['mail_template'] = 'friendship_newpetition_notify';
        $modversion['notification']['event'][4]['mail_subject'] = _MI_YOG_FRIEND_NEWPETITION_NOTIFYSBJ;

$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'yogurt_iteminfo';
//$modversion['notification']['tags_file'] = 'include/notification.inc.php';
//$modversion['notification']['tags_func'] = 'yogurt_tags';



$modversion['blocks'][1]['file'] = "blocks.php";
$modversion['blocks'][1]['name'] = _MI_YOGURT_FRIENDS;
$modversion['blocks'][1]['description'] = _MI_YOGURT_FRIENDS_DESC;
$modversion['blocks'][1]['show_func'] = "b_yogurt_friends_show";
$modversion['blocks'][1]['options'] = "5";
$modversion['blocks'][1]['edit_func'] = "b_yogurt_friends_edit";
$modversion['blocks'][1]['template'] = 'yogurt_block_friends.html';

$modversion['blocks'][2]['file'] = "blocks.php";
$modversion['blocks'][2]['name'] = _MI_YOGURT_LAST;
$modversion['blocks'][2]['description'] = _MI_YOGURT_LAST_DESC;
$modversion['blocks'][2]['show_func'] = "b_yogurt_lastpictures_show";
$modversion['blocks'][2]['options'] = "5";
$modversion['blocks'][2]['edit_func'] = "b_yogurt_lastpictures_edit";
$modversion['blocks'][2]['template'] = 'yogurt_block_lastpictures.html';





?>