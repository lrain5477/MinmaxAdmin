<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class AdminMenuRequest
 */
class AdminMenuRequest extends FormRequest
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
                    'AdminMenu.parent_id' => 'nullable|exists:admin_menu,id',
                    'AdminMenu.title' => 'required|string',
                    'AdminMenu.uri' => ['required', Rule::unique('admin_menu', 'uri')->ignore($this->route('id'))],
                    'AdminMenu.controller' => 'nullable|string',
                    'AdminMenu.model' => 'nullable|string',
                    'AdminMenu.link' => 'nullable|string',
                    'AdminMenu.icon' => 'nullable|string',
                    'AdminMenu.permission_key' => 'nullable|string',
                    'AdminMenu.sort' => 'required|integer|min:0',
                    'AdminMenu.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'AdminMenu.parent_id' => 'nullable|exists:admin_menu,id',
                    'AdminMenu.title' => 'required|string',
                    'AdminMenu.uri' => 'required|unique:admin_menu,uri',
                    'AdminMenu.controller' => 'nullable|string',
                    'AdminMenu.model' => 'nullable|string',
                    'AdminMenu.link' => 'nullable|string',
                    'AdminMenu.icon' => 'nullable|string',
                    'AdminMenu.permission_key' => 'nullable|string',
                    'AdminMenu.sort' => 'nullable|integer|min:0',
                    'AdminMenu.active' => 'required|boolean',
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
            'AdminMenu.parent_id' => __('MinmaxBase::models.AdminMenu.parent_id'),
            'AdminMenu.title' => __('MinmaxBase::models.AdminMenu.title'),
            'AdminMenu.uri' => __('MinmaxBase::models.AdminMenu.uri'),
            'AdminMenu.controller' => __('MinmaxBase::models.AdminMenu.controller'),
            'AdminMenu.model' => __('MinmaxBase::models.AdminMenu.model'),
            'AdminMenu.link' => __('MinmaxBase::models.AdminMenu.link'),
            'AdminMenu.icon' => __('MinmaxBase::models.AdminMenu.icon'),
            'AdminMenu.permission_key' => __('MinmaxBase::models.AdminMenu.permission_key'),
            'AdminMenu.sort' => __('MinmaxBase::models.AdminMenu.sort'),
            'AdminMenu.active' => __('MinmaxBase::models.AdminMenu.active'),
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
