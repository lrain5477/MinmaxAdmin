<?php

namespace Minmax\Base\Helpers;

use \Illuminate\Support\Facades\File;

class Image
{
    /**
     * @param  string $filePath
     * @param  integer $maxWidth
     * @param  integer $maxHeight
     * @param  boolean $upSize
     * @param  boolean $overwrite if true, always rebuild thumbnail and overwrite file.
     * @param  integer $quality is between 0 to 100.
     * @return string|null
     */
    public static function makeThumbnail($filePath, $maxWidth, $maxHeight, $upSize = true, $overwrite = false, $quality = 80)
    {
        if(is_int($overwrite)) { $quality = $overwrite; $overwrite = false; }

        $filePath = preg_replace('/^\//i', '', $filePath);

        if(File::exists(public_path($filePath))) {
            $fileName      = str_replace(['/', '.' . File::extension($filePath)], '_', $filePath);
            $fileExtension = strtolower(File::extension($filePath));
            $thumbnailPath = "files/thumbnails/{$fileName}{$maxWidth}x{$maxHeight}.{$fileExtension}";

            if(file_exists(public_path($thumbnailPath)) && !$overwrite) {
                if (File::lastModified(public_path($thumbnailPath)) >= File::lastModified(public_path($filePath))) {
                    return $thumbnailPath;
                }
            }

            if ($image = \Image::make(public_path($filePath))) {
                $image->resize($maxWidth, $maxHeight, function ($constraint) use ($upSize) {
                    /** @var \Intervention\Image\Constraint $constraint */
                    $constraint->aspectRatio();
                    if ($upSize) $constraint->upsize();
                });

                try {
                    if ($image->save(public_path($thumbnailPath), $quality)) {
                        return $thumbnailPath;
                    }
                } catch (\Exception $e) {}
            }
        }

        return null;
    }
}
