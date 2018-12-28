<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class SystemParameterGroupRequest
 */
class SystemParameterGroupRequest extends FormRequest
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
                    'SystemParameterGroup.code' => [
                        'required', 'string',
                        Rule::unique('system_parameter_group', 'code')->ignore($this->route('id'))],
                    'SystemParameterGroup.title' => 'required|string',
                    'SystemParameterGroup.options' => 'nullable|array',
                    'SystemParameterGroup.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'SystemParameterGroup.code' => 'required|string|unique:system_parameter_group,code',
                    'SystemParameterGroup.title' => 'required|string',
                    'SystemParameterGroup.options' => 'nullable|array',
                    'SystemParameterGroup.active' => 'required|boolean',
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
            'SystemParameterGroup.code' => __('MinmaxBase::models.SystemParameterGroup.code'),
            'SystemParameterGroup.title' => __('MinmaxBase::models.SystemParameterGroup.title'),
            'SystemParameterGroup.options' => __('MinmaxBase::models.SystemParameterGroup.options'),
            'SystemParameterGroup.active' => __('MinmaxBase::models.SystemParameterGroup.active'),
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
