<?php

if (!function_exists('domainConfig')) {
    function domainConfig($configKey = null)
    {
        $domainConfig = \App\Helpers\Classes\Helper::getDomainConfig();

        if (empty($configKey) || !$domainConfig->has($configKey)) {
            return $domainConfig;
        }

        return $domainConfig->get($configKey);
    }
}

if (!function_exists('getMonthList')) {
    function getMonthList($lang = 'en'): array
    {
        $en = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        $bn = [
            '1' => 'January',
            '2' => 'February',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'June',
            '7' => 'July',
            '8' => 'August',
            '9' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December'
        ];

        return $lang === 'bn' ? $bn : $en;
    }
}
