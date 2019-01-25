<?php

namespace Minmax\Product\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ProductBrandRequest
 */
class ProductBrandRequest extends FormRequest
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
                return $this->user('admin')->can('productBrandEdit');
            case 'POST':
                return $this->user('admin')->can('productBrandCreate');
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
                    'ProductBrand.title' => 'required|string',
                    'ProductBrand.pic' => 'nullable|array',
                    'ProductBrand.details.description' => 'nullable|string',
                    'ProductBrand.details.editor' => 'nullable|string',
                    'ProductBrand.sort' => 'required|integer',
                    'ProductBrand.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ProductBrand.title' => 'required|string',
                    'ProductBrand.pic' => 'nullable|array',
                    'ProductBrand.details.description' => 'nullable|string',
                    'ProductBrand.details.editor' => 'nullable|string',
                    'ProductBrand.sort' => 'nullable|integer',
                    'ProductBrand.active' => 'required|boolean',
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
            'ProductBrand.title' => __('MinmaxProduct::models.ProductBrand.title'),
            'ProductBrand.pic' => __('MinmaxProduct::models.ProductBrand.pic'),
            'ProductBrand.details.description' => __('MinmaxProduct::models.ProductBrand.details.description'),
            'ProductBrand.details.editor' => __('MinmaxProduct::models.ProductBrand.details.editor'),
            'ProductBrand.sort' => __('MinmaxProduct::models.ProductBrand.sort'),
            'ProductBrand.active' => __('MinmaxProduct::models.ProductBrand.active'),
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
