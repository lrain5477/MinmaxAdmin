<?php

namespace Minmax\World\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WorldCountryRequest
 */
class WorldCountryRequest extends FormRequest
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
                    'WorldCountry.continent_id' => 'required|exists:world_continent,id',
                    'WorldCountry.title' => 'required|string',
                    'WorldCountry.code' => [
                        'required',
                        'string',
                        Rule::unique('world_country', 'code')->ignore($this->route('id')),
                    ],
                    'WorldCountry.name' => 'required|string',
                    'WorldCountry.language_id' => 'required|exists:world_language,id',
                    'WorldCountry.sort' => 'required|integer',
                    'WorldCountry.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WorldCountry.continent_id' => 'required|exists:world_continent,id',
                    'WorldCountry.title' => 'required|string',
                    'WorldCountry.code' => 'required|string|unique:world_country,code',
                    'WorldCountry.name' => 'required|string',
                    'WorldCountry.language_id' => 'required|exists:world_language,id',
                    'WorldCountry.sort' => 'nullable|integer',
                    'WorldCountry.active' => 'required|boolean',
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
            'WorldCountry.continent_id' => __('MinmaxWorld::models.WorldCountry.continent_id'),
            'WorldCountry.title' => __('MinmaxWorld::models.WorldCountry.title'),
            'WorldCountry.code' => __('MinmaxWorld::models.WorldCountry.code'),
            'WorldCountry.name' => __('MinmaxWorld::models.WorldCountry.name'),
            'WorldCountry.language_id' => __('MinmaxWorld::models.WorldCountry.language_id'),
            'WorldCountry.sort' => __('MinmaxWorld::models.WorldCountry.sort'),
            'WorldCountry.active' => __('MinmaxWorld::models.WorldCountry.active'),
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
