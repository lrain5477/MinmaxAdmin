<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Controller;

/**
 * Class ProductPackageController
 */
class ProductPackageController extends Controller
{
    protected $packagePrefix = 'MinmaxProduct::';

    public function __construct(ProductPackageRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQueryBuilder()
    {
        $query = $this->modelRepository->query()->with(['productItem', 'productSet', 'productMarkets']);

        if ($set_id = request('set')) {
            $query->whereHas('productSet', function ($query) use ($set_id) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where('product_set.id', $set_id);
            });
        }

        if ($item_id = request('item')) {
            $query->whereHas('productItem', function ($query) use ($item_id) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where('product_item.id', $item_id);
            });
        }

        return $query;
    }
}
