<?php

namespace Minmax\Product\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ProductCategoryRequest
 */
class ProductCategoryRequest extends FormRequest
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
                    'ProductCategory.title' => 'required|string',
                    'ProductCategory.details.pic' => 'nullable|array',
                    'ProductCategory.details.description' => 'nullable|string',
                    'ProductCategory.details.editor' => 'nullable|string',
                    'ProductCategory.parent_id' => 'nullable|exists:product_category,id',
                    'ProductCategory.sort' => 'required|integer',
                    'ProductCategory.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ProductCategory.title' => 'required|string',
                    'ProductCategory.details.pic' => 'nullable|array',
                    'ProductCategory.details.description' => 'nullable|string',
                    'ProductCategory.details.editor' => 'nullable|string',
                    'ProductCategory.parent_id' => 'nullable|exists:product_category,id',
                    'ProductCategory.sort' => 'nullable|integer',
                    'ProductCategory.active' => 'required|boolean',
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
            'ProductCategory.title' => __('MinmaxProduct::models.ProductCategory.title'),
            'ProductCategory.details.pic' => __('MinmaxProduct::models.ProductCategory.details.pic'),
            'ProductCategory.details.description' => __('MinmaxProduct::models.ProductCategory.details.description'),
            'ProductCategory.details.editor' => __('MinmaxProduct::models.ProductCategory.details.editor'),
            'ProductCategory.parent_id' => __('MinmaxProduct::models.ProductCategory.parent_id'),
            'ProductCategory.sort' => __('MinmaxProduct::models.ProductCategory.sort'),
            'ProductCategory.active' => __('MinmaxProduct::models.ProductCategory.active'),
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
