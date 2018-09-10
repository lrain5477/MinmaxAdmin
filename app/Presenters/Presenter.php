<?php

namespace App\Presenters;

use App\Models\SystemParameter;
use Illuminate\Support\Collection;

class Presenter
{
    /** @var string $guardName **/
    protected $guardName;
    /** @var Collection $parameterSet **/
    protected $parameterSet;
    protected $columnClass = [];
    protected $fieldSelection = [];

    public function __construct()
    {
        \Cache::forget('systemParams');
    }

    public function getViewNormalText($model, $column, $value = '') {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = $value === '' ? (isset($model->$column) ? nl2br(trim(strip_tags($model->$column))) : '') : $value;

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'value' => $fieldValue,
        ];

        return view("{$this->guardName}.view-components.normal-text", $componentData);
    }

    public function getViewEditor($model, $column, $value = '', $options = []) {
        if(is_array($value)) {
            $options = $value;
            $value = '';
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = $value === '' ? (isset($model->$column) ? $model->$column : '') : $value;

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'value' => $fieldValue,
            'size' => isset($options['size']) ? $options['size'] : 10,
            'height' => isset($options['height']) ? $options['height'] : '250px',
            'stylesheet' => isset($options['stylesheet']) ? $options['stylesheet'] : null,
        ];

        return view("{$this->guardName}.view-components.editor", $componentData);
    }

    public function getViewSelection($model, $column) {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? ($this->parameterSet[$column][$model->$column] ?? __("models.{$modelName}.selection.{$column}.{$model->$column}")) : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'value' => $fieldValue,
        ];

        return view("{$this->guardName}.view-components.normal-text", $componentData);
    }

    public function getViewMediaImage($model, $column, $options = []) {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $columnAlt = "{$column}_alt";
        $imageList = isset($model->$column) ? explode(config('app.separate_string'), $model->$column) : [];
        $altList = isset($model->$columnAlt) ? explode(config('app.separate_string'), $model->$columnAlt) : [];

        $images = collect([]);
        foreach($imageList as $key => $item) {
            if($item === '' || !\File::exists(public_path($item))) continue;

            $images->push((object) [
                'path' => $item,
                'alt' => $altList[$key] ?? '',
            ]);
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'images' => $images,
            'altShow' => isset($options['alt']) ? $options['alt'] : false,
        ];

        return view("{$this->guardName}.view-components.image-list", $componentData);
    }

    public function getFieldNormalText($model, $column, $plaintText = false)
    {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? $model->$column : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'value' => $fieldValue,
            'plaintText' => $plaintText,
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 10,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 10,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 10,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'required' => isset($options['required']) ? $options['required'] : false,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 10,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
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
        $fieldValue = isset($model->$column) ? $model->$column : $defaultValue;

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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";
        $pickerType = isset($options['type']) ? $options['type'] : 'birthdate';

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
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => !is_null($fieldValue) && $fieldValue != '' ? date($valueTimeFormat, strtotime($fieldValue)) : '',
            'required' => isset($options['required']) ? $options['required'] : false,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'type' => $pickerType,
            'size' => isset($options['size']) ? $options['size'] : 3,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'size' => isset($options['size']) ? $options['size'] : 10,
            'rows' => isset($options['rows']) ? $options['rows'] : 5,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'size' => isset($options['size']) ? $options['size'] : 10,
            'height' => isset($options['height']) ? $options['height'] : '250px',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
            'stylesheet' => isset($options['stylesheet']) ? $options['stylesheet'] : null,
            'template' => isset($options['template']) ? $options['template'] : null,
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'title' => isset($options['title']) ? $options['title'] : '',
            'search' => isset($options['search']) ? $options['search'] : false,
            'size' => isset($options['size']) ? $options['size'] : 3,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
            'listData' => isset($this->parameterSet[$column]) ? $this->parameterSet[$column] : [],
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'title' => isset($options['title']) ? $options['title'] : '',
            'search' => isset($options['search']) ? $options['search'] : false,
            'size' => isset($options['size']) ? $options['size'] : 3,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
            'listData' => isset($this->parameterSet[$column]) ? $this->parameterSet[$column] : [],
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$fieldName}[]",
            'values' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'title' => isset($options['title']) ? $options['title'] : '',
            'group' => isset($options['group']) ? $options['group'] : false,
            'size' => isset($options['size']) ? $options['size'] : 10,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
            'listData' => isset($this->parameterSet[$column]) ? $this->parameterSet[$column] : [],
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$fieldName}[]",
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'inline' => isset($options['inline']) ? $options['inline'] : false,
            'color' => isset($options['color']) ? $options['color'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
            'listData' => isset($this->parameterSet[$column]) ? $this->parameterSet[$column] : [],
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
        $fieldName = isset($options['name']) ? $options['name'] : "{$modelName}[{$column}]";
        $fieldValue = $model->getAttribute($column) ?? '';
        $hintPath = "models.{$modelName}.hint.{$column}";

        if (isset($options['subColumn'])) {
            $columnLabel = __("models.{$modelName}.{$column}.{$options['subColumn']}");
            $fieldName .= "[{$options['subColumn']}]";
            $fieldValue = $fieldValue->{$options['subColumn']} ?? '';
            $hintPath .= ".{$options['subColumn']}";
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => isset($options['required']) ? $options['required'] : false,
            'inline' => isset($options['inline']) ? $options['inline'] : false,
            'color' => isset($options['color']) ? $options['color'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __($hintPath) : '',
            'listData' => isset($this->parameterSet[$column]) ? $this->parameterSet[$column] : [],
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
        $imageList = isset($model->$column) ? explode(config('app.separate_string'), $model->$column) : [];
        $altList = isset($model->{"{$column}_alt"}) ? explode(config('app.separate_string'), $model->{"{$column}_alt"}) : [];

        $images = collect([]);
        foreach($imageList as $key => $item) {
            if($item === '' || !\File::exists(public_path($item))) continue;

            $images->push((object) [
                'path' => $item,
                'alt' => $altList[$key] ?? '',
            ]);
        }

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'altName' => "{$modelName}[{$column}_alt]",
            'required' => isset($options['required']) ? $options['required'] : false,
            'limit' => isset($options['limit']) ? $options['limit'] : 0,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
            'images' => $images,
        ];

        return view("{$this->guardName}.form-components.image", $componentData);
    }

    public function getFieldMediaFile($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fileList = isset($model->$column) ? explode(config('app.separate_string'), $model->$column) : [];

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'required' => $required,
            'limit' => isset($options['limit']) ? $options['limit'] : 0,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
            'files' => $fileList,
        ];

        return view("{$this->guardName}.form-components.file", $componentData);
    }

    public function getFieldUploadFile($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fileList = isset($model->$column) ? explode(config('app.separate_string'), $model->$column) : [];
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
            'required' => $required,
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
            'limit' => isset($options['limit']) ? $options['limit'] : 0,
            'path' => $options['path'] ?? 'uploads',
            'file' => implode(config('app.separate_string'), $fileList),
            'filename' => implode(', ', $filenameList),
        ];

        return view("{$this->guardName}.form-components.file-upload", $componentData);
    }
}