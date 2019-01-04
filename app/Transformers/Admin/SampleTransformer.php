<?php

namespace App\Transformers\Admin;

use App\Models\PasswordReset;
use App\Presenters\Admin\SamplePresenter;
use Minmax\Base\Admin\Transformer;

/**
 * Class SampleTransformer
 */
class SampleTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'sampleShow',
        'U' => 'sampleEdit',
        'D' => 'sampleDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  SamplePresenter $presenter
     * @param  string $uri
     */
    public function __construct(SamplePresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  PasswordReset $model
     * @return array
     * @throws \Throwable
     */
    public function transform(PasswordReset $model)
    {
        return [
            'ip' => $this->presenter->getGridText($model, 'ip'),
            'rule' => $this->presenter->getGridSwitch($model, 'rule'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}