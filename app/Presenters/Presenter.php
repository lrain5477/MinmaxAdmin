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

    public function getFieldMediaImage(Model $model, $column, $fieldNote, $fieldLimit = 0, $useLang = false) {
        $modelName = class_basename($model);
        $columnLabel = __('siteadmin.' . $modelName . '.' . $column);
        $requiredTip = in_array($column, $this->fieldRequired) ? '<span class="text-danger ml-1">*</span>' : '';
        $limitTip = $fieldLimit == 0 ? '圖片數量不限. ' : '您只能選擇 ' . $fieldLimit . ' 張圖片. ';
        $langId = $useLang && isset($model->lang) ? ('_' . $model->lang) : '';
        $langName = $useLang && isset($model->lang) ? ('[' . $model->lang . ']') : '';

        $columnAlt = $column . '_alt';
        $imagesArray = isset($model->$column) ? explode(',', $model->$column) : [];
        $altArray = isset($model->$columnAlt) ? explode('§', str_replace(' ', '', $model->$columnAlt)) : [];

        $imagesHtml = '';
        foreach($imagesArray as $imageKey => $imagePath) {
            if($imagePath != '') {
                $altText = isset($altArray[$imageKey]) ? $altArray[$imageKey] : '';
                $imagesHtml .= <<<IMAGE
<div class="card ml-2 ui-sortable-handle" id="{$column}_{$model->lang}{$imageKey}">
    <a class="thumb" href="{$imagePath}" data-fancybox="">
        <span class="imgFill imgLiquid_bgSize imgLiquid_ready" style="background-image: url(&quot;{$imagePath}&quot;); background-size: cover; background-position: center center; background-repeat: no-repeat;">
            <img src="{$imagePath}" class="imgData" style="display: none;">
        </span>
    </a>
    <div class="btn-group btn-group-sm justify-content-center">
        <input type="hidden" class="imgData" id="{$column}{$langId}{$imageKey}" name="{$modelName}[{$column}]{$langName}[{$imageKey}]" value="{$imagePath}">
        <input type="hidden" class="altData" id="{$column}{$langId}_alt{$imageKey}" name="{$modelName}[{$column}_alt]{$langName}[{$imageKey}]" value="{$altText}">
        <button class="btn btn-outline-default open_modal_picname" type="button" title="設定" data-target="#modal_picname" data-toggle="modal" data-filename="{$imagePath}" data-alt="{$altText}" data-id="{$column}{$langId}_alt{$imageKey}"><i class="icon-wrench"></i></button>
        <button class="btn btn-outline-default delFiles imgSeetAlert delBtn" type="button" data-title="是否確認刪除" data-message="您將刪除此檔案" data-type="info" data-show-confirm-button="true" data-confirm-button-class="btn-danger" data-show-cancel-button="true" data-cancel-button-class="btn-outline-default" data-close-on-confirm="false" data-confirm-button-text="確認" data-cancel-button-text="取消" data-popup-title-success="刪除完成" data-popup-message-success="您的項目已丟進垃圾桶區" data-id="{$column}{$langId}_alt{$imageKey}"><i class="icon-trash2"></i></button>
    </div>
</div>
IMAGE;
            }
        }

        $columnHtml = <<<CELL
<div class="form-group row imageArea" data-key="pic">
    <label class="col-sm-2 col-form-label" for="">{$columnLabel}{$requiredTip}</label>
    <div class="col-sm-10">
        <button class="btn btn-secondary getImages" type="button" data-target="#modal_file" data-toggle="modal" data-field="{$column}{$langId}" ><i class="icon-pictures"></i>瀏覽媒體庫</button>
        <div style="color:#FF0000">{$limitTip}{$fieldNote}</div>
        <input type="hidden" id="isSelFile_{$column}{$langId}" value="" data-title="被選取的檔案">
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-10 offset-sm-2">
        <div class="row file-img-list" id="{$column}{$langId}_img">{$imagesHtml}</div>
    </div>
</div>
CELL;
        return $columnHtml;
    }

    public function getFieldMediaFile(Model $model, $column, $fieldNote, $fieldLimit = 1, $useLang = false) {
        $modelName = class_basename($model);
        $columnLabel = __('siteadmin.' . $modelName . '.' . $column);
        $requiredTip = in_array($column, $this->fieldRequired) ? '<span class="text-danger ml-1">*</span>' : '';
        $limitTip = $fieldLimit == 0 ? '檔案數量不限. ' : '您只能選擇 ' . $fieldLimit . ' 個檔案. ';
        $langId = $useLang && isset($model->lang) ? ('_' . $model->lang) : '';
        $langName = $useLang && isset($model->lang) ? ('[' . $model->lang . ']') : '';

        $filesArray = isset($model->$column) ? explode(',', $model->$column) : [];

        $imagesHtml = '';
        foreach($filesArray as $fileKey => $filePath) {
            if($filePath != '') {
                $imagesHtml .= <<<IMAGE
<div class="card ml-2 ui-sortable-handle" id="{$column}_{$model->lang}{$fileKey}">
    <a class="thumb" href="{$filePath}" target="_blank" title="{$filePath}">
        <span class="imgFill imgLiquid_bgSize imgLiquid_ready" style="background-image: url(&quot;/admin/images/file.png&quot;); background-size: cover; background-position: center center; background-repeat: no-repeat;">
            <img src="{$filePath}" class="imgData" style="display: none;">
        </span>
    </a>
    <div class="btn-group btn-group-sm justify-content-center">
        <button class="btn btn-outline-default delFiles imgSeetAlert delBtn" type="button" data-title="是否確認刪除" data-message="您將刪除此檔案" data-type="info" data-show-confirm-button="true" data-confirm-button-class="btn-danger" data-show-cancel-button="true" data-cancel-button-class="btn-outline-default" data-close-on-confirm="false" data-confirm-button-text="確認" data-cancel-button-text="取消" data-popup-title-success="刪除完成" data-popup-message-success="您的項目已丟進垃圾桶區" data-id="{$column}{$langId}_alt{$fileKey}"><i class="icon-trash2"></i></button>
    </div>
</div>
IMAGE;
            }
        }

        $columnHtml = <<<CELL
<div class="form-group row imageArea" data-key="pic">
    <label class="col-sm-2 col-form-label" for="">{$columnLabel}{$requiredTip}</label>
    <div class="col-sm-10">
        <button class="btn btn-secondary getFiles" type="button" data-target="#modal_file" data-toggle="modal" data-field="{$column}{$langId}" ><i class="icon-pictures"></i>瀏覽檔案庫</button>
        <div style="color:#FF0000">{$limitTip}{$fieldNote}</div>
        <input type="hidden" id="isSelFile_{$column}{$langId}" value="" data-title="被選取的檔案">
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-10 offset-sm-2">
        <div class="row file-img-list" id="{$column}{$langId}_img">{$imagesHtml}</div>
    </div>
</div>
CELL;
        return $columnHtml;
    }
}