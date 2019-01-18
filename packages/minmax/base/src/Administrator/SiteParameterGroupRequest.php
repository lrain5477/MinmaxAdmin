<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class SiteParameterGroupRequest
 */
class SiteParameterGroupRequest extends FormRequest
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
                    'SiteParameterGroup.category' => 'nullable|string',
                    'SiteParameterGroup.code' => [
                        'required', 'string',
                        Rule::unique('site_parameter_group', 'code')->ignore($this->route('id'))],
                    'SiteParameterGroup.title' => 'required|string',
                    'SiteParameterGroup.options' => 'nullable|array',
                    'SiteParameterGroup.active' => 'required|boolean',
                    'SiteParameterGroup.editable' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'SiteParameterGroup.category' => 'nullable|string',
                    'SiteParameterGroup.code' => 'required|string|unique:site_parameter_group,code',
                    'SiteParameterGroup.title' => 'required|string',
                    'SiteParameterGroup.options' => 'nullable|array',
                    'SiteParameterGroup.active' => 'required|boolean',
                    'SiteParameterGroup.editable' => 'required|boolean',
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
            'SiteParameterGroup.category' => __('MinmaxBase::models.SiteParameterGroup.category'),
            'SiteParameterGroup.code' => __('MinmaxBase::models.SiteParameterGroup.code'),
            'SiteParameterGroup.title' => __('MinmaxBase::models.SiteParameterGroup.title'),
            'SiteParameterGroup.options' => __('MinmaxBase::models.SiteParameterGroup.options'),
            'SiteParameterGroup.active' => __('MinmaxBase::models.SiteParameterGroup.active'),
            'SiteParameterGroup.editable' => __('MinmaxBase::models.SiteParameterGroup.editable'),
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
