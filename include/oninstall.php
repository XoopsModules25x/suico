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
 * @author          Jan Pedersen
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 */

use XoopsModules\Suico\{
    Common\Configurator,
    Helper,
    Utility
};
/** @var Helper $helper */
/** @var Utility $utility */
/** @var Common\Configurator $configurator */

include dirname(
            __DIR__
        ) . '/preloads/autoloader.php';
/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_install_suico(
    XoopsModule $module
) {
    require __DIR__ . '/common.php';
    $utility = new Utility();
    //check for minimum XOOPS version
    $xoopsSuccess = $utility::checkVerXoops($module);
    // check for minimum PHP version
    $phpSuccess = $utility::checkVerPhp($module);
    if ($xoopsSuccess && $phpSuccess) {
        $moduleTables = &$module->getInfo('tables');
        foreach ($moduleTables as $table) {
            $GLOBALS['xoopsDB']->queryF('DROP TABLE IF EXISTS ' . $GLOBALS['xoopsDB']->prefix($table) . ';');
        }
    }
    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during installation of the module
 * @param \XoopsModule $module {@link XoopsModule}
 *
 * @return bool true if installation successful, false if not
 */
function xoops_module_install_suico(XoopsModule $module)
{
    global $module_id;
    $module_id = $module->getVar('mid');
    xoops_loadLanguage('user');
    require_once dirname(__DIR__) . '/preloads/autoloader.php';
    $moduleDirName = basename(dirname(__DIR__));
    // Create registration steps
    suico_install_addStep(_MI_SUICO_STEP_BASIC, '', 1, 1);
    // Create categories
    suico_install_addCategory(_MI_SUICO_CATEGORY_PERSONAL, 1);
    suico_install_addCategory(_MI_SUICO_CATEGORY_MESSAGING, 2);
    suico_install_addCategory(_MI_SUICO_CATEGORY_SETTINGS, 3);
    suico_install_addCategory(_MI_SUICO_CATEGORY_COMMUNITY, 4);
    // Add user fields
    xoops_loadLanguage('notification');
    xoops_loadLanguage('main', $module->getVar('dirname', 'n'));
    require_once $GLOBALS['xoops']->path('include/notification_constants.php');
    $umode_options         = [
        'nest'   => _NESTED,
        'flat'   => _FLAT,
        'thread' => _THREADED,
    ];
    $uorder_options        = [
        0 => _OLDESTFIRST,
        1 => _NEWESTFIRST,
    ];
    $notify_mode_options   = [
        XOOPS_NOTIFICATION_MODE_SENDALWAYS         => _NOT_MODE_SENDALWAYS,
        XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE => _NOT_MODE_SENDONCE,
        XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT   => _NOT_MODE_SENDONCEPERLOGIN,
    ];
    $notify_method_options = [
        XOOPS_NOTIFICATION_METHOD_DISABLE => _NOT_METHOD_DISABLE,
        XOOPS_NOTIFICATION_METHOD_PM      => _NOT_METHOD_PM,
        XOOPS_NOTIFICATION_METHOD_EMAIL   => _NOT_METHOD_EMAIL,
    ];
    suico_install_addField('name', _US_REALNAME, '', 1, 'textbox', 1, 1, 1, [], 0, 255);
    suico_install_addField('user_from', _US_LOCATION, '', 1, 'textbox', 1, 2, 1, [], 0, 255);
    suico_install_addField('user_occ', _US_OCCUPATION, '', 1, 'textbox', 1, 3, 1, [], 0, 255);
    suico_install_addField('user_intrest', _US_INTEREST, '', 1, 'textbox', 1, 4, 1, [], 0, 255);
    suico_install_addField('bio', _US_EXTRAINFO, '', 1, 'textarea', 2, 5, 1, [], 0, 0);
    suico_install_addField('user_sig', _US_SIGNATURE, '', 1, 'dhtml', 1, 6, 1, [], 0, 0);
    suico_install_addField('url', _MI_SUICO_URL_TITLE, '', 1, 'textbox', 1, 7, 1, [], 0, 255, false);
    suico_install_addField('timezone_offset', _US_TIMEZONE, '', 3, 'timezone', 1, 0, 1, [], 0, 0, false);
    suico_install_addField('user_viewemail', _US_ALLOWVIEWEMAIL, '', 3, 'yesno', 3, 1, 1, [], 0, 1, false);
    suico_install_addField('attachsig', _US_SHOWSIG, '', 3, 'yesno', 3, 2, 1, [], 0, 1, false);
    suico_install_addField('user_mailok', _US_MAILOK, '', 3, 'yesno', 3, 3, 1, [], 0, 1, false);
    suico_install_addField('theme', _MD_SUICO_THEME, '', 3, 'theme', 1, 4, 1, [], 0, 0, false);
    suico_install_addField('umode', _US_CDISPLAYMODE, '', 3, 'select', 1, 5, 1, $umode_options, 0, 0, false);
    suico_install_addField('uorder', _US_CSORTORDER, '', 3, 'select', 3, 6, 1, $uorder_options, 0, 0, false);
    suico_install_addField('notify_mode', _NOT_NOTIFYMODE, '', 3, 'select', 3, 7, 1, $notify_mode_options, 0, 0, false);
    suico_install_addField('notify_method', _NOT_NOTIFYMETHOD, '', 3, 'select', 3, 8, 1, $notify_method_options, 0, 0, false);
    suico_install_addField('user_regdate', _US_MEMBERSINCE, '', 4, 'datetime', 3, 1, 0, [], 0, 10);
    suico_install_addField('posts', _US_POSTS, '', 4, 'textbox', 3, 2, 0, [], 0, 255);
    suico_install_addField('rank', _US_RANK, '', 4, 'rank', 3, 3, 2, [], 0, 0);
    suico_install_addField('last_login', _US_LASTLOGIN, '', 4, 'datetime', 3, 4, 0, [], 0, 10);
    suico_install_initializeProfiles();
    $helper       = Helper::getInstance();
    $utility      = new Utility();
    $configurator = new Configurator();
    // Load language files
    $helper->loadLanguage('admin');
    $helper->loadLanguage('modinfo');
    // default Permission Settings ----------------------
    $moduleId = $module->getVar('mid');
    //$moduleName = $module->getVar('name');
    $grouppermHandler = xoops_getHandler('groupperm');
    // access rights ------------------------------------------
    $grouppermHandler->addRight(
        $moduleDirName . '_approve',
        1,
        XOOPS_GROUP_ADMIN,
        $moduleId
    );
    $grouppermHandler->addRight($moduleDirName . '_submit', 1, XOOPS_GROUP_ADMIN, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_ADMIN, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_USERS, $moduleId);
    $grouppermHandler->addRight($moduleDirName . '_view', 1, XOOPS_GROUP_ANONYMOUS, $moduleId);
    //  ---  CREATE FOLDERS ---------------
    if (count($configurator->uploadFolders) > 0) {
        //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
        foreach (
            array_keys(
                $configurator->uploadFolders
            ) as $i
        ) {
            $utility::createFolder($configurator->uploadFolders[$i]);
        }
    }
    //  ---  COPY blank.png FILES ---------------
    if (count($configurator->copyBlankFiles) > 0) {
        $file = dirname(__DIR__) . '/assets/images/blank.png';
        foreach (array_keys($configurator->copyBlankFiles) as $i) {
            $dest = $configurator->copyBlankFiles[$i] . '/blank.png';
            $utility::copyFile($file, $dest);
        }
    }
    /*
        //  ---  COPY test folder files ---------------
    if (count($configurator->copyTestFolders) > 0) {
        //        $file =  dirname(__DIR__) . '/testdata/images/';
        foreach (array_keys($configurator->copyTestFolders) as $i) {
            $src  = $configurator->copyTestFolders[$i][0];
            $dest = $configurator->copyTestFolders[$i][1];
            $utility::xcopy($src, $dest);
        }
    }
    */
    //delete .html entries from the tpl table
    $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix(
            'tplfile'
        ) . " WHERE `tpl_module` = '" . $module->getVar(
            'dirname',
            'n'
        ) . "' AND `tpl_file` LIKE '%.html%'";
    $GLOBALS['xoopsDB']->queryF($sql);
    return true;
}

function suico_install_initializeProfiles()
{
    global $module_id;
    $GLOBALS['xoopsDB']->queryF('   INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('suico_profile') . ' (profile_id) ' . '   SELECT uid ' . '   FROM ' . $GLOBALS['xoopsDB']->prefix('users'));
    $sql = 'INSERT INTO '
           . $GLOBALS['xoopsDB']->prefix('group_permission')
           . ' (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) '
           . ' VALUES '
           . ' ('
           . XOOPS_GROUP_ADMIN
           . ', '
           . XOOPS_GROUP_ADMIN
           . ", {$module_id}, 'profile_access'), "
           . ' ('
           . XOOPS_GROUP_ADMIN
           . ', '
           . XOOPS_GROUP_USERS
           . ", {$module_id}, 'profile_access'), "
           . ' ('
           . XOOPS_GROUP_USERS
           . ', '
           . XOOPS_GROUP_USERS
           . ", {$module_id}, 'profile_access'), "
           . ' ('
           . XOOPS_GROUP_ANONYMOUS
           . ', '
           . XOOPS_GROUP_USERS
           . ", {$module_id}, 'profile_access') "
           . ' ';
    $GLOBALS['xoopsDB']->queryF($sql);
}

// canedit: 0 - no; 1 - admin; 2 - admin & owner
/**
 * @param      $name
 * @param      $title
 * @param      $description
 * @param      $category
 * @param      $type
 * @param      $valuetype
 * @param      $weight
 * @param      $canedit
 * @param      $options
 * @param      $step_id
 * @param      $length
 * @param bool $visible
 *
 * @return bool
 */
function suico_install_addField($name, $title, $description, $category, $type, $valuetype, $weight, $canedit, $options, $step_id, $length, $visible = true)
{
    global $module_id;
    $fieldHandler = Helper::getInstance()->getHandler('Field');
    $obj          = $fieldHandler->create();
    $obj->setVar('field_name', $name, true);
    $obj->setVar('field_moduleid', $module_id, true);
    $obj->setVar('field_show', 1);
    $obj->setVar('field_edit', $canedit ? 1 : 0);
    $obj->setVar('field_config', 0);
    $obj->setVar('field_title', strip_tags($title), true);
    $obj->setVar('field_description', strip_tags($description), true);
    $obj->setVar('field_type', $type, true);
    $obj->setVar('field_valuetype', $valuetype, true);
    $obj->setVar('field_options', $options, true);
    if ($canedit) {
        $obj->setVar('field_maxlength', $length, true);
    }
    $obj->setVar('field_weight', $weight, true);
    $obj->setVar('cat_id', $category, true);
    $obj->setVar('step_id', $step_id, true);
    $fieldHandler->insert($obj);
    suico_install_setPermissions($obj->getVar('field_id'), $module_id, $canedit, $visible);
    return true;
    /*
    //$GLOBALS['xoopsDB']->query("INSERT INTO ".$GLOBALS['xoopsDB']->prefix("suico_field")." VALUES (0, {$category}, '{$type}', {$valuetype}, '{$name}', " . $GLOBALS['xoopsDB']->quote($title) . ", " . $GLOBALS['xoopsDB']->quote($description) . ", 0, {$length}, {$weight}, '', 1, {$canedit}, 1, 0, '" . serialize($options) . "', {$step_id})");
    $gperm_itemid = $obj->getVar('field_id');
    unset($obj);
    $gperm_modid = $module_id;
    $sql = "INSERT INTO " . $GLOBALS['xoopsDB']->prefix("group_permission") .
        " (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) " .
        " VALUES " .
        ($canedit ?
            " (" . XOOPS_GROUP_ADMIN . ", {$gperm_itemid}, {$gperm_modid}, 'suico_edit'), "
        : "" ) .
        ($canedit == 1 ?
            " (" . XOOPS_GROUP_USERS . ", {$gperm_itemid}, {$gperm_modid}, 'suico_edit'), "
        : "" ) .
        " (" . XOOPS_GROUP_ADMIN . ", {$gperm_itemid}, {$gperm_modid}, 'suico_search'), " .
        " (" . XOOPS_GROUP_USERS . ", {$gperm_itemid}, {$gperm_modid}, 'suico_search') " .
        " ";
    $GLOBALS['xoopsDB']->query($sql);

    if ($visible) {
        $sql = "INSERT INTO " . $GLOBALS['xoopsDB']->prefix("suico_profile_visibility") .
            " (field_id, user_group, suico_group) " .
            " VALUES " .
            " ({$gperm_itemid}, " . XOOPS_GROUP_ADMIN . ", " . XOOPS_GROUP_ADMIN . "), " .
            " ({$gperm_itemid}, " . XOOPS_GROUP_ADMIN . ", " . XOOPS_GROUP_USERS . "), " .
            " ({$gperm_itemid}, " . XOOPS_GROUP_USERS . ", " . XOOPS_GROUP_ADMIN . "), " .
            " ({$gperm_itemid}, " . XOOPS_GROUP_USERS . ", " . XOOPS_GROUP_USERS . "), " .
            " ({$gperm_itemid}, " . XOOPS_GROUP_ANONYMOUS . ", " . XOOPS_GROUP_ADMIN . "), " .
            " ({$gperm_itemid}, " . XOOPS_GROUP_ANONYMOUS . ", " . XOOPS_GROUP_USERS . ")" .
            " ";
        $GLOBALS['xoopsDB']->query($sql);
    }
    */
}

/**
 * @param $field_id
 * @param $module_id
 * @param $canedit
 * @param $visible
 */
function suico_install_setPermissions($field_id, $module_id, $canedit, $visible)
{
    $gperm_itemid = $field_id;
    $gperm_modid  = $module_id;
    $sql          = 'INSERT INTO '
                    . $GLOBALS['xoopsDB']->prefix('group_permission')
                    . ' (gperm_groupid, gperm_itemid, gperm_modid, gperm_name) '
                    . ' VALUES '
                    . ($canedit ? ' (' . XOOPS_GROUP_ADMIN . ", {$gperm_itemid}, {$gperm_modid}, 'profile_edit'), " : '')
                    . (1 == $canedit ? ' ('
                                       . XOOPS_GROUP_USERS
                                       . ", {$gperm_itemid}, {$gperm_modid}, 'profile_edit'), " : '')
                    . ' ('
                    . XOOPS_GROUP_ADMIN
                    . ", {$gperm_itemid}, {$gperm_modid}, 'profile_search'), "
                    . ' ('
                    . XOOPS_GROUP_USERS
                    . ", {$gperm_itemid}, {$gperm_modid}, 'profile_search') "
                    . ' ';
    $GLOBALS['xoopsDB']->queryF($sql);
    if ($visible) {
        $sql = 'INSERT INTO '
               . $GLOBALS['xoopsDB']->prefix('suico_profile_visibility')
               . ' (field_id, user_group, profile_group) '
               . ' VALUES '
               . " ({$gperm_itemid}, "
               . XOOPS_GROUP_ADMIN
               . ', '
               . XOOPS_GROUP_ADMIN
               . '), '
               . " ({$gperm_itemid}, "
               . XOOPS_GROUP_ADMIN
               . ', '
               . XOOPS_GROUP_USERS
               . '), '
               . " ({$gperm_itemid}, "
               . XOOPS_GROUP_USERS
               . ', '
               . XOOPS_GROUP_ADMIN
               . '), '
               . " ({$gperm_itemid}, "
               . XOOPS_GROUP_USERS
               . ', '
               . XOOPS_GROUP_USERS
               . '), '
               . " ({$gperm_itemid}, "
               . XOOPS_GROUP_ANONYMOUS
               . ', '
               . XOOPS_GROUP_ADMIN
               . '), '
               . " ({$gperm_itemid}, "
               . XOOPS_GROUP_ANONYMOUS
               . ', '
               . XOOPS_GROUP_USERS
               . ')'
               . ' ';
        $GLOBALS['xoopsDB']->queryF($sql);
    }
}

/**
 * @param $name
 * @param $weight
 */
function suico_install_addCategory($name, $weight)
{
    $GLOBALS['xoopsDB']->query('INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('suico_profile_category') . ' VALUES (0, ' . $GLOBALS['xoopsDB']->quote($name) . ", '', {$weight})");
}

/**
 * @param $name
 * @param $desc
 * @param $order
 * @param $save
 */
function suico_install_addStep($name, $desc, $order, $save)
{
    $GLOBALS['xoopsDB']->query('INSERT INTO ' . $GLOBALS['xoopsDB']->prefix('suico_profile_regstep') . ' VALUES (0, ' . $GLOBALS['xoopsDB']->quote($name) . ', ' . $GLOBALS['xoopsDB']->quote($desc) . ", {$order}, {$save})");
}
