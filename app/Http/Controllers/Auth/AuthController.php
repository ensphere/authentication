<?php namespace Ensphere\Authentication\Http\Controllers\Auth;

use Ensphere\Authentication\Contracts\Blueprints\Authentication;
use Ensphere\Authentication\Models\User;
use Ensphere\Authentication\Http\Controllers\BaseController;
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
    public function __construct( Authentication $blueprint )
    {
        $this->repository = $blueprint;
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
        return $this->repository->showLoginForm();
    }

    /**
     * [getRegister description]
     * @return [type] [description]
     */
    public function getRegister()
    {
        return $this->repository->getRegister();
    }

    /**
     * [register description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function register( Request $request )
    {
        return $this->repository->register( $request );
    }

    /**
     * [login description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login( Request $request )
    {
        return $this->repository->login( $request, $this->getGuard() );
    }

    /**
     * [signedUp description]
     * @return [type] [description]
     */
    public function signedUp()
    {
        return $this->repository->signedUp();
    }

}
