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
 * Image resizer class for xoops
 *
 * @copyright      2000-2020 XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2.0 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         Goffy - Wedega - Email:<webmaster@wedega.com> - Website:<https://wedega.com>
 */
class Resizer
{
    public string $sourceFile    = '';
    public string $endFile       = '';
    public int    $maxWidth      = 0;
    public int    $maxHeight     = 0;
    public string $imageMimetype = '';
    public int    $jpgQuality    = 90;
    public int    $mergeType     = 0;
    public int    $mergePos      = 0;
    public int    $degrees       = 0;
    public string $error         = '';

    /**
     * resize image if size exceed given width/height
     * @return string|bool
     */
    public function resizeImage()
    {
        // check file extension
        switch ($this->imageMimetype) {
            case 'image/png':
                $img = \imagecreatefrompng($this->sourceFile);
                break;
            case 'image/jpeg':
                $img = \imagecreatefromjpeg($this->sourceFile);
                if (!$img) {
                    $img = \imagecreatefromstring(\file_get_contents($this->sourceFile));
                }
                break;
            case 'image/gif':
                $img = \imagecreatefromgif($this->sourceFile);
                break;
            default:
                return 'Unsupported format';
        }
        $width  = \imagesx($img);
        $height = \imagesy($img);
        if ($width > $this->maxWidth || $height > $this->maxHeight) {
            // recalc image size based on this->maxWidth/this->maxHeight
            if ($width > $height) {
                if ($width < $this->maxWidth) {
                    $newWidth = $width;
                } else {
                    $newWidth  = $this->maxWidth;
                    $divisor   = $width / $newWidth;
                    $newHeight = (int)\floor($height / $divisor);
                }
            } elseif ($height < $this->maxHeight) {
                $newHeight = (int)$height;
            } else {
                $newHeight = $this->maxHeight;
                $divisor   = $height / $newHeight;
                $newWidth  = (int)\floor($width / $divisor);
            }
            // Create a new temporary image.
            $tmpimg = \imagecreatetruecolor($newWidth, $newHeight);
            \imagealphablending($tmpimg, false);
            \imagesavealpha($tmpimg, true);
            // Copy and resize old image into new image.
            \imagecopyresampled(
                $tmpimg,
                $img,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $width,
                $height
            );
            \unlink($this->endFile);
            //compressing the file
            switch ($this->imageMimetype) {
                case 'image/png':
                    \imagepng($tmpimg, $this->endFile, 0);
                    break;
                case 'image/jpeg':
                    \imagejpeg($tmpimg, $this->endFile, 100);
                    break;
                case 'image/gif':
                    \imagegif($tmpimg, $this->endFile);
                    break;
            }
            // release the memory
            \imagedestroy($tmpimg);
        } else {
            return 'copy';
        }
        \imagedestroy($img);

        return true;
    }

    /**
     * @return bool|string
     */
    public function resizeAndCrop()
    {
        // check file extension
        switch ($this->imageMimetype) {
            case 'image/png':
                $original = \imagecreatefrompng($this->sourceFile);
                break;
            case 'image/jpeg':
                $original = \imagecreatefromjpeg($this->sourceFile);
                break;
            case 'image/gif':
                $original = \imagecreatefromgif($this->sourceFile);
                break;
            default:
                return 'Unsupported format';
        }
        if (!$original) {
            return false;
        }
        // GET ORIGINAL IMAGE DIMENSIONS
        [$original_w, $original_h] = \getimagesize($this->sourceFile);
        // RESIZE IMAGE AND PRESERVE PROPORTIONS
        $max_width_resize  = $this->maxWidth;
        $max_height_resize = $this->maxHeight;
        if ($original_w > $original_h) {
            $max_height_ratio = $this->maxHeight / $original_h;
            $max_width_resize = (int)\round($original_w * $max_height_ratio);
        } else {
            $max_width_ratio   = $this->maxWidth / $original_w;
            $max_height_resize = (int)\round($original_h * $max_width_ratio);
        }
        if ($max_width_resize < $this->maxWidth) {
            $max_height_ratio  = $this->maxWidth / $max_width_resize;
            $max_height_resize = (int)\round($this->maxHeight * $max_height_ratio);
            $max_width_resize  = $this->maxWidth;
        }
        // CREATE THE PROPORTIONAL IMAGE RESOURCE
        $thumb = \imagecreatetruecolor($max_width_resize, $max_height_resize);
        if (!\imagecopyresampled(
            $thumb,
            $original,
            0,
            0,
            0,
            0,
            $max_width_resize,
            $max_height_resize,
            $original_w,
            $original_h
        )) {
            return false;
        }
        // CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
        $final             = \imagecreatetruecolor(
            $this->maxWidth,
            $this->maxHeight
        );
        $max_width_offset  = 0;
        $max_height_offset = 0;
        if ($this->maxWidth < $max_width_resize) {
            $max_width_offset = (int)\round(($max_width_resize - $this->maxWidth) / 2);
        } else {
            $max_height_offset = (int)\round(($max_height_resize - $this->maxHeight) / 2);
        }
        if (!\imagecopy(
            $final,
            $thumb,
            0,
            0,
            $max_width_offset,
            $max_height_offset,
            $max_width_resize,
            $max_height_resize
        )) {
            return false;
        }
        // STORE THE FINAL IMAGE - WILL OVERWRITE $this->endFile
        if (!\imagejpeg(
            $final,
            $this->endFile,
            $this->jpgQuality
        )) {
            return false;
        }

        return true;
    }

    /**
     * @return void
     */
    public function mergeImage(): void
    {
        $dest = \imagecreatefromjpeg($this->endFile);
        $src  = \imagecreatefromjpeg($this->sourceFile);
        if (4 === $this->mergeType) {
            $imgWidth  = (int)\round($this->maxWidth / 2 - 1);
            $imgHeight = (int)\round($this->maxHeight / 2 - 1);
            $posCol2   = (int)\round($this->maxWidth / 2 + 1);
            $posRow2   = (int)\round($this->maxHeight / 2 + 1);
            switch ($this->mergePos) {
                case 1:
                    \imagecopy($dest, $src, 0, 0, 0, 0, $imgWidth, $imgHeight); //top left
                    break;
                case 2:
                    \imagecopy($dest, $src, $posCol2, 0, 0, 0, $imgWidth, $imgHeight); //top right
                    break;
                case 3:
                    \imagecopy($dest, $src, 0, $posRow2, 0, 0, $imgWidth, $imgHeight); //bottom left
                    break;
                case 4:
                    \imagecopy($dest, $src, $posCol2, $posRow2, 0, 0, $imgWidth, $imgHeight); //bottom right
                    break;
            }
        }
        if (6 === $this->mergeType) {
            $imgWidth  = (int)\round($this->maxWidth / 3 - 1);
            $imgHeight = (int)\round($this->maxHeight / 2 - 1);
            $posCol2   = (int)\round($this->maxWidth / 3 + 1);
            $posCol3   = $posCol2 + (int)\round($this->maxWidth / 3 + 1);
            $posRow2   = (int)\round($this->maxHeight / 2 + 1);
            switch ($this->mergePos) {
                case 1:
                    \imagecopy($dest, $src, 0, 0, 0, 0, $imgWidth, $imgHeight); //top left
                    break;
                case 2:
                    \imagecopy($dest, $src, $posCol2, 0, 0, 0, $imgWidth, $imgHeight); //top center
                    break;
                case 3:
                    \imagecopy($dest, $src, $posCol3, 0, 0, 0, $imgWidth, $imgHeight); //top right
                    break;
                case 4:
                    \imagecopy($dest, $src, 0, $posRow2, 0, 0, $imgWidth, $imgHeight); //bottom left
                    break;
                case 5:
                    \imagecopy($dest, $src, $posCol2, $posRow2, 0, 0, $imgWidth, $imgHeight); //bottom center
                    break;
                case 6:
                    \imagecopy($dest, $src, $posCol3, $posRow2, 0, 0, $imgWidth, $imgHeight); //bottom right
                    break;
            }
        }
        \imagejpeg($dest, $this->endFile);
        \imagedestroy($src);
        \imagedestroy($dest);
    }

    /**
     * @return bool|string
     */
    public function rotateImage()
    {
        // check file extension
        switch ($this->imageMimetype) {
            case 'image/png':
                $original = \imagecreatefrompng($this->sourceFile);
                break;
            case 'image/jpeg':
                $original = \imagecreatefromjpeg($this->sourceFile);
                break;
            case 'image/gif':
                $original = \imagecreatefromgif($this->sourceFile);
                break;
            default:
                return 'Unsupported format';
        }
        if (!$original) {
            return false;
        }
        // Rotate
        $tmpimg = \imagerotate($original, $this->degrees, 0);
        \unlink($this->endFile);
        //compressing the file
        switch ($this->imageMimetype) {
            case 'image/png':
                if (!\imagepng($tmpimg, $this->endFile, 0)) {
                    return false;
                }
                break;
            case 'image/jpeg':
                if (!\imagejpeg($tmpimg, $this->endFile, $this->jpgQuality)) {
                    return false;
                }
                break;
            case 'image/gif':
                if (!\imagegif($tmpimg, $this->endFile)) {
                    return false;
                }
                break;
        }
        // release the memory
        \imagedestroy($tmpimg);

        return true;
    }
}
