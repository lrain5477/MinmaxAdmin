<?php

namespace Minmax\World\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class WorldStateRequest
 */
class WorldStateRequest extends FormRequest
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
                return $this->user('admin')->can('worldStateEdit');
            case 'POST':
                return $this->user('admin')->can('worldStateCreate');
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
                    'WorldState.country_id' => 'required|exists:world_country,id',
                    'WorldState.title' => 'required|string',
                    'WorldState.code' => [
                        'required',
                        'string',
                        Rule::unique('world_state', 'code')->ignore($this->route('id')),
                    ],
                    'WorldState.name' => 'required|string',
                    'WorldState.sort' => 'required|integer',
                    'WorldState.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'WorldState.country_id' => 'required|exists:world_country,id',
                    'WorldState.title' => 'required|string',
                    'WorldState.code' => 'required|string|unique:world_state,code',
                    'WorldState.name' => 'required|string',
                    'WorldState.sort' => 'nullable|integer',
                    'WorldState.active' => 'required|boolean',
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
            'WorldState.country_id' => __('MinmaxWorld::models.WorldState.country_id'),
            'WorldState.title' => __('MinmaxWorld::models.WorldState.title'),
            'WorldState.code' => __('MinmaxWorld::models.WorldState.code'),
            'WorldState.name' => __('MinmaxWorld::models.WorldState.name'),
            'WorldState.sort' => __('MinmaxWorld::models.WorldState.sort'),
            'WorldState.active' => __('MinmaxWorld::models.WorldState.active'),
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
