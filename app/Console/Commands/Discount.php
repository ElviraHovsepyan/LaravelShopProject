<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;

class Discount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:discount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a discount for the product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $discount = $_ENV['DISCOUNT'];
        $products = Product::all();
        foreach($products as $product){
            $price = intval($product->price);
            $price = $price - (($discount/100) * $price);
            $product->price = $price;
            $product->save();
        }
    }
}




