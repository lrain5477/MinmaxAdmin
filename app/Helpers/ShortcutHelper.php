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