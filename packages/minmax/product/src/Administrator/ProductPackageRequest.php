<?php

namespace Minmax\Product\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ProductPackageRequest
 */
class ProductPackageRequest extends FormRequest
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
                    'ProductPackage.set_sku' => 'required|exists:product_set,sku',
                    'ProductPackage.item_sku' => 'required|exists:product_item,sku',
                    'ProductPackage.amount' => 'required|integer',
                    'ProductPackage.limit' => 'nullable|integer',
                    'ProductPackage.description' => 'nullable|string',
                    'ProductPackage.price_advice' => 'nullable|array',
                    'ProductPackage.price_sell' => 'nullable|array',
                    'ProductPackage.start_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'ProductPackage.end_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'ProductPackage.sort' => 'required|integer',
                    'ProductPackage.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ProductPackage.set_sku' => 'required|exists:product_set,sku',
                    'ProductPackage.item_sku' => 'required|exists:product_item,sku',
                    'ProductPackage.amount' => 'required|integer',
                    'ProductPackage.limit' => 'nullable|integer',
                    'ProductPackage.description' => 'nullable|string',
                    'ProductPackage.price_advice' => 'nullable|array',
                    'ProductPackage.price_sell' => 'nullable|array',
                    'ProductPackage.start_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'ProductPackage.end_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'ProductPackage.sort' => 'nullable|integer',
                    'ProductPackage.active' => 'required|boolean',
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
            'ProductPackage.set_sku' => __('MinmaxProduct::models.ProductPackage.set_sku'),
            'ProductPackage.item_sku' => __('MinmaxProduct::models.ProductPackage.item_sku'),
            'ProductPackage.amount' => __('MinmaxProduct::models.ProductPackage.amount'),
            'ProductPackage.limit' => __('MinmaxProduct::models.ProductPackage.limit'),
            'ProductPackage.description' => __('MinmaxProduct::models.ProductPackage.description'),
            'ProductPackage.price_advice' => __('MinmaxProduct::models.ProductPackage.price_advice'),
            'ProductPackage.price_sell' => __('MinmaxProduct::models.ProductPackage.price_sell'),
            'ProductPackage.start_at' => __('MinmaxProduct::models.ProductPackage.start_at'),
            'ProductPackage.end_at' => __('MinmaxProduct::models.ProductPackage.end_at'),
            'ProductPackage.sort' => __('MinmaxProduct::models.ProductPackage.sort'),
            'ProductPackage.active' => __('MinmaxProduct::models.ProductPackage.active'),
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
