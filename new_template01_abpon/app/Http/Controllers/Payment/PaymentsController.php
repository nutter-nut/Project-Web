<?php

namespace App\Http\Controllers\Payment;

use App\Product;
use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Payment\PaymentsController;
use App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use Auth;

use App\Order;
use App\OrderItem;
use App\Payment;

class PaymentsController extends Controller
{

    public function getDetail($id)
    {
        $payment = DB::connection('mongodb')->collection("payment")->select('payment_type', 'payment_id')->where('order_id', '=', $id * 1)->first();

        $order = DB::connection('mongodb')->collection("orders")->select('*')->where('id', '=', $id * 1)->first();

        if(Auth::user()->id * 1 != $order['user_id']){

            if(Auth::user()->isAdmin()){

                return self::goViewReceipt($payment, $order);

            }else{

                return back()->with('fail', (\Session::get('locale') != "th") ? 'The authorization was not successful.' : 'การอนุญาต ไม่สำเร็จ');
                
            }

        }elseif(Auth::user()->id * 1 == $order['user_id']){

            return self::goViewReceipt($payment, $order);
        }

    }

    public function goViewReceipt($payment, $order)
    {
        $status_text = self::getStatusText($order['status']);

        for ($i = 1; $i < 6 ; $i++) { 
            if($i > $order['status']*1){
                $status[$i] = false;
            }else{
                $status[$i] = true;
            }
        }
        
        if($order['status_payment']*1 == 0){
            foreach($status as $key => $item){
                $status[$key] = false;
            }
        }

        return view('login.receipt', [
            'payment' => $payment,
            'order' => $order,
            'status' => $status,
            'status_text' => $status_text
        ]);
    }

    public function getStatusText($order_id)
    {
        $status_text = DB::connection('mongodb')->collection("payment_status")->select('*')->where('id', '=', $order_id)->first();

        return $status_text;
    }

    public function showPaymentReceipt($paypalPaymentID, $paypalPayerID, $full_name, $phone, $address){
        
        // dd($paypalPaymentID,$paypalPayerID);
        if(!empty($paypalPaymentID) && !empty($paypalPayerID)){
            //will return json -> contains transaction status

            $this->validate_payment($paypalPaymentID, $paypalPayerID);

            $this->storePaymentInfo($paypalPaymentID, $paypalPayerID, $full_name, $phone, $address);

            //delete payment_info from session
            Session::forget("cart");
            
            return redirect()->route("Index")->withsuccess((\Session::get('locale') != "th") ? 'The product was purchased successfully.' : 'ชื้อสินค้าสำเร็จ');

        }else{

            return redirect()->route("Index")->with('fail', (\Session::get('locale') != "th") ? 'The authorization was not successful.' : 'การอนุญาต ไม่สำเร็จ');

        }

    }

    public function storePaymentInfo($paypalPaymentID, $paypalPayerID, $full_name, $phone, $address)
    {
        $cart = Session::get('cart');

        $order_id = self::saveOrder($cart, $full_name, $phone, $address);

        $type = 'paypal';

        $payment_id = self::savePayment($cart, $paypalPaymentID, $paypalPayerID, $full_name, $phone, $address, $order_id[2], $type);

        $check_out_posone = self::checkoutAtPosone($order_id);
    }

    public function checkoutAtPosone($order_id)
    {
        $cart = DB::connection('mongodb')->collection("orders")->select('cart')->where('id','=',$order_id[2]*1)->first();

        $get_Movingproductstock = app('App\Http\Controllers\Admin\Treasury\StockController')->getMovingproductstock();

        $get_checkoutAtPosone = app('App\Http\Controllers\CheckoutController')->checkoutAtPosone($cart, $get_Movingproductstock, $order_id[2]);
    }

    public function saveOrder($cart, $full_name, $phone, $address)
    {
        
        $full_name = base64_decode($full_name);

        $phone = base64_decode($phone);

        $address = base64_decode($address);

        $price = $cart->totalPrice*1.0;

        $date = \Carbon\Carbon::now()->toDateTimeString();

        $create_order = Order::database()->collection("orders")->insertGetId([
            'id' => Order::database()->collection("orders")->getModifySequence('id'),
            // 'status' => 'กำลังตรวจสอบ, ชำระเงินสำเร็จ',
            'status' => '2',
            'status_payment' => 1,
            'document_refer' => "",
            'date' => date('Y-m-d'),
            'quantity' => $cart->totalQuantity*1.0,
            'price' => $price,
            'user_id' => Auth::user()->id*1,
            'full_name' => $full_name,
            'address' => $address,
            'phone' => $phone,
            'cart' => $cart,
            'created_at' => $date,
            'updated_at' => $date,
        ],'id');

        $oeder_item = self::saveOrderItem($cart, $create_order);

        return $create_order;
    }

    public function saveOrderItem($cart, $create_order)
    {
        $date = \Carbon\Carbon::now()->toDateTimeString();

        foreach($cart->items as $cart_item){
            $item_id = $cart_item['data']['prodCode'];
            $item_name = $cart_item['data']['prodTName'];
            $item_quantity = $cart_item['quantity'];
            $item_price = $cart_item['data']['prodUnitPrice'];
            $item_uomName = $cart_item['data']['uomName'];
            $item_uomCode = $cart_item['data']['uomCode'];

            $create_order_items = OrderItem::database()->collection("order_items")->insert([
                'id' => OrderItem::database()->collection("order_items")->getModifySequence('id'),
                'product_id' => $item_id,
                'order_id' => $create_order[2]*1,
                'product_quantity' => $item_quantity*1,
                'product_name' => $item_name,
                'product_price' => $item_price,
                'product_total' => ($item_price * 1.0) * $item_quantity,
                'product_uomName' => $item_uomName,
                'product_uomCode' => $item_uomCode,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }

        return 1;
    }

    public function savePayment($cart, $paypalPaymentID, $paypalPayerID, $full_name, $phone, $address, $order_id, $payment_type)
    {
        $order_srt_id = "Order#".$order_id;
        if($payment_type=='paypal'){
            $price_total = sprintf('%0.2f', $cart->totalPrice*1.0);
        }else{
            $price_total = sprintf('%0.2f', $cart['cart']['totalPrice']*1.0);
        }
        $date = \Carbon\Carbon::now()->toDateTimeString();

        $create_payment = Payment::database()->collection("payment")->insertGetId([
            "id" => OrderItem::database()->collection("payment")->getModifySequence('id'), //
            "order_id" => $order_id*1,
            "payment_type" => $payment_type,
            "transaction_type" => 'SALE',
            "pymt_method" => 'ANY', 
            "service_id" => $paypalPaymentID,
            "payment_id" => $paypalPayerID,
            "order_number" => $order_srt_id, 
            "amount" => $price_total, 
            "currency_code" => 'THB', 
            "hash_value" => null,
            "hash_value2" => null,
            "txn_id" => null,
            "issuing_bank" => null,
            "txn_xtatus" => 0,
            "auth_code" => null,
            "bank_refNo" => null,
            "token_type" => null,
            "token" => null,
            "resp_time" => $date,
            "txn_message" => 'Transaction Successful',
            "card_no_mask" => null,
            "card_holder" => null,
            "card_type" => null,
            "card_exp" => null,
            "created_at" => $date,
            "updated_at" => $date
        ],'order_id');

        return $create_payment;
    }

    // public function savePayment($cart, $paypalPaymentID, $paypalPayerID, $full_name, $phone, $address, $order_id, $type)
    // {
    //     $order_srt_id = "Order#".$order_id[2];
    //     if($type=='paypal'){
    //         $price_total = sprintf('%0.2f', $cart->totalPrice*1.0);
    //     }else{
    //         $price_total = sprintf('%0.2f', $cart['cart']['totalPrice']*1.0);
    //     }
    //     $date = \Carbon\Carbon::now()->toDateTimeString();

    //     $create_payment = Payment::database()->collection("payment")->insertGetId([
    //         "id" => OrderItem::database()->collection("payment")->getModifySequence('id'), //
    //         "order_id" => $order_id[2]*1,
    //         "payment_type" => $type,
    //         "transaction_type" => 'SALE',
    //         "pymt_method" => 'ANY', 
    //         "service_id" => $paypalPaymentID,
    //         "payment_id" => $paypalPayerID,
    //         "order_number" => $order_srt_id, 
    //         "amount" => $price_total, 
    //         "currency_code" => 'THB', 
    //         "hash_value" => null,
    //         "hash_value2" => null,
    //         "txn_id" => null,
    //         "issuing_bank" => null,
    //         "txn_xtatus" => 0,
    //         "auth_code" => null,
    //         "bank_refNo" => null,
    //         "token_type" => null,
    //         "token" => null,
    //         "resp_time" => $date,
    //         "txn_message" => 'Transaction Successful',
    //         "card_no_mask" => null,
    //         "card_holder" => null,
    //         "card_type" => null,
    //         "card_exp" => null,
    //         "created_at" => $date,
    //         "updated_at" => $date
    //     ],'order_id');

    //     return $create_payment;
    // }

    public function validate_payment($paypalPagerID,$paypalPayerID){
        $paypalEnv = 'sandbox'; //Or 'production
        $paypalURL = 'https://api.sanbox.paypal.com/v1/';
        $paypalClientID = 'Your_Cliect_id';
        $paypalSecret = 'Your_Secret';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $paypalURL. 'oauth2/token');
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $paypalClientID.":".$paypalSecret);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
            $response = curl_exec($ch);
            curl_close($ch);

            if(empty($response)){

                return false;
            }else{

                $jsonDate = json_decode($response);
                $curl = curl_init($paypalURL.'payments/payment/'.$paypalPaymentID);
                curl_setopt($curt, CURLOPT_POST, false);
                curl_setopt($curt, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curt, CURLOPT_HEADER, false);
                curl_setopt($curt, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curt, CURLOPT_HTTPHEADER, array(
                    'Authorization: Bearer' . $jsonDate->access_token,
                    'Accept:application/json',
                    'Content-Type: application/xml'
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                //Transaction data
                $result = json_decode($response);

                return $result;
            }
    }

    // public function getPaymentInfoByOrderId($order_id)
    // {      
    //     $paymentInfo = DB::table('payments')->where('order_id', $order_id)->get();

    //     return json_encode($paymentInfo[0]);
    // }

}
