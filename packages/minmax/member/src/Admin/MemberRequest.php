<?php

namespace Minmax\Member\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class MemberRequest
 */
class MemberRequest extends FormRequest
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
                return $this->user('admin')->can('memberEdit');
            case 'POST':
                return $this->user('admin')->can('memberCreate');
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
                    'Member.name' => 'required|string',
                    'Member.email' => 'required|email',
                    'Member.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'Member.username' => 'required|string|min:6|unique:member,username',
                    'Member.name' => 'required|string',
                    'Member.email' => 'required|email',
                    'Member.active' => 'required|boolean',
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
            'Member.username' => __('MinmaxMember::models.Member.username'),
            'Member.name' => __('MinmaxMember::models.Member.name'),
            'Member.email' => __('MinmaxMember::models.Member.email'),
            'Member.active' => __('MinmaxMember::models.Member.active'),
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
