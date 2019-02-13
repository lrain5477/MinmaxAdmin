<?php

namespace Minmax\Io\Admin;

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Minmax\Base\Admin\Controller;

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
     * @param  mixed $datatable
     * @param  Request $request
     * @return mixed
     */
    protected function doDatatableFilter($datatable, $request)
    {
        $datatable->filter(function($query) use ($request) {
            /** @var \Illuminate\Database\Query\Builder $query */

            if($request->has('filter')) {
                $query->where(function ($query) use ($request) {
                    /** @var \Illuminate\Database\Query\Builder $query */

                    foreach ($request->input('filter', []) as $column => $value) {
                        if (empty($column) || is_null($value) || $value === '') continue;

                        if ($column == 'title') {
                            try {
                                $filterDisplayName = collect(cache('langMap.' . app()->getLocale(), []))
                                    ->filter(function ($item, $key) use ($value) {
                                        return preg_match('/^io_construct\.title\./', $key) > 0 && strpos($item, $value) !== false;
                                    })
                                    ->keys()
                                    ->toArray();
                                $query->orWhereIn($column, $filterDisplayName);
                            } catch (\Exception $e) {
                            }
                            continue;
                        }

                        $query->orWhere($column, 'like', "%{$value}%");
                    }
                });
            }

            if($request->has('equal')) {
                foreach($request->input('equal', []) as $column => $value) {
                    if (empty($column) || is_null($value) || $value === '') continue;

                    $query->where($column, $value);
                }
            }
        });

        return $datatable;
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
            if ($model->example == 'controller') {
                try {
                    return app()->call($model->controller, [$id], 'example');
                } catch (\InvalidArgumentException $e) {
                    return abort(404);
                } catch (\Exception $e) {
                    return abort(404);
                }
            }

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
                return app()->call($model->controller, [$id], 'import');
            } catch (\InvalidArgumentException $e) {
                return redirect(langRoute("admin.io-data.config", ['id' => $id]))
                    ->withErrors([__('MinmaxIo::admin.form.message.import_error', ['title' => $model->title])]);
            } catch (\Exception $e) {
                return redirect(langRoute("admin.io-data.config", ['id' => $id]))
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
                return app()->call($model->controller, [$id], 'export');
            } catch (\InvalidArgumentException $e) {
                return redirect(langRoute("admin.io-data.config", ['id' => $id]))
                    ->withErrors([__('MinmaxIo::admin.form.message.export_error', ['title' => $model->title])]);
            } catch (\Exception $e) {
                return redirect(langRoute("admin.io-data.config", ['id' => $id]))
                    ->withErrors([__('MinmaxIo::admin.form.message.import_error', ['title' => $model->title])]);
            }
        }

        return abort(404);
    }
}
