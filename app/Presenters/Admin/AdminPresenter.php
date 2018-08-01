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
        $fieldValues = $model->roles
            ->map(function($item) {
                /** @var \App\Models\Role $item */
                return $item->id;
            })
            ->toArray();

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}][]",
            'values' => $fieldValues,
            'required' => $required,
            'title' => isset($options['title']) ? $options['title'] : '',
            'group' => isset($options['group']) ? $options['group'] : false,
            'size' => isset($options['size']) ? $options['size'] : 10,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
            'listData' => isset($this->fieldSelection[$column]) ? $this->fieldSelection[$column] : [],
        ];

        return view("{$this->guardName}.form-components.multi-select", $componentData);
    }
}