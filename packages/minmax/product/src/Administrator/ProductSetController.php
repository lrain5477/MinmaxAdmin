<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Controller;
use Minmax\Io\Administrator\IoConstructRepository;

/**
 * Class ProductSetController
 */
class ProductSetController extends Controller
{
    protected $packagePrefix = 'MinmaxProduct::';

    public function __construct(ProductSetRepository $repository)
    {
        $this->modelRepository = $repository;

        parent::__construct();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getQueryBuilder()
    {
        $query = $this->modelRepository->query()->with(['productItems', 'productPackages.productMarkets', 'productCategories']);

        if ($itemId = request('item')) {
            $query->whereHas('productItems', function ($query) use ($itemId) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where('product_item.id', $itemId);
            });
        }

        if ($specGroup = request('spec')) {
            $query->where('spec_group', $specGroup);
        }

        return $query;
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
                                        return preg_match('/^product_set\.title\./', $key) > 0 && strpos($item, $value) !== false;
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

                    if ($column == 'category') {
                        $query
                            ->whereHas('productCategories', function ($query) use ($value) {
                                /** @var \Illuminate\Database\Eloquent\Builder $query */
                                $query->where('id', $value);
                            });
                        continue;
                    }

                    $query->where($column, $value);
                }
            }
        });

        return $datatable;
    }

    protected function setCustomViewDataIndex()
    {
        $ioModel = (new IoConstructRepository)->one(['uri' => 'product-set', 'active' => true]);
        $this->viewData['importLink'] = is_null($ioModel) ? null : ($ioModel->import_enable ? langRoute('administrator.io-construct.config', ['id' => $ioModel->id, 'method' => 'import']) : null);
        $this->viewData['exportLink'] = is_null($ioModel) ? null : ($ioModel->export_enable ? langRoute('administrator.io-construct.config', ['id' => $ioModel->id, 'method' => 'export']) : null);
    }
}
