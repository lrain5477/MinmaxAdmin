<?php

namespace Minmax\Product\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ProductSetRequest
 */
class ProductSetRequest extends FormRequest
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
                return $this->user('admin')->can('productSetEdit');
            case 'POST':
                return $this->user('admin')->can('productSetCreate');
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
                    'ProductSet.sku' => [
                        'required', 'string',
                        Rule::unique('product_set', 'sku')->ignore($this->route('id'))
                    ],
                    'ProductSet.serial' => 'nullable|string',
                    'ProductSet.title' => 'required|string',
                    'ProductSet.pic' => 'nullable|array',
                    'ProductSet.details.description' => 'nullable|string',
                    'ProductSet.details.editor' => 'nullable|string',
                    'ProductSet.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ProductSet.sku' => 'required|string|unique:product_set,sku',
                    'ProductSet.serial' => 'nullable|string',
                    'ProductSet.title' => 'required|string',
                    'ProductSet.pic' => 'nullable|array',
                    'ProductSet.details.description' => 'nullable|string',
                    'ProductSet.details.editor' => 'nullable|string',
                    'ProductSet.active' => 'required|boolean',
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
            'ProductSet.sku' => __('MinmaxProduct::models.ProductSet.sku'),
            'ProductSet.serial' => __('MinmaxProduct::models.ProductSet.serial'),
            'ProductSet.title' => __('MinmaxProduct::models.ProductSet.title'),
            'ProductSet.pic' => __('MinmaxProduct::models.ProductSet.pic'),
            'ProductSet.details.description' => __('MinmaxProduct::models.ProductSet.details.description'),
            'ProductSet.details.editor' => __('MinmaxProduct::models.ProductSet.details.editor'),
            'ProductSet.active' => __('MinmaxProduct::models.ProductSet.active'),
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