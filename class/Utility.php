<?php

declare(strict_types=1);

namespace XoopsModules\Suico;

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

use WideImage\WideImage;
use Xmf\Request;

/**
 * Class Utility
 */
class Utility extends Common\SysUtility
{
    //--------------- Custom module methods -----------------------------
    /**
     * Access the only instance of this class
     *
     * @return object
     */
    public static function getInstance()
    {
        static $instance;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }

    /**
     * Create a unique upload filename
     *
     * @param string $folder The folder where the file will be saved
     * @param        $filename
     * @param bool   $trimname
     * @return string  The unique filename to use (with its extension)
     */
    public static function createUploadName($folder, $filename, $trimname = false)
    {
        $workingfolder = $folder;
        if ('/' !== \xoops_substr($workingfolder, mb_strlen($workingfolder) - 1, 1)) {
            $workingfolder .= '/';
        }
        $ext  = \basename($filename);
        $ext  = \explode('.', $ext);
        $ext  = '.' . $ext[\count($ext) - 1];
        $true = true;
        while ($true) {
            $ipbits = \explode('.', $_SERVER['REMOTE_ADDR']);
            [$usec, $sec] = \explode(' ', \microtime());
            $usec *= 65536;
            $sec  = ((int)$sec) & 0xFFFF;
            if ($trimname) {
                $uid = \sprintf('%06x%04x%04x', ($ipbits[0] << 24) | ($ipbits[1] << 16) | ($ipbits[2] << 8) | $ipbits[3], $sec, $usec);
            } else {
                $uid = \sprintf('%08x-%04x-%04x', ($ipbits[0] << 24) | ($ipbits[1] << 16) | ($ipbits[2] << 8) | $ipbits[3], $sec, $usec);
            }
            if (!\file_exists($workingfolder . $uid . $ext)) {
                $true = false;
            }
        }
        return $uid . $ext;
    }

    /**
     * Resize a Picture to some given dimensions (using the wideImage library)
     *
     * @param string $src_path      Picture's source
     * @param string $dst_path      Picture's destination
     * @param int    $param_width   Maximum picture's width
     * @param int    $param_height  Maximum picture's height
     * @param bool   $keep_original Do we have to keep the original picture ?
     * @param string $fit           Resize mode (see the wideImage library for more information)
     *
     * @return bool
     */
    public static function resizePicture(
        $src_path,
        $dst_path,
        $param_width,
        $param_height,
        $keep_original = false,
        $fit = 'inside'
    ) {
        $resize = true;
        if ($moduleDirNameUpper . '_DONT_RESIZE_IF_SMALLER') {
            $pictureDimensions = \getimagesize($src_path);
            if (\is_array($pictureDimensions)) {
                $width  = $pictureDimensions[0];
                $height = $pictureDimensions[1];
                if ($width < $param_width && $height < $param_height) {
                    $resize = false;
                }
            }
        }
        $img = WideImage::load($src_path);
        if ($resize) {
            $result = $img->resize($param_width, $param_height, $fit);
            $result->saveToFile($dst_path);
        } else {
            @\copy($src_path, $dst_path);
        }
        if (!$keep_original) {
            @\unlink($src_path);
        }
        return true;
    }

    /**
     * @param        $srcPath
     * @param        $destPath
     * @param        $paramWidth
     * @param        $paramHeight
     * @param bool   $keepOriginal
     * @param string $fit
     */
    public static function resizeSavePicture(
        $srcPath,
        $destPath,
        $paramWidth,
        $paramHeight,
        $keepOriginal = false,
        $fit = 'inside'
    ) {
        if ($allowupload) { // L'image
            if (Request::hasVar('xoops_upload_file', 'POST')) {
                $helper  = Helper::getInstance();
                $fldname = $_FILES[$_POST['xoops_upload_file'][1]];
                $fldname = $fldname['name'];
                if (\xoops_trim('' !== $fldname)) {
                    $destname       = self::createUploadName($destPath, $fldname);
                    $permittedTypes = $helper->getConfig('mimetypes'); //['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'];
                    $uploader       = new \XoopsMediaUploader(XOOPS_ROOT_PATH . '/uploads/news/image', $permittedTypes, $helper->getConfig('maxuploadsize'));
                    $uploader->setTargetFileName($destname);
                    if ($uploader->fetchMedia($_POST['xoops_upload_file'][1])) {
                        if ($uploader->upload()) {
                            $fullPictureName = XOOPS_ROOT_PATH . '/uploads/news/image/' . \basename($destname);
                            $newName         = XOOPS_ROOT_PATH . '/uploads/news/image/redim_' . \basename($destname);
                            self::resizePicture($fullPictureName, $newName, $helper->getConfig('maxwidth'), $helper->getConfig('maxheight'));
                            if (\file_exists($newName)) {
                                @\unlink($fullPictureName);
                                \rename($newName, $fullPictureName);
                            }
                            $story->setPicture(\basename($destname));
                        } else {
                            echo \_AM_SUICO_UPLOAD_ERROR . ' ' . $uploader->getErrors();
                        }
                    } else {
                        echo $uploader->getErrors();
                    }
                }
                $story->setPictureinfo(Request::getString('pictureinfo', '', 'POST'));
            }
        }
    }
}
