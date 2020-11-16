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

use Xmf\Database\TableLoad;
use Xmf\Request;
use Xmf\Yaml;
use XoopsModules\Suico\{
    Common,
    Helper,
    Common\Migrate,
    Utility
};

require_once dirname(__DIR__, 3) . '/include/cp_header.php';
require dirname(__DIR__) . '/preloads/autoloader.php';
$op                 = Request::getCmd('op', '');
$moduleDirName      = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
$helper             = Helper::getInstance();
// Load language files
$helper->loadLanguage('common');
switch ($op) {
    case 'load':
        if (Request::hasVar('ok', 'REQUEST') && 1 === Request::getInt('ok', 0, 'REQUEST')) {
            if (!$GLOBALS['xoopsSecurity']->check()) {
                redirect_header('../admin/index.php', 3, implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
            }
            loadSampleData();
        } else {
            xoops_cp_header();
            xoops_confirm(
                [
                    'ok' => 1,
                    'op' => 'load',
                ],
                'index.php',
                sprintf(constant('CO_' . $moduleDirNameUpper . '_' . 'ADD_SAMPLEDATA_OK')),
                constant(
                    'CO_' . $moduleDirNameUpper . '_' . 'CONFIRM'
                ),
                true
            );
            xoops_cp_footer();
        }
        break;
    case 'save':
        saveSampleData();
        break;
}
// XMF TableLoad for SAMPLE data
function loadSampleData()
{
    global $xoopsConfig;
    $moduleDirName      = basename(dirname(__DIR__));
    $moduleDirNameUpper = mb_strtoupper($moduleDirName);
    $utility            = new Utility();
    $configurator       = new Common\Configurator();
    $tables             = Helper::getHelper($moduleDirName)->getModule()->getInfo('tables');
    $language           = 'english/';
    if (is_dir(__DIR__ . '/' . $xoopsConfig['language'])) {
        $language = $xoopsConfig['language'] . '/';
    }
    // load module tables
    foreach ($tables as $table) {
        $tabledata = Yaml::readWrapped($language . $table . '.yml');
        if (is_array($tabledata)) {
            TableLoad::truncateTable($table);
            TableLoad::loadTableFromArray($table, $tabledata);
        }
    }

    // load permissions
    $table     = 'group_permission';
    $tabledata = \Xmf\Yaml::readWrapped($language . $table . '.yml');
    $mid       = \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid');
    loadTableFromArrayWithReplace($table, $tabledata, 'gperm_modid', $mid);

    //  ---  COPY test folder files ---------------
    if (is_array($configurator->copyTestFolders)
        && count(
               $configurator->copyTestFolders
           ) > 0) {
        //        $file =  dirname(__DIR__) . '/testdata/images/';
        foreach (
            array_keys(
                $configurator->copyTestFolders
            ) as $i
        ) {
            $src  = $configurator->copyTestFolders[$i][0];
            $dest = $configurator->copyTestFolders[$i][1];
            $utility::rcopy($src, $dest);
        }
    }

    addUsers();
    \redirect_header('../admin/index.php', 1, \constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA_SUCCESS'));
}

function saveSampleData()
{
    global $xoopsConfig;
    $moduleDirName      = basename(dirname(__DIR__));
    $moduleDirNameUpper = mb_strtoupper($moduleDirName);
    $tables             = Helper::getHelper($moduleDirName)->getModule()->getInfo('tables');
    $language           = 'english/';
    if (is_dir(__DIR__ . '/' . $xoopsConfig['language'])) {
        $language = $xoopsConfig['language'] . '/';
    }
    $languageFolder = __DIR__ . '/' . $language;
    if (!file_exists($languageFolder . '/')) {
        Utility::createFolder($languageFolder . '/');
    }
    $exportFolder = $languageFolder . '/Exports-' . date('Y-m-d-H-i-s') . '/';
    Utility::createFolder($exportFolder);

    // save module tables
    foreach ($tables as $table) {
        TableLoad::saveTableToYamlFile($table, $exportFolder . $table . '.yml');
    }

    // save permissions
    $criteria = new \CriteriaCompo();
    $criteria->add(new \Criteria('gperm_modid', \Xmf\Module\Helper::getHelper($moduleDirName)->getModule()->getVar('mid')));
    $skipColumns[] = 'gperm_id';
    \Xmf\Database\TableLoad::saveTableToYamlFile('group_permission', $exportFolder . 'group_permission.yml', $criteria, $skipColumns);
    unset($criteria);

    \redirect_header('../admin/index.php', 1, \constant('CO_' . $moduleDirNameUpper . '_' . 'SAVE_SAMPLEDATA_SUCCESS'));
}

function exportSchema()
{
    $moduleDirName      = basename(dirname(__DIR__));
    $moduleDirNameUpper = mb_strtoupper($moduleDirName);
    try {
        // TODO set exportSchema
        //        $migrate = new Migrate($moduleDirName);
        //        $migrate->saveCurrentSchema();
        //
        //        redirect_header('../admin/index.php', 1, constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_SUCCESS'));
    } catch (Throwable $e) {
        exit(constant('CO_' . $moduleDirNameUpper . '_' . 'EXPORT_SCHEMA_ERROR'));
    }
}


/**
 * loadTableFromArrayWithReplace
 *
 * @param string $table  value with should be used insead of original value of $search
 *
 * @param array  $data   array of rows to insert
 *                       Each element of the outer array represents a single table row.
 *                       Each row is an associative array in 'column' => 'value' format.
 * @param string $search name of column for which the value should be replaced
 * @param        $replace
 * @return int number of rows inserted
 */
function loadTableFromArrayWithReplace($table, $data, $search, $replace)
{
    /** @var \XoopsMySQLDatabase $db */
    $db = \XoopsDatabaseFactory::getDatabaseConnection();

    $prefixedTable = $db->prefix($table);
    $count         = 0;

    $sql = 'DELETE FROM ' . $prefixedTable . ' WHERE `' . $search . '`=' . $db->quote($replace);

    $result = $db->queryF($sql);

    foreach ($data as $row) {
        $insertInto  = 'INSERT INTO ' . $prefixedTable . ' (';
        $valueClause = ' VALUES (';
        $first       = true;
        foreach ($row as $column => $value) {
            if ($first) {
                $first = false;
            } else {
                $insertInto  .= ', ';
                $valueClause .= ', ';
            }

            $insertInto .= $column;
            if ($search === $column) {
                $valueClause .= $db->quote($replace);
            } else {
                $valueClause .= $db->quote($value);
            }
        }

        $sql = $insertInto . ') ' . $valueClause . ')';

        $result = $db->queryF($sql);
        if (false !== $result) {
            ++$count;
        }
    }

    return $count;
}

/**
 * @return bool
 */
function addUsers()
{
    $ret = false;
    $xoopsDB = \XoopsDatabaseFactory::getDatabaseConnection();

    $sql = ' INSERT INTO `'
           . $xoopsDB->prefix('users')
           . '` (`uid`, `name`, `uname`, `email`, `url`, `user_avatar`, `user_regdate`, `user_icq`, `user_from`, `user_sig`, `user_viewemail`, `actkey`, `user_aim`, `user_yim`, `user_msnm`, `pass`, `posts`, `attachsig`, `rank`, `level`, `theme`, `timezone_offset`, `last_login`, `umode`, `uorder`, `notify_method`, `notify_mode`, `user_occ`, `bio`, `user_intrest`, `user_mailok`) VALUES ';

    $userInfo = [
        998  => "998, 'Joe Webmaster', 'webmaster', 'joe@mysite.com', 'www.xoops.org', 'avatars/avatar2.jpg', 1587372647, '', '', 'Go XOOPS! ', 0, '', '', '', '', '$2y$10$4NtwDxHimN4uxUya93Egu.VJYkYCKzgX3EtomGyYrf1bkY6rB.DTm', 0, 0, 7, 1, 'xswatch4', -5.0, 1588844591, 'flat', 0, 1, 0, '', '', '', 0",
        999  => "999, 'ALL Visitors', 'tester', '0fe6bf283000a9f9376ee72c69322b04', '', 'avatars/avatar4.jpg', 1585429986, '', '', 'User under suspension until 2020/5/3 23:16', 0, '', '', '', '', '$2y$10$tOYz4y.S.g4JYtmDnKfEKOpYh3Vivs8.UNZmdX.DVIBd9G5FZVaUi', 0, 0, 0, 1, '', 0.0, 1588838831, 'flat', 0, 1, 0, '', '', '', 1",
        1000 => "1000, 'Members Only', 'tester2', 'name2@email.com', '', 'avatars/avatar5.jpg', 1588229043, '', '', '', 0, '', '', '', '', '$2y$10$uYjy3xn0WyoDdUK5iXml/.lRhw/51SKeATx/FTEjZmL.2ibo.cF0q', 0, 0, 0, 1, '', 0.0, 1588844747, 'flat', 0, 1, 0, '', '', '', 1",
        1001 => "1001, 'Friends Only', 'tester3', 'name3@email.com', '', 'avatars/avatar6.jpg', 1588232828, '', '', '', 0, '90853319', '', '', '', '$2y$10$FPO.waxqjq.xXXJggTcSMuXpeXQU5UmuOCpX6Lo33d3o78bCh5w4a', 0, 0, 0, 1, 'xswatch4', 0.0, 1588845446, 'flat', 0, 1, 0, '', '', '', 1",
        1002 => "1002, 'Only Me', 'tester4', 'tester4@suicotest.com', '', 'avatars/avatar7.jpg', 1588800450, '', '', '', 0, '', '', '', '', '$2y$10$QF2FadecKKaSBFOsB9U5ne2o1FtPhbVWTurv3.zjwSpDxPFu9qqhm', 0, 0, 0, 1, '', 0.0, 1588845425, 'flat', 0, 1, 0, '', '', '', 1",
    ];
    // this is where the magic happens
    $it = new ArrayIterator($userInfo);
    // a new caching iterator gives us access to hasNext()
    $cit = new CachingIterator($it);
    // loop over the array
    foreach ($cit as $key => $value) {
        $criteria    = new \Criteria('uid', $key);
        $userHandler = xoops_getHandler('user');
        if (0 == $userHandler->getCount($criteria)) {
            // add to the query
            $sql .= '(' . $cit->current() . ')';
            // if there is another array member, add a comma
            if ($cit->hasNext()) {
                $sql .= ',';
            }
        }
    }

    if (',' === mb_substr($sql, -1)){
        $sql = mb_substr($sql, 0, -1);
    }

    $result = $xoopsDB->queryF($sql);
    if (false !== $result) {
     $ret = true;
    }
    return $ret;

}
