<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            flash('欢迎回来')->success()->important();
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    protected function attemptLogin(Request $request)
    {
        $credentials = array_merge($this->credentials($request), ['is_active' => 1]);
        return $this->guard()->attempt(
            $credentials, $request->filled('remember')
        );
    }


//    /**
//     * 登录方法
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
//     * @throws \Illuminate\Validation\ValidationException
//     */
//    public function login(Request $request)
//    {
//        $this->validateLogin($request);
//
//        if ($this->attemptLogin($request)) {
//            $user = $this->guard()->user();
//            $user->generateToken();
//
//            return response()->json([
//                'data' => $user->toArray(),
//            ]);
//        }
//
//        return $this->sendFailedLoginResponse($request);
//    }
//
//    /**
//     * 退出登录的方法
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function logout(Request $request)
//    {
//        $user = Auth::guard('api')->user();
//
//        if ($user) {
//            $user->api_token = null;
//            $user->save();
//        }
//
//        return response()->json(['data' => 'User logged out.'], 200);
//    }

}
