<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

use View;

use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {    
        Schema::defaultStringLength(191);

        date_default_timezone_set('Asia/Bangkok');

        View::composer('*', function($view){
            $view->with('userData', Auth::user());
        });

        if(Auth::check()){
            $locale = DB::connection('mongodb')->collection("users")->where('id', "=", Auth::user()->id*1)->first();
            \Session::put('locale', $locale['language']);

        }else{
            \Session::put('locale', 'th');
        }

        View::composer('*', function($view){
            $companyData = [];

            $company_about = DB::connection('mongodb')->collection("config")->where('config','=','company_about')->first();
            $company_address = DB::connection('mongodb')->collection("config")->where('config','=','company_address')->first();
            $company_phone = DB::connection('mongodb')->collection("config")->where('config','=','company_phone')->first();
            $company_email = DB::connection('mongodb')->collection("config")->where('config','=','company_email')->first();
            $company_name = DB::connection('mongodb')->collection("config")->where('config','=','company_name')->first();

            $companyData['about'] = $company_about;
            $companyData['address'] = $company_address;
            $companyData['phone'] = $company_phone;
            $companyData['email'] = $company_email;
            $companyData['name'] = $company_name;

            $view->with('companyData', $companyData);
        });
     
    }
}
