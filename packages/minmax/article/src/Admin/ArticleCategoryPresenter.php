<?php

namespace Minmax\Article\Admin;

use Minmax\Base\Admin\ColumnExtensionRepository;
use Minmax\Base\Admin\Presenter;

/**
 * Class ArticleCategoryPresenter
 */
class ArticleCategoryPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxArticle::';

    protected $languageColumns = ['title', 'details', 'seo'];

    protected $categorySet = [];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'parent_id' => (new ArticleCategoryRepository)->getSelectParameters(),
            'editable' => systemParam('editable'),
            'active' => systemParam('active'),
        ];

        $this->categorySet = (new ArticleCategoryRepository)->all();
    }

    /**
     * @param  \Minmax\Article\Models\ArticleCategory $model
     * @return integer
     */
    public function getGridObjAmount($model)
    {
        if ($relation = array_get($model->options ?? [], 'relation')) {
            $relationColumn = snake_case($relation);
            $countColumn = "{$relationColumn}_count";
            return $model->{$countColumn} ?? 0;
        }
        return 0;
    }

    /**
     * @param  \Minmax\Article\Models\ArticleCategory $model
     * @param  boolean $childrenFlag
     * @return string
     */
    public function getGridSubAmount($model, $childrenFlag)
    {
        $amount = $this->categorySet->where('parent_id', $model->id)->count();

        if ($childrenFlag) {
            $url = langRoute('admin.article-category.index', ['parent' => $model->id]);
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

    /**
     * @param  \Minmax\Article\Models\ArticleCategory $model
     * @param  array $options
     * @return string
     */
    public function getViewDetails($model, $options = [])
    {
        $column = 'details';
        $columns = (new ColumnExtensionRepository)->getFields($model->getTable(), $column);
        $detailColumns = array_key_exists($column, $model->options ?? []) ? explode(',', array_get($model->options, $column)) : [];

        $parentId = $model->parent_id;
        while (! is_null($parentId)) {
            if ($parentModel = (new ArticleCategoryRepository)->find($parentId)) {
                $parentId = $parentModel->parent_id;
                if (is_null($parentId)) {
                    $detailColumns = array_key_exists($column, $parentModel->options ?? [])
                        ? explode(',', array_get($parentModel->options, $column))
                        : [];
                }
            } else {
                return '';
            }
        }

        $fields = '';

        try {
            foreach ($detailColumns as $detailColumn) {
                if (in_array($detailColumn, array_get($options, 'excepts', []))) continue;

                if ($subColumnItem = $columns->where('sub_column_name', $detailColumn)->first()) {
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
                        case 'getFieldEmail':
                        case 'getFieldTel':
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
     * @param  \Minmax\Article\Models\ArticleCategory $model
     * @param  array $options
     * @return integer
     */
    public function getFieldDetails($model, $options = [])
    {
        $column = 'details';
        $columns = (new ColumnExtensionRepository)->getFields($model->getTable(), $column);
        $detailColumns = array_key_exists($column, $model->options ?? []) ? explode(',', array_get($model->options, $column)) : [];

        $parentId = $model->parent_id;
        while (! is_null($parentId)) {
            if ($parentModel = (new ArticleCategoryRepository)->find($parentId)) {
                $parentId = $parentModel->parent_id;
                if (is_null($parentId)) {
                    $detailColumns = array_key_exists($column, $parentModel->options ?? [])
                        ? explode(',', array_get($parentModel->options, $column))
                        : [];
                }
            } else {
                return '';
            }
        }

        $fields = '';

        try {
            foreach ($detailColumns as $detailColumn) {
                if ($subColumnItem = $columns->where('sub_column_name', $detailColumn)->first()) {
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