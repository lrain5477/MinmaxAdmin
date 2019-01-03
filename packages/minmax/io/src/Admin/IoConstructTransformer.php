<?php

namespace Minmax\Io\Admin;

use Illuminate\Support\Facades\Storage;
use Minmax\Base\Admin\Transformer;
use Minmax\Io\Models\IoConstruct;

/**
 * Class IoConstructTransformer
 */
class IoConstructTransformer extends Transformer
{
    protected $permissions = [
        'I' => 'ioDataImport',
        'O' => 'ioDataExport',
    ];

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
        return [
            'sort' => $this->presenter->getGridText($model, 'sort'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}