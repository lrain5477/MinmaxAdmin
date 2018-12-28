<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\EditorTemplate;

/**
 * Class EditorTemplateTransformer
 */
class EditorTemplateTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  EditorTemplatePresenter $presenter
     * @param  string $uri
     */
    public function __construct(EditorTemplatePresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  EditorTemplate $model
     * @return array
     * @throws \Throwable
     */
    public function transform(EditorTemplate $model)
    {
        return [
            'guard' => $this->presenter->getGridSelection($model, 'guard'),
            'category' => $this->presenter->getGridText($model, 'category'),
            'title' => $this->presenter->getGridText($model, 'title'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}