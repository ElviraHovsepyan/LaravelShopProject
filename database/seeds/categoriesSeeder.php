<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        Category::create([
//            'cat_name'=>'Women'
//            ['cat_name'=>'Men'],
//            ['cat_name'=>'Kids'],
//            ['cat_name'=>'Home and Gifts'],
//            ['cat_name'=>'Shoes'],
//            ['cat_name'=>'Clothing'],
//            ['cat_name'=>'Handbags'],
//            ['cat_name'=>'Jewelry'],
//            ['cat_name'=>'Accessories'],
//            ['cat_name'=>'Girls'],
//            ['cat_name'=>'Boys'],
//            ['cat_name'=>'Baby']
//        ]);

        DB::table('categories')->insert([

            ['cat_name'=>'Women'],
            ['cat_name'=>'Men'],
            ['cat_name'=>'Kids'],
            ['cat_name'=>'Home and Gifts'],
//            ['cat_name'=>'Shoes'],
//            ['cat_name'=>'Clothing'],
//            ['cat_name'=>'Handbags'],
//            ['cat_name'=>'Jewelry'],
//            ['cat_name'=>'Accessories'],
//            ['cat_name'=>'Girls'],
//            ['cat_name'=>'Boys'],
//            ['cat_name'=>'Baby']

        ]);
    }
}
