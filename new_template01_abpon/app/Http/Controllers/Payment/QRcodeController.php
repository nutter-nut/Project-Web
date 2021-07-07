<?php

namespace App\Http\Controllers\Payment;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Moneyspace\Api\Api;
use App\Moneyspace\config\config;

class QRcodeController extends Controller
{
    public function createqr($data_payment)
    {
        $config = new Config();
        $api = new Api($config->getSecret_id(),$config->getSecret_key());

        $ms_data = array(
            "firstname" => $data_payment['fname'], // ชื่อลูกค้า
            "lastname" => $data_payment['lname'], // สกุลลูกค้า
            "email" => $data_payment['email'], // อีเมลล์เพื่อรับ ใบสำคัญรับเงิน (RECEIPT)
            "phone" => $data_payment['tel'], // เบอร์โทรศัพท์
            "amount" => "1.00", // จำนวนเงิน
            // "amount" => $data_payment['price_total'], // จำนวนเงิน
            "description" => $data_payment['text_prod'], // รายละเอียดสินค้า
            "address" => $data_payment['full_address'], // ที่อยู่ลูกค้า
            "message" => $data_payment['message_store'], // ข้อความถึงร้านค้า
            "order_id" => $data_payment['order_id'] . '-qr-' . $data_payment['user_id_mongodb'],  // เลขที่ออเดอร์ ( ตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ หรือตัวเลข สูงสุด 20 ตัว)
            "payment_type" => "qrnone"
        );

        $response = $api->CreatePayment($ms_data); // Call function

        $array_response = json_decode($response); // JSON to Array

        if ($array_response[0]->status == "success"){

            $image_qrprom = $array_response[0]->image_qrprom; // ลิ้งรูป QR Code Promptpay

            $transaction_ID = $array_response[0]->transaction_ID; // รหัสธุรกรรม

        }

        return view('moneyspace.qrcode')
                ->with('transaction_ID', $transaction_ID)
                ->with('image_qrprom', $image_qrprom)
                ->with('ms_data', $ms_data);
    }
}
