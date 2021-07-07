<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Auth;

use App;

class LanguageController extends Controller
{
    public function index($locale)
    {
        if(Auth::check()){

            $id = Auth::user()->id*1;
    
            DB::connection('mongodb')->collection("users")->where('id', "=", $id)->update(['language' => $locale]);

            \Session::put('locale', $locale);
    
            return redirect()->back();
        }else{
            \Session::put('locale', $locale);
    
            return redirect()->back();
        }

        // \Session::put('locale', $locale);
        
        // return redirect()->back();
    }
}
