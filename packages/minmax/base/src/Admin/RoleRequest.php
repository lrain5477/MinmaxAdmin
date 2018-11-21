<?php

namespace Minmax\Base\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

class RoleRequest extends FormRequest
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
                return $this->user('admin')->can('roleEdit');
            case 'POST':
                return $this->user('admin')->can('roleCreate');
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
                    'Role.name' => 'required|string',
                    'Role.display_name' => 'required|string',
                    'Role.active' => 'required|in:1,0',
                ];
            case 'POST':
            default:
                return [
                    'Role.guard' => 'required|in:admin,web',
                    'Role.name' => 'required|string',
                    'Role.display_name' => 'required|string',
                    'Firewall.active' => 'required|in:1,0',
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
            'Role.guard' => __('models.Role.guard'),
            'Role.name' => __('models.Role.name'),
            'Role.display_name' => __('models.Role.display_name'),
            'Role.active' => __('models.Role.active'),
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
