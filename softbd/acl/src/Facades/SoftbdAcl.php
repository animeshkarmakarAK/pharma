<?php

namespace Softbd\Acl\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Logger
 * @package Acl\Facades
 */
class SoftbdAcl extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'softbd-acl';
    }
}
