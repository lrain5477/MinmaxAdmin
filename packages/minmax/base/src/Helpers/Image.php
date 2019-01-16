<?php

namespace Minmax\Base\Helpers;

use \Illuminate\Support\Facades\File;
use \Illuminate\Support\Facades\Storage;

class Image
{
    /**
     * @param string $filePath
     * @param integer $maxWidth
     * @param integer $maxHeight
     * @param bool $overwrite if true, always rebuild thumbnail and overwrite file.
     * @param integer $quality is between 0 to 100.
     * @return string|null
     */
    public static function makeThumbnail($filePath, $maxWidth, $maxHeight, $overwrite = false, $quality = 80)
    {
        if(is_int($overwrite)) { $quality = $overwrite; $overwrite = false; }

        $filePath = preg_replace('/^\//i', '', $filePath);

        if(File::exists(public_path($filePath))) {
            $filename = str_replace(['/', '.' . File::extension($filePath)], '_', $filePath);
            $fileExtension = strtolower(File::extension($filePath));
            $thumbnailPath = "files/thumbnails/{$filename}{$maxWidth}x{$maxHeight}.{$fileExtension}";

            if(file_exists(public_path($thumbnailPath)) && !$overwrite) {
                if (File::lastModified(public_path($thumbnailPath)) >= File::lastModified(public_path($filePath))) {
                    return $thumbnailPath;
                }
            }

            try {
                $image = null;
                list($width, $height) = getimagesize(public_path($filePath));

                if($maxWidth / $width <= $maxHeight / $height) {
                    $zoomPercent = $maxWidth / $width;
                } else {
                    $zoomPercent = $maxHeight / $height;
                }

                $newWidth = $zoomPercent < 1 ? $width * $zoomPercent : $width;
                $newHeight = $zoomPercent < 1 ? $height * $zoomPercent : $height;

                switch ($fileExtension) {
                    case 'jpg':
                        $image = imagecreatefromjpeg(public_path($filePath));
                        break;
                    case 'png':
                        $image = imagecreatefrompng(public_path($filePath));
                        break;
                    case 'gif':
                        $image = imagecreatefromgif(public_path($filePath));
                        break;
                }

                if($image === null) return null;

                $thumbnail = imagecreatetruecolor($newWidth, $newHeight);

                $storageStatus = false;
                switch ($fileExtension) {
                    case 'jpg':
                        imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        $storageStatus = imagejpeg($thumbnail, public_path($thumbnailPath), $quality);
                        break;
                    case 'png':
                        imagesavealpha($thumbnail, true);
                        imagefill($thumbnail, 0, 0, imagecolorallocatealpha($thumbnail, 0, 0, 0, 127));
                        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        $storageStatus = imagepng($thumbnail, public_path($thumbnailPath));
                        break;
                    case 'gif':
                        imagesavealpha($thumbnail, true);
                        imagefill($thumbnail, 0, 0, imagecolorallocatealpha($thumbnail, 0, 0, 0, 127));
                        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        $storageStatus = imagegif($thumbnail, public_path($thumbnailPath));
                        break;
                }

                if($storageStatus)
                    return $thumbnailPath;

                return null;
            } catch (\Exception $e) {
                return null;
            }
        } else {
            return null;
        }
    }
}