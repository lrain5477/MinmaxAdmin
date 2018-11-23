<?php

namespace Minmax\Base\Admin;

use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    protected $uri;
    protected $model;
    protected $parameters = [];
    protected $parameterSet = [];

    /**
     * @var array $permissions can include above character
     *      R - Show (Read)
     *      U - Edit (Update)
     *      D - Destroy (Delete)
     */
    protected $permissions = [];

    /**
     * Transformer constructor. Initial setting uri.
     * @param string $uri
     */
    public function __construct($uri)
    {
        $this->uri = $uri;

        foreach ($this->parameterSet as $item) {
            if ($paramArray = systemParam($item)) {
                $this->parameters[$item] = systemParam($item);
            }
        }
    }

    /**
     * @param string $value
     * @return string
     */
    public function getGridText($value)
    {
        return (string) strip_tags($value);
    }

    /**
     * @param string $value
     * @param string $column
     * @return string
     * @throws \Throwable
     */
    public function getGridTextBadge($value, $column)
    {
        return view('MinmaxBase::admin.layouts.grid.text-badge', [
            'value' => $value,
            'column' => $column,
            'model' => $this->model,
            'parameter' => $this->parameters[$column][$value] ?? null,
            ])->render();
    }

    /**
     * @param string $value
     * @param string $alt_text
     * @param integer $size
     * @return string
     * @throws \Throwable
     */
    public function getGridThumbnail($value, $alt_text = '', $size = 120)
    {
        return view('MinmaxBase::admin.layouts.grid.thumbnail', [
            'value' => $value,
            'alt' => $alt_text,
            'size' => $size,
        ])->render();
    }

    /**
     * @param string $id
     * @return string
     * @throws \Throwable
     */
    public function getGridCheckBox($id)
    {
        if(in_array('U',  $this->permissions)) {
            return view('MinmaxBase::admin.layouts.grid.checkbox', ['id' => $id])->render();
        } else {
            return $this->getGridText('-');
        }
    }

    /**
     * @param string $id
     * @param string $column
     * @param string $value
     * @return string
     * @throws \Throwable
     */
    public function getGridSort($id, $column, $value)
    {
        if(in_array('U',  $this->permissions)) {
            return view('MinmaxBase::admin.layouts.grid.sort', [
                'id' => $id,
                'column' => $column,
                'value' => $value,
                'uri' => $this->uri,
                'model' => $this->model,
            ])->render();
        } else {
            return $this->getGridText($value);
        }
    }

    /**
     * @param string $id
     * @param string $column
     * @param string $value
     * @return string
     * @throws \Throwable
     */
    public function getGridSwitch($id, $column, $value)
    {
        if(in_array('U',  $this->permissions)) {
            return view('MinmaxBase::admin.layouts.grid.switch', [
                'id' => $id,
                'column' => $column,
                'value' => $value,
                'uri' => $this->uri,
                'model' => $this->model,
                'parameter' => $this->parameters[$column][$value] ?? null,
            ])->render();
        } else {
            return $this->getGridText($this->parameters[$column][$value]['title']);
        }
    }

    /**
     * @param string $id
     * @return string
     * @throws \Throwable
     */
    public function getGridActions($id)
    {
        return view('MinmaxBase::admin.layouts.grid.actions', [
            'id' => $id,
            'uri' => $this->uri,
            'rules' => $this->permissions,
        ])->render();
    }
}