<?php

namespace Minmax\Base\Admin;

use Illuminate\Support\Facades\DB;

/**
 * Class SiteParameterGroupController
 */
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
     * @param  \Yajra\DataTables\EloquentDataTable $datatable
     * @param  \Illuminate\Http\Request $request
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
                                $filterTitle = collect(cache('langMap.' . app()->getLocale(), []))
                                    ->filter(function ($item, $key) use ($value) {
                                        return preg_match('/^site_parameter_group\.title\./', $key) > 0 && strpos($item, $value) !== false;
                                    })
                                    ->keys()
                                    ->toArray();
                                $query->orWhereIn($column, $filterTitle);
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

        $titleLanguageSet = collect(langDBSet('site_parameter_group.title.'))->sort()->keys()->implode("','");
        $datatable->orderColumn('title', "field(title,'{$titleLanguageSet}') $1");

        return $datatable;
    }
}
