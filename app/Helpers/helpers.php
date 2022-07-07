<?php

if (!function_exists('formatPrice')) {
    /**
     * formatPrice
     *
     * @param  mixed $str
     * @return string
     */
    function formatPrice($str): string
    {
        return 'Rp. ' . number_format($str, '0', '', '.');
    }
}
