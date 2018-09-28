<?php

namespace App\Presenters;

use Illuminate\Support\Collection;

class Presenter
{
    /** @var string $guardName **/
    protected $guardName;

    /** @var Collection $parameterSet **/
    protected $parameterSet;

    /** @var array $columnClass */
    protected $columnClass = [];

    public function __construct()
    {
        \Cache::forget('systemParams');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewNormalText($model, $column, $options = []) {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $defaultValue = $options['defaultValue'] ?? null;
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $defaultValue ?? ($model->getAttribute($column) ?? '');

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $defaultValue ?? $fieldValue[$options['subColumn']] ?? '';
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'value' => nl2br(trim(strip_tags($fieldValue))),
        ];

        return view("{$this->guardName}.view-components.normal-text", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewEditor($model, $column, $options = []) {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $defaultValue = $options['defaultValue'] ?? null;
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $defaultValue ?? ($model->getAttribute($column) ?? '');

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $defaultValue ?? $fieldValue[$options['subColumn']] ?? '';
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'value' => $fieldValue,
            'size' => $options['size'] ?? 10,
            'height' => $options['height'] ?? '250px',
            'stylesheet' => $options['stylesheet'] ?? null,
        ];

        return view("{$this->guardName}.view-components.editor", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewSelection($model, $column, $options = []) {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $defaultValue = $options['defaultValue'] ?? null;
        $fieldValue = $model->getAttribute($column) ?? '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'value' => $defaultValue ?? ($this->parameterSet[$column][$fieldValue]['title'] ?? '(not exist)'),
        ];

        return view("{$this->guardName}.view-components.normal-text", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewMultiSelection($model, $column, $options = []) {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $defaultValue = $options['defaultValue'] ?? null;
        $fieldValue = $model->getAttribute($column) ?? [];

        $parameterValue = collect($this->parameterSet[$column] ?? [])
            ->filter(function($item, $key) use ($fieldValue) {
                return array_key_exists('title', $item) && in_array($key, $fieldValue);
            })
            ->map(function($item) {
                return $item['title'] ?? '';
            })
            ->implode(', ');

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'value' => $defaultValue ?? $parameterValue,
        ];

        return view("{$this->guardName}.view-components.normal-text", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewMediaImage($model, $column, $options = []) {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $images = $model->getAttribute($column) ?? [];

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'images' => $images,
            'altShow' => isset($options['alt']) ? $options['alt'] : false,
        ];

        return view("{$this->guardName}.view-components.image-list", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldNormalText($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = $model->getAttribute($column) ?? '';

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'value' => $fieldValue,
            'plaintText' => $options['plaintText'] ?? false,
        ];

        return view("{$this->guardName}.form-components.normal-text", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldText($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'icon' => $options['icon'] ?? '',
            'size' => $options['size'] ?? 10,
            'placeholder' => $options['placeholder'] ?? '',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
        ];

        return view("{$this->guardName}.form-components.text", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldEmail($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'icon' => $options['icon'] ?? '',
            'size' => $options['size'] ?? 10,
            'placeholder' => $options['placeholder'] ?? '',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
        ];

        return view("{$this->guardName}.form-components.email", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldTel($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'icon' => $options['icon'] ?? '',
            'size' => $options['size'] ?? 10,
            'placeholder' => $options['placeholder'] ?? '',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
        ];

        return view("{$this->guardName}.form-components.tel", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldPassword($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldId = "{$modelName}-{$column}";
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldId .= '-' . $options['subColumn'];
            $fieldName .= "[{$options['subColumn']}]";
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'required' => $options['required'] ?? false,
            'icon' => $options['icon'] ?? '',
            'size' => $options['size'] ?? 10,
            'placeholder' => $options['placeholder'] ?? '',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
        ];

        return view("{$this->guardName}.form-components.password", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  string|null $defaultValue
     * @return string
     */
    public function getFieldHidden($model, $column, $defaultValue = null) {
        $modelName = class_basename($model);
        $fieldValue = $defaultValue ?? $model->getAttribute($column);

        return "<input type=\"hidden\" name=\"{$modelName}[{$column}]\" value=\"{$fieldValue}\" />";
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldDatePicker($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";
        $pickerType = $options['type'] ?? 'birthdate';

        switch($pickerType) {
            case 'birthdateTime':
                $valueTimeFormat = 'Y-m-d H:i:s';
                break;
            default:
                $valueTimeFormat = 'Y-m-d';
                break;
        }


        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => !is_null($fieldValue) && $fieldValue != '' ? date($valueTimeFormat, strtotime($fieldValue)) : '',
            'required' => $options['required'] ?? false,
            'icon' => $options['icon'] ?? '',
            'type' => $pickerType,
            'size' => $options['size'] ?? 3,
            'placeholder' => $options['placeholder'] ?? '',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
        ];

        return view("{$this->guardName}.form-components.date-picker", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldTextarea($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'size' => $options['size'] ?? 10,
            'rows' => $options['rows'] ?? 5,
            'placeholder' => $options['placeholder'] ?? '',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
        ];

        return view("{$this->guardName}.form-components.textarea", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldEditor($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'size' => $options['size'] ?? 10,
            'height' => $options['height'] ?? '250px',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'stylesheet' => $options['stylesheet'] ?? null,
            'template' => $options['template'] ?? null,
        ];

        return view("{$this->guardName}.form-components.editor", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldSelect($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'title' => $options['title'] ?? '',
            'search' => $options['search'] ?? false,
            'size' => $options['size'] ?? 3,
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'listData' => $this->parameterSet[$column] ?? [],
        ];

        return view("{$this->guardName}.form-components.select", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldGroupSelect($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'title' => $options['title'] ?? '',
            'search' => $options['search'] ?? false,
            'size' => $options['size'] ?? 3,
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'listData' => $this->parameterSet[$column] ?? [],
        ];

        return view("{$this->guardName}.form-components.group-select", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldMultiSelect($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? [];
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $model->getAttribute($column)[$options['subColumn']] ?? [];
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => "{$fieldName}[]",
            'values' => $fieldValue,
            'required' => $options['required'] ?? false,
            'title' => $options['title'] ?? '',
            'group' => $options['group'] ?? false,
            'size' => $options['size'] ?? 10,
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'listData' => $this->parameterSet[$column] ?? [],
        ];

        return view("{$this->guardName}.form-components.multi-select", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldCheckbox($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? [];
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => "{$fieldName}[]",
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'inline' => $options['inline'] ?? false,
            'color' => $options['color'] ?? '',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'listData' => $this->parameterSet[$column] ?? [],
        ];

        return view("{$this->guardName}.form-components.checkbox", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldRadio($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldId = "{$modelName}-{$column}";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldId .= '-' . $options['subColumn'];
            $fieldValue = $fieldValue[$options['subColumn']] ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => $options['required'] ?? false,
            'inline' => $options['inline'] ?? false,
            'color' => $options['color'] ?? '',
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'listData' => $this->parameterSet[$column] ?? [],
        ];

        return view("{$this->guardName}.form-components.radio", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldMediaImage($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldName = $options['name'] ?? "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? [];
        $hintPath = "models.{$modelName}.hint.{$column}";
        $lang = app()->getLocale();
        switch ($lang) {
            case 'tw':
                $lang = 'zh_TW';
                break;
            case 'cn':
                $lang = 'zh_CN';
                break;
            case 'jp':
                $lang = 'ja';
                break;
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'required' => $options['required'] ?? false,
            'limit' => $options['limit'] ?? 0,
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'lang' => $lang,
            'images' => $fieldValue,
            'additionalFields' => $options['additional'] ?? [],
        ];

        return view("{$this->guardName}.form-components.image", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldMediaFile($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = $model->getAttribute($column) ?? [];
        $hintPath = "models.{$modelName}.hint.{$column}";
        $lang = app()->getLocale();
        switch ($lang) {
            case 'tw':
                $lang = 'zh_TW';
                break;
            case 'cn':
                $lang = 'zh_CN';
                break;
            case 'jp':
                $lang = 'ja';
                break;
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'required' => $options['required'] ?? false,
            'limit' => $options['limit'] ?? 0,
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'lang' => $lang,
            'files' => $fieldValue,
        ];

        return view("{$this->guardName}.form-components.file", $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldUploadFile($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fileList = $model->getAttribute($column) ?? [];
        $hintPath = "models.{$modelName}.hint.{$column}";
        $filenameList = [];
        foreach($fileList as $fileKey => $fileItem) {
            if(!\File::exists(public_path($fileItem))) {
                unset($fileList[$fileKey]);
            } else {
                $filenameList[] = \File::basename(public_path($fileItem));
            }
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[uploads][{$column}]",
            'required' => $options['required'] ?? false,
            'limit' => $options['limit'] ?? 0,
            'hint' => isset($options['hint']) && $options['hint'] === true ? (is_string($options['hint']) ? $options['hint'] : __($hintPath)) : '',
            'path' => $options['path'] ?? 'uploads',
            'file' => implode(config('app.separate_string'), $fileList),
            'filename' => implode(', ', $filenameList),
        ];

        return view("{$this->guardName}.form-components.file-upload", $componentData);
    }
}