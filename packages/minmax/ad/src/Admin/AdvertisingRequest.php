<?php

namespace Minmax\Ad\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class AdvertisingRequest
 */
class AdvertisingRequest extends FormRequest
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
                return $this->user('admin')->can('advertisingEdit');
            case 'POST':
                return $this->user('admin')->can('advertisingCreate');
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
                    'Advertising.title' => 'required|string',
                    'Advertising.target' => 'required|string',
                    'Advertising.link' => 'nullable|string',
                    'Advertising.details' => 'nullable|array',
                    'Advertising.start_at' => 'required|date_format:Y-m-d H:i:s',
                    'Advertising.end_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'Advertising.sort' => 'required|integer',
                    'Advertising.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'Advertising.category_id' => 'required|exists:advertising_category,id',
                    'Advertising.title' => 'required|string',
                    'Advertising.target' => 'required|string',
                    'Advertising.link' => 'nullable|string',
                    'Advertising.details' => 'nullable|array',
                    'Advertising.start_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'Advertising.end_at' => 'nullable|date_format:Y-m-d H:i:s',
                    'Advertising.sort' => 'nullable|integer',
                    'Advertising.active' => 'required|boolean',
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
            'Advertising.category_id' => __('MinmaxAd::models.Advertising.category_id'),
            'Advertising.title' => __('MinmaxAd::models.Advertising.title'),
            'Advertising.target' => __('MinmaxAd::models.Advertising.target'),
            'Advertising.link' => __('MinmaxAd::models.Advertising.link'),
            'Advertising.details' => __('MinmaxAd::models.Advertising.details'),
            'Advertising.start_at' => __('MinmaxAd::models.Advertising.start_at'),
            'Advertising.end_at' => __('MinmaxAd::models.Advertising.end_at'),
            'Advertising.sort' => __('MinmaxAd::models.Advertising.sort'),
            'Advertising.active' => __('MinmaxAd::models.Advertising.active'),
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
                    LogHelper::system('admin', $this->path(), $this->method(), '', $this->user()->username, 0, $validator->errors()->first());
                    break;
                case 'PUT':
                    LogHelper::system('admin', $this->path(), $this->method(), $this->route('id'), $this->user()->username, 0, $validator->errors()->first());
                    break;
            }
        }
    }
}
