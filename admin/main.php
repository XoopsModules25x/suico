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

/**
 * main.php, Main administration file *
 * This file was implemented as follows
 * First you have several functions
 * Then you have a case that will call some of these functions according to
 * the $ op parameter
 */

/**
 * Xoops admin header file
 */
require_once __DIR__ . '/admin_header.php';

/**
 * Function that draws the header of the Xoops administration
 */
xoops_cp_header();

$op = isset($_GET['op']) ? $_GET['op'] : '';

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
function about()
{
    $moduleHandler = xoops_getHandler('module');
    $modulo        = $moduleHandler->getByDirname('yogurt');
    echo "<br style='clear: both;'>
<img src='" . XOOPS_URL . '/modules/' . $modulo->getInfo('dirname') . '/' . $modulo->getInfo('image') . "' alt='Yogurt' style='float: left; margin-right: 10px;'></a>
<div style='margin-top: 1px; color: #33538e; margin-bottom: 4px; font-size: 18px; line-height: 18px; font-weight: bold;'>
    " . $modulo->getInfo('name') . ' ' . $modulo->getInfo('version') . "</div>

<div style='line-height: 16px; font-weight: bold;'>
    " . _MA_YOGURT_BY . ' ' . $modulo->getInfo('author') . "
</div>

<div style = 'line-height: 16px; '>
     " . $modulo->getInfo('license') . "

</div>
<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
    <tr>
        <td class='bg3'><b>" . _MA_YOGURT_DESC . "</b></td>
    </tr>

    <tr>
        <td class='even'>" . $modulo->getInfo('description') . "</td>
    </tr>
</table>
    <table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
        <tr>
            <td class='bg3'><b>" . _MA_YOGURT_CREDITS . "</b></td>
        </tr>

        <tr>
            <td class='even'>" . $modulo->getInfo('credits') . "</td>

        </tr>
    </table>

<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
    <tr>
        <td colspan='2' class='bg3'>
            <b>" . _MA_YOGURT_CONTRIBUTORS . "</b>
        </td>
    </tr>



            <tr>
            <td class='head' style='vertical-align: top;' width = '150px'>" . _MA_YOGURT_DEVELOPERS . "</td>
            <td class='even'>
                                    <div>";

    $vetorpessoas    = $modulo->getInfo('people');
    $vetordevelopers = $vetorpessoas['developers'];
    foreach ($vetordevelopers as $developer) {
        echo $developer . '&nbsp;';
    }
    echo "</div>
                 </td>
        </tr>

            <tr>

            <td class='head' style='vertical-align: top;' width = '150px'>" . _MA_YOGURT_TESTERS . "</td>
            <td class='even'>
                                    <div>";

    $vetortesters = $vetorpessoas['testers'];
    foreach ($vetortesters as $tester) {
        echo $tester . '&nbsp;';
    }

    echo "</div>
                 </td>
        </tr>




            <tr>
            <td class='head' width = '150px'>" . _MA_YOGURT_TRANSLATIONS . "</td>

            <td class='even'>";

    $vetortranslators = $vetorpessoas['translators'];
    foreach ($vetortranslators as $translator) {
        echo $translator . '&nbsp;';
    }

    echo "</td>
        </tr>

            <tr>
            <td class='head' width = '150px'>" . _MA_YOGURT_EMAIL . "</td>
            <td class='even'><a href='mailto:" . $modulo->getInfo('developer_email') . "' target='_blank'>" . $modulo->getInfo('developer_email') . "</a></td>
        </tr>
</table>

<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
    <tr>
        <td colspan='2' class='bg3'><b>" . _MA_YOGURT_MODDEVDET . "</b></td>
    </tr>

    <tr>
        <td class='head' width = '200px'>" . _MA_YOGURT_RELEASEDATE . "</td>
        <td class='even'>" . $modulo->getInfo('date') . "</td>

    </tr>

    <tr>
        <td class='head' width = '200px'>" . _MA_YOGURT_STATUS . "</td>
        <td class='even'>" . $modulo->getInfo('status') . "</td>
    </tr>


            <tr>
            <td class='head' width = '200px'>" . _MA_YOGURT_OFCSUPORTSITE . "</td>

            <td class='even'><a href='" . $modulo->getInfo('support_site_url') . "' target='_blank'>" . $modulo->getInfo('support_site_url') . "</a></td>
        </tr>


</table>




<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
    <tr>
        <td class='bg3'><b>" . _MA_YOGURT_VERSIONHIST . "</b></td>

    </tr>

    <tr>
        <td class='even'>
            <div style='line-height: 18px;'><b><u>=> Version 3.3 RC2 (2008-08)</u></b><br>
               > A many bugfixes: Security and Bugs from Sourceforge <br>
                - Developed for ImpressCMS 1.0.x and 1.1.x<br>
                - Developed for XOOPS 2.0.x and 2.2.x<br>
                             </div>
            <div style='line-height: 18px;'><b><u>=> Version 3.2 RC1 (2008)</u></b><br>
               > 2 new features: Fans page and notifications upon new friend petition <br>
                             </div>
            <div style='line-height: 18px;'><b><u>=> Version 3.1 BETA 3 (2008)</u></b><br>
               > Bug Corrections (many of them) <br>
                             </div>
            <div style='line-height: 18px;'><b><u>=> Version 3.0 BETA 2 (2008)</u></b><br>
               > Bug Corrections (many of them) <br>
                             </div>
         <div style='line-height: 18px;'><b><u>=> Version 2.9 BETA (2007)</u></b><br>
               > Transformed to Social Network Module <br>
                             </div>
                <div style='line-height: 18px;'><b><u>=> Version 1.0 RC1 (2007)</u></b><br>
               > fixed minor bugs <br>
               > documentation <br>

            - Developed for XOOPS 2.0.17 </div>
            <div style='line-height: 18px;'><b><u>=> Version 0.9 (2007)</u></b><br>
                       >Added search feature<br>
                       > Added comments system (2007)<br>
                       > fixed minor bugs <br>

            - Developed for XOOPS 2.0.17 </div>
                        <div style='line-height: 18px;'><b><u>=> Version 0.1 (2007)</u></b><br>

            - Developed for XOOPS 2.0.16 </div>

        </td>
    </tr>
</table>

";
}

function homedefault()
{
    global $isframeworksrequirement;
    echo _MA_YOGURT_CONFIGEVERYTHING;
    //echo "<a href='../../system/admin.php?fct=modulesadmin&op=update&module=yogurt'>Update</a>";

    echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
        <tr>
            <td class='bg3'><b>" . _MA_YOGURT_ALLTESTSOK . '</b></td>
        </tr>';
    $a = $GLOBALS['xoopsDB']->getServerVersion();
    //$b = substr($a, 0, strpos($a, "-"));
    $b = explode('-', $a, 2);
    $b = $b[0];
    $c = explode('.', $b);
    echo "<tr><td class='odd'>";
    if ($c[0] > 4 || (4 == $c[0] && $c[1] > 0)) {
        echo "<img src='../assets/images/green.gif' align='baseline'> ";
        echo 'Mysql Version:<b>' . $b;
    } else {
        echo "<img src='../assets/images/red.gif'> ";
        echo 'Mysql Version:<b>' . $b . '</b>. You must use a version higher than 4.1 </td></tr>';
    }
    if (extension_loaded('gd')) {
        echo "        <tr>
            <td class='even'><img src='../assets/images/green.gif' align='baseline'> " . _MA_YOGURT_GDEXTENSIONOK . '

     ' . _MA_YOGURT_MOREINFO . " <a href='http://www.libgd.org/Main_Page'> Gd Library</a> </td>

        </tr>";
    } else {
        echo "
<tr>
            <td class='even'><img src='../assets/images/red.gif'> " . _MA_YOGURT_GDEXTENSIONFALSE . ' ' . _MA_YOGURT_CONFIGPHPINI . '
     ' . _MA_YOGURT_MOREINFO . " <a href='http://www.libgd.org/Main_Page'>Gd Library</a> </td>

        </tr>";
    }
    if (str_replace('.', '', PHP_VERSION) > 499) {
        echo "              <tr>
            <td class='odd'><img src='../assets/images/green.gif' align='baseline'> " . _MA_YOGURT_PHP5PRESENT . ' ' . PHP_VERSION . '</td>

        </tr>';
    } else {
        echo "
                <tr>
            <td class='odd'><img src='../assets/images/red.gif' align='baseline'> " . _MA_YOGURT_PHP5NOTPRESENT . ' ' . PHP_VERSION . '</td>

        </tr>

     ';
    }

    /*
    if ($isframeworksrequirement){
         echo "
           <tr>
          <td class='even'><img src='../assets/images/green.gif' align='baseline'> ";
             printf(_MA_YOGURT_FRAMEWORKSTRUE,XOOPS_FRAMEWORKS_VERSION);
              echo "</td>
            </tr>
            ";
    }else {
           echo "<tr>
                <td class='even'><img src='../assets/images/red.gif' align='baseline'> "._MA_YOGURT_FRAMEWORKSFALSE."</td>
            </tr>
         ";
    }
    */
    if (!is_dir(XOOPS_ROOT_PATH . '/uploads/yogurt/mp3/')) {
        echo "<tr>
          <td class='odd'><img src='../assets/images/red.gif'> /uploads/yogurt/mp3/ is not exists</td>
        </tr>";
    } elseif (!is_writable(XOOPS_ROOT_PATH . '/uploads/yogurt/mp3/')) {
        echo "<tr>
          <td class='odd'><img src='../assets/images/red.gif'> /uploads/yogurt/mp3/ is not writable</td>
        </tr>";
    } else {
        echo "<tr>
          <td class='odd'><img src='../assets/images/green.gif' align='baseline'> /uploads/yogurt/mp3/ exists and writable</td>
        </tr>";
    }

    echo "<tr><td class='odd'><img src='../assets/images/messagebox_info.gif'> " . sprintf(_MA_YOGURT_MAXBYTESPHPINI, ini_get('post_max_size')) . '</td></tr>';
    if (function_exists('memory_get_usage')) {
        echo "<tr><td class='even'><img src='../assets/images/messagebox_info.gif'> " . _MA_YOGURT_MEMORYLIMIT . ' ' . memory_get_usage() . '</td></tr>';
    }
    echo '</table>';
}

switch ($op) {
    case 'about':
        if ($isframeworksrequirement) {
            loadModuleAdminMenu(2, '-> About');
        }
        //            renderUglierMenu(2, '-> About');

        about();

        break;
    default:
        if ($isframeworksrequirement) {
            loadModuleAdminMenu(1, '-> home');
        }
        //            renderUglierMenu(1, '-> home');

        homedefault();

        break;
}

//fechamento das tags de if l� de cim�o verifica��o se os arquivos do phppp existem
xoops_cp_footer();
