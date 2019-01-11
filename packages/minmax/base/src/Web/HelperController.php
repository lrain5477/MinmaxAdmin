<?php

namespace Minmax\Base\Web;

use Illuminate\Routing\Controller as BaseController;
use Minmax\Base\Helpers\Captcha as CaptchaHelper;

/**
 * Class HelperController
 */
class HelperController extends BaseController
{
    /**
     * @param  string $name
     * @param  integer $id
     * @return string
     */
    public function getCaptcha($name, $id = null)
    {
        return CaptchaHelper::createCaptcha('web_captcha_' . $name, 4, $id);
    }
}
