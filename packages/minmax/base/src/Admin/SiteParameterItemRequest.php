<?php

namespace Minmax\Base\Admin;

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
        switch ($this->method()) {
            case 'PUT':
                return $this->user('admin')->can('siteParameterItemEdit');
            case 'POST':
                return $this->user('admin')->can('siteParameterItemCreate');
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
                    'SiteParameterItem.value' => ['required', Rule::unique('site_parameter_item', 'value')->ignore($this->route('id'))],
                    'SiteParameterItem.label' => 'required|string',
                    'SiteParameterItem.details.description' => 'nullable|string',
                    'SiteParameterItem.details.editor' => 'nullable|string',
                    'SiteParameterItem.details.pic' => 'nullable|array',
                    'SiteParameterItem.sort' => 'required|integer',
                    'SiteParameterItem.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'SiteParameterItem.group_id' => 'required|exists:site_parameter_group,id',
                    'SiteParameterItem.value' => 'required|unique:site_parameter_item,value',
                    'SiteParameterItem.label' => 'required|string',
                    'SiteParameterItem.details.description' => 'nullable|string',
                    'SiteParameterItem.details.editor' => 'nullable|string',
                    'SiteParameterItem.details.pic' => 'nullable|array',
                    'SiteParameterItem.sort' => 'nullable|integer',
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
            'SiteParameterItem.sort' => __('MinmaxBase::models.SiteParameterItem.sort'),
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
