<?php

namespace App\Transformers\Admin;

use App\Models\Admin;

class AdminTransformer extends Transformer
{
    protected $model = 'Admin';
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

        if(\Auth::guard('admin')->user()->can('adminShow')) $this->permissions[] = 'R';
        if(\Auth::guard('admin')->user()->can('adminEdit')) $this->permissions[] = 'U';
        if(\Auth::guard('admin')->user()->can('adminDestroy')) $this->permissions[] = 'D';
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
        if($destroyFlag && $model->guid === \Auth::guard('admin')->user()->guid) {
            unset($this->permissions[$key = array_search('D', $this->permissions)]);
        }

        $transformerData = [
            'username' => $this->getGridText($model->username),
            'name' => $this->getGridText($model->name),
            'email' => $this->getGridText($model->email),
            'role_id' => $this->getGridText($model->roles()->first()->display_name),
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