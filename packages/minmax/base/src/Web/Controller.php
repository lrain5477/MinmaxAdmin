<?php

namespace Minmax\Base\Web;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * Abstract class Controller
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var string $packagePrefix */
    protected $packagePrefix = '';

    /** @var string $uri */
    protected $uri;

    /** @var string $uri */
    protected $rootUri = '';

    /** @var bool $ajaxRequest */
    protected $ajaxRequest = false;

    /** @var \Illuminate\Support\Collection|\Minmax\Base\Models\WorldLanguage[] $languageData */
    protected $languageData;

    /** @var array $viewData */
    protected $viewData;

    /** @var array $systemMenu */
    protected $systemMenu;

    /** @var \Minmax\Base\Models\WebData $webData */
    protected $webData;

    /** @var \Minmax\Base\Models\AdminMenu $pageData */
    protected $pageData;

    /** @var \Minmax\Base\Admin\Repository $modelRepository */
    protected $modelRepository;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            /** @var Request $request */

            // 設定 Controller 參數
            $this->setAttributes($request->get('controllerAttributes'));

            // 設定 viewData
            $this->setDefaultViewData();

            return $next($request);
        });
    }

    /**
     * Set this controller object attributes
     *
     * @param  array $attributes
     * @return void
     */
    protected function setAttributes($attributes)
    {
        foreach ($attributes ?? [] as $attribute => $value) {
            $this->{$attribute} = $value;
        }
    }

    protected function setDefaultViewData()
    {
        $this->viewData['languageData'] = $this->languageData;
        $this->viewData['webData'] = $this->webData;
        $this->viewData['systemMenu'] = $this->systemMenu;
        $this->viewData['pageData'] = $this->pageData;
        $this->viewData['rootUri'] = ($this->webData->system_language == app()->getLocale() ? '' : (app()->getLocale() . '/')) . $this->rootUri;
    }

    protected function setCustomViewDataIndex()
    {
        //
    }

    protected function setCustomViewDataShow()
    {
        //
    }

    protected function setCustomViewDataCreate()
    {
        //
    }

    protected function setCustomViewDataEdit()
    {
        //
    }
}
