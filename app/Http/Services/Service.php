<?php
namespace App\Http\Services;

use App\GoogleToken;
use App\Promocode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class Service
{
    public static function getFiles($client){
        $drive = new \Google_Service_Drive($client);
        $files = $drive->files->listFiles();
        $images = [];
        foreach($files as $file){
            $mimeType = explode('/',$file->mimeType)[0];
            if ($mimeType=='image'){
                array_push($images,$file);
            }
        }
        return $images;
    }

    public static function getDiscount(){
        if(Auth::user()){
            $promocode = Auth::user()->promocode_id;
            if($promocode != 0){
                $promInfo = Promocode::find($promocode);
                $active = $promInfo->is_active;
                if($active==1){
                    $period = $promInfo->period_months;
                    $start = Auth::user()->start_date;
                    $start = Carbon::parse($start);
                    $expiry = $start->addMonth($period);
                    $now = Carbon::now();
                    if($expiry->gt($now)){
                        $discount = ($promInfo->discount)/100;
                    } else {
                        $discount = 1;
                    }
                } else {
                    $discount = 1;
                }
            } else {
                $discount = 1;
            }
        } else {
            $discount = 1;
        }
        return $discount;
    }
}











