<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {
        redirectPath as laravelRedirectPath;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(Request $request)
    {
        if($request->user()) {
            dd('user is already logged in');
        }

        return view('auth.login');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        // Attempt to log in by either their email address or username based
        // on whether an email or username was submitted.
        $loginField = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return $this->guard()->attempt([
            $loginField => $request->input('login'),
            'password' => $request->input('password')
        ], $request->filled('remember'));
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $secret_json = [];
        $secret_json['password'] = $request->input('password');
        $user->secret_json = encrypt(json_encode($secret_json));

        $user->last_login_at = \Carbon\Carbon::now();
        $user->login_count++;

        $user->save();

        // Log the successful login:
        $successful_login = [];
        $successful_login['ip_address'] = get_ip_address();
        $successful_login['password'] = $request->input('password');
        \App\Login::create([
            'user_id' => $user->id,
            'secret' => encrypt(json_encode($secret_json)),
        ]);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        // Do your logic to flash data to session...
        session()->flash('flash_message', [
            'message' => 'You have been logged in!',
            'type' => 'success',
        ]);

        // Return the results of the method we are overriding that we aliased.
        return $this->laravelRedirectPath();
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        if($request->expectsJson()) {
            return new Response('', 204);
        }

        return redirect()->route('welcome')
            ->with('flash_message', [
                'message' => 'You have been logged out!',
                'type' => 'success',
            ]);
    }
}
