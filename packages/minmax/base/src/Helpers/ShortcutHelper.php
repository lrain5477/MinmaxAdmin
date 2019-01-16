<?php

if (! function_exists('uuidl')) {
    /**
     * Create a custom length uuid.
     *
     * @param  integer  $length
     * @return string
     */
    function uuidl($length = 16)
    {
        $generateUuid = \Illuminate\Support\Str::uuid();
        $generateTime = strtolower(base_convert(time(), 10, 16));
        $skipIndex = [3, 4, 7, 8, 9, 10, 13, 14];
        $upperIndex = [];
        $collectedIndex = [];

        for($i = 0; $i < ceil($length / 2); $i++) {
            do {
                $randomIndex = rand(0, $length - 1);
            } while (in_array($randomIndex, $upperIndex));

            $upperIndex[] = $randomIndex;
        }

        do {
            $randomIndex = rand(0, strlen($generateUuid) - 1);
            if (!in_array($randomIndex, $collectedIndex) && substr($generateUuid, $randomIndex, 1) !== '-') {
                $collectedIndex[] = $randomIndex;
            }
        } while (count($collectedIndex) < $length);

        sort($collectedIndex);

        $uuidString = '';
        foreach ($collectedIndex as $arrayKey => $index) {
            $uuidString .= in_array($arrayKey, $skipIndex)
                ? substr($generateTime, array_search($arrayKey, $skipIndex), 1)
                : substr($generateUuid, $index, 1);
        }

        foreach ($upperIndex as $index) {
            $originalCharacter = substr($uuidString, $index, 1);
            $uuidString = substr_replace($uuidString, strtoupper($originalCharacter), $index, 1);
        }

        return $uuidString;
    }
}

if (! function_exists('langId')) {
    /**
     * Get a language id via language code.
     *
     * @param  string  $code
     * @return string
     */
    function langId($code)
    {
        /** @var array $langMap */
        $langMap = Cache::rememberForever('langId', function() {
            try {
                $langTable = DB::table('world_language')
                    ->where('active', '1')
                    ->orderBy('sort')
                    ->select(['id', 'code'])
                    ->get();
                return $langTable
                    ->mapWithKeys(function ($item) { return [$item->code => $item->id]; })
                    ->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });

        return $langMap[$code] ?? '';
    }
}

if (! function_exists('langDB')) {
    /**
     * Get a local content from database via key.
     *
     * @param  string  $key
     * @param  bool  $showKey
     * @param  string  $langKey
     * @return string
     */
    function langDB($key, $showKey = false, $langKey = null)
    {
        $langKey = $langKey ?? app()->getLocale();

        if (config('app.env') != 'production') Cache::forget("langMap.{$langKey}");

        /** @var array $langMap */
        $langMap = Cache::rememberForever("langMap.{$langKey}", function() use ($langKey) {
            try {
                $langTable = DB::table('language_resource')
                    ->where('language_id', langId($langKey))
                    ->orderBy('key')
                    ->select(['key', 'text'])
                    ->get();
                return $langTable
                    ->mapWithKeys(function ($item) { return [$item->key => $item->text]; })
                    ->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });

        return $langMap[$key] ?? ($showKey ? $key : null);
    }
}

if (! function_exists('langRoute')) {
    /**
     * Get a local content from database via key.
     *
     * @param  string  $name
     * @param  array  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function langRoute($name, $parameters = [], $absolute = true)
    {
        if (is_null($name) || $name == '') return '';

        $newNameSet = [];
        $nameSet = explode('.', $name);

        foreach ($nameSet as $index => $uri) {
            if ($index == 0) {
                $newNameSet[] = $uri;
                $newNameSet[] = app()->getLocale();
            } else {
                $newNameSet[] = $uri;
            }
        }

        return route(implode('.', $newNameSet), $parameters, $absolute);
    }
}

if (! function_exists('saveLang')) {
    /**
     * Save (update or insert) a local content to database via key.
     *
     * @param  string  $key
     * @param  string  $value
     * @param  string  $langKey
     * @return bool
     */
    function saveLang($key, $value, $langKey = null)
    {
        $langKey = $langKey ?? session('admin-formLocal', app()->getLocale());
        $attributes = ['language_id' => langId($langKey), 'key' => $key];
        $values = ['text' => is_array($value) ? json_encode($value) : $value, 'updated_at' => date('Y-m-d H:i:s')];

        try {
            if (DB::table('language_resource')->updateOrInsert($attributes, $values)) {
                Cache::forget("langMap.{$langKey}");
                return true;
            }
        } catch (\Exception $e) {}

        return false;
    }
}

if (! function_exists('deleteLang')) {
    /**
     * Delete local contents via key or key set.
     *
     * @param  array $keys
     * @param  string $langKey
     * @return bool
     */
    function deleteLang($keys, $langKey = null)
    {
        $keys = is_array($keys) ? $keys : [$keys];

        try {
            if ($langKey) {
                if (DB::table('language_resource')->whereIn('key', $keys)->where('language_id', langId($langKey))->delete()) {
                    Cache::forget("langMap.{$langKey}");
                    return true;
                }
            } else {
                if (DB::table('language_resource')->whereIn('key', $keys)->delete()) {
                    $langMap = cache('langId') ?? [];
                    foreach ($langMap as $code => $id) {
                        Cache::forget("langMap.{$code}");
                    }
                    return true;
                }
            }
        } catch (\Exception $e) {}

        return false;
    }
}

if (! function_exists('systemParam')) {
    /**
     * Get system parameter via key.
     *
     * @param  string $key
     * @param  string $langKey
     * @return string|array
     */
    function systemParam($key = null, $langKey = null)
    {
        $langKey = $langKey ?? app()->getLocale();

        $params = Cache::rememberForever("systemParams.{$langKey}", function () {
            return \Minmax\Base\Models\SystemParameterGroup::with('systemParameterItems')
                ->where('active', true)
                ->get()
                ->mapWithKeys(function ($item) {
                    /** @var \Minmax\Base\Models\SystemParameterGroup $item */
                    return [
                        $item->code => $item->systemParameterItems
                            ->where('active', true)
                            ->mapWithKeys(function ($item) {
                                /** @var \Minmax\Base\Models\SystemParameterItem $item */
                                return [$item->value => ['title' => $item->label, 'options' => $item->options]];
                            })
                    ];
                })
                ->toArray();
        });

        if (count($params) == 0) Cache::forget("systemParams.{$langKey}");

        return is_null($key) ? $params : array_get($params, $key, $key);
    }
}

if (! function_exists('getImagePath')) {
    /**
     * Check and get image path.
     *
     * @param  string  $path
     * @param  boolean  $transparent
     * @return string
     */
    function getImagePath($path, $transparent = true)
    {
        $imgTransparent = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        $imgNoImage = asset('static/admin/images/common/noimage.gif');

        if (! isset($path)) {
            return $transparent ? $imgTransparent : $imgNoImage;
        }

        if (is_null($path)) {
            return $transparent ? $imgTransparent : $imgNoImage;
        }

        if (is_string($path) && $path == '') {
            return $transparent ? $imgTransparent : $imgNoImage;
        }

        if (! file_exists(public_path($path))) {
            return $transparent ? $imgTransparent : $imgNoImage;
        }

        return asset($path);
    }
}

if (! function_exists('getThumbnailPath')) {
    /**
     * Check and get thumbnail path.
     *
     * @param  string  $path
     * @param  integer|boolean  $size
     * @param  boolean  $transparent
     * @return string
     */
    function getThumbnailPath($path, $size = 80, $transparent = true)
    {
        if (is_bool($size)) {
            $transparent = $size;
            $size = 80;
        }

        $thumbnailPath = \Minmax\Base\Helpers\Image::makeThumbnail($path, $size, $size);

        return getImagePath($thumbnailPath, $transparent);
    }
}

if(!function_exists('sendProxyMail')) {
    /**
     * @param  array|string $to
     * @param  \Illuminate\Mail\Mailable  $mailable
     * @param  string $from
     * @return array|mixed
     */
    function sendProxyMail($to = [], $mailable = null, $from = '')
    {
        $proxyUrl = "http://proxy.mailer.youweb.tw/send";

        $parameters = [
            'project' => config('mail.username'),
            'auth_key' => config('mail.password'),
            'to' => $to,
            'body' => $mailable->render(),
            'subject' => $mailable->subject,
            'from' => $from == '' ? config('mail.from.address') : $from,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $proxyUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        $output = curl_exec($ch);
        curl_close($ch);

        return empty($output) ? false : json_decode($output, true);
    }
}
