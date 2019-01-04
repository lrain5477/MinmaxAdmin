<?php

namespace App\Transformers\Web;

use App\Models\PasswordReset;
use App\Presenters\Web\SamplePresenter;
use Minmax\Base\Web\Transformer;

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
            //'action' => $this->presenter->getPureString($model->id),
        ];
    }
}