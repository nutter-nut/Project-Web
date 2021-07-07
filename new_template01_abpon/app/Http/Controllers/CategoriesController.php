<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Auth;
use Redirect;

use App\Product;
use App\Categorie;

class CategoriesController extends Controller
{

    public function index(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        $check = $request->input('categories_choice');

        $selectSort = $request->input('select_sort');

        if(!isset($selectSort)){

            $selectSort = "create";

            $sort = ['pm.productPOSId','desc'];

        }else{
            switch ($selectSort) {
                case "max-min":
                    $selectSort = "max-min";            
                    $sort = ['pu.prodUnitPrice','desc'];         
                    break;

                case "min-max":
                    $selectSort = "min-max";  
                    $sort = ['pu.prodUnitPrice','asc'];
                    break;

                case "create":
                    $selectSort = "create";                  
                    $sort = ['pm.productPOSId','desc'];
                    break;

                case "old":
                    $selectSort = "old";                  
                    $sort = ['pm.productPOSId','asc'];
                    break;

                case "name":
                    $selectSort = "name";            
                    $sort = ['pm.prodTName','asc'];
                    break;
                default:
                    return redirect()->route('Categories')->with('fail', (\Session::get('locale') != "th") ? 'Wrong sorting' : 'เรียงข้อมูลผิดพลาด');
            }
        }

        if($check){
            if(gettype($check)=="array"){

                $categories_id = [];

                foreach($check as $item){
                    array_push($categories_id, $item);
                }

                $str = json_encode($check);
                $str = substr($str, 1);
                $length_str = strlen($str);
                $str = substr($str, 0, $length_str - 1);
                $str = str_replace('"', "'", $str);

            }else{
                $categories_id = explode(",", $check);

                $str = json_encode($categories_id);
                $str = substr($str, 1);
                $length_str = strlen($str);
                $str = substr($str, 0, $length_str - 1);
                $str = str_replace('"', "'", $str);
            }

            $arr_str = explode(",", $str);
            $arr_str2 = explode(",", $str);
            $index_other = [];
            foreach($arr_str as $key => $item){
                if(strpos($item, ':other') !== false){
                    array_push($index_other, $key);
                    unset($arr_str2[$key]);
                } 
            }

            $arr_id_prodgroup = [];
            foreach($index_other as $item){
                $id_prodgroup = str_replace(":other'","", $arr_str[$item]);
                $id_prodgroup2 = str_replace("'","", $id_prodgroup);
                array_push($arr_id_prodgroup, $id_prodgroup2);
            }

            $search_id_type = implode(",", $arr_str2);
            ($arr_id_prodgroup !=null) ? $text_and_or = 'or' : $text_and_or = 'and';
            ($search_id_type != null) ? $text_search_id_type = $text_and_or . " pm.ProdTypeCode IN (".$search_id_type.")" : $text_search_id_type = '';

            if($arr_id_prodgroup){
                $str_other = json_encode($arr_id_prodgroup);
                $str_other = substr($str_other, 1);
                $length_str_other = strlen($str_other);
                $str_other = substr($str_other, 0, $length_str_other - 1);
                $search_id_group = str_replace('"', "'", $str_other);
   
                $str_qury = "
                    and pm.prodGroupCode IN (".$search_id_group.")
                    and (pm.ProdTypeCode is NULL or pm.ProdTypeCode = '') 
                    ".$text_search_id_type."
                ";

            }else{
                $str_qury = $text_search_id_type;
            }

            $products = self::getSearchProductAll($str_qury, $sort);

            $products_count = self::getProductCountAll($sort);

        }else{
            
            $categories_id = [];

            $products = self::getSearchProductAll($str_qury = null, $sort);

            $products_count = self::getProductCountAll($sort);

        }

        $array_product_group = self::getCategoriesWithCount($check);

        $arr_product = [];
        foreach($products as $key => $item){
            $image = app('App\Http\Controllers\ProductsController')->getLocationAttribute(app('App\Http\Controllers\ProductsController')->getImage($item->prodCode));
            $review_count = app('App\Http\Controllers\ProductsController')->reviewCount($item->prodCode, $item->uomCode);

            $arr_data = [
                'image' => $image != null ? $image : null,
                'product' => $item,
                'stock' => app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStock($item->prodCode, $item->uomCode),
                'ratting' => app('App\Http\Controllers\ProductsController')->sumRattingProduct($item->prodCode, $item->uomCode, $review_count),
                'data_promotion' => app('App\Http\Controllers\Admin\PromotionController')->getPromotionDetail($item->prodCode, $item->uomCode),
                'data_product' => app('App\Http\Controllers\ProductsController')->getProduct($item->prodCode, $item->uomCode),
            ];
            $arr_product[$item->prodCode][$key] = $arr_data;
        }

        $data = self::paginate($arr_product, 12);

        $str_categories_selected = implode(",", $categories_id);

        $text_page = "";
        foreach($categories_id as $item){
            $text = '&categories_choice[]=' . $item;
            $text_page .= $text;
        }

        return view('categories', [
                'group_categories' => $array_product_group,
                'totalQuantity' => $cart->totalQuantity,
                'select_sort' => $selectSort,
                'categories_selected' => $categories_id,
                'str_categories_selected' => $str_categories_selected,
                'text_page' => $text_page,
                'products' => $data,
                'products_count' => $products_count[0]->count
            ]);
    }

    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getCategoriesWithCount($str)
    {
        \Config::set('database.default', 'posone_mysql');

        $get_product_group = app('App\Http\Controllers\Admin\Product\ProductGroupController')->getProductGroup();

        $array_product_group = [];

        foreach($get_product_group as $item){
            $qury = "SELECT
                COUNT(DISTINCT pm.prodCode) as count,
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
                inner join productunitpos pu on  pm.prodCode=pu.productposCode
                inner join unitofmeasurepos u  on  u.uomCode=pu.prodUnit1UOMCode 
                left outer join productplaceorder plo on plo.prodcode=pm.prodCode
                left outer join productsetmenu psm on psm.prodcode=pm.prodCode
                Where pm.prodGroupCode='".$item->prodGroupCode."'
                and pm.companyCode='SINGLE' and prodstatus='N'";

            $get_data = DB::select(DB::raw($qury));

            $get_type_from_grodcode = app('App\Http\Controllers\Admin\Product\ProductTypeController')->getProductTypeByGroupCode($item->prodGroupCode);
            $text_page = [];
            foreach($get_type_from_grodcode as $item2){
                array_push($text_page, $item2->ProdTypeCode);
            }

            array_push($array_product_group, [
                'data' => $item,
                'prodGroupName' => $item->prodGroupName, 
                'prodGroupCode' => $item->prodGroupCode, 
                'type' => self::getProdTypeWithCount($item->prodGroupCode, $get_data[0]->count, $str),
                'count' => $get_data[0]->count,
                'text_page' => $text_page
            ]);
        }

        return $array_product_group;
    }

    public function getProdTypeWithCount($prodGroupCode, $count_all, $str)
    {
        \Config::set('database.default', 'posone_mysql');

        $type = app('App\Http\Controllers\Admin\Product\ProductTypeController')->getProductTypeByGroupCode($prodGroupCode);

        $count_num = 0;
        $count = [];
        foreach($type as $key => $item){
            $qury = "select COUNT(*) as count from productshopmasterpos where prodGroupCode = '".$prodGroupCode."' and ProdTypeCode = '".$item->ProdTypeCode."'";
            $get_data = DB::select(DB::raw($qury));
            $count_num += $get_data[0]->count;
            array_push($count, $get_data[0]->count);
        }

        if($type != null){
            $data_type = [];
            $arr_type = [];
            foreach($type as $key => $item){
                $data_type[$key] = [
                    'ProdTypeCode' => $item->ProdTypeCode,
                    'ProdTypeName' => $item->ProdTypeName,
                ];
                $arr_type[$key] = $item->ProdTypeCode;
            }
        }else{
            $data_type = [];
            $arr_type = [];
        }
        
        $count_other = $count_all - $count_num;

        $data = [
            'data' => $data_type,
            'count' => $count,
        ];

        array_push($data['data'], [
            'ProdTypeCode' => $prodGroupCode.':other',
            'ProdTypeName' => 'อื่นๆ'
        ]);

        array_push($data['count'], $count_other);

        return $data;
    }

    public function getSearchProductAll($str_qury, $sort)
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
            inner join productunitpos pu on  pm.prodCode=pu.productposCode
            inner join unitofmeasurepos u  on  u.uomCode=pu.prodUnit1UOMCode 
            left outer join productplaceorder plo on plo.prodcode=pm.prodCode
            left outer join productsetmenu psm on psm.prodcode=pm.prodCode
            Where pm.companyCode='SINGLE' and prodstatus='N' $str_qury
            order by $sort[0] $sort[1]";

        $products = DB::select(DB::raw($qury));

        return $products;
    }

    public function getProductCountAll($sort)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury_count = "SELECT                
            COUNT(*) as count,
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
            inner join productunitpos pu on  pm.prodCode=pu.productposCode
            inner join unitofmeasurepos u  on  u.uomCode=pu.prodUnit1UOMCode 
            left outer join productplaceorder plo on plo.prodcode=pm.prodCode
            left outer join productsetmenu psm on psm.prodcode=pm.prodCode                
            Where pm.companyCode='SINGLE' and prodstatus='N'
            order by $sort[0] $sort[1]";

        $products_count = DB::select(DB::raw($qury_count));

        return $products_count;
    }

}
