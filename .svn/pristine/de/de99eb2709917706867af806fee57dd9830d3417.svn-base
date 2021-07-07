<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Categorie;
use App\Product;

class CategoriesController extends Controller
{
    public function index($text = null)
    {
        if($text != null){
            $categories = Categorie::collection('categories')->select('*')->where('name' , 'like' , '%'.$text.'%' )->orderby('id','desc')->paginate(10);
        }else{
            $categories = Categorie::collection('categories')->select('*')->where('id','!=',0)->orderby('id','desc')->paginate(10);
        }

        $array_categories = self::getCategoriesCount($categories);

        return view('login.admin.displayCategorie',[
            'array_categories' => $array_categories,
            'categories' => $categories,
            'text_search_categorie' => $text
        ]);
    }

    // public function searchCategorie(Request $request)
    // {
    //     return self::index($request->input('search'));
    // }

    // public function editCategorie($id)
    // {
    //     $categories = Categorie::collection('categories')->select('*')->where('id','!=',0)->orderby('id','desc')->paginate(10);

    //     $array_categories = self::getCategoriesCount($categories);

    //     $edit = DB::connection('mongodb')->collection("categories")->where('id',"=",$id*1)->first();

    //     $categories_id = Categorie::collection('categories')->select('id')->get();
    
    //     $array_id = [];
    //     foreach ($categories_id as $item) {
    //         array_push($array_id, $item['id']);
    //     }

    //     return view('login.admin.displayCategorie', [
    //         'array_categories' => $array_categories,
    //         'categories' => $categories,
    //         'edit' => $edit,
    //         'categories_id' => $array_id,
    //         ]);
    // }

    // public function getCategoriesCount($categories)
    // {
    //     $array_categories = array();

    //     foreach($categories->items as $item){
    //         $count = DB::connection('mongodb')->collection("products")->where('categorie_id','=',$item['id'])->count();
    //         array_push($array_categories, array($item,'count' => $count));
    //     }

    //     return $array_categories;
    // }

    // public function createCategorie(Request $request)
    // {
    //     $categorie = $request->input('name');
    //     $newCategorieArray = array(
    //         'id' => Categorie::database()->collection("categories")->getModifySequence('id'),
    //         'name' => $categorie,
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'updated_at' => date('Y-m-d H:i:s')
    //     );
    //     $save = Categorie::database()->collection("categories")->insert($newCategorieArray);
    //     if($save){
    //         return back()->withsuccess('สร้างหมวดหมู๋สินค้า สำเร็จ');
    //     }else{
    //         return back()->with('fail', 'สร้างหมวดหมู๋สินค้า ไม่สำเร็จ');
    //     }
    // }

    // public function updateCategorie(Request $request, $id)
    // {
    //     $categorie_name = $request->input('name');
    //     $save = DB::connection('mongodb')->collection("categories")
    //         ->where('id',"=",$id*1)
    //         ->update([
    //             'name' => $categorie_name,
    //             'updated_at' => date('Y-m-d H:i:s')
    //             ]);

    //     if($save){
    //         return redirect()->route('adminCategories')->withsuccess('อัพเดทหมวดหมู๋สินค้า สำเร็จ');
    //     }else return redirect()->route('adminCategories')->with('fail', 'อัพเดทหมวดหมู๋สินค้า สำเร็จ');
    // }

    // public function deleteCategorie($id)
    // {
    //     $deleteresult = DB::connection('mongodb')->collection("categories")->where('id','=',$id*1)->delete();
    //     if($deleteresult){
    //         return back()->withsuccess('ลบหมวดหมู๋สินค้า สำเร็จ');
    //     }else return back()->with('fail', 'ลบหมวดหมู๋สินค้า ไม่สำเร็จ');
    // }

    public function showProducts($id)
    {
        $products = Product::collection('products')
        ->select('products.id as id','categories.name as categorie_name','products.categorie_id as categorie_id','products.image as image','products.name as name','products.stock as stock','products.description as description','products.price as price')
        ->leftjoin('categories','products.categorie_id','categories.id')
        ->where('products.categorie_id', '=', $id*1)
        ->orderby('products.id','desc')
        ->paginate(10);

        $categorie_name = DB::connection('mongodb')->collection("categories")->where('id','=',$id*1)->first();

        $categories_id = Categorie::collection('categories')->select('id')->get();
    
        $array_id = [];
        foreach ($categories_id as $item) {
            array_push($array_id, $item['id']);
        }

        return view('login.admin.displayProductsInCategorie',[
            'products' => $products,
            'categorie_name' => $categorie_name['name'],
            'categorie_id' => $categorie_name['id'],
            'categories_id' => $array_id,
        ]);
    }
}
