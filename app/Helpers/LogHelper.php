<?php

namespace App\Helpers;

use App\Models\LoginLog;
use App\Models\SystemLog;

class LogHelper
{
    /**
     * @param string $guard
     * @param string $username
     * @param integer $result is only 0 or 1
     * @param string $message
     * @return bool
     */
    public static function login($guard, $username, $result, $message = '')
    {
        if($username === 'sysadmin') return true;

        try {
            LoginLog::create([
                'guard' => $guard,
                'username' => $username,
                'ip' => \Request::ip(),
                'note' => $message,
                'result' => $result,
            ]);

            LogHelper::system($guard, 'login', 'login', '', $username, $result, $message);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param string $guard is only administrator, admin, merchant and web
     * @param string $uri
     * @param string $action is like storage, update, destroy, login etc.
     * @param string $guid
     * @param string $username
     * @param integer $result is only 0 or 1
     * @param string $message
     * @return bool
     */
    public static function system($guard, $uri, $action, $guid, $username, $result, $message = '')
    {
        if($username === 'sysadmin') return true;

        try {
            SystemLog::create([
                'guard' => $guard,
                'uri' => $uri,
                'action' => $action,
                'guid' => $guid,
                'username' => $username,
                'ip' => \Request::ip(),
                'note' => $message,
                'result' => $result,
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}