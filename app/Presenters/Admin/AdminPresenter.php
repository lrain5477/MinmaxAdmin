<?php

namespace App\Presenters\Admin;

use App\Models\Role;

class AdminPresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->fieldSelection = [
            'role_id' => Role::orderBy('display_name')
                ->get()
                ->mapWithKeys(function($item, $key) {
                    return [$item->id => $item->display_name];
                })
                ->toArray(),
            'active' => $this->parameterSet
                ->firstWhere('code', '=', 'active')
                ->parameterItem()
                ->where(['active' => 1])
                ->get(['title', 'value'])
                ->mapWithKeys(function($item) {
                    /** @var \App\Models\ParameterItem $item **/
                    return [$item->value => $item->title];
                })
                ->toArray(),
        ];
    }

    /**
     * @param \App\Models\Admin $model
     * @param string $column
     * @param mixed $required
     * @param array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldRoleSelect($model, $column, $required = false, $options = [])
    {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = is_null($model->roles()->first()) ? '' : $model->roles()->first()->id;

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'value' => $fieldValue,
            'required' => $required,
            'title' => isset($options['title']) ? $options['title'] : '',
            'search' => isset($options['search']) ? $options['search'] : false,
            'size' => isset($options['size']) ? $options['size'] : 3,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
            'listData' => isset($this->fieldSelection[$column]) ? $this->fieldSelection[$column] : [],
        ];

        return view("{$this->guardName}.form-components.select", $componentData);
    }
}