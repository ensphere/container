<?php

namespace Ensphere\Container\Facades;

use Illuminate\Support\Facades\Facade;

class Container extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
    	return 'ensphere.container';
    }
}
