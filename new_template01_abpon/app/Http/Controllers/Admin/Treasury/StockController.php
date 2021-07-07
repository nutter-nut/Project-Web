<?php

namespace App\Http\Controllers\Admin\Treasury;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Product;

use Auth;

class StockController extends Controller
{
    public function index($get_data_edit = null)
    {
        $get_stock = self::getStock();

        $get_products = self::getProducts();

        $get_treasury = app('App\Http\Controllers\Admin\Treasury\TreasuryController')->getTreasury();

        if($get_data_edit != null){
            $data_edit = [
                'data_edit' => $get_data_edit[0],
                'get_uomCode' => self::getUomCode($get_data_edit[0]->stockProdCode),
            ];
        }

        if($get_products != null){
            $get_last_UomCode = app('App\Http\Controllers\Admin\Treasury\StockController')->getUomCode($get_products[0]->prodCode);
        }else{
            $get_last_UomCode = null;
        }
       

        $arr_products = [];
        foreach ($get_products as $key => $item) {
            $arr_products[$item->prodGroupCode]['data'][$key] = $item;
            $arr_products[$item->prodGroupCode]['prod_gorup_name'] = $item->prodGroupName;
        }
// dd($get_stock);
        return view('login.admin.posone.displayStock', [
            'get_stock' => $get_stock,
            'get_treasury' => $get_treasury,
            'data_edit' => $get_data_edit != null ? $data_edit : null,
            'get_products' => $arr_products,
            'get_last_UomCode' => $get_last_UomCode
        ]);
    }

    public function getProducts()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select
        prodCode,
        prodTName,
        prodGroupCode,
        prodIsVat,
        prodGroupName,
        whCode,
        prodBalOnHand,
        whTName,uomCode,uomName,
        counter.FOUND_ROW_NUMBER 
        from
        (
        
        SELECT
        productshopmasterpos.prodCode,
        productshopmasterpos.prodTName,
        productshopmasterpos.prodGroupCode,
        productshopmasterpos.prodIsVat,
        productgrouppos.prodGroupName,
        whCode,
        ifnull(prodBalOnHand,0) as  prodBalOnHand,
        whTName,uomCode,uomName
        FROM
        productshopmasterpos
        INNER JOIN productgrouppos ON productshopmasterpos.prodGroupCode = productgrouppos.prodGroupCode
        INNER JOIN(
        SELECT
        unitofmeasurepos.uomCode,
        unitofmeasurepos.uomName,
        productunitpos.productPOSCode
        FROM
        productunitpos
        INNER JOIN unitofmeasurepos ON productunitpos.prodUnit1UOMCode = unitofmeasurepos.uomCode
        where prodUnitRatio=1
        )UNIT on productshopmasterpos.prodCode=UNIT.productPOSCode 
        left OUTER JOIN
        (
        SELECT
        productstaticpos.productPOSCode,
        productstaticpos.whCode,
        sum(productstaticpos.prodBalOnHand) as prodBalOnHand,
        warehousepos.whTName
        FROM
        productstaticpos
        INNER JOIN warehousepos ON productstaticpos.whCode = warehousepos.whCode
        where productstaticpos.companyCode='SINGLE' 
        GROUP BY productPOSCode
        
        )STOCK on productshopmasterpos.prodCode=STOCK.productPOSCode 
        where  productshopmasterpos.companyCode='SINGLE' 
        and prodStatus !='Y' and productshopmasterpos.placeOrder != 'N' and prodIsComplementary !='Y'
        
        group by  productshopmasterpos.prodCode
         order by productshopmasterpos.prodCode limit 0,100) As Item
                    JOIN (
        SELECT
        count(productshopmasterpos.prodCode) as FOUND_ROW_NUMBER
        FROM
        productshopmasterpos
        INNER JOIN productgrouppos ON productshopmasterpos.prodGroupCode = productgrouppos.prodGroupCode
        INNER JOIN(
        SELECT
        unitofmeasurepos.uomCode,
        unitofmeasurepos.uomName,
        productunitpos.productPOSCode
        FROM
        productunitpos
        INNER JOIN unitofmeasurepos ON productunitpos.prodUnit1UOMCode = unitofmeasurepos.uomCode
        where prodUnitRatio=1
        )UNIT on productshopmasterpos.prodCode=UNIT.productPOSCode 
        left OUTER JOIN
        (
        SELECT
        productstaticpos.productPOSCode,
        productstaticpos.whCode,
        sum(productstaticpos.prodBalOnHand) as prodBalOnHand,
        warehousepos.whTName
        FROM
        productstaticpos
        INNER JOIN warehousepos ON productstaticpos.whCode = warehousepos.whCode
        where productstaticpos.companyCode='SINGLE' 
        GROUP BY productPOSCode
        
        )STOCK on productshopmasterpos.prodCode=STOCK.productPOSCode 
        where  productshopmasterpos.companyCode='SINGLE' 
        and prodStatus !='Y' and productshopmasterpos.placeOrder != 'N' and prodIsComplementary !='Y'
        
        ) AS counter";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function getUomCode($prodCode)
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
// dd($get_data);
        return $get_data;
    }

    public function getStock()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "SELECT MOVEND.companyCode,
        MOVEND.whCode,
        warehousepos.whTName,
        MOVEND.stockProdCode,
        PRODUCT.prodTName, PRODUCT.ProdTypeCode,
        PRODUCT.prodGroupCode,
        PRODUCT.prodGroupName,
        UNIT.prodUnit1UOMCode,
        MOVEND.endQty,
IFNULL(PRODUCTCHECKSTOCK.ProdQty,0) AS ProdQty,
IFNULL(PRODUCTCHECKSTOCK.prodOnhandQty,0) AS prodOnhandQty,uomName

FROM (SELECT movingproductstock.companyCode,
        movingproductstock.whCode,
        movingproductstock.stockProdCode,
        movingproductstock.endQty
        FROM movingproductstock
        INNER JOIN (SELECT movingproductstock.whCode,
                    movingproductstock.stockProdCode,
                    MAX(movingproductstock.stockId) AS stockId
                    FROM movingproductstock 
                    inner join productshopmasterpos pm on movingproductstock.stockprodcode = pm.prodcode
                    WHERE movingproductstock.stockDocDate <= 'YYYY-MM-DD'
                    GROUP BY movingproductstock.whCode,
                    movingproductstock.stockProdCode) AS ENDID
        ON movingproductstock.stockId=ENDID.stockId) AS MOVEND

INNER JOIN warehousepos ON MOVEND.whCode=warehousepos.whCode

INNER JOIN (SELECT productshopmasterpos.prodCode,
        productshopmasterpos.prodTName,ProdTypeCode,
        productshopmasterpos.prodGroupCode,
        productgrouppos.prodGroupName
        FROM productgrouppos
        INNER JOIN productshopmasterpos ON productshopmasterpos.prodGroupCode = productgrouppos.prodGroupCode
        where prodstatus='N' ) AS PRODUCT
        ON MOVEND.stockProdCode=PRODUCT.prodCode
        INNER JOIN (SELECT productunitpos.productPOSCode,
                    productunitpos.prodUnit1UOMCode,unitofmeasurepos.uomName
                    FROM productunitpos
                    inner join unitofmeasurepos
                    on unitofmeasurepos.uomCode=productunitpos.prodUnit1UOMCode
                    WHERE productunitpos.prodUnitRatio=1) AS UNIT
        ON MOVEND.stockProdCode=UNIT.productPOSCode

LEFT OUTER JOIN (
                SELECT
                productcheckstockmasterpos.ChkProdDivisionCode,
                productcheckstockmasterpos.ChkProdWhCode,
                productcheckstockdetailpos.ProductPOSCode,
                sum(productcheckstockdetailpos.ProdQty) as ProdQty,sum(prodOnhandQty) as prodOnhandQty,
                productcheckstockdetailpos.ProductUnitCode
                FROM productcheckstockmasterpos
                INNER JOIN productcheckstockdetailpos ON productcheckstockdetailpos.chkProdId = productcheckstockmasterpos.ChkProdId
                WHERE productcheckstockmasterpos.ChkProdDocDate <= 'YYYY-MM-DD'  and ChkProdStatus='A'
                GROUP BY ProductPOSCode,productcheckstockdetailpos.ProductUnitCode,ChkProdWhCode,ChkProdDivisionCode
                ORDER BY  productcheckstockdetailpos.ProductPOSCode,ChkProdWhCode
                ) AS PRODUCTCHECKSTOCK
ON (MOVEND.whCode=PRODUCTCHECKSTOCK.ChkProdWhCode AND MOVEND.stockProdCode=PRODUCTCHECKSTOCK.ProductPOSCode)
where (1=1)  ORDER BY MOVEND.whCode,PRODUCT.prodGroupCode,MOVEND.stockProdCode ASC";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function getSearchStock($stockProdCode, $prodUnit1UOMCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "SELECT MOVEND.companyCode,
        MOVEND.whCode,
        warehousepos.whTName,
        MOVEND.stockProdCode,
        PRODUCT.prodTName, PRODUCT.ProdTypeCode,
        PRODUCT.prodGroupCode,
        PRODUCT.prodGroupName,
        UNIT.prodUnit1UOMCode,
        MOVEND.endQty,
IFNULL(PRODUCTCHECKSTOCK.ProdQty,0) AS ProdQty,
IFNULL(PRODUCTCHECKSTOCK.prodOnhandQty,0) AS prodOnhandQty,uomName

FROM (SELECT movingproductstock.companyCode,
        movingproductstock.whCode,
        movingproductstock.stockProdCode,
        movingproductstock.endQty
        FROM movingproductstock
        INNER JOIN (SELECT movingproductstock.whCode,
                    movingproductstock.stockProdCode,
                    MAX(movingproductstock.stockId) AS stockId
                    FROM movingproductstock 
                    inner join productshopmasterpos pm on movingproductstock.stockprodcode = pm.prodcode
                    WHERE movingproductstock.stockDocDate <= 'YYYY-MM-DD'
                    GROUP BY movingproductstock.whCode,
                    movingproductstock.stockProdCode) AS ENDID
        ON movingproductstock.stockId=ENDID.stockId) AS MOVEND

INNER JOIN warehousepos ON MOVEND.whCode=warehousepos.whCode

INNER JOIN (SELECT productshopmasterpos.prodCode,
        productshopmasterpos.prodTName,ProdTypeCode,
        productshopmasterpos.prodGroupCode,
        productgrouppos.prodGroupName
        FROM productgrouppos
        INNER JOIN productshopmasterpos ON productshopmasterpos.prodGroupCode = productgrouppos.prodGroupCode
        where prodstatus='N' ) AS PRODUCT
        ON MOVEND.stockProdCode=PRODUCT.prodCode
        INNER JOIN (SELECT productunitpos.productPOSCode,
                    productunitpos.prodUnit1UOMCode,unitofmeasurepos.uomName
                    FROM productunitpos
                    inner join unitofmeasurepos
                    on unitofmeasurepos.uomCode=productunitpos.prodUnit1UOMCode
                    WHERE productunitpos.prodUnitRatio=1) AS UNIT
        ON MOVEND.stockProdCode=UNIT.productPOSCode

LEFT OUTER JOIN (
                SELECT
                productcheckstockmasterpos.ChkProdDivisionCode,
                productcheckstockmasterpos.ChkProdWhCode,
                productcheckstockdetailpos.ProductPOSCode,
                sum(productcheckstockdetailpos.ProdQty) as ProdQty,sum(prodOnhandQty) as prodOnhandQty,
                productcheckstockdetailpos.ProductUnitCode
                FROM productcheckstockmasterpos
                INNER JOIN productcheckstockdetailpos ON productcheckstockdetailpos.chkProdId = productcheckstockmasterpos.ChkProdId
                WHERE productcheckstockmasterpos.ChkProdDocDate <= 'YYYY-MM-DD'  and ChkProdStatus='A'
                GROUP BY ProductPOSCode,productcheckstockdetailpos.ProductUnitCode,ChkProdWhCode,ChkProdDivisionCode
                ORDER BY  productcheckstockdetailpos.ProductPOSCode,ChkProdWhCode
                ) AS PRODUCTCHECKSTOCK
ON (MOVEND.whCode=PRODUCTCHECKSTOCK.ChkProdWhCode AND MOVEND.stockProdCode=PRODUCTCHECKSTOCK.ProductPOSCode)
where (1=1) and MOVEND.stockProdCode = '$stockProdCode' ORDER BY MOVEND.whCode,PRODUCT.prodGroupCode,MOVEND.stockProdCode ASC";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function getSearchStockWhCode($stockProdCode, $whCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "SELECT MOVEND.companyCode,
        MOVEND.whCode,
        warehousepos.whTName,
        MOVEND.stockProdCode,
        PRODUCT.prodTName, PRODUCT.ProdTypeCode,
        PRODUCT.prodGroupCode,
        PRODUCT.prodGroupName,
        UNIT.prodUnit1UOMCode,
        MOVEND.endQty,
IFNULL(PRODUCTCHECKSTOCK.ProdQty,0) AS ProdQty,
IFNULL(PRODUCTCHECKSTOCK.prodOnhandQty,0) AS prodOnhandQty,uomName

FROM (SELECT movingproductstock.companyCode,
        movingproductstock.whCode,
        movingproductstock.stockProdCode,
        movingproductstock.endQty
        FROM movingproductstock
        INNER JOIN (SELECT movingproductstock.whCode,
                    movingproductstock.stockProdCode,
                    MAX(movingproductstock.stockId) AS stockId
                    FROM movingproductstock 
                    inner join productshopmasterpos pm on movingproductstock.stockprodcode = pm.prodcode
                    WHERE movingproductstock.stockDocDate <= 'YYYY-MM-DD'
                    GROUP BY movingproductstock.whCode,
                    movingproductstock.stockProdCode) AS ENDID
        ON movingproductstock.stockId=ENDID.stockId) AS MOVEND

INNER JOIN warehousepos ON MOVEND.whCode=warehousepos.whCode

INNER JOIN (SELECT productshopmasterpos.prodCode,
        productshopmasterpos.prodTName,ProdTypeCode,
        productshopmasterpos.prodGroupCode,
        productgrouppos.prodGroupName
        FROM productgrouppos
        INNER JOIN productshopmasterpos ON productshopmasterpos.prodGroupCode = productgrouppos.prodGroupCode
        where prodstatus='N' ) AS PRODUCT
        ON MOVEND.stockProdCode=PRODUCT.prodCode
        INNER JOIN (SELECT productunitpos.productPOSCode,
                    productunitpos.prodUnit1UOMCode,unitofmeasurepos.uomName
                    FROM productunitpos
                    inner join unitofmeasurepos
                    on unitofmeasurepos.uomCode=productunitpos.prodUnit1UOMCode
                    WHERE productunitpos.prodUnitRatio=1) AS UNIT
        ON MOVEND.stockProdCode=UNIT.productPOSCode

LEFT OUTER JOIN (
                SELECT
                productcheckstockmasterpos.ChkProdDivisionCode,
                productcheckstockmasterpos.ChkProdWhCode,
                productcheckstockdetailpos.ProductPOSCode,
                sum(productcheckstockdetailpos.ProdQty) as ProdQty,sum(prodOnhandQty) as prodOnhandQty,
                productcheckstockdetailpos.ProductUnitCode
                FROM productcheckstockmasterpos
                INNER JOIN productcheckstockdetailpos ON productcheckstockdetailpos.chkProdId = productcheckstockmasterpos.ChkProdId
                WHERE productcheckstockmasterpos.ChkProdDocDate <= 'YYYY-MM-DD'  and ChkProdStatus='A'
                GROUP BY ProductPOSCode,productcheckstockdetailpos.ProductUnitCode,ChkProdWhCode,ChkProdDivisionCode
                ORDER BY  productcheckstockdetailpos.ProductPOSCode,ChkProdWhCode
                ) AS PRODUCTCHECKSTOCK
ON (MOVEND.whCode=PRODUCTCHECKSTOCK.ChkProdWhCode AND MOVEND.stockProdCode=PRODUCTCHECKSTOCK.ProductPOSCode)
where (1=1) and MOVEND.stockProdCode = '$stockProdCode' and MOVEND.whCode = '$whCode' ORDER BY MOVEND.whCode,PRODUCT.prodGroupCode,MOVEND.stockProdCode ASC";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function stockInsert(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $request->validate([
            'prodCode' => 'required',
            'uomCode' => 'required',
            'prodQty' => 'required',
        ]);

        //-----------------------------------------
        $get_AdjDocNo = self::getLastAdjDocNo();

        if($get_AdjDocNo != null){
            $str = "Lot_".$get_AdjDocNo[0]->AdjDocNo."_1";
            $number = substr($str, -6, 4) + 1;
        }else{
            $str = "Lot_AJP-00-".date("ym")."/0001_1";
            $number = 1;
        }
  
        $number2 = substr(str_repeat(0, 4).$number, - 4);

        $str_01 = substr($str, 0, 11).date("ym")."/".$number2."_1"; //Lot_AJP-00-2012/0016_1
        $str_02 = substr($str, 4, 7).date("ym")."/".$number2; //AJP-00-2012/0016
        //-----------------------------------------

        $date = date("Y-m-d")." ".date("h:i:s");
        $date2 = date("Y-m-d");

        $arr_prodCode = explode(',', $request->input("prodCode"));
        $prodCode = $arr_prodCode[0];
        $prodName = $arr_prodCode[1];

        $prodQty = $request->input("prodQty");

        $uomCode_data = explode(',', $request->input("uomCode"));

        $check_str = strpos($uomCode_data[0], '[') !== false && strpos($uomCode_data[1], ']') !== false;

        $uomCode = $check_str ? str_replace("[", "", $uomCode_data[0]) : $uomCode_data[0];
        
        $prodUnitRatio = $check_str ? str_replace("]", "", $uomCode_data[1]) : $uomCode_data[1];

        // $whCode = "POSWH-00-03"; //! ทำต่อ
        $treasury_select = app('App\Http\Controllers\Admin\Treasury\TreasuryController')->treasuryNow();

        $whCode = $treasury_select['value'][0];

        $getSearchStockWhCode = self::getSearchStockWhCode($prodCode, $whCode);

        $endQty = $getSearchStockWhCode != null ? $getSearchStockWhCode[0]->endQty : 0;

        $after_endQty = $endQty + ( ($prodQty * 1.0) * ($prodUnitRatio * 1.0) );

        $qury = [
            "call sp_prodlotdetail_insert ('".$str_01."', $prodQty, 0, 0, $prodQty, 0, 0, '".$date."', '".$prodCode."', 'SINGLE')",
            "call sp_prodlotmaster_update ($after_endQty, 0, '".$date."', 'SINGLE00-0001', '".$prodCode."')",
            "call sp_avgprodprice_update (1, 0, -165, 'SINGLE00-0001', '".$date."', 0, '".$prodCode."', '00')", //! -165 คือ
            "call sp_movingproductstock_insert ('SINGLE00-0001', '".$date."', '', 0, 1, 0, 'SINGLE', '', '".$whCode."', 'AJP', '".$str_02."', '".$date2."', '".$prodCode."', $endQty, $prodQty, $after_endQty, 'insert web')",
            "call sp_productstaticpos_update ($after_endQty, '".$prodCode."', '".$whCode."')",
            "call sp_adjustproductdetailpos_insert ('', '', '', '".$str_02."', 1, '".$prodCode."', 0, $prodQty, '".$whCode."', '".$uomCode."', 'SINGLE')",
        ];
        
        foreach ($qury as $item) {
            DB::select(DB::raw($item));
        }

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'success', 'product stock', [
            'th' => 'เพิ่มสินค้าคงเหลือ ' . $prodName . ': ' . $prodQty . ' ชิ้น',
            'en' => 'Successfully created ' . $prodName . '(' . $prodQty . ') product stock.',
        ]);

        return back()->withsuccess((\Session::get('locale') != "th") ? 'Successfully saved.' : 'บันทึกสำเร็จ');
    }

    public function stockEdit($whCode, $stockProdCode)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "SELECT MOVEND.companyCode,
        MOVEND.whCode,
        warehousepos.whTName,
        MOVEND.stockProdCode,
        PRODUCT.prodTName, PRODUCT.ProdTypeCode,
        PRODUCT.prodGroupCode,
        PRODUCT.prodGroupName,
        UNIT.prodUnit1UOMCode,
        MOVEND.endQty,
IFNULL(PRODUCTCHECKSTOCK.ProdQty,0) AS ProdQty,
IFNULL(PRODUCTCHECKSTOCK.prodOnhandQty,0) AS prodOnhandQty,uomName

FROM (SELECT movingproductstock.companyCode,
        movingproductstock.whCode,
        movingproductstock.stockProdCode,
        movingproductstock.endQty
        FROM movingproductstock
        INNER JOIN (SELECT movingproductstock.whCode,
                    movingproductstock.stockProdCode,
                    MAX(movingproductstock.stockId) AS stockId
                    FROM movingproductstock 
                    inner join productshopmasterpos pm on movingproductstock.stockprodcode = pm.prodcode
                    WHERE movingproductstock.stockDocDate <= 'YYYY-MM-DD'
                    GROUP BY movingproductstock.whCode,
                    movingproductstock.stockProdCode) AS ENDID
        ON movingproductstock.stockId=ENDID.stockId) AS MOVEND

INNER JOIN warehousepos ON MOVEND.whCode=warehousepos.whCode

INNER JOIN (SELECT productshopmasterpos.prodCode,
        productshopmasterpos.prodTName,ProdTypeCode,
        productshopmasterpos.prodGroupCode,
        productgrouppos.prodGroupName
        FROM productgrouppos
        INNER JOIN productshopmasterpos ON productshopmasterpos.prodGroupCode = productgrouppos.prodGroupCode
        where prodstatus='N' ) AS PRODUCT
        ON MOVEND.stockProdCode=PRODUCT.prodCode
        INNER JOIN (SELECT productunitpos.productPOSCode,
                    productunitpos.prodUnit1UOMCode,unitofmeasurepos.uomName
                    FROM productunitpos
                    inner join unitofmeasurepos
                    on unitofmeasurepos.uomCode=productunitpos.prodUnit1UOMCode
                    WHERE productunitpos.prodUnitRatio=1) AS UNIT
        ON MOVEND.stockProdCode=UNIT.productPOSCode

LEFT OUTER JOIN (
                SELECT
                productcheckstockmasterpos.ChkProdDivisionCode,
                productcheckstockmasterpos.ChkProdWhCode,
                productcheckstockdetailpos.ProductPOSCode,
                sum(productcheckstockdetailpos.ProdQty) as ProdQty,sum(prodOnhandQty) as prodOnhandQty,
                productcheckstockdetailpos.ProductUnitCode
                FROM productcheckstockmasterpos
                INNER JOIN productcheckstockdetailpos ON productcheckstockdetailpos.chkProdId = productcheckstockmasterpos.ChkProdId
                WHERE productcheckstockmasterpos.ChkProdDocDate <= 'YYYY-MM-DD'  and ChkProdStatus='A'
                GROUP BY ProductPOSCode,productcheckstockdetailpos.ProductUnitCode,ChkProdWhCode,ChkProdDivisionCode
                ORDER BY  productcheckstockdetailpos.ProductPOSCode,ChkProdWhCode
                ) AS PRODUCTCHECKSTOCK
ON (MOVEND.whCode=PRODUCTCHECKSTOCK.ChkProdWhCode AND MOVEND.stockProdCode=PRODUCTCHECKSTOCK.ProductPOSCode)
where MOVEND.whCode = '".$whCode."' and MOVEND.stockProdCode = '".$stockProdCode."' ORDER BY MOVEND.whCode,PRODUCT.prodGroupCode,MOVEND.stockProdCode ASC ";

        $get_data = DB::select(DB::raw($qury));

        return self::index($get_data);
    }

    public function stockUpdate(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        //-----------------------------------------
        $get_AdjDocNo = self::getLastAdjDocNo();

        if($get_AdjDocNo != null){
            $str = "Lot_".$get_AdjDocNo[0]->AdjDocNo."_1";
            $number = substr($str, -6, 4) + 1;
        }else{
            $str = "Lot_AJP-00-".date("ym")."/0001_1";
            $number = 1;
        }
  
        $number2 = substr(str_repeat(0, 4).$number, - 4);

        $str_01 = substr($str, 0, 11).date("ym")."/".$number2."_1"; //Lot_AJP-00-2012/0016_1
        $str_02 = substr($str, 4, 7).date("ym")."/".$number2; //AJP-00-2012/0016
        //-----------------------------------------

        $request->validate([
            'quantity' => 'required',
        ]);

        $endQty = $request->input('endQty');

        $quantity = $request->input('quantity');

        $count = $endQty + $quantity;

        $whCode = $request->input('whCode');

        $stockProdCode = $request->input('stockProdCode');

        $stockProdName = $request->input('stockProdName');

        $document = $str_01;

        $document_main = $str_02;

        $date = date("Y-m-d")." ".date("h:i:s");

        $date2 = date("Y-m-d");

        
        $qury = [
            "call sp_prodlotdetail_insert ('".$document."', ".$quantity.", 0, 0, ".$quantity.", 0, 0, '".$date."', '".$stockProdCode."', 'SINGLE')", // 10 จำนวนสินค้าที่เพิ่ม, 1236 รหัสสินค้า, AJP-00-2012/0014_1 เอกสารย่อยต่อ 1สินค้า
            "call sp_prodlotmaster_update (".$count.", 0, '".$date."', 'SINGLE00-0001', '".$stockProdCode."')", // 30 ผลลัพธืของสินค้า
            "call sp_avgprodprice_update (1, 0, -200, 'SINGLE00-0001', '".$date."', 0, '".$stockProdCode."', '00')", // -200 ไม่ทราบ
            "call sp_movingproductstock_insert ('SINGLE00-0001', '".$date."', '', 0, 1, 0, 'SINGLE', '', '".$whCode."', 'AJP', '".$document_main."', '".$date2."', '".$stockProdCode."', ".$quantity.", ".$quantity.", ".$count.", 'insert')", // POSWH-00-03 คลังสินค้า 
            "call sp_productstaticpos_update (".$count.", '".$stockProdCode."', '".$whCode."')",
            "call sp_adjustproductdetailpos_insert ('', '', '', '".$document_main."', 1, '".$stockProdCode."', 0, ".$quantity.", '".$whCode."', '02', 'SINGLE')", // AJP-00-2012/0014 เอกสารหลัก
            "call sp_adjustproductmasterpos_insert ('".$document_main."', '".$date2."', '001', 'SINGLE00-0001', '00', 'SINGLE00-0001', 'SINGLE00-0001', '', 'A', '', '".$date."', '".$date."', 'SINGLE')",
        ];
        
        foreach ($qury as $item) {
            DB::select(DB::raw($item));
        }

        app('App\Http\Controllers\Admin\LogActivityController')->eventNotification(Auth::user()->getAttributes(), 'warning', 'product stock', [
            'th' => 'อัพเดทสินค้าคงเหลือ ' . $stockProdName . ': ' . $quantity . ' ชิ้น',
            'en' => 'Successfully updated ' . $stockProdName . '(' . $quantity . ') product stock.',
        ]);

        return redirect()->route('adminStock')->withsuccess((\Session::get('locale') != "th") ? 'Successfully updated.' : 'อัพเดทสำเร็จ');
    }

    // public function stockDelete($whCode, $stockProdCode)
    // {
    //     \Config::set('database.default', 'posone_mysql');

    //     $qury = "call sp_t_movingproductstock_delete ('".$whCode."', 'TEST1', '".$stockProdCode."')";

    //     DB::select(DB::raw($qury));

    //     return redirect()->route('adminStock')->withsuccess((\Session::get('locale') != "th") ? 'Deleted successfully.' : 'ลบสำเร็จ');
    // }

    public function getLastAdjDocNo()
    {
        \Config::set('database.default', 'posone_mysql');

        $date = date("Y-m-d");

        $qury = "select * from productadjustmasterpos p1  where  (1=1)  and  AdjDocDate between  '".$date."' and '".$date."' and  AdjStatus !=  'D' order by adjdocdate  desc,adjdocno desc limit 1";

        $get_ReferDocNo = DB::select(DB::raw($qury));

        return $get_ReferDocNo;
    }

    public function getMovingproductstock()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from movingproductstock where stockDocumentName = 'ABB' order by stockId desc limit 1";

        $get_Movingproductstock = DB::select(DB::raw($qury));

        return $get_Movingproductstock;
    }

}
