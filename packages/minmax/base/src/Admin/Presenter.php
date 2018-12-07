<?php

namespace Minmax\Base\Admin;

class Presenter
{
    /**
     * @var string $packagePrefix
     */
    protected $packagePrefix = '';

    /**
     * @var array $parameterSet
     */
    protected $parameterSet = [];

    /**
     * @var array $languageColumns
     */
    protected $languageColumns = [];

    /**
     * @var string $currentLanguage
     */
    protected $currentLanguage;

    /**
     * Presenter constructor.
     */
    public function __construct()
    {
        $this->currentLanguage = session('admin-formLocal', app()->getLocale());
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @return mixed
     */
    protected function getModelValue($model, $column)
    {
        $originalValue = $model->getAttribute($column);

        if (in_array($column, $this->languageColumns)) {
            if (is_array($originalValue)) {
                $value = json_decode(langDB("{$model->getTable()}.{$column}.{$model->getKey()}", false, $this->currentLanguage) ?? '[]', true);
            } else {
                $value = langDB("{$model->getTable()}.{$column}.{$model->getKey()}", false, $this->currentLanguage) ?? '';
            }
        } else {
            $value = $originalValue;
        }

        return $value;
    }

    /**
     * @param  string $value
     * @param  bool $transLineBreak
     * @return string
     */
    public function getPureString($value, $transLineBreak = true)
    {
        return $transLineBreak
            ? nl2br(trim(strip_tags($value)))
            : trim(strip_tags($value));
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewNormalText($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'value' => $this->getPureString($fieldValue),
        ];

        return view('MinmaxBase::admin.layouts.view.normal-text', $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewEditor($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'value' => $fieldValue,
            'size' => array_get($options, 'size', 10),
            'height' => array_get($options, 'height', '250px'),
            'stylesheet' => array_get($options, 'stylesheet'),
        ];

        return view('MinmaxBase::admin.layouts.view.editor', $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewSelection($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '';
            $fieldDisplay = array_get($options, 'defaultValue', array_get($this->parameterSet, "{$column}.{$subColumn}.{$fieldValue}.title", '(not exist)'));
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldValue = $columnValue;
            $fieldDisplay = array_get($options, 'defaultValue', array_get($this->parameterSet, "{$column}.{$fieldValue}.title", '(not exist)'));
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'value' => $fieldDisplay,
        ];

        return view('MinmaxBase::admin.layouts.view.normal-text', $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewMultiSelection($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnValue = $this->getModelValue($model, $column);

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
            $fieldDisplay = array_get($options, 'defaultValue',
                collect(array_get($this->parameterSet, "{$column}.{$subColumn}", []))
                    ->filter(function($item, $key) use ($fieldValue) {
                        return array_key_exists('title', $item) && in_array($key, $fieldValue);
                    })
                    ->pluck('title')
                    ->implode(', ')
            );
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldValue = is_array($columnValue) ? $columnValue : [];
            $fieldDisplay = array_get($options, 'defaultValue',
                collect(array_get($this->parameterSet, "{$column}", []))
                    ->filter(function($item, $key) use ($fieldValue) {
                        return array_key_exists('title', $item) && in_array($key, $fieldValue);
                    })
                    ->pluck('title')
                    ->implode(', ')
            );
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'value' => $fieldDisplay,
        ];

        return view('MinmaxBase::admin.layouts.view.normal-text', $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewMediaImage($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnValue = $this->getModelValue($model, $column);

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldValue = is_array($columnValue) ? $columnValue : [];
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'images' => $fieldValue,
            'additionalFields' => array_get($options, 'additional', []),
        ];

        return view('MinmaxBase::admin.layouts.view.image-list', $componentData);
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'value' => $fieldValue,
            'plaintText' => array_get($options, 'plaintText', false),
        ];

        return view('MinmaxBase::admin.layouts.form.normal-text', $componentData);
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'icon' => array_get($options, 'icon', ''),
            'size' => array_get($options, 'size', 10),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::admin.layouts.form.text', $componentData);
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'icon' => array_get($options, 'icon', ''),
            'size' => array_get($options, 'size', 10),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::admin.layouts.form.email', $componentData);
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'icon' => array_get($options, 'icon', ''),
            'size' => array_get($options, 'size', 10),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::admin.layouts.form.tel', $componentData);
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

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'required' => array_get($options, 'required', false),
            'icon' => array_get($options, 'icon', ''),
            'size' => array_get($options, 'size', 10),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::admin.layouts.form.password', $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     */
    public function getFieldHidden($model, $column, $options = []) {
        $modelName = class_basename($model);
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
        } else {
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
        }

        return "<input type=\"hidden\" name=\"{$fieldName}]\" value=\"{$fieldValue}\" />";
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        switch(array_get($options, 'type', 'date')) {
            case 'datetime':
                $pickerType = 'birthdateTime';
                $fieldValue = (! is_null($fieldValue) && $fieldValue != '') ? date('Y-m-d H:i:s', strtotime($fieldValue)) : $fieldValue;
                break;
            case 'date':
            default:
                $pickerType = 'birthdate';
                $fieldValue = (! is_null($fieldValue) && $fieldValue != '') ? date('Y-m-d', strtotime($fieldValue)) : $fieldValue;
                break;
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'icon' => array_get($options, 'icon', ''),
            'type' => $pickerType,
            'size' => array_get($options, 'size', 10),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::admin.layouts.form.date-picker', $componentData);
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'size' => array_get($options, 'size', 10),
            'rows' => array_get($options, 'rows', 5),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::admin.layouts.form.textarea', $componentData);
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'size' => array_get($options, 'size', 10),
            'height' => array_get($options, 'height', '250px'),
            'hint' => $hintValue,
            'stylesheet' => array_get($options, 'stylesheet'),
            'template' => array_get($options, 'template'),
        ];

        return view('MinmaxBase::admin.layouts.form.editor', $componentData);
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $fieldList = array_get($this->parameterSet, "{$column}.{$subColumn}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $fieldList = array_get($this->parameterSet, "{$column}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'title' => array_get($options, 'title', ''),
            'search' => array_get($options, 'search', false),
            'size' => array_get($options, 'size', 3),
            'hint' => $hintValue,
            'listData' => $fieldList,
        ];

        if (array_get($options, 'group', false)) {
            return view('MinmaxBase::admin.layouts.form.group-select', $componentData);
        }

        return view('MinmaxBase::admin.layouts.form.select', $componentData);
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
        $columnValue = $this->getModelValue($model, $column);

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn][]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, []) : []);
            $fieldList = array_get($this->parameterSet, "{$column}.{$subColumn}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? $columnValue : []);
            $fieldList = array_get($this->parameterSet, "{$column}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'values' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'title' => array_get($options, 'title', ''),
            'group' => array_get($options, 'group', false),
            'size' => array_get($options, 'size', 10),
            'hint' => $hintValue,
            'listData' => $fieldList,
        ];

        return view('MinmaxBase::admin.layouts.form.multi-select', $componentData);
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
        $columnValue = $this->getModelValue($model, $column);

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn][]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, []) : []);
            $fieldList = array_get($this->parameterSet, "{$column}.{$subColumn}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? $columnValue : []);
            $fieldList = array_get($this->parameterSet, "{$column}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        foreach ($fieldValue as $key => $value) {
            if (is_bool($value)) $fieldValue[$key] = intval($value);
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'inline' => array_get($options, 'inline', false),
            'color' => array_get($options, 'color', ''),
            'hint' => $hintValue,
            'listData' => $fieldList,
        ];

        return view('MinmaxBase::admin.layouts.form.checkbox', $componentData);
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
        $columnValue = $this->getModelValue($model, $column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $fieldList = array_get($this->parameterSet, "{$column}.{$subColumn}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $fieldList = array_get($this->parameterSet, "{$column}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        if (is_bool($fieldValue)) {
            $fieldValue = intval($fieldValue);
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'inline' => array_get($options, 'inline', false),
            'color' => array_get($options, 'color', ''),
            'hint' => $hintValue,
            'listData' => $fieldList,
        ];

        return view('MinmaxBase::admin.layouts.form.radio', $componentData);
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
        $columnValue = $this->getModelValue($model, $column);

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = is_array($columnValue) ? $columnValue : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        switch (app()->getLocale()) {
            case 'zh-Hant':
                $lang = 'zh_TW';
                break;
            case 'zh-Hans':
                $lang = 'zh_CN';
                break;
            case 'jp':
                $lang = 'jp';
                break;
            default:
                $lang = app()->getLocale();
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'required' => array_get($options, 'required', false),
            'limit' => array_get($options, 'limit', 0),
            'hint' => $hintValue,
            'lang' => $lang,
            'images' => $fieldValue,
            'additionalFields' => array_get($options, 'additional', []),
        ];

        return view('MinmaxBase::admin.layouts.form.image', $componentData);
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
        $columnValue = $this->getModelValue($model, $column);

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][$subColumn]");
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = is_array($columnValue) ? $columnValue : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        switch (app()->getLocale()) {
            case 'zh-Hant':
                $lang = 'zh_TW';
                break;
            case 'zh-Hans':
                $lang = 'zh_CN';
                break;
            case 'jp':
                $lang = 'jp';
                break;
            default:
                $lang = app()->getLocale();
        }

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'required' => array_get($options, 'required', false),
            'limit' => array_get($options, 'limit', 0),
            'hint' => $hintValue,
            'lang' => $lang,
            'files' => $fieldValue,
        ];

        return view('MinmaxBase::admin.layouts.form.file', $componentData);
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
        $columnValue = $this->getModelValue($model, $column);

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}");
            $fieldName = array_get($options, 'name', "{$modelName}[uploads][{$column}][$subColumn]");
            $fieldFiles = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = __($this->packagePrefix . "models.{$modelName}.{$column}");
            $fieldName = array_get($options, 'name', "{$modelName}[uploads][{$column}]");
            $fieldFiles = is_array($columnValue) ? $columnValue : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $filenameList = [];
        foreach($fieldFiles as $fileKey => $fileItem) {
            if(!\File::exists(public_path($fileItem))) {
                unset($fieldFiles[$fileKey]);
            } else {
                $filenameList[] = \File::basename(public_path($fileItem));
            }
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'label' => $fieldLabel,
            'name' => $fieldName,
            'required' => array_get($options, 'required', false),
            'limit' => array_get($options, 'limit', 0),
            'hint' => $hintValue,
            'path' => array_get($options, 'path', 'uploads'),
            'file' => implode(', ', $fieldFiles),
            'filename' => implode(', ', $filenameList),
        ];

        return view('MinmaxBase::admin.layouts.form.file-upload', $componentData);
    }
}
