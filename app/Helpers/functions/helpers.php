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
