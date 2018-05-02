<?php

namespace App\Transformers\Admin;

use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    protected $uri;
    protected $model;

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
     * @param string $class
     * @param string $column
     * @return string
     * @throws \Throwable
     */
    public function getGridTextBadge($value, $class, $column)
    {
        return view('admin.grid-components.text-badge', [
            'value' => $value,
            'class' => $class,
            'column' => $column,
            'model' => $this->model,
            ])->render();
    }

    /**
     * @param string $value
     * @return string
     */
    public function getGridDate($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * @param string $value
     * @return string
     */
    public function getGridDatetime($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * @param string $id
     * @return string
     * @throws \Throwable
     */
    public function getGridCheckBox($id)
    {
        return view('admin.grid-components.checkbox', ['id' => $id])->render();
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
        return view('admin.grid-components.sort', [
            'id' => $id,
            'column' => $column,
            'value' => $value,
            'uri' => $this->uri,
            'model' => $this->model,
            ])->render();
    }

    /**
     * @param $id
     * @param $column
     * @param $value
     * @return string
     * @throws \Throwable
     */
    public function getGridSwitch($id, $column, $value)
    {
        return view('admin.grid-components.switch', [
            'id' => $id,
            'column' => $column,
            'value' => $value,
            'uri' => $this->uri,
            'model' => $this->model,
            ])->render();
    }

    /**
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function getGridActions($id)
    {
        return view('admin.grid-components.actions', [
            'id' => $id,
            'uri' => $this->uri,
            'rules' => ['R', 'U', 'D'],
        ])->render();
    }
}