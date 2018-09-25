<?php

namespace App\Http\Requests\Administrator;

use App\Helpers\LogHelper;
use Illuminate\Foundation\Http\FormRequest;

class WorldLanguageRequest extends FormRequest
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
                    'WorldLanguage.title' => 'required|string',
                    'WorldLanguage.code' => 'required|string',
                    'WorldLanguage.name' => 'required|string',
                    'WorldLanguage.icon' => 'required|string',
                    'WorldLanguage.sort' => 'required|integer',
                    'WorldLanguage.active' => 'required|in:1,0',
                ];
            case 'POST':
            default:
                return [
                    'WorldLanguage.title' => 'required|string',
                    'WorldLanguage.code' => 'required|string',
                    'WorldLanguage.name' => 'required|string',
                    'WorldLanguage.icon' => 'required|string',
                    'WorldLanguage.sort' => 'nullable|integer',
                    'WorldLanguage.active' => 'required|in:1,0',
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
            'WorldLanguage.title' => __('models.WorldLanguage.title'),
            'WorldLanguage.code' => __('models.WorldLanguage.code'),
            'WorldLanguage.name' => __('models.WorldLanguage.name'),
            'WorldLanguage.icon' => __('models.WorldLanguage.icon'),
            'WorldLanguage.sort' => __('models.WorldLanguage.sort'),
            'WorldLanguage.active' => __('models.WorldLanguage.active'),
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
