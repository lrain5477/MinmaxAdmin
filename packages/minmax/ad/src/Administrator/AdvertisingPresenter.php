<?php

namespace Minmax\Ad\Administrator;

use Illuminate\Support\Facades\DB;
use Minmax\Base\Administrator\ColumnExtensionRepository;
use Minmax\Base\Administrator\Presenter;

/**
 * Class AdvertisingPresenter
 */
class AdvertisingPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxAd::';

    protected $languageColumns = ['title', 'link', 'details'];

    protected $clickCountSet = [];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'category_id' => (new AdvertisingCategoryRepository)->getSelectParameters(),
            'target' => systemParam('target'),
            'active' => systemParam('active'),
        ];

        $this->clickCountSet = DB::table('advertising_track')
            ->select(['advertising_id', DB::raw('count(*) as `num`')])
            ->groupBy('advertising_id')
            ->pluck('num', 'advertising_id')
            ->toArray();
    }

    /**
     * @param  \Minmax\Ad\Models\Advertising $model
     * @return string
     */
    public function getGridTitle($model)
    {
        $titleValue = $model->getAttribute('title');
        $categoryValue = $model->advertisingCategory->title;

        $url = langRoute('administrator.advertising.edit', ['id' => $model->id]);

        $gridHtml = <<<HTML
<h3 class="h6 d-inline d-sm-block">
    <a class="text-pre-line" href="{$url}">{$titleValue}</a>
</h3>
<span class="float-right">{$categoryValue}</span>
HTML;

        return $gridHtml;
    }

    /**
     * @param  \Minmax\Ad\Models\Advertising $model
     * @return integer
     */
    public function getGridCount($model)
    {
        return array_get($this->clickCountSet, $model->id, 0);
    }

    /**
     * @param  \Minmax\Ad\Models\Advertising $model
     * @param  array $options
     * @return integer
     */
    public function getViewDetails($model, $options = [])
    {
        $column = 'details';
        $columns = (new ColumnExtensionRepository)->getFields($model->getTable(), $column);
        $categoryColumns = explode(',', systemParam("ad_type.{$model->advertisingCategory->ad_type}.options.{$column}"));

        $fields = '';

        try {
            foreach ($categoryColumns as $categoryColumn) {
                if (in_array($categoryColumn, array_get($options, 'excepts', []))) continue;

                if ($subColumnItem = $columns->where('sub_column_name', $categoryColumn)->first()) {
                    /** @var \Minmax\Base\Models\ColumnExtension $subColumnItem */
                    $subColumn = $subColumnItem->sub_column_name;
                    $subOptions = $subColumnItem->options;
                    $subOptions['label'] = $subColumnItem->title;

                    if ($systemParam = array_pull($subOptions, 'systemParam')) {
                        $this->parameterSet[$column][$subColumn] = systemParam($systemParam);
                    }

                    if ($siteParam = array_pull($subOptions, 'siteParam')) {
                        $this->parameterSet[$column][$subColumn] = siteParam($siteParam);
                    }

                    $subMethod = null;

                    switch (array_pull($subOptions, 'method')) {
                        case 'getFieldNormalText':
                        case 'getFieldText':
                        case 'getFieldDatePicker':
                        case 'getFieldTextarea':
                            $subMethod = 'getViewNormalText';
                            break;
                        case 'getFieldEditor':
                            $subMethod = 'getViewEditor';
                            break;
                        case 'getFieldSelection':
                        case 'getFieldRadio':
                            $subMethod = 'getViewSelection';
                            break;
                        case 'getFieldMultiSelect':
                        case 'getFieldCheckbox':
                            $subMethod = 'getViewMultiSelection';
                            break;
                        case 'getFieldMediaImage':
                            $subMethod = 'getViewMediaImage';
                            break;
                    }

                    if (! is_null($subMethod)) {
                        $fields .= $this->{$subMethod}($model, $column, ['subColumn' => $subColumn] + $subOptions + $options)->render();
                    }
                }
            }
        } catch (\Exception $e) {
            $fields = '';
        }

        return $fields;
    }

    /**
     * @param  \Minmax\Ad\Models\Advertising $model
     * @param  array $options
     * @return integer
     */
    public function getFieldDetails($model, $options = [])
    {
        $column = 'details';
        $columns = (new ColumnExtensionRepository)->getFields($model->getTable(), $column);
        $categoryColumns = explode(',', systemParam("ad_type.{$model->advertisingCategory->ad_type}.options.{$column}"));

        $fields = '';

        try {
            foreach ($categoryColumns as $categoryColumn) {
                if ($subColumnItem = $columns->where('sub_column_name', $categoryColumn)->first()) {
                    /** @var \Minmax\Base\Models\ColumnExtension $subColumnItem */
                    $subColumn = $subColumnItem->sub_column_name;
                    $subOptions = $subColumnItem->options;
                    $subOptions['label'] = $subColumnItem->title;

                    if ($systemParam = array_pull($subOptions, 'systemParam')) {
                        $this->parameterSet[$column][$subColumn] = systemParam($systemParam);
                    }

                    if ($siteParam = array_pull($subOptions, 'siteParam')) {
                        $this->parameterSet[$column][$subColumn] = siteParam($siteParam);
                    }

                    if ($subMethod = array_pull($subOptions, 'method')) {
                        $fields .= $this->{$subMethod}($model, $column, ['subColumn' => $subColumn] + $subOptions + $options)->render();
                    }
                }
            }
        } catch (\Exception $e) {
            $fields = '';
        }

        return $fields;
    }
}