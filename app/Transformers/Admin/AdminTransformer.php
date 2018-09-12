<?php

namespace App\Transformers\Admin;

use App\Models\Admin;

class AdminTransformer extends Transformer
{
    protected $model = 'Admin';
    protected $parameterSet = [
        'active',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        if(request()->user('admin')->can('adminShow')) $this->permissions[] = 'R';
        if(request()->user('admin')->can('adminEdit')) $this->permissions[] = 'U';
        if(request()->user('admin')->can('adminDestroy')) $this->permissions[] = 'D';
    }

    /**
     * @param Admin $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Admin $model)
    {
        // Can't destroy self. So remove Destroy permission.
        $destroyFlag = in_array('D', $this->permissions);
        if($destroyFlag && $model->guid === request()->user('admin')->guid) {
            unset($this->permissions[$key = array_search('D', $this->permissions)]);
        }

        $transformerData = [
            'username' => $this->getGridText($model->username),
            'name' => $this->getGridText($model->name),
            'email' => $this->getGridText($model->email),
            'role_id' => $this->getGridText($model->roles()->get()->map(function($item) { return $item->display_name; })->implode(', ')),
            'active' => $this->getGridSwitch($model->guid, 'active', $model->active),
            'action' => $this->getGridActions($model->guid),
        ];

        // After put Destroy permission back, if it was removed at first.
        if($destroyFlag && !in_array('D', $this->permissions)) {
            $this->permissions[] = 'D';
        }

        return $transformerData;
    }
}