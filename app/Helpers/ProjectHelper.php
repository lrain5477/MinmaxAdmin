<?php
/*
 * Here you can make your own shortcut functions.
 * You can check Minmax\Base\Helper\ShortcutHelper.php to learn how to make.
 */

if (! function_exists('sampleInfo')) {
    /**
     * Get php server info.
     */
    function sampleInfo()
    {
        echo phpinfo();
        exit();
    }
}