<?php

namespace Minmax\Io\Administrator;

use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Minmax\Base\Administrator\Controller;

/**
 * Class IoConstructController
 */
class IoConstructController extends Controller
{
    protected $packagePrefix = 'MinmaxIo::';

    public function __construct(IoConstructRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsConfig()
    {
        Breadcrumbs::register('config', function ($breadcrumbs) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('administrator.home');
            $breadcrumbs->push($this->pageData->title, langRoute("administrator.{$this->uri}.index"));
            $breadcrumbs->push(__('MinmaxIo::administrator.form.config'));
        });
    }

    /**
     * @param  integer $id
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function config($id)
    {
        $this->viewData['formData'] = $this->modelRepository->find($id) ?? abort(404);

        $this->buildBreadcrumbsConfig();

        return view($this->packagePrefix . 'administrator.io-construct.config', $this->viewData);
    }

    /**
     * @param  integer $id
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function example($id)
    {
        if ($model = $this->modelRepository->find($id)) {
            if (Storage::exists($model->example)) {
                return Storage::response($model->example, null, [], 'attachment');
            }
        }

        return abort(404);
    }

    /**
     * @param  Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request, $id)
    {
        if ($model = $this->modelRepository->find($id)) {
            try {
                return app()->call($model->controller, [$request, $id], 'import');
            } catch (\InvalidArgumentException $e) {
                return redirect(langRoute("administrator.io-construct.config"))
                    ->withErrors([__('MinmaxIo::administrator.form.message.import_error', ['title' => $model->title])]);
            }
        }

        return abort(404);
    }

    /**
     * @param  Request $request
     * @param  integer $id
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, $id)
    {
        if ($model = $this->modelRepository->find($id)) {
            try {
                return app()->call($model->controller, [$request, $id], 'export');
            } catch (\InvalidArgumentException $e) {
                return redirect(langRoute("administrator.io-construct.config"))
                    ->withErrors([__('MinmaxIo::administrator.form.message.export_error', ['title' => $model->title])]);
            }
        }

        return abort(404);
    }
}
