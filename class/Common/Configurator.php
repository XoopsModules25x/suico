<?php declare(strict_types=1);

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
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @author          Marcello Brandão aka  Suico, Mamba, LioMJ  <https://xoops.org>
 */

/**
 * Class Configurator
 */
class Configurator
{
    public $name;
    public       $paths           = [];
    public array $uploadFolders   = [];
    public array $copyBlankFiles  = [];
    public array $copyTestFolders = [];
    public array $templateFolders = [];
    public array $oldFiles        = [];
    public array $oldFolders      = [];
    public array $renameTables    = [];
    public array $renameColumns   = [];
    public array $moduleStats     = [];
    public       $icons;

    /**
     * Configurator constructor.
     */
    public function __construct()
    {
        $config                = include \dirname(__DIR__, 2) . '/config/config.php';
        $this->name            = $config->name;
        $this->paths           = $config->paths;
        $this->uploadFolders   = $config->uploadFolders;
        $this->copyBlankFiles  = $config->copyBlankFiles;
        $this->copyTestFolders = $config->copyTestFolders;
        $this->templateFolders = $config->templateFolders;
        $this->oldFiles        = $config->oldFiles;
        $this->oldFolders      = $config->oldFolders;
        $this->renameTables    = $config->renameTables;
        $this->renameColumns   = $config->renameColumns;
        $this->moduleStats     = $config->moduleStats;
        //        $this->modCopyright    = $config->modCopyright;
        $this->icons = require \dirname(__DIR__, 2) . '/config/icons.php';
        $this->paths = require \dirname(__DIR__, 2) . '/config/paths.php';
    }
}
