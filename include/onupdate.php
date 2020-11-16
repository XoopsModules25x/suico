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

use XoopsModules\Suico\{
    Common\Configurator,
    Common\Migrate,
    Helper,
    Utility
};
/** @var Helper $helper */
/** @var Utility $utility */
/** @var Common\Configurator $configurator */
/** @var Common\Migrate $migrator */

if ((!defined('XOOPS_ROOT_PATH')) || !($GLOBALS['xoopsUser'] instanceof \XoopsUser)
    || !$GLOBALS['xoopsUser']->isAdmin()) {
    exit('Restricted access' . PHP_EOL);
}
include dirname(__DIR__) . '/preloads/autoloader.php';
/**
 * @param string $tablename
 *
 * @return bool
 */
function tableExists($tablename)
{
    $result = $GLOBALS['xoopsDB']->queryF("SHOW TABLES LIKE '${tablename}'");
    return $GLOBALS['xoopsDB']->getRowsNum($result) > 0;
}

/**
 * Prepares system prior to attempting to install module
 * @param \XoopsModule $module {@link \XoopsModule}
 * @return bool true if ready to install, false if not
 */
function xoops_module_pre_update_suico(
    \XoopsModule $module
) {
    $moduleDirName = basename(dirname(__DIR__));
    $helper       = Helper::getInstance();
    $utility      = new Utility();
    $xoopsSuccess = $utility::checkVerXoops($module);
    $phpSuccess   = $utility::checkVerPhp($module);
    $configurator = new Configurator();
    $migrator     = new Migrate($configurator);
    $migrator->synchronizeSchema();
    return $xoopsSuccess && $phpSuccess;
}

/**
 * Performs tasks required during update of the module
 * @param \XoopsModule $module {@link XoopsModule}
 * @param null         $previousVersion
 *
 * @return bool true if update successful, false if not
 */
function xoops_module_update_suico(
    XoopsModule $module,
    $previousVersion = null
) {
    $moduleDirName      = basename(dirname(__DIR__));
    $moduleDirNameUpper = mb_strtoupper($moduleDirName);

    $helper       = Helper::getInstance();
    $utility      = new Utility();
    $configurator = new Configurator();
    $helper->loadLanguage('common');
    $migrator = new Migrate($configurator);
    $migrator->synchronizeSchema();
    if ($previousVersion < 360) {
        //rename column EXAMPLE
        //        $tables = new Tables();
        //        $table = 'xxxx_categories';
        //        $column = 'order';
        //        $newName = 'order';
        //        $attributes = "INT(5) NOT NULL DEFAULT '0'";
        //        if ($tables->useTable($table)) {
        //            $tables->alterColumn($table, $column, $attributes, $newName);
        //            if (!$tables->executeQueue()) {
        //                echo '<br>' . constant('CO_' . $moduleDirNameUpper . '_UPGRADEFAILED0') . ' ' . $migrate->getLastError();
        //            }
        //        }
        //delete old HTML templates
        if (count($configurator->templateFolders) > 0) {
            foreach ($configurator->templateFolders as $folder) {
                $templateFolder = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $folder);
                if (is_dir($templateFolder)) {
                    $templateList = array_diff(scandir($templateFolder, SCANDIR_SORT_NONE), ['..', '.']);
                    foreach ($templateList as $k => $v) {
                        $fileInfo = new SplFileInfo($templateFolder . $v);
                        if ('html' === $fileInfo->getExtension() && 'index.html' !== $fileInfo->getFilename()) {
                            if (is_file($templateFolder . $v)) {
                                unlink($templateFolder . $v);
                            }
                        }
                    }
                }
            }
        }
        //  ---  DELETE OLD FILES ---------------
        if (count($configurator->oldFiles) > 0) {
            //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
            foreach (
                array_keys(
                    $configurator->oldFiles
                ) as $i
            ) {
                $tempFile = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFiles[$i]);
                if (is_file($tempFile)) {
                    unlink($tempFile);
                }
            }
        }
        //  ---  DELETE OLD FOLDERS ---------------
        xoops_load('XoopsFile');
        if (count($configurator->oldFolders) > 0) {
            //    foreach (array_keys($GLOBALS['uploadFolders']) as $i) {
            foreach (
                array_keys(
                    $configurator->oldFolders
                ) as $i
            ) {
                $tempFolder = $GLOBALS['xoops']->path('modules/' . $moduleDirName . $configurator->oldFolders[$i]);
                /** @var XoopsObjectHandler $folderHandler */
                $folderHandler = XoopsFile::getHandler(
                    'folder',
                    $tempFolder
                );
                $folderHandler->delete($tempFolder);
            }
        }
        //  ---  CREATE UPLOAD FOLDERS ---------------
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
        //delete .html entries from the tpl table
        $sql = 'DELETE FROM ' . $GLOBALS['xoopsDB']->prefix(
                'tplfile'
            ) . " WHERE `tpl_module` = '" . $module->getVar(
                'dirname',
                'n'
            ) . "' AND `tpl_file` LIKE '%.html%'";
        $GLOBALS['xoopsDB']->queryF($sql);
        /** @var XoopsGroupPermHandler $gpermHandler */
        $gpermHandler = xoops_getHandler('groupperm');
        return $gpermHandler->deleteByModule($module->getVar('mid'), 'item_read');
    }
    $profileHandler = $helper->getHandler('Profile');
    $profileHandler->cleanOrphan($GLOBALS['xoopsDB']->prefix('users'), 'uid', 'profile_id');
    $fieldHandler = $helper->getHandler('Field');
    $user_fields  = $fieldHandler->getUserVars();
    $criteria     = new Criteria('field_name', "('" . implode("', '", $user_fields) . "')", 'IN');
    $fieldHandler->updateAll('field_config', 0, $criteria);
    return true;
}
