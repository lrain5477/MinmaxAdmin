<?php

namespace Minmax\Member\Admin;

use Minmax\Base\Admin\Transformer;
use Minmax\Member\Models\MemberTerm;

/**
 * Class MemberTermTransformer
 */
class MemberTermTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'memberTermShow',
        'U' => 'memberTermEdit',
        'D' => 'memberTermDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param  MemberTermPresenter $presenter
     * @param  string $uri
     */
    public function __construct(MemberTermPresenter $presenter, $uri)
    {
        $this->presenter = $presenter;

        parent::__construct($uri);
    }

    /**
     * @param  MemberTerm $model
     * @return array
     * @throws \Throwable
     */
    public function transform(MemberTerm $model)
    {
        return [
            'id' => $this->presenter->getGridCheckBox($model),
            'title' => $this->presenter->getGridText($model, 'title'),
            'start_at' => $this->presenter->getGridText($model, 'start_at'),
            'end_at' => $this->presenter->getGridText($model, 'end_at'),
            'active' => $this->presenter->getGridSwitch($model, 'active'),
            'action' => $this->presenter->getGridActions($model),
        ];
    }
}