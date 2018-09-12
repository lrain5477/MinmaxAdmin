<?php

namespace App\Http\Requests\Admin;

use App\Helpers\LogHelper;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('adminEdit');
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
                    'Admin.password' => 'sometimes|required|string|min:6|confirmed',
                    'Admin.name' => 'required|string',
                    'Admin.email' => 'nullable|email',
                    'Admin.active' => 'required|in:1,0',
                ];
            case 'POST':
            default:
                return [
                    'Admin.username' => 'required|string',
                    'Admin.name' => 'required|string',
                    'Admin.email' => 'nullable|email',
                    'Admin.active' => 'required|in:1,0',
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
            'Admin.username' => __('models.Admin.username'),
            'Admin.password' => __('models.Admin.password'),
            'Admin.name' => __('models.Admin.name'),
            'Admin.email' => __('models.Admin.email'),
            'Admin.active' => __('models.Admin.active'),
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
                    LogHelper::system('admin', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'PUT':
                    LogHelper::system('admin', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
