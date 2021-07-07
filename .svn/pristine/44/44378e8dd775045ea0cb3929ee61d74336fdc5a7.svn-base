<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Auth;

class ProductMenuGroupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($get_data_edit = null)
    {
        $get_menugroup = $this->getMenuGroup();

        $data['get_menugroup'] = $get_menugroup;

        $data['get_filter'] = $this->getFilter($get_menugroup);

        $data['get_data_edit'] = $get_data_edit != null ? $this->getDataEdit($get_menugroup, $get_data_edit[0]) : null;

        return view('login.admin.posone.displayProductMenuGroup', [ 'data' => $data ]);
    }

    public function deleteProduct($pmCode, $prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "delete from producttmenudetail where ProdCode = '".$prodCode."' and prodMenuGroupCode = '".$pmCode."'";

        $get_data = DB::select(DB::raw($qury));

        return 1;
    }

    public function insertProduct($pmCode, $prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "call sp_producttmenudetail_insert ('".$prodCode."', '".$pmCode."', '',  'MENU001')";

        $get_data = DB::select(DB::raw($qury));

        return 1;
    }

    public function getProductsMenu($pmCode)
    {
        $inProduct = $this->getProductsWithMenuGroup($pmCode);

        $products = DB::connection('mongodb')
            ->collection("products")
            ->select('id','prodCode','uomCode','uomName','prodTName','prodGroupCode','prodUnitRatio','prodUnitPrice','prodIsVat','promotion','price_promotion','price_vat','discount','price','review_count','review_count_star','ratting_product','image','ratting','details','best_seller','created_at','updated_at')
            ->groupBy('prodCode')
            ->orderBy('id', 'desc')
            ->get();

        if($inProduct != 0){
            foreach ($inProduct as $val){ //ถ้าซ้ำให้ลบออก
                foreach ($products as $key => $final_val){ 
                    if ($val['prodCode'] == $final_val['prodCode']) unset($products[$key]);
                } 
            }
    
            $new_products = [];
            foreach($products as $item){
                array_push($new_products, $item);
            }
    
            return $products != null ? $new_products : 0;
        }else return $products;

    }

    public function DeleteImageAtPosone($fileName)
    {
        $path = public_path() . '/posone_images/SINGLE/MenuGroup/'.$fileName.'';

        $exists = file_exists($path);

        if($exists && $fileName != null) unlink($path);

        return $exists;
    }

    public function FindMenuGroup($pmId)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productmenugroup where PMenuId='".$pmId."'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data != null ? $get_data[0]: abort(404);
    }

    public function productMenuGroupDelete($pmId)
    {
        \Config::set('database.default', 'posone_mysql');

        $get_data = $this->FindMenuGroup($pmId);

        $qury = "select * from productmenugroup where PMenuGroupCode like '%".$get_data->PMenuGroupCode."%' ";

        $get_data_del = DB::select(DB::raw($qury));

        foreach($get_data_del as $key => $item){
            $qury_item = "call sp_productmenugroup_delete ('".$item->PMenuGroupCode."')";
            $qury_item_product = "delete from producttmenudetail where prodMenuGroupCode = '".$item->PMenuGroupCode."'";

            $qury_image = $item->PMenuGroupPicThumnail;

            DB::select(DB::raw($qury_item));
            DB::select(DB::raw($qury_item_product));
            $deleteImage = $this->DeleteImageAtPosone($qury_image);
        }

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'error', 'menugroup', [
            'th' => 'ลบเมนูขาย ' . $get_data->PMenuGroupName,
            'en' => 'Deleted ' . $get_data->PMenuGroupName . ' menugroup successfully.',
        ]);

        return back()->withsuccess((\Session::get('locale') != "th") ? 'Deleted successfully.' : 'ลบสำเร็จ');
    }

    public function productMenuGroupUpdate(Request $request, $pmId, $pmCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $request->validate([
            'prodMenuGroupName' => 'required',
        ]);

        $PMenuGroupName = $request->prodMenuGroupName;

        $PMenuGroupPicThumnail = $request->PMenuGroupPicThumnail;

        $PMenuGroupParent = $request->PMenuGroupParent;

        $new_code = $request->new_code_cate != null ? 1 : 0;

        if($request->hasFile('image')){

            $deleteImage = $this->DeleteImageAtPosone($PMenuGroupPicThumnail);
            
            $imageName = $this->uploadFileImage($pmCode, $request->image);

        }else $imageName = $PMenuGroupPicThumnail;

        if($new_code){
            $qury = "call sp_productmenugroup_insert ('".$pmCode.'_001'."', '".$PMenuGroupName."', '".$imageName."',  '".$pmCode."', 'SINGLE', 'N')";

            DB::select(DB::raw($qury));

            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'menugroup', [
                'th' => 'เพิ่มเมนูขาย ' . $PMenuGroupName,
                'en' => 'Successfully created menugroup' . $PMenuGroupName . ' product.',
            ]);

            return back()->withSuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');

        }else{
            $qury = "call sp_productmenugroup_update ('".$pmCode."', '".$PMenuGroupName."', '".$imageName."', '".$PMenuGroupParent."', 'SINGLE', 'N')";

            DB::select(DB::raw($qury));

            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'menugroup', [
                'th' => 'อัพเดทเมนูขาย ' . $PMenuGroupName,
                'en' => 'Successfully updated menugroup' . $PMenuGroupName . ' product.',
            ]);

            return redirect()->route('adminProductMenuGroup')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
        }
    }

    public function productMenuGroupInsert(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        Validator::make($request->all(), ['image.*' => "required|file|image|mimes:jpg,png,jpeg|max:1000"])->validate();

        $image = $request->image;

        $PMenuGroupName = $request->prodMenuGroupName;

        $PMenuGroupParent = $request->prodMenuGroupType;

        $new_menu_group = $request->new_categorie != null ? 1 : 0;

        if($new_menu_group)
        {
            $get_data = app('App\Http\Controllers\IndexController')->getData();

            $get_menugroup = app('App\Http\Controllers\IndexController')->getFilter($get_data, 1);

            $max = max(array_column($get_menugroup, 'PMenuGroupCode'));

            $PMenuGroupCode = sprintf("%03d", $max + 1);

            ($request->hasFile('image')) ? $imageName = $this->uploadFileImage($PMenuGroupCode, $image) : $imageName = null;

            $PMenuGroupName1 = $request->prodMenuGroupName1;
            $PMenuGroupName2 = $request->prodMenuGroupName2;
            $PMenuGroupName3 = $request->prodMenuGroupName3;
            $PMenuGroupName4 = $request->prodMenuGroupName4;

            $arr_qury = [
                "call sp_productmenugroup_insert ('".$PMenuGroupCode."', '".$PMenuGroupName1."', '".$imageName."',  '".$PMenuGroupCode."', 'SINGLE', 'N')",
                "call sp_productmenugroup_insert ('".$PMenuGroupCode.'_001'."', '".$PMenuGroupName2."', '".$imageName."',  '".$PMenuGroupCode."', 'SINGLE', 'N')",
                "call sp_productmenugroup_insert ('".$PMenuGroupCode.'_001_001'."', '".$PMenuGroupName3."', '".$imageName."',  '".$PMenuGroupCode.'_001'."', 'SINGLE', 'N')",
                "call sp_productmenugroup_insert ('".$PMenuGroupCode.'_001_001_001'."', '".$PMenuGroupName4."', '".$imageName."',  '', 'SINGLE', 'N')",
            ];

            foreach ($arr_qury as $item) {
                DB::select(DB::raw($item));
            }

            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'menugroup', [
                'th' => 'เพิ่มเมนูขาย ' . $PMenuGroupName,
                'en' => 'Successfully created menugroup' . $PMenuGroupName . ' product.',
            ]);

            return back()->withSuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');

        }else{

            $arr_PMenuGroupParent = explode("_", $PMenuGroupParent);

            $count = count($arr_PMenuGroupParent);
            
            $get_data = app('App\Http\Controllers\IndexController')->getData();

            if($count == 1)
            {
                $get_menugroup = app('App\Http\Controllers\IndexController')->getFilter($get_data, 2, $arr_PMenuGroupParent[0]);

                if($get_menugroup != null){

                    $max = max(array_column($get_menugroup, 'PMenuGroupCode'));

                    $arr_max = explode("_", $max);
            
                    $PMenuGroupCode_last = sprintf("%03d", $arr_max[count($arr_max) - 1] + 1);

                    $PMenuGroupCode = $arr_PMenuGroupParent[0] . '_' . $PMenuGroupCode_last;

                }else{
                    $PMenuGroupCode = $arr_PMenuGroupParent[0] . '_001';
                }

                $parent = $arr_PMenuGroupParent[0];
                
            }else{
                $parent = '';

                for ($i = 0; $i < $count - 1; $i++) { 
                    $parent .= $arr_PMenuGroupParent[$i] . '_';
                }
                
                $parent = substr($parent, 0, -1);
 
                $get_menugroup = app('App\Http\Controllers\IndexController')->getFilter($get_data, $count, $parent);
                
                $max = max(array_column($get_menugroup, 'PMenuGroupCode'));
                
                $arr_max = explode("_", $max);
                
                $PMenuGroupCode_last = sprintf("%03d", $arr_max[count($arr_max) - 1] + 1);
    
                $PMenuGroupCode = $parent . '_' . $PMenuGroupCode_last;
            }

            ($request->hasFile('image') && $count != 4) ? $imageName = $this->uploadFileImage($PMenuGroupCode, $image) : $imageName = null;

            // $PMenuGroupCode2 = $new_menu_group ? $PMenuGroupCode : $arr_max[count($arr_max) - 1];

            $qury = "call sp_productmenugroup_insert ('".$PMenuGroupCode."', '".$PMenuGroupName."', '".$imageName."',  '".$parent."', 'SINGLE', 'N')";

            DB::select(DB::raw($qury));

            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'menugroup', [
                'th' => 'เพิ่มเมนูขาย ' . $PMenuGroupName,
                'en' => 'Successfully created menugroup' . $PMenuGroupName . ' product.',
            ]);

            return back()->withSuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
        }
    }

    public function uploadFileImage($PMenuGroupCode, $image)
    {
        $imageName = $PMenuGroupCode . '_' . $image->getClientOriginalName();
        // $imageEncoded = File::get($image);
        // Storage::disk('local')->put('public/menugroup_images/'.$imageName, $imageEncoded);

        $filePath = public_path() . '/posone_images/SINGLE/MenuGroup/';

        $data_file = $image->move($filePath, $imageName);

        return $imageName;
    }

    public function getDataEdit($arrData, $data)
    {
        $image = app('App\Http\Controllers\IndexController')->getImage($data->PMenuGroupPicThumnail);
        
        $count = count(explode("_", $data->PMenuGroupCode));

        $get_data = app('App\Http\Controllers\IndexController')->getData();

        $get_menugroup = app('App\Http\Controllers\IndexController')->getFilter($get_data, $count+1, $data->PMenuGroupCode);

        $data->image = $image;

        $data->count = $count;

        $data->hasSubMenu = $get_menugroup != null ? 1 : 0;

        $data->countRow = count($arrData);

        $data->keyRow = array_search($data->PMenuId, array_column($arrData, 'PMenuId')); 

        return $data;
    }

    public function productMenuGroupEdit($id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productmenugroup where PMenuId = '".$id."' ";

        $get_data = DB::select(DB::raw($qury));

        return $this->index($get_data);
    }
    
    public function getProductsWithMenuGroup($PMenuGroupCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $arr_PMenuGroupCode = explode("_", $PMenuGroupCode);
        
        $text = '';
        for ($j=0; $j < count($arr_PMenuGroupCode)-1 ; $j++) { 
            $text2 = '';
            for ($i=0; $i < $j+1; $i++) {
                if($j == 0) $text2 .= $arr_PMenuGroupCode[$j];
                else{
                    if($i == $j) $text2 .= $arr_PMenuGroupCode[$j];
                    else $text2 .= $arr_PMenuGroupCode[$i].'_';
                }
            }
            $text .= " or prodMenuGroupCode = '".$text2."'";
        }
        
        $qury = "select * from producttmenudetail where prodMenuGroupCode = '".$PMenuGroupCode."' $text ";
        
        $products = DB::select(DB::raw($qury));
        
        if($products != null){

            foreach($products as $key => $item){

                $product[$key] = app('App\Http\Controllers\ProductsController')->getProductNoUom($item->ProdCode);
            }

            return $product;
            
        }else return $product = 0;  

    }

    public function getFilter($data)
    {
        foreach($data as $key => $item){
            $arr_item = explode("_", $item->PMenuGroupCode);
            $num = count($arr_item);

            if($num){
                $new_data[] = $item;
            }
        }

        return $new_data;
    }

    public function getMenuGroup()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productmenugroup order by PMenuGroupCode asc";

        $get_data = DB::select(DB::raw($qury));

        foreach($get_data as $key => $item){
            $arr_item = explode("_", $item->PMenuGroupCode);
            $qury_product_count = "select count(*) as count from producttmenudetail where prodMenuGroupCode = '".$item->PMenuGroupCode."'";
            $get_data = DB::select(DB::raw($qury_product_count));

            $new_data[$key] = $item;
            $new_data[$key]->type = $this->getName($item->PMenuGroupParent);
            $new_data[$key]->image = app('App\Http\Controllers\IndexController')->getImage($item->PMenuGroupPicThumnail);
            $new_data[$key]->count = count($arr_item);
            $new_data[$key]->count_product = $get_data[0]->count;
        }

        return $new_data;
    }

    public function getName($code)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productmenugroup where PMenuGroupCode = '".$code."' ";

        $get_data = DB::select(DB::raw($qury));

        return ($get_data != null) ? $get_data[0]->PMenuGroupName : null;
    }
}
