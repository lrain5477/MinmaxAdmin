<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\Elfinder\ElfinderController as BaseElfinderController;

class ElfinderController extends BaseElfinderController
{
    protected function getViewVars()
    {
        $guard = 'admin';
        $dir = 'components/elFinder';
        $locale = str_replace("-",  "_", $this->app->config->get('app.locale'));
        switch ($locale) {
            case 'tw':
                $locale = 'zh_TW';
                break;
            case 'cn':
                $locale = 'zh_CN';
                break;
            case 'jp':
                $locale = 'ja';
                break;
            default:
                $locale = '';
        }
        if (!file_exists($this->app['path.public'] . "/$dir/js/i18n/elfinder.$locale.js")) {
            $locale = false;
        }
        $csrf = true;
        return compact('dir', 'locale', 'csrf', 'guard');
    }
}