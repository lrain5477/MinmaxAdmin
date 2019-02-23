<?php

namespace Minmax\Article\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ArticleCategoryRequest
 */
class ArticleCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'PUT':
                return $this->user('admin')->can('articleCategoryEdit');
            case 'POST':
                return $this->user('admin')->can('articleCategoryCreate');
            default:
                return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'PUT':
                return [
                    'ArticleCategory.uri' => [
                        'nullable',
                        'string',
                        Rule::unique('article_category', 'uri')->ignore($this->route('id'))
                    ],
                    'ArticleCategory.parent_id' => 'nullable|exists:article_category,id',
                    'ArticleCategory.title' => 'required|string',
                    'ArticleCategory.details' => 'nullable|array',
                    'ArticleCategory.sort' => 'required|integer',
                    'ArticleCategory.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ArticleCategory.uri' => 'nullable|string|unique:article_category,uri',
                    'ArticleCategory.parent_id' => 'nullable|exists:article_category,id',
                    'ArticleCategory.title' => 'required|string',
                    'ArticleCategory.details' => 'nullable|array',
                    'ArticleCategory.sort' => 'nullable|integer',
                    'ArticleCategory.active' => 'required|boolean',
                ];
        }
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'ArticleCategory.uri' => __('MinmaxAd::models.ArticleCategory.uri'),
            'ArticleCategory.parent_id' => __('MinmaxAd::models.ArticleCategory.parent_id'),
            'ArticleCategory.title' => __('MinmaxAd::models.ArticleCategory.title'),
            'ArticleCategory.details' => __('MinmaxAd::models.ArticleCategory.details'),
            'ArticleCategory.options' => __('MinmaxAd::models.ArticleCategory.options'),
            'ArticleCategory.sort' => __('MinmaxAd::models.ArticleCategory.sort'),
            'ArticleCategory.active' => __('MinmaxAd::models.ArticleCategory.active'),
        ];
    }

    /**
     * 設定驗證器實例。
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            switch ($this->method()) {
                case 'POST':
                    LogHelper::system('admin', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'PUT':
                    LogHelper::system('admin', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
