<?php

namespace App\Transformers\Administrator;

use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    protected $uri;
    protected $model;
    protected $parameters = [];
    protected $parameterSet = [];

    /**
     * Transformer constructor. Initial setting uri.
     *
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
        return view('administrator.grid-components.text-badge', [
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
        return view('administrator.grid-components.thumbnail', [
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
        return view('administrator.grid-components.checkbox', ['id' => $id])->render();
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
        return view('administrator.grid-components.sort', [
            'id' => $id,
            'column' => $column,
            'value' => $value,
            'uri' => $this->uri,
            'model' => $this->model,
            ])->render();
    }

    /**
     * @param  integer|string $id
     * @param  string $column
     * @param  string $value
     * @return string
     * @throws \Throwable
     */
    public function getGridSwitch($id, $column, $value)
    {
        return view('administrator.grid-components.switch', [
            'id' => $id,
            'column' => $column,
            'value' => $value,
            'uri' => $this->uri,
            'model' => $this->model,
            'parameter' => $this->parameters[$column][$value] ?? null,
            ])->render();
    }

    /**
     * @param  integer|string $id
     * @param  array $rules
     * @return string
     * @throws \Throwable
     */
    public function getGridActions($id, $rules = ['R', 'U', 'D'])
    {
        return view('administrator.grid-components.actions', [
            'id' => $id,
            'uri' => $this->uri,
            'rules' => $rules,
        ])->render();
    }
}