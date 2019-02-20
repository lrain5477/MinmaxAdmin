<?php

namespace Minmax\Ad\Admin;

use Illuminate\Support\Facades\DB;
use Minmax\Base\Admin\Controller;

/**
 * Class AdvertisingController
 */
class AdvertisingController extends Controller
{
    protected $packagePrefix = 'MinmaxAd::';

    public function __construct(AdvertisingRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->modelRepository->query()->with(['advertisingCategory']);
    }

    /**
     * Set datatable filter.
     *
     * @param  mixed $datatable
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
                                        return preg_match('/^advertising\.title\./', $key) > 0 && strpos($item, $value) !== false;
                                    })
                                    ->keys()
                                    ->toArray();
                                $query->orWhereIn($column, $filterTitle);
                            } catch (\Exception $e) {}
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

        $trackSet = DB::table('advertising_track')
            ->select(['advertising_id', DB::raw('count(*) as `num`')])
            ->groupBy('advertising_id')
            ->orderBy('num')
            ->pluck('advertising_id')
            ->implode(',');
        $datatable->orderColumn('count', "field(id,'{$trackSet}') $1");

        return $datatable;
    }
}
