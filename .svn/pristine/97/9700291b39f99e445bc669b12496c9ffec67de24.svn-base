<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;

class ProductUnitofmeasureposController extends Controller
{
    public function index($get_data_edit = null)
    {
        $get_product_unitofmeasurepos = self::getProductUnitofmeasurepos();

        $get_edit = app('App\Http\Controllers\Admin\ProductsController')->getDataEdit($get_product_unitofmeasurepos, $get_data_edit, 'uomId');

        return view('login.admin.posone.displayProductUnitofmeasurepos', [
            'product_unitofmeasurepos' => $get_product_unitofmeasurepos,
            'data_edit' => $get_edit
        ]);
    }

    public function getProductUnitofmeasurepos()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from unitofmeasurepos Order By uomCode";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function productUomInsert(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $request->validate([
            'uomCode' => 'required|unique:unitofmeasurepos|max:32',
            'uomName' => 'required|max:128',
            'uomDescription' => 'max:1000',
        ]);

        $code = $request->input('uomCode');
        
        $name = $request->input('uomName');

        $description = $request->input('uomDescription');

        $qury = "call sp_unitofmeasurepos_insert (1, '".$description."', 'SINGLE', '".$code."', '".$name."', '')";

        DB::select(DB::raw($qury));

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'product unitofmeasure', [
            'th' => 'เพิ่มหน่วยนับสินค้า ' . $name,
            'en' => 'Successfully created ' . $name . ' product unitofmeasure.',
        ]);

        return back()->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
    }

    public function productUomEdit($id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from unitofmeasurepos where uomCode = '".$id."' Order By uomCode;";

        $get_data = DB::select(DB::raw($qury));
    
        return self::index($get_data);
    }

    public function productUomUpdate(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $request->validate([
            'uomName' => 'required|max:32',
            'uomDescription' => 'max:255',
        ]);

        $code = $request->input('uomCode');

        $name = $request->input('uomName');

        $description = $request->input('uomDescription');

        $qury = "call sp_unitofmeasurepos_update (1, '".$description."', 'SINGLE', '".$code."', '".$name."', '')";

        DB::select(DB::raw($qury));

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'product unitofmeasure', [
            'th' => 'อัพเดทหน่วยนับสินค้า ' . $name,
            'en' => 'Successfully updated ' . $name . ' product unitofmeasure.',
        ]);

        return redirect()->route('adminProductUnitofmeasurepos')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
    }

    public function productUomDelete($id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury2 = "select * from unitofmeasurepos where uomCode = '".$id."'";

        $get_data2 = DB::select(DB::raw($qury2));

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'error', 'product unitofmeasure', [
            'th' => 'ลบหน่วยนับสินค้า ' . $get_data2[0]->uomName,
            'en' => 'Deleted ' . $get_data2[0]->uomName . ' product unitofmeasure successfully.',
        ]);

        $qury = "call sp_unitofmeasurepos_delete  ('".$id."')";

        DB::select(DB::raw($qury));

        return back()->withsuccess((\Session::get('locale') != "th") ? 'Deleted successfully.' : 'ลบสำเร็จ');
    }

    public function getNameUom($uomCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from unitofmeasurepos where uomCode = '".$uomCode."'";

        $get_data = DB::select(DB::raw($qury));
    
        return $get_data;
    }
}
