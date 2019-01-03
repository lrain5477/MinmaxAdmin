<?php

namespace Minmax\Io\Admin;

use Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Minmax\Base\Admin\Controller;
use Minmax\Base\Helpers\Permission as PermissionHelper;

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
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push($this->pageData->title, langRoute("admin.{$this->uri}.index"));
            $breadcrumbs->push(__('MinmaxIo::admin.form.config'));
        });
    }

    /**
     * Set datatable filter.
     *
     * @param  mixed $datatables
     * @param  Request $request
     * @return mixed
     */
    protected function doDatatableFilter($datatables, $request)
    {
        if($request->has('filter')) {
            $datatables->filter(function($query) use ($request) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $whereQuery = '';
                $whereValue = [];

                if($request->has('filter')) {
                    foreach ($request->input('filter') as $column => $value) {
                        if (is_null($value) || $value === '') continue;

                        if ($column == 'title') {
                            try {
                                $filterDisplayName = collect(cache('langMap.' . app()->getLocale(), []))
                                    ->filter(function ($item, $key) use ($value) {
                                        return preg_match('/^io-construct\.title\./', $key) > 0 && strpos($item, $value) !== false;
                                    })
                                    ->keys()
                                    ->implode(',');
                            } catch (\Exception $e) {
                                $filterDisplayName = '';
                            }
                            $whereQuery .= ($whereQuery === '' ? '' : ' or ') . "{$column} in (?)";
                            $whereValue[] = $filterDisplayName;
                            continue;
                        }

                        $whereQuery .= ($whereQuery === '' ? '' : ' or ') . "{$column} like ?";
                        $whereValue[] = "%{$value}%";
                    }
                    if($whereQuery !== '') $whereQuery = "({$whereQuery})";
                }

                if($whereQuery !== '' && count($whereValue) > 0)
                    $query->whereRaw("{$whereQuery}", $whereValue);
            });
        }

        return $datatables;
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

        return view($this->packagePrefix . 'admin.io-data.config', $this->viewData);
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
                return redirect(langRoute("admin.io-data.config"))
                    ->withErrors([__('MinmaxIo::admin.form.message.import_error', ['title' => $model->title])]);
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
                return redirect(langRoute("admin.io-data.config"))
                    ->withErrors([__('MinmaxIo::admin.form.message.export_error', ['title' => $model->title])]);
            }
        }

        return abort(404);
    }
}
