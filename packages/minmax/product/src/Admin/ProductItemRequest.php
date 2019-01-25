<?php

namespace Minmax\Product\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ProductItemRequest
 */
class ProductItemRequest extends FormRequest
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
                return $this->user('admin')->can('productItemEdit');
            case 'POST':
                return $this->user('admin')->can('productItemCreate');
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
                    'ProductItem.sku' => [
                        'required', 'string',
                        Rule::unique('product_item', 'sku')->ignore($this->route('id'))
                    ],
                    'ProductItem.serial' => 'nullable|string',
                    'ProductItem.title' => 'required|string',
                    'ProductItem.pic' => 'nullable|array',
                    'ProductItem.details.description' => 'nullable|string',
                    'ProductItem.details.editor' => 'nullable|string',
                    'ProductItem.cost' => 'nullable|array',
                    'ProductItem.price' => 'nullable|array',
                    'ProductItem.qty_enable' => 'required|boolean',
                    'ProductItem.qty_safety' => 'nullable|integer|min:0',
                    'ProductItem.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ProductItem.sku' => 'required|string|unique:product_item,sku',
                    'ProductItem.serial' => 'nullable|string',
                    'ProductItem.title' => 'required|string',
                    'ProductItem.pic' => 'nullable|array',
                    'ProductItem.details.description' => 'nullable|string',
                    'ProductItem.details.editor' => 'nullable|string',
                    'ProductItem.cost' => 'nullable|array',
                    'ProductItem.price' => 'nullable|array',
                    'ProductItem.qty_enable' => 'required|boolean',
                    'ProductItem.qty_safety' => 'nullable|integer|min:0',
                    'ProductItem.active' => 'required|boolean',
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
            'ProductItem.sku' => __('MinmaxProduct::models.ProductItem.sku'),
            'ProductItem.serial' => __('MinmaxProduct::models.ProductItem.serial'),
            'ProductItem.title' => __('MinmaxProduct::models.ProductItem.title'),
            'ProductItem.pic' => __('MinmaxProduct::models.ProductItem.pic'),
            'ProductItem.details.description' => __('MinmaxProduct::models.ProductItem.details.description'),
            'ProductItem.details.editor' => __('MinmaxProduct::models.ProductItem.details.editor'),
            'ProductItem.cost' => __('MinmaxProduct::models.ProductItem.cost'),
            'ProductItem.price' => __('MinmaxProduct::models.ProductItem.price'),
            'ProductItem.qty_enable' => __('MinmaxProduct::models.ProductItem.qty_enable'),
            'ProductItem.qty_safety' => __('MinmaxProduct::models.ProductItem.qty_safety'),
            'ProductItem.active' => __('MinmaxProduct::models.ProductItem.active'),
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
                    LogHelper::system('admin', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'POST':
                    LogHelper::system('admin', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
