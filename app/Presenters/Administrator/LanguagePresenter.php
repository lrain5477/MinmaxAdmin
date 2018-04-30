<?php

namespace App\Presenters\Administrator;

class LanguagePresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'active' => [
                '0' => __('models.Language.selection.active.0'),
                '1' => __('models.Language.selection.active.1'),
            ],
        ];
    }
}