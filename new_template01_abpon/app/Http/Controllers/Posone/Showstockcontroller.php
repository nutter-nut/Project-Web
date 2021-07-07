<?php

namespace App\Http\Controllers\Posone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Showstockcontroller extends Controller
{
    public function index($get_data_edit = null)
    {
        $get_product_group = self::getProductGroup();
    
        return view('posone_test', [
            'get_product_group' => $get_product_group,
            'get_data_edit' => $get_data_edit != null ? $get_data_edit[0] : null
        ]);
    }

    public function productGroupInsert(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $name = $request->input('name');

        $code = $request->input('code');

        $qury = "call sp_prodgrouppos_insert (1, 'N', 'SINGLE', '".$code."', '".$name."', 'N');";

        DB::select(DB::raw($qury));

        return back();
    }

    public function productGroupEdit(Request $request, $id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "select * from productgrouppos where prodGroupCode = '".$id."' Order by prodGroupCode";

        $get_data = DB::select(DB::raw($qury));
    
        return self::index($get_data);
    }

    public function productGroupUpdate(Request $request)
    {
        \Config::set('database.default', 'posone_mysql');

        $code = $request->input('code');

        $name = $request->input('name');

        $qury = "call sp_prodgrouppos_update (1, 'N', 'SINGLE', '".$code."', '".$name."', 'N');";

        DB::select(DB::raw($qury));

        return back();
    }

    public function getProductGroup()
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "SELECT * FROM productgrouppos ORDER BY prodGroupCode";

        $get_data = DB::select(DB::raw($qury));

        return $get_data;
    }

    public function productGroupDelete($id)
    {
        \Config::set('database.default', 'posone_mysql');

        $qury = "call sp_prodgrouppos_delete ('".$id."')";

        DB::select(DB::raw($qury));

        return back();
    }

    public function show(){
        \Config::set('database.default', 'posone_mysql');
        $qury="SELECT MOVEND.companyCode,
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
   
        $test = DB::select(DB::raw($qury));
        
    
        // return view('showstock')->with('test',$test);
        return $test;
    }

    public function sal(){

    $sal1 = " SELECT
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
                 Where  pm.prodcode like '006%'
                 and pm.companyCode='SINGLE' and prodstatus='N'";

    $call = "call sp_t_invoicemasterposREST_insert ('TAB-00/0025', '', '0', 1, 0, 0, '', 0, 222, 0, 0, 0, '1', '', '', '', 'ORD-00-2011/00057', '2020-11-15', '00', 'STRPOS00-0001', '', '', 
    '', 'EA5D0260', 222, 0, 0, 0, 222, 222, 0, 222, 'POSWH-00-01', 'ORD', 'W', '2020-11-15 15:47:05', '2020-11-15 15:47:05', 'SINGLE', 'STRPOS00-0001', 'STRPOS00-0001'); ";
    $call2 = "call sp_invoicedetailpos_insert2 (99, '', '', 'P1', 0, '0', 0, 0, '', 'prod', 1, '00101001', '', '', 2, '37', 1, 2, '37', 198, 0, 0, 0, 198, 'N', 'ORD-00-2011/00057', 'SINGLE')";
    $update = "update invoicemasterpos set ver='1' where invdocno='ORD-00-2011/00057'";
    $call3 = "call sp_t_trans_kitchen_insert (0, '', '1917', 0, 0, 1, 'ORD-00-2011/00057', '', 'KIT-00/0001', '00101001', 'TAB-00/0025', 2, '37', 1, 'W', 'STRPOS00-0001', '2020-11-15 15:47:05')";
    $call4 = "call sp_t_invoicedetailpos_update_isCooking ('1917', 2, 0, 'prod', '00101001', 'ORD-00-2011/00057', 'SINGLE')";
    $call5 = "call sp_t_invoicepaymentmaster_insert ('', '00', '0', '0', 'ABB', '2020-11-15 16:55:01', 'STRPOS00-0001', '', 'A', '', 'GENERAL', 'SINGLE', 0, '', '', 'EA5D0260', 'N',
    'STRPOS00-0001', 0, 0, 0, 1000, 778, 'INV-00-2011/00052', 1, 0, '2020-11-15', 222, 222, 0, ''); ";
    // 222 ยอดสุทธิ 1000 เงินที่รับจากลูกค้า 778 เงินทอน
    $call6 = "call sp_t_invoicepaymentdetail_insert ('cash', '', 222, 'INV-00-2011/00052', '', '')  ";
    $call7 = "call sp_t_invoicepayment_insert ('INV-00-2011/00052', 'ORD-00-2011/00057', 'SINGLE', 1, 0)    ";
    $call8 = "call sp_t_invoicemasterposREST_update ('TAB-00/0025', '', '0', 1, 0, 0, '', 0, 222, 0, 0, 0, '1', '', '', '', 'ORD-00-2011/00057', '2020-11-15', '00', 'STRPOS00-0001', NULL, NULL,
    '', 'EA5D0260', 222, 0, 0, 0, 222, 222, 0, 222, 'POSWH-00-01', 'ORD', 'A', '2020-11-15 15:47:05', '2020-11-15 16:54:29', 'SINGLE', 'STRPOS00-0001', 'STRPOS00-0001')   ";
    $call9 = "call sp_t_trans_kitchen_update (0, '', '1917', 0, 0, 1, 'ORD-00-2011/00057', '', 'KIT-00/0001', '00103021', 'TAB-00/0025', 1, '05', 1, 'F', 'STRPOS00-0001', '2020-11-15 16:55:01')";
    $delete = "delete  from pre_invoicedetailpos where tablecode='TAB-00/0024'";
    
    
    $product = DB::select(DB::raw($sal1));
    dd($test1);
    //$test2 = DB::select(DB::raw($delete));
    // // $docno = $test1[0];

    // // //dd($docno);
    //  dd($test2);

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
    return view('showstock')
        ->with('test',$test);
    }

    public function all(){

        $typepro = "SELECT
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
                     Where pm.prodCode like '006%' and  pm.companyCode='SINGLE' and prodstatus='N'";

        $show = DB::select(DB::raw($typepro));
        // dd($show);
        return view('allproducts')
        ->with('show',$show);
    }
    public function shop(){
        return view('shop');
    }
    public function addata(){
        return view('showstock');
    }
}
