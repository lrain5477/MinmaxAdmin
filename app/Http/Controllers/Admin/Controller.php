<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Helpers\PermissionHelper;
use App\Repositories\Admin\AdminMenuRepository;
use App\Repositories\Admin\WebDataRepository;
use App\Repositories\Admin\WorldLanguageRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Breadcrumbs;

/**
 * Class Controller
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /** @var string $uri */
    protected $uri;

    /** @var string $uri */
    protected $rootUri = 'siteadmin';

    /** @var bool $ajaxRequest */
    protected $ajaxRequest = false;

    /** @var \Illuminate\Support\Collection|\App\Models\WorldLanguage[] $languageData */
    protected $languageData;

    /** @var array $viewData */
    protected $viewData;

    /** @var array $systemMenu */
    protected $systemMenu;

    /** @var \App\Models\WebData $webData */
    protected $webData;

    /** @var \App\Models\AdminMenu $pageData */
    protected $pageData;

    /** @var \App\Models\Admin $adminData */
    protected $adminData;

    /** @var \App\Repositories\Admin\Repository $modelRepository */
    protected $modelRepository;

    public function __construct(Request $request)
    {
        // 設定 語言資料
        $this->languageData = \Cache::rememberForever('languageSet', function() {
            return (new WorldLanguageRepository())
                ->all(function($query) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    $query->where('active', '1')->orderBy('sort');
                });
        });

        // 設定 網站資料
        $this->webData = (new WebDataRepository())->getData() ?? abort(404);
        if ($this->webData->active != '1') abort(404, $this->webData->offline_text);

        // 設定 Uri
        $this->uri = explode('/', $request->path())[$this->languageData->count() > 1 ? 2 : 1] ?? '';

        // 設定 選單資料
        $this->systemMenu = (new AdminMenuRepository())->getMenu();

        // 設定 頁面資料
        $this->pageData = (new AdminMenuRepository())->one(['uri' => $this->uri, 'active' => 1]);

        $this->middleware(function ($request, $next) {
            /** @var Request $request */

            // 設定 帳號資料
            $this->adminData = $request->user('admin');

            // 設定 viewData
            $this->setViewData();

            return $next($request);
        });
    }

    protected function setViewData()
    {
        $this->viewData['languageData'] = $this->languageData;
        $this->viewData['webData'] = $this->webData;
        $this->viewData['systemMenu'] = $this->systemMenu;
        $this->viewData['pageData'] = $this->pageData;
        $this->viewData['adminData'] = $this->adminData;
        $this->viewData['rootUri'] = $this->rootUri . '/' . ($this->languageData->count() > 1 ? (app()->getLocale() . '/') : '');
    }

    protected function checkPermissionCreate($type = 'web')
    {
        switch ($type) {
            case 'web':
                $statusCode = 404; break;
            case 'ajax':
                $statusCode = 401; break;
            default:
                $statusCode = 500; break;
        }
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Create')) === false) abort($statusCode);
    }

    protected function checkPermissionShow($type = 'web')
    {
        switch ($type) {
            case 'web':
                $statusCode = 404; break;
            case 'ajax':
                $statusCode = 401; break;
            default:
                $statusCode = 500; break;
        }
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === false) abort($statusCode);
    }

    protected function checkPermissionEdit($type = 'web')
    {
        switch ($type) {
            case 'web':
                $statusCode = 404; break;
            case 'ajax':
                $statusCode = 401; break;
            default:
                $statusCode = 500; break;
        }
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) abort($statusCode);
    }

    protected function checkPermissionDestroy($type = 'web')
    {
        switch ($type) {
            case 'web':
                $statusCode = 404; break;
            case 'ajax':
                $statusCode = 401; break;
            default:
                $statusCode = 500; break;
        }
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Destroy')) === false) abort($statusCode);
    }

    /**
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsIndex()
    {
        Breadcrumbs::register('index', function ($breadcrumbs) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('admin.home');
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
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push($this->pageData->title, langRoute("admin.{$this->uri}.index"));
            $breadcrumbs->push(__('admin.form.view'));
        });
    }

    /**
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    protected function buildBreadcrumbsCreate()
    {
        Breadcrumbs::register('create', function ($breadcrumbs) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push(
                $this->pageData->title,
                $this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === true
                    ? langRoute("admin.{$this->uri}.index")
                    : null
            );
            $breadcrumbs->push(__('admin.form.create'));
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
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push(
                $this->pageData->title,
                $this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === true
                    ? langRoute("admin.{$this->uri}.index")
                    : null
            );
            $breadcrumbs->push(__('admin.form.edit'));
        });
    }

    protected function checkValidate()
    {
        app('App\\Http\\Requests\\Admin\\' . $this->pageData->getAttribute('model') . 'Request');
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
        $datatables->setTransformer(app('App\\Transformers\\Admin\\' . $this->pageData->getAttribute('model') . 'Transformer', ['uri' => $this->uri]));

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
        $this->checkPermissionShow();

        $this->buildBreadcrumbsIndex();

        try {
            return view('admin.' . $this->uri . '.index', $this->viewData);
        } catch(\Exception $e) {
            return abort(404);
        }
    }

    /**
     * Model Show
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function show($id)
    {
        $this->checkPermissionShow();

        $this->viewData['formData'] = $this->modelRepository->find($id) ?? abort(404);

        $this->buildBreadcrumbsShow();

        try {
            return view('admin.' . $this->uri . '.view', $this->viewData);
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
        $this->checkPermissionCreate();

        $this->viewData['formData'] = $this->modelRepository->query()->getModel();

        $this->buildBreadcrumbsCreate();

        try {
            return view('admin.' . $this->uri . '.create', $this->viewData);
        } catch(\Exception $e) {
            return abort(404);
        }
    }

    /**
     * Model Store
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->checkPermissionCreate();

        $this->checkValidate();

        $inputSet = $request->input($this->pageData->getAttribute('model'));

        $inputSet = $this->doFileUpload($inputSet, $request);

        // 儲存新建資料
        try {
            \DB::beginTransaction();

            if ($modelData = $this->modelRepository->create($inputSet)) {
                \DB::commit();
                LogHelper::system('admin', $request->path(), $request->method(), $modelData->getKey(), $this->adminData->username, 1, __('admin.form.message.create_success'));
                return redirect(langRoute("admin.{$this->uri}.edit", [$modelData->getKey()]))->with('success', __('admin.form.message.create_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('admin', $request->path(), $request->method(), '', $this->adminData->username, 0, __('admin.form.message.create_error'));
        return redirect(langRoute("admin.{$this->uri}.create"))->withErrors([__('admin.form.message.create_error')])->withInput();
    }

    /**
     * Model Edit
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function edit($id)
    {
        $this->checkPermissionEdit();

        $this->viewData['formDataId'] = $id;
        $this->viewData['formData'] = $this->modelRepository->find($id) ?? abort(404);

        $this->buildBreadcrumbsEdit($id);

        try {
            return view('admin.' . $this->uri . '.edit', $this->viewData);
        } catch(\Exception $e) {
            return abort(404);
        }
    }

    /**
     * Model Update
     *
     * @param string $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        $this->checkPermissionEdit();

        $this->checkValidate();

        $model = $this->modelRepository->find($id) ?? abort(404);

        $inputSet = $request->input($this->pageData->getAttribute('model'));

        $inputSet = $this->doFileUpload($inputSet, $request);

        // 儲存更新資料
        try {
            \DB::beginTransaction();

            if ($this->modelRepository->save($model, $inputSet)) {
                \DB::commit();
                LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('admin.form.message.edit_success'));
                return redirect(langRoute("admin.{$this->uri}.edit", [$id]))->with('success', __('admin.form.message.edit_success'));
            }

            \DB::rollBack();
        } catch (\Exception $e) {
            \DB::rollBack();
        }

        LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('admin.form.message.edit_error'));
        return redirect(langRoute("admin.{$this->uri}.edit", [$id]))->withErrors([__('admin.form.message.edit_error')])->withInput();
    }

    /**
     * Model Destroy
     *
     * @param string $id
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        $this->checkPermissionDestroy();

        if ($model = $this->modelRepository->find($id)) {
            if ($this->modelRepository->delete($model)) {
                LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 1, __('admin.form.message.delete_success'));
                return redirect(langRoute("admin.{$this->uri}.index"))->with('success', __('admin.form.message.delete_success'));
            }
        }

        LogHelper::system('admin', $request->path(), $request->method(), $id, $this->adminData->username, 0, __('admin.form.message.delete_error'));
        return redirect(langRoute("admin.{$this->uri}.index"))->withErrors([__('admin.form.message.delete_error')]);
    }

    /**
     * Grid data return for DataTables
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function ajaxDataTable(Request $request)
    {
        $this->checkPermissionShow('ajax');

        $queryBuilder = $this->getQueryBuilder();

        $datatables = \DataTables::of($queryBuilder);

        $datatables = $this->doDatatableFilter($datatables, $request);

        $datatables = $this->setDatatablesTransformer($datatables);

        return $datatables->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxSwitch(Request $request)
    {
        $this->checkPermissionEdit('ajax');

        $inputSet = $request->input();

        $validator = validator($inputSet, [
            'id' => 'required',
            'column' => 'required',
            'oriValue' => 'required|in:0,1',
            'switchTo' => 'required|in:0,1',
        ]);

        if (!$validator->fails() && $model = $this->modelRepository->find($inputSet['id'])) {
            if ($this->modelRepository->save($model, [$inputSet['column'] => $inputSet['switchTo']])) {
                LogHelper::system('admin', $request->path(), $request->method(), $inputSet['id'], $this->adminData->username, 1, __('admin.form.message.edit_success'));
                return response([
                    'msg' => 'success',
                    'oriClass' => 'badge-' . systemParam("{$inputSet['column']}.{$inputSet['oriValue']}.class"),
                    'newLabel' => systemParam("{$inputSet['column']}.{$inputSet['switchTo']}.title"),
                    'newClass' => 'badge-' . systemParam("{$inputSet['column']}.{$inputSet['switchTo']}.class"),
                ], 200, ['Content-Type' => 'application/json']);
            }
        }

        LogHelper::system('admin', $request->path(), $request->method(), $inputSet['id'], $this->adminData->username, 0, __('admin.form.message.edit_error'));
        return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxSort(Request $request)
    {
        $this->checkPermissionEdit('ajax');

        $inputSet = $request->input();

        $validator = validator($inputSet, [
            'id' => 'required',
            'column' => 'required',
            'index' => 'required|integer',
        ]);

        if (!$validator->fails() && $model = $this->modelRepository->find($inputSet['id'])) {
            if ($this->modelRepository->save($model, [$inputSet['column'] => $inputSet['index']])) {
                LogHelper::system('admin', $request->path(), $request->method(), $inputSet['id'], $this->adminData->username, 1, __('admin.form.message.edit_success'));
                return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
            }
        }

        LogHelper::system('admin', $request->path(), $request->method(), $inputSet['id'], $this->adminData->username, 0, __('admin.form.message.edit_error'));
        return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
    }
}
