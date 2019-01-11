<?php

namespace Minmax\Member\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class MemberDetailRequest
 */
class MemberDetailRequest extends FormRequest
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
                    'MemberDetail.name' => 'required|array',
                    'MemberDetail.contact' => 'nullable|array',
                    'MemberDetail.social' => 'nullable|array',
                    'MemberDetail.profile' => 'nullable|array',
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
            'MemberDetail.name' => __('MinmaxMember::models.MemberDetail.name'),
            'MemberDetail.contact' => __('MinmaxMember::models.MemberDetail.contact'),
            'MemberDetail.social' => __('MinmaxMember::models.MemberDetail.social'),
            'MemberDetail.profile' => __('MinmaxMember::models.MemberDetail.profile'),
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
                    LogHelper::system('administrator', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'PUT':
                    LogHelper::system('administrator', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
