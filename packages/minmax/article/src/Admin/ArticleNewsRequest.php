<?php

namespace Minmax\Article\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ArticleNewsRequest
 */
class ArticleNewsRequest extends FormRequest
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
                return $this->user('admin')->can('articleNewsEdit');
            case 'POST':
                return $this->user('admin')->can('articleNewsCreate');
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
                    'ArticleNews.uri' => [
                        'nullable',
                        'string',
                        Rule::unique('article_news', 'uri')->ignore($this->route('id'))
                    ],
                    'ArticleNews.categories' => 'required|array',
                    'ArticleNews.title' => 'required|string',
                    'ArticleNews.description' => 'nullable|string',
                    'ArticleNews.editor' => 'nullable|string',
                    'ArticleNews.pic' => 'nullable|array',
                    'ArticleNews.start_at' => 'required|date_format:Y-m-d H:i:s',
                    'ArticleNews.end_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'ArticleNews.top' => 'required|boolean',
                    'ArticleNews.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ArticleNews.uri' => 'nullable|string|unique:article_news,uri',
                    'ArticleNews.categories' => 'required|array',
                    'ArticleNews.title' => 'required|string',
                    'ArticleNews.description' => 'nullable|string',
                    'ArticleNews.editor' => 'nullable|string',
                    'ArticleNews.pic' => 'nullable|array',
                    'ArticleNews.start_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'ArticleNews.end_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'ArticleNews.top' => 'required|boolean',
                    'ArticleNews.active' => 'required|boolean',
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
            'ArticleNews.uri' => __('MinmaxAd::models.ArticleNews.uri'),
            'ArticleNews.categories' => __('MinmaxAd::models.ArticleNews.categories'),
            'ArticleNews.title' => __('MinmaxAd::models.ArticleNews.title'),
            'ArticleNews.description' => __('MinmaxAd::models.ArticleNews.description'),
            'ArticleNews.editor' => __('MinmaxAd::models.ArticleNews.editor'),
            'ArticleNews.pic' => __('MinmaxAd::models.ArticleNews.pic'),
            'ArticleNews.start_at' => __('MinmaxAd::models.ArticleNews.start_at'),
            'ArticleNews.end_at' => __('MinmaxAd::models.ArticleNews.end_at'),
            'ArticleNews.top' => __('MinmaxAd::models.ArticleNews.top'),
            'ArticleNews.active' => __('MinmaxAd::models.ArticleNews.active'),
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
