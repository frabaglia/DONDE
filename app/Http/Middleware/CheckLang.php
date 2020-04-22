<?php 
namespace App\Http\Middleware;

use Closure;

class CheckLang {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		$lang = session('lang');
		if (($lang != 'null') && ($lang == 'en' || $lang == 'es' || $lang == 'br')){
			app()->setLocale(\Session::get('lang'));
		}
		return $next($request);
	}

}
