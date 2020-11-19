<?php

declare(strict_types=1);

namespace XoopsModules\Suico\Common;

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

use XoopsModules\Suico\Common;

/**
 * Class Migrate synchronize existing tables with target schema
 *
 * @category  Migrate
 * @author    Richard Griffith <richard@geekwright.com>
 * @copyright 2016 XOOPS Project (https://xoops.org)
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @link      https://xoops.org
 */
class Migrate extends \Xmf\Database\Migrate
{
    private $renameTables;
    private $renameColumns;

    /**
     * Migrate constructor.
     * @param \XoopsModules\Suico\Common\Configurator|null $configurator
     */
    public function __construct(
        ?Common\Configurator $configurator = null
    ) {
        if (null !== $configurator) {
            $this->renameTables  = $configurator->renameTables;
            $this->renameColumns = $configurator->renameColumns;
            $moduleDirName       = \basename(\dirname(__DIR__, 2));
            parent::__construct($moduleDirName);
        }
    }

    /**
     * Perform any upfront actions before synchronizing the schema
     *
     * Some typical uses include
     *   table and column renames
     *   data conversions
     */
    protected function preSyncActions()
    {
        // rename table
        if ($this->renameTables && \is_array($this->renameTables)) {
            $this->renameTable();
        }
        $this->renameColumn('suico_notes', 'Note_id', 'note_id');
        $this->renameColumn('suico_notes', 'Note_text', 'note_text');
        $this->renameColumn('suico_notes', 'Note_from', 'note_from');
        $this->renameColumn('suico_notes', 'Note_to', 'note_to');
    }

    /**
     * rename table if needed
     */
    private function renameTable()
    {
        foreach ($this->renameTables as $oldName => $newName) {
            if ($this->tableHandler->useTable($oldName) && !$this->tableHandler->useTable($newName)) {
                $this->tableHandler->renameTable($oldName, $newName);
            }
        }
    }

    /**
     * @param $tableName
     * @param $columnName
     * @param $newName
     */
    private function renameColumn(
        $tableName,
        $columnName,
        $newName
    ) {
        if ($this->tableHandler->useTable($tableName)) {
            $attributes = $this->tableHandler->getColumnAttributes($tableName, $columnName);
            //            if (false !== strpos($attributes, ' int(')) {
            $this->tableHandler->alterColumn(
                $tableName,
                $columnName,
                $attributes,
                $newName
            );
            //            }
        }
    }
}
