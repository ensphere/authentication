<?php namespace Ensphere\Authentication\Http\Controllers\Auth;

use Ensphere\Authentication\Models\User;
use Ensphere\Authentication\Http\Controllers\BaseController;
use Validator;
use Ensphere\Authentication\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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
        $this->layout->content = view('ensphere.auth::auth.login');
    }

    /**
     * [getRegister description]
     * @return [type] [description]
     */
    public function getRegister()
    {
        $this->layout->content = view('ensphere.auth::auth.register');
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
