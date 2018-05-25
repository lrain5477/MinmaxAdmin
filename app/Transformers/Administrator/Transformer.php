<?php

namespace App\Transformers\Administrator;

use App\Models\ParameterGroup;
use Illuminate\Support\Carbon;
use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    protected $uri;
    protected $model;
    protected $parameters = [];
    protected $parameterSet = [];

    /**
     * Transformer constructor. Initial setting uri.
     * @param string $uri
     */
    public function __construct($uri)
    {
        $this->uri = $uri;

        $parameterGroup = ParameterGroup::where(['active' => 1])
            ->get(['guid', 'code', 'title'])
            ->filter(function($item) {
                return in_array($item->code, $this->parameterSet);
            })
            ->values();

        $this->parameters = collect($this->parameterSet)
            ->map(function($item) use ($parameterGroup) {
                return $parameterGroup->where('code', '=', $item)->count() > 0
                    ? $parameterGroup
                        ->firstWhere('code', '=', $item)
                        ->parameterItem()
                        ->get(['title', 'value', 'class'])
                        ->mapWithKeys(function($item) {
                            /** @var \App\Models\ParameterItem $item **/
                            return [
                                $item->value => [
                                    'title' => $item->getAttribute('title'),
                                    'class' => $item->getAttribute('class')
                                ]
                            ];
                        })
                        ->toArray()
                    : [];
            })
            ->toArray();
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
     * @param $id
     * @param $column
     * @param $value
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
     * @param $id
     * @return string
     * @throws \Throwable
     */
    public function getGridActions($id)
    {
        return view('administrator.grid-components.actions', [
            'id' => $id,
            'uri' => $this->uri,
            'rules' => ['R', 'U', 'D'],
        ])->render();
    }
}