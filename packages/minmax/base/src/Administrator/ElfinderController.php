<?php

namespace Minmax\Base\Administrator;

use Barryvdh\Elfinder\Connector;
use Barryvdh\Elfinder\Session\LaravelSession;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Routing\Controller;

/**
 * Class ElfinderController
 */
class ElfinderController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function showIndex()
    {
        try {
            return view($this->packagePrefix . 'administrator.layouts.elfinder.elfinder', $this->getViewVars());
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function showTinyMCE()
    {
        try {
            return view($this->packagePrefix . 'administrator.layouts.elfinder.tinymce', $this->getViewVars());
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function showTinyMCE4()
    {
        try {
            return view($this->packagePrefix . 'administrator.layouts.elfinder.tinymce4', $this->getViewVars());
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function showCKeditor4()
    {
        try {
            return view($this->packagePrefix . 'administrator.layouts.elfinder.ckeditor4', $this->getViewVars());
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function showPopup($input_id)
    {
        try {
            return view($this->packagePrefix . 'administrator.layouts.elfinder.standalonepopup', $this->getViewVars())
                ->with(compact('input_id'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function showFilePicker($input_id)
    {
        $type = request('type');
        $mimeTypes = implode(',', array_map(function ($t) {return "'{$t}'";}, explode(',', $type)));

        try {
            return view($this->packagePrefix . 'administrator.layouts.elfinder.filepicker', $this->getViewVars())
                ->with(compact('input_id', 'type', 'mimeTypes'));
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function showConnector()
    {
        $roots = config('elfinder.roots', []);
        if (empty($roots)) {
            $dirs = (array) config('elfinder.dir', []);
            foreach ($dirs as $dir) {
                $roots[] = ['driver' => 'LocalFileSystem', 'path' => public_path($dir), 'URL' => url($dir), 'accessControl' => config('elfinder.access')];
                // driver for accessing file system (REQUIRED)
                // path to files (REQUIRED)
                // URL to files (REQUIRED)
                // filter callback (OPTIONAL)
            }

            $disks = (array) config('elfinder.disks', []);
            foreach ($disks as $key => $root) {
                if (is_string($root)) {
                    $key = $root;
                    $root = [];
                }
                $disk = app('filesystem')->disk($key);
                if ($disk instanceof FilesystemAdapter) {
                    $roots[] = array_merge(['driver' => 'Flysystem', 'filesystem' => $disk->getDriver(), 'alias' => $key], $root);
                }
            }
        }

        if (app()->bound('session.store')) {
            $sessionStore = app('session.store');
            $session = new LaravelSession($sessionStore);
        } else {
            $session = null;
        }

        $rootOptions = config('elfinder.root_options', []);
        foreach ($roots as $key => $root) {
            $roots[$key] = array_merge($rootOptions, $root);
        }

        $opts = array_merge(config('elfinder.options', []), ['roots' => $roots, 'session' => $session]);

        // run elFinder
        $connector = new Connector(new \elFinder($opts));
        $connector->run();
        return $connector->getResponse();
    }

    protected function getViewVars()
    {
        $dir = 'static/modules/elFinder';

        $locale = str_replace('-', '_', app()->getLocale());
        switch($locale) {
            case 'zh_Hant':
                $locale = 'zh_TW'; break;
            case 'zh_Hans':
                $locale = 'zh_CN'; break;
        }

        if (!file_exists(public_path("/{$dir}/js/i18n/elfinder.{$locale}.js"))) {
            $locale = false;
        }

        $csrf = true;

        return compact('dir', 'locale', 'csrf');
    }
}