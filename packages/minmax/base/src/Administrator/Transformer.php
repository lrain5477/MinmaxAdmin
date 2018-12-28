<?php

namespace Minmax\Base\Administrator;

use League\Fractal\TransformerAbstract;

/**
 * Class Transformer
 */
class Transformer extends TransformerAbstract
{
    /**
     * @var Presenter $presenter
     */
    protected $presenter;

    /**
     * Transformer constructor. Initial setting uri.
     * @param  string $uri
     */
    public function __construct($uri)
    {
        if (! is_null($this->presenter)) {
            $this->presenter->setUri($uri);
        }
    }
}