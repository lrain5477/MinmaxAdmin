<?php

namespace Minmax\Base\Administrator;

use Minmax\Base\Models\WebData;

/**
 * Class WebDataTransformer
 */
class WebDataTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  WebDataPresenter $presenter
     * @param  string $uri
     */
    public function __construct(WebDataPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  WebData $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WebData $model)
    {
        return [
            'guard' => $this->presenter->getGridSelection($model, 'guard'),
            'website_name' => $this->presenter->getGridText($model, 'website_name'),
            'system_email' => $this->presenter->getGridText($model, 'system_email'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}