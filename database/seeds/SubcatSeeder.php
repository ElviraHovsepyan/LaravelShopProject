<?php

use App\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubcatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        DB::table('subcat')->insert([
//
//
//            ['subcat_name'=>'Shoes'],
//            ['subcat_name'=>'Clothing'],
//            ['subcat_name'=>'Handbags'],
//            ['subcat_name'=>'Jewelry'],
//            ['subcat_name'=>'Accessories'],
//            ['subcat_name'=>'Girls'],
//            ['subcat_name'=>'Boys'],
//            ['subcat_name'=>'Baby']
//
//        ]);

        factory(Product::class,10)->create();
    }
}
