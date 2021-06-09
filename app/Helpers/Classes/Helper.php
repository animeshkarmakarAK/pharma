<?php

namespace App\Helpers\Classes;

use Illuminate\Support\Facades\Cache;

class Helper
{
    public static function randomPassword($length, $onlyDigit = false): string
    {
        $alphabet = $onlyDigit ? '1234567890' : 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $length; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n] == '0' ? '1' : $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function getDomainConfig()
    {
        try {
            $urls = [
                \request()->getSchemeAndHttpHost(),
                \request()->getScheme() . '://www.' . \request()->getHttpHost(),
                \request()->getSchemeAndHttpHost() . '/',
                \request()->getScheme() . '://www.' . \request()->getHttpHost() . '/',
            ];

            return Cache::rememberForever($urls[0], function () use ($urls) {
                $institute = Institute::whereIn('domain', $urls)->first();
                return collect(['institute' => $institute]);
            });
        } catch (\Throwable $exception) {
            return collect(['institute' => null]);
        }
    }

    public static function forgetDomainConfig($institute): bool
    {
        $urls = [
            \request()->getSchemeAndHttpHost(),
            \request()->getScheme() . '://www.' . \request()->getHttpHost(),
            \request()->getSchemeAndHttpHost() . '/',
            \request()->getScheme() . '://www.' . \request()->getHttpHost() . '/',
        ];

        return in_array($institute->domain, $urls) && Cache::forget($urls[0]);
    }
}
