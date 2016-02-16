<?php

namespace Ensphere\Authentication\Http\Controllers\Auth;

use Ensphere\Authentication\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Ensphere\Authentication\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class PasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->redirectTo = route('get.dashboard');
        $this->middleware( 'guest' );
    }

    /**
     * [getEmail description]
     * @return [type] [description]
     */
    public function getEmail()
    {
        return $this->showLinkRequestForm();
    }

    /**
     * [showLinkRequestForm description]
     * @return [type] [description]
     */
    public function showLinkRequestForm()
    {
        if ( view()->exists( 'ensphere.auth::auth.passwords.email' ) ) {
            $this->layout->content = view( 'ensphere.auth::auth.passwords.email' );
        }
    }

    /**
     * [showResetForm description]
     * @param  Request $request [description]
     * @param  [type]  $token   [description]
     * @return [type]           [description]
     */
    public function showResetForm( Request $request, $token = null )
    {
        if ( is_null( $token ) ) {
            $this->getEmail();
        } else {
            $email = $request->input( 'email' );
            if ( view()->exists( 'ensphere.auth::auth.passwords.reset' ) ) {
                $this->layout->content = view( 'ensphere.auth::auth.passwords.reset' );
                $this->layout->content->token = $token;
                $this->layout->content->email = $email;
            }
        }
    }

}
