<?php

namespace App\Http\Controllers;

use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function show(){
        return view('chartView');
    }
    public function getData(Request $request){
        $year = $request->key;
            $arr = [0,0,0,0,0,0,0,0,0,0,0,0];
            $createData = Product::select('created_at')->get();
            foreach($createData as $oneData){
                $date = Carbon::parse($oneData->created_at);
                if($date->year == $year){
                    $date = $date->month;
                    $arr[$date-1]++;
                }
            }
        return json_encode($arr);
    }
}






