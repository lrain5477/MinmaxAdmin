<?php

namespace Minmax\World\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WorldCurrencyRequest
 */
class WorldCurrencyRequest extends FormRequest
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
                    'WorldCurrency.code' => [
                        'required',
                        'string',
                        Rule::unique('world_currency', 'code')
                            ->ignore($this->route('id')),
                    ],
                    'WorldCurrency.name' => 'required|string',
                    'WorldCurrency.options.symbol' => 'required|string',
                    'WorldCurrency.options.native' => 'required|string',
                    'WorldCurrency.options.exchange' => 'required|string',
                    'WorldCurrency.sort' => 'required|integer',
                    'WorldCurrency.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WorldCurrency.code' => 'required|string|unique:world_currency,code',
                    'WorldCurrency.name' => 'required|string',
                    'WorldCurrency.options.symbol' => 'required|string',
                    'WorldCurrency.options.native' => 'required|string',
                    'WorldCurrency.options.exchange' => 'required|string',
                    'WorldCurrency.sort' => 'nullable|integer',
                    'WorldCurrency.active' => 'required|boolean',
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
            'WorldCurrency.code' => __('MinmaxWorld::models.WorldCurrency.code'),
            'WorldCurrency.name' => __('MinmaxWorld::models.WorldCurrency.name'),
            'WorldCurrency.options.symbol' => __('MinmaxWorld::models.WorldCurrency.options.symbol'),
            'WorldCurrency.options.native' => __('MinmaxWorld::models.WorldCurrency.options.native'),
            'WorldCurrency.options.exchange' => __('MinmaxWorld::models.WorldCurrency.options.exchange'),
            'WorldCurrency.sort' => __('MinmaxWorld::models.WorldCurrency.sort'),
            'WorldCurrency.active' => __('MinmaxWorld::models.WorldCurrency.active'),
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
