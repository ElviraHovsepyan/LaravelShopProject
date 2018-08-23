<?php

namespace App\Http\Controllers;

use App\Category;
use App\Invoice;
use App\Purchase;
use App\Subcat;
use App\Product;

//use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class PrDetailsController extends Controller
{
    public function show($id){
        $pr = Product::find($id);
        if($pr != null){
            return view('productDetails')->withPr($pr);
        } else {
            abort(404);
        }
    }

    public function deleteItem($prId){
        $item = Product::find($prId);
        $item->delete();
//        Product::onlyTrashed()->restore();
        return redirect('/');
    }

    public function buy(Request $request){
        $arr = $request->arr;
        $userId = Auth::user()->id;
        $name = Carbon::now()->timestamp;
        foreach($arr as $key=>$value){
             $product = Product::find($key);
             $obj = new Purchase;
             $obj->user_id = $userId;
             $obj->inv_name = $name;
             $obj->el_id = $key;
             $obj->quantity = $value;
             $obj->el_name = $product->name;
             $obj->el_price = $product->price;
             $obj->total_price = ($product->price)*($value);
             $obj->save();
        }
        $this->createPdf($name);
    }

    public function createPdf($name){
        $usId = Auth::user()->id;
        $data = Purchase::where(['user_id'=>$usId,'inv_name'=>$name])->get();
        $price = 0;
        foreach($data as $d){
            $price += $d->total_price;
        }
        $pdf = App::make('dompdf.wrapper');
        $pdf->setPaper('a4');
        $pdf->setWarnings(false);
        $pdf = PDF::loadView('pdf',compact('data','price'));
        $pdf->save(storage_path('/invoices/'.$name.'.pdf'));
        $invoice = new Invoice;
        $invoice->user_id  = $usId;
        $invoice->inv_name = $name;
        $invoice->save();
    }

    public function showInvoices($key = false){
        $userId = Auth::user()->id;
        $invoices = Invoice::where('user_id',$userId)->get();
        return view('showInvoices')->withInvoices($invoices);
    }

    public function getInvoices($key){
        $userId = Auth::user()->id;
        $check = Invoice::where(['user_id'=>$userId,'inv_name'=>$key])->get();
        if(!empty($check)){
            $f = file_get_contents(storage_path('/invoices/'.$key.'.pdf'));
            return $f;
        }
    }
}






