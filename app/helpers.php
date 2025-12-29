<?php

if (!function_exists('rupiahShort')) {
    function rupiahShort($value)
    {
        if ($value >= 1_000_000) {
            return 'Rp ' . round($value / 1_000_000, 1) . ' jt';
        }

        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}
