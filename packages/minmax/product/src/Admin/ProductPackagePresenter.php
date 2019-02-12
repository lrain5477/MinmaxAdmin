<?php

namespace Minmax\Product\Admin;

use Minmax\Base\Admin\Presenter;
use Minmax\World\Admin\WorldCurrencyRepository;

/**
 * Class ProductPackagePresenter
 */
class ProductPackagePresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxProduct::';

    protected $languageColumns = ['description'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'productMarkets' => (new ProductMarketRepository)->getSelectParameters(),
            'active' => systemParam('active'),
            'currencies' => (new WorldCurrencyRepository)->getSelectParameters('active', true),
        ];
    }

    /**
     * @param  \Minmax\Product\Models\ProductPackage $model
     * @return string
     */
    public function getGridTitle($model)
    {
        $setTitle = $model->productSet->title;
        $itemTitle = $model->productItem->title;

        $setSkuLabel = __('MinmaxProduct::models.ProductPackage.set_sku');
        $itemSkuLabel = __('MinmaxProduct::models.ProductPackage.item_sku');

        $url = 'javascript:void(0);';
        if (in_array('R', $this->permissionSet)) {
            $url = langRoute('admin.product-package.show', ['id' => $model->id]);
        }
        if (in_array('U', $this->permissionSet)) {
            $url = langRoute('admin.product-package.edit', ['id' => $model->id]);
        }

        $setUrl = langRoute('admin.product-set.show', ['id' => $model->productSet->id]);
        $itemUrl = langRoute('admin.product-item.show', ['id' => $model->productItem->id]);

        $marketSet = $model->productMarkets->pluck('title');
        if ($marketSet->count() > 0) {
            $markets = $marketSet->implode(', ');
            $markets = mb_strlen($markets) <= 20 ? $markets : (mb_substr($markets, 20) . '...');
        } else {
            $markets = __('MinmaxProduct::admin.grid.ProductPackage.all_market');
        }

        $gridHtml = <<<HTML
<h3 class="h6 d-inline d-sm-block">
    <a class="text-pre-line" href="{$url}">{$setTitle}</a>
</h3>
<p class="m-0 p-0 text-pre-line"><!--
    --><small>{$setSkuLabel}:</small><small class="ml-1"><a href="{$setUrl}" title="{$setTitle}" target="_blank">{$model->set_sku}</a></small><br /><!--
    --><small>{$itemSkuLabel}:</small><small class="ml-1"><a href="{$itemUrl}" title="{$itemTitle}" target="_blank">{$model->item_sku}</a></small><!--
--></p>
<small class="text-success float-right">{$markets}</small>
HTML;

        return $gridHtml;
    }

    /**
     * @param  \Minmax\Product\Models\ProductPackage $model
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldDynamicPriceList($model, $options = [])
    {
        $modelName = 'ProductPackage';
        $adviceValue = $this->getModelValue($model, 'price_advice') ?? [];
        $sellValue = $this->getModelValue($model, 'price_sell') ?? [];

        $fieldLabel = __("MinmaxProduct::admin.form.ProductPackage.price");
        $fieldValue = [];

        foreach ($adviceValue as $currency => $advice) {
            $fieldValue[$currency] = ['advice' => $advice, 'sell' => 0];
        }
        foreach ($sellValue as $currency => $sell) {
            if (! isset($fieldValue[$currency])) {
                $fieldValue[$currency]['advice'] = 0;
            }
            $fieldValue[$currency]['sell'] = $sell;
        }

        $hintPath = $this->packagePrefix . "admin.form.ProductPackage.hint.price";

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => 'ProductPackage-price',
            'label' => $fieldLabel,
            'name' => $modelName,
            'currencies' => array_get($this->parameterSet, 'currencies', []),
            'values' => $fieldValue,
            'hint' => $hintValue,
        ];

        return view('MinmaxProduct::admin.product-package.form-dynamic-price-list', $componentData);
    }

    /**
     * @param  \Minmax\Product\Models\ProductPackage $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewDynamicPriceList($model)
    {
        $modelName = 'ProductPackage';
        $adviceValue = $this->getModelValue($model, 'price_advice') ?? [];
        $sellValue = $this->getModelValue($model, 'price_sell') ?? [];

        $fieldLabel = __("MinmaxProduct::admin.form.ProductPackage.price");
        $fieldValue = [];

        foreach ($adviceValue as $currency => $advice) {
            $fieldValue[$currency] = ['advice' => $advice, 'sell' => 0];
        }
        foreach ($sellValue as $currency => $sell) {
            if (! isset($fieldValue[$currency])) {
                $fieldValue[$currency]['advice'] = 0;
            }
            $fieldValue[$currency]['sell'] = $sell;
        }

        $componentData = [
            'id' => 'ProductPackage-money',
            'label' => $fieldLabel,
            'name' => $modelName,
            'currencies' => array_get($this->parameterSet, 'currencies', []),
            'values' => $fieldValue,
        ];

        return view('MinmaxProduct::admin.product-package.view-dynamic-price-list', $componentData);
    }
}