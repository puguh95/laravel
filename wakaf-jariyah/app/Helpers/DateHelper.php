<?php

use Carbon\Carbon;

if (!function_exists('formatEpoch')) {
    function formatEpochFromTimestamp($epoch)
    {
        // Set bahasa ke Indonesia (untuk nama hari dan bulan dalam bahasa Indonesia)
        Carbon::setLocale('id');

        // Format: Min, 27 April 2025 16:06:52 +0700
        return Carbon::parse($epoch)
            ->timezone('Asia/Jakarta') // Menggunakan zona waktu Jakarta
            ->isoFormat('ddd, DD MMMM YYYY HH:mm:ss') . ' ' . Carbon::parse($epoch)->timezone('Asia/Jakarta')->format('O');
    }

    function formatEpoch($epoch)
    {
        // Set bahasa ke Indonesia (untuk nama hari dan bulan dalam bahasa Indonesia)
        Carbon::setLocale('id');

        // Format: Sun, 27 April 2025 09:08:34 GMT+07
        return Carbon::createFromTimestamp($epoch)
            ->timezone('Asia/Jakarta') // Menggunakan zona waktu Jakarta
            ->isoFormat('ddd, DD MMMM YYYY HH:mm:ss') . ' ' . Carbon::createFromTimestamp($epoch)->timezone('Asia/Jakarta')->format('O');
    }
}
