<?php

namespace Minmax\Base\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Minmax\Base\Helpers\Log as LogHelper;

/**
 * Class FirewallRequest
 */
class FirewallRequest extends FormRequest
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
                return $this->user('admin')->can('firewallEdit');
            case 'POST':
                return $this->user('admin')->can('firewallCreate');
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
                    'Firewall.ip' => 'required|ip',
                    'Firewall.rule' => 'required|boolean',
                    'Firewall.active' => 'required|boolean',
                ];
            case 'POST':
            default:
                return [
                    'Firewall.ip' => 'required|ip',
                    'Firewall.rule' => 'required|boolean',
                    'Firewall.active' => 'required|boolean',
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
            'Firewall.ip' => __('MinmaxBase::models.Firewall.ip'),
            'Firewall.rule' => __('MinmaxBase::models.Firewall.rule'),
            'Firewall.active' => __('MinmaxBase::models.Firewall.active'),
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
