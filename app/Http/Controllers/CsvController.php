<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function exportCsv(){
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $products = Product::all();
        $columns = array('name', 'info', 'pic', 'price');
        $callback = function() use ($products, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($products as $product) {
                fputcsv($file, array($product->name,$product->info,$product->pic,$product->price));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function exportCsvOne($id){
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $product = Product::find($id);
        $columns = array('name', 'info', 'pic', 'price');
        $callback = function() use ($product, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, array($product->name,$product->info,$product->pic,$product->price));
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function import(Request $request){
        $csv = $request->file('file');
        $header = null;
        if (($handle = fopen ( $csv, 'r' )) !== FALSE) {
            while ( ($row = fgetcsv( $handle, 1000, ',' )) !== FALSE ) {
                if(count($row)!= 4){
                    return json_encode('Structure of your csv file is incorrect!');
                } else {
                    if(!$header){
                        $header = $row;
                    } else {
                        $data[] = array_combine($header,$row);

//                        $product = new Product();
//                        $product->name = $data['name'];
//                        $product->info = $data['info'];
//                        $product->pic = $data['pic'];
//                        $product->price = $data['price'];
//                        $product->save ();
                    }
                }
            }

            fclose ($handle);
        }
        return json_encode($data);
    }
}













