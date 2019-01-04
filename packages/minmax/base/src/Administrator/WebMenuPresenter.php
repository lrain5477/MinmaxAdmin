<?php

namespace Minmax\Base\Administrator;

/**
 * Class WebMenuPresenter
 */
class WebMenuPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxBase::';

    protected $languageColumns = ['title'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'parent_id' => (new WebMenuRepository)->getSelectParameters(),
            'permission_key' => (new PermissionRepository)->getSelectParameters('web'),
            'options' => [
                'target' => systemParam('target')
            ],
            'editable' => systemParam('editable'),
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param  \Minmax\Base\Models\WebMenu $model
     * @return string
     */
    public function getGridLinkTitle($model)
    {
        $columnValue = '';
        $valueTitle = $this->getPureString($model->getAttribute('title') ?? '');
        $valueLink  = $model->getAttribute('link') ?? '';

        if ($valueTitle != '') {
            $columnValue = $valueTitle;
            if ($valueLink != '') {
                if (preg_match('/^(http|https):\/\//i', $valueLink) !== 1 && preg_match('/^www\./i', $valueLink) !== 1) {
                    $valueLink = url($valueLink);
                }
                $columnValue = '<a href="' . $valueLink . '" target="_blank">' . $valueTitle . '</a>';
            }
        }

        return $columnValue;
    }
}