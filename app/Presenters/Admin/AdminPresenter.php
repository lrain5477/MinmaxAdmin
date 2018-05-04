<?php

namespace App\Presenters\Admin;

use App\Models\Role;

class AdminPresenter extends Presenter
{
    public function __construct()
    {
        $this->fieldSelection = [
            'role_id' => Role::orderBy('display_name')->get()->mapWithKeys(function($item, $key) {
                return [$item->id => $item->display_name];
            }),
            'active' => [
                '1' => __('models.Admin.selection.active.1'),
                '0' => __('models.Admin.selection.active.0'),
            ],
        ];
    }

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