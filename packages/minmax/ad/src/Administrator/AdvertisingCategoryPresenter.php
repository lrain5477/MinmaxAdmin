<?php

namespace Minmax\Ad\Administrator;

use Minmax\Base\Administrator\Presenter;

/**
 * Class AdvertisingCategoryPresenter
 */
class AdvertisingCategoryPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxAd::';

    protected $languageColumns = ['title', 'remark'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'ad_type' => systemParam('ad_type'),
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param  \Minmax\Ad\Models\AdvertisingCategory $model
     * @return integer
     */
    public function getGridAmount($model)
    {
        $amount = $model->advertising->count();

        $url = langRoute('administrator.advertising.index', ['category' => $model->id]);

        $gridHtml = <<<HTML
<a href="{$url}">{$amount}</a>
HTML;

        return $gridHtml;
    }
}