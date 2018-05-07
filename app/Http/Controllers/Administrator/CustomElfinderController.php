<?php

namespace App\Http\Controllers\Administrator;

use Barryvdh\Elfinder\ElfinderController;

class CustomElfinderController extends ElfinderController
{
    protected function getViewVars()
    {
        $dir = 'packages/barryvdh/' . $this->package;
        $locale = str_replace("-",  "_", $this->app->config->get('app.locale'));
        switch ($locale) {
            case 'tw':
                $locale = 'zh_TW';
                break;
            case 'cn':
                $locale = 'zh_CN';
                break;
        }
        if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js")) {
            $locale = false;
        }
        $csrf = true;
        return compact('dir', 'locale', 'csrf');
    }
}