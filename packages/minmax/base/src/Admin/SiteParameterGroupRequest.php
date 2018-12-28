<?php

namespace Minmax\Base\Admin;

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
        switch ($this->method()) {
            case 'PUT':
                return $this->user('admin')->can('siteParameterGroupEdit');
            case 'POST':
                return $this->user('admin')->can('siteParameterGroupCreate');
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
                    'SiteParameterGroup.code' => ['required', Rule::unique('site_parameter_group', 'code')->ignore($this->route('id'))],
                    'SiteParameterGroup.title' => 'required|string',
                    'SiteParameterGroup.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'SiteParameterGroup.code' => 'required|unique:site_parameter_group,code',
                    'SiteParameterGroup.title' => 'required|string',
                    'SiteParameterGroup.active' => 'required|boolean',
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
            'SiteParameterGroup.code' => __('MinmaxBase::models.SiteParameterGroup.code'),
            'SiteParameterGroup.title' => __('MinmaxBase::models.SiteParameterGroup.title'),
            'SiteParameterGroup.active' => __('MinmaxBase::models.SiteParameterGroup.active'),
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
