<?php

namespace Joeelia\AuthorizeNet;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Joeelia\AuthorizeNet\Skeleton\SkeletonClass
 */
class AuthorizeNetFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'authorize-net';
    }
}
