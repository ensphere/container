<?php namespace Ensphere\Container\Facades;

use Illuminate\Support\Facades\Facade;

class Container extends Facade
{

    /**
     * [getFacadeAccessor description]
     * @return [type] [description]
     */
    protected static function getFacadeAccessor()
    {
    	return 'ensphere.container';
    }
}