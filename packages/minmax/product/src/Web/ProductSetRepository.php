<?php

namespace Minmax\Product\Web;

use Minmax\Base\Web\Repository;
use Minmax\Product\Models\ProductSet;

/**
 * Class ProductSetRepository
 * @property ProductSet $model
 * @method ProductSet find($id)
 * @method ProductSet one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ProductSet create($attributes)
 * @method ProductSet save($model, $attributes)
 * @method ProductSet|\Illuminate\Database\Eloquent\Builder query()
 */
class ProductSetRepository extends Repository
{
    const MODEL = ProductSet::class;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'product_set';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Minmax\Product\Models\ProductSet
     */
    public function getProductSetsBaseQuery()
    {
        $baseQuery = $this->query()
            ->with([
                'productCategories' => function ($query) {
                    /** @var \Illuminate\Database\Eloquent\Builder $query */
                    $query->where('active', true)->orderBy('sort');
                },
                'productPackages' => function ($query) {
                    /** @var \Illuminate\Database\Eloquent\Builder $query */
                    $query
                        ->with(['productMarkets'])
                        ->where('active', true)
                        ->where(function ($query) {
                            /** @var \Illuminate\Database\Eloquent\Builder $query */
                            $query->whereNull('start_at')->orWhere('start_at', '<=', date('Y-m-d H:i:s'));
                        })
                        ->where(function ($query) {
                            /** @var \Illuminate\Database\Eloquent\Builder $query */
                            $query->whereNull('end_at')->orWhere('end_at', '>=', date('Y-m-d H:i:s'));
                        })
                        ->orderBy('sort');
                },
                'productItems.productQuantities' => function ($query) {
                    /** @var \Illuminate\Database\Eloquent\Builder $query */
                    $query->latest('id')->limit(1);
                }
            ])
            ->whereHas('productCategories', function ($query) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where('active', true);
            })
            ->whereHas('productPackages', function ($query) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query
                    ->where('active', true)
                    ->where(function ($query) {
                        /** @var \Illuminate\Database\Eloquent\Builder $query */
                        $query->whereNull('start_at')->orWhere('start_at', '<=', date('Y-m-d H:i:s'));
                    })
                    ->where(function ($query) {
                        /** @var \Illuminate\Database\Eloquent\Builder $query */
                        $query->whereNull('end_at')->orWhere('end_at', '>=', date('Y-m-d H:i:s'));
                    })
                    ->where(function ($query) {
                        /** @var \Illuminate\Database\Eloquent\Builder $query */
                        $query
                            ->doesntHave('productMarkets')
                            ->orWhereHas('productMarkets', function ($query) {
                                /** @var \Illuminate\Database\Eloquent\Builder $query */
                                $query->where(['code' => 'store', 'active' => true]);
                            });
                    });
            })
            ->where(function ($query) {
                if(in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers'))) {
                    /** @var \Illuminate\Database\Eloquent\Builder $query */
                    $query
                        ->whereRaw("json_contains(ec_parameters, '\"1\"', '$.continued')")
                        ->orWhere(function ($query) {
                            /** @var \Illuminate\Database\Eloquent\Builder $query */
                            $query
                                ->whereRaw("json_contains(ec_parameters, '\"0\"', '$.continued')")
                                ->whereHas('productItems', function ($query) {
                                    /** @var \Illuminate\Database\Eloquent\Builder $query */
                                    $query
                                        ->where(function ($query) {
                                            /** @var \Illuminate\Database\Eloquent\Builder $query */
                                            $query
                                                ->where('qty_enable', false)
                                                ->orWhere(function ($query) {
                                                    /** @var \Illuminate\Database\Eloquent\Builder $query */
                                                    $query
                                                        ->where('qty_enable', true)
                                                        ->whereHas('productQuantities', function ($query) {
                                                            /** @var \Illuminate\Database\Eloquent\Builder $query */
                                                            $query
                                                                ->join(\DB::raw('(select item_id, max(id) as id from product_quantity group by item_id) as b'), function ($join) {
                                                                    /** @var \Illuminate\Database\Query\JoinClause $join */
                                                                    $join
                                                                        ->on('product_quantity.item_id', '=', 'b.item_id')
                                                                        ->on('product_quantity.id', '=', 'b.id');
                                                                })
                                                                ->where('summary', '>', 0);
                                                        });
                                                });
                                        });
                                });
                        });
                }
            })
            ->where('product_set.active', true);

        return $baseQuery;
    }
}