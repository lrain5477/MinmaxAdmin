<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class ProductItemController
 */
class ProductItemController extends Controller
{
    protected $packagePrefix = 'MinmaxProduct::';

    public function __construct(ProductItemRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQueryBuilder()
    {
        return $this->modelRepository->query()->with(['productQuantities', 'productPackages']);
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
            /** @var \Illuminate\Database\Eloquent\Builder $query */

            if($request->has('filter')) {
                $query->where(function ($query) use ($request) {
                    /** @var \Illuminate\Database\Eloquent\Builder $query */

                    foreach ($request->input('filter', []) as $column => $value) {
                        if (empty($column) || is_null($value) || $value === '') continue;

                        if ($column == 'title') {
                            try {
                                $filterTitle = collect(cache('langMap.' . app()->getLocale(), []))
                                    ->filter(function ($item, $key) use ($value) {
                                        return preg_match('/^product_item\.title\./', $key) > 0 && strpos($item, $value) !== false;
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

                    if ($column == 'status_tag') {
                        switch ($value) {
                            case 'qty_safety':
                                $query
                                    ->leftJoin('product_quantity', function ($join) {
                                        /** @var \Illuminate\Database\Query\JoinClause $join */
                                        $join->on('product_item.id', '=', 'product_quantity.item_id')
                                            ->orderByDesc('product_quantity.id')
                                            ->limit(1);
                                    })
                                    ->where('qty_enable', true)
                                    ->where('qty_safety', '>', 0)
                                    ->whereNotNull('product_quantity.summary')
                                    ->where('product_quantity.summary', '<=', 'product_quantity.summary')
                                    ->where('product_quantity.summary', '>', 0);
                                break;
                            case 'qty_empty':
                                $query
                                    ->leftJoin('product_quantity', function ($join) {
                                        /** @var \Illuminate\Database\Query\JoinClause $join */
                                        $join->on('product_item.id', '=', 'product_quantity.item_id')
                                            ->orderByDesc('product_quantity.id')
                                            ->limit(1);
                                    })
                                    ->where('qty_enable', true)
                                    ->where(function ($query) {
                                        /** @var \Illuminate\Database\Eloquent\Builder $query */
                                        $query
                                            ->where('product_quantity.summary', '<', 1)
                                            ->orWhereNull('product_quantity.summary');
                                    });
                                break;
                            case 'package_empty':
                                $query->whereHas('productPackages', null, '<', 1);
                                break;
                        }
                        continue;
                    }

                    $query->where($column, $value);
                }
            }
        });

        return $datatable;
    }
}
