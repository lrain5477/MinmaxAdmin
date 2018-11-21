<?php

namespace Minmax\Base\Helpers;

class Permission
{
    /**
     * @param string $origin_name
     * @param string $replace_action
     * @return string
     */
    public static function replacePermissionName($origin_name, $replace_action)
    {
        $permissionName = '';
        if($permissionName === '' && substr($origin_name, -4) === 'Show') $permissionName = substr($origin_name, 0, -4) . $replace_action;
        if($permissionName === '' && substr($origin_name, -6) === 'Create') $permissionName = substr($origin_name, 0, -6) . $replace_action;
        if($permissionName === '' && substr($origin_name, -4) === 'Edit') $permissionName = substr($origin_name, 0, -4) . $replace_action;
        if($permissionName === '' && substr($origin_name, -7) === 'Destroy') $permissionName = substr($origin_name, 0, -7) . $replace_action;

        return $permissionName == '' ? 'You can not pass' : $permissionName;
    }
}