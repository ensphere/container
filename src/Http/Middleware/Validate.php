<?php

namespace Ensphere\Container\Http\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Route;

class Validate
{

    /**
     * Validate constructor.
     * @param Application $app
     */
	public function __construct( Application $app )
	{
		$this->app = $app;
	}

    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
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
