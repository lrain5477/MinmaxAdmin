<?php

namespace Minmax\Base\Helpers;

class Log
{
    const IGNORE_USERS = ['sysadmin'];

    /**
     * @param string $guard
     * @param \Illuminate\Http\Request $request
     * @param string $username
     * @param integer $result is only 0 or 1
     * @param string $message
     * @return bool
     */
    public static function login($guard, $request, $username, $result, $message = '')
    {
        if(in_array($username, static::IGNORE_USERS)) return true;

        try {
            $insertResult = \DB::table('login_log')->insert([
                'guard' => $guard,
                'username' => $username,
                'ip' => request()->ip(),
                'remark' => $message,
                'result' => $result,
            ]);

            if ($insertResult && static::system($guard, $request->path(), $request->method(), $username, $username, $result, $message)) {
                return true;
            }
        } catch (\Exception $e) {}

        return false;
    }

    /**
     * @param string $guard is only administrator, admin, merchant and web
     * @param string $uri
     * @param string $action is like storage, update, destroy, login etc.
     * @param string $id
     * @param string $username
     * @param integer $result is only 0 or 1
     * @param string $message
     * @return bool
     */
    public static function system($guard, $uri, $action, $id, $username, $result, $message = '')
    {
        if(in_array($username, static::IGNORE_USERS)) return true;

        try {
            return \DB::table('system_log')->insert([
                'guard' => $guard,
                'uri' => $uri,
                'action' => $action,
                'id' => $id,
                'username' => $username,
                'ip' => request()->ip(),
                'remark' => $message,
                'result' => strval($result),
            ]);
        } catch (\Exception $e) {}

        return false;
    }
}