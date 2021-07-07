<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;

use  App\Moneyspace\Api\Api;
use  App\Moneyspace\config\config;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

use App\Webhook;

class MoneySpaceController extends Controller
{
    public function paymentCard(Request $request, $data_payment)
    {   
        $fname = $data_payment['fname'];
        $lname = $data_payment['lname'];
        $email = $data_payment['email'];
        $phone = $data_payment['tel'];
        $address = $data_payment['full_address'];
        $description = $data_payment['text_prod'];
        $price = $data_payment['price_total'];
        $sendmessage = $data_payment['message_store'];
        $order_id = $data_payment['order_id'];
        $user_id = $data_payment['user_id_mongodb'];
        
        $url = \Config::get('app.url');

        $config = new Config();
        $api = new Api($config->getSecret_id(),$config->getSecret_key());
        $ms_data = array(
            "firstname" => $fname, // ชื่อลูกค้า
            "lastname" => $lname, // สกุลลูกค้า
            "email" => $email , // อีเมลล์เพื่อรับ ใบสำคัญรับเงิน (RECEIPT)
            "phone" => $phone, // เบอร์โทรศัพท์
            "amount" => "1.00", // จำนวนเงิน 
            // "amount" => $price_total, // จำนวนเงิน 
            "description" => $description , // รายละเอียดสินค้า
            "address" => $address , // ที่อยู่ลูกค้า
            "feeType" => "include", // ผู้รับผิดชอบค่าธรรมเนียม ( include : ร้านค้ารับผิดชอบค่าธรรมเนียมบัตรเครดิต/เดบิต , exclude : ผู้ซื้อรับผิดชอบค่าธรรมเนียมบัตรเครดิต/เดบิต ไม่สามารถใช้กับประเภทการชำระเงินแบบ qr ได้)
            "message" => $sendmessage , // ข้อความถึงร้านค้า
            // "order_id" => "EX".date("YmdHis"),  // เลขที่ออเดอร์ ( ตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ หรือตัวเลข สูงสุด 20 ตัว)
            "order_id" => $order_id . '-cc-' . $user_id,  // เลขที่ออเดอร์ ( ตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ หรือตัวเลข สูงสุด 20 ตัว)
            "payment_type" => "card", // ประเภทการชำระเงิน ( card : บัตรเครดิต , qrnone : คิวอาร์โค๊ดพร้อมเพย์แบบรูป )
            "success_Url" => $url . "/paymentsucess", // เมื่อชำระเงินสำเร็จจะ redirect มายัง url
            "fail_Url" => $url . "/payfail", // เมื่อชำระเงินไม่สำเร็จจะ redirect มายัง url
            "cancel_Url" => $url . "/paycancle", // เมื่อชำระเงินไม่สำเร็จจะ redirect มายัง url
            "agreement" => 1
        );
        
       // dd($fname , $lname  ,$email,$phone,$address,$description,$price,$sendmessage);
        // dd($ms_data);
        $response = $api->CreatePayment($ms_data); // Call function

        $array_response = json_decode($response);


        if ($array_response[0]->status == "success"){
            $link_payment = $array_response[0]->link_payment; // ลิ้งชำระเงิน
            $transaction_ID = $array_response[0]->transaction_ID; // รหัสธุรกรรม 

            return Redirect::to($link_payment); // // เปิดลิ้งชำระเงิน  redirect to external URL
        }elseif ($array_response[0]->status == "error create"){
            echo "ข้อมูลไม่ถูกต้อง"; // กรุณาตรวจสอบ secret_id, secret_key, amount, feeType, order_id, payment_type 
        }
        
        
}

    public function checkorder(Request $request){
        $config = new Config();
        $api = new Api($config->getSecret_id(),$config->getSecret_key());
        $orderid= $request->input('orderid');
        $ms_data = array(
            "order_id" => $orderid , // เลขที่ออเดอร์
        );
        $response = $api->Check_OrderID($ms_data); //  Call function
        $orderdetail = (array) json_decode($response, true);
        return view('moneyspace.checkorder')->with('orderdetail',$orderdetail[0]  );
    }
     //################################
     // All return status
     // ############################### 
    public function paymentsucess(Request $request){
       // 
       Session::forget('cart');
       return redirect()->route('Index')->withsuccess((\Session::get('locale') != "th") ? 'Successful product purchase.' : 'ชื้อสินค้าสำเร็จ');
    //    return 'SUCCESS' ;
    }
    public function payfail(Request $request){
       //
       return redirect()->route('Index')->with('fail', (\Session::get('locale') != "th") ? 'Product purchase is not successful.' : 'ชื้อสินค้าไม่สำเร็จ');
    //    print ("<h1> request  data of fail payment</h1><br>");
    //    dd($_POST,$request);
    //    return 'FAIL' ;
    }
    public function paycancle(Request $request){
       //
       print ("<h1> Router to cancle => request  data of cancle payment</h1><br>");
       dd($_GET,$request);
       return 'CANCLE' ;
    }
    public function webhook(Request $request){
        // ignored CSRF token
        //dd($_GET)  ;
        $arr_order_id = explode("-", $_POST['orderid']); // 300-cc-01 ,oder_id-payment_type-user_id
        $get_user_id = $arr_order_id[2];
        $get_payment_type = $this->getPaymentType($arr_order_id[1]);

        $status_payment = $this->savePayment($arr_order_id[0], $get_payment_type, $_POST["transectionID"]);
        $status = $this->saveWebhook($_POST, $arr_order_id[0], $get_payment_type, $get_user_id);

        $fileName = __DIR__  ."/../../../../public/logs/".  $_POST["transectionID"]  .".html" ;
        //dd($fileName);
        $fp = fopen( $fileName , 'w');
        
        
        fwrite($fp,"<HTML><BODY>");
        fwrite($fp,"<h3>WEBHOOK POST DATA Transection No. :". $_POST["transectionID"] ."</h3>");
        fwrite($fp,  "<table>" ) ;
        foreach ($_POST as $key => $value) {
            fwrite($fp,  "<tr>" ) ;
            fwrite($fp, "<td>" ) ;
            fwrite($fp, $key );
            fwrite($fp, "</td>" ) ;
            fwrite($fp, "<td>" );
            fwrite($fp, $value ) ;
            fwrite($fp, "</td>" ) ;
            fwrite($fp, "</tr>" );
        }
        fwrite($fp,  "</table>" );
        fwrite($fp,"</body></HTML>");
    
    
        fclose($fp);
        dd('File Name',$fileName,$status);
    }

    public function getPaymentType($type)
    {
          switch ($type) {
            case 'cc':
                $type = 'credit_card';
                break;
            case 'qr':
                $type = 'qrcode';
                break;
            case 'im':
                $type = 'imstallment';
                break;
            case 'pp':
                $type = 'paypal';
                break;
            default:
                $type = 'other';
        }
        return $type;
    }

    public function savePayment($order_id, $payment_type, $transaction_ID){
        $type = 'credit_card';
        $cart = DB::connection('mongodb')->collection("orders")->select('cart')->where('id','=',$order_id*1)->first();
        $savePayment = app('App\Http\Controllers\Payment\PaymentsController')->savePayment($cart, $paypalPaymentID = null, $transaction_ID, $full_name = null, $phone = null, $address = null, $order_id, $payment_type);
    }

    public function saveWebhook($post, $order_id, $payment_type, $user_id)
    {
        $newLogArray = array(
            'id' => Webhook::database()->collection("webhook")->getModifySequence('id'),
            'transectionID' => $post['transectionID'],
            'order_id' => $post['orderid'],
            'amount' => $post['amount'],
            'status' => $post['status'],
            'hash' => $post['hash'],
            'created_at' => date('Y-m-d H:i:s')
        );

        $save = Webhook::database()->collection("webhook")->insert($newLogArray);

        $this->updateStatusPayment($order_id, $post['status']);

        $this->updateStock($order_id, $user_id);

        return $save;
    }

    public function updateStatusPayment($order_id, $status)
    {
        $order_id_at_payment = DB::connection('mongodb')->collection("payment")->select('order_id')->where('order_id','=',$order_id*1)->first();

        $update_status_in_order = DB::connection('mongodb')->collection("orders")->where('id',"=",$order_id_at_payment['order_id']*1)->update([
            'status_payment' => ($status=='paysuccess') ? 1 : 0, 
            'status' => ($status=='paysuccess') ? "2" : "7", 
        ]);
    }

    public function updateStock($order_id, $user_id)
    {
        $get_Movingproductstock = app('App\Http\Controllers\Admin\Treasury\StockController')->getMovingproductstock();

        $cart = DB::connection('mongodb')->collection("orders")->select('cart')->where('id','=',$order_id*1)->first();

        $checkoutAtPosone = app('App\Http\Controllers\CheckoutController')->checkoutAtPosone($user_id, $cart, $get_Movingproductstock, $order_id);
    }
    
}
