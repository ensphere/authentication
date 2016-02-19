<?php namespace Ensphere\Authentication\Contracts;

use Ensphere\Authentication\Contracts\Blueprints\Authentication as Blueprint;
use Ensphere\Authentication\Models\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Validator;

class Authentication extends Contract implements Blueprint {

	use ValidatesRequests;
	use ThrottlesLogins;

	/**
	 * [$viewPath description]
	 * @var string
	 */
	protected $viewPath = 'ensphere.auth::';

	/**
	 * [__construct description]
	 * @param [type] $model [description]
	 */
	public function __construct( User $model )
	{
		$this->model = $model;
	}

	/**
	 * [showLoginForm description]
	 * @return [type] [description]
	 */
	public function showLoginForm()
	{
		return $this->view( 'auth.login' );
	}

	/**
	 * [getRegister description]
	 * @return [type] [description]
	 */
	public function getRegister()
	{
		return $this->view( 'auth.register' );
	}

	/**
	 * [signedUp description]
	 * @return [type] [description]
	 */
	public function signedUp()
	{
		return $this->view( 'auth.signedup' );
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
	public function login( Request $request, $guard )
	{
		$this->validateLogin( $request );
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ( $throttles && $lockedOut = $this->hasTooManyLoginAttempts( $request ) ) {
            $this->fireLockoutEvent( $request );
            return $this->sendLockoutResponse( $request );
        }
        $credentials = $this->getCredentials( $request );
        if ( Auth::guard( $guard )->attempt( array( 'active' => 1 ) + $credentials, $request->has( 'remember' ) ) ) {
            return $this->handleUserWasAuthenticated( $request, $throttles );
        }

        // check to see if they can login without the active flag
        if( Auth::guard( $guard )->attempt( $credentials ) ) {
            // log them back out and send them back
            Auth::guard( $guard )->logout();
            return redirect()->back()
                ->withInput( $request->only( $this->loginUsername(), 'remember' ) )
                ->withErrors([
                    'active' => 'Your account is currently not active',
                ]);
        }

        if ( $throttles && ! $lockedOut ) {
            $this->incrementLoginAttempts( $request );
        }
        return $this->sendFailedLoginResponse( $request );
	}

	/**
	 * [sendFailedLoginResponse description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	protected function sendFailedLoginResponse( Request $request )
    {
        return redirect()->back()
            ->withInput( $request->only( $this->loginUsername(), 'remember' ) )
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * [getFailedLoginMessage description]
     * @return [type] [description]
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has( 'auth.failed' ) ? Lang::get( 'auth.failed' ) : 'These credentials do not match our records.';
    }

	/**
	 * [isUsingThrottlesLoginsTrait description]
	 * @return boolean [description]
	 */
	protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }

    public function loginUsername()
    {
    	return 'email';
    }

	/**
	 * [getCredentials description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	protected function getCredentials( Request $request )
    {
        return $request->only( $this->loginUsername(), 'password' );
    }

	/**
	 * [validateLogin description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	protected function validateLogin( Request $request )
    {
        $this->validate( $request, [
            $this->loginUsername() => 'required', 'password' => 'required',
        ]);
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
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt( $data['password'] ),
        ]);
    }

}