<?php

namespace App\Http\Requests\Administrator;

use App\Helpers\LogHelper;
use Illuminate\Foundation\Http\FormRequest;

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
                    'AdminMenu.title' => 'required|string',
                    'AdminMenu.uri' => 'required|unique:admin_menu,uri',
                    'AdminMenu.controller' => 'nullable|string',
                    'AdminMenu.model' => 'nullable|string',
                    'AdminMenu.class' => 'required|string',
                    'AdminMenu.parent_id' => 'nullable|exists:admin_menu,guid',
                    'AdminMenu.link' => 'nullable|string',
                    'AdminMenu.icon' => 'nullable|string',
                    'AdminMenu.permission_key' => 'nullable|string',
                    'AdminMenu.sort' => 'nullable|integer|min:0',
                    'AdminMenu.active' => 'required|in:1,0',
                ];
            case 'POST':
            default:
                return [
                    'AdminMenu.title' => 'required|string',
                    'AdminMenu.uri' => 'required|unique:admin_menu,uri',
                    'AdminMenu.controller' => 'nullable|string',
                    'AdminMenu.model' => 'nullable|string',
                    'AdminMenu.class' => 'required|string',
                    'AdminMenu.parent_id' => 'nullable|exists:admin_menu,guid',
                    'AdminMenu.link' => 'nullable|string',
                    'AdminMenu.icon' => 'nullable|string',
                    'AdminMenu.permission_key' => 'nullable|string',
                    'AdminMenu.sort' => 'required|integer|min:0',
                    'AdminMenu.active' => 'required|in:1,0',
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
            'AdminMenu.title' => __('models.AdminMenu.title'),
            'AdminMenu.uri' => __('models.AdminMenu.uri'),
            'AdminMenu.controller' => __('models.AdminMenu.controller'),
            'AdminMenu.model' => __('models.AdminMenu.model'),
            'AdminMenu.class' => __('models.AdminMenu.class'),
            'AdminMenu.parent_id' => __('models.AdminMenu.parent_id'),
            'AdminMenu.link' => __('models.AdminMenu.link'),
            'AdminMenu.icon' => __('models.AdminMenu.icon'),
            'AdminMenu.permission_key' => __('models.AdminMenu.permission_key'),
            'AdminMenu.sort' => __('models.AdminMenu.sort'),
            'AdminMenu.active' => __('models.AdminMenu.active'),
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
