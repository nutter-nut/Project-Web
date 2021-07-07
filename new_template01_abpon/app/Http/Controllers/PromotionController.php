<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Product;

class PromotionController extends Controller
{
    public function getPromotion()
    {
        \Config::set('database.default', 'posone_mysql'); 

        $qury = "select * from promotionmaster pt left outer 
        join copromotion co on co.coCode = pt.coPromotionCode
        join promotiondetail pd on pd.PMId = pt.PMId  
        where   ( pmStatus !='D' and  PMEndDate >= '2021-01-18' ) and pd.Type = 'RESULT' order by pt.PMId desc";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function PromotionDayCondition($date_toDay, $promotions)
    {
        $arr_promotion = [];

        foreach($promotions as $key => $item){

            $arr_PromDay = explode(",", $item->PromDay);

            if(in_array($date_toDay, $arr_PromDay)){

                array_push($arr_promotion, $item);
            }

        }

        return $arr_promotion;
    }

    public function PromotionTimeCondition($date_toDay_time, $promotions)
    {
        $arr_promotion = [];

        foreach($promotions as $item){

            $date = new \DateTime($date_toDay_time);

            $from = new \DateTime($item->StartTime);
                
            $to = new \DateTime($item->EndTime);

            if ($date >= $from && $date <= $to) {
                
                array_push($arr_promotion, $item);
            }

        }

        return $arr_promotion;
    }

    public function findpromotionId($PMCode)
    {
        \Config::set('database.default', 'posone_mysql'); 

        $qury = "select PMId from promotionmaster where PMCode='".$PMCode."'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data[0]->PMId;
    }

    public function getpromotionDiscAllRate($PMId)
    {
        \Config::set('database.default', 'posone_mysql'); 

        $qury = "select * from promotiondetail where PMId='".$PMId."' and Type='RESULT'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data != null ? $get_data[0]->DiscAllRate : 0;
    }

    public function getpromotionDiscAllAmt($PMId)
    {
        \Config::set('database.default', 'posone_mysql'); 

        $qury = "select * from promotiondetail where PMId='".$PMId."' and Type='RESULT'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data != null ? $get_data[0]->DiscAllAmt: 0;
    }

    public function refreshPromotionPrice()
    {
        $arr_product = Product::collection('products')->get();
 
        // $x = [];
        foreach($arr_product as $key => $item){
            $promotion = app('App\Http\Controllers\Admin\PromotionController')->getPromotionDetail($item['prodCode'], $item['uomCode']);

            $price_promotion = ($promotion != null) ? ($item['prodUnitPrice'] * 1.0) - ($item['prodUnitPrice'] * $promotion['discount'] / 100) : 'no';

            $price_vat = app('App\Http\Controllers\CartController')->taxDeduction($item['prodIsVat'], $item['prodUnitPrice']);
            
            $update_price = DB::connection('mongodb')->collection("products")
            ->where([['prodCode', "=", $item['prodCode']], ['uomCode', "=", $item['uomCode']]])
            ->update([
                'promotion' => ($promotion != null) ? $promotion['text_promotion'] : 'no',
                'price_promotion' => ($promotion != null) ? $price_promotion : $item['prodUnitPrice'],
                'price_vat' => $price_vat,
                'discount' => ($promotion != null) ? $promotion['discount'] : 'no',
                'price' => ($promotion != null) ? app('App\Http\Controllers\CartController')->taxDeduction($item['prodIsVat'], $price_promotion) : $price_vat
                ]);

            // $x[$key] = [
            //     $promotion,
            //     $price_promotion,
            //     $price_vat
            // ];
        }
        // return $x;
    }
}
