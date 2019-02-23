<?php

namespace Minmax\Article\Admin;

use Minmax\Base\Admin\Repository;
use Minmax\Article\Models\ArticleNews;

/**
 * Class ArticleNewsRepository
 * @property ArticleNews $model
 * @method ArticleNews find($id)
 * @method ArticleNews one($column = null, $operator = null, $value = null, $boolean = 'and')
 * @method ArticleNews create($attributes)
 * @method ArticleNews save($model, $attributes)
 * @method ArticleNews|\Illuminate\Database\Eloquent\Builder query()
 */
class ArticleNewsRepository extends Repository
{
    const MODEL = ArticleNews::class;

    protected $languageColumns = ['title', 'description', 'editor', 'seo'];

    protected $categories = null;

    /**
     * Get table name of this model
     *
     * @return string
     */
    protected function getTable()
    {
        return 'article_news';
    }

    protected function beforeCreate()
    {
        $this->categories = array_pull($this->attributes, 'categories', []);
    }

    protected function afterCreate()
    {
        $this->model->articleCategories()->sync($this->categories);
        $this->categories = null;
    }

    protected function beforeSave()
    {
        if (count($this->attributes) > 1 || !array_key_exists('sort', $this->attributes)) {
            $this->categories = array_pull($this->attributes, 'categories', []) ?? [];
        }
    }

    protected function afterSave()
    {
        if (! is_null($this->categories)) {
            $this->model->articleCategories()->sync($this->categories);
            $this->categories = null;
        }
    }
}