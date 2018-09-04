<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Administrator;
use App\Models\AdministratorMenu;
use App\Models\WorldLanguage;
use App\Models\ParameterGroup;
use App\Models\WebData;
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

/**
 * Class Controller
 * @property \App\Models\Administrator $adminData
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string $uri
     * @var array $viewData
     * @var Administrator $adminData
     * @var WorldLanguage $languageData
     * @var array $parameterData
     * @var AdministratorMenu $pageData
     * @var string $modelName
     * @var Repository $modelRepository
     */
    protected $uri;
    protected $viewData;
    protected $adminData;
    protected $languageData;
    protected $parameterData;
    protected $menuData;
    protected $pageData;
    protected $modelName;
    protected $modelRepository;

    public function __construct(Repository $modelRepository)
    {
        $this->modelRepository = $modelRepository;

        $this->middleware(function($request, $next) {
            /**
             * @var \Illuminate\Http\Request $request
             */

            // 取得 語系資料
            $this->languageData = WorldLanguage::all();
            $this->viewData['languageData'] = $this->languageData->where('active', '1');

            // 設定 語系
            if($request->has('language') && $this->languageData->where('codes', $request->get('language'))->where('active', '1')->count() > 0) {
                session(['administratorLanguage' => $request->get('language')]);
                session()->save();
            }
            if(session()->has('administratorLanguage') && !is_null(session('administratorLanguage'))) {
                app()->setLocale(session('administratorLanguage'));
            }

            // 設定 URI
            if($request->route()->hasParameter('uri')) {
                $this->uri = $request->route()->parameter('uri');
                Route::current()->forgetParameter('uri');
            } else {
                $this->uri = explode('/', $request->route()->uri())[1] ?? $this->uri;
            }

            // 設定 系統參數
            $this->parameterData = ParameterGroup::where(['active' => 1])
                ->get(['guid', 'code'])
                ->mapWithKeys(function($item) {
                    /** @var ParameterGroup $item */
                    return [
                        $item->code => $item
                            ->parameterItem()
                            ->get(['guid', 'title', 'value', 'class'])
                            ->mapWithKeys(function($item) {
                                /** @var \App\Models\ParameterItem $item */
                                return [
                                    $item->value => [
                                        'title' => $item->getAttribute('title'),
                                        'class' => $item->getAttribute('class')
                                    ]
                                ];
                            })
                            ->toArray()
                    ];
                })->toArray();
            $this->viewData['parameterData'] = $this->parameterData;

            // 設定 網站資料
            $this->viewData['webData'] = WebData::where(['lang' => app()->getLocale(), 'website_key' => 'administrator'])->first();

            // 設定 選單資料
            $this->menuData = AdministratorMenu::where(['parent' => '0'])->orderBy('sort')->get()->sortBy('class');
            $this->viewData['menuData'] = $this->menuData;

            // 設定 頁面資料
            if($this->uri) {
                $this->pageData = AdministratorMenu::where(['uri' => $this->uri])->first();
                $this->viewData['pageData'] = $this->pageData;
            }

            // 設定 帳號資料
            $this->adminData = Auth::guard('administrator')->user();
            $this->viewData['adminData'] = $this->adminData;

            // 設定 模型注入
            if($this->pageData) {
                $this->modelRepository->setModelClassName($this->pageData->getAttribute('model') ?? null);
            } elseif($request->route()->uri() !== 'administrator') {
                abort(404);
            }

            return $next($request);
        });
    }

    /**
     * DataGrid List
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function index()
    {
        // 設定麵包屑導航
        Breadcrumbs::register('index', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('administrator.home');
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
        $where = [$this->modelRepository->getIndexKey() => $id];
        if($this->modelRepository->isMultiLanguage()) $where['lang'] = app()->getLocale();

        $this->viewData['formData'] = $this->modelRepository->one($where);

        // 設定麵包屑導航
        Breadcrumbs::register('view', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('administrator.home');
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
        $this->viewData['formData'] = $this->modelRepository->new();

        // 設定麵包屑導航
        Breadcrumbs::register('create', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('administrator.home');
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
        $inputSet = $request->input($this->pageData->getAttribute('model'));

        $validator = Validator::make($inputSet, $this->modelRepository->getRules() ?? []);

        if($validator->passes()) {
            $formDataKey = $this->modelRepository->getIndexKey();
            if($formDataKey !== 'id') $input[$formDataKey] = Str::uuid();

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
                // 多語系複製
                if($this->modelRepository->isMultiLanguage()) {
                    foreach ($this->languageData as $language) {
                        if($language->codes === app()->getLocale()) continue;
                        $copyInsert = $modelData->replicate();
                        $copyInsert->lang = $language->codes;
                        $copyInsert->save();
                    }
                }

                return redirect()->route('administrator.edit', [$this->uri, $modelData->$formDataKey])->with('success', __('administrator.form.message.create_success'));
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
        $where = [$this->modelRepository->getIndexKey() => $id];
        if($this->modelRepository->isMultiLanguage()) $where['lang'] = app()->getLocale();

        $this->viewData['formDataId'] = $id;
        $this->viewData['formData'] = $this->modelRepository->one($where);

        // 設定麵包屑導航
        Breadcrumbs::register('edit', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('administrator.home');
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
        $inputSet = $request->input($this->pageData->getAttribute('model'));

        $validator = Validator::make($request->input($this->pageData->getAttribute('model')), $this->modelRepository->getRules() ?? []);

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
                return redirect()->route('administrator.edit', [$this->uri, $id])->with('success', __('administrator.form.message.edit_success'));
            }

            return redirect()->route('administrator.edit', [$this->uri, $id])->withErrors([__('administrator.form.message.edit_error')])->withInput();
        }

        return redirect()->route('administrator.edit', [$this->uri, $id])->withErrors($validator)->withInput();
    }

    /**
     * Model Destroy
     *
     * @param string $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
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
            ->setTransformer(app()->make('App\\Transformers\\Administrator\\' . $this->pageData->getAttribute('model') . 'Transformer', ['uri' => $this->uri]))
            ->make(true);
    }

    public function ajaxSwitch(Request $request)
    {
        $validateResult = $request->validate([
            'id' => 'required',
            'column' => 'required',
            'oriValue' => 'required|in:0,1',
            'switchTo' => 'required|in:0,1',
        ]);

        if($this->modelRepository->save([$request->input('column') => $request->input('switchTo')], [[$this->modelRepository->getIndexKey(), '=', $request->input('id')]])) {
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
            return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
        }
    }

    public function ajaxMultiSwitch(Request $request)
    {
        $validateResult = $request->validate([
            'data' => 'required',
        ]);

        $input = json_decode(urldecode($request->input('data')));
        $inputData = [];
        foreach ($input as $value) {
            $inputData[$value->name] = ($value->name == 'selID') ? explode(',', substr($value->value, 0, -1)) : $value->value;
        }

        if($this->modelRepository->update(['active' => $inputData['active']], function($query) use ($inputData) { /** @var \Illuminate\Database\Query\Builder $query */ $query->whereIn($this->modelRepository->getIndexKey(), $inputData['selID']); })) {
            return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
        } else {
            return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
        }
    }

    public function ajaxSort(Request $request)
    {
        $validateResult = $request->validate([
            'id' => 'required',
            'column' => 'required',
            'index' => 'required|integer',
        ]);

        if($this->modelRepository->save([$request->input('column') => $request->input('index')], [[$this->modelRepository->getIndexKey(), '=', $request->input('id')]])) {
            return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
        } else {
            return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
        }
    }
}
