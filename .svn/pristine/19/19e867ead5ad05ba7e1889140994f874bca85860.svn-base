<?php

namespace App\Http\Controllers\Admin\Treasury;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;

class TreasuryController extends Controller
{
    public function index($get_data_edit = null)
    {
        $get_treasury = self::getTreasury();

        $get_employees = self::getEmployees();

        $get_edit = app('App\Http\Controllers\Admin\ProductsController')->getDataEdit($get_treasury, $get_data_edit, 'whId');

        return view('login.admin.posone.displayTreasury', [
            'get_treasury' => $get_treasury,
            'get_employees' => $get_employees,
            'data_edit' => $get_edit
        ]);
    }

    public function getTreasury()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from warehousepos";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function getEmployees()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from employeepos left outer join divisionpos on divisionpos.divisionCode=employeepos.empPOSDivisionCode inner join userlogin on userlogin.empcode=employeepos.empcode  where ( empPOSEndDate ='' or empPOSEndDate is null)  and empPOStype != 'STR_SUPPORT' order by employeepos.empCode";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function treasuryInsert(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $request->validate([
            'whCode' => 'required|unique:warehousepos|max:32',
            'whTName' => 'required|max:32',
            // 'whContactName' => 'required',
            'whAddress1' => 'required|max:64',
            'whTelNo' => 'max:20',
            'whFaxNo' => 'max:20',
            'whRemark' => 'max:255',
        ]);

        $code = $request->input('whCode');

        $name = $request->input('whTName');

        $contact = $request->input('whContactName');

        $address = $request->input('whAddress1');

        $phone = $request->input('whTelNo');

        $fax = $request->input('whFaxNo');

        $remark = $request->input('whRemark');

        $qury = "call sp_warehousepos_insert ('N', 0, 1, 'Y', '".$code."', '".$name."', '', '".$contact."', '".$address."', '', '".$phone."', '".$fax."', '".$remark."', '00', 'SINGLE')";

        DB::select(DB::raw($qury));

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'treasury', [
            'th' => 'เพิ่มคลังสินค้า ' . $name,
            'en' => 'Successfully created ' . $name . ' treasury.',
        ]);

        return back()->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
    }

    public function treasuryEdit($id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from warehousepos where whCode = '".$id."'";

        $get_data = DB::select(DB::raw($qury));
    
        return self::index($get_data);
    }

    public function treasuryUpdate(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $request->validate([
            'whCode' => 'required',
            'whTName' => 'required|max:32',
            // 'whContactName' => 'required',
            'whAddress1' => 'required|max:64',
            'whTelNo' => 'max:20',
            'whFaxNo' => 'max:20',
            'whRemark' => 'max:255',
        ]);

        $code = $request->input('whCode');

        $name = $request->input('whTName');

        $contact = $request->input('whContactName');

        $address = $request->input('whAddress1');

        $phone = $request->input('whTelNo');

        $fax = $request->input('whFaxNo');

        $remark = $request->input('whRemark');

        $qury = "call sp_warehousepos_update (0, 1, '".$code."', '".$name."', '', '".$contact."', '".$address."', '', '".$phone."', '".$fax."', '".$remark."')";

        DB::select(DB::raw($qury));

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'treasury', [
            'th' => 'อัพเดทคลังสินค้า ' . $name,
            'en' => 'Successfully updated ' . $name . ' treasury.',
        ]);

        return redirect()->route('adminTreasury')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
    }

    public function treasuryDelete($id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury2 = "select * from warehousepos where whCode = '".$id."'";

        $get_data2 = DB::select(DB::raw($qury2));

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'error', 'treasury', [
            'th' => 'ลบคลังสินค้า ' . $get_data2[0]->whTName,
            'en' => 'Deleted ' . $get_data2[0]->whTName . ' treasury successfully.',
        ]);

        $qury = [
            "delete from warehousepos where whCode='".$id."'",
            "delete from productstaticpos where whcode='".$id."'"
        ];

        foreach ($qury as $item) {
            DB::select(DB::raw($item));
        }

        return back()->withsuccess((\Session::get('locale') != "th") ? 'Deleted successfully.' : 'ลบสำเร็จ');
    }

    public function treasuryNow()
    {
        $treasury_select = DB::connection('mongodb')->collection("config")->where('config','=','treasury_select')->first();

        return $treasury_select;
    }
}
