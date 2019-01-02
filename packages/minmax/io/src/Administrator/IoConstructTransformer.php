<?php

namespace Minmax\Io\Administrator;

use Illuminate\Support\Facades\Storage;
use Minmax\Base\Administrator\Transformer;
use Minmax\Io\Models\IoConstruct;

/**
 * Class IoConstructTransformer
 */
class IoConstructTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  IoConstructPresenter $presenter
     * @param  string $uri
     */
    public function __construct(IoConstructPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  IoConstruct $model
     * @return array
     * @throws \Throwable
     */
    public function transform(IoConstruct $model)
    {
        $additions = [
            ['view' => 'MinmaxIo::administrator.io-construct.action-button-config'],
        ];

        if (! is_null($model->example) && $model->example != '') {
            if (Storage::exists($model->example)) {
                $additions[] = ['view' => 'MinmaxIo::administrator.io-construct.action-button-example'];
            }
        }

        return [
            'title' => $this->presenter->getGridText($model, 'title'),
            'uri' => $this->presenter->getGridText($model, 'uri'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model, $additions),
        ];
    }
}