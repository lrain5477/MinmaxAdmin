<?php

namespace Minmax\World\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WorldCityRequest
 */
class WorldCityRequest extends FormRequest
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
                return $this->user('admin')->can('worldCityEdit');
            case 'POST':
                return $this->user('admin')->can('worldCityCreate');
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
                    'WorldCity.county_id' => 'required|exists:world_county,id',
                    'WorldCity.title' => 'required|string',
                    'WorldCity.code' => [
                        'required',
                        'string',
                        Rule::unique('world_city', 'code')
                            ->where('county_id', $this->input('WorldCity.county_id'))
                            ->ignore($this->route('id')),
                    ],
                    'WorldCity.name' => 'required|string',
                    'WorldCity.sort' => 'required|integer',
                    'WorldCity.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WorldCity.county_id' => 'required|exists:world_county,id',
                    'WorldCity.title' => 'required|string',
                    'WorldCity.code' => [
                        'required',
                        'string',
                        Rule::unique('world_city', 'code')
                            ->where('county_id', $this->input('WorldCity.county_id')),
                    ],
                    'WorldCity.name' => 'required|string',
                    'WorldCity.sort' => 'nullable|integer',
                    'WorldCity.active' => 'required|boolean',
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
            'WorldCity.county_id' => __('MinmaxWorld::models.WorldCity.county_id'),
            'WorldCity.title' => __('MinmaxWorld::models.WorldCity.title'),
            'WorldCity.code' => __('MinmaxWorld::models.WorldCity.code'),
            'WorldCity.name' => __('MinmaxWorld::models.WorldCity.name'),
            'WorldCity.sort' => __('MinmaxWorld::models.WorldCity.sort'),
            'WorldCity.active' => __('MinmaxWorld::models.WorldCity.active'),
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
