<?php

namespace Minmax\Member\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class MemberTermRequest
 */
class MemberTermRequest extends FormRequest
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
            case 'POST':
            default:
                return [
                    'MemberTerm.title' => 'required|string',
                    'MemberTerm.editor' => 'required|string',
                    'MemberTerm.start_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'MemberTerm.end_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'MemberTerm.active' => 'required|boolean',
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
            'MemberTerm.title' => __('MinmaxMember::models.MemberTerm.title'),
            'MemberTerm.editor' => __('MinmaxMember::models.MemberTerm.editor'),
            'MemberTerm.start_at' => __('MinmaxMember::models.MemberTerm.start_at'),
            'MemberTerm.end_at' => __('MinmaxMember::models.MemberTerm.end_at'),
            'MemberTerm.active' => __('MinmaxMember::models.MemberTerm.active'),
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
