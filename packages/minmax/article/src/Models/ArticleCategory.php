<?php

namespace Minmax\Article\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleCategory
 * @property string $id
 * @property string $uri
 * @property string $parent_id
 * @property string $title
 * @property array $details
 * @property array $options
 * @property array $seo
 * @property integer $sort
 * @property boolean $editable
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|ArticleNews[] $articleNews
 */
class ArticleCategory extends Model
{
    protected $table = 'article_category';
    protected $guarded = [];
    protected $casts = [
        'options' => 'array',
        'editable' => 'boolean',
        'active' => 'boolean',
    ];

    public $incrementing = false;

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getDetailsAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('details')), true);
    }

    public function getSeoAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('seo')), true);
    }

    public function articleNews()
    {
        return $this->belongsToMany(ArticleNews::class, 'article_news_category', 'category_id', 'news_id');
    }
}
