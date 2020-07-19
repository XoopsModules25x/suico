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
// @see http://www.php-fig.org/psr/psr-4/examples/
spl_autoload_register(
    static function ($class) {
        // project-specific namespace prefix
        $prefix = 'XoopsModules\\' . ucfirst(basename(dirname(__DIR__)));
        // base directory for the namespace prefix
        $baseDir = dirname(__DIR__) . '/class/';
        // does the class use the namespace prefix?
        $len = mb_strlen($prefix);
        if (0 !== strncmp($prefix, $class, $len)) {
            return;
        }
        // get the relative class name
        $relativeClass = mb_substr($class, $len);
        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        // if the file exists, require it
        if (is_file($file)) {
            require_once $file;
        }
    }
);
