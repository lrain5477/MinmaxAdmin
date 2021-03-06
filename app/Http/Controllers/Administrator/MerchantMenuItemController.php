<?php

namespace App\Http\Controllers\Administrator;

use App\Models\MerchantMenuItem;
use Breadcrumbs;
use Illuminate\Http\Request;

class MerchantMenuItemController extends Controller
{
    /**
     * Administrator MerchantMenuItem DataGrid List.
     *
     * @return \Illuminate\Http\Response
     * @throws \DaveJamesMiller\Breadcrumbs\Exceptions\DuplicateBreadcrumbException
     */
    public function index()
    {
        $this->viewData['menuParent'] = request()->has('parent') ? request('parent') : '0';
        $this->viewData['menuParentBack'] = request()->has('parent') ? MerchantMenuItem::where('guid', request('parent'))->first()->parent : '0';

        // 設定麵包屑導航
        Breadcrumbs::register('index', function ($breadcrumbs) {
            /**
             * @var \DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator $breadcrumbs
             */
            $breadcrumbs->parent('home');
            $breadcrumbs->push($this->pageData->title, route('index', [$this->uri]));
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

        $datatables = \DataTables::of($this->modelRepository->query()->where(['parent' => $parent]));

        if($request->has('filter')) {
            $datatables->filter(function($query) use ($request) {
                $whereQuery = '';
                $whereValue = [];
                foreach($request->input('filter') as $column => $value) {
                    if(is_null($value) || $value === '') continue;
                    if($whereQuery === '') {
                        $whereQuery .= "{$column} like ?";
                    } else {
                        $whereQuery .= " or {$column} like ?";
                    }
                    $whereValue[] = "%{$value}%";
                }

                if($whereQuery !== '' && count($whereValue) > 0)
                    $query->whereRaw("{$whereQuery}", $whereValue);
            });
        }

        return $datatables
            ->setTransformer(app()->make('App\\Transformers\\Administrator\\' . $this->pageData->model . 'Transformer'))
            ->make(true);
    }
}
