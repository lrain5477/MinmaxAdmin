<?php

namespace Minmax\Base\Admin;

use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    /**
     * @var string $uri
     */
    protected $uri;

    /**
     * @var array $permissions can include above character
     *      R - Show (Read)
     *      C - Create (Create)
     *      U - Edit (Update)
     *      D - Destroy (Delete)
     */
    protected $permissions = [];

    /**
     * @var array $parameterSet
     */
    protected $parameterSet = [];

    /**
     * @var array $permissionSet
     */
    protected $permissionSet = [];

    /**
     * Transformer constructor. Initial setting uri and permissions.
     * @param string $uri
     */
    public function __construct($uri)
    {
        $this->uri = $uri;

        foreach ($this->permissions as $key => $permission) {
            if(request()->user('admin')->can($permission)) {
                $this->permissionSet[] = $key;
            }
        }
    }

    /**
     * @param  string $value
     * @return string
     */
    public function getPureString($value)
    {
        return (string) strip_tags($value);
    }

    /**
     * @param  string $value
     * @return string
     */
    public function getGridText($value)
    {
        return $this->getPureString($value);
    }

    /**
     * @param  string $value
     * @param  string $column
     * @return string
     * @throws \Throwable
     */
    public function getGridTextBadge($value, $column)
    {
        return view('MinmaxBase::admin.layouts.grid.text-badge', [
                'value' => $value,
                'parameter' => $this->parameterSet[$column][$value] ?? null,
            ])
            ->render();
    }

    /**
     * @param  string $value
     * @param  string $alt_text
     * @param  integer $size
     * @return string
     * @throws \Throwable
     */
    public function getGridThumbnail($value, $alt_text = '', $size = 120)
    {
        return view('MinmaxBase::admin.layouts.grid.thumbnail', [
                'value' => $value,
                'alt' => $alt_text,
                'size' => $size,
            ])
            ->render();
    }

    /**
     * @param  string|integer $id
     * @return string
     * @throws \Throwable
     */
    public function getGridCheckBox($id)
    {
        if(in_array('U',  $this->permissionSet)) {
            return view('MinmaxBase::admin.layouts.grid.checkbox', [
                    'id' => $id
                ])
                ->render();
        } else {
            return $this->getGridText('-');
        }
    }

    /**
     * @param  string|integer $id
     * @param  string $column
     * @param  string $value
     * @return string
     * @throws \Throwable
     */
    public function getGridSort($id, $column, $value)
    {
        if(in_array('U',  $this->permissionSet)) {
            return view('MinmaxBase::admin.layouts.grid.sort', [
                    'id' => $id,
                    'column' => $column,
                    'value' => $value,
                    'uri' => $this->uri,
                ])
                ->render();
        } else {
            return $this->getGridText($value);
        }
    }

    /**
     * @param  string|integer $id
     * @param  string $column
     * @param  string $value
     * @return string
     * @throws \Throwable
     */
    public function getGridSwitch($id, $column, $value)
    {
        if(in_array('U',  $this->permissionSet)) {
            return view('MinmaxBase::admin.layouts.grid.switch', [
                    'id' => $id,
                    'column' => $column,
                    'value' => $value,
                    'uri' => $this->uri,
                    'parameter' => $this->parameterSet[$column][$value] ?? null,
                ])
                ->render();
        } else {
            return $this->getGridText($this->parameterSet[$column][$value]['title']);
        }
    }

    /**
     * @param  string|integer $id
     * @return string
     * @throws \Throwable
     */
    public function getGridActions($id)
    {
        $result = '';

        if (in_array('R', $this->permissionSet)) {
            $result .= view('MinmaxBase::admin.layouts.grid.action-button-show', ['id' => $id, 'uri' => $this->uri])->render();
        }

        if (in_array('U', $this->permissionSet)) {
            $result .= view('MinmaxBase::admin.layouts.grid.action-button-edit', ['id' => $id, 'uri' => $this->uri])->render();
        }

        if (in_array('D', $this->permissionSet)) {
            $result .= view('MinmaxBase::admin.layouts.grid.action-button-destroy', ['id' => $id, 'uri' => $this->uri])->render();
        }

        return $result;
    }
}