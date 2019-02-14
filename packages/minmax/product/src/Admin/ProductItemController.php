<?php

namespace Minmax\Product\Admin;

use Illuminate\Http\Request;
use Minmax\Base\Admin\Controller;
use Minmax\Base\Helpers\Log as LogHelper;
use Minmax\Io\Admin\IoConstructRepository;

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
        $query = $this->modelRepository->query()->with(['productQuantities', 'productPackages', 'productSets']);

        if ($set_id = request('set')) {
            $query->whereHas('productSets', function ($query) use ($set_id) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                $query->where('product_set.id', $set_id);
            });
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

    protected function setCustomViewDataIndex()
    {
        $ioModel = (new IoConstructRepository)->one('uri', 'product-item');
        $this->viewData['importLink'] = is_null($ioModel) ? null : langRoute('admin.io-data.config', ['id' => $ioModel->id, 'method' => 'import']);
        $this->viewData['exportLink'] = is_null($ioModel) ? null : langRoute('admin.io-data.config', ['id' => $ioModel->id, 'method' => 'export']);
    }

    public function ajaxMultiQty(Request $request)
    {
        $this->checkPermissionEdit('ajax');

        $validator = validator($request->input(), [
            'data' => 'required|array|min:1',
        ]);

        $updatedSet = $request->input('data', []);

        if (!$validator->fails() && count($updatedSet) > 0) {
            try {
                \DB::beginTransaction();

                foreach ($updatedSet as $itemId => $itemQty) {
                    if ($model = $this->modelRepository->find($itemId)) {
                        $oriQty = $model->qty;
                        $model->productQuantities()->create([
                            'amount' => intval($itemQty) - $oriQty,
                            'remark' => __('MinmaxProduct::admin.form.ProductItem.messages.manual_update_qty'),
                            'summary' => $itemQty,
                        ]);
                        $model->touch();
                    } else {
                        throw new \Exception();
                    }
                }

                \DB::commit();

                foreach ($updatedSet as $itemId => $itemQty) {
                    LogHelper::system('admin', $request->path(), $request->method(), $itemId, $this->adminData->username, 1, __('MinmaxBase::admin.form.message.edit_success'));
                }
                return response(['msg' => 'success'], 200, ['Content-Type' => 'application/json']);
            } catch (\Exception $e) {
                \DB::rollBack();
            }
        }

        LogHelper::system('admin', $request->path(), $request->method(), '', $this->adminData->username, 0, __('MinmaxBase::admin.form.message.edit_error'));
        return response(['msg' => 'error'], 400, ['Content-Type' => 'application/json']);
    }
}
