<?php

namespace Minmax\Product\Administrator;

use Minmax\Base\Administrator\Presenter;

/**
 * Class ProductCategoryPresenter
 */
class ProductCategoryPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxProduct::';

    protected $languageColumns = ['title', 'details'];

    protected $categorySet = [];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'parent_id' => (new ProductCategoryRepository)->getSelectParameters(),
            'active' => systemParam('active'),
        ];

        $this->categorySet = (new ProductCategoryRepository)->all();
    }

    /**
     * @param  \Minmax\Product\Models\ProductCategory $model
     * @return string
     */
    public function getGridSetAmount($model)
    {
        $amount = $model->productSets->count();

        $url = langRoute('administrator.product-set.index', ['category' => $model->id]);

        $thisHtml = <<<HTML
<a class="text-center d-block" href="{$url}">{$amount}</a>
HTML;

        return $thisHtml;

    }

    /**
     * @param  \Minmax\Product\Models\ProductCategory $model
     * @param  boolean $childrenFlag
     * @return string
     */
    public function getGridSubAmount($model, $childrenFlag)
    {
        $amount = $this->categorySet->where('parent_id', $model->id)->count();

        if ($childrenFlag) {
            $url = langRoute('administrator.product-category.index', ['parent' => $model->id]);
            $thisHtml = <<<HTML
<a class="text-center d-block" href="{$url}">{$amount}</a>
HTML;
        } else {
            $thisHtml = <<<HTML
<span class="text-center d-block">{$amount}</span>
HTML;
        }

        return $thisHtml;

    }
}