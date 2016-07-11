<?php

namespace Kregel\AuthLogin\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Kregel\AuthLogin\Http\Controllers\Controller;
use Validator;
use Auth;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public $registerView = 'auth-login::register';

    public $loginView = 'auth-login::login';

    public $emailView = 'auth-login::emails.password';

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


    public function login(Request $request)
    {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();
        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            // Fire custom auth event
            $this->fireEvent('login.failed', 'Rate limit: ' . $throttles . ' attempts', $request, true);

            return $this->sendLockoutResponse($request);
        }
        $credentials = $this->getCredentials($request);
        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            $this->fireEvent('login.success', 'Successfull login', $request, false);

            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }
        $this->fireEvent('login.failed', 'Failed to authenticate', $request, true);

        return $this->sendFailedLoginResponse($request);
    }


    public function showLoginForm()
    {
        return view($this->loginView);
    }


    public function getLogout()
    {
        \Session::flush();

        return redirect('/');
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->fireEvent('register.failed', json_encode($validator->getMessageBag()->toArray()), $request, true);
            $this->throwValidationException($request, $validator);
        }

        Auth::guard($this->getGuard())->login($this->create($request->all()));
        $this->fireEvent('register.success', 'User registration succeeded', $request, false);

        return redirect($this->redirectPath());
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
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
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
        $user_model = config('auth.providers.users.model');
        $user       = new $user_model;
        $user->fill($data);
        if ( ! empty( $user->password )) {
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
}
