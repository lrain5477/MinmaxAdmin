<?php

namespace Minmax\Article\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleNews
 * @property string $id
 * @property string $uri
 * @property string $title
 * @property string $description
 * @property string $editor
 * @property array $pic
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property array $seo
 * @property boolean $top
 * @property boolean $active
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|ArticleCategory[] $articleCategories
 */
class ArticleNews extends Model
{
    protected $table = 'article_news';
    protected $guarded = [];
    protected $dates = ['start_at', 'end_at', 'created_at', 'updated_at'];
    protected $casts = [
        'top' => 'boolean',
        'active' => 'boolean',
    ];

    public $incrementing = false;

    public function getTitleAttribute()
    {
        return langDB($this->getAttributeFromArray('title'));
    }

    public function getDescriptionAttribute()
    {
        return langDB($this->getAttributeFromArray('description'));
    }

    public function getEditorAttribute()
    {
        return langDB($this->getAttributeFromArray('editor'));
    }

    public function getSeoAttribute()
    {
        return json_decode(langDB($this->getAttributeFromArray('seo')), true);
    }

    public function articleCategories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_news_category', 'news_id', 'category_id');
    }
}
