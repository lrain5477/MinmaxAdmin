<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class ColumnExtensionRequest
 */
class ColumnExtensionRequest extends FormRequest
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
                    'ColumnExtension.table_name' => 'required|string',
                    'ColumnExtension.column_name' => 'required|string',
                    'ColumnExtension.sub_column_name' => 'required|string',
                    'ColumnExtension.title' => 'required|string',
                    'ColumnExtension.options' => 'required|array',
                    'ColumnExtension.sort' => 'required|integer',
                    'ColumnExtension.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'ColumnExtension.table_name' => 'required|string',
                    'ColumnExtension.column_name' => 'required|string',
                    'ColumnExtension.sub_column_name' => 'required|string',
                    'ColumnExtension.title' => 'required|string',
                    'ColumnExtension.options' => 'required|array',
                    'ColumnExtension.sort' => 'nullable|integer',
                    'ColumnExtension.active' => 'required|boolean',
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
            'ColumnExtension.table_name' => __('MinmaxBase::models.ColumnExtension.table_name'),
            'ColumnExtension.column_name' => __('MinmaxBase::models.ColumnExtension.column_name'),
            'ColumnExtension.sub_column_name' => __('MinmaxBase::models.ColumnExtension.sub_column_name'),
            'ColumnExtension.title' => __('MinmaxBase::models.ColumnExtension.title'),
            'ColumnExtension.options' => __('MinmaxBase::models.ColumnExtension.options'),
            'ColumnExtension.sort' => __('MinmaxBase::models.ColumnExtension.sort'),
            'ColumnExtension.active' => __('MinmaxBase::models.ColumnExtension.active'),
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
