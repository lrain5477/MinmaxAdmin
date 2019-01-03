<?php

namespace Minmax\World\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WorldLanguageRequest
 */
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
                    'WorldLanguage.code' => 'required|string',
                    'WorldLanguage.name' => 'required|string',
                    'WorldLanguage.native' => 'required|string',
                    'WorldLanguage.options.icon' => 'required|string',
                    'WorldLanguage.options.script' => 'required|string',
                    'WorldLanguage.options.regional' => 'required|string',
                    'WorldLanguage.currency_id' => 'nullable|exists:world_currency,id',
                    'WorldLanguage.sort' => 'required|integer',
                    'WorldLanguage.active_admin' => 'required|boolean',
                    'WorldLanguage.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WorldLanguage.title' => 'required|string',
                    'WorldLanguage.code' => 'required|string',
                    'WorldLanguage.name' => 'required|string',
                    'WorldLanguage.options.icon' => 'required|string',
                    'WorldLanguage.options.script' => 'required|string',
                    'WorldLanguage.options.regional' => 'required|string',
                    'WorldLanguage.currency_id' => 'nullable|exists:world_currency,id',
                    'WorldLanguage.sort' => 'nullable|integer',
                    'WorldLanguage.active_admin' => 'required|boolean',
                    'WorldLanguage.active' => 'required|boolean',
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
            'WorldLanguage.title' => __('MinmaxBase::models.WorldLanguage.title'),
            'WorldLanguage.code' => __('MinmaxBase::models.WorldLanguage.code'),
            'WorldLanguage.name' => __('MinmaxBase::models.WorldLanguage.name'),
            'WorldLanguage.options.icon' => __('MinmaxBase::models.WorldLanguage.options.icon'),
            'WorldLanguage.options.script' => __('MinmaxBase::models.WorldLanguage.options.script'),
            'WorldLanguage.options.regional' => __('MinmaxBase::models.WorldLanguage.options.regional'),
            'WorldLanguage.currency_id' => __('MinmaxBase::models.WorldLanguage.currency_id'),
            'WorldLanguage.sort' => __('MinmaxBase::models.WorldLanguage.sort'),
            'WorldLanguage.active_admin' => __('MinmaxBase::models.WorldLanguage.active_admin'),
            'WorldLanguage.active' => __('MinmaxBase::models.WorldLanguage.active'),
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
