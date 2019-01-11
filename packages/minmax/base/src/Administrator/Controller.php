<?php

namespace Minmax\Base\Administrator;

use Breadcrumbs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Minmax\Base\Helpers\Log as LogHelper;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class Controller
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var string $packagePrefix */
    protected $packagePrefix = '';

    /** @var string $uri */
    protected $uri;

    /** @var string $uri */
    protected $rootUri = 'administrator';

    /** @var bool $ajaxRequest */
    protected $ajaxRequest = false;

    /** @var \Illuminate\Support\Collection|\Minmax\Base\Models\WorldLanguage[] $languageData */
    protected $languageData;

    /** @var \Illuminate\Support\Collection|\Minmax\Base\Models\WorldLanguage[] $languageActive */
    protected $languageActive;

    /** @var array $viewData */
    protected $viewData;

    /** @var array $systemMenu */
    protected $systemMenu;

    /** @var \Minmax\Base\Models\WebData $webData */
    protected $webData;

    /** @var \Minmax\Base\Models\AdministratorMenu $pageData */
    protected $pageData;

    /** @var \Minmax\Base\Models\Administrator $adminData */
    protected $adminData;

    /** @var \Minmax\Base\Administrator\Repository $modelRepository */
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
            $this->setViewData();

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

    protected function setViewData()
    {
        $this->viewData['languageData'] = $this->languageData;
        $this->viewData['languageActive'] = $this->languageActive;
        $this->viewData['webData'] = $this->webData;
        $this->viewData['systemMenu'] = $this->systemMenu;
        $this->viewData['pageData'] = $this->pageData;
        $this->viewData['adminData'] = $this->adminData;
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

    /**
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsIndex()
    {
        Breadcrumbs::register('index', function ($breadcrumbs) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('administrator.home');
            $breadcrumbs->push($this->pageData->title);
        });
    }

    /**
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsShow()
    {
        Breadcrumbs::register('view', function ($breadcrumbs) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('administrator.home');
            $breadcrumbs->push($this->pageData->title, langRoute("administrator.{$this->uri}.index"));
            $breadcrumbs->push(__('MinmaxBase::administrator.form.view'));
        });
    }

    /**
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsCreate()
    {
        Breadcrumbs::register('create', function ($breadcrumbs) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('administrator.home');
            $breadcrumbs->push($this->pageData->title, langRoute("administrator.{$this->uri}.index"));
            $breadcrumbs->push(__('MinmaxBase::administrator.form.create'));
        });
    }

    /**
     * @param  string|integer $id
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsEdit($id)
    {
        Breadcrumbs::register('edit', function ($breadcrumbs) use ($id) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('administrator.home');
            $breadcrumbs->push($this->pageData->title, langRoute("administrator.{$this->uri}.index"));
            $breadcrumbs->push(__('MinmaxBase::administrator.form.edit'));
        });
    }

    protected function checkValidate()
    {
        try {
            $reflection = new \ReflectionClass(static::class);
            app($reflection->getNamespaceName() . '\\' . $this->pageData->getAttribute('model') . 'Request');
        } catch (\ReflectionException $e) {}
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->modelRepository->query();
    }

    /**
     * Upload files and return new input set.
     *
     * @param  array $inputSet
     * @param  Request $request
     * @return array
     */
    protected function doFileUpload($inputSet, $request)
    {
        foreach ($inputSet['uploads'] ?? [] as $columnKey => $columnInput) {
            $inputSet[$columnKey] = $columnInput['origin'] ?? null;
            $filePath = 'files/' . ($columnInput['path'] ?? 'uploads');
            $fileList = [];
            foreach ($request->file($this->pageData->getAttribute('model') . '.uploads.' . $columnKey . '.file', []) as $fileItem) {
                /** @var \Illuminate\Http\UploadedFile $fileItem */
                if ($fileItem) {
                    $fileName = microtime() . rand(100000, 999999) . '.' . strtolower($fileItem->getClientOriginalExtension());
                    $fileItem->move(public_path($filePath), $fileName);
                    $fileList[] = $filePath . '/' . $fileName;
                }
            }
            $inputSet[$columnKey] = count($fileList) > 0 ? $fileList : $inputSet[$columnKey];
        }
        if (isset($inputSet['uploads'])) unset($inputSet['uploads']);

        return $inputSet;
    }

    /**
     * Upload files and return new input set.
     *
     * @param  mixed $datatables
     * @param  Request $request
     * @return mixed
     */
    protected function doDatatableFilter($datatables, $request)
    {
        if($request->has('filter') || $request->has('equal')) {
            $datatables->filter(function($query) use ($request) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $whereQuery = '';
                $whereValue = [];

                if($request->has('filter')) {
                    foreach ($request->input('filter') as $column => $value) {
                        if (is_null($value) || $value === '') continue;

                        $whereQuery .= ($whereQuery === '' ? '' : ' or ') . "{$column} like ?";
                        $whereValue[] = "%{$value}%";
                    }
                    if($whereQuery !== '') $whereQuery = "({$whereQuery})";
                }

                if($request->has('equal')) {
                    foreach($request->input('equal') as $column => $value) {
                        if(is_null($value) || $value === '') continue;

                        $whereQuery .= ($whereQuery === '' ? '' : ' and ') . "{$column} = ?";
                        $whereValue[] = "{$value}";
                    }
                }

                if($whereQuery !== '' && count($whereValue) > 0)
                    $query->whereRaw("{$whereQuery}", $whereValue);
            });
        }

        return $datatables;
    }

    /**
     * Upload files and return new input set.
     *
     * @param  mixed $datatables
     * @return mixed
     */
    protected function setDatatablesTransformer($datatables)
    {
        try {
            $reflection = new \ReflectionClass(static::class);
            $datatables->setTransformer(app($reflection->getNamespaceName() . '\\' . $this->pageData->getAttribute('model') . 'Transformer', ['uri' => $this->uri]));
        } catch (\Exception $e) {}

        return $datatables;
    }

    /**
     * DataGrid List
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function index()
    {
        $this->setCustomViewDataIndex();

        $this->buildBreadcrumbsIndex();

        try {
            return view($this->packagePrefix . 'administrator.' . $this->uri . '.index', $this->viewData);
        } catch(\Exception $e) {
            return abort(404);
        }
    }

    /**
     * Model Show
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function show($id)
    {
        $this->viewData['formData'] = $this->modelRepository->find($id) ?? abort(404);

        $this->setCustomViewDataShow();

        $this->buildBreadcrumbsShow();

        try {
            return view($this->packagePrefix . 'administrator.' . $this->uri . '.view', $this->viewData);
        } catch(\Exception $e) {
            return abort(404);
        }
    }

    /**
     * Model Create
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function create()
    {
        $this->viewData['formData'] = $this->modelRepository->query()->getModel();

        $this->setCustomViewDataCreate();

        $this->buildBreadcrumbsCreate();

        try {
            return view($this->packagePrefix . 'administrator.' . $this->uri . '.create', $this->viewData);
        } catch(\Exception $e) {
            return abort(404);
        }
    }

    /**
     * Model Store
     *
     * @param  Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkValidate();

        $inputSet = $request->input($this->pageData->getAttribute('model'));

        $inputSet = $this->doFileUpload($inputSet, $request);

        // 儲存新建資料
        try {
            \DB::beginTransaction();

            if ($modelData = $this->modelRepository->create($inputSet)) {
                \DB::commit();
                LogHelper::system('administrator', $request->path(), $request->method(), $modelData->getKey(), $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.create_success'));
                return redirect(langRoute("administrator.{$this->uri}.edit", [$modelData->getKey()]))->with('success', __('MinmaxBase::administrator.form.message.create_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('administrator', $request->path(), $request->method(), '', $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.create_error'));
        return redirect(langRoute("administrator.{$this->uri}.create"))->withErrors([__('MinmaxBase::administrator.form.message.create_error')])->withInput();
    }

    /**
     * Model Edit
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function edit($id)
    {
        $this->viewData['formData'] = $this->modelRepository->find($id) ?? abort(404);

        $this->setCustomViewDataEdit();

        $this->buildBreadcrumbsEdit($id);

        try {
            return view($this->packagePrefix . 'administrator.' . $this->uri . '.edit', $this->viewData);
        } catch(\Exception $e) {
            return abort(404);
        }
    }

    /**
     * Model Update
     *
     * @param  Request $request
     * @param  string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->checkValidate();

        $model = $this->modelRepository->find($id) ?? abort(404);

        $inputSet = $request->input($this->pageData->getAttribute('model'));

        $inputSet = $this->doFileUpload($inputSet, $request);

        // 儲存更新資料
        try {
            \DB::beginTransaction();

            if ($this->modelRepository->save($model, $inputSet)) {
                \DB::commit();
                LogHelper::system('administrator', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.edit_success'));
                return redirect(langRoute("administrator.{$this->uri}.edit", [$id]))->with('success', __('MinmaxBase::administrator.form.message.edit_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('administrator', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.edit_error'));
        return redirect(langRoute("administrator.{$this->uri}.edit", [$id]))->withErrors([__('MinmaxBase::administrator.form.message.edit_error')])->withInput();
    }

    /**
     * Model Destroy
     *
     * @param  Request $request
     * @param  string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        if ($model = $this->modelRepository->find($id)) {
            if ($this->modelRepository->delete($model)) {
                LogHelper::system('administrator', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.delete_success'));
                return redirect(langRoute("administrator.{$this->uri}.index"))->with('success', __('MinmaxBase::administrator.form.message.delete_success'));
            }
        }

        LogHelper::system('administrator', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.delete_error'));
        return redirect(langRoute("administrator.{$this->uri}.index"))->withErrors([__('MinmaxBase::administrator.form.message.delete_error')]);
    }

    /**
     * Grid data return for DataTables
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function ajaxDataTable(Request $request)
    {
        $queryBuilder = $this->getQueryBuilder();

        $datatable = DataTables::of($queryBuilder);

        $datatable = $this->doDatatableFilter($datatable, $request);

        $datatable = $this->setDatatablesTransformer($datatable);

        return $datatable->make(true);
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxSwitch(Request $request)
    {
        $inputSet = $request->input();

        $validator = validator($inputSet, [
            'id' => 'required',
            'column' => 'required',
            'oriValue' => 'required|boolean',
            'switchTo' => 'required|boolean',
        ]);

        if (!$validator->fails() && $model = $this->modelRepository->find($inputSet['id'])) {
            if ($this->modelRepository->save($model, [$inputSet['column'] => $inputSet['switchTo']])) {
                LogHelper::system('administrator', $request->path(), $request->method(), $inputSet['id'], $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.edit_success'));
                return response([
                    'msg' => 'success',
                    'oriClass' => 'badge-' . systemParam("{$inputSet['column']}.{$inputSet['oriValue']}.options.class"),
                    'newLabel' => systemParam("{$inputSet['column']}.{$inputSet['switchTo']}.title"),
                    'newClass' => 'badge-' . systemParam("{$inputSet['column']}.{$inputSet['switchTo']}.options.class"),
                ], 200, ['Content-Type' => 'application/json']);
            }
        }

        LogHelper::system('administrator', $request->path(), $request->method(), $inputSet['id'], $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.edit_error'));
        return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxSort(Request $request)
    {
        $inputSet = $request->input();

        $validator = validator($inputSet, [
            'id' => 'required',
            'column' => 'required',
            'index' => 'required|integer',
        ]);

        if (!$validator->fails() && $model = $this->modelRepository->find($inputSet['id'])) {
            if ($this->modelRepository->save($model, [$inputSet['column'] => $inputSet['index']])) {
                LogHelper::system('administrator', $request->path(), $request->method(), $inputSet['id'], $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.edit_success'));
                return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
            }
        }

        LogHelper::system('administrator', $request->path(), $request->method(), $inputSet['id'], $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.edit_error'));
        return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxMultiSwitch(Request $request)
    {
        $validator = validator($request->input(), [
            'selected' => 'required|array|min:1',
            'column' => 'required|string',
            'switchTo' => 'required',
        ]);

        $selectedIds = $request->input('selected', []);
        $column = $request->input('column');
        $switchValue = $request->input('switchTo');

        if (!$validator->fails() && count($selectedIds) > 0 && !is_null($column) && !is_null($switchValue)) {
            try {
                \DB::beginTransaction();

                foreach ($selectedIds as $selectedId) {
                    if ($model = $this->modelRepository->find($selectedId)) {
                        if (is_null($this->modelRepository->save($model, [$column => $switchValue]))) {
                            throw new \Exception();
                        }
                    } else {
                        throw new \Exception();
                    }
                }

                \DB::commit();

                foreach ($selectedIds as $selectedId) {
                    LogHelper::system('administrator', $request->path(), $request->method(), $selectedId, $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.edit_success'));
                }
                return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
            } catch (\Exception $e) {
                \DB::rollBack();
            }
        }

        LogHelper::system('administrator', $request->path(), $request->method(), '', $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.edit_error'));
        return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
    }

    /**
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxMultiDestroy(Request $request)
    {
        $validator = validator($request->input(), [
            'selected' => 'required|array|min:1',
        ]);

        $selectedIds = $request->input('selected', []);

        if (!$validator->fails() && count($selectedIds) > 0) {
            try {
                \DB::beginTransaction();

                foreach ($selectedIds as $selectedId) {
                    if ($model = $this->modelRepository->find($selectedId)) {
                        if (! $this->modelRepository->delete($model)) {
                            throw new \Exception();
                        }
                    } else {
                        throw new \Exception();
                    }
                }

                \DB::commit();

                foreach ($selectedIds as $selectedId) {
                    LogHelper::system('administrator', $request->path(), $request->method(), $selectedId, $this->adminData->username, 1, __('MinmaxBase::administrator.form.message.delete_success'));
                }
                return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
            } catch (\Exception $e) {
                \DB::rollBack();
            }
        }

        LogHelper::system('administrator', $request->path(), $request->method(), '', $this->adminData->username, 0, __('MinmaxBase::administrator.form.message.delete_error'));
        return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
    }
}
