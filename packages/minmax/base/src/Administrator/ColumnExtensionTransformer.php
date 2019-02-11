<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\ColumnExtension;

/**
 * Class ColumnExtensionTransformer
 */
class ColumnExtensionTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  ColumnExtensionPresenter $presenter
     * @param  string $uri
     */
    public function __construct(ColumnExtensionPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  ColumnExtension $model
     * @return array
     * @throws \Throwable
     */
    public function transform(ColumnExtension $model)
    {
        return [
            'table_name' => $this->presenter->getGridText($model, 'table_name'),
            'column_name' => $this->presenter->getGridText($model, 'column_name'),
            'sub_column_name' => $this->presenter->getGridText($model, 'sub_column_name'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}