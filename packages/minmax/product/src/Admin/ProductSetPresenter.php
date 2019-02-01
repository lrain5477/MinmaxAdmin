<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Presenter;
use Minmax\Base\Admin\SiteParameterGroupRepository;

/**
 * Class ProductSetPresenter
 */
class ProductSetPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxProduct::';

    protected $languageColumns = ['title', 'details', 'seo'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'brand_id' => (new ProductBrandRepository)->getSelectParameters(),
            'categories' => (new ProductCategoryRepository)->getSelectParameters(false, true),
            'rank' => siteParam('rank'),
            'specifications' => siteParam(null, null, 'spec'),
            'properties' => siteParam('property'),
            'searchable' => systemParam('searchable'),
            'visible' => systemParam('visible'),
            'active' => systemParam('active'),
        ];

        if (in_array(\Minmax\Ecommerce\ServiceProvider::class, config('app.providers'))) {
            $this->parameterSet['ec_parameters'] = [
                'payment_types' => siteParam('payment_type'),
                'delivery_types' => siteParam('delivery_type'),
                'billing' => siteParam('billing'),
                'shipping' => siteParam('shipping'),
                'continued' => systemParam('continued'),
                'additional' => systemParam('additional'),
                'wrapped' => systemParam('wrapped'),
                'returnable' => systemParam('returnable'),
                'rewarded' => systemParam('rewarded'),
            ];
        }
    }

    /**
     * @param  \Minmax\Product\Models\ProductSet $model
     * @return string
     */
    public function getGridTitle($model)
    {
        $titleValue = $model->getAttribute('title') ?? '';
        $skuValue = $model->getAttribute('sku') ?? '-';
        $serialValue = $model->getAttribute('serial') ?? '-';

        $skuLabel = __('MinmaxProduct::models.ProductSet.sku');
        $serialLabel = __('MinmaxProduct::models.ProductSet.serial');

        $url = 'javascript:void(0);';
        if (in_array('R', $this->permissionSet)) {
            $url = langRoute('admin.product-set.show', ['id' => $model->id]);
        }
        if (in_array('U', $this->permissionSet)) {
            $url = langRoute('admin.product-set.edit', ['id' => $model->id]);
        }

        $qtyTag = '';
//        if ($model->qty_enable) {
//            if ($model->qty_safety > 0 && $model->qty > 0) {
//                if ($model->qty <= $model->qty_safety) {
//                    $qtyTag = '<span class="badge badge-pill badge-warning ml-2">' . __('MinmaxProduct::admin.grid.ProductItem.tags.qty_safety') . '</span>';
//                }
//            } else {
//                if ($model->qty < 1) {
//                    $qtyTag = '<span class="badge badge-pill badge-danger ml-2">' . __('MinmaxProduct::admin.grid.ProductItem.tags.qty_empty') . '</span>';
//                }
//            }
//        }

        $itemTag = '';
        if ($model->productPackages->count() < 1) {
            $itemTag = '<span class="badge badge-pill badge-danger ml-2">' . __('MinmaxProduct::admin.grid.ProductSet.tags.package_empty') . '</span>';
        }

        $categories = $model->productCategories->pluck('title')->implode(', ');
        $categories = mb_strlen($categories) <= 20 ? $categories : (mb_substr($categories, 20) . '...');

        $gridHtml = <<<HTML
<h3 class="h6 d-inline d-sm-block">
    <a class="text-pre-line" href="{$url}">{$titleValue}</a>{$qtyTag}{$itemTag}
</h3>
<p class="m-0 p-0 text-pre-line"><!--
    --><small>{$skuLabel}:</small><small class="ml-1">{$skuValue}</small><br /><!--
    --><small>{$serialLabel}:</small><small class="ml-1">{$serialValue}</small><!--
--></p>
<small class="text-success float-right">$categories</small>
HTML;

        return $gridHtml;
    }

    /**
     * @param  \Minmax\Product\Models\ProductSet $model
     * @return string
     */
    public function getGridRelation($model)
    {
        $itemLabel = __('MinmaxProduct::admin.grid.ProductSet.relations.item');
        $packageLabel = __('MinmaxProduct::admin.grid.ProductSet.relations.package');
        $specificationLabel = __('MinmaxProduct::admin.grid.ProductSet.relations.specification');

        $itemAmount = $model->productItems->count();
        $packageAmount = $model->productPackages->count();

        $gridHtml = <<<HTML
<div class="text-nowrap small">{$itemLabel}：<a href="productPackage.html">{$itemAmount}</a></div>
<div class="text-nowrap small">{$packageLabel}：<a href="productPackage.html">{$packageAmount}</a></div>
<div class="text-nowrap small">{$specificationLabel}：<a href="productPackage.html">0</a></div>
HTML;

        return $gridHtml;
    }

    /**
     * @param  \Minmax\Product\Models\ProductSet $model
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldCategorySelection($model, $options = [])
    {
        $componentData = [
            'id' => 'ProductSet-categories',
            'label' => __('MinmaxProduct::models.ProductSet.categories'),
            'name' => 'ProductSet[categories][]',
            'values' => $model->productCategories->pluck('id')->toArray(),
            'hint' => __('MinmaxProduct::models.ProductSet.hint.categories'),
            'size' => array_get($options, 'size', 10),
            'listData' => array_get($this->parameterSet, 'categories', []),
        ];

        return view('MinmaxProduct::admin.product-set.form-product-category-selection', $componentData);
    }

    /**
     * @param  \Minmax\Product\Models\ProductSet $model
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldDynamicSpecificationList($model, $options = [])
    {
        $fieldLabel = __("MinmaxProduct::models.ProductSet.specifications");
        $fieldValue = $this->getModelValue($model, 'specifications') ?? [];

        $specifications = (new SiteParameterGroupRepository)->all('active', true)
            ->sortBy('sort')
            ->filter(function ($item) { return array_key_exists($item->code, array_get($this->parameterSet, 'specifications', [])); })
            ->map(function ($item) {
                $item->children = array_get($this->parameterSet, "specifications.{$item->code}", []);
                return $item;
            });

        $componentData = [
            'id' => 'ProductSet-specifications',
            'label' => $fieldLabel,
            'name' => 'ProductSet',
            'values' => $fieldValue,
            'listData' => $specifications,
            'hint' => __('MinmaxProduct::models.ProductSet.hint.specifications', ['link' => langRoute('admin.site-parameter-item.index')]),
        ];

        return view('MinmaxProduct::admin.product-set.form-dynamic-specification-list', $componentData);
    }
}