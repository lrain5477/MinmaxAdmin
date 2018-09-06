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
     * @param  string  $langKey
     * @return string
     */
    function langDB($key, $langKey = null)
    {
        $langKey = $langKey ?? app()->getLocale();

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

        return $langMap[$key] ?? $key;
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
        $langKey = $langKey ?? app()->getLocale();
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
     * Save (update or insert) a local content to database via key.
     *
     * @param  array  $keys
     * @param  string  $langKey
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