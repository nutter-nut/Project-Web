<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;

use App\Order;
use App\OrderItem;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->isAdmin()){

            $orders = Order::collection('orders')
            ->select('orders.id as id','users.id as user_id','users.name as user_name','users.email as user_email','users.employee as user_employee','orders.status as status','orders.status_payment as status_payment','orders.quantity as quantity','orders.price as price','orders.full_name as full_name','orders.address as address','orders.phone as phone','orders.promotion as promotion')
            ->leftjoin('users','orders.user_id','users.id')
            ->where('orders.id','!=',0)
            ->orderby('orders.id','desc')
            ->get();

            $array_orders = array();
            foreach ($orders as $item) {
                $order_items = OrderItem::collection('order_items')
                    ->select('order_items.id as id', 'order_items.product_id as product_id', 'order_items.product_name as product_name', 'order_items.product_quantity as product_quantity', 'order_items.product_price as product_price', 'products.image as image', 'order_items.product_uomName as product_uomName', 'order_items.product_uomCode as product_uomCode', 'order_items.product_total as product_total')
                    ->leftjoin('products', 'order_items.product_id', 'products.id')
                    ->groupby('$selected')
                    ->where('order_items.order_id', '=', $item['id'] * 1)
                    ->get();

                $order_items_image = [];
                foreach($order_items as $key2 => $item2){
                    $get_image = app('App\Http\Controllers\ProductsController')->getImage($item2['product_id']);
                    $image = app('App\Http\Controllers\ProductsController')->getLocationAttribute($get_image);
                    array_push($order_items_image, $image);
                }
                
                array_push($array_orders, [
                    'order' => $item, 
                    'items' => $order_items,
                    'image' => $order_items_image,
                    'status' => app('App\Http\Controllers\Payment\PaymentsController')->getStatusText($item['status']),
                ]);
            }

        }else{

            $orders = Order::collection('orders')
            ->select('orders.id as id','users.id as user_id','users.name as user_name','users.email as user_email','users.employee as user_employee','orders.status as status','orders.status_payment as status_payment','orders.quantity as quantity','orders.price as price','orders.full_name as full_name','orders.address as address','orders.phone as phone','orders.promotion as promotion')
            ->leftjoin('users','orders.user_id','users.id')
            ->where('orders.user_id', '=', Auth::user()->id * 1)
            ->orderby('orders.id','desc')
            ->get();

            $array_orders = array();
            foreach ($orders as $item) {
                $order_items = OrderItem::collection('order_items')
                    ->select('order_items.id as id', 'order_items.product_id as product_id', 'order_items.product_name as product_name', 'order_items.product_quantity as product_quantity', 'order_items.product_price as product_price', 'products.image as image', 'order_items.product_uomName as product_uomName', 'order_items.product_uomCode as product_uomCode', 'order_items.product_total as product_total')
                    ->leftjoin('products', 'order_items.product_id', 'products.id')
                    ->groupby('$selected')
                    ->where('order_items.order_id', '=', $item['id'] * 1)
                    ->get();

                $order_items_image = [];
                foreach($order_items as $key2 => $item2){
                    $get_image = app('App\Http\Controllers\ProductsController')->getImage($item2['product_id']);
                    $image = app('App\Http\Controllers\ProductsController')->getLocationAttribute($get_image);
                    array_push($order_items_image, $image);
                }

                array_push($array_orders, [
                    'order' => $item, 
                    'items' => $order_items,
                    'image' => $order_items_image,
                    'status' => app('App\Http\Controllers\Payment\PaymentsController')->getStatusText($item['status']),
                ]);
            }

        }

        $status = self::getPaymentStatus();

        return view('login.home', [
            'orders' => $orders,
            'array_orders' => $array_orders,
            'status' => $status
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $check_local_en = (\Session::get('locale') != "th");

        $status_update = DB::connection('mongodb')->collection("orders")->where('id', "=", $id * 1)->update(['status' => $request->input('order_status')]);

        if($status_update){
            
            $get_status = DB::connection('mongodb')->collection("payment_status")->where('id', "=", $request->input('order_status'))->first();
        
            $check_local_en ? $text = $get_status['status_en'] : $text = $get_status['status_th'];

            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'order status', [
                'th' => 'อัพเดทสถานะใบสั่งชื้อที่ ' . $id . ' เป็น ' . $text,
                'en' => 'Successfully updated ' . $id . ' (' . $text . ') order status.',
            ]);

            return back()->withsuccess($check_local_en ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
        }else{

            return back()->with('fail', $check_local_en ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
        }
    }

    public function searchAll(Request $request)
    {
        // $search = [];

        // if($request->has('search'))
        // {
        //     $text = $request->input('search');

        //     $search_product = Product::collection('products')
        //         ->where('prodCode' , 'like' , '%'.$text.'%' )
        //         ->orwhere('prodTName' , 'like' , '%'.$text.'%' )
        //         ->orwhere('uomName' , 'like' , '%'.$text.'%' )
        //         ->get();

        //     array_push($search, $search_product);

        //     ($search_product =! null) ? $type = 'product' : '';

        // }

        // return view('login.search', [
        //     'search' => $search[0],
        //     'type' => $type,
        //     'text' => $text
        // ]);
    }

    public function getPaymentStatus()
    {
        $status = DB::connection('mongodb')->collection("payment_status")->take(5)->get();

        return $status;
    }
}
