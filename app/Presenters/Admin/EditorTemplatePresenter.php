<?php

namespace App\Presenters\Admin;

class EditorTemplatePresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'guard' => [
                'admin' => 'admin',
                'merchant' => 'merchant',
                'web' => 'web',
            ],
            'active' => [
                '1' => __('models.EditorTemplate.selection.active.1'),
                '0' => __('models.EditorTemplate.selection.active.0'),
            ],
        ];
    }
}