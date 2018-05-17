<?php

namespace App\Presenters;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class Presenter
{
    protected $guardName;
    protected $columnClass = [];
    protected $fieldRequired = [];
    protected $fieldSelection = [];

    public function getViewNormalText($model, $column, $value = '') {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = $value === '' ? (isset($model->$column) ? $model->$column : '') : $value;

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'value' => $fieldValue,
        ];

        return view("{$this->guardName}.view-components.normal-text", $componentData);
    }

    public function getViewSelection($model, $column) {
        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? __("models.{$modelName}.selection.{$column}.{$model->$column}") : '';

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
        $imageList = isset($model->$column) ? explode(env('SEPARATE_STRING', ','), $model->$column) : [];
        $altList = isset($model->$columnAlt) ? explode(env('SEPARATE_STRING', ','), $model->$columnAlt) : [];

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

    public function getFieldNormalText($model, $column, $plaintText = false) {
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

    public function getFieldText($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? $model->$column : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'value' => $fieldValue,
            'required' => $required,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 10,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
        ];

        return view("{$this->guardName}.form-components.text", $componentData);
    }

    public function getFieldEmail($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? $model->$column : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'value' => $fieldValue,
            'required' => $required,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 10,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
        ];

        return view("{$this->guardName}.form-components.email", $componentData);
    }

    public function getFieldTel($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? $model->$column : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'value' => $fieldValue,
            'required' => $required,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 10,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
        ];

        return view("{$this->guardName}.form-components.tel", $componentData);
    }

    public function getFieldPassword($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'required' => $required,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 10,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
        ];

        return view("{$this->guardName}.form-components.password", $componentData);
    }

    public function getFieldDatePicker($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? date('Y-m-d', strtotime($model->$column)) : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'value' => $fieldValue,
            'required' => $required,
            'icon' => isset($options['icon']) ? $options['icon'] : '',
            'size' => isset($options['size']) ? $options['size'] : 3,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
        ];

        return view("{$this->guardName}.form-components.date-picker", $componentData);
    }

    public function getFieldTextarea($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? $model->$column : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'value' => $fieldValue,
            'required' => $required,
            'size' => isset($options['size']) ? $options['size'] : 10,
            'rows' => isset($options['rows']) ? $options['rows'] : 5,
            'placeholder' => isset($options['placeholder']) ? $options['placeholder'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
        ];

        return view("{$this->guardName}.form-components.textarea", $componentData);
    }

    public function getFieldEditor($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? $model->$column : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'value' => $fieldValue,
            'required' => $required,
            'size' => isset($options['size']) ? $options['size'] : 10,
            'height' => isset($options['height']) ? $options['height'] : '250px',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
        ];

        return view("{$this->guardName}.form-components.editor", $componentData);
    }

    public function getFieldSelect($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? $model->$column : '';

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

    public function getFieldCheckbox($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? explode(',', $model->$column) : [];

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}][]",
            'value' => $fieldValue,
            'required' => $required,
            'inline' => isset($options['inline']) ? $options['inline'] : false,
            'color' => isset($options['color']) ? $options['color'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
            'listData' => isset($this->fieldSelection[$column]) ? $this->fieldSelection[$column] : [],
        ];

        return view("{$this->guardName}.form-components.checkbox", $componentData);
    }

    public function getFieldRadio($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $fieldValue = isset($model->$column) ? $model->$column : '';

        $componentData = [
            'id' => "{$modelName}-{$column}",
            'label' => $columnLabel,
            'name' => "{$modelName}[{$column}]",
            'value' => $fieldValue,
            'required' => $required,
            'inline' => isset($options['inline']) ? $options['inline'] : false,
            'color' => isset($options['color']) ? $options['color'] : '',
            'hint' => isset($options['hint']) && $options['hint'] == true ? __("models.{$modelName}.hint.{$column}") : '',
            'listData' => isset($this->fieldSelection[$column]) ? $this->fieldSelection[$column] : [],
        ];

        return view("{$this->guardName}.form-components.radio", $componentData);
    }

    public function getFieldMediaImage($model, $column, $required = false, $options = []) {
        if(is_array($required)) {
            $options = $required;
            $required = false;
        }

        $modelName = class_basename($model);
        $columnLabel = __("models.{$modelName}.{$column}");
        $columnAlt = "{$column}_alt";
        $imageList = isset($model->$column) ? explode(env('SEPARATE_STRING', ','), $model->$column) : [];
        $altList = isset($model->$columnAlt) ? explode(env('SEPARATE_STRING', ','), $model->$columnAlt) : [];

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
            'altName' => "{$modelName}[{$columnAlt}]",
            'required' => $required,
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
        $fileList = isset($model->$column) ? explode(env('SEPARATE_STRING', ','), $model->$column) : [];

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
}