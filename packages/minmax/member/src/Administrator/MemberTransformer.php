<?php

namespace Minmax\Member\Administrator;

use Minmax\Base\Administrator\Transformer;
use Minmax\Member\Models\Member;

/**
 * Class MemberTransformer
 */
class MemberTransformer extends Transformer
{
    /**
     * Transformer constructor. Put action permissions.
     * @param  MemberPresenter $presenter
     * @param  string $uri
     */
    public function __construct(MemberPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  Member $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Member $model)
    {
        return [
            'username' => $this->presenter->getGridText($model, 'username'),
            'name' => $this->presenter->getGridText($model, 'name'),
            'role_id' => $this->presenter->getPureString($model->roles->pluck('display_name')->implode(', ')),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'created_at' => $this->presenter->getGridText($model, 'created_at'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}