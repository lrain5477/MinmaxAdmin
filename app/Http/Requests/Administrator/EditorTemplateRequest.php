<?php

namespace App\Http\Requests\Administrator;

use App\Helpers\LogHelper;
use Illuminate\Foundation\Http\FormRequest;

class EditorTemplateRequest extends FormRequest
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
                 return $this->user('administrator')->can('editorTemplateEdit');
             case 'POST':
                 return $this->user('administrator')->can('editorTemplateCreate');
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
                    'EditorTemplate.guard' => 'required|string',
                    'EditorTemplate.category' => 'required|string',
                    'EditorTemplate.title' => 'required|string',
                    'EditorTemplate.description' => 'required|string',
                    'EditorTemplate.editor' => 'required|string',
                    'EditorTemplate.sort' => 'required|integer',
                    'EditorTemplate.active' => 'required|in:1,0',
                ];
            case 'POST':
            default:
                return [
                    'EditorTemplate.guard' => 'required|string',
                    'EditorTemplate.category' => 'required|string',
                    'EditorTemplate.title' => 'required|string',
                    'EditorTemplate.description' => 'required|string',
                    'EditorTemplate.editor' => 'required|string',
                    'EditorTemplate.sort' => 'nullable|integer',
                    'EditorTemplate.active' => 'required|in:1,0',
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
            'EditorTemplate.guard' => __('models.EditorTemplate.guard'),
            'EditorTemplate.category' => __('models.EditorTemplate.category'),
            'EditorTemplate.title' => __('models.EditorTemplate.title'),
            'EditorTemplate.description' => __('models.EditorTemplate.description'),
            'EditorTemplate.editor' => __('models.EditorTemplate.editor'),
            'EditorTemplate.sort' => __('models.EditorTemplate.sort'),
            'EditorTemplate.active' => __('models.EditorTemplate.active'),
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
