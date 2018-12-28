<?php

namespace Minmax\Base\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class EditorTemplateRequest
 */
class EditorTemplateRequest extends FormRequest
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
                    'EditorTemplate.guard' => 'required|string',
                    'EditorTemplate.category' => 'required|string',
                    'EditorTemplate.title' => 'required|string',
                    'EditorTemplate.description' => 'nullable|string',
                    'EditorTemplate.editor' => 'required|string',
                    'EditorTemplate.sort' => 'required|integer',
                    'EditorTemplate.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'EditorTemplate.guard' => 'required|string',
                    'EditorTemplate.category' => 'required|string',
                    'EditorTemplate.title' => 'required|string',
                    'EditorTemplate.description' => 'nullable|string',
                    'EditorTemplate.editor' => 'required|string',
                    'EditorTemplate.sort' => 'nullable|integer',
                    'EditorTemplate.active' => 'required|boolean',
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
            'EditorTemplate.guard' => __('MinmaxBase::models.EditorTemplate.guard'),
            'EditorTemplate.category' => __('MinmaxBase::models.EditorTemplate.category'),
            'EditorTemplate.title' => __('MinmaxBase::models.EditorTemplate.title'),
            'EditorTemplate.description' => __('MinmaxBase::models.EditorTemplate.description'),
            'EditorTemplate.editor' => __('MinmaxBase::models.EditorTemplate.editor'),
            'EditorTemplate.sort' => __('MinmaxBase::models.EditorTemplate.sort'),
            'EditorTemplate.active' => __('MinmaxBase::models.EditorTemplate.active'),
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
