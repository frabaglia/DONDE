<?php namespace App\Http\Middleware;

use Closure;

class ForceHttpProtocol {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// return $next($request);
		if (!$request->secure() && env('APP_ENV') === 'pro')  {
            return redirect()->secure($request->getRequestUri());
        }
 
        return $next($request);

	}

}
