<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\User;
use App\User_nan;
use App\Session;
use App\Message;

use App\Rules\Captcha;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function showResetForm(Request $request, $token = null) {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => decrypt($request->query('e'))]
        );
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:6', 'max:50', 'unique:users'],
            'f_name' => ['required', 'string', 'max:50'],
            'l_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'tel' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => new Captcha(),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $now_id = User_nan::database()->collection("users")->getModifySequence('id');

        $user = User::create([
            'id' => $now_id,
            'admin' => 0,
            'employee' => 0,
            'sale' => 0,
            'name' => $data['name'],
            'prefix' => $data['prefix'],
            'first_name' => $data['f_name'],
            'last_name' => $data['l_name'],
            'email' => $data['email'],
            'tel' => $data['tel'],
            'image' => "default.jpg",
            'status' => "online",
            'language' => "th",
            'banned_until' => "1",
            'password' => Hash::make($data['password']),
        ]);

        app('App\Http\Controllers\Chat\ChatController')->createSession($now_id, 'random');

        return $user;

    }
}
