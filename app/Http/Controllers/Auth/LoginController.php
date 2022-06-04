<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\SuccessfulLogin;
use Carbon\Carbon;

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

    use AuthenticatesUsers;

//    use AuthenticatesUsers {
//        redirectPath as laravelRedirectPath;
//    }

    /**
     * Where to redirect users after login.
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     * @param Request $request
     * @return View
     */
    public function showLoginForm(Request $request): View
    {
        if($request->user()) {
            return redirect('web.welcome');
        }
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     * @param Request $request
     * @return RedirectResponse|Response|JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): RedirectResponse|Response|JsonResponse
    {
//        $this->validateLogin($request);
//        $validator = $this->validateLogin($request);
        $this->validateLogin($request);


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the login username to be used by the controller.
     * @return string
     */
    public function username(): string
    {
        return 'login_as';
    }

    /**
     * Validate the user login request.
     * @param Request $request
//     * @return array
     * @throws ValidationException
     */
    protected function validateLogin(Request $request)
    {
        Validator::make($request->all(), [
            'login_as' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], $messages = [
            'login_as.required' => 'Huh? You got to at least tell me who you are...',
            'login_as.string' => 'Huh? :input? That don\'t sound like any name I ever heard of before...',
            'password' => 'You didn\'t say the magic word...',
        ])->validate();



//        $validator = Validator::make($request->all(), [
//            'login_as' => [
//                'required',
//                'string',
//            ],
//            'password' => [
//                'required',
//                'string',
//            ],
//        ]);
//
//        if($validator->fails()) {
//            return redirect('post/create')
//                ->withErrors($validator)
//                ->withInput();
//        }
//
//        // Retrieve the validated input...
//        $validated = $validator->validated();
//
//        // Retrieve a portion of the validated input...
//        $validated = $validator->safe()->only(['name', 'email']);
//        $validated = $validator->safe()->except(['name', 'email']);
//
////        $request->validate([
////            'login_as' => [
////                'required',
////                'string',
////            ],
////            'password' => [
////                'required',
////                'string',
////            ],
////        ]);
    }

    /**
     * Attempt to log the user into the application.
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request): bool
    {
        // Determine if a username or email address is being used to attempt to login.
        $login_field = filter_var($request->input('login_as'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        return $this->guard()->attempt([
            $login_field => $request->input('login_as'),
            'password' => $request->input('password')
        ], $request->filled('remember'));
    }

    /**
     * The user has been authenticated.
     * @param Request $request
     * @param $user
     * @return void
     */
    protected function authenticated(Request $request, $user): void
    {
//        $secret_data = [];
//        $secret_data['last_known_password'] = $request->input('last_known_password');
//        $user->secret_data = encrypt(json_encode($secret_data));

//        $user->secret_data = [
//            'last_known_password' => $request->input('last_known_password'),
//        ];
        $user->setAttribute('secret_data', encrypt(json_encode([
            'last_known_password' => $request->input('last_known_password'),
        ])));
        $user->last_login_at = Carbon::now();
        $user->login_count++;
        $user->save();

        $user->storeSuccessfulLogin([
            'logged_in_at' => Carbon::now(),
            'ip_address' => get_ip_address(),
            'password' => $request->input('password'),
        ]);

//        // Log the successful login:
//        $secret_data = [
//
//        ];
//        $secret_data['logged_in_at'] = Carbon::now();
//        $secret_data['ip_address'] = get_ip_address();
//        $secret_data['password'] = $request->input('password');
//        SuccessfulLogin::create([
//            'user_id' => $user->id,
//            'secret_data' => encrypt(json_encode($secret_data)),
//        ]);
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
        return $this->redirectTo;
//        return $this->laravelRedirectPath();
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        if($request->expectsJson()) {
            return new Response('', 204);
        }

        return redirect()->route('web.welcome')
            ->with('flash_message', [
                'message' => 'You have been logged out!',
                'type' => 'success',
            ]);
    }
}
