<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;

class SettingController extends Controller
{

    public function index()
    {
        $config = DB::connection('mongodb')->collection("config")->get();

        $get_treasury = app('App\Http\Controllers\Admin\Treasury\TreasuryController')->getTreasury();

        $treasury_select =  DB::connection('mongodb')->collection("config")->where('config','=','treasury_select')->first();

        return view('login.admin.posone.displaySetting', [
            'config' => $config,
            'get_treasury' => $get_treasury,
            'treasury_select' => [
                'code' => $treasury_select['value'][0],
                'name' => $treasury_select['value'][1]
            ]
        ]);
    }

    public function settingUpdate(Request $request)
    {
        //cc
        $save_web_payment = DB::connection('mongodb')->collection("config")->where('config',"=",'payment_payment_url')->update(['value' => $request->input('payment_payment_url')]);
        $save_mywab = DB::connection('mongodb')->collection("config")->where('config',"=",'payment_url_myweb')->update(['value' => $request->input('payment_url_myweb')]);
        $save_currency = DB::connection('mongodb')->collection("config")->where('config',"=",'payment_currencycode')->update(['value' => $request->input('payment_currencycode')]);
        $save_custip = DB::connection('mongodb')->collection("config")->where('config',"=",'payment_custip')->update(['value' => $request->input('payment_custip')]);
        $save_custname = DB::connection('mongodb')->collection("config")->where('config',"=",'payment_custname')->update(['value' => $request->input('payment_custname')]);
        $save_custemail = DB::connection('mongodb')->collection("config")->where('config',"=",'payment_custemail')->update(['value' => $request->input('payment_custemail')]);
        $save_custphone = DB::connection('mongodb')->collection("config")->where('config',"=",'payment_custphone')->update(['value' => $request->input('payment_custphone')]);
        $save_pagetimeout = DB::connection('mongodb')->collection("config")->where('config',"=",'pagetimeout')->update(['value' => $request->input('pagetimeout')]);
        $save_first_messages = DB::connection('mongodb')->collection("config")->where('config',"=",'first_messages')->update(['value' => $request->input('first_messages')]);

        //pp
        $save_paypal_url = DB::connection('mongodb')->collection("config")->where('config',"=",'paypal_url')->update(['value' => $request->input('payment_paypal_url')]);
        $save_paypal_client_id = DB::connection('mongodb')->collection("config")->where('config',"=",'paypal_client_id')->update(['value' => $request->input('payment_paypal_client_id')]);
        $save_paypal_secret = DB::connection('mongodb')->collection("config")->where('config',"=",'paypal_secret')->update(['value' => $request->input('payment_paypal_secret')]);
        $save_paypal_env = DB::connection('mongodb')->collection("config")->where('config',"=",'paypal_env')->update(['value' => $request->input('payment_paypal_env')]);

        $save_treasury_main = DB::connection('mongodb')->collection("config")->where('config', "=", 'treasury_select')->update(['value' => explode(",", $request->input('treasury'))]);

        $save_limit_messages = DB::connection('mongodb')->collection("config")->where('config',"=",'limit_messages')->update(['value' => $request->input('limit_messages')]);
        $save_delete_old_messages = DB::connection('mongodb')->collection("config")->where('config',"=",'delete_old_messages')->update(['value' => $request->input('delete_old_messages')]);

        $save_company_about = DB::connection('mongodb')->collection("config")->where('config',"=",'company_about')->update(['value' => $request->input('company_about')]);
        $save_company_address = DB::connection('mongodb')->collection("config")->where('config',"=",'company_address')->update(['value' => $request->input('company_address')]);
        $save_company_phone = DB::connection('mongodb')->collection("config")->where('config',"=",'company_phone')->update(['value' => $request->input('company_phone')]);
        $save_company_email = DB::connection('mongodb')->collection("config")->where('config',"=",'company_email')->update(['value' => $request->input('company_email')]);
        $save_company_name = DB::connection('mongodb')->collection("config")->where('config',"=",'company_name')->update(['value' => $request->input('company_name')]);
        $save_company_tax = DB::connection('mongodb')->collection("config")->where('config',"=",'contact_tax_no')->update(['value' => $request->input('contact_tax_no')]);

        
        $save_web_payment_r = ($save_web_payment==1) ? "Payment url" : '';
        $save_mywab_r = ($save_mywab==1) ? "Url web" : '';
        $save_currency_r = ($save_currency==1) ? "Currency" : '';
        $save_custip_r = ($save_custip==1) ? "Cust ip" : '';
        $save_custname_r = ($save_custname==1) ? "Cust name" : '';
        $save_custemail_r = ($save_custemail==1) ? "Cust email" : '';
        $save_custphone_r = ($save_custphone==1) ? "Cust phone" : '';
        $save_pagetimeout_r = ($save_pagetimeout==1) ? "Pagetimeout" : '';
        $save_first_messages_r = ($save_first_messages==1) ? "First messages" : '';

        $save_limit_messages_r = ($save_limit_messages==1) ? "Limit messages" : '';
        $save_delete_old_messages_r = ($save_delete_old_messages==1) ? "Delete old messages" : '';
        
        $save_company_about_r = ($save_company_about==1) ? "company about" : '';
        $save_company_address_r = ($save_company_address==1) ? "company address" : '';
        $save_company_phone_r = ($save_company_phone==1) ? "company phone" : '';
        $save_company_email_r = ($save_company_email==1) ? "company email" : '';
        $save_company_name_r = ($save_company_name==1) ? "company name" : '';
        $save_company_tax_r = ($save_company_tax==1) ? "company tax no" : '';

        $save_treasury_main_r = ($save_treasury_main==1) ? "Treasury main" : '';

        $save_paypal_url_r = ($save_paypal_url==1) ? "Paypal url" : '';
        $save_paypal_client_id_r = ($save_paypal_client_id==1) ? "Paypal client id" : '';
        $save_paypal_secret_r = ($save_paypal_secret==1) ? "Paypal secret" : '';
        $save_paypal_env_r = ($save_paypal_env==1) ? "Paypal env" : '';

        $text_update = $save_web_payment_r.$save_mywab_r.$save_currency_r.$save_custip_r.$save_custname_r.$save_custemail_r.$save_custphone_r.$save_pagetimeout_r.$save_first_messages_r.$save_limit_messages_r.$save_delete_old_messages_r.$save_company_about_r.$save_company_address_r.$save_company_phone_r.$save_company_email_r.$save_company_name_r.$save_company_tax_r.$save_treasury_main_r.$save_paypal_url_r.$save_paypal_client_id_r.$save_paypal_secret_r.$save_paypal_env_r;

        if($save_web_payment||$save_mywab||$save_currency||$save_custip||$save_custname||$save_custemail||$save_custphone||$save_pagetimeout||$save_first_messages||$save_limit_messages_r||$save_delete_old_messages_r||$save_company_about_r||$save_company_address_r||$save_company_phone_r||$save_company_email_r||$save_company_name_r||$save_company_tax_r||$save_treasury_main_r||$save_paypal_url_r||$save_paypal_client_id_r||$save_paypal_secret_r||$save_paypal_env_r){
            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'setting', [
                'th' => 'อัพเดทตั้งค่าระบบ',
                'en' => 'Successfully setting updated.',
            ]);

            return back()->withsuccess($text_update . (\Session::get('locale') != "th") ? ' Successfully updated..' : ' อัพเดทสำเร็จ');
        }else{
            return back()->with('fail', (\Session::get('locale') != "th") ? 'Failed to update.' : 'อัพเดท ไม่สำเร็จ');
        }
    }
}