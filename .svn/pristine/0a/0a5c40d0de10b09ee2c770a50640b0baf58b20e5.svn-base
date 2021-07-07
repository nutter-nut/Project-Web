<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

use Auth;

use App\Order;
use App\OrderItem;
use App\Payment;
use App\Cart;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        (Auth::check()) ? $address = app('App\Http\Controllers\profilecontroller')->getAddress(Auth::user()->id) : $address = [];

        return view('checkout',[
            'cart' => $cart->items,
            'totalQuantity' => $cart->totalQuantity,
            'totalPrice' => $cart->totalPrice,
            'address' => $address
        ]);
    }

    public function sendOrder(Request $request)
    {
        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        if($cart->items == null || $cart->items == '' || $cart->items == []) return back()->with('fail', (\Session::get('locale') != "th") ? 'There are no products listed.' : 'ไม่มีรายการสินค้า');

        $check_stock = self::checkStockEnoughToBuy($cart);

        $price = $cart->totalPrice*1.0;

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'payment' => 'required'
        ]);

        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $payment = $request->input('payment');
        $message_store = $request->input('message_store');

        $full_address = $first_name." ".$last_name."\n".$address."\n".$phone;
        
        $date = \Carbon\Carbon::now()->toDateTimeString();

        $create_order = Order::database()->collection("orders")->insertGetId([
            'id' => Order::database()->collection("orders")->getModifySequence('id'),
            // 'status' => 'กำลังตรวจสอบ, รอชำระเงิน',
            'status' => '1',
            'status_payment' => 0,
            'document_refer' => "",
            'date' => date('Y-m-d'),
            'quantity' => $cart->totalQuantity * 1.0,
            'price' => $price,
            'user_id' => Auth::user()->id * 1,
            'full_name' => $first_name . " " . $last_name,
            'address' => $address,
            'phone' => $phone,
            'cart' => [$cart->items,$cart->totalQuantity,$cart->totalPrice],
            'created_at' => $date,
            'updated_at' => $date,
        ],'id');

        // $order_last = DB::connection('mongodb')->collection("orders")->select('*')->where('id','=',$create_order[2]*1)->first();
        // $user_last = DB::connection('mongodb')->collection("users")->select('*')->where('id','=',$order_last['user_id']*1)->first();

        // $get_order_id = json_encode($user_last['_id'], true);
        // $get_order_id = substr($get_order_id, 9);
        // $get_order_id = substr($get_order_id, 0, -2);

        if($create_order){
            $text_prod = "";
            $count_cart_prod = 1;
            foreach($cart->items as $cart_item){
                $item_id = $cart_item['data']['prodCode'];
                $item_name = $cart_item['data']['prodTName'];
                $item_quantity = $cart_item['quantity'];
                $item_price = $cart_item['price'];
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

                $text_prod .= $count_cart_prod . '. ' . $cart_item['data']['prodCode'] . '-' . $cart_item['data']['prodTName'] . '(' . $cart_item['quantity'] . ' ' . $cart_item['data']['uomName'] . ')' . "\n";
                $count_cart_prod++;
            }

            $random_str = self::random_str(3, 'abcdefghijklmnopqrstuvwxyz');
            $prefix = app('App\Http\Controllers\Admin\UsersController')->getPrefix(Auth::user()->prefix);
            $fname = Auth::user()->first_name;

            $get_user_id_mongodb = DB::connection('mongodb')->collection("users")->select('*')->where('id','=',Auth::user()->id*1)->first();
            $user_id_mongodb = json_encode($get_user_id_mongodb['_id'], true);
            $user_id_mongodb = substr($user_id_mongodb, 9);
            $user_id_mongodb = substr($user_id_mongodb, 0, -2);

            $data_payment = [
                'fname' => $prefix[0].''.$fname,
                'lname' => Auth::user()->last_name,
                'email' => Auth::user()->email,
                'tel' => Auth::user()->tel,
                'user_id' => Auth::user()->id,
                'price_total' => sprintf('%0.2f', $price),
                'payment_id' => "SITTBP1".sprintf("%010d", $create_order[2]).$random_str,
                'order_id' => $create_order[2],
                'full_address' => $full_address,
                'text_prod' => $text_prod,
                'message_store' => $message_store,
                'user_id_mongodb' => $user_id_mongodb
            ];

            if($payment == "credit_card"){

                // $random_str = self::random_str(3, 'abcdefghijklmnopqrstuvwxyz');

                // $order_srt_id = "Order#".$create_order[2];
                // $price_total = sprintf('%0.2f', $price);
                // $payment_id = "SITTBP1".sprintf("%010d", $create_order[2]).$random_str;

                // $payment_for = "Screwshop ".$order_srt_id;

                // return self::creditCard($order_srt_id, $price_total, $payment_id, $payment_for, $get_order_id);

            }else if($payment=="paypal"){
                return back()->with('fail', 'ยังไม่พร้อมให้บริการ');

            }else if($payment == "moneyspace"){

                return app('App\Http\Controllers\Payment\MoneySpaceController')->paymentCard($request, $data_payment);
            }else if($payment == "qrcode"){

                return app('App\Http\Controllers\Payment\QRcodeController')->createqr($data_payment);
            }else if($payment == "installment"){
                // if($price < 3000.00 || $price > 10000.00) return back()->with('fail', (\Session::get('locale') != "th") ? 'The payment amount must be greater than 3000 baht.' : 'ผ่อนชำระเงิน ต้องมากกว่า 3000 บาท และ ไม่เกิน 10000 บาท');
            
                $data_payment['bankcode'] = $request->input('bankcode');
                $data_payment['min'] = $request->input('min');
                $data_payment['max'] = $request->input('max');
                return app('App\Http\Controllers\Payment\InstallmentController')->create($data_payment);
            }else{
                return back()->with('fail', 'ยังไม่พร้อมให้บริการ');
            }

            $request->session()->forget("cart");

            return back()->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');

        }else{

            return back()->with('fail', (\Session::get('locale') != "th") ? 'Save is not successful. ' : 'บันทึก ไม่สำเร็จ');
        }
    }

    public function checkStockEnoughToBuy($cart)
    {
        $i = 0;
        foreach($cart->items as $item){
            $arr[$item['data']['prodCode']][$i] = $item;
            $i++;
        }

        foreach($arr as $items){
            $qty_all = 0;
            foreach($items as $key => $item){
                $prodCode = $item['data']['prodCode'];
                $uomCode = $item['data']['uomCode'];

                $qty_all += ($item['quantity'] * 1) * $item['ratio'];
                
                $get_data = app('App\Http\Controllers\ProductsController')->getProductQury($prodCode, $uomCode);
                $get_stock = app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStock($prodCode, $uomCode);
                $stock_now[] = app('App\Http\Controllers\ProductsController')->getStockNow($get_data, $get_stock, $prodCode, $uomCode, 'cart');

                if($stock_now[$key]['ProdAllowMinus'] != 'Y'){
                    if($qty_all <= $stock_now[$key]['stock']) $check_stock_text[$key] = 'Y';
                    else return self::sellOver($item); //$check_stock_text[$key] = 'N';   //ถ้าเป็น n ไม่ให้ชาย ชื้อเกินจำนวนสต๊อกที่มี
                }else{
                    if($qty_all <= 999) $check_stock_text[$key] = 'Y';
                    else return self::sellOver($item);  //$check_stock_text[$key] = 'N'; 
                }
            }
        }

        return $check_stock_text;
    }

    public function creditCard($order_srt_id, $price_total, $payment_id, $product_name, $user_id)
    {
        $config = DB::connection('mongodb')->collection("config")->get();

        $payment_url = $config[3]['value'] ? $config[3]['value'] : \Config::get('adminConfig.payment.payment_url');
        // $web_url = $config[4]['value'] ? $config[4]['value'] : \Config::get('adminConfig.payment.url_myweb');
        $web_url = "http://127.0.0.1:8000";
        $web_currencycode = $config[5]['value'] ? $config[5]['value'] : \Config::get('adminConfig.payment.currencycode');
        $web_custip = $config[6]['value'] ? $config[6]['value'] : \Config::get('adminConfig.payment.custip');
        $web_custname = $config[7]['value'] ? $config[7]['value'] : \Config::get('adminConfig.payment.custname');
        $web_custemail = $config[8]['value'] ? $config[8]['value'] : \Config::get('adminConfig.payment.custemail');
        $web_custphone = $config[9]['value'] ? $config[9]['value'] : \Config::get('adminConfig.payment.custphone');
        $web_pagetimeout = $config[10]['value'] ? $config[10]['value'] : \Config::get('adminConfig.payment.pagetimeout');

        $encode_id_user = self::encode($user_id,'tbp123');

        $encode = base64_encode($order_srt_id.''.$payment_id);
        $encode2 = self::encode($encode,'tbp123');

        $URL = $payment_url;
        $TransactionType = 'SALE';
        $PymtMethod = 'ANY';
        $OrderNumber = $order_srt_id;
        $PaymentDesc = $product_name;
        $ServiceID = 'SIT';
        $PaymentID = $payment_id;
        $MerchantReturnURL = $web_url . '/tbpapi/'.$encode2;
        $MerchantCallBackURL = $web_url;
        $Amount = $price_total;
        $CurrencyCode = $web_currencycode;
        $CustIP = $web_custip;
        $PageTimeout = $web_pagetimeout;
        $CustName = $web_custname;
        $CustEmail = $web_custemail;
        $CustPhone = $web_custphone;
        $MerchantTermsURL = $web_url;

        $HashValue =  hash('sha256', 'sit12345' . $ServiceID . $PaymentID . $MerchantReturnURL . $MerchantCallBackURL . $Amount . $CurrencyCode . $CustIP . $PageTimeout);
        
        return view('user.payment',[
            'URL' => $URL,
            'TransactionType' => 'SALE',
            'PymtMethod' => 'ANY',
            'OrderNumber' => $OrderNumber,
            'PaymentDesc' => $PaymentDesc,
            'ServiceID' => $ServiceID,  
            'PaymentID' => $payment_id, 
            'MerchantReturnURL' => $MerchantReturnURL,
            'MerchantCallBackURL' => $MerchantCallBackURL,
            'Amount' => $Amount,
            'CurrencyCode' => $CurrencyCode,
            'CustIP' => $CustIP,
            'PageTimeout' => $PageTimeout,
            'CustName' => $CustName,
            'CustEmail' => $CustEmail,
            'CustPhone' => $CustPhone,
            'MerchantTermsURL' => $MerchantTermsURL,
            'HashValue' => $HashValue,
            'Param6' => $encode_id_user
        ]);
        
    }

    public function paymentResponse(Request $request, $id)
    {
        $TransactionType = $request->input('TransactionType');
        $PymtMethod = $request->input('PymtMethod');
        $ServiceID = $request->input('ServiceID');
        $PaymentID = $request->input('PaymentID');
        $OrderNumber = $request->input('OrderNumber');
        $Amount = $request->input('Amount');
        $CurrencyCode = $request->input('CurrencyCode');
        $HashValue = $request->input('HashValue');
        $HashValue2 = $request->input('HashValue2');
        $TxnID = $request->input('TxnID');
        $IssuingBank = $request->input('IssuingBank');
        $TxnStatus = $request->input('TxnStatus');
        $AuthCode = $request->input('AuthCode');
        $BankRefNo = $request->input('BankRefNo');
        $TokenType = $request->input('TokenType');
        $Token = $request->input('Token');
        $RespTime = $request->input('RespTime');
        $TxnMessage = $request->input('TxnMessage');
        $CardNoMask = $request->input('CardNoMask');
        $CardHolder = $request->input('CardHolder');
        $CardType = $request->input('CardType');
        $CardExp = $request->input('CardExp');
        $Param6 = $request->input('Param6');

        $order_id = substr($OrderNumber,6);

        $date = \Carbon\Carbon::now()->toDateTimeString();

        $create_payment = Payment::database()->collection("payment")->insertGetId([
            "id" => OrderItem::database()->collection("payment")->getModifySequence('id'),
            "order_id" => $order_id*1,
            "payment_type" => "credit_card",
            "transaction_type" => $TransactionType,
            "pymt_method" => $PymtMethod,
            "service_id" => $ServiceID,
            "payment_id" => $PaymentID,
            "order_number" => $OrderNumber,
            "amount" => $Amount,
            "currency_code" => $CurrencyCode,
            "hash_value" => $HashValue,
            "hash_value2" => $HashValue2,
            "txn_id" => $TxnID,
            "issuing_bank" => $IssuingBank,
            "txn_xtatus" => $TxnStatus,
            "auth_code" => $AuthCode,
            "bank_refNo" => $BankRefNo,
            "token_type" => $TokenType,
            "token" => $Token,
            "resp_time" => $RespTime,
            "txn_message" => $TxnMessage,
            "card_no_mask" => $CardNoMask,
            "card_holder" => $CardHolder,
            "card_type" => $CardType,
            "card_exp" => $CardExp,
            "created_at" => $date,
            "updated_at" => $date
        ],'order_id');

        if($create_payment[0]){

            if($TxnStatus == "0"){
                
                $order_id_at_payment = DB::connection('mongodb')->collection("payment")->select('order_id')->where('order_id','=',$create_payment[2]*1)->first();
    
                $update_status_in_order = DB::connection('mongodb')->collection("orders")->where('id',"=",$order_id_at_payment['order_id']*1)->update([
                    'status_payment' => $TxnStatus*1==0 ? 1 : 0, 
                    // 'status' => "กำลังตรวจสอบ, ชำระเงินสำเร็จ"
                    'status' => "2"
                    ]);

                $cart = DB::connection('mongodb')->collection("orders")->select('cart')->where('id','=',$order_id*1)->first();
// dd($cart);
                $get_Movingproductstock = app('App\Http\Controllers\Admin\Treasury\StockController')->getMovingproductstock();
                // $cart = app('App\Http\Controllers\Admin\Treasury\StockController')->stockUpdateTest($request);

                // Session::forget('cart');
                
                $decode_test_id_user = self::decode($Param6,'tbp123');
                
                $user_login = Auth::loginUsingId($decode_test_id_user, true);
                
                self::checkoutAtPosone($user_login, $cart, $get_Movingproductstock, $order_id);

                return back()->withsuccess((\Session::get('locale') != "th") ? 'Successful product purchase.' : 'ชื้อสินค้าสำเร็จ');

            }else{

                $order_id_at_payment = DB::connection('mongodb')->collection("payment")->select('order_id')->where('order_id','=',$create_payment[2]*1)->first();
    
                $update_status_in_order = DB::connection('mongodb')->collection("orders")->where('id',"=",$order_id_at_payment['order_id']*1)->update([
                    'status_payment' => $TxnStatus*1==0 ? 1 : 0, 
                    // 'status' => "กำลังตรวจสอบ, ชำระเงินสำเร็จ"
                    'status' => "7"
                    ]);

                $decode_test_id_user = self::decode($Param6,'tbp123');

                Auth::loginUsingId($decode_test_id_user, true);

                return back()->with('fail', (\Session::get('locale') != "th") ? $TxnMessage : $TxnMessage);
            }

        }else{

            return back()->with('fail', (\Session::get('locale') != "th") ? 'Product purchase is not successful.' : 'ชื้อสินค้า ไม่สำเร็จ');

        }
    }

    public function checkoutAtPosone($user_login, $cart, $get_Movingproductstock, $order_id)
    {
        \Config::set('database.default', 'posone_mysql');        

        if($get_Movingproductstock != null){
            $str = "Lot_".$get_Movingproductstock[0]->stockDocNo."_1";
            $number = substr($str, -6, 4) + 1;
        }else{
            $str = "Lot_ABB-00-".date("ym")."/0001_1";
            $number = 1;
        }
   
        $number2 = substr(str_repeat(0, 5).$number, - 5);
        
        $str_01 = substr($str, 0, 11).date("ym")."/".$number2."_1"; //Lot_ABB-00-2012/0016_1
        $str_02 = substr($str, 4, 7).date("ym")."/".$number2; //ABB-00-2012/0016

        $qury_doc = [
            "update invoicemasterpos set invTotalY='6' , invTotalI ='0', invDiscAllN='0', invDiscAllY='0',invDiscAllI= '0' where invdocno='".$str_02."'",
            "update  invoicemasterpos , ( select ver as _version from invoicemasterpos  where InvDocNo='".$str_02."')P set ver = ifnull(_version + 1 ,1) , statusSending = false  , statusSending2 = false  where InvDocNo='".$str_02."'",
        ];

        foreach($qury_doc as $item){
            DB::select(DB::raw($item));
        }

        $arr_qury = [];
        $i = 0;
        $qty = [];
        foreach($cart['cart']['items'] as $item){
            // $prodQty = 0 - ( $item['quantity']*1.0 );

            // $whCode = "POSWH-00-03"; //! ทำต่อ
            $treasury_select = app('App\Http\Controllers\Admin\Treasury\TreasuryController')->treasuryNow();
            $whCode = $treasury_select['value'][0];

            $getSearchStockWhCode = app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStockWhCode($item['data']['prodCode'], $whCode);

            $endQty = $getSearchStockWhCode != null ? $getSearchStockWhCode[0]->endQty : 0;

            $prodQty = ($item['quantity']*1.0) * ($item['data']['prodUnitRatio']*1.0);

            $after_endQty = $endQty - $prodQty;

            if(array_search($item['data']['prodCode'], array_column($qty, 'prod_code')) !== FALSE){
                $remaining = $qty[$i-1]['after_endQty'] - ($item['ratio'] * $item['quantity']);
                // if($remaining < 0) return self::sellOver($item); 
                $qty[] = [
                    'prod_code' => $item['data']['prodCode'],
                    'uom_code' => $item['uom_code'],
                    'ratio' => $item['ratio'],
                    'after_endQty' => $remaining,
                ];
            }else{
                $qty[] = [
                    'prod_code' => $item['data']['prodCode'],
                    'uom_code' => $item['uom_code'],
                    'ratio' => $item['ratio'],
                    'after_endQty' => $after_endQty,
                ];
            }
            $after_endQty2 = $qty[$i]['after_endQty']*1;

            $qury = [
                "call sp_prodlotdetail_insert ('".$str_01."', $prodQty, 0, 0, $prodQty, 0, 0, '".date('Y-m-d H:i:s')."', '".$item['data']['prodCode']."', 'SINGLE')",
                "call sp_prodlotmaster_update ($after_endQty2, 0, '".date('Y-m-d H:i:s')."', 'SINGLE00-0001', '".$item['data']['prodCode']."')",
                "call sp_productstaticpos_update ($after_endQty2, '".$item['data']['prodCode']."', '".$whCode."')",
                "call sp_movingproductstock_insert ('SINGLE00-0001', '".date('Y-m-d H:i:s')."', '', 0, 1, 0, 'SINGLE', '".$item['data']['prodCode']."', '".$whCode."', 'ABB', '".$str_02."', '".date('Y-m-d')."', '".$item['data']['prodCode']."', $endQty, $prodQty, $after_endQty2, 'insert web')",
            ];

            array_push($arr_qury, $qury);
            $i++;
        }
        $arr_qury2 = [];
        foreach ($arr_qury as $key => $items) {
            foreach($items as $item){
                array_push($arr_qury2, $item);
            }
        }

        Auth::loginUsingId($user_login, true); 

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'checkout', [
            'th' => 'ชื้อสินค้าที่ใบสั่งชื้อ ' . $order_id . ' รวมเป็นเงิน ' . $cart['cart']['totalPrice'] . ' จำนวน ' . $cart['cart']['totalQuantity'] . ' ชิ้น',
            'en' => 'Purchased items at the purchase order: ' . $order_id . ' total amount: ' . $cart['cart']['totalPrice'] . ' amount: ' . $cart['cart']['totalQuantity'] . ' pieces.',
        ]);

        foreach ($arr_qury2 as $item) {
            DB::select(DB::raw($item));
        }

        $order_doc_update = array(
            'document_refer' => $str_02,
        );
        $save = $this->orderDocUpdate($order_id, $order_doc_update);

        // Session::forget('cart');
    }

    public function orderDocUpdate($order_id, $order_doc_update)
    {
        $save = DB::connection('mongodb')->collection("orders")->where('id', "=", $order_id * 1)->update($order_doc_update);

        return $save;
    }

    public function payAgain(Request $request, $id)
    {
        $order = DB::connection('mongodb')->collection("orders")->where('id', '=', $id * 1)->first();

        Session::forget('cart');

        foreach($order['cart']['items'] as $item){
    
            $prevCart = $request->session()->get('cart');
            
            $add_cart = new Cart($prevCart);

            $product = app('App\Http\Controllers\ProductsController')->getProduct($item['data']['prodCode'], $item['data']['uomCode']);
            
            $image = $item['image'];

            $get_data = app('App\Http\Controllers\ProductsController')->getProductQury($item['data']['prodCode'], $item['data']['uomCode']);

            $get_stock = app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStock($item['data']['prodCode'], $item['data']['uomCode']);

            $stock_now = app('App\Http\Controllers\ProductsController')->getStockNow($get_data, $get_stock, $item['data']['prodCode'], $item['data']['uomCode'], 'cart');

            $add_cart->addItem($item['data']['prodCode'], $item['data']['uomCode'], $product, $image, $item['quantity'], $stock_now);

            $request->session()->put('cart', $add_cart);
        }

        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        $address = app('App\Http\Controllers\profilecontroller')->getAddress(Auth::user()->id);
        
        return view('checkout',[
            'cart' => $cart->items,
            'totalQuantity' => $cart->totalQuantity,
            'totalPrice' => $cart->totalPrice,
            'address' => $address
        ]);
    }

    public function sellOver($item)
    {
        return redirect()->route('Index')->with('fail', (\Session::get('locale') != "th") ? 'Product ' . $item['data']['prodCode'] . '-' . $item['data']['prodTName'] . ' Not enough to buy.' : 'สินค้า ' . $item['data']['prodCode'] . '-' . $item['data']['prodTName'] . ' จำนวนไม่พอชื้อ');
    }

    public function random_str(
        int $length = 64,
        string $keyspace = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    public function encode($value,$srt) {
        if (!$value) {
            return false;
        }
    
        $key = sha1($srt);
        $strLen = strlen($value);
        $keyLen = strlen($key);
        $j = 0;
        $crypttext = '';
    
        for ($i = 0; $i < $strLen; $i++) {
            $ordStr = ord(substr($value, $i, 1));
            if ($j == $keyLen) {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j++;
            $crypttext .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
        }
    
        return $crypttext;
    }
    
    
    public function decode($value,$srt) {
        if (!$value) {
            return false;
        }
    
        $key = sha1($srt);
        $strLen = strlen($value);
        $keyLen = strlen($key);
        $j = 0;
        $decrypttext = '';
    
        for ($i = 0; $i < $strLen; $i += 2) {
            $ordStr = hexdec(base_convert(strrev(substr($value, $i, 2)), 36, 16));
            if ($j == $keyLen) {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j++;
            $decrypttext .= chr($ordStr - $ordKey);
        }
    
        return $decrypttext;
    }
}
