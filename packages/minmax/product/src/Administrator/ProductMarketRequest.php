<?php

namespace Minmax\Product\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ProductMarketRequest
 */
class ProductMarketRequest extends FormRequest
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
                    'ProductMarket.code' => [
                        'required',
                        Rule::unique('product_market', 'code')->ignore($this->route('id'))
                    ],
                    'ProductMarket.title' => 'required|string',
                    'ProductMarket.admin_id' => 'nullable|exists:admin,id',
                    'ProductMarket.details.editor' => 'nullable|string',
                    'ProductMarket.details.pic' => 'nullable|array',
                    'ProductMarket.options' => 'nullable|array',
                    'ProductMarket.sort' => 'required|integer',
                    'ProductMarket.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ProductMarket.code' => 'required|unique:product_market,code',
                    'ProductMarket.title' => 'required|string',
                    'ProductMarket.admin_id' => 'nullable|exists:admin,id',
                    'ProductMarket.details.editor' => 'nullable|string',
                    'ProductMarket.details.pic' => 'nullable|array',
                    'ProductMarket.options' => 'nullable|array',
                    'ProductMarket.sort' => 'nullable|integer',
                    'ProductMarket.active' => 'required|boolean',
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
            'ProductMarket.code' => __('MinmaxProduct::models.ProductMarket.code'),
            'ProductMarket.title' => __('MinmaxProduct::models.ProductMarket.title'),
            'ProductMarket.admin_id' => __('MinmaxProduct::models.ProductMarket.admin_id'),
            'ProductMarket.details.editor' => __('MinmaxProduct::models.ProductMarket.details.editor'),
            'ProductMarket.details.pic' => __('MinmaxProduct::models.ProductMarket.details.pic'),
            'ProductMarket.options' => __('MinmaxProduct::models.ProductMarket.options'),
            'ProductMarket.sort' => __('MinmaxProduct::models.ProductMarket.sort'),
            'ProductMarket.active' => __('MinmaxProduct::models.ProductMarket.active'),
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
                case 'PUT':
                    LogHelper::system('administrator', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'POST':
                    LogHelper::system('administrator', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
