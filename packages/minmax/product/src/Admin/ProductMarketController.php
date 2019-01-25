<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class ProductMarketController
 */
class ProductMarketController extends Controller
{
    protected $packagePrefix = 'MinmaxProduct::';

    public function __construct(ProductMarketRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
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
                                        return preg_match('/^product_market\.title\./', $key) > 0 && strpos($item, $value) !== false;
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

        return $datatable;
    }
}
