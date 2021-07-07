<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Moneyspace\Api\Api;
use App\Moneyspace\config\config;
use Illuminate\Support\Facades\Redirect;

class InstallmentController extends Controller
{
    public  function create($data_payment)
    { 
        $fname = $data_payment['fname'];
        $lname = $data_payment['lname'];
        $email = $data_payment['email'];
        $phone = $data_payment['tel'];
        $address = $data_payment['full_address'];
        $description = $data_payment['text_prod'];
        $bankcode = $data_payment['bankcode'];
        $sendmessage = $data_payment['message_store'];
        $order_id = $data_payment['order_id'];
        $user_id = $data_payment['user_id_mongodb'];
        $min = $data_payment['min'] * 1;
        $max = $data_payment['max'] * 1;
        $amount = $data_payment['price_total'];

        $url = \Config::get('app.url');
    
        $config = new Config();
        $api = new Api($config->getSecret_id(),$config->getSecret_key());
        
        $ms_data = array(
            "firstname" => $fname, // ชื่อลูกค้า
            "lastname" => $lname, // สกุลลูกค้า
            "email" => $email, // อีเมลล์เพื่อรับ ใบสำคัญรับเงิน (RECEIPT)
            "phone" => $phone , // เบอร์โทรศัพท์
            "amount" => $amount, // จำนวนเงิน ( ขั้นต่ำ 3000.01 บาท )
            // "amount" => "4000", // จำนวนเงิน ( ขั้นต่ำ 3000.01 บาท )
            "description" => $description, // รายละเอียดสินค้า
            "address" => $address, // ที่อยู่ลูกค้า
            "feeType" => "include", // ผู้รับผิดชอบค่าธรรมเนียม ( include : ร้านค้ารับผิดชอบดอกเบี้ยรายเดือน , exclude : ผู้ถือบัตรรับผิดชอบดอกเบี้ยรายเดือน ดอกเบี้ย 0.8% , 1% )
            "message" => $sendmessage, // ข้อความถึงร้านค้า
            // "order_id" => "EX".date("YmdHis"),  // เลขที่ออเดอร์ ( ตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ หรือตัวเลข สูงสุด 20 ตัว)
            "order_id" => $order_id . '-im-' . $user_id,  // เลขที่ออเดอร์ ( ตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ หรือตัวเลข สูงสุด 20 ตัว)
            "success_Url" => $url . "/paymentsucess", // เมื่อชำระเงินสำเร็จจะ redirect มายัง url
            "fail_Url" => $url . "/payfail", // เมื่อชำระเงินไม่สำเร็จจะ redirect มายัง url
            "cancel_Url" => $url . "/paycancle", //  เมื่อชำระเงินไม่สำเร็จจะ redirect มายัง url
            "agreement" => "1",  // เงื่อนไขยอมรับการขอคืนเงิน หรือการยกเลิกรายการการจ่ายเงิน
            "bankType" => $bankcode, // 3 ประเภทบัตร ได้แก่ KTC, BAY, FCY 
            "startTerm" => $min,  // ช่วงเดือนเริ่มต้นในการผ่อนชำระเงิน เช่น 3, 4, 5, 6, 7, 8, 9, 10 
            "endTerm" => $max,  // ช่วงเดือนสิ้นสุดในการผ่อนชำระเงิน เช่น 3, 4, 6, 9, 10, 12, 18, 24, 36 ( fee include สูงสุุด 10 เดือน )
        );
        //
        $response = $api->Createinstallment($ms_data); // Call function
    
        $array_response = json_decode($response); // JSON to Array
        // dd($array_response[0]->status);
        
        if ($array_response[0]->status == "success"){
        
            $link_payment = $array_response[0]->link_payment; // ลิ้งชำระเงิน
        
            $transaction_ID = $array_response[0]->transaction_ID; // รหัสธุรกรรม
        
           // header( "location: ".$link_payment); // เปิดลิ้งชำระเงิน
            return Redirect::to($link_payment);
        }else{
          echo $array_response[0]->status ;
           //  echo "ข้อมูลไม่ถูกต้อง"; // กรุณาตรวจสอบ secret_id, secret_key, amount, feeType, order_id, payment_type
        
        }
    
    }
}
