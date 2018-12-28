<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class PermissionRequest
 */
class PermissionRequest extends FormRequest
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
                    'Permission.guard' => 'required|in:admin,web',
                    'Permission.group' => 'required|string',
                    'Permission.name' => 'required|string',
                    'Permission.label' => 'required|string',
                    'Permission.display_name' => 'required|string',
                    'Permission.description' => 'nullable|string',
                    'Permission.sort' => 'required|integer',
                    'Permission.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'Permission.guard' => 'required|in:admin,web',
                    'Permission.group' => 'required|string',
                    'Permission.name' => 'required|string',
                    'Permission.label' => 'required|string',
                    'Permission.display_name' => 'required|string',
                    'Permission.description' => 'nullable|string',
                    'Permission.sort' => 'nullable|integer',
                    'Permission.active' => 'required|boolean',
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
            'Permission.guard' => __('MinmaxBase::models.Permission.guard'),
            'Permission.group' => __('MinmaxBase::models.Permission.group'),
            'Permission.name' => __('MinmaxBase::models.Permission.name'),
            'Permission.label' => __('MinmaxBase::models.Permission.label'),
            'Permission.display_name' => __('MinmaxBase::models.Permission.display_name'),
            'Permission.description' => __('MinmaxBase::models.Permission.description'),
            'Permission.sort' => __('MinmaxBase::models.Permission.sort'),
            'Permission.active' => __('MinmaxBase::models.Permission.active'),
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
