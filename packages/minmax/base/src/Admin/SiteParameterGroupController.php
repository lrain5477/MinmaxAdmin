<?php

namespace Minmax\Base\Admin;

class SiteParameterGroupController extends Controller
{
    protected $packagePrefix = 'MinmaxBase::';

    public function __construct(SiteParameterGroupRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * Set datatable filter.
     *
     * @param  mixed $datatables
     * @param  \Illuminate\Http\Request $request
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

                        if ($column == 'title') {
                            try {
                                $filterTitle = collect(cache('langMap.' . app()->getLocale(), []))
                                    ->filter(function ($item, $key) use ($value) {
                                        return preg_match('/^site_parameter_group\.title\./', $key) > 0 && strpos($item, $value) !== false;
                                    })
                                    ->keys()
                                    ->implode(',');
                            } catch (\Exception $e) {
                                $filterTitle = '';
                            }
                            $whereQuery .= ($whereQuery === '' ? '' : ' or ') . "{$column} in (?)";
                            $whereValue[] = $filterTitle;
                            continue;
                        }

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
}
