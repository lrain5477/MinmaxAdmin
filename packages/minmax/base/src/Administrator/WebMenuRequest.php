<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WebMenuRequest
 */
class WebMenuRequest extends FormRequest
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
                    'WebMenu.parent_id' => 'nullable|exists:web_menu,id',
                    'WebMenu.title' => 'required|string',
                    'WebMenu.uri' => 'nullable|string',
                    'WebMenu.controller' => 'nullable|string',
                    'WebMenu.model' => 'nullable|string',
                    'WebMenu.link' => 'nullable|string',
                    'WebMenu.permission_key' => 'nullable|string',
                    'WebMenu.sort' => 'required|integer|min:0',
                    'WebMenu.editable' => 'required|boolean',
                    'WebMenu.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WebMenu.parent_id' => 'nullable|exists:web_menu,id',
                    'WebMenu.title' => 'required|string',
                    'WebMenu.uri' => 'nullable|string',
                    'WebMenu.controller' => 'nullable|string',
                    'WebMenu.model' => 'nullable|string',
                    'WebMenu.link' => 'nullable|string',
                    'WebMenu.permission_key' => 'nullable|string',
                    'WebMenu.sort' => 'nullable|integer|min:0',
                    'WebMenu.editable' => 'required|boolean',
                    'WebMenu.active' => 'required|boolean',
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
            'WebMenu.parent_id' => __('MinmaxBase::models.WebMenu.parent_id'),
            'WebMenu.title' => __('MinmaxBase::models.WebMenu.title'),
            'WebMenu.uri' => __('MinmaxBase::models.WebMenu.uri'),
            'WebMenu.controller' => __('MinmaxBase::models.WebMenu.controller'),
            'WebMenu.model' => __('MinmaxBase::models.WebMenu.model'),
            'WebMenu.link' => __('MinmaxBase::models.WebMenu.link'),
            'WebMenu.permission_key' => __('MinmaxBase::models.WebMenu.permission_key'),
            'WebMenu.sort' => __('MinmaxBase::models.WebMenu.sort'),
            'WebMenu.editable' => __('MinmaxBase::models.WebMenu.editable'),
            'WebMenu.active' => __('MinmaxBase::models.WebMenu.active'),
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
