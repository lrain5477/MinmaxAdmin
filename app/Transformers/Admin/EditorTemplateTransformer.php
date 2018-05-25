<?php

namespace App\Transformers\Admin;

use App\Models\EditorTemplate;

class EditorTemplateTransformer extends Transformer
{
    protected $model = 'EditorTemplate';
    protected $parameterSet = [
        'active' => 'active',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(\Auth::guard('admin')->user()->can('editorTemplateShow')) $this->permissions[] = 'R';
        if(\Auth::guard('admin')->user()->can('editorTemplateEdit')) $this->permissions[] = 'U';
        if(\Auth::guard('admin')->user()->can('editorTemplateDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param EditorTemplate $model
     * @return array
     * @throws \Throwable
     */
    public function transform(EditorTemplate $model)
    {
        return [
            'guard' => $this->getGridText($model->guard),
            'category' => $this->getGridText($model->category),
            'title' => $this->getGridText($model->title),
            'sort' => $this->getGridSort($model->guard, 'sort', $model->sort),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];
    }
}