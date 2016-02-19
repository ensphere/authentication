<?php namespace Ensphere\Authentication\Contracts;

use Ensphere\Authentication\Contracts\Blueprints\Password as Blueprint;
use Ensphere\Authentication\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Password as IlluminatePassword;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class Password extends Contract implements Blueprint {

	use ValidatesRequests;

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
		$this->redirectTo = route( 'get.dashboard' );
	}

	/**
	 * [reset description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function reset( $request, $broker, $guard )
	{
        $this->validate( $request, $this->getResetValidationRules() );
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
        $response = IlluminatePassword::broker( $broker )->reset( $credentials, function ( $user, $password ) use ( $guard ) {
            $this->resetPassword( $user, $password, $guard );
        });
        switch ( $response ) {
            case IlluminatePassword::PASSWORD_RESET:
                return $this->getResetSuccessResponse( $response );
            break;
            default:
                return $this->getResetFailureResponse( $request, $response );
            break;
        }
	}

	/**
	 * [getResetFailureResponse description]
	 * @param  Request $request  [description]
	 * @param  [type]  $response [description]
	 * @return [type]            [description]
	 */
	protected function getResetFailureResponse( Request $request, $response )
    {
        return redirect()->back()
            ->withInput( $request->only( 'email' ) )
            ->withErrors( ['email' => trans( $response )] );
    }

	/**
	 * [getResetSuccessResponse description]
	 * @param  [type] $response [description]
	 * @return [type]           [description]
	 */
	protected function getResetSuccessResponse( $response )
    {
        return redirect( $this->redirectTo )->with( 'status', trans( $response ) );
    }

	/**
	 * [resetPassword description]
	 * @param  [type] $user     [description]
	 * @param  [type] $password [description]
	 * @param  [type] $guard    [description]
	 * @return [type]           [description]
	 */
	protected function resetPassword( $user, $password, $guard )
    {
        $user->password = bcrypt( $password );
        $user->save();
        if( $user->active == 1 )
        {
        	Auth::guard( $guard )->login( $user );
        }
    }

	/**
	 * [getResetValidationRules description]
	 * @return [type] [description]
	 */
	protected function getResetValidationRules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

	/**
	 * [getEmail description]
	 * @return [type] [description]
	 */
	public function getEmail()
	{
		return $this->view( 'auth.passwords.email' );
	}

	/**
	 * [showResetForm description]
	 * @param  [type] $request [description]
	 * @param  [type] $token   [description]
	 * @return [type]          [description]
	 */
	public function showResetForm( $request, $token )
	{
		if ( is_null( $token ) ) {
            return $this->getEmail();
        } else {
            $email = $request->input( 'email' );
            return $this->view( 'auth.passwords.reset', array(
                'token' => $token,
                'email' => $email
            ));
        }
	}

}