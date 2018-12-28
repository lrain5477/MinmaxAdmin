<?php

namespace Minmax\World\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WorldCountyRequest
 */
class WorldCountyRequest extends FormRequest
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
                    'WorldCounty.state_id' => 'required|exists:world_state,id',
                    'WorldCounty.title' => 'required|string',
                    'WorldCounty.code' => [
                        'required',
                        'string',
                        Rule::unique('world_county', 'code')->ignore($this->route('id')),
                    ],
                    'WorldCounty.name' => 'required|string',
                    'WorldCounty.sort' => 'required|integer',
                    'WorldCounty.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WorldCounty.state_id' => 'required|exists:world_state,id',
                    'WorldCounty.title' => 'required|string',
                    'WorldCounty.code' => 'required|string|unique:world_county,code',
                    'WorldCounty.name' => 'required|string',
                    'WorldCounty.sort' => 'nullable|integer',
                    'WorldCounty.active' => 'required|boolean',
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
            'WorldCounty.state_id' => __('MinmaxWorld::models.WorldCounty.state_id'),
            'WorldCounty.title' => __('MinmaxWorld::models.WorldCounty.title'),
            'WorldCounty.code' => __('MinmaxWorld::models.WorldCounty.code'),
            'WorldCounty.name' => __('MinmaxWorld::models.WorldCounty.name'),
            'WorldCounty.sort' => __('MinmaxWorld::models.WorldCounty.sort'),
            'WorldCounty.active' => __('MinmaxWorld::models.WorldCounty.active'),
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
