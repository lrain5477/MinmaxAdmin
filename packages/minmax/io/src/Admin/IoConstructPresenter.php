<?php

namespace Minmax\Io\Admin;

use Illuminate\Support\Facades\Storage;
use Minmax\Base\Admin\Presenter;

/**
 * Class IoConstructPresenter
 */
class IoConstructPresenter extends Presenter
{
    protected $packagePrefix = 'MinmaxIo::';

    protected $languageColumns = ['title', 'filename'];

    public function __construct()
    {
        parent::__construct();

        $this->parameterSet = [];
    }

    /**
     * @param  \Minmax\Io\Models\IoConstruct $model
     * @param  array $additional will format as ['permission' => 'R', 'view' => 'xxx', 'uri' => '???']
     * @return string
     */
    public function getGridActions($model, $additional = [])
    {
        $id = $model->getKey();

        $result = '';

        try {
            if (in_array('I', $this->permissionSet) || in_array('O', $this->permissionSet)) {
                $result .= view('MinmaxIo::admin.io-data.action-button-config', ['id' => $id, 'uri' => $this->uri])->render();
            }

            if (! is_null($model->example) && $model->example != '' && in_array('I', $this->permissionSet)) {
                if (Storage::exists($model->example)) {
                    $result .= view('MinmaxIo::admin.io-data.action-button-example', ['id' => $id, 'uri' => $this->uri])->render();
                }
            }
        } catch (\Throwable $e) {
            $result = '';
        }

        return $result;
    }
}