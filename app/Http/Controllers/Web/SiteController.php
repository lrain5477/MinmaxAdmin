<?php

namespace App\Http\Controllers\Web;

use Minmax\Base\Web\Controller as BaseController;

/**
 * Class SiteController
 */
class SiteController extends BaseController
{
    public function index()
    {
        dd($this->viewData);
    }
}
