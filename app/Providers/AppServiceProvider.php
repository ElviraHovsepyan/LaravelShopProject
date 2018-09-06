<?php

namespace App\Providers;

use App\Promocode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Category;
use App\Subcat;
use App\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     */


    public function boot()
    {
        View::share('cats',$this->getCategories());
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    public function getCategories(){
        $cats = Category::with('Subcat')
                ->with('Subcat.Products')->get();
        return $cats;
    }


}


