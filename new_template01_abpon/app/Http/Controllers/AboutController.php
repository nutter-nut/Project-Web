<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Cart;

class AboutController extends Controller
{
    // public function index(Request $request)
    // {
    //     $cart = app('App\Http\Controllers\CartController')->getCart($request);

    //     return view('about',[
    //         'totalQuantity' => $cart->totalQuantity
    //     ]);
    // }

    public function getData()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productmenugroup";

        $get_data = DB::select(DB::raw($qury));

        $data = [
            'menugroup' => $get_data
        ];

        return $data;
    }
    public function getFilter($data, $num_in, $cate = null)
    {
        $new_data = [];

        foreach($data['menugroup'] as $key => $item){
            $arr_item = explode("_", $item->PMenuGroupCode);
            $num = count($arr_item);

            $if_cate = $cate != null && $num_in != 3 && $num_in != 4 ? $arr_item[0] == $cate : true;

            if($num == $num_in && $if_cate){
                if($num_in == 3){
                    $text = $arr_item[0].'_'.$arr_item[1];
                    if($text == $cate) $new_data[] = $item;
                }else if($num_in == 4){
                    $text = $arr_item[0].'_'.$arr_item[1].'_'.$arr_item[2];
                    if($text == $cate) $new_data[] = $item;
                }else{
                    $new_data[] = $item;
                }
            }
        }
        
        return $new_data;
    }
    public function topProducts()
    {
        $top_products = app('App\Http\Controllers\Admin\DashboardsController')->getTopProducts(date("Y"));

        foreach($top_products as $key => $item){
            $data_top_products[$key]['data'] = $item;
            $data_top_products[$key]['detal'] = app('App\Http\Controllers\ProductsController')->getProduct($item['product_id'], $item['product_uom']);
        }

        return $data_top_products;
    }


    public function about(Request $request)
    {
        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        $data = $this->getData();

        $new_data = $this->getFilter($data, 1);

        $get_cate = $this->getFilter($data, 2, $request->id); //list categorie data

        $data['menugroup'] = $new_data;

        $data['breadcrumb'] = [
            'category_id' => $request->id,
            'category_name' => $request->name
        ];

        $data['cate_data'] = $get_cate;

        $data['cart'] = $cart;

        $data['top_products'] = $this->topProducts();

        return view('about', [ 'data' => $data ]);
    }
}
