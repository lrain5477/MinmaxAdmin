<?php

namespace Minmax\World\Administrator;

use Minmax\Base\Administrator\Presenter;

/**
 * Class WorldLanguagePresenter
 */
class WorldLanguagePresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxWorld::';

    protected $languageColumns = ['native'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'currency_id' => (new WorldCurrencyRepository)->getSelectParameters(),
            'active_admin' => systemParam('active_admin'),
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param  \Minmax\Base\Models\WorldLanguage $model
     * @return string
     */
    public function getGridNameWithIcon($model)
    {
        $nameValue = $model->getAttribute('name') ?? '';
        $iconValue = array_get($model->getAttribute('options') ?? [], 'icon', '');

        $value = '<i class="mr-2 flag-icon ' . $iconValue . '"></i>' . $this->getPureString($nameValue, false);

        return $value;
    }

    /**
     * @param  \Minmax\Base\Models\WorldLanguage $model
     * @param  array $additional
     * @return string
     */
    public function getGridActions($model, $additional = [])
    {
        $id = $model->getKey();

        $result = '';

        try {
            $result .= view('MinmaxBase::administrator.layouts.grid.action-button-show', ['id' => $id, 'uri' => $this->uri])->render();

            if ($model->code != app()->getLocale()) {
                $result .= view('MinmaxBase::administrator.layouts.grid.action-button-edit', ['id' => $id, 'uri' => $this->uri])->render();
            }

            foreach ($additional as $viewItem) {
                $result .= view(array_get($viewItem, 'view', ''), ['id' => $id, 'uri' => array_get($viewItem, 'uri', $this->uri)])->render();
            }

            if ($model->code != app()->getLocale()) {
                $result .= view('MinmaxBase::administrator.layouts.grid.action-button-destroy', ['id' => $id, 'uri' => $this->uri])->render();
            }
        } catch (\Throwable $e) {
            $result = '';
        }

        return $result;
    }
}