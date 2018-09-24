<?php

namespace App\Http\Requests\Admin;

use App\Helpers\LogHelper;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !is_null($this->user('admin'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'Admin.name' => 'required|string',
            'Admin.email' => 'required|email',
            'Admin.password' => 'sometimes|required|string|min:6|confirmed',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'Admin.name' => __('models.Admin.name'),
            'Admin.email' => __('models.Admin.email'),
            'Admin.password' => __('models.Admin.password'),
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
            LogHelper::system('admin', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
        }
    }
}
