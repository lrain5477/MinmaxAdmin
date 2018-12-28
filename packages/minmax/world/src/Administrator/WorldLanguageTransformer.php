<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\Base\Models\WorldLanguage;

/**
 * Class WorldLanguageTransformer
 */
class WorldLanguageTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  WorldLanguagePresenter $presenter
     * @param  string $uri
     */
    public function __construct(WorldLanguagePresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  WorldLanguage $model
     * @return array
     * @throws \Throwable
     */
    public function transform(WorldLanguage $model)
    {
        $isSelf = $model->code == app()->getLocale();

        return [
            'name' => $this->presenter->getGridNameWithIcon($model),
            'code' => $this->presenter->getGridText($model, 'code'),
            'sort' => $this->presenter->getGridSort($model, 'sort'),
            'active_admin' => $isSelf ? $this->presenter->getGridTextBadge($model, 'active_admin') : $this->presenter->getGridSwitch($model, 'active_admin'),
            'active' => $isSelf ? $this->presenter->getGridTextBadge($model, 'active') : $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}