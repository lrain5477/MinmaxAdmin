<?php

namespace Minmax\Io\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class IoConstructRequest
 */
class IoConstructRequest extends FormRequest
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
                    'IoConstruct.title' => 'required|string',
                    'IoConstruct.uri' => [
                        'required',
                        'string',
                        Rule::unique('io_construct', 'uri')->ignore($this->route('id')),
                    ],
                    'IoConstruct.import_enable' => 'required|boolean',
                    'IoConstruct.export_enable' => 'required|boolean',
                    'IoConstruct.import_view' => 'nullable|string',
                    'IoConstruct.export_view' => 'nullable|string',
                    'IoConstruct.controller' => 'required|string',
                    'IoConstruct.example' => 'nullable|string',
                    'IoConstruct.filename' => 'nullable|string',
                    'IoConstruct.sort' => 'required|integer',
                    'IoConstruct.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'IoConstruct.title' => 'required|string',
                    'IoConstruct.uri' => 'required|string|unique:io_construct,uri',
                    'IoConstruct.import_enable' => 'required|boolean',
                    'IoConstruct.export_enable' => 'required|boolean',
                    'IoConstruct.import_view' => 'nullable|string',
                    'IoConstruct.export_view' => 'nullable|string',
                    'IoConstruct.controller' => 'required|string',
                    'IoConstruct.example' => 'nullable|string',
                    'IoConstruct.filename' => 'nullable|string',
                    'IoConstruct.sort' => 'nullable|integer',
                    'IoConstruct.active' => 'required|boolean',
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
            'IoConstruct.title' => __('MinmaxIo::models.IoConstruct.title'),
            'IoConstruct.uri' => __('MinmaxIo::models.IoConstruct.uri'),
            'IoConstruct.import_enable' => __('MinmaxIo::models.IoConstruct.import_enable'),
            'IoConstruct.export_enable' => __('MinmaxIo::models.IoConstruct.export_enable'),
            'IoConstruct.import_view' => __('MinmaxIo::models.IoConstruct.import_view'),
            'IoConstruct.export_view' => __('MinmaxIo::models.IoConstruct.export_view'),
            'IoConstruct.controller' => __('MinmaxIo::models.IoConstruct.controller'),
            'IoConstruct.example' => __('MinmaxIo::models.IoConstruct.example'),
            'IoConstruct.filename' => __('MinmaxIo::models.IoConstruct.filename'),
            'IoConstruct.sort' => __('MinmaxIo::models.IoConstruct.sort'),
            'IoConstruct.active' => __('MinmaxIo::models.IoConstruct.active'),
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
