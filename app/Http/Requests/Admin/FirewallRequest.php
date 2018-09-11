<?php

namespace App\Http\Requests\Admin;

use App\Helpers\LogHelper;
use Illuminate\Foundation\Http\FormRequest;

class FirewallRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('firewallEdit');
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
                    'Firewall.rule' => 'required|in:1,0',
                    'Firewall.active' => 'required|in:1,0',
                ];
            case 'POST':
            default:
                return [
                    'Firewall.guard' => 'required|in:admin,web',
                    'Firewall.ip' => 'required|ip',
                    'Firewall.rule' => 'required|in:1,0',
                    'Firewall.active' => 'required|in:1,0',
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
            'Firewall.guard' => __('models.Firewall.guard'),
            'Firewall.ip' => __('models.Firewall.ip'),
            'Firewall.rule' => __('models.Firewall.rule'),
            'Firewall.active' => __('models.Firewall.active'),
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
