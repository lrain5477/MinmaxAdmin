<?php

namespace Minmax\Base\Admin;

use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    /**
     * @var Presenter $presenter
     */
    protected $presenter;

    /**
     * @var array $permissions
     */
    protected $permissions = [];

    /**
     * Transformer constructor. Initial setting uri.
     * @param  string $uri
     */
    public function __construct($uri)
    {
        if (! is_null($this->presenter)) {
            $this->presenter->setUri($uri);
            $this->presenter->setPermissions($this->permissions);
        }
    }
}