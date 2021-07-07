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

class ProductImageController extends Controller
{
    public function index(Request $request, $prodCode)
    {
        $get_data = app('App\Http\Controllers\Admin\Product\ProductController')->getDataUomProduct($prodCode);

        $get_image = app('App\Http\Controllers\Admin\Product\ProductController')->getImage($prodCode);

        $get_image2 = DB::connection('mongodb')->collection("products")->where('prodCode', '=', $prodCode)->first()['image'];

        $image_default = array_search($get_image->ProdPicName, $get_image2);

        return view("login.admin.posone.editProductImage", [
            'data_edit' => $get_data[0],
            'get_image' => $get_image2,
            'image_default' => [
                'index' => $image_default,
                'file_name' => $get_image2[$image_default],
            ]
        ]);
    }

    public function addProductImage(Request $request, $prodCode)
    {
        Validator::make($request->all(), ['image' => "required|file|image|mimes:jpg,png,jpeg|max:1000"])->validate();

        $get_image = DB::connection('mongodb')->collection("products")->where('prodCode', '=', $prodCode)->first()['image'];

        $get_product = app('App\Http\Controllers\ProductsController')->getProductNoUom($prodCode);

        if($request->hasFile("image")){
            $imageName = $prodCode . '_'. count($get_image) . '.' . $request->file('image')->getClientOriginalExtension();

            $imageEncoded = File::get($request->file('image'));
                
            Storage::disk('local')->put('public/product_images/'.$prodCode.'/'.$imageName, $imageEncoded);

            $all_images = DB::connection('mongodb')->collection("products")->select('image')->where('prodCode', '=', $prodCode)->first();

            array_push($all_images['image'], $imageName);

            DB::table('products')->where('prodCode', $prodCode)->update(['image' => $all_images['image']]);

            app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'product image', [
                'th' => 'เพิ่มรูปภาพสินค้า ' . $get_product['prodTName'],
                'en' => 'Add product images: ' . $get_product['prodTName'],
            ]);

            return back()->withsuccess((\Session::get('locale') != "th") ? 'Successfully added product images.' : 'เพิ่มรูปสินค้าสำเร็จ');

        }else{
            return back()->with('fail', (\Session::get('locale') != "th") ? 'Failed to add product images.' : 'เพิ่มรูปสินค้า ไม่สำเร็จ');
        }
    }

    public function updateProductImageDefault($prodCode, $image)
    {
        $path_from = Storage::disk('local')->path("public/product_images/".$prodCode.'/'.$image);

        $path_to = 'posone_images/SINGLE/MenuGroup/' . $image;

        $copy_file = File::copy($path_from, public_path($path_to));

        if($copy_file){
            self::deleteImageOld($prodCode, $image);

            return back()->withsuccess((\Session::get('locale') != "th") ? 'Successfully selected the main image.' : 'เลือกรูปภาพหลัก สำเร็จ');
        }else back()->with('fail', (\Session::get('locale') != "th") ? 'Failed to select the main image.' : 'เลือกรูปภาพหลัก ไม่สำเร็จ');

    }

    public function deleteImageOld($prodCode, $image)
    {
        $get_image = app('App\Http\Controllers\Admin\Product\ProductController')->getImage($prodCode);

        $path = public_path() . '/posone_images/SINGLE/MenuGroup/'.$get_image->ProdPicName.'';

        $exists = file_exists($path);

        if($exists){

            unlink($path);

            self::updateNewImage($prodCode, $image);

        }else self::updateNewImage($prodCode, $image);
    }

    public function updateNewImage($prodCode, $image)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "call sp_productpicturepos_update (1, '".$prodCode."', 'SINGLE', '".$image."', '".$image."', '".$image."', '".$image."')";

        DB::select(DB::raw($qury));
    }

    public function updateProductImage(Request $request, $prodCode, $image)
    {
        Validator::make($request->all(), ['image' => "required|file|image|mimes:jpg,png,jpeg|max:1000"])->validate();
        
        $get_product = app('App\Http\Controllers\ProductsController')->getProductNoUom($prodCode);

        if($request->hasFile("image")){

            $get_image = app('App\Http\Controllers\Admin\Product\ProductController')->getImage($prodCode);

            if($get_image->ProdPicName == $image){

                return back()->with('fail', (\Session::get('locale') != "th") ? 'Failure to update product images.' : 'อัพเดทรูปสินค้า ไม่สำเร็จ');

            }else{

                $product = Product::collection("products")->where('prodCode', "=", $prodCode)->first();
    
                $exists = Storage::disk('local')->exists("public/product_images/".$prodCode.'/'.$image);
    
                if($exists){
                    Storage::delete('public/product_images/'.$prodCode.'/'.$image);
                }
    
                $index = array_search($image, $product[0]['image']);
                
                $imageName = $prodCode . '_'. $index . '.' . $request->file('image')->getClientOriginalExtension();
    
                $imageEncoded = File::get($request->file('image'));
                
                Storage::disk('local')->put('public/product_images/'.$prodCode.'/'.$imageName, $imageEncoded);

                app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'product image', [
                    'th' => 'อัพเดทรูปภาพสินค้า ' . $get_product['prodTName'],
                    'en' => 'Update product images: ' . $get_product['prodTName'],
                ]);
    
                return back()->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated product images.' : 'อัพเดทรูปสินค้า สำเร็จ');
            }

        }else return back()->with('fail', (\Session::get('locale') != "th") ? 'Failure to update product images.' : 'อัพเดทรูปสินค้า ไม่สำเร็จ');
    }

    public function deleteProductImage($prodCode, $image)
    {
        $get_product = app('App\Http\Controllers\ProductsController')->getProductNoUom($prodCode);

        $all_images = DB::connection('mongodb')->collection("products")->select('image')->where('prodCode', '=', $prodCode)->first();
     
        if(count($all_images['image']) < 2){

            return back()->with('fail', (\Session::get('locale') != "th") ? 'Must have 1 product image.' : 'ต้องมีรูปสินค้าไว้ 1 รูป');

        }else{

            $index = array_search($image, $all_images['image']);

            $image_del = $all_images['image'][$index];
    
            $exists = Storage::disk('local')->exists("public/product_images/".$prodCode.'/'.$image_del);
    
            if($exists){
    
                Storage::delete('public/product_images/'.$prodCode.'/'.$image_del);
    
                unset($all_images['image'][$index]);
    
                DB::table('products')->where('prodCode', $prodCode)->update(['image' => $all_images['image']]);

                app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'error', 'product image', [
                    'th' => 'ลบรูปภาพสินค้า ' . $get_product['prodTName'],
                    'en' => 'Delete product images: ' . $get_product['prodTName'],
                ]);
    
                return back()->withsuccess((\Session::get('locale') != "th") ? 'Successfully deleted product images.' : 'ลบรูปสินค้า สำเร็จ');

            }else return back()->with('fail', (\Session::get('locale') != "th") ? 'Failed to delete product images.' : 'ลบรูปสินค้า ไม่สำเร็จ');
            
        }
    }
}
