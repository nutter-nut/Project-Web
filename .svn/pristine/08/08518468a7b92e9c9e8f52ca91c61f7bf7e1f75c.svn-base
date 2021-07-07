<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Product;

use Auth;

class ProductController extends Controller
{
    public function index()
    {
        \Config::set('database.default', 'posone_mysql');
        
        $get_products = self::getProducts();

        $arr_product = [];
        $i = 0;

        foreach($get_products['item'] as $item){
            $prodCode = array_values($item)[0]->prodCode;
            $get_prod_group = app('App\Http\Controllers\Admin\Product\ProductGroupController')->getProductGroupByCode(array_values($item)[0]->prodGroupCode);

            foreach(array_slice($item, 0, 1) as $key => $value){
                $stock[$i][$key] = app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStock($value->prodCode, $value->uomCode);
            }

            if($get_prod_group != null){
                $qury = "select * from productshopmasterpos where prodCode='".$prodCode."'";
                $get_data = DB::select(DB::raw($qury));
    
                $arr_product[$i]['data'] = array_values($item);
                $arr_product[$i]['count'] = count(array_values($item));
                $arr_product[$i]['prod_group'] = $get_prod_group[0]->prodGroupName;
                $arr_product[$i]['get_detail_group'] = [
                    'prodGroupCode' => app('App\Http\Controllers\Admin\Product\ProductGroupController')->getProductGroupByCode($get_data[0]->prodGroupCode)[0]->prodGroupName,
                    'ProdTypeCode' => app('App\Http\Controllers\Admin\Product\ProductTypeController')->getProductTypeByCode($get_data[0]->ProdTypeCode),
                    'ProdBrandCode' => app('App\Http\Controllers\Admin\Product\ProductBrandController')->getProductBrandByCode($get_data[0]->ProdBrandCode),
                    'ProdModelCode' => app('App\Http\Controllers\Admin\Product\ProductModelController')->getProductModelByCode($get_data[0]->ProdModelCode),
                ];
                $arr_product[$i]['image'] = app('App\Http\Controllers\ProductsController')->getLocationAttribute(app('App\Http\Controllers\ProductsController')->getImage($prodCode));
                $arr_product[$i]['stock'] = $stock[$i][0];
                $arr_product[$i]['treasury'] = DB::connection('mongodb')->collection('config')->get()[20]['value'][0];
                $arr_product[$i]['menugroup'] = $this->getMenuGroup($prodCode);
    
                $i++;
            }
        }

        return view('login.admin.posone.displayProduct', [
            'arr_product' => $arr_product,
        ]);
    }

    public function getMenuGroup($prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from producttmenudetail where ProdCode = '".$prodCode."'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function getProducts()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "SELECT
        pm.productPOSId,
        pm.prodCode,
        pm.prodTName,
        pm.prodEName,
        pm.prodShortName,
        pm.prodStatus,
        pm.prodIsComplementary,
        pm.prodIsVat,
        pm.CompanyCode,
        pm.prodGroupCode,
        pm.referProdCode,
        pm.productCalcType,ProdAllowMinus ,WarrantyPeriod,ExpirePeriod,ProdInsID,SUPPCode,ProdDetail,
        pu.prodUnitRatio,
        pu.prodUnitBarcode,
        pu.prodUnitPrice,
        pu.prodUnitDiscount,
        pu.prodUnit1UOMCode,
        pu.productPOSCode,
        pu.isProdBaseUnit,
        pu.prodUnitPrice1,
        pu.prodUnitPrice2,
        pu.prodUnitPrice3,
        pu.prodUnitPrice4,
        pu.prodUnitPrice5,
        pu.prodUnitPrice6,
        pu.prodUnitPrice7,
        pu.prodUnitPrice8,
        pu.prodUnitPrice9,
        u.uomCode,
        u.uomName,
        u.uomDescription,
        u.uomNameEn,
        plo.PlaceOrder,
        psm.IsMenuSet
        from productshopmasterpos pm
        inner join productunitpos pu on pm.prodCode=pu.productposCode
        inner join unitofmeasurepos u on u.uomCode=pu.prodUnit1UOMCode
        left outer join productplaceorder plo on plo.prodcode=pm.prodCode
        left outer join productsetmenu psm on psm.prodcode=pm.prodCode
        Where pm.companyCode='SINGLE' and prodstatus='N'
        order by pm.productPOSId desc";

        $get_data = DB::select(DB::raw($qury));

        $arr = [];
        $arr_count = [];

        foreach ($get_data as $key => $item) {
            $arr[$item->prodCode][$key] = $item;
        }

        foreach ($arr as $key => $item) {
            $arr_count[$key]['count'] = count($item);
        }

        $data = [ 
            'item' => $arr, 
            'count' => $arr_count
        ];

        // $data_paginate = app('App\Http\Controllers\CategoriesController')->paginate($data['item'], 10);

        return $data;
    }


    public function productCreate()
    {
        $get_product_group = app('App\Http\Controllers\Admin\Product\ProductGroupController')->getProductGroup();

        $get_brand = app('App\Http\Controllers\Admin\Product\ProductBrandController')->getProductBrand();

        $get_model = app('App\Http\Controllers\Admin\Product\ProductModelController')->getProductModel();

        $get_uom = app('App\Http\Controllers\Admin\Product\ProductUnitofmeasureposController')->getProductUnitofmeasurepos();

        return view("login.admin.posone.createProduct", [
            'product_group' => $get_product_group,
            'get_brand' => $get_brand,
            'get_model' => $get_model,
            'get_uom' => $get_uom,
        ]);
    }

    public function productInsert(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $request->validate([
            'prodCode' => 'required|unique:productshopmasterpos|max:32',
            'prodTName' => 'required|max:256',
            'prodUnitRatio' => 'required',
            'prodUnitPrice' => 'required',
            'image' => 'required',
        ]);

        Validator::make($request->all(), ['image.*' => "required|file|image|mimes:jpg,png,jpeg|max:1000"])->validate();

        $prodCode = $request->input("prodCode");
        $prodTName = $request->input("prodTName");
        $prodGroupCode = $request->input("prodGroupCode");
        $ProdTypeCode = $request->input("ProdTypeCode");
        $prodBrandCode = $request->input("prodBrandCode");
        $ProdModelCode = $request->input("ProdModelCode");
        $prodIsVat = $request->input("prodIsVat");
        $prodDetail = ($request->input("prodDetail") != null) ? $request->input("prodDetail") : '';

        $ProdAllowMinus = $request->input("ProdAllowMinus") != null ? $request->input("ProdAllowMinus") : 'N';

        // $placeOrder = $request->input("PlaceOrder") != null ? $request->input("PlaceOrder") : 'N';
        $placeOrder = 'Y';

        $uomCode = $request->input("uomCode");
        $prodUnitRatio = $request->input("prodUnitRatio");
        $prodUnitPrice = $request->input("prodUnitPrice");
        // $productCalcType = $request->input("productCalcType");
        $productCalcType = 'AVG';
        $best_seller = $request->input("best_seller");

        $details = $request->input("addmore");
        if($details){
            $array_details = array();
            foreach ($details as $key => $item) {
                array_push($array_details, $item);
            }
        }else $array_details = [];

        if($request->hasFile('image')){ //image at web
            $create_folder = Storage::disk('local')->makeDirectory('public/product_images/'.$prodCode);
            $fileName = [];
            foreach($request->file('image') as $key => $image){
                if($key == 0){
                    // $imageName = $image->getClientOriginalName();
                    $imageName = $prodCode . '_'. $key . '.' . $image->getClientOriginalExtension();
                    $imageEncoded = File::get($image);
                    Storage::disk('local')->put('public/product_images/'.$prodCode.'/'.$imageName, $imageEncoded);
                    array_push($fileName, $imageName);  

                    $filePath = public_path() . '/posone_images/SINGLE/MenuGroup/';
                    $data_file = $image->move($filePath, $imageName);
                }else{
                    // $imageName = $image->getClientOriginalName();
                    $imageName = $prodCode . '_' . $key . '.' . $image->getClientOriginalExtension();
                    $imageEncoded = File::get($image);
                    Storage::disk('local')->put('public/product_images/'.$prodCode.'/'.$imageName, $imageEncoded);
                    array_push($fileName, $imageName);          
                }
            }
        }

        $arr_qury = [
            "update productunitpos set ver='1' where productPOSCode='".$prodCode."'",
            "call sp_productshopmasterpos_insert ('".$prodDetail."', '".$ProdModelCode."', '".$prodBrandCode."', 0, 0, '', '', '".$ProdTypeCode."', 'Y', '".$productCalcType."', '".$prodCode."', '".$prodTName."', '".$prodTName."', '', '".$placeOrder."', 'N', 'N', '".$prodIsVat."', 'SINGLE', '".$prodGroupCode."', 1)",
            "call sp_productsetmenu_insert ('".$prodCode."', 'N', 'SINGLE')",
            "call sp_productplaceorder_insert ('".$prodCode."', '".$placeOrder."', 'SINGLE')",
            "call sp_productpicturepos_insert (1, '".$prodCode."', 'SINGLE', '".$fileName[0]."', '".$fileName[0]."', '".$fileName[0]."', '".$fileName[0]."')"
        ];

        // ! error when insert multiple products.
        foreach($uomCode as $key => $item){

            if($prodUnitRatio[$key] == 1){

                $isProdBaseUnit = "Y";

                // $prodCode2 = $prodCode;

            }else{

                $isProdBaseUnit = "N"; 

                // $prodCode2 = null;
            }

            $call = "call sp_productunitpos_insert2 (0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".$prodUnitRatio[$key].", '', ".$prodUnitPrice[$key].", 0, 'SINGLE', '".$uomCode[$key]."', '".$prodCode."', '".$isProdBaseUnit."')";        

            array_push($arr_qury, $call);           

            $uomName = app('App\Http\Controllers\Admin\Product\ProductUnitofmeasureposController')->getNameUom($item);
            
            $new_product_array = array(
                'id' => Product::database()->collection("products")->getModifySequence('id'),
                'prodCode' => $prodCode,
                'uomCode' => $uomCode[$key],
                'uomName' => $uomName[0]->uomName,
                'prodTName' => $prodTName,
                'prodGroupCode' => $prodGroupCode,
                'prodUnitRatio' => $prodUnitRatio[$key],
                'prodUnitPrice' => $prodUnitPrice[$key],
                'prodIsVat' => $prodIsVat,
                'promotion' => 'no',
                'price_promotion' => $prodUnitPrice[$key],
                'price_vat' => app('App\Http\Controllers\CartController')->taxDeduction($prodIsVat, $prodUnitPrice[$key]),
                'discount' => 'no',
                'price' => app('App\Http\Controllers\CartController')->taxDeduction($prodIsVat, $prodUnitPrice[$key]),
                'image' => $fileName,
                'ratting' => 0.0,
                'details' => $array_details,
                'best_seller' => ($best_seller != null) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            Product::database()->collection("products")->insert($new_product_array);
        }

        foreach ($arr_qury as $item) {
            DB::select(DB::raw($item));
        }

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'product', [
            'th' => 'เพิ่มสินค้า ' . $prodTName,
            'en' => 'Successfully created ' . $prodTName . ' product.',
        ]);

        return back()->withSuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
    }

    public function getDataUomProduct($prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "SELECT
            pm.prodCode,
            pm.prodTName,
            pm.prodEName,
            pm.prodShortName,
            pm.prodStatus,
            pm.prodIsComplementary,
            pm.prodIsVat,
            pm.CompanyCode,
            pm.prodGroupCode,
            pm.referProdCode,
            pm.productCalcType,ProdAllowMinus ,WarrantyPeriod,ExpirePeriod,ProdInsID,SUPPCode,ProdDetail,
            pu.prodUnitId,
            pu.prodUnitRatio,
            pu.prodUnitBarcode,
            pu.prodUnitPrice,
            pu.prodUnitDiscount,
            pu.prodUnit1UOMCode,
            pu.productPOSCode,
            pu.isProdBaseUnit,
            pu.prodUnitPrice1,
            pu.prodUnitPrice2,
            pu.prodUnitPrice3,
            pu.prodUnitPrice4,
            pu.prodUnitPrice5,
            pu.prodUnitPrice6,
            pu.prodUnitPrice7,
            pu.prodUnitPrice8,
            pu.prodUnitPrice9,
            u.uomCode,
            u.uomName,
            u.uomDescription,
            u.uomNameEn,
            plo.PlaceOrder,
            psm.IsMenuSet
            from productshopmasterpos pm
            inner join productunitpos pu on  pm.prodCode=pu.productposCode
            inner join unitofmeasurepos u  on  u.uomCode=pu.prodUnit1UOMCode 
            left outer join productplaceorder plo on plo.prodcode=pm.prodCode
            left outer join productsetmenu psm on psm.prodcode=pm.prodCode
            Where pm.prodcode='".$prodCode."' 
            and pm.companyCode='SINGLE' and prodstatus='N'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function productEdit($prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury2 = "select * from productshopmasterpos where prodCode='".$prodCode."'";

        $get_data2 = DB::select(DB::raw($qury2));

        $get_product_group = app('App\Http\Controllers\Admin\Product\ProductGroupController')->getProductGroup();

        $get_uom = app('App\Http\Controllers\Admin\Product\ProductUnitofmeasureposController')->getProductUnitofmeasurepos();

        $get_type = app('App\Http\Controllers\Admin\Product\ProductTypeController')->getProductTypeByGroupCode($get_data2[0]->prodGroupCode);

        $get_brand = app('App\Http\Controllers\Admin\Product\ProductBrandController')->getProductBrand();

        $get_model = app('App\Http\Controllers\Admin\Product\ProductModelController')->getProductModel();

        $get_DataUomProduct = self::getDataUomProduct($prodCode);

        $get_image = self::getImage($prodCode);

        $file_name = isset($get_image->ProdPicName) ? $get_image->ProdPicName : '';

        $product = Product::collection('products')->select('*')->where('prodCode', '=', $prodCode)->first();

        return view("login.admin.posone.EditProduct", [
            'data_edit' => $get_DataUomProduct[0],
            'all_data_edit' => $get_DataUomProduct,
            'product_group' => $get_product_group,
            'get_uom' => $get_uom,
            'get_type' => $get_type,
            'get_brand' => $get_brand,
            'get_model' => $get_model,
            'get_detail_group' => [
                'prodGroupCode' => $get_data2[0]->prodGroupCode,
                'ProdTypeCode' => $get_data2[0]->ProdTypeCode,
                'ProdBrandCode' => $get_data2[0]->ProdBrandCode,
                'ProdModelCode' => $get_data2[0]->ProdModelCode,
            ],
            'image' => [
                'file_name' => $file_name,
                'url'=> url("/posone_images/SINGLE/MenuGroup/".$file_name.""),
            ],
            'details' => $product[0]['details'],
            'best_seller' => $product[0]['best_seller'],
        ]);
    }

    public function productUpdate(Request $request, $prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $request->validate([
            'prodTName' => 'required|max:200',
            'prodUnitRatio' => 'required',
            'prodUnitPrice' => 'required',
        ]);

        $prodCode = $request->input("prodCode");
        $prodTName = $request->input("prodTName");
        $prodIsVat = $request->input("prodIsVat");
        $prodAllowMinus = $request->input("ProdAllowMinus");
        // $placeOrder = $request->input("PlaceOrder");
        $placeOrder = 'Y';
        $prodGroupCode = $request->input("prodGroupName");
        $prodTypeCode = $request->input("ProdTypeCode");
        $prodBrandCode = $request->input("prodBrandCode");
        $ProdModelCode = $request->input("ProdModelCode");

        $prodDetail = ($request->input("prodDetail") != null) ? $request->input("prodDetail") : '';

        $uomCode = $request->input("uomCode");
        $prodUnitRatio = $request->input("prodUnitRatio");
        $prodUnitPrice = $request->input("prodUnitPrice");
        // $productCalcType = $request->input("productCalcType");
        $productCalcType = 'AVG';
        $best_seller = $request->input("best_seller");

        $get_DataUomProduct = self::getDataUomProduct($prodCode);
        foreach($get_DataUomProduct as $item){
            $uom_old[] = $item->prodUnit1UOMCode;
        }

        $del_uom = array_diff($uom_old, $uomCode);

        $upd_uom = [];
        $ins_uom = [];
        foreach($uomCode as $items){
            if(in_array($items, $uom_old)){
                array_push($upd_uom, $items);
            }else array_push($ins_uom, $items);
        }

        $details = $request->input("addmore");
        if($details){
            $array_details = array();
            foreach ($details as $key => $item) {
                array_push($array_details, $item);
            }
        }else $array_details = [];

        $get_image = self::getImage($prodCode);

        $arr_qury = [];

        foreach($ins_uom as $key => $item){ // insert uom

            $index = array_search ($item, $uomCode);

            ($prodUnitRatio[$index] == 1) ? $isProdBaseUnit = "Y" : $isProdBaseUnit = "N";

            $call = "call sp_productunitpos_insert2 (0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".$prodUnitRatio[$index].", '', ".$prodUnitPrice[$index].", 0, 'SINGLE', '".$uomCode[$index]."', '".$prodCode."', '".$isProdBaseUnit."')";        

            array_push($arr_qury, $call);           

            $uomName = app('App\Http\Controllers\Admin\Product\ProductUnitofmeasureposController')->getNameUom($item);
            
            $new_product_array = array(
                'id' => Product::database()->collection("products")->getModifySequence('id'),
                'prodCode' => $prodCode,
                'uomCode' => $uomCode[$index],
                'uomName' => $uomName[0]->uomName,
                'prodTName' => $prodTName,
                'prodGroupCode' => $prodGroupCode,
                'prodUnitRatio' => $prodUnitRatio[$index],
                'prodUnitPrice' => $prodUnitPrice[$index],
                'prodIsVat' => $prodIsVat,
                'promotion' => 'no',
                'price_promotion' => $prodUnitPrice[$index],
                'price_vat' => app('App\Http\Controllers\CartController')->taxDeduction($prodIsVat, $prodUnitPrice[$index]),
                'discount' => 'no',
                'price' => app('App\Http\Controllers\CartController')->taxDeduction($prodIsVat, $prodUnitPrice[$index]),
                'image' => [ $get_image->ProdPicName ],
                'ratting' => 0.0,
                'details' => $array_details,
                'best_seller' => ($best_seller != null) ? 1 : 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            Product::database()->collection("products")->insert($new_product_array);
        }

        foreach($upd_uom as $key => $item){ // update uom

            $index = array_search ($item, $uomCode);

            $index2 = array_search ($item, $uom_old);

            $getIDUpdateProduct = self::getIDUpdateProduct($get_DataUomProduct[$index2]->prodCode, $get_DataUomProduct[$index2]->prodUnit1UOMCode);

            if($prodUnitRatio[$index] == 1){

                $isProdBaseUnit = "Y";

                $prodCode2 = $prodCode;

            }else{

                $isProdBaseUnit = "N"; 

                $prodCode2 = $prodCode;
            }

            $uomName = app('App\Http\Controllers\Admin\Product\ProductUnitofmeasureposController')->getNameUom($item);

            $imageName_old = ($get_image != null) ? $get_image->ProdPicName : '';

            $update_product_array = array(
                'prodCode' => $prodCode,
                'uomCode' => $item,
                'uomName' => $uomName[0]->uomName,
                'prodTName' => $prodTName,
                'prodGroupCode' => $prodGroupCode,
                'prodUnitRatio' => $prodUnitRatio[$index],
                'prodUnitPrice' => $prodUnitPrice[$index],
                'prodIsVat' => $prodIsVat,
                'ratting' => 0.0,
                'best_seller' => ($best_seller != null) ? 1 : 0,
                'details' => $array_details,
                'updated_at' => date('Y-m-d H:i:s')
            );

            $update_product = self::supUpdateProduct($update_product_array, $getIDUpdateProduct['id']);
            
            $call = "call sp_productunitpos_update2 (0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".$prodUnitRatio[$index].", '".$prodCode2."', ".$prodUnitPrice[$index].", 0, 'SINGLE', '".$item."', '".$prodCode."', '".$isProdBaseUnit."')";

            array_push($arr_qury, $call);
        }

        if(isset($del_uom)){  //delete uom
            foreach($del_uom as $key => $item)
            {
                $index2 = array_search ($item, $uom_old);

                DB::connection('mongodb')->collection("products")->where([['prodCode', "=", $prodCode], ['uomCode', "=", $get_DataUomProduct[$index2]->prodUnit1UOMCode]])->delete();

                $call = "DELETE FROM dbposone.productunitpos WHERE  prodUnitId = ".$get_DataUomProduct[$index2]->prodUnitId."";

                array_push($arr_qury, $call);
            }
        }

        $qury = "call sp_productshopmasterpos_update ('".$prodDetail."', '".$ProdModelCode."', '".$prodBrandCode."', 0, 0, '', '', '".$prodTypeCode."', '".$prodAllowMinus."', '".$productCalcType."', '".$prodCode."', '".$prodTName."', '".$prodTName."', '', '".$placeOrder."', 'N', 'N', '".$prodIsVat."', 'SINGLE', '".$prodGroupCode."', 1)";
        array_push($arr_qury, $qury);

        foreach($arr_qury as $item){ 
            DB::select(DB::raw($item)); 
        }

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'product', [
            'th' => 'อัพเดทสินค้า ' . $prodTName,
            'en' => 'Successfully updated ' . $prodTName . ' products.',
        ]);

        return redirect()->route('adminProduct')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');

    }

    public function productDelete($prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury_get_product = "select * from productshopmasterpos where prodCode = '".$prodCode."'";

        $get_product = DB::select(DB::raw($qury_get_product));

        $qury = "call sp_productshopmasterpos_update ('', '".$get_product[0]->ProdModelCode."', '".$get_product[0]->ProdBrandCode."', 0, 0, '', '', '".$get_product[0]->ProdTypeCode."', 'Y', '".$get_product[0]->productCalcType."', '".$get_product[0]->prodCode."', '".$get_product[0]->prodTName."', '".$get_product[0]->prodTName."', '', '".$get_product[0]->placeOrder."', 'Y', 'N', '".$get_product[0]->prodIsVat."', 'SINGLE', '".$get_product[0]->prodGroupCode."', 1)";
        
        DB::select(DB::raw($qury));

        $get_image = self::getImage($prodCode);
        if($get_image != null){
            $path = public_path() . '/posone_images/SINGLE/MenuGroup/'.$get_image->ProdPicName.'';
            $exists = file_exists($path);
            if($exists) unlink($path);
        }

        $product = Product::collection("products")->where('prodCode', "=", $prodCode)->first();
        $exists2 = Storage::disk('local')->exists('public/product_images/'.$prodCode);
        if($exists2) Storage::disk('local')->deleteDirectory('public/product_images/'.$prodCode);

        $delete = DB::connection('mongodb')->collection("products")->where("prodCode", "=", $prodCode)->delete();
        
        if($delete){

            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'error', 'product', [
                'th' => 'ลบสินค้า ' . $get_product[0]->prodTName,
                'en' => 'Deleted ' . $get_product[0]->prodTName . ' product successfully.',
            ]);

            return back()->withsuccess((\Session::get('locale') != "th") ? 'Deleted successfully.' : 'ลบสำเร็จ');
        }else{

            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'error', 'product', [
                'th' => 'ลบสินค้า ' . $get_product[0]->prodTName . ' ไม่สำเร็จ',
                'en' => 'Product ' . $get_product[0]->prodTName . ' was not deleted.',
            ]);

            return back()->with('fail', (\Session::get('locale') != "th") ? 'Deleted is not successful.' : 'ลบ ไม่สำเร็จ');
        }
    }

    public function supUpdateProduct($arr, $id = null)
    {
        if($id){
            $update_product = DB::connection('mongodb')->collection("products")
            ->where([['id', "=", $id * 1]])
            ->update($arr);
        }else{
            $update_product = DB::connection('mongodb')->collection("products")
                ->where([['prodCode', "=", $arr['prodCode']], ['uomCode', "=", $arr['uomCode']]])
                ->update($arr);
        }

        return $update_product;
    }

    public function getIDUpdateProduct($prodCode, $uomCode)
    {
        $get_product = DB::connection('mongodb')->collection("products")->where([['prodCode', "=", $prodCode], ['uomCode', "=", $uomCode]])->get();

        return $get_product[0];
    }

    public function getImage($prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productpicturepos where prodCode='".$prodCode."'";

        $get_image = DB::select(DB::raw($qury));

        return ($get_image != null) ? $get_image[0] : '';
    }

    // ! สำหรับสร้างสินค้าที่ mongo db 
    public function insertProductAll()
    {
        $get_product = app('App\Http\Controllers\Admin\Product\ProductController')->getProducts(); // ! เปลี่ยน desc เป็น asc

        foreach($get_product['item'] as $items){
            foreach($items as $item){

                $get_image = app('App\Http\Controllers\Admin\Product\ProductController')->getImage($item->prodCode);

                $promotion = app('App\Http\Controllers\Admin\PromotionController')->getPromotionDetail($item->prodCode, $item->uomCode);

                $price_promotion = ($promotion != null) ? ($item->prodUnitPrice * 1.0) - (($item->prodUnitPrice * 1.0) * $promotion['discount'] / 100) : 'no';

                $price_vat = app('App\Http\Controllers\CartController')->taxDeduction($item->prodIsVat, $item->prodUnitPrice);

                $new_product_array = array(
                    'id' => Product::database()->collection("products")->getModifySequence('id'),
                    'prodCode' => $item->prodCode,
                    'uomCode' => $item->uomCode,
                    'uomName' => $item->uomName,
                    'prodTName' => $item->prodTName,
                    'prodGroupCode' => $item->prodGroupCode,
                    'prodUnitRatio' => $item->prodUnitRatio,
                    'prodUnitPrice' => $item->prodUnitPrice,
                    'prodIsVat' => $item->prodIsVat,
                    'promotion' => ($promotion != null) ? $promotion['text_promotion'] : 'no',
                    'price_promotion' => ($promotion != null) ? $price_promotion : $item->prodUnitPrice,
                    'price_vat' => $price_vat ,
                    'discount' => ($promotion != null) ? $promotion['discount'] : 'no',
                    'price' => ($promotion != null) ? app('App\Http\Controllers\CartController')->taxDeduction('Y', $price_promotion) : $price_vat ,
                    'image' => ($get_image != null) ? $get_image->ProdPicName : '',
                    'ratting' => 0.0,
                    'best_seller' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
    
                Product::database()->collection("products")->insert($new_product_array);
            }
        }
        return 1;
    }
}
