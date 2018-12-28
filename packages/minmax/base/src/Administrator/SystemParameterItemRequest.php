<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class SystemParameterItemRequest
 */
class SystemParameterItemRequest extends FormRequest
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
                    'SystemParameterItem.group_id' => 'required|exists:system_parameter_group,id',
                    'SystemParameterItem.value' => [
                        'required', 'string',
                        Rule::unique('system_parameter_item', 'value')
                            ->where('group_id', $this->input('SystemParameterItem.group_id'))
                            ->ignore($this->route('id'))
                    ],
                    'SystemParameterItem.label' => 'required|string',
                    'SystemParameterItem.options' => 'nullable|array',
                    'SystemParameterItem.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'SystemParameterItem.group_id' => 'required|exists:system_parameter_group,id',
                    'SystemParameterItem.value' => [
                        'required', 'string',
                        Rule::unique('system_parameter_item', 'value')
                            ->where('group_id', $this->input('SystemParameterItem.group_id'))
                    ],
                    'SystemParameterItem.label' => 'required|string',
                    'SystemParameterItem.options' => 'nullable|array',
                    'SystemParameterItem.active' => 'required|boolean',
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
            'SystemParameterItem.group_id' => __('MinmaxBase::models.SystemParameterItem.group_id'),
            'SystemParameterItem.value' => __('MinmaxBase::models.SystemParameterItem.value'),
            'SystemParameterItem.label' => __('MinmaxBase::models.SystemParameterItem.label'),
            'SystemParameterItem.options' => __('MinmaxBase::models.SystemParameterItem.options'),
            'SystemParameterItem.active' => __('MinmaxBase::models.SystemParameterItem.active'),
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
