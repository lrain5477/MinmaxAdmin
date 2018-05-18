<?php

namespace App\Transformers\Admin;

use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    protected $uri;
    protected $model;

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
     * @param string $alt_text
     * @param integer $size
     * @return string
     * @throws \Throwable
     */
    public function getGridThumbnail($value, $alt_text = '', $size = 120)
    {
        return view('admin.grid-components.thumbnail', [
            'value' => $value,
            'alt' => $alt_text,
            'size' => $size,
        ])->render();
    }

    /**
     * @param string $value
     * @return string
     */
    public function getGridDate($value)
    {
        return is_null($value) ? '-' : Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * @param string $value
     * @return string
     */
    public function getGridDatetime($value)
    {
        return is_null($value) ? '-' : Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * @param string $id
     * @return string
     * @throws \Throwable
     */
    public function getGridCheckBox($id)
    {
        if(in_array('U',  $this->permissions)) {
            return view('admin.grid-components.checkbox', ['id' => $id])->render();
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
            return view('admin.grid-components.sort', [
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
            return view('admin.grid-components.switch', [
                'id' => $id,
                'column' => $column,
                'value' => $value,
                'uri' => $this->uri,
                'model' => $this->model,
            ])->render();
        } else {
            return $this->getGridText(__("models.{$this->model}.selection.{$column}.{$value}"));
        }
    }

    /**
     * @param string $id
     * @return string
     * @throws \Throwable
     */
    public function getGridActions($id)
    {
        return view('admin.grid-components.actions', [
            'id' => $id,
            'uri' => $this->uri,
            'rules' => $this->permissions,
        ])->render();
    }
}