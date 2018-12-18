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
                    'Role.permissions' => 'nullable|array',
                    'Role.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'Role.name' => 'required|string',
                    'Role.display_name' => 'required|string',
                    'Role.active' => 'required|boolean',
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
            'Role.name' => __('MinmaxBase::models.Role.name'),
            'Role.display_name' => __('MinmaxBase::models.Role.display_name'),
            'Role.permissions' => __('MinmaxBase::admin.form.fieldSet.permission'),
            'Role.active' => __('MinmaxBase::models.Role.active'),
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
