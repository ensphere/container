<?php namespace Ensphere\Container\Providers;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Ensphere\Container\Container;

class ServiceProvider extends IlluminateServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{

	}

	/**
	 * [register description]
	 * @return [type] [description]
	 */
	public function register()
	{
		$contracts = [];
		foreach( $contracts as $blueprint => $contract ) {
			$this->app->bind( $blueprint, $contract );
		}
		$this->app['ensphere.container'] = $this->app->share( function( $app ) {
			return new Container( $app );
		});
	}
}
