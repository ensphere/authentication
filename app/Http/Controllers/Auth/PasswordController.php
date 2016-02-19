<?php namespace Ensphere\Authentication\Http\Controllers\Auth;

use Ensphere\Authentication\Contracts\Blueprints\Password;
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
    public function __construct( Password $blueprint )
    {
        $this->repository = $blueprint;
        $this->middleware( 'guest' );
    }

    /**
     * [getEmail description]
     * @return [type] [description]
     */
    public function getEmail()
    {
        return $this->repository->getEmail();
    }

    /**
     * [reset description]
     * @return [type] [description]
     */
    public function reset( Request $request )
    {
        return $this->repository->reset( $request, $this->getBroker(), $this->getGuard() );
    }

    /**
     * [showResetForm description]
     * @param  Request $request [description]
     * @param  [type]  $token   [description]
     * @return [type]           [description]
     */
    public function showResetForm( Request $request, $token = null )
    {
        return $this->repository->showResetForm( $request, $token );
    }

}
