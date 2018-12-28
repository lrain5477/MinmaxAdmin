<?php

namespace Minmax\Base\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class AdminRequest
 */
class AdminRequest extends FormRequest
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
                return $this->user('admin')->can('adminEdit');
            case 'POST':
                return $this->user('admin')->can('adminCreate');
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
                    'Admin.username' => 'required|string',
                    'Admin.password' => 'nullable|string|min:6|confirmed',
                    'Admin.name' => 'required|string',
                    'Admin.email' => 'nullable|email',
                    'Admin.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'Admin.username' => 'required|string',
                    'Admin.name' => 'required|string',
                    'Admin.email' => 'nullable|email',
                    'Admin.active' => 'required|boolean',
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
            'Admin.username' => __('MinmaxBase::models.Admin.username'),
            'Admin.password' => __('MinmaxBase::models.Admin.password'),
            'Admin.password_confirmation' => __('MinmaxBase::models.Admin.password_confirmation'),
            'Admin.name' => __('MinmaxBase::models.Admin.name'),
            'Admin.email' => __('MinmaxBase::models.Admin.email'),
            'Admin.active' => __('MinmaxBase::models.Admin.active'),
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
