<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Presenter;
use Minmax\World\Administrator\WorldCurrencyRepository;

/**
 * Class ProductItemPresenter
 */
class ProductItemPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxProduct::';

    protected $languageColumns = ['title', 'details'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'qty_enable' => systemParam('qty_enable'),
            'active' => systemParam('active'),
            'currencies' => (new WorldCurrencyRepository)->getSelectParameters('active', true),
        ];
    }

    /**
     * @param  \Minmax\Product\Models\ProductItem $model
     * @return string
     */
    public function getGridTitle($model)
    {
        $titleValue = $model->getAttribute('title') ?? '';
        $skuValue = $model->getAttribute('sku') ?? '-';
        $serialValue = $model->getAttribute('serial') ?? '-';

        $skuLabel = __('MinmaxProduct::models.ProductItem.sku');
        $serialLabel = __('MinmaxProduct::models.ProductItem.serial');

        $url = langRoute('administrator.product-item.edit', ['id' => $model->id]);

        $qtyTag = '';
        if ($model->qty_enable) {
            if ($model->qty_safety > 0 && $model->qty > 0) {
                if ($model->qty <= $model->qty_safety) {
                    $qtyTag = '<span class="badge badge-pill badge-warning ml-2">' . __('MinmaxProduct::administrator.grid.ProductItem.tags.qty_safety') . '</span>';
                }
            } else {
                if ($model->qty < 1) {
                    $qtyTag = '<span class="badge badge-pill badge-danger ml-2">' . __('MinmaxProduct::administrator.grid.ProductItem.tags.qty_empty') . '</span>';
                }
            }
        }

        $productTag = '';
        if ($model->productPackages->count() < 1) {
            $productTag = '<span class="badge badge-pill badge-danger ml-2">' . __('MinmaxProduct::administrator.grid.ProductItem.tags.package_empty') . '</span>';
        }

        $gridHtml = <<<HTML
<h3 class="h6 d-inline d-sm-block">
    <a class="text-pre-line" href="{$url}">{$titleValue}</a>{$qtyTag}{$productTag}
</h3>
<p class="m-0 p-0 text-pre-line"><!--
    --><small>{$skuLabel}:</small><small class="ml-1">{$skuValue}</small><br /><!--
    --><small>{$serialLabel}:</small><small class="ml-1">{$serialValue}</small><!--
--></p>
HTML;

        return $gridHtml;
    }

    /**
     * @param  string $name
     * @param  array $options
     * @return string
     */
    public function getFilterStatusTag($name, $options = [])
    {
        $tags = [
            'qty_safety' => ['title' => __('MinmaxProduct::administrator.grid.ProductItem.tags.qty_safety')],
            'qty_empty' => ['title' => __('MinmaxProduct::administrator.grid.ProductItem.tags.qty_empty')],
            'package_empty' => ['title' => __('MinmaxProduct::administrator.grid.ProductItem.tags.package_empty')],
        ];

        try {
            return view('MinmaxBase::administrator.layouts.grid.filter-selection', [
                    'name' => $name,
                    'emptyLabel' => array_get($options, 'emptyLabel', 'All'),
                    'parameters' => $tags,
                    'current' => array_get($options, 'current', ''),
                ])
                ->render();
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * @param  \Minmax\Product\Models\ProductItem $model
     * @return string
     */
    public function getGridQty($model)
    {
        $value = $model->qty_enable ? $model->qty : -1;

        if ($value >= 0) {
            try {
                return view('MinmaxProduct::administrator.product-item.grid-qty', [
                        'id' => $model->getKey(),
                        'value' => $value,
                    ])
                    ->render();
            } catch (\Throwable $e) {
                return '';
            }
        } else {
            if ($model->qty_enable) {
                return $model->qty;
            } else {
                return $this->getGridTextBadge($model, 'qty_enable');
            }
        }
    }

    /**
     * @param  \Minmax\Product\Models\ProductItem $model
     * @return string
     */
    public function getGridRelation($model)
    {
        $setLabel = __('MinmaxProduct::admin.grid.ProductItem.relations.set');
        $packageLabel = __('MinmaxProduct::admin.grid.ProductSet.relations.package');

        $setAmount = $model->productSets->count();
        $packageAmount = $model->productPackages->count();

        $setUrl = langRoute('admin.product-set.index', ['item' => $model->id]);
        $packageUrl = langRoute('admin.product-package.index', ['item' => $model->id]);

        $gridHtml = <<<HTML
<div class="text-nowrap small">{$setLabel}：<a href="{$setUrl}">{$setAmount}</a></div>
<div class="text-nowrap small">{$packageLabel}：<a href="{$packageUrl}">{$packageAmount}</a></div>
HTML;

        return $gridHtml;
    }

    /**
     * @param  \Minmax\Product\Models\ProductItem $model
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldDynamicPriceList($model, $options = [])
    {
        $modelName = 'ProductItem';
        $costValue = $this->getModelValue($model, 'cost') ?? [];
        $priceValue = $this->getModelValue($model, 'price') ?? [];

        $fieldLabel = __("MinmaxProduct::admin.form.ProductItem.money");
        $fieldValue = [];

        foreach ($costValue as $currency => $cost) {
            $fieldValue[$currency] = ['cost' => $cost, 'price' => 0];
        }
        foreach ($priceValue as $currency => $price) {
            if (! isset($fieldValue[$currency])) {
                $fieldValue[$currency]['cost'] = 0;
            }
            $fieldValue[$currency]['price'] = $price;
        }

        $hintPath = $this->packagePrefix . "admin.form.ProductItem.hint.money";

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => 'ProductItem-money',
            'label' => $fieldLabel,
            'name' => $modelName,
            'currencies' => array_get($this->parameterSet, 'currencies', []),
            'values' => $fieldValue,
            'hint' => $hintValue,
        ];

        return view('MinmaxProduct::admin.product-item.form-dynamic-price-list', $componentData);
    }

    /**
     * @param  \Minmax\Product\Models\ProductItem $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewDynamicPriceList($model)
    {
        $modelName = 'ProductItem';
        $costValue = $this->getModelValue($model, 'cost') ?? [];
        $priceValue = $this->getModelValue($model, 'price') ?? [];

        $fieldLabel = __("MinmaxProduct::admin.form.ProductItem.money");
        $fieldValue = [];

        foreach ($costValue as $currency => $cost) {
            $fieldValue[$currency] = ['cost' => $cost, 'price' => 0];
        }
        foreach ($priceValue as $currency => $price) {
            if (! isset($fieldValue[$currency])) {
                $fieldValue[$currency]['cost'] = 0;
            }
            $fieldValue[$currency]['price'] = $price;
        }

        $componentData = [
            'id' => 'ProductItem-money',
            'label' => $fieldLabel,
            'name' => $modelName,
            'currencies' => array_get($this->parameterSet, 'currencies', []),
            'values' => $fieldValue,
        ];

        return view('MinmaxProduct::admin.product-item.view-dynamic-price-list', $componentData);
    }
}