<?php

namespace App\Http\Controllers\Administrator;

use App\Helpers\LogHelper;
use App\Repositories\Administrator\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Breadcrumbs;
use Route;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $uri;
    protected $viewData;
    protected $adminData;
    protected $pageData;
    protected $modelName;
    protected $modelRepository;

    public function __construct(Repository $modelRepository)
    {
        $this->middleware('auth:administrator');

        $this->middleware(function($request, $next) {
            $this->adminData = Auth::guard('administrator')->user();
            $this->viewData['adminData'] = $this->adminData;

            return $next($request);
        });

        $this->uri = Route::current()->parameter('uri');
        Route::current()->forgetParameter('uri');

        if($this->uri) {
            $this->pageData = $this->getPageData($this->uri);
            $this->viewData['pageData'] = $this->pageData;

            $this->modelRepository = $modelRepository;
            if($this->pageData) {
                $this->modelRepository->setModelClassName($this->pageData->model ?? null);
            } else {
                abort(404);
            }
        }
    }

    protected function getPageData($uri) {
        $menuModel = collect([
            ['uri' => 'admin-menu-class', 'title' => '管理員選單類別', 'model' => 'AdminMenuClass', 'parent' => 'menu-control'],
            ['uri' => 'admin-menu-item', 'title' => '管理員選單目錄', 'model' => 'AdminMenuItem', 'parent' => 'menu-control'],
            ['uri' => 'merchant-menu-class', 'title' => '經銷商選單類別', 'model' => 'MerchantMenuClass', 'parent' => 'menu-control'],
            ['uri' => 'merchant-menu-item', 'title' => '經銷商選單目錄', 'model' => 'MerchantMenuItem', 'parent' => 'menu-control'],
            ['uri' => 'language', 'title' => '語系管理', 'model' => 'Language', 'parent' => '0'],
            ['uri' => 'permission', 'title' => '權限物件管理', 'model' => 'Permission', 'parent' => 'permission-control'],
            ['uri' => 'role', 'title' => '權限角色管理', 'model' => 'Role', 'parent' => 'permission-control'],
            ['uri' => 'language', 'title' => '語系管理', 'model' => 'Language', 'parent' => '0'],
            ['uri' => 'web-data', 'title' => '網站基本資訊', 'model' => 'WebData', 'parent' => '0'],
            ['uri' => 'system-log', 'title' => '操作紀錄', 'model' => 'SystemLog', 'parent' => '0'],
        ])->map(function($item, $key) { return (object) $item; });

        return $menuModel->where('uri', $uri)->first();
    }

    /**
     * DataGrid List
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function index()
    {
        if(get_class($this) !== (__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller') && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->index();
        }

        // 設定麵包屑導航
        Breadcrumbs::register('index', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
            $breadcrumbs->push($this->pageData->title, route('administrator.index', [$this->uri]));
        });

        try {
            return view('administrator.' . $this->uri . '.index', $this->viewData);
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->view($id);
        }

        $this->viewData['formData'] = $this->modelRepository->one([$this->modelRepository->getIndexKey() => $id]);

        // 設定麵包屑導航
        Breadcrumbs::register('view', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
            $breadcrumbs->push($this->pageData->title, route('administrator.index', [$this->uri]));
            $breadcrumbs->push(__('administrator.form.view'));
        });

        try {
            return view('administrator.' . $this->uri . '.view', $this->viewData);
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->create();
        }

        $this->viewData['formData'] = $this->modelRepository->new();

        // 設定麵包屑導航
        Breadcrumbs::register('create', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
            $breadcrumbs->push($this->pageData->title, route('administrator.index', [$this->uri]));
            $breadcrumbs->push(__('administrator.form.create'));
        });

        try {
            return view('administrator.' . $this->uri . '.create', $this->viewData);
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->store($request);
        }

        $validator = Validator::make($request->input($this->pageData->model), $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            $formDataKey = $this->modelRepository->getIndexKey();
            $makeId = $formDataKey === 'id' ? [] : [$formDataKey => Str::uuid()];

            if($modelData = $this->modelRepository->create($request->input($this->pageData->model) + $makeId)) {
                return redirect()->route('administrator.edit', [$this->uri, $modelData->$formDataKey])->with('success', __('administrator.form.message.edit_success'));
            }

            return redirect()->route('administrator.create', [$this->uri])->withErrors([__('administrator.form.message.create_error')])->withInput();
        }

        return redirect()->route('administrator.create', [$this->uri])->withErrors($validator)->withInput();
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->edit($id);
        }

        $this->viewData['formDataId'] = $id;
        $this->viewData['formData'] = $this->modelRepository->one([$this->modelRepository->getIndexKey() => $id]);

        // 設定麵包屑導航
        Breadcrumbs::register('edit', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
            $breadcrumbs->push($this->pageData->title, route('administrator.index', [$this->uri]));
            $breadcrumbs->push(__('administrator.form.edit'));
        });

        try {
            return view('administrator.' . $this->uri . '.edit', $this->viewData);
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->update($id, $request);
        }

        $validator = Validator::make($request->input($this->pageData->model), $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            if($this->modelRepository->save($request->input($this->pageData->model), [$this->modelRepository->getIndexKey() => $id])) {
                return redirect()->route('administrator.edit', [$this->uri, $id])->with('success', __('administrator.form.message.edit_success'));
            }

            return redirect()->route('administrator.edit', [$this->uri, $id])->withErrors([__('administrator.form.message.edit_error')])->withInput();
        }

        return redirect()->route('administrator.edit', [$this->uri, $id])->withErrors($validator)->withInput();
    }

    /**
     * Model Update
     *
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->destroy($id);
        }

        if($this->modelRepository->delete([$this->modelRepository->getIndexKey() => $id]))
            return redirect()->route('administrator.index', [$this->uri])->with('success', __('administrator.form.message.delete_success'));

        return redirect()->route('administrator.index', [$this->uri])->withErrors([__('administrator.form.message.delete_error')]);
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->ajaxDataTable($request);
        }

        $datatables = \DataTables::of($this->modelRepository->query());

        if($request->has('filter') || $request->has('equal')) {
            $datatables->filter(function($query) use ($request) {
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
                }
                if($request->has('equal')) {
                    foreach($request->input('equal') as $column => $value) {
                        if(is_null($value) || $value === '') continue;
                        if($whereQuery === '') {
                            $whereQuery .= "{$column} = ?";
                        } else {
                            $whereQuery .= " or {$column} = ?";
                        }
                        $whereValue[] = "{$value}";
                    }
                }

                if($whereQuery !== '' && count($whereValue) > 0)
                    $query->whereRaw("{$whereQuery}", $whereValue);
            });
        }

        return $datatables
            ->setTransformer(app()->make('App\\Transformers\\Administrator\\' . $this->pageData->model . 'Transformer'))
            ->make(true);
    }

    public function ajaxSwitch(Request $request)
    {
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->ajaxSwitch($request);
        }

        $validateResult = $request->validate([
            'id' => 'required',
            'column' => 'required',
            'switchTo' => 'required|in:0,1',
        ]);

        if($this->modelRepository->save([$request->input('column') => $request->input('switchTo')], [[$this->modelRepository->getIndexKey(), '=', $request->input('id')]])) {
            //LogHelper::systemLog(Auth::guard('administrator')->user()->username, 'Update ' . $this->modelName . '(' . $request->input('id') . ') ' . $request->input('column') . ' to ' . $request->input('switchTo'), 'Success');

            return response([
                'msg' => 'success',
                'newLabel' => __("models.{$this->pageData->model}.selection.{$request->input('column')}.{$request->input('switchTo')}"),
            ], 200)->header('Content-Type', 'application/json');
        } else {
            //LogHelper::systemLog(Auth::guard('administrator')->user()->username, 'Update ' . $this->modelName . '(' . $request->input('id') . ') ' . $request->input('column') . ' to ' . $request->input('switchTo'), 'Failed');

            return response(['msg' => 'error'], 400)->header('Content-Type', 'application/json');
        }
    }

    public function ajaxMultiSwitch(Request $request)
    {
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->ajaxMultiSwitch($request);
        }

        $validateResult = $request->validate([
            'data' => 'required',
        ]);

        $input = json_decode(urldecode($request->input('data')));
        $inputData = [];
        foreach ($input as $value) {
            $inputData[$value->name] = ($value->name == 'selID') ? explode(',', substr($value->value, 0, -1)) : $value->value;
        }

        if($this->modelRepository->update(['active' => $inputData['active']], function($query) use ($inputData) { $query->whereIn($this->modelRepository->getIndexKey(), $inputData['selID']); })) {
            //LogHelper::systemLog(Auth::guard('administrator')->user()->username, 'Update ' . $this->modelName . '(' . implode(',', $inputData['selID']) . ') chk to ' . $inputData['chk'], 'Success');

            return response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
        } else {
            //LogHelper::systemLog(Auth::guard('administrator')->user()->username, 'Update ' . $this->modelName . '(' . implode(',', $inputData['selID']) . ') chk to ' . $inputData['chk'], 'Failed');

            return response(['msg' => 'error'], 400)->header('Content-Type', 'application/json');
        }
    }

    public function ajaxSort(Request $request)
    {
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->ajaxSort($request);
        }

        $validateResult = $request->validate([
            'id' => 'required',
            'column' => 'required',
            'index' => 'required|integer',
        ]);

        if($this->modelRepository->save([$request->input('column') => $request->input('index')], [[$this->modelRepository->getIndexKey(), '=', $request->input('id')]])) {
            //LogHelper::systemLog(Auth::guard('administrator')->user()->username, 'Update ' . $this->modelName . '(' . $request->input('id') . ') sorting to ' . $request->input('index'), 'Success');

            return response([
                'msg' => 'success',
            ], 200)->header('Content-Type', 'application/json');
        } else {
            return response(['msg' => 'error'], 400)->header('Content-Type', 'application/json');
        }
    }
}
