<?php

namespace App\Http\Controllers\Administrator;

use App\Models\AdminMenuItem;
use Breadcrumbs;
use Illuminate\Http\Request;

class AdminMenuItemController extends Controller
{
    /**
     * Administrator AdminMenuItem DataGrid List.
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function index()
    {
        $this->viewData['menuParent'] = request()->has('parent') ? request('parent') : '0';
        $this->viewData['menuParentBack'] = request()->has('parent') ? AdminMenuItem::where(['guid' => request('parent'), 'lang' => app()->getLocale()])->first()->parent : '0';

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
     * Administrator AdminMenuItem Grid data return for DataTables
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function ajaxDataTable(Request $request)
    {
        $parent = $request->has('parent') ? $request->input('parent') : 0;

        $datatables = \DataTables::of($this->modelRepository->query(['parent' => $parent, 'lang' => app()->getLocale()]));

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
}
