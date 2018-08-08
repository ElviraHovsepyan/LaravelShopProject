<?php
namespace App\Http\Services;

use App\GoogleToken;


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
}











