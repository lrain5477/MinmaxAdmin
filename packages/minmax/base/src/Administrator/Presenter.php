<?php

namespace Minmax\Base\Administrator;

/**
 * Abstract class Presenter
 */
abstract class Presenter
{
    /**
     * @var string $packagePrefix
     */
    protected $packagePrefix = '';

    /**
     * @var string $uri
     */
    protected $uri = '';

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
     * @param  string $uri
     * @return void
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
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
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     */
    public function getGridText($model, $column, $options = [])
    {
        $columnValue = $model->getAttribute($column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $value = is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '';
        } else {
            $value = $columnValue;
        }

        return $this->getPureString($value, array_get($options, 'nl2br', true));
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     */
    public function getGridSelection($model, $column, $options = [])
    {
        $columnValue = $model->getAttribute($column) ?? '';

        if (is_bool($columnValue)) {
            $columnValue = intval($columnValue);
        }

        if ($subColumn = array_get($options, 'subColumn')) {
            $value = is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '';
            $valueText = array_get($this->parameterSet, "{$column}.{$subColumn}.{$value}.title", '');
        } else {
            $value = $columnValue;
            $valueText = array_get($this->parameterSet, "{$column}.{$value}.title", '');
        }

        return $this->getPureString($valueText, false);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     */
    public function getGridMultiSelection($model, $column, $options = [])
    {
        $columnValue = $model->getAttribute($column) ?? [];

        $titleSet = [];
        if ($subColumn = array_get($options, 'subColumn')) {
            $value = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
            foreach ($value as $singleValue) {
                $singleTitle = array_get($this->parameterSet, "{$column}.{$subColumn}.{$singleValue}.title", '');
                if ($singleTitle != '') $titleSet[] = $singleTitle;
            }
        } else {
            $value = $columnValue;
            foreach ($value as $singleValue) {
                $singleTitle = array_get($this->parameterSet, "{$column}.{$singleValue}.title", '');
                if ($singleTitle != '') $titleSet[] = $singleTitle;
            }
        }

        return $this->getPureString(implode(', ', $titleSet), false);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     */
    public function getGridTextBadge($model, $column, $options = [])
    {
        $columnValue = $model->getAttribute($column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $value = is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '';
            $parameter = array_get($this->parameterSet, "{$column}.{$subColumn}.{$value}");
        } else {
            $value = $columnValue;
            $parameter = array_get($this->parameterSet, "{$column}.{$value}");
        }

        try {
            return view('MinmaxBase::administrator.layouts.grid.text-badge', [
                    'value' => $value,
                    'parameter' => $parameter,
                ])
                ->render();
        } catch (\Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     */
    public function getGridThumbnail($model, $column, $options = [])
    {
        $columnValue = $model->getAttribute($column) ?? [];

        if ($subColumn = array_get($options, 'subColumn')) {
            $value = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
        } else {
            $value = $columnValue;
        }

        $value = $value[array_get($options, 'index', 0)] ?? [];

        try {
            return view('MinmaxBase::administrator.layouts.grid.thumbnail', [
                    'value' => str_replace(url('/'), '', array_get($value, 'path', '')),
                    'alt' => array_get($value, array_get($options, 'alt', ''), ''),
                    'size' => array_get($options, 'size', 120),
                ])
                ->render();
        } catch (\Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    public function getGridCheckBox($model)
    {
        $id = $model->getKey();

        try {
            return view('MinmaxBase::administrator.layouts.grid.checkbox', [
                    'id' => $id
                ])
                ->render();
        } catch (\Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     */
    public function getGridSort($model, $column, $options = [])
    {
        $columnValue = $model->getAttribute($column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $value = is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '';
        } else {
            $value = $columnValue;
        }

        try {
            return view('MinmaxBase::administrator.layouts.grid.sort', [
                    'id' => $model->getKey(),
                    'column' => $column,
                    'value' => $value,
                    'uri' => $this->uri,
                ])
                ->render();
        } catch (\Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     */
    public function getGridSwitch($model, $column, $options = [])
    {
        $columnValue = $model->getAttribute($column) ?? '';

        if ($subColumn = array_get($options, 'subColumn')) {
            $value = is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '';
            $value = is_bool($value) ? intval($value) : $value;
            $parameter = array_get($this->parameterSet, "{$column}.{$subColumn}.{$value}");
        } else {
            $value = is_bool($columnValue) ? intval($columnValue) : $columnValue;
            $parameter = array_get($this->parameterSet, "{$column}.{$value}");
        }

        try {
            return view('MinmaxBase::administrator.layouts.grid.switch', [
                    'id' => $model->getKey(),
                    'column' => $column,
                    'value' => $value,
                    'uri' => $this->uri,
                    'parameter' => $parameter,
                ])
                ->render();
        } catch (\Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  array $additional will format as ['view' => 'xxx', 'uri' => '???']
     * @return string
     */
    public function getGridActions($model, $additional = [])
    {
        $id = $model->getKey();

        $result = '';

        try {
            $result .= view('MinmaxBase::administrator.layouts.grid.action-button-show', ['id' => $id, 'uri' => $this->uri])->render();

            $result .= view('MinmaxBase::administrator.layouts.grid.action-button-edit', ['id' => $id, 'uri' => $this->uri])->render();

            foreach ($additional as $viewItem) {
                $result .= view(array_get($viewItem, 'view', ''), ['id' => $id, 'uri' => array_get($viewItem, 'uri', $this->uri)])->render();
            }

            $result .= view('MinmaxBase::administrator.layouts.grid.action-button-destroy', ['id' => $id, 'uri' => $this->uri])->render();
        } catch (\Exception $e) {
            return '';
        } catch (\Throwable $e) {
            $result = '';
        }

        return $result;
    }

    /**
     * @param  string $column
     * @param  string $name
     * @param  array $options
     * @return string
     */
    public function getFilterSelection($column, $name, $options = [])
    {
        try {
            return view('MinmaxBase::administrator.layouts.grid.filter-selection', [
                    'name' => $name,
                    'column' => $column,
                    'emptyLabel' => array_get($options, 'emptyLabel', 'All'),
                    'parameters' => array_get($this->parameterSet, $column, []),
                    'current' => array_get($options, 'current', ''),
                ])
                ->render();
        } catch (\Exception $e) {
            return '';
        } catch (\Throwable $e) {
            return '';
        }
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
        }

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'value' => $this->getPureString($fieldValue),
        ];

        return view('MinmaxBase::administrator.layouts.view.normal-text', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
        }

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'value' => $fieldValue,
            'size' => array_get($options, 'size', 10),
            'height' => array_get($options, 'height', '250px'),
            'stylesheet' => array_get($options, 'stylesheet'),
        ];

        return view('MinmaxBase::administrator.layouts.view.editor', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '';
            if (is_bool($fieldValue)) $fieldValue = intval($fieldValue);
            $fieldDisplay = array_get($options, 'defaultValue', array_get($this->parameterSet, "{$column}.{$subColumn}.{$fieldValue}.title", '(not exist)'));
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldValue = $columnValue;
            if (is_bool($fieldValue)) $fieldValue = intval($fieldValue);
            $fieldDisplay = array_get($options, 'defaultValue', array_get($this->parameterSet, "{$column}.{$fieldValue}.title", '(not exist)'));
        }

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'value' => $fieldDisplay,
        ];

        return view('MinmaxBase::administrator.layouts.view.normal-text', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
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
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'value' => $fieldDisplay,
        ];

        return view('MinmaxBase::administrator.layouts.view.normal-text', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldValue = is_array($columnValue) ? $columnValue : [];
        }

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'images' => $fieldValue,
            'additionalFields' => array_get($options, 'additional', []),
        ];

        return view('MinmaxBase::administrator.layouts.view.image-list', $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     * @throws \Throwable
     */
    public function getViewColumnExtension($model, $column, $options = [])
    {
        $columns = (new ColumnExtensionRepository)->getFields($model->getTable(), $column);

        $fields = '';

        try {
            foreach ($columns as $subColumnItem) {
                /** @var \Minmax\Base\Models\ColumnExtension $subColumnItem */
                $subColumn = $subColumnItem->sub_column_name;

                if (in_array($subColumn, array_get($options, 'excepts', []))) continue;

                $subOptions = $subColumnItem->options;
                $subOptions['label'] = $subColumnItem->title;

                if ($systemParam = array_pull($subOptions, 'systemParam')) {
                    $this->parameterSet[$column][$subColumn] = systemParam($systemParam);
                }

                if ($siteParam = array_pull($subOptions, 'siteParam')) {
                    $this->parameterSet[$column][$subColumn] = siteParam($siteParam);
                }

                $subMethod = null;

                switch (array_pull($subOptions, 'method')) {
                    case 'getFieldNormalText':
                    case 'getFieldText':
                    case 'getFieldEmail':
                    case 'getFieldTel':
                    case 'getFieldDatePicker':
                    case 'getFieldTextarea':
                        $subMethod = 'getViewNormalText';
                        break;
                    case 'getFieldEditor':
                        $subMethod = 'getViewEditor';
                        break;
                    case 'getFieldSelection':
                    case 'getFieldRadio':
                        $subMethod = 'getViewSelection';
                        break;
                    case 'getFieldMultiSelect':
                    case 'getFieldCheckbox':
                        $subMethod = 'getViewMultiSelection';
                        break;
                    case 'getFieldMediaImage':
                        $subMethod = 'getViewMediaImage';
                        break;
                }

                if (! is_null($subMethod)) {
                    $fields .= $this->{$subMethod}($model, $column, ['subColumn' => $subColumn] + $subOptions + $options)->render();
                }
            }
        } catch (\Exception $e) {
            $fields = '';
        }

        return $fields;
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
        }

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'value' => $fieldValue,
            'plaintText' => array_get($options, 'plaintText', false),
        ];

        return view('MinmaxBase::administrator.layouts.form.normal-text', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'type' => array_get($options, 'type', 'text'),
            'icon' => array_get($options, 'icon', ''),
            'size' => array_get($options, 'size', 10),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::administrator.layouts.form.text', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'required' => array_get($options, 'required', false),
            'icon' => array_get($options, 'icon', ''),
            'size' => array_get($options, 'size', 10),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::administrator.layouts.form.password', $componentData);
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
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
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
            'language' => in_array($column, $this->languageColumns),
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

        return view('MinmaxBase::administrator.layouts.form.date-picker', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'size' => array_get($options, 'size', 10),
            'rows' => array_get($options, 'rows', 5),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::administrator.layouts.form.textarea', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
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

        return view('MinmaxBase::administrator.layouts.form.editor', $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFieldDynamicOptionText($model, $column, $options = [])
    {
        $modelName = class_basename($model);
        $columnValue = $this->getModelValue($model, $column) ?? [];

        if ($subColumn = array_get($options, 'subColumn')) {
            $fieldId = "{$modelName}-{$column}-{$subColumn}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = array_get($options, 'defaultValue', array_get($columnValue, $subColumn, []));
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}]");
            $fieldValue = array_get($options, 'defaultValue', $columnValue);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'values' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'size' => array_get($options, 'size', 10),
            'placeholder' => array_get($options, 'placeholder', ''),
            'hint' => $hintValue,
        ];

        return view('MinmaxBase::administrator.layouts.form.dynamic-options-text', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $fieldList = array_get($this->parameterSet, "{$column}.{$subColumn}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
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
            'language' => in_array($column, $this->languageColumns),
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
            return view('MinmaxBase::administrator.layouts.form.group-select', $componentData);
        }

        return view('MinmaxBase::administrator.layouts.form.select', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}][]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, []) : []);
            $fieldList = array_get($this->parameterSet, "{$column}.{$subColumn}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
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
            'language' => in_array($column, $this->languageColumns),
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

        $type = array_get($options, 'type', 'collect');

        switch ($type) {
            case 'collect':
                return view('MinmaxBase::administrator.layouts.form.multi-collect', $componentData);
            case 'dropdown':
                $componentData['search'] = array_get($options, 'search', false);
                return view('MinmaxBase::administrator.layouts.form.multi-select', $componentData);
            default:
                return null;
        }
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}][]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, []) : []);
            $fieldList = array_get($this->parameterSet, "{$column}.{$subColumn}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? $columnValue : []);
            $fieldList = array_get($this->parameterSet, "{$column}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}";
        }

        $fieldValue = is_array($fieldValue) ? $fieldValue : [];

        foreach ($fieldValue as $key => $value) {
            if (is_bool($value)) $fieldValue[$key] = intval($value);
        }

        $hintValue = array_get($options, 'hint', false) === false
            ? ''
            : (is_string(array_get($options, 'hint')) ? array_get($options, 'hint') : __($hintPath));

        $componentData = [
            'id' => $fieldId,
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'values' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'inline' => array_get($options, 'inline', false),
            'color' => array_get($options, 'color', ''),
            'hint' => $hintValue,
            'listData' => $fieldList,
        ];

        return view('MinmaxBase::administrator.layouts.form.multi-checkbox', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = array_get($options, 'defaultValue', is_array($columnValue) ? array_get($columnValue, $subColumn, '') : '');
            $fieldList = array_get($this->parameterSet, "{$column}.{$subColumn}", []);
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
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
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'value' => $fieldValue,
            'required' => array_get($options, 'required', false),
            'inline' => array_get($options, 'inline', false),
            'color' => array_get($options, 'color', ''),
            'hint' => $hintValue,
            'listData' => $fieldList,
        ];

        return view('MinmaxBase::administrator.layouts.form.radio', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
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
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'required' => array_get($options, 'required', false),
            'limit' => array_get($options, 'limit', 0),
            'hint' => $hintValue,
            'lang' => $lang,
            'images' => $fieldValue ?? [],
            'additionalFields' => array_get($options, 'additional', []),
        ];

        return view('MinmaxBase::administrator.layouts.form.image', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[{$column}][{$subColumn}]");
            $fieldValue = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
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
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'required' => array_get($options, 'required', false),
            'limit' => array_get($options, 'limit', 0),
            'hint' => $hintValue,
            'lang' => $lang,
            'files' => $fieldValue,
        ];

        return view('MinmaxBase::administrator.layouts.form.file', $componentData);
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
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}.{$subColumn}"));
            $fieldName = array_get($options, 'name', "{$modelName}[uploads][{$column}][{$subColumn}]");
            $fieldFiles = is_array($columnValue) ? array_get($columnValue, $subColumn, []) : [];
            $hintPath = $this->packagePrefix . "models.{$modelName}.hint.{$column}.{$subColumn}";
        } else {
            $fieldId = "{$modelName}-{$column}";
            $fieldLabel = array_get($options, 'label', __($this->packagePrefix . "models.{$modelName}.{$column}"));
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
            'language' => in_array($column, $this->languageColumns),
            'label' => $fieldLabel,
            'name' => $fieldName,
            'required' => array_get($options, 'required', false),
            'limit' => array_get($options, 'limit', 0),
            'hint' => $hintValue,
            'path' => array_get($options, 'path', 'uploads'),
            'file' => implode(', ', $fieldFiles),
            'filename' => implode(', ', $filenameList),
        ];

        return view('MinmaxBase::administrator.layouts.form.file-upload', $componentData);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @param  string $column
     * @param  array $options
     * @return string
     * @throws \Throwable
     */
    public function getFieldColumnExtension($model, $column, $options = [])
    {
        $columns = (new ColumnExtensionRepository)->getFields($model->getTable(), $column);

        $fields = '';

        try {
            foreach ($columns as $subColumnItem) {
                /** @var \Minmax\Base\Models\ColumnExtension $subColumnItem */
                $subColumn = $subColumnItem->sub_column_name;
                $subOptions = $subColumnItem->options;
                $subOptions['label'] = $subColumnItem->title;

                if ($systemParam = array_pull($subOptions, 'systemParam')) {
                    $this->parameterSet[$column][$subColumn] = systemParam($systemParam);
                }

                if ($siteParam = array_pull($subOptions, 'siteParam')) {
                    $this->parameterSet[$column][$subColumn] = siteParam($siteParam);
                }

                if ($subMethod = array_pull($subOptions, 'method')) {
                    $fields .= $this->{$subMethod}($model, $column, ['subColumn' => $subColumn] + $subOptions + $options)->render();
                }
            }
        } catch (\Exception $e) {
            $fields = '';
        }

        return $fields;
    }
}
