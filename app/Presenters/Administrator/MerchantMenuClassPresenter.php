<?php

namespace App\Presenters\Administrator;

class MerchantMenuClassPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'active' => [
                '1' => __('models.MerchantMenuClass.selection.active.1'),
                '0' => __('models.MerchantMenuClass.selection.active.0'),
            ],
        ];
    }
}