<?php

namespace Minmax\Base\Admin;

use Illuminate\Foundation\Http\FormRequest;
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
        switch ($this->method()) {
            case 'PUT':
                return $this->user('admin')->can('webMenuEdit');
            case 'POST':
                return $this->user('admin')->can('webMenuCreate');
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
                    'WebMenu.parent_id' => 'nullable|exists:web_menu,id',
                    'WebMenu.title' => 'required|string',
                    'WebMenu.uri' => 'nullable|string',
                    'WebMenu.link' => 'nullable|string',
                    'WebMenu.sort' => 'required|integer|min:0',
                    'WebMenu.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WebMenu.parent_id' => 'nullable|exists:web_menu,id',
                    'WebMenu.title' => 'required|string',
                    'WebMenu.uri' => 'nullable|string',
                    'WebMenu.link' => 'nullable|string',
                    'WebMenu.sort' => 'nullable|integer|min:0',
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
            'WebMenu.link' => __('MinmaxBase::models.WebMenu.link'),
            'WebMenu.sort' => __('MinmaxBase::models.WebMenu.sort'),
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
                    LogHelper::system('admin', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'POST':
                    LogHelper::system('admin', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
