<?php

namespace App\Http\Controllers\Posone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class InsertProductsController extends Controller
{
    public function index($get_data_edit = null)
    {
        $get_product_type = self::getProductType();
        $groupproducts = "SELECT * FROM productgrouppos ORDER BY prodGroupCode";
        
        $get_data_group = DB::select(DB::raw($groupproducts));
        //dd($get_product_type);
        return view('posone_insert', [
            'get_product_type' => $get_product_type,
            'get_data_group' => $get_data_group,
            'get_data_edit' => $get_data_edit != null ? $get_data_edit[0] : null
        ]);
    }

    public function productTypeInsert(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $name = $request->input('name');
        $group = $request->input('group');
        $code = $request->input('code');
        //dd($group);
        $qury = "call sp_productTypeMaster_insert ('SINGLE', '".$code."', '".$name."', '', '', 'Y', '".$group."');";
        

        DB::select(DB::raw($qury));

        return back();
    }

    public function productTypeEdit(Request $request, $id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productTypeMaster where ProdTypeCode = '".$id."' Order by ProdTypeID";

        $get_data = DB::select(DB::raw($qury));
        $group_selected = $get_data[0]->ProdGroupCode;
        //dd($get_data[0]->ProdGroupCode);
        return self::index($get_data)
        ->with('group_selected',$group_selected);
    }

    public function productTypeUpdate(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $code = $request->input('code');
        $group = $request->input('group');
        $name = $request->input('name');
 
        $qury = "call sp_productTypeMaster_update ('SINGLE', '".$code."', '".$name."', '', '', 'Y', '".$group."');";

        DB::select(DB::raw($qury));

        return back();
    }

    public function getProductType()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "SELECT
        producttypemaster.ProdTypeID,
        producttypemaster.ProdTypeCode,
        producttypemaster.ProdTypeName,
        producttypemaster.ProdTypeEName,
        producttypemaster.ProdTypeRemark,
        producttypemaster.ProdTypeStatus,
        producttypemaster.CompanyCode,
        producttypemaster.ProdGroupCode,
        productgrouppos.prodGroupName
        FROM
        producttypemaster
        Left Outer Join productgrouppos
        ON producttypemaster.ProdGroupCode = productgrouppos.prodGroupCode
        Order by producttypemaster.ProdTypeCode, ProdTypeCode;";

        
        
        $get_data = DB::select(DB::raw($qury));
       

        return $get_data;
    }

    public function productTypeDelete($id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "delete from producttypemaster where ProdTypeCode='".$id."';";

        DB::select(DB::raw($qury));

        return back();
    }

}
