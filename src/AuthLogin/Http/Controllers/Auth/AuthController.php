<?php

namespace Kregel\AuthLogin\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Kregel\AuthLogin\Http\Controllers\Controller;
use Validator;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $registerView = 'auth-login::auth.register';
    protected $loginView = 'auth-login::auth.login';
    protected $emailView = 'auth-login::emails.password';
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = config('kregel.auth-login.redirect-to');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user_model = config('auth.model');
        $user = new $user_model;
        $user->fill($data);
        if (!empty($user->password)) {
            $user->password = bcrypt($data['password']);
        }
        if (in_array('uuid', $user->getFillable())) {
            $user->uuid = $this->uuid(openssl_random_pseudo_bytes(16));
        }
        $user->save();

        return $user;
    }

    /**
     * @param $data
     *
     * @return string
     */
    private function uuid($data)
    {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    public function showLoginForm()
    {
        return view('auth-login::auth.login');
    }

    public function getLogout()
    {
        \Session::flush();
        return redirect('/');
    }
}
