<?php

namespace Minmax\Ad\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class AdvertisingCategoryRequest
 */
class AdvertisingCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
                    'AdvertisingCategory.code' => [
                        'required',
                        'string',
                        Rule::unique('advertising_category', 'code')->ignore($this->route('id')),
                    ],
                    'AdvertisingCategory.title' => 'required|string',
                    'AdvertisingCategory.remark' => 'nullable|string',
                    'AdvertisingCategory.ad_type' => 'required|string',
                    'AdvertisingCategory.options' => 'nullable|array',
                    'AdvertisingCategory.sort' => 'required|integer',
                    'AdvertisingCategory.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'AdvertisingCategory.code' => 'required|string|unique:advertising_category,code',
                    'AdvertisingCategory.title' => 'required|string',
                    'AdvertisingCategory.remark' => 'nullable|string',
                    'AdvertisingCategory.ad_type' => 'required|string',
                    'AdvertisingCategory.options' => 'nullable|array',
                    'AdvertisingCategory.sort' => 'nullable|integer',
                    'AdvertisingCategory.active' => 'required|boolean',
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
            'AdvertisingCategory.code' => __('MinmaxAd::models.AdvertisingCategory.code'),
            'AdvertisingCategory.title' => __('MinmaxAd::models.AdvertisingCategory.title'),
            'AdvertisingCategory.remark' => __('MinmaxAd::models.AdvertisingCategory.remark'),
            'AdvertisingCategory.ad_type' => __('MinmaxAd::models.AdvertisingCategory.ad_type'),
            'AdvertisingCategory.options' => __('MinmaxAd::models.AdvertisingCategory.options'),
            'AdvertisingCategory.sort' => __('MinmaxAd::models.AdvertisingCategory.sort'),
            'AdvertisingCategory.active' => __('MinmaxAd::models.AdvertisingCategory.active'),
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
                    LogHelper::system('administrator', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'PUT':
                    LogHelper::system('administrator', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
