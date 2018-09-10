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
use Illuminate\Support\Str;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Breadcrumbs;
use Validator;

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

    public function test()
    {
        dd($this->uri);
    }

    protected function setViewData()
    {
        $this->viewData['languageData'] = $this->languageData;
        $this->viewData['webData'] = $this->webData;
        $this->viewData['systemMenu'] = $this->systemMenu;
        $this->viewData['pageData'] = $this->pageData;
        $this->viewData['adminData'] = $this->adminData;
        $this->viewData['rootUri'] = $this->rootUri . '/' . ($this->languageData->count() > 1 ? app()->getLocale() : '');
    }

    /**
     * DataGrid List
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function index()
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === false) return abort(404);

        // 設定麵包屑導航
        Breadcrumbs::register('index', function ($breadcrumbs) {
            /** @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs */
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push($this->pageData->title, route('admin.index', [$this->uri]));
        });

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
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === false) return abort(404);

        $where = [$this->modelRepository->getIndexKey() => $id];
        if($this->modelRepository->isMultiLanguage()) $where['lang'] = app()->getLocale();

        $this->viewData['formData'] = $this->modelRepository->one($where);

        // 設定麵包屑導航
        Breadcrumbs::register('view', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push($this->pageData->title, route('admin.index', [$this->uri]));
            $breadcrumbs->push(__('admin.form.view'));
        });

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
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Create')) === false) return abort(404);

        $this->viewData['formData'] = $this->modelRepository->new();

        // 設定麵包屑導航
        Breadcrumbs::register('create', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push(
                $this->pageData->title,
                $this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === true
                    ? route('admin.index', [$this->uri])
                    : null
            );
            $breadcrumbs->push(__('admin.form.create'));
        });

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
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Create')) === false) return abort(404);

        $inputSet = $request->input($this->pageData->getAttribute('model'));

        $validator = Validator::make($inputSet, $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            $formDataKey = $this->modelRepository->getIndexKey();
            if($formDataKey !== 'id') $inputSet[$formDataKey] = Str::uuid();

            foreach($inputSet['uploads'] ?? [] as $columnKey => $columnInput) {
                $inputSet[$columnKey] = $columnInput['origin'] ?? null;
                $filePath = 'files/' . ($columnInput['path'] ?? 'uploads');
                $fileList = [];
                foreach($request->file($this->pageData->getAttribute('model') . '.uploads.' . $columnKey . '.file') ?? [] as $fileItem) {
                    /** @var \Illuminate\Http\UploadedFile $fileItem */
                    if($fileItem) {
                        $fileName = microtime() . rand(100000, 999999) . '.' . $fileItem->getClientOriginalExtension();
                        $fileItem->move(public_path($filePath), $fileName);
                        $fileList[] = $filePath . '/' . $fileName;
                    }
                }
                $inputSet[$columnKey] = count($fileList) > 0 ? implode(config('app.separate_string'), $fileList) : $inputSet[$columnKey];
            }
            if(isset($inputSet['uploads'])) unset($inputSet['uploads']);

            if($modelData = $this->modelRepository->create($inputSet)) {
                LogHelper::system('admin', $this->uri, 'store', $modelData->$formDataKey, $this->adminData->username, 1, __('admin.form.message.create_success'));

                // 多語系複製
                if($this->modelRepository->isMultiLanguage()) {
                    foreach ($this->languageData as $language) {
                        if($language->codes === app()->getLocale()) continue;
                        $copyInsert = $modelData->replicate();
                        $copyInsert->lang = $language->codes;
                        $copyInsert->save();
                    }
                }

                return redirect()->route('admin.edit', [$this->uri, $modelData->$formDataKey])->with('success', __('admin.form.message.create_success'));
            }

            LogHelper::system('admin', $this->uri, 'store', '', $this->adminData->username, 0, __('admin.form.message.create_error'));
            return redirect()->route('admin.create', [$this->uri])->withErrors([__('admin.form.message.create_error')])->withInput();
        }

        LogHelper::system('admin', $this->uri, 'store', '', $this->adminData->username, 0, $validator->errors()->first());
        return redirect()->route('admin.create', [$this->uri])->withErrors($validator)->withInput();
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
        dd($id);

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(404);

        $where = [$this->modelRepository->getIndexKey() => $id];
        if($this->modelRepository->isMultiLanguage()) $where['lang'] = app()->getLocale();

        $this->viewData['formDataId'] = $id;
        $this->viewData['formData'] = $this->modelRepository->one($where);

        // 設定麵包屑導航
        Breadcrumbs::register('edit', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('admin.home');
            $breadcrumbs->push(
                $this->pageData->title,
                $this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === true
                    ? route('admin.index', [$this->uri])
                    : null
            );
            $breadcrumbs->push(__('admin.form.edit'));
        });

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
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(404);

        $inputSet = $request->input($this->pageData->getAttribute('model'));

        $validator = Validator::make($inputSet, $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            $where = [$this->modelRepository->getIndexKey() => $id];
            if($this->modelRepository->isMultiLanguage()) $where['lang'] = app()->getLocale();

            foreach($inputSet['uploads'] ?? [] as $columnKey => $columnInput) {
                $inputSet[$columnKey] = $columnInput['origin'] ?? null;
                $filePath = 'files/' . ($columnInput['path'] ?? 'uploads');
                $fileList = [];
                foreach($request->file($this->pageData->getAttribute('model') . '.uploads.' . $columnKey . '.file') ?? [] as $fileItem) {
                    /** @var \Illuminate\Http\UploadedFile $fileItem */
                    if($fileItem) {
                        $fileName = microtime() . rand(100000, 999999) . '.' . $fileItem->getClientOriginalExtension();
                        $fileItem->move(public_path($filePath), $fileName);
                        $fileList[] = $filePath . '/' . $fileName;
                    }
                }
                $inputSet[$columnKey] = count($fileList) > 0 ? implode(config('app.separate_string'), $fileList) : $inputSet[$columnKey];
            }
            if(isset($inputSet['uploads'])) unset($inputSet['uploads']);

            if($this->modelRepository->save($inputSet, $where)) {
                LogHelper::system('admin', $this->uri, 'update', $id, $this->adminData->username, 1, __('admin.form.message.edit_success'));
                return redirect()->route('admin.edit', [$this->uri, $id])->with('success', __('admin.form.message.edit_success'));
            }

            LogHelper::system('admin', $this->uri, 'update', $id, $this->adminData->username, 0, __('admin.form.message.edit_error'));
            return redirect()->route('admin.edit', [$this->uri, $id])->withErrors([__('admin.form.message.edit_error')])->withInput();
        }

        LogHelper::system('admin', $this->uri, 'update', $id, $this->adminData->username, 0, $validator->errors()->first());
        return redirect()->route('admin.edit', [$this->uri, $id])->withErrors($validator)->withInput();
    }

    /**
     * Model Destroy
     *
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Destroy')) === false) return abort(404);

        if($this->modelRepository->delete([$this->modelRepository->getIndexKey() => $id])) {
            LogHelper::system('admin', $this->uri, 'destroy', $id, $this->adminData->username, 1, __('admin.form.message.delete_success'));
            return redirect()->route('admin.index', [$this->uri])->with('success', __('admin.form.message.delete_success'));
        }

        LogHelper::system('admin', $this->uri, 'destroy', $id, $this->adminData->username, 0, __('admin.form.message.delete_error'));
        return redirect()->route('admin.index', [$this->uri])->withErrors([__('admin.form.message.delete_error')]);
    }

    /**
     * Grid data return for DataTables
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function ajaxDataTable(Request $request)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === false) return abort(403);

        $where = [];
        if($this->modelRepository->isMultiLanguage()) $where['lang'] = app()->getLocale();

        $datatables = \DataTables::of($this->modelRepository->query($where));

        if($request->has('filter') || $request->has('equal')) {
            $datatables->filter(function($query) use ($request) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $whereQuery = '';
                $whereValue = [];
                if($request->has('filter')) {
                    foreach ($request->input('filter') as $column => $value) {
                        if (is_null($value) || $value === '') continue;
                        if ($whereQuery === '') {
                            $whereQuery .= "{$column} like ?";
                        } else {
                            $whereQuery .= " or {$column} like ?";
                        }
                        $whereValue[] = "%{$value}%";
                    }
                    if($whereQuery !== '') $whereQuery = "({$whereQuery})";
                }
                if($request->has('equal')) {
                    foreach($request->input('equal') as $column => $value) {
                        if(is_null($value) || $value === '') continue;
                        if($whereQuery === '') {
                            $whereQuery .= "{$column} = ?";
                        } else {
                            $whereQuery .= " and {$column} = ?";
                        }
                        $whereValue[] = "{$value}";
                    }
                }

                if($whereQuery !== '' && count($whereValue) > 0)
                    $query->whereRaw("{$whereQuery}", $whereValue);
            });
        }

        return $datatables
            ->setTransformer(app()->make('App\\Transformers\\Admin\\' . $this->pageData->getAttribute('model') . 'Transformer', ['uri' => $this->uri]))
            ->make(true);
    }

    public function ajaxSwitch(Request $request)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(403);

        $validateResult = $request->validate([
            'id' => 'required',
            'column' => 'required',
            'oriValue' => 'required|in:0,1',
            'switchTo' => 'required|in:0,1',
        ]);

        $where = [
            $this->modelRepository->getIndexKey() => $request->input('id')
        ];

        if($this->modelRepository->update([$request->input('column') => $request->input('switchTo')], $where)) {
            LogHelper::system('admin', $this->uri, 'update', $request->input('id'), $this->adminData->username, 1, __('admin.form.message.edit_success'));

            return response([
                'msg' => 'success',
                'oriClass' => 'badge-' . ($this->parameterData[$request->input('column')][$request->input('oriValue')]['class']
                    ?? ($request->input('oriValue') == 1 ? 'danger' : 'secondary')),
                'newLabel' => $this->parameterData[$request->input('column')][$request->input('switchTo')]['title']
                    ?? __("models.{$this->pageData->getAttribute('model')}.selection.{$request->input('column')}.{$request->input('switchTo')}"),
                'newClass' => 'badge-' . ($this->parameterData[$request->input('column')][$request->input('switchTo')]['class']
                    ?? ($request->input('switchTo') == 1 ? 'danger' : 'secondary')),
            ], 200, ['Content-Type' => 'application/json']);
        } else {
            LogHelper::system('admin', $this->uri, 'update', $request->input('id'), $this->adminData->username, 0, __('admin.form.message.edit_error'));

            return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
        }
    }

    public function ajaxMultiSwitch(Request $request)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(403);

        $validateResult = $request->validate([
            'data' => 'required',
        ]);

        $input = json_decode(urldecode($request->input('data')));
        $inputData = [];
        foreach ($input as $value) {
            $inputData[$value->name] = ($value->name == 'selID') ? explode(',', substr($value->value, 0, -1)) : $value->value;
        }

        if($this->modelRepository->update(['active' => $inputData['active']], function($query) use ($inputData) { /** @var \Illuminate\Database\Query\Builder $query */ $query->whereIn($this->modelRepository->getIndexKey(), $inputData['selID']); })) {
            LogHelper::system('admin', $this->uri, 'update', implode(',', $inputData['selID']), $this->adminData->username, 1, __('admin.form.message.edit_success'));

            return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
        } else {
            LogHelper::system('admin', $this->uri, 'update', implode(',', $inputData['selID']), $this->adminData->username, 0, __('admin.form.message.edit_error'));

            return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
        }
    }

    public function ajaxSort(Request $request)
    {
        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(403);

        $validateResult = $request->validate([
            'id' => 'required',
            'column' => 'required',
            'index' => 'required|integer',
        ]);

        if($this->modelRepository->save([$request->input('column') => $request->input('index')], [[$this->modelRepository->getIndexKey(), '=', $request->input('id')]])) {
            LogHelper::system('admin', $this->uri, 'update', $request->input('id'), $this->adminData->username, 1, __('admin.form.message.edit_success'));

            return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
        } else {
            return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
        }
    }
}
