<?php

namespace Minmax\Notify\Administrator;

use Minmax\Base\Admin\AdminRepository;
use Minmax\Base\Admin\Presenter;
use Minmax\Base\Admin\WebDataRepository;

/**
 * Class NotifyEmailPresenter
 */
class NotifyEmailPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxNotify::';

    protected $languageColumns = [
        'title',
        'custom_subject', 'custom_preheader', 'custom_editor',
        'admin_subject', 'admin_preheader', 'admin_editor',
        'replacements'
    ];

    public function __construct()
    {
        parent::__construct();

        $receivers = [];
        $webReceivers = [];
        $adminReceivers = [];

        if ($webData = (new WebDataRepository)->getData('web')) {
            if (! is_null($webData->system_email)) {
                $webReceivers["web_data.system_email.{$webData->id}"] = ['title' => __('MinmaxNotify::admin.form.receivers.system') . " ({$webData->system_email})"];
            }
            if (isset($webData->contact['email'])) {
                $webReceivers["web_data.contact.{$webData->id}.email"] = ['title' => __('MinmaxNotify::admin.form.receivers.contact') . " ({$webData->contact['email']})"];
            }
        }

        foreach ((new AdminRepository)->all('username', '!=', 'sysadmin')->sortBy('name') as $adminData) {
            if (! is_null($adminData->email)) {
                $adminReceivers["admin.email.{$adminData->id}"] = ['title' => "{$adminData->name} ({$adminData->email})"];
            }
        }

        if (count($webReceivers) > 0) {
            $receivers[__('MinmaxNotify::admin.form.receivers.website')] = $webReceivers;
        }
        if (count($adminReceivers) > 0) {
            $receivers[__('MinmaxNotify::admin.form.receivers.admin')] = $adminReceivers;
        }

        $this->parameterSet = [
            'receivers' => $receivers,
            'notifiable' => systemParam('notifiable'),
            'queueable' => systemParam('queueable'),
            'active' => systemParam('active'),
        ];
    }
}