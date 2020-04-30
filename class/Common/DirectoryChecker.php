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

use Xmf\Request;
use XoopsModules\Suico;

require_once \dirname(__DIR__, 4) . '/mainfile.php';
$moduleDirName      = \basename(\dirname(__DIR__, 2));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
\xoops_loadLanguage('directorychecker', $moduleDirName);

/**
 * Class DirectoryChecker
 * check status of a directory
 */
class DirectoryChecker
{
    /**
     * @param     $path
     * @param int $mode
     * @param     $redirectFile
     *
     * @return bool|string
     */
    public static function getDirectoryStatus(
        $path,
        $mode = 0777,
        $redirectFile = null
    ) {
        global $pathIcon16;
        if (empty($path)) {
            return false;
        }
        if (null === $redirectFile) {
            $redirectFile = $_SERVER['SCRIPT_NAME'];
        }
        $moduleDirName      = \basename(\dirname(__DIR__, 2));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);
        if (!@\is_dir($path)) {
            $pathStatus = "<img src='${pathIcon16}/0.png' alt='DC_NOTAVAILABLE'>";
            $pathStatus .= "${path} (" . \constant('CO_' . $moduleDirNameUpper . '_' . 'DC_NOTAVAILABLE') . ') ';
            $pathStatus .= "<form action='" . $_SERVER['SCRIPT_NAME'] . "' method='post'>";
            $pathStatus .= "<input type='hidden' name='op' value='createdir'>";
            $pathStatus .= "<input type='hidden' name='path' value='${path}'>";
            $pathStatus .= "<input type='hidden' name='redirect' value='${redirectFile}'>";
            $pathStatus .= "<button class='submit' onClick='this.form.submit();'>" . \constant(
                    'CO_' . $moduleDirNameUpper . '_' . 'DC_CREATETHEDIR'
                ) . '</button>';
            $pathStatus .= '</form>';
        } elseif (@\is_writable($path)) {
            $pathStatus  = "<img src='${pathIcon16}/1.png' alt='DC_AVAILABLE'>";
            $pathStatus  .= "${path} (" . \constant('CO_' . $moduleDirNameUpper . '_' . 'DC_AVAILABLE') . ') ';
            $currentMode = mb_substr(\decoct(\fileperms($path)), 2);
            if ($currentMode !== \decoct($mode)) {
                $pathStatus = "<img src='${pathIcon16}/0.png' alt='DC_NOTWRITABLE'>";
                $pathStatus .= $path . \sprintf(
                        \constant('CO_' . $moduleDirNameUpper . '_' . 'DC_NOTWRITABLE'),
                        \decoct($mode),
                        $currentMode
                    );
                $pathStatus .= "<form action='" . $_SERVER['SCRIPT_NAME'] . "' method='post'>";
                $pathStatus .= "<input type='hidden' name='op' value='setdirperm'>";
                $pathStatus .= "<input type='hidden' name='mode' value='${mode}'>";
                $pathStatus .= "<input type='hidden' name='path' value='${path}'>";
                $pathStatus .= "<input type='hidden' name='redirect' value='${redirectFile}'>";
                $pathStatus .= "<button class='submit' onClick='this.form.submit();'>" . \constant(
                        'CO_' . $moduleDirNameUpper . '_' . 'DC_SETMPERM'
                    ) . '</button>';
                $pathStatus .= '</form>';
            }
        } else {
            $currentMode = mb_substr(\decoct(\fileperms($path)), 2);
            $pathStatus  = "<img src='${pathIcon16}/0.png' alt='DC_NOTWRITABLE'>";
            $pathStatus  .= $path . \sprintf(
                    \constant('CO_' . $moduleDirNameUpper . '_' . 'DC_NOTWRITABLE'),
                    \decoct($mode),
                    $currentMode
                );
            $pathStatus  .= "<form action='" . $_SERVER['SCRIPT_NAME'] . "' method='post'>";
            $pathStatus  .= "<input type='hidden' name='op' value='setdirperm'>";
            $pathStatus  .= "<input type='hidden' name='mode' value='${mode}'>";
            $pathStatus  .= "<input type='hidden' name='path' value='${path}'>";
            $pathStatus  .= "<input type='hidden' name='redirect' value='${redirectFile}'>";
            $pathStatus  .= "<button class='submit' onClick='this.form.submit();'>" . \constant(
                    'CO_' . $moduleDirNameUpper . '_' . 'DC_SETMPERM'
                ) . '</button>';
            $pathStatus  .= '</form>';
        }
        return $pathStatus;
    }

    /**
     * @param     $target
     * @param int $mode
     *
     * @return bool
     */
    public static function createDirectory(
        $target,
        $mode = 0777
    ) {
        $target = \str_replace('..', '', $target);
        // http://www.php.net/manual/en/function.mkdir.php
        return \is_dir($target)
               || (self::createDirectory(
                    \dirname($target),
                    $mode
                )
                   && !\mkdir(
                    $target,
                    $mode
                )
                   && !\is_dir(
                    $target
                ));
    }

    /**
     * @param     $target
     * @param int $mode
     *
     * @return bool
     */
    public static function setDirectoryPermissions(
        $target,
        $mode = 0777
    ) {
        $target = \str_replace('..', '', $target);
        return @\chmod($target, (int)$mode);
    }

    /**
     * @param   $dir_path
     *
     * @return bool
     */
    public static function dirExists($dir_path)
    {
        return \is_dir($dir_path);
    }
}

$op = Request::getString('op', '', 'POST');
switch ($op) {
    case 'createdir':
        if (Request::hasVar('path', 'POST')) {
            $path = Request::getString('path', '', 'POST');
        }
        if (Request::hasVar('redirect', 'POST')) {
            $redirect = Request::getString('redirect', '', 'POST');
        }
        $msg = DirectoryChecker::createDirectory($path) ? \constant(
            'CO_' . $moduleDirNameUpper . '_' . 'DC_DIRCREATED'
        ) : \constant(
            'CO_' . $moduleDirNameUpper . '_' . 'DC_DIRNOTCREATED'
        );
        \redirect_header($redirect, 2, $msg . ': ' . $path);
        break;
    case 'setdirperm':
        if (Request::hasVar('path', 'POST')) {
            $path = Request::getString('path', '', 'POST');
        }
        if (Request::hasVar('redirect', 'POST')) {
            $redirect = Request::getString('redirect', '', 'POST');
        }
        if (Request::hasVar('mode', 'POST')) {
            $mode = Request::getString('mode', '', 'POST');
        }
        $msg = DirectoryChecker::setDirectoryPermissions($path, $mode) ? \constant(
            'CO_' . $moduleDirNameUpper . '_' . 'DC_PERMSET'
        ) : \constant(
            'CO_' . $moduleDirNameUpper . '_' . 'DC_PERMNOTSET'
        );
        \redirect_header($redirect, 2, $msg . ': ' . $path);
        break;
}
