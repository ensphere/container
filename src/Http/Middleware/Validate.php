<?php namespace Ensphere\Container\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Route;

class Validate
{

	/**
	 * [__construct description]
	 * @param Application $app [description]
	 */
	public function __construct( Application $app )
	{
		$this->app = $app;
	}

    /**
     * [handle description]
     * @param  [type]  $request [description]
     * @param  Closure $next    [description]
     * @param  [type]  $guard   [description]
     * @return [type]           [description]
     */
    public function handle( $request, Closure $next, $guard = null )
    {
        $errors = $this->app['ensphere.container']->validate( $request );
        if( $errors ) {
            $request->flash();
        	return back()->withInput()->withErrors( $errors );
        }
        return $next( $request );
    }
}
