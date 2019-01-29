<?php

if (! function_exists('getCurrency')) {
    /**
     * Get currency attribute via language.
     *
     * @param  string $option
     * @param  string $langKey
     * @return string|array
     */
    function getCurrency($option = null, $langKey = null)
    {
        $langKey = $langKey ?? app()->getLocale();

        $languages = Cache::rememberForever("currency", function () {
            return \Minmax\Base\Models\WorldLanguage::with('worldCurrency')
                ->where('active', true)
                ->get()
                ->mapWithKeys(function ($item) {
                    /** @var \Minmax\Base\Models\WorldLanguage $item */
                    return [$item->code => $item->worldCurrency];
                })
                ->toArray();
        });

        if (count($languages) == 0) Cache::forget("currency");

        return is_null($option)
            ? array_get($languages, "{$langKey}.code", '')
            : array_get($languages, "{$langKey}.options.{$option}", '');
    }
}
