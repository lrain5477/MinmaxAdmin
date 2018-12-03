<?php

namespace Minmax\Base\Admin;

use Minmax\Base\Models\Admin;

class AdminTransformer extends Transformer
{
    protected $permissions = [
        'R' => 'adminShow',
        'U' => 'adminEdit',
        'D' => 'adminDestroy',
    ];

    /**
     * Transformer constructor. Put action permissions.
     * @param string $uri
     */
    public function __construct($uri)
    {
        parent::__construct($uri);

        $this->parameterSet = [
            'active' => systemParam('active'),
        ];
    }

    /**
     * @param Admin $model
     * @return array
     * @throws \Throwable
     */
    public function transform(Admin $model)
    {
        $isSelf = $model->id === request()->user('admin')->id;

        // Can't destroy self. So remove Destroy permission.
        $destroyFlag = in_array('D', $this->permissionSet);
        if($destroyFlag && $isSelf) {
            unset($this->permissionSet[$key = array_search('D', $this->permissionSet)]);
        }

        $transformerData = [
            'username' => $this->getGridText($model->username),
            'name' => $this->getGridText($model->name),
            'email' => $this->getGridText($model->email),
            'role_id' => $this->getGridText($model->roles()->get()->pluck('display_name')->implode(', ')),
            'active' => $isSelf
                ? $this->getGridTextBadge($model->active, 'active')
                : $this->getGridSwitch($model->id, 'active', $model->active),
            'action' => $this->getGridActions($model->id),
        ];

        // After put Destroy permission back, if it was removed at first.
        if($destroyFlag && !in_array('D', $this->permissionSet)) {
            $this->permissionSet[] = 'D';
        }

        return $transformerData;
    }
}