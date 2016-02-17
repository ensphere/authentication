<?php namespace Ensphere\Authentication\Http\Controllers\Auth;

use Ensphere\Authentication\Models\User;
use Ensphere\Authentication\Http\Controllers\BaseController;
use Validator;
use Ensphere\Authentication\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * [$redirectTo description]
     * @var [type]
     */
    protected $redirectTo;

    /**
     * [$redirectAfterLogout description]
     * @var [type]
     */
    protected $redirectAfterLogout;

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->redirectTo = route('get.dashboard');
        $this->redirectAfterLogout = route('get.login');
        $this->middleware( 'guest', ['except' => 'logout' ]);
    }

    /**
     * [getLogin description]
     * @return [type] [description]
     */
    public function showLoginForm()
    {
        return view('ensphere.auth::auth.login');
    }

    /**
     * [getRegister description]
     * @return [type] [description]
     */
    public function getRegister()
    {
        return view('ensphere.auth::auth.register');
    }

    /**
     * [register description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function register( Request $request )
    {
        $validator = $this->validator( $request->all() );
        if ( $validator->fails() ) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $this->create( $request->all() );
        return redirect( route( 'get.signedup' ) );
    }

    /**
     * [login description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login( Request $request )
    {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ( $throttles && $lockedOut = $this->hasTooManyLoginAttempts( $request ) ) {
            $this->fireLockoutEvent( $request );
            return $this->sendLockoutResponse( $request );
        }
        $credentials = $this->getCredentials( $request );
        if ( Auth::guard( $this->getGuard() )->attempt( array( 'active' => 1 ) + $credentials, $request->has( 'remember' ) ) ) {
            return $this->handleUserWasAuthenticated( $request, $throttles );
        }

        // check to see if they can login without the active flag
        if( Auth::guard( $this->getGuard() )->attempt( $credentials ) ) {
            // log them back out and send them back
            Auth::guard( $this->getGuard() )->logout();
            return redirect()->back()
                ->withInput( $request->only( $this->loginUsername(), 'remember' ) )
                ->withErrors([
                    'active' => 'Your account is currently not active',
                ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ( $throttles && ! $lockedOut ) {
            $this->incrementLoginAttempts( $request );
        }
        return $this->sendFailedLoginResponse( $request );
    }

    /**
     * [signedUp description]
     * @return [type] [description]
     */
    public function signedUp()
    {
        return view( 'ensphere.auth::auth.signedup' );
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator( array $data )
    {
        return Validator::make( $data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create( array $data )
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
