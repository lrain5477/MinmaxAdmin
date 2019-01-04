<?php

namespace Minmax\Base\Web;

/**
 * Abstract class Presenter
 */
abstract class Presenter
{
    /**
     * @var string $packagePrefix
     */
    protected $packagePrefix = '';

    /**
     * @var string $uri
     */
    protected $uri = '';

    /**
     * @var array $parameterSet
     */
    protected $parameterSet = [];

    /**
     * @var array $permissionSet
     */
    protected $permissionSet = [];

    /**
     * @param  string $uri
     * @return void
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param  array $permissions
     * @param  string|array $except
     * @return void
     */
    public function setPermissions($permissions, $except = null)
    {
        $this->permissionSet = [];

        if (! is_null($except)) {
            $permissions = array_except($permissions, array_wrap($except));
        }

        foreach ($permissions as $key => $permission) {
            if(request()->user('web')->can($permission)) {
                $this->permissionSet[] = $key;
            }
        }
    }

    /**
     * @param  string $value
     * @param  bool $transLineBreak
     * @return string
     */
    public function getPureString($value, $transLineBreak = true)
    {
        return $transLineBreak
            ? nl2br(trim(strip_tags($value)))
            : trim(strip_tags($value));
    }
}
