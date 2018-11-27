<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testCurlGet(){
        $url = 'http://laravelproject.loc/api/products';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'token: $2y$10$TIpcC1qnuv42vn/cbF4ERef7T4rH4oedH84xZLQF.jz7Blbdt.vci'
        ));
        $result = curl_exec($curl);
        echo $result;
        curl_close($curl);
    }

    public function testCurlPost(){
        $url = 'http://laravelproject.loc/api/category';
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl,CURLOPT_HTTPHEADER, array(
            'token: $2y$10$TIpcC1qnuv42vn/cbF4ERef7T4rH4oedH84xZLQF.jz7Blbdt.vci'
        ));

        curl_setopt($curl,CURLOPT_POSTFIELDS, array(
            'name'=>'dresses',
            'parent'=>'4'
        ));

        $result = curl_exec($curl);
        echo $result;
        curl_close($curl);
    }

    public function testCurlGuzzleGet(){
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request('GET', 'http://laravelproject.loc/api/products',
                ['headers' => ['token' => '$2y$10$TIpcC1qnuv42vn/cbF4ERef7T4rH4oedH84xZLQF.jz7Blbdt.vci']]);
        }
        catch (GuzzleException $guzzleException){
            dd("Sorry, url not working");
        }
        $response = $request->getBody()->getContents();
        echo $response;
        exit;
    }

    public function testCurl(){
        $client = new \GuzzleHttp\Client();
        try{
            $request = $client->request('POST', 'http://laravelproject.loc/api/category',
                ['headers' => ['token' => '$2y$10$TIpcC1qnuv42vn/cbF4ERef7T4rH4oedH84xZLQF.jz7Blbdt.vci'],
                    'form_params'=>[
                        'name'=>'caps',
                        'parent'=>'3'
                    ]
                ]);
        }
        catch (GuzzleException $guzzleException){
            dd("Sorry, url not working");
        }
        $response = $request->getBody()->getContents();
        echo $response;
        exit;
    }
}
