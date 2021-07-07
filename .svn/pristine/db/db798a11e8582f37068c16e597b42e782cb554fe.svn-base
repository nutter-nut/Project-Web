<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

use App\Cart;

use Auth;

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

//     protected function authenticated(Request $request) //เมื่อเข้าสู่ระบบเสร็จ ทำอะไรต่อ
//     {

//     }

    public function showLoginForm(Request $request)
    {
        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        $get_data = app('App\Http\Controllers\IndexController')->getData();

        $new_data = app('App\Http\Controllers\IndexController')->getFilter($get_data, 1); //list categorie

        $data['menugroup'] = $new_data;

        $data['cart'] = $cart;

        $data['top_products'] = app('App\Http\Controllers\IndexController')->topProducts();

        return view('auth.login', [ 'data' => $data ]);
    }

    protected function authenticated(Request $request) // จะทำงาน หลังจาก login
    {
        $session_cart = Auth::user()->getAttributes()['session_cart'];

        if($session_cart != null) $this->addItemToCart($request, $session_cart);
    }

    public function addItemToCart($request, $session_cart)
    {
        $cart = [];

        $i = 0;

        foreach ($session_cart['items'] as $key => $item) {

            $fm_item = explode(",", $key);

            $cart[$i]['prodCode'] = $fm_item[0];

            $cart[$i]['uomCode'] = $fm_item[1];

            $cart[$i]['qty'] = $item['quantity'];

            $i++;
        }

        app('App\Http\Controllers\CartController')->addItemToCart($request, $cart);
    }

    public function logout(Request $request) // จะทำงาน ก่อนจะ logout *เชพตะกร้าสินค้า ก่อนที่จะ logout
    {
        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        $user_id = Auth::user()->id;

        $session_cart = [ 'session_cart' => $cart ];

        $update_session_cart = app('App\Http\Controllers\Admin\UsersController')->userArrayUpdate($user_id, $session_cart);

        $this->guard()->logout();

        $request->session()->forget("cart");

        return redirect('/');
    }

}
