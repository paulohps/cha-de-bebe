<?php

if (!function_exists('mask')) {
    function mask(string $value, string $mask): string
    {
        $masked = '';
        $k = 0;

        for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
            if ($mask[$i] === '#') {
                if (isset($value[$k])) {
                    $masked .= $value[$k++];
                }
            } elseif (isset($mask[$i])) {
                $masked .= $mask[$i];
            }
        }

        return $masked;
    }
}
