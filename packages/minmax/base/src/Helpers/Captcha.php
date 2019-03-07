<?php

namespace Minmax\Base\Helpers;

class Captcha {
    /**
     * Get captcha image with character.
     *
     * @param string $name
     * @param integer $length
     * @param integer $seed
     * @param array $imageSetting ['width' => 80, 'height' => 33, 'fontSize' => 18]
     * @param array $colorSetting ['background' => [<R>, <G>, <B>], 'font' => [<R>, <G>, <B>], 'noise1' => [<R>, <G>, <B>], 'noise2' => [<R>, <G>, <B>]]
     * @return string
     */
    public static function createCaptcha($name = 'captcha', $length = 4, $seed = null, $imageSetting = [], $colorSetting = [])
    {
        $charSet = [
            '1', '2', '3', '4', '5', '6', '7', '8',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        ];
        $verification = static::randCode($length, true, $charSet, $seed);

        // 將驗證碼記錄在 Session 中
        session()->flash($name, $verification);

        $imageWidth      = intval(array_get($imageSetting, 'width', 80));           // 圖片寬度
        $imageHeight     = intval(array_get($imageSetting, 'height', 33));          // 圖片高度
        $fontSize        = intval(array_get($imageSetting, 'fontSize', 18));        // 文字大小
        $backgroundColor = array_get($colorSetting, 'background', [255, 255, 255]); // 圖片底色
        $fontColor       = array_get($colorSetting, 'font', [240, 0, 0]);           // 文字顏色
        $noise1Color     = array_get($colorSetting, 'noise1', [200, 200, 200]);     // 干擾線條顏色
        $noise2Color     = array_get($colorSetting, 'noise2', [200, 200, 200]);     // 干擾像素顏色

        // 建立圖片物件
        $image = \Image::canvas($imageWidth, $imageHeight, $backgroundColor);
        // 底色干擾線條
        for($i= 0; $i < 25; $i++) {
            $image->line(rand(0,$imageWidth), rand(0,$imageHeight), rand(0,$imageWidth), rand(0,$imageHeight),
                function ($draw) use ($noise1Color) {
                    /** @var \Intervention\Image\Gd\Shapes\LineShape $draw */
                    $draw->color('rgb(' . implode(',', $noise1Color) . ')');
                });
        }
        // 繪上文字
        $image->text($verification, floor($imageWidth / 2) + rand(-5, 5), floor($imageHeight / 2) + rand(-2, 2),
            function ($font) use ($fontSize, $fontColor) {
                /** @var \Intervention\Image\Gd\Font $font */
                $font->file(storage_path('app/font/arial.ttf'));
                $font->size($fontSize);
                $font->color($fontColor);
                $font->align('center');
                $font->valign('middle');
                $font->angle(rand(-5, 5));
            });
        // 干擾像素
        for($i= 0; $i < 90; $i++) {
            $image->pixel($noise2Color, rand() % $imageWidth, rand() % $imageHeight);
        }

        return $image->response('png');
    }

    /**
     * Get a random code string.
     *
     * @param int $length
     * @param mixed $duplicate
     * @param array $charSet Using array made long string connecting is possible.
     * @param integer $seed
     * @return string
     */
    public static function randCode($length = 6, $duplicate = false, $charSet = [], $seed = null)
    {
        $defaultCharSet = [
            '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ];

        if(is_array($duplicate)) {
            $charSet = $duplicate;
            $duplicate = false;
        }

        if($duplicate) {
            $charSet = count($charSet) > 0 ? $charSet : $defaultCharSet;
        } else {
            $charSet = count($charSet) >= $length ? $charSet : $defaultCharSet;
        }

        mt_srand((is_null($seed) ? (double) microtime() : $seed) * 1000000);

        $codeCollect = [];

        while(count($codeCollect) < $length) {
            do {
                $randIndex = rand(0, count($charSet) - 1);
                $randChar = $charSet[$randIndex];
            } while(!$duplicate && in_array($randChar, $codeCollect));

            $codeCollect[] = $randChar;
        }

        return implode('', $codeCollect);
    }
}
