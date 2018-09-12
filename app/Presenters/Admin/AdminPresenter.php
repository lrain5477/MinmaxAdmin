<?php

namespace App\Presenters\Admin;

use App\Models\Role;

class AdminPresenter extends Presenter
{
    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [
            'role_id' => Role::query()
                ->orderBy('display_name')
                ->get()
                ->mapWithKeys(function($item) {
                    return [$item->id => $item->display_name];
                })
                ->toArray(),
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param \App\Models\Admin $model
     * @param string $column
     * @param array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldRoleSelect($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValues = $model
            ->roles()
            ->get()
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
            'required' => $options['required'] ?? false,
            'title' => $options['title'] ?? '',
            'group' => $options['group'] ?? false,
            'size' => $options['size'] ?? 10,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
            'listData' => $this->parameterSet[$column] ?? [],
        ];

        return view("{$this->guardName}.form-components.multi-select", $componentData);
    }
}