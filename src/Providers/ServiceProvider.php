<?php

namespace Ensphere\Container\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Ensphere\Container\Container;

class ServiceProvider extends IlluminateServiceProvider
{

	public function boot() {}

    /**
     * @return void
     */
	public function register()
	{
		$this->app->singleton( 'ensphere.container', function( $app ) {
			return new Container( $app );
		});
	}
	
}
