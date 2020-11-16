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

use Xmf\Module\Admin;
use Xmf\Request;
use XoopsModules\Suico\{
    Common\Configurator,
    Common\Migrate
};
/** @var Admin $adminObject */

require_once __DIR__ . '/admin_header.php';
xoops_cp_header();
$adminObject->displayNavigation(basename(__FILE__));
echo <<<EOF
<form method="post" class="form-inline">
<div class="form-group">
<input name="show" class="btn btn-default" type="submit" value="Show SQL">
</div>
<div class="form-group">
<input name="migrate" class="btn btn-default" type="submit" value="Do Migration">
</div>
<div class="form-group">
<input name="schema" class="btn btn-default" type="submit" value="Write Schema">
</div>
</form>
EOF;
//XoopsLoad::load('migrate', 'newbb');
$configurator = new Configurator();
$migrator     = new Migrate($configurator);
$op           = Request::getCmd('op', 'default');
$opShow       = Request::getCmd('show', null, 'POST');
$opMigrate    = Request::getCmd('migrate', null, 'POST');
$opSchema     = Request::getCmd('schema', null, 'POST');
$op           = !empty($opShow) ? 'show' : $op;
$op           = !empty($opMigrate) ? 'migrate' : $op;
$op           = !empty($opSchema) ? 'schema' : $op;
$message      = '';
switch ($op) {
    case 'show':
        $queue = $migrator->getSynchronizeDDL();
        if (!empty($queue)) {
            echo "<pre>\n";
            foreach ($queue as $line) {
                echo $line . ";\n";
            }
            echo "</pre>\n";
        }
        break;
    case 'migrate':
        $migrator->synchronizeSchema();
        $message = 'Database migrated to current schema.';
        break;
    case 'schema':
        xoops_confirm(
            ['op' => 'confirmwrite'],
            'migrate.php',
            'Warning! This is intended for developers only. Confirm write schema file from current database.',
            'Confirm'
        );
        break;
    case 'confirmwrite':
        if ($GLOBALS['xoopsSecurity']->check()) {
            $migrator->saveCurrentSchema();
            $message = 'Current schema file written';
        }
        break;
}
echo "<div>${message}</div>";
require_once __DIR__ . '/admin_footer.php';
