<?php

namespace App\Http\Controllers\Posone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB; //mobgodb

use App\Pos_product;

class PosoneProductsController extends Controller
{
    public function index()
    {
        // $product = new Pos_product();

        // $product->setConnection('posone_mysql');

        $product = Pos_product::all();

        // $product = Pos_product::select('select * from productgrouppos');

        // $product = Pos_product::raw('select * from productgrouppos Order by prodGroupCode;');

        return $product;
        // dd($product);

    }
}
