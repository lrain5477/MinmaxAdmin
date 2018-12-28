<?php

namespace Minmax\World\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WorldContinentRequest
 */
class WorldContinentRequest extends FormRequest
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
                return $this->user('admin')->can('worldContinentEdit');
            case 'POST':
                return $this->user('admin')->can('worldContinentCreate');
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
                    'WorldContinent.title' => 'required|string',
                    'WorldContinent.code' => [
                        'required',
                        'string',
                        Rule::unique('world_continent', 'code')->ignore($this->route('id')),
                    ],
                    'WorldContinent.name' => 'required|string',
                    'WorldContinent.sort' => 'required|integer',
                    'WorldContinent.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WorldContinent.title' => 'required|string',
                    'WorldContinent.code' => 'required|string|unique:world_continent,code',
                    'WorldContinent.name' => 'required|string',
                    'WorldContinent.sort' => 'nullable|integer',
                    'WorldContinent.active' => 'required|boolean',
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
            'WorldContinent.title' => __('MinmaxWorld::models.WorldContinent.title'),
            'WorldContinent.code' => __('MinmaxWorld::models.WorldContinent.code'),
            'WorldContinent.name' => __('MinmaxWorld::models.WorldContinent.name'),
            'WorldContinent.sort' => __('MinmaxWorld::models.WorldContinent.sort'),
            'WorldContinent.active' => __('MinmaxWorld::models.WorldContinent.active'),
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
