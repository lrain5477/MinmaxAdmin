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
    public static function createCaptcha($name = 'captcha', $length = 4, $seed = null, $imageSetting = [], $colorSetting = []) {
        $charSet = [
            '1', '2', '3', '4', '5', '6', '7', '8',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        ];
        $verification = static::randCode($length, true, $charSet, $seed);

        // 將驗證碼記錄在 Session 中
        session()->put($name, $verification);
        session()->save();

        if(ob_get_contents()) ob_clean();
        ob_start();

        header("Content-type:image/png");

        // 圖片寬度
        $imageWidth  = $imageSetting['width']  ?? 80;
        // 圖片高度
        $imageHeight = $imageSetting['height'] ?? 33;
        // 文字大小
        $fontSize = $imageSetting['fontSize'] ?? 18;
        // 建立圖片物件
        $im = @imagecreatetruecolor($imageWidth, $imageHeight)	or die("無法建立圖片！");

        // 圖片底色
        $backgroundColor = imagecolorallocate($im,
            $colorSetting['background'][0] ?? 255,
            $colorSetting['background'][1] ?? 255,
            $colorSetting['background'][2] ?? 255
        );
        // 文字顏色
        $fontColor = imagecolorallocate($im,
            $colorSetting['font'][0] ?? 240,
            $colorSetting['font'][1] ?? 0,
            $colorSetting['font'][2] ?? 0
        );
        // 干擾線條顏色
        $noiseColor1 = imagecolorallocate($im,
            $colorSetting['noise1'][0] ?? 200,
            $colorSetting['noise1'][1] ?? 200,
            $colorSetting['noise1'][2] ?? 200
        );
        // 干擾像素顏色
        $noiseColor2 = imagecolorallocate($im,
            $colorSetting['noise2'][0] ?? 200,
            $colorSetting['noise2'][1] ?? 200,
            $colorSetting['noise2'][2] ?? 200
        );
        // 設定圖片底色
        imagefill($im, 0, 0, $backgroundColor);
        // 底色干擾線條
        for($i= 0; $i < 25; $i++) imageline($im, rand(0,$imageWidth), rand(0,$imageHeight), rand($imageHeight,$imageWidth), rand(0,$imageHeight), $noiseColor1);
        // 繪上文字
        imagettftext($im, $fontSize, 0, 20, 25, $fontColor, base_path('/public/font/arial.ttf'), $verification);
        // 干擾像素
        for($i= 0; $i < 90; $i++) imagesetpixel($im, rand()%$imageWidth, rand()%$imageHeight, $noiseColor2);

        imagepng($im);
        imagedestroy($im);

        return ob_get_clean();
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