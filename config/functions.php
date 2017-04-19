<?php

if (!function_exists('random')) {
    function random($length = 60, $pattern = null)
    {
        if (is_null($pattern)) {
            $pattern = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        } elseif (strtolower($pattern) === 'integer' || strtolower($pattern) === 'int') {
            $pattern = "1234567890";
        } elseif (strtolower($pattern) === 'string'){
            $pattern = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        return array_reduce(range(1, $length), function ($p) use ($pattern) { return $p.str_shuffle($pattern)[0]; });
    }
}
