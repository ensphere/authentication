<?php namespace Ensphere\Authentication\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{

    /**
     * [handle description]
     * @param  [type]  $request [description]
     * @param  Closure $next    [description]
     * @param  [type]  $guard   [description]
     * @return [type]           [description]
     */
    public function handle( $request, Closure $next, $guard = null )
    {
        if ( Auth::guard( $guard )->guest() ) {
            if ( $request->ajax() ) {
                return response( 'Unauthorized.', 401 );
            } else {
                return redirect()->guest( route( 'get.login' ) );
            }
        }
        return $next($request);
    }
}
