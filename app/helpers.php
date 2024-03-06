<?php

// helpers.php

if (!function_exists('numhash')) {
    function numhash($inNum)
    {
        return (((0x0000FFFF & $inNum) << 16) + ((0xFFFF0000 & $inNum) >> 16));
    }
}