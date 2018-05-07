<?php

namespace App\Http\Controllers\Admin;

//use App\Helpers\LogHelper;
use App\Helpers\PermissionHelper;
use App\Models\AdminMenuClass;
use App\Models\AdminMenuItem;
use App\Models\WebData;
use App\Repositories\Admin\Repository;
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
        $this->middleware(function($request, $next) {
            $this->adminData = Auth::guard('admin')->user();
            $this->viewData['adminData'] = $this->adminData;

            $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'admin'])->first();
            $this->viewData['menuData'] = $this->getMenuData();

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

    protected function getMenuData() {
        $menuItemData = AdminMenuClass::where(['active' => 1])->orderBy('sort')->get();

        return $menuItemData;
    }

    protected function getPageData($uri) {
        $menuItemData = AdminMenuItem::where(['lang' => app()->getLocale(), 'active' => 1])->get();

        return $menuItemData->where('uri', $uri)->first();
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

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === false) return abort(404);

        // 設定麵包屑導航
        Breadcrumbs::register('index', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->show($id);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === false) return abort(404);

        $this->viewData['formData'] = $this->modelRepository->one([$this->modelRepository->getIndexKey() => $id]);

        // 設定麵包屑導航
        Breadcrumbs::register('view', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->create();
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Create')) === false) return abort(404);

        $this->viewData['formData'] = $this->modelRepository->new();

        // 設定麵包屑導航
        Breadcrumbs::register('create', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
            $breadcrumbs->push($this->pageData->title, route('admin.index', [$this->uri]));
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->store($request);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Create')) === false) return abort(404);

        $validator = Validator::make($request->input($this->pageData->model), $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            $input = $request->input($this->pageData->model);
            $formDataKey = $this->modelRepository->getIndexKey();
            if($formDataKey !== 'id') $input[$formDataKey] = Str::uuid();

            if($modelData = $this->modelRepository->create($input)) {
                return redirect()->route('admin.edit', [$this->uri, $modelData->$formDataKey])->with('success', __('admin.form.message.edit_success'));
            }

            return redirect()->route('admin.create', [$this->uri])->withErrors([__('admini.form.message.create_error')])->withInput();
        }

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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->edit($id);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(404);

        $this->viewData['formDataId'] = $id;
        $this->viewData['formData'] = $this->modelRepository->one([$this->modelRepository->getIndexKey() => $id]);

        // 設定麵包屑導航
        Breadcrumbs::register('edit', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
            $breadcrumbs->push($this->pageData->title, route('admin.index', [$this->uri]));
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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->update($id, $request);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(404);

        $validator = Validator::make($request->input($this->pageData->model), $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            if($this->modelRepository->save($request->input($this->pageData->model), [$this->modelRepository->getIndexKey() => $id])) {
                return redirect()->route('admin.edit', [$this->uri, $id])->with('success', __('admin.form.message.edit_success'));
            }

            return redirect()->route('admin.edit', [$this->uri, $id])->withErrors([__('admin.form.message.edit_error')])->withInput();
        }

        return redirect()->route('admin.edit', [$this->uri, $id])->withErrors($validator)->withInput();
    }

    /**
     * Model Destroy
     *
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->destroy($id);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Destroy')) === false) return abort(404);

        if($this->modelRepository->delete([$this->modelRepository->getIndexKey() => $id]))
            return redirect()->route('admin.index', [$this->uri])->with('success', __('admin.form.message.delete_success'));

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
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->ajaxDataTable($request);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Show')) === false) return abort(403);

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
            ->setTransformer(app()->make('App\\Transformers\\Admin\\' . $this->pageData->model . 'Transformer', ['uri' => $this->uri]))
            ->make(true);
    }

    public function ajaxSwitch(Request $request)
    {
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->ajaxSwitch($request);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(403);

        $validateResult = $request->validate([
            'id' => 'required',
            'column' => 'required',
            'switchTo' => 'required|in:0,1',
        ]);

        if($this->modelRepository->save([$request->input('column') => $request->input('switchTo')], [[$this->modelRepository->getIndexKey(), '=', $request->input('id')]])) {
            //LogHelper::systemLog(Auth::guard('admin')->user()->username, 'Update ' . $this->modelName . '(' . $request->input('id') . ') ' . $request->input('column') . ' to ' . $request->input('switchTo'), 'Success');

            return response([
                'msg' => 'success',
                'newLabel' => __("models.{$this->pageData->model}.selection.{$request->input('column')}.{$request->input('switchTo')}"),
            ], 200)->header('Content-Type', 'application/json');
        } else {
            //LogHelper::systemLog(Auth::guard('admin')->user()->username, 'Update ' . $this->modelName . '(' . $request->input('id') . ') ' . $request->input('column') . ' to ' . $request->input('switchTo'), 'Failed');

            return response(['msg' => 'error'], 400)->header('Content-Type', 'application/json');
        }
    }

    public function ajaxMultiSwitch(Request $request)
    {
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->ajaxMultiSwitch($request);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(403);

        $validateResult = $request->validate([
            'data' => 'required',
        ]);

        $input = json_decode(urldecode($request->input('data')));
        $inputData = [];
        foreach ($input as $value) {
            $inputData[$value->name] = ($value->name == 'selID') ? explode(',', substr($value->value, 0, -1)) : $value->value;
        }

        if($this->modelRepository->update(['active' => $inputData['active']], function($query) use ($inputData) { $query->whereIn($this->modelRepository->getIndexKey(), $inputData['selID']); })) {
            //LogHelper::systemLog(Auth::guard('admin')->user()->username, 'Update ' . $this->modelName . '(' . implode(',', $inputData['selID']) . ') chk to ' . $inputData['chk'], 'Success');

            return response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
        } else {
            //LogHelper::systemLog(Auth::guard('admin')->user()->username, 'Update ' . $this->modelName . '(' . implode(',', $inputData['selID']) . ') chk to ' . $inputData['chk'], 'Failed');

            return response(['msg' => 'error'], 400)->header('Content-Type', 'application/json');
        }
    }

    public function ajaxSort(Request $request)
    {
        if(get_class($this) !== __NAMESPACE__ . '\\' . $this->pageData->model . 'Controller' && class_exists(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')) {
            Route::current()->setParameter('uri', $this->uri);
            return app()->make(__NAMESPACE__ . '\\' . $this->pageData->model . 'Controller')->ajaxSort($request);
        }

        if($this->adminData->can(PermissionHelper::replacePermissionName($this->pageData->permission_key, 'Edit')) === false) return abort(403);

        $validateResult = $request->validate([
            'id' => 'required',
            'column' => 'required',
            'index' => 'required|integer',
        ]);

        if($this->modelRepository->save([$request->input('column') => $request->input('index')], [[$this->modelRepository->getIndexKey(), '=', $request->input('id')]])) {
            //LogHelper::systemLog(Auth::guard('admin')->user()->username, 'Update ' . $this->modelName . '(' . $request->input('id') . ') sorting to ' . $request->input('index'), 'Success');

            return response([
                'msg' => 'success',
            ], 200)->header('Content-Type', 'application/json');
        } else {
            return response(['msg' => 'error'], 400)->header('Content-Type', 'application/json');
        }
    }
}
