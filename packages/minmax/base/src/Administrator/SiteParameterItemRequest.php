<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class SiteParameterItemRequest
 */
class SiteParameterItemRequest extends FormRequest
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
                    'SiteParameterItem.group_id' => 'required|exists:site_parameter_group,id',
                    'SiteParameterItem.value' => [
                        'required', 'string',
                        Rule::unique('site_parameter_item', 'value')
                            ->where('group_id', $this->input('SiteParameterItem.group_id'))
                            ->ignore($this->route('id'))
                    ],
                    'SiteParameterItem.label' => 'required|string',
                    'SiteParameterItem.details.description' => 'nullable|string',
                    'SiteParameterItem.details.editor' => 'nullable|string',
                    'SiteParameterItem.details.pic' => 'nullable|array',
                    'SiteParameterItem.options' => 'nullable|array',
                    'SiteParameterItem.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'SiteParameterItem.group_id' => 'required|exists:site_parameter_group,id',
                    'SiteParameterItem.value' => [
                        'required', 'string',
                        Rule::unique('site_parameter_item', 'value')
                            ->where('group_id', $this->input('SiteParameterItem.group_id'))
                    ],
                    'SiteParameterItem.label' => 'required|string',
                    'SiteParameterItem.details.description' => 'nullable|string',
                    'SiteParameterItem.details.editor' => 'nullable|string',
                    'SiteParameterItem.details.pic' => 'nullable|array',
                    'SiteParameterItem.options' => 'nullable|array',
                    'SiteParameterItem.active' => 'required|boolean',
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
            'SiteParameterItem.group_id' => __('MinmaxBase::models.SiteParameterItem.group_id'),
            'SiteParameterItem.value' => __('MinmaxBase::models.SiteParameterItem.value'),
            'SiteParameterItem.label' => __('MinmaxBase::models.SiteParameterItem.label'),
            'SiteParameterItem.details.description' => __('MinmaxBase::models.SiteParameterItem.details.description'),
            'SiteParameterItem.details.editor' => __('MinmaxBase::models.SiteParameterItem.details.editor'),
            'SiteParameterItem.details.pic' => __('MinmaxBase::models.SiteParameterItem.details.pic'),
            'SiteParameterItem.options' => __('MinmaxBase::models.SiteParameterItem.options'),
            'SiteParameterItem.active' => __('MinmaxBase::models.SiteParameterItem.active'),
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
