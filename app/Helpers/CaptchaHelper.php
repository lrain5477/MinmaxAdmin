<?php
namespace App\Helpers;

class CaptchaHelper {
    /**
     * @param string $seed
     * @param string $name
     * @return string
     */
    public static function createCaptcha($seed = '', $name = 'captcha') {
        if($seed == '') $seed = (double) microtime();

        ob_clean();
        ob_start();

        header("Content-type:image/png");

        // 設定亂數種子
        mt_srand($seed * 1000000);

        // 驗證碼變數
        $verification = '';

        // 定義顯示在圖片上的文字，可以再加上大寫字母
        $str = 'abcdefghijkmnpqrstuvwxyz12345678';

        $l = strlen($str); //取得字串長度

        //隨機取出 4 個字
        for($i = 0; $i < 4; $i++) $verification .= $str[rand(0, $l - 1)];

        // 將驗證碼記錄在 Session 中
        session()->put($name, $verification);
        session()->save();

        // 圖片的寬度與高度
        $imageWidth = 80; $imageHeight = 33;
        // 建立圖片物件
        $im = @imagecreatetruecolor($imageWidth, $imageHeight)	or die("無法建立圖片！");

        //主要色彩設定
        // 圖片底色
        $bgColor = imagecolorallocate($im, 255,255,255);
        // 文字顏色
        $Color = imagecolorallocate($im, 240,0,0);
        // 干擾線條顏色
        $gray1 = imagecolorallocate($im, 200,200,200);
        // 干擾像素顏色
        $gray2 = imagecolorallocate($im, 200,200,200);
        //設定圖片底色
        imagefill($im,0,0,$bgColor);
        //底色干擾線條
        for($i=0; $i<25; $i++) imageline($im, rand(0,$imageWidth), rand(0,$imageHeight), rand($imageHeight,$imageWidth), rand(0,$imageHeight), $gray1);
        imagettftext($im, 18, 0, 20, 25, $Color, base_path('/public/font/arial.ttf'), $verification);
        // 干擾像素
        for($i=0; $i < 90; $i++) imagesetpixel($im, rand()%$imageWidth, rand()%$imageHeight, $gray2);

        imagepng($im);
        imagedestroy($im);

        return ob_get_clean();
    }
}