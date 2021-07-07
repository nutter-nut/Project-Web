<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;

use App\Product;
use App\Cart;
use App\Review;

class ProductsController extends Controller
{
    public function getProductQury($prodCode, $uomCode)
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
                pg.prodGroupName,
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
                LEFT OUTER JOIN productgrouppos pg ON pm.prodGroupCode = pg.prodGroupCode
                Where pm.prodcode='" . $prodCode . "' and u.uomCode='" . $uomCode . "'
                and pm.companyCode='SINGLE' and prodstatus='N'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function getStockNow($get_data, $get_stock, $prodCode, $uomCode, $page)
    {
        $config = DB::connection('mongodb')->collection("config")->get();

        $sell = self::searchForId($config[20]['value'][0], $get_stock);
        $stock_now = [
            'ProdAllowMinus' => ($get_data[0]->ProdAllowMinus != null) ? 'Y' : 'N', //y ติดลบได้ n ติดลบไม่ได้
            'endQty' => ($get_stock != null)
                ? $get_stock[$sell]->endQty * 1
                : self::getStockMain($get_data, $get_stock, $prodCode, $uomCode, $config, $page, $get_data[0]->ProdAllowMinus),
            'stock' => ($get_stock != null)
                ? $get_stock[$sell]->endQty * 1
                : self::getStockMain($get_data, $get_stock, $prodCode, $uomCode, $config, 'product_details', $get_data[0]->ProdAllowMinus),
        ];

        return $stock_now;
    }

    public function getStockMain($get_data, $get_stock, $prodCode, $uomCode, $config, $page, $ProdAllowMinus)
    {
        $getSearchStock = app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStock($prodCode, $uomCode);

        if ($getSearchStock != null) {

            return $getSearchStock / self::getProduct($prodCode, $uomCode)['prodUnitRatio'];

        } else {

            $stock = self::searchForRatio('1', self::getUomName($prodCode));

            if (gettype($stock) == 'integer' && $ProdAllowMinus != 'Y') {

                $divide = ($page == 'cart') ? self::getProduct($prodCode, $uomCode)['prodUnitRatio'] : 1; 
                
                $whhous = $config[20]['value'][0];

                $getSearchStock = app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStock($prodCode, $uomCode);

                ($getSearchStock != null)
                    ? $stock2 = app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStock($prodCode, $uomCode)[self::searchForId($whhous, $getSearchStock)]->endQty / $divide
                    : $stock2 = 0;

            } else $stock2 = 999;

            return $stock2 * 1;
        }
    }

    public function productDetails(Request $request, $prodCode, $uomCode)
    {
        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        $get_data = self::getProductQury($prodCode, $uomCode);

        if ($get_data == null) return redirect()->route('Index')->with('fail', (\Session::get('locale') != "th") ? 'No data found' : 'ไม่พบข้อมูล');

        $get_stock = app('App\Http\Controllers\Admin\Treasury\StockController')->getSearchStock($get_data[0]->prodCode, $get_data[0]->prodUnit1UOMCode);

        $product = Product::collection("products")->select('*')->where('prodCode', '=', $prodCode)->andwhere('uomCode', '=', $uomCode)->first();

        $reviews = Review::collection('reviews')
            ->select('users.name as user_name', 'users.image as user_image', 'reviews.created_at as date', 'reviews.text as review', 'reviews.ratting as ratting', 'reviews.id')
            ->leftjoin('users', 'reviews.user_id', 'users.id')
            ->groupby('$selected')
            ->orderby('reviews.id', 'desc')
            ->where('reviews.prodCode', '=', $prodCode)
            ->paginate(3);

        $get_uomname = self::getUomName($prodCode);

        // $get_image = self::getLocationAttribute(self::getImage($prodCode));
        $get_image = DB::connection('mongodb')->collection("products")->where('prodCode', '=', $prodCode)->first()['image'];

        $price = $product[0]['price'];

        $arr_price = [];
        foreach ($get_uomname as $key => $item) {
            $arr_price[$key]['item'] = $item;
            $arr_price[$key]['price'] = $item['price'];
            $arr_price[$key]['data_product'] = self::getPromotionText($prodCode, $item['uomCode']);
        }

        $product = Product::collection('products')->select('*')->where('prodCode', '=', $prodCode)->get();

        $stock_now = self::getStockNow($get_data, $get_stock, $prodCode, $uomCode, 'product_details');

        $qty_all = 0;
        foreach ($cart->items as $key => $item) {
            $produCode_cart = $item['data']['prodCode'];
            if($prodCode == $produCode_cart){
                $qty_all += $item['quantity'] * $item['ratio'];
            }
        }

        $qury2 = "select * from productshopmasterpos where prodCode='".$prodCode."'";
        $get_data2 = DB::select(DB::raw($qury2));
        $get_data_product = [
            'prodGroupCode' => app('App\Http\Controllers\Admin\Product\ProductGroupController')->getProductGroupByCode($get_data2[0]->prodGroupCode)[0]->prodGroupName,
            'ProdTypeCode' => app('App\Http\Controllers\Admin\Product\ProductTypeController')->getProductTypeByCode($get_data2[0]->ProdTypeCode),
            'ProdBrandCode' => app('App\Http\Controllers\Admin\Product\ProductBrandController')->getProductBrandByCode($get_data2[0]->ProdBrandCode),
            'ProdModelCode' => app('App\Http\Controllers\Admin\Product\ProductModelController')->getProductModelByCode($get_data2[0]->ProdModelCode),
        ];

        $get_type_from_grodcode = app('App\Http\Controllers\Admin\Product\ProductTypeController')->getProductTypeByGroupCode($get_data2[0]->prodGroupCode);
        $text_page = [];
        foreach($get_type_from_grodcode as $item){
            array_push($text_page, $item->ProdTypeCode);
        }

        return view('product_details', [
            'get_data' => $get_data[0],
            'totalQuantity' => $cart->totalQuantity,
            'get_stock' => $get_stock,
            'review_count' => isset($product[0]['review_count']) ? $product[0]['review_count'] : null,
            'review_count_star' => isset($product[0]['review_count_star']) ? $product[0]['review_count_star'] : null,
            'ratting_product' => isset($product[0]['ratting_product']) ? $product[0]['ratting_product'] : null,
            'reviews' => $reviews,
            'get_uomname' => $get_uomname,
            'uomCode' => $uomCode,
            'get_image' => $get_image,
            'price' => $price,
            'arr_price' => $arr_price,
            'promotion' => self::getPromotionText($prodCode, $uomCode),
            'details' => $product[0]['details'],
            'stock_now' => $stock_now,
            'stock_limit' => $stock_now['endQty'] - $qty_all,
            'cart' => $cart->items,
            'get_data_product' => $get_data_product,
            'best_seller' => $product[0]['best_seller'],
            'text_page' => $text_page
        ]);
    }

    public function getPromotionText($prodCode, $uomCode)
    {
        $data_product = app('App\Http\Controllers\Admin\PromotionController')->getPromotionDetail($prodCode, $uomCode);

        if (isset($data_product)) {
            $data = $data_product['text_promotion'] . " (-" . $data_product['discount'] . "%)";
        } else $data = null;

        return $data;
    }

    public function getUomName($prodCode)
    {
        $get_data = DB::connection('mongodb')->collection("products")->select('*')->where([['prodCode', '=', $prodCode]])->orderBy('prodUnitRatio', 'asc')->get();

        // $get_data = Product::collection("products")->select('*')->where('prodCode', '=', $prodCode)->orderby('prodUnitRatio', 'asc')->get();

        return $get_data;
    }

    public function reviewCount($prodCode, $uomCode)
    {
        $review_count = DB::connection('mongodb')->collection("reviews")->where('prodCode', '=', $prodCode)->count();

        return $review_count;
    }

    public function reviewCountStar($prodCode, $uomCode, $review_count)
    {
        $review_count_star = array();

        for ($i = 1; $i <= 5; $i++) {
            $ratting = DB::connection('mongodb')->collection("reviews")->where('prodCode', '=', $prodCode)->where('ratting', '=', $i)->count();
            $ratting != 0 ?  $percen = ($ratting / $review_count) * 100 : $percen = 0;
            array_push($review_count_star, array($ratting, sprintf("%01.1f", $percen)));
        }

        return $review_count_star;
    }

    public function sumRattingProduct($prodCode, $uomCode, $review_count)
    {
        $sum_ratting_product = DB::connection('mongodb')->collection("reviews")->where('prodCode', '=', $prodCode)->sum('ratting');

        if ($sum_ratting_product != 0) {
            $update_ratting = DB::connection('mongodb')->collection("products")
                ->where('prodCode', '=', $prodCode)
                ->update([
                    'ratting' => $sum_ratting_product / ($review_count * 5) * 5,
                ]);
        }

        $sum_ratting_product != 0 ? $ratting_product = $sum_ratting_product / ($review_count * 5) * 5 : $ratting_product = 0;

        return $ratting_product;
    }

    public function reviewProduct(Request $request, $prodCode, $uomCode)
    {
        $validatedData = $request->validate([
            'text_review' => 'required',
            'rating' => 'required',
        ]);
        
        $produc_pos = $this->getProductAtPOS($prodCode);

        $user_id = Auth::user()->id * 1;

        $text = $request->text_review;

        $ratting = $request->rating * 1.0;

        $date = date('Y-m-d H:i:s');

        $newRevireArray = array(
            'id' => Review::database()->collection("reviews")->getModifySequence('id'),
            'prodCode' => $prodCode,
            'user_id' => $user_id,
            'text' => $text,
            'ratting' => $ratting,
            'created_at' => $date,
            'updated_at' => $date
        );

        $save = Review::database()->collection("reviews")->insert($newRevireArray);

        if ($save) {

            $review_count = self::reviewCount($prodCode, $uomCode);

            $review_count_star = self::reviewCountStar($prodCode, $uomCode, $review_count);

            $ratting_product = self::sumRattingProduct($prodCode, $uomCode, $review_count);

            $update_ratting = DB::connection('mongodb')->collection("products")
                ->where('prodCode', '=', $prodCode)
                ->update([
                    "review_count" => $review_count,
                    "review_count_star" => $review_count_star,
                    "ratting_product" => $ratting_product,
                ]);

            return redirect()->route('productDetal', [
                'prodCode' => $prodCode,
                'uomCode' => $uomCode,
                'name' => $produc_pos[0]->prodTName,
            ])->withsuccess((\Session::get('locale') != "th") ? 'Successful product review.' : 'รีวิวสินค้าสำเร็จ');
        }
    }

    public function searchProduct(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $search_text = $request->input('search_text');

        if ($search_text) {

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
            pg.prodGroupName,
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
            LEFT OUTER JOIN productgrouppos pg ON pm.prodGroupCode = pg.prodGroupCode
            Where pm.prodTName like '%$search_text%' and pm.companyCode='SINGLE' and prodstatus='N'";

            $products = DB::select(DB::raw($qury));
        } else {

            $products = [];
        }

        $cart = app('App\Http\Controllers\CartController')->getCart($request);

        return view('search', [
            'products' => $products,
            'totalQuantity' => $cart->totalQuantity,
            'search_text' => $search_text,
        ]);
    }

    public function getImage($prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productpicturepos where ProdCode ='" . $prodCode . "'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function getProductAtPOS($prodCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productshopmasterpos where prodCode ='" . $prodCode . "'";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function getProduct($prodCode, $uomCode)
    {
        $get_data = DB::connection('mongodb')->collection("products")->select('*')->where([['prodCode', '=', $prodCode], ['uomCode', '=', $uomCode]])->first();

        return $get_data;
    }

    public function getProductNoUom($prodCode)
    {
        $get_data = DB::connection('mongodb')->collection("products")->where("prodCode", "=", $prodCode)->first();

        return $get_data;
    }

    public function getLocationAttribute($val)
    {
        if ($val != null) {
            $file_name = [];
            foreach ($val as $key => $item) {
                $file_name[$key] = $item->ProdPicName;
            }
            $file_name2 = implode("", $file_name);

            if (\File::exists('posone_images/SINGLE/MenuGroup/' . $file_name2)) {
                $data = [
                    'exists' => true,
                    'url' => url("posone_images/SINGLE/MenuGroup/{$file_name2}"),
                ];
            } else {
                $data = [
                    'exists' => false,
                    'url' => url("storage/product_images/product_default.png"),
                ];
            }
        } else {
            $data = [
                'exists' => false,
                'url' => url("storage/product_images/product_default.png"),
            ];
        }

        return $data;
    }

    public function searchForId($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val->whCode === $id) {
                return $key;
            }
        }
        return null;
    }

    public function searchForRatio($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['prodUnitRatio'] === $id) {
                return $key;
            }
        }
        return null;
    }
}
