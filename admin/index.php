<?php
// $Id: index.php,v 1.14 2008/04/13 14:23:43 marcellobrandao Exp $
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

/**
 * index.php, Principal arquivo da administração
 * 
 * Este arquivo foi implementado da seguinte forma
 * Primeiro você tem várias funções
 * Depois você tem um case que vai chamar algumas destas funções de acordo com
 * o paramentro $op
 * @author Marcello Brandão <marcello.brandao@gmail.com>
 * @version 1.0
 * @package admin
 */

/**
 * Arquivo de cabeçalho da administração do Xoops
 */
include '../../../include/cp_header.php';

/**
 * Função que desenha o cabeçalho da administração do Xoops
 */
xoops_cp_header();

$op = (isset($_GET['op']))? $_GET['op'] : "";

/*
if (!@file_exists(XOOPS_ROOT_PATH."/Frameworks/art/functions.admin.php")) {
     
     $isframeworksrequirement = false;
    
} else {
     include_once(XOOPS_ROOT_PATH."/Frameworks/art/functions.admin.php");
     include_once(XOOPS_ROOT_PATH."/Frameworks/xoops_version.php");
   
     if( (str_replace('.', '', XOOPS_FRAMEWORKS_VERSION)) < 110){
     
     $isframeworksrequirement = false;
     
     } else {
     
     $isframeworksrequirement = true;
     
     }
}

*/
$isframeworksrequirement = false;

/**
 * Para termos as configs dentro da parte de admin
 */
    global $xoopsModuleConfig, $xoopsModule;
function about(){
    $module_handler =& xoops_gethandler('module');
    $modulo         =& $module_handler->getByDirname('yogurt');     
     echo "<br style='clear: both;' />
<img src='".XOOPS_URL."/modules/".$modulo->getInfo("dirname")."/".$modulo->getInfo("image")."' alt='Yogurt' style='float: left; margin-right: 10px;'/></a>
<div style='margin-top: 1px; color: #33538e; margin-bottom: 4px; font-size: 18px; line-height: 18px; font-weight: bold;'>
    ".$modulo->getInfo("name")." ".$modulo->getInfo("version")."</div>

<div style='line-height: 16px; font-weight: bold;'>
    "._MA_YOG_BY." ".$modulo->getInfo("author")."
</div>

<div style = 'line-height: 16px; '>
     ".$modulo->getInfo("license")."

</div>
<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
    <tr>
        <td class='bg3'><b>"._MA_YOG_DESC."</b></td>
    </tr>

    <tr>
        <td class='even'>".$modulo->getInfo("description")."</td>
    </tr>
</table>
    <table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
        <tr>
            <td class='bg3'><b>"._MA_YOG_CREDITS."</b></td>
        </tr>

        <tr>
            <td class='even'>".$modulo->getInfo("credits")."</td>

        </tr>
    </table>

<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
    <tr>
        <td colspan='2' class='bg3'>
            <b>"._MA_YOG_CONTRIBUTORS."</b>
        </td>
    </tr>

    
    
            <tr>
            <td class='head' style='vertical-align: top;' width = '150px'>"._MA_YOG_DEVELOPERS."</td>
            <td class='even'>
                                    <div>";
     
     
     $vetorpessoas = $modulo->getInfo("people");
     $vetordevelopers = $vetorpessoas['developers'];
     foreach ($vetordevelopers as $developer){
          echo $developer."&nbsp;";
               }
     echo "</div>
                 </td>
        </tr>
    
            <tr>

            <td class='head' style='vertical-align: top;' width = '150px'>"._MA_YOG_TESTERS."</td>
            <td class='even'>
                                    <div>";
       
     $vetortesters = $vetorpessoas['testers'];
     foreach ($vetortesters as $tester){
          echo $tester."&nbsp;";
               }
                                                        
                                                        echo "</div>
                 </td>
        </tr>
    
    
    
    
            <tr>
            <td class='head' width = '150px'>"._MA_YOG_TRANSLATIONS."</td>

            <td class='even'>";
       
     $vetortranslators = $vetorpessoas['translators'];
     foreach ($vetortranslators as $translator){
          echo $translator."&nbsp;";
               }
                                                        
                                                        echo "</td>
        </tr>
    
            <tr>
            <td class='head' width = '150px'>"._MA_YOG_EMAIL."</td>
            <td class='even'><a href='mailto:".$modulo->getInfo("developer_email")."' target='_blank'>".$modulo->getInfo("developer_email")."</a></td>
        </tr>
</table>

<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
    <tr>
        <td colspan='2' class='bg3'><b>"._MA_YOG_MODDEVDET."</b></td>
    </tr>

    <tr>
        <td class='head' width = '200px'>"._MA_YOG_RELEASEDATE."</td>
        <td class='even'>".$modulo->getInfo("date")."</td>

    </tr>

    <tr>
        <td class='head' width = '200px'>"._MA_YOG_STATUS."</td>
        <td class='even'>".$modulo->getInfo("status")."</td>
    </tr>

    
            <tr>
            <td class='head' width = '200px'>"._MA_YOG_OFCSUPORTSITE."</td>

            <td class='even'><a href='".$modulo->getInfo("support_site_url")."' target='_blank'>".$modulo->getInfo("support_site_url")."</a></td>
        </tr>
    
    
</table>




<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
    <tr>
        <td class='bg3'><b>"._MA_YOG_VERSIONHIST."</b></td>

    </tr>

    <tr>
        <td class='even'>
            <div style='line-height: 18px;'><b><u>=> Version 3.3 RC2 (2008-08)</u></b><br />
                > A many bugfixes: Security and Bugs from Sourceforge <br />
				- Developed for ImpressCMS 1.0.x and 1.1.x<br />
				- Developed for XOOPS 2.0.x and 2.2.x<br />
                             </div>
            <div style='line-height: 18px;'><b><u>=> Version 3.2 RC1 (2008)</u></b><br />
                > 2 new features: Fans page and notifications upon new friend petition <br />
                             </div>
            <div style='line-height: 18px;'><b><u>=> Version 3.1 BETA 3 (2008)</u></b><br />
                > Bug Corrections (many of them) <br />
                             </div>
            <div style='line-height: 18px;'><b><u>=> Version 3.0 BETA 2 (2008)</u></b><br />
                > Bug Corrections (many of them) <br />
                             </div>
         <div style='line-height: 18px;'><b><u>=> Version 2.9 BETA (2007)</u></b><br />
                > Transformed to Social Network Module <br />
                             </div>
                <div style='line-height: 18px;'><b><u>=> Version 1.0 RC1 (2007)</u></b><br />
                > fixed minor bugs <br />
                > documentation <br />
            
            - Developed for XOOPS 2.0.17 </div>
            <div style='line-height: 18px;'><b><u>=> Version 0.9 (2007)</u></b><br />
                        >Added search feature<br />
                        > Added comments system (2007)<br />
                        > fixed minor bugs <br />
            
            - Developed for XOOPS 2.0.17 </div>
                        <div style='line-height: 18px;'><b><u>=> Version 0.1 (2007)</u></b><br />
           
            - Developed for XOOPS 2.0.16 </div>

        </td>
    </tr>
</table>
   
";
}

function homedefault(){

global $isframeworksrequirement;
echo _MA_YOG_CONFIGEVERYTHING;
//echo "<a href='../../system/admin.php?fct=modulesadmin&op=update&module=yogurt'>Update</a>";

echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
        <tr>
            <td class='bg3'><b>"._MA_YOG_ALLTESTSOK."</b></td>
        </tr>";
$a = mysql_get_server_info();
//$b = substr($a, 0, strpos($a, "-"));
$b = explode("-",$a,2);
$b=$b[0];
$c = explode(".",$b);
echo "<tr><td class='odd'>";
if ($c[0]>4 || ($c[0]==4 && $c[1]>0)) {
  echo "<img src='../images/green.gif' align='baseline'> ";
  echo "Mysql Version:<b>".$b;
} else {
  echo "<img src='../images/red.gif'> ";
  echo "Mysql Version:<b>".$b. "</b>. You must use a version higher than 4.1 </td></tr>";
} 
if (extension_loaded('gd')) {
echo "        <tr>
            <td class='even'><img src='../images/green.gif' align='baseline'> "._MA_YOG_GDEXTENSIONOK."
     
     "._MA_YOG_MOREINFO." <a href='http://www.libgd.org/Main_Page'> Gd Library</a> </td>

        </tr>";
                
} else {
     echo "
<tr>
            <td class='even'><img src='../images/red.gif'> "._MA_YOG_GDEXTENSIONFALSE." "
     ._MA_YOG_CONFIGPHPINI."
     "._MA_YOG_MOREINFO." <a href='http://www.libgd.org/Main_Page'>Gd Library</a> </td>

        </tr>";}
if ( (str_replace('.', '', PHP_VERSION)) > 499 ){              
 echo "              <tr>
            <td class='odd'><img src='../images/green.gif' align='baseline'> "._MA_YOG_PHP5PRESENT." ". PHP_VERSION."</td>

        </tr>";} else {
     echo "
                <tr>
            <td class='odd'><img src='../images/red.gif' align='baseline'> "._MA_YOG_PHP5NOTPRESENT." ". PHP_VERSION."</td>

        </tr>
    
     ";}

/*                    
if ($isframeworksrequirement){
     echo "
       <tr>
      <td class='even'><img src='../images/green.gif' align='baseline'> ";         
         printf(_MA_YOG_FRAMEWORKSTRUE,XOOPS_FRAMEWORKS_VERSION);         
          echo "</td>
        </tr>
        ";
}else {
       echo "<tr>
            <td class='even'><img src='../images/red.gif' align='baseline'> "._MA_YOG_FRAMEWORKSFALSE."</td>
        </tr>
     ";
}
*/
if (!is_dir(XOOPS_ROOT_PATH."/uploads/yogurt/mp3/")) {
  echo "<tr>
          <td class='odd'><img src='../images/red.gif'> /uploads/yogurt/mp3/ is not exists</td>
        </tr>";
}elseif (!is_writable(XOOPS_ROOT_PATH."/uploads/yogurt/mp3/")) {
  echo "<tr>
          <td class='odd'><img src='../images/red.gif'> /uploads/yogurt/mp3/ is not writable</td>
        </tr>";
}else{
  echo "<tr>
          <td class='odd'><img src='../images/green.gif' align='baseline'> /uploads/yogurt/mp3/ exists and writable</td>
        </tr>";
}

echo "<tr><td class='odd'><img src='../images/messagebox_info.gif'> ".sprintf(_MA_YOG_MAXBYTESPHPINI,ini_get('post_max_size'))."</td></tr>";     
if (function_exists('memory_get_usage')){
echo "<tr><td class='even'><img src='../images/messagebox_info.gif'> "._MA_YOG_MEMORYLIMIT." ".memory_get_usage()."</td></tr>";     
}
echo "</table>";
}

function renderUglierMenu($currentoption, $breadcrumb = ""){
    //$module_handler =& xoops_gethandler('module');
    //$modulo         =& $module_handler->getByDirname('yogurt'); 
    //echo "<div class='buttontop'><a href='index.php'>Home</a> - <a href='index.php?op=about'>About</a> - <a href='../../system/admin.php?fct=preferences&op=showmod&mod=".$modulo->getVar('mid')."'>Preferences</a> - <a href='../index.php'>Go to Module</a></div>";
	$adminmenu = array();
	
	if(!@include XOOPS_ROOT_PATH."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/".$GLOBALS["xoopsModule"]->getInfo("adminmenu")){
		return null;
	}
	$breadcrumb = empty($breadcrumb) ? $adminmenu[$currentoption]["title"] : $breadcrumb;
	$module_link = XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/";
	//$image_link = XOOPS_URL."/Frameworks/compat/include";
	$image_link = XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/images";
	
	$adminmenu_text ='
	<style type="text/css">
	<!--
	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0;}
	#buttonbar { float:left; width:100%; background: #e7e7e7 url("'.$image_link.'/modadminbg.gif") repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px;}
	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
	#buttonbar li { display:inline; margin:0; padding:0; }
	#buttonbar a { float:left; background:url("'.$image_link.'/left_both.gif") no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
	#buttonbar a span { float:left; display:block; background:url("'.$image_link.'/right_both.gif") no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
	/* Commented Backslash Hack hides rule from IE5-Mac \*/
	#buttonbar a span {float:none;}
	/* End IE5-Mac hack */
	#buttonbar a:hover span { color:#333; }
	#buttonbar .current a { background-position:0 -150px; border-width:0; }
	#buttonbar .current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
	#buttonbar a:hover { background-position:0% -150px; }
	#buttonbar a:hover span { background-position:100% -150px; }	
	//-->
	</style>
	<div id="buttontop">
	 <table style="width: 100%; padding: 0; " cellspacing="0">
	     <tr>
	         <td style="width: 70%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">
	             <a href="../index.php">'.$GLOBALS["xoopsModule"]->getVar("name").'</a>
	         </td>
	         <td style="width: 30%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;">
	             <b>'.$GLOBALS["xoopsModule"]->getVar("name").'</b>&nbsp;'.$breadcrumb.'
	         </td>
	     </tr>
	 </table>
	</div>
	<div id="buttonbar">
	 <ul>
	';
	foreach(array_keys($adminmenu) as $key){
		$adminmenu_text .= (($currentoption == $key) ? '<li class="current">':'<li>').'<a href="'.$module_link.$adminmenu[$key]["link"].'"><span>'.$adminmenu[$key]["title"].'</span></a></li>';
	}
	$adminmenu_text .= '<li><a href="'.XOOPS_URL.'/modules/system/admin.php?fct=preferences&op=showmod&mod='.$GLOBALS["xoopsModule"]->getVar("mid").'"><span>'._PREFERENCES.'</span></a></li>';
	$adminmenu_text .='
	 </ul>
	</div>
	<br style="clear:both;" />';
	
	echo $adminmenu_text;
}
	 
switch ($op) {

        case "about":
        if ($isframeworksrequirement){
            loadModuleAdminMenu(2,"-> About");
        }else {
          renderUglierMenu(2,"-> About");
          }
            about();

            
            break;
default:
if ($isframeworksrequirement){
        loadModuleAdminMenu(1,"-> home");
} else {
     renderUglierMenu(1,"-> home");
     }
        homedefault();
        
    break;
}

    

//fechamento das tags de if lá de cimão verificação se os arquivos do phppp existem
xoops_cp_footer();
?>