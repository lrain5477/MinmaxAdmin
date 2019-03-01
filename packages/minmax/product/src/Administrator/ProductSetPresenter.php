<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Presenter;
use Minmax\Base\Administrator\SiteParameterGroupRepository;

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
            'tags' => siteParam('tags'),
            'specifications' => siteParam(null, null, 'spec'),
            'properties' => siteParam('property'),
            'searchable' => systemParam('searchable'),
            'visible' => systemParam('visible'),
            'active' => systemParam('active'),
        ];
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

        $url = langRoute('administrator.product-set.edit', ['id' => $model->id]);

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
            $itemTag = '<span class="badge badge-pill badge-danger ml-2">' . __('MinmaxProduct::administrator.grid.ProductSet.tags.package_empty') . '</span>';
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
<small class="text-success float-right">{$categories}</small>
HTML;

        return $gridHtml;
    }

    /**
     * @param  \Minmax\Product\Models\ProductSet $model
     * @return string
     */
    public function getGridRelation($model)
    {
        $itemLabel = __('MinmaxProduct::administrator.grid.ProductSet.relations.item');
        $packageLabel = __('MinmaxProduct::administrator.grid.ProductSet.relations.package');
        $specificationLabel = __('MinmaxProduct::administrator.grid.ProductSet.relations.specification');

        $itemAmount = $model->productItems->count();
        $packageAmount = $model->productPackages->count();
        $specificationAmount = $model->newQuery()->whereNotNull('spec_group')->where('spec_group', $model->spec_group)->count();

        $itemUrl = langRoute('administrator.product-item.index', ['set' => $model->id]);
        $packageUrl = langRoute('administrator.product-package.index', ['set' => $model->id]);
        $specificationUrl = $specificationAmount > 0 ? langRoute('administrator.product-set.index', ['spec' => $model->spec_group]) : 'javascript:void(0);';

        $gridHtml = <<<HTML
<div class="text-nowrap small">{$itemLabel}：<a href="{$itemUrl}">{$itemAmount}</a></div>
<div class="text-nowrap small">{$packageLabel}：<a href="{$packageUrl}">{$packageAmount}</a></div>
<div class="text-nowrap small">{$specificationLabel}：<a href="{$specificationUrl}">{$specificationAmount}</a></div>
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

        return view('MinmaxProduct::administrator.product-set.form-product-category-selection', $componentData);
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
            'hint' => __('MinmaxProduct::models.ProductSet.hint.specifications', ['link' => langRoute('administrator.site-parameter-item.index')]),
        ];

        return view('MinmaxProduct::administrator.product-set.form-dynamic-specification-list', $componentData);
    }

    /**
     * @param  \Minmax\Product\Models\ProductSet $model
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldTagsInput($model, $options = [])
    {
        $componentData = [
            'id' => 'ProductSet-tags',
            'label' => __('MinmaxProduct::models.ProductSet.tags'),
            'name' => 'ProductSet[tags][]',
            'values' => $model->tags ?? [],
            'hint' => __('MinmaxProduct::models.ProductSet.hint.tags', ['link' => langRoute('administrator.site-parameter-item.index')]),
            'listData' => array_get($this->parameterSet, 'tags', []),
        ];

        return view('MinmaxProduct::administrator.product-set.form-tags-input', $componentData);
    }
}