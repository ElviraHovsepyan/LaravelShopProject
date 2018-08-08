<?php

namespace App\Http\Controllers;

use App\GoogleToken;
use App\Http\Services\Service;
use App\Subcat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GoogleDriveController extends Controller
{
    public function init(){
        if(Auth::user()){
            $userId = Auth::user()->id;
                $client = $this->initGoogleClient();
                $token = GoogleToken::where('user_id',$userId)->first();
            if($token){
                $client->setAccessToken($token->token);
                $drive = new \Google_Service_Drive($client);
            }
            else{
                $url = $client->createAuthUrl();
                return redirect($url);
            }
        } else {
            return redirect()->route('products');
        }
    }

    /**
     * @param Request $request
     */
    public function getGoogleDriveRedirectData(Request $request){
        if($request->has('code')){
            $code = $request->input('code');
            $client = $this->initGoogleClient();
            $client->authenticate($code);
            $token = $client->getAccessToken()['access_token'];
            $refreshToken = $client->getRefreshToken();
            $userId = Auth::user()->id;
            $tokenRow = GoogleToken::where('user_id',$userId)->first();
            if(!$tokenRow){
                $token_obj = new GoogleToken();
                $token_obj->token = $token;
                $token_obj->refresh_token = $refreshToken;
                $token_obj->expires_in = Carbon::now()->addSecond(3600);
                $token_obj->user_id = $userId;
                $token_obj->save();
            }
        }
    }

    public function initGoogleClient(){
        $client = new \Google_Client();
        $client->setAuthConfig(base_path('client_secret.json'));
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        $client->addScope('https://www.googleapis.com/auth/drive');
        return $client;
    }

    public function index(){
        $auth = true;
        $userId = Auth::user()->id;
        $tokenRow = GoogleToken::where('user_id',$userId)->first();
        if(!$tokenRow) $auth = false;
        $client = $this->setGoogleClientToken();
        $images = Service::getFiles($client);
        return view('drive')->withAuth($auth)->withFiles($images);
    }

    public function setGoogleClientToken(){
        $userId = Auth::user()->id;
        $client = $this->initGoogleClient();
        $tokenRow = GoogleToken::where('user_id',$userId)->first();
        $expiry = $tokenRow->expires_in;
        $expiry = Carbon::parse($expiry);
        $now = Carbon::now();
        if($now->gt($expiry)){
            $client->refreshToken($tokenRow->refresh_token);
            $token = $client->getAccessToken();
            $tokenRow->token = $token['access_token'];
            $tokenRow->expires_in = Carbon::now()->addSecond(3600);
            $tokenRow->save();
            $client->setAccessToken($token);
        }
        else{
            $client->setAccessToken($tokenRow->token);
        }
        return $client;
    }

    public function getFilesList(){
        $client = $this->setGoogleClientToken();
        $drive = new \Google_Service_Drive($client);
        dd($drive->files->listFiles());
    }

    public function uploadFiles(Request $request)
    {
        $client = $this->setGoogleClientToken();
        $service = new \Google_Service_Drive($client);
        $picture = $request->file('file');
        $title = 'title';
        $description = 'description';
        $filename = $picture->getClientOriginalName();
        $mimeType = $picture->getMimeType();


//        $file = new \Google_Service_Drive_DriveFile($client);
//        $file->setDescription($description);
//        $file->setMimeType($mimeType);
//        $file->setName($filename);

   ///////////////////parent
        $parentId = '1bq2RX_oFMNC5dyJh9JJOlhZrwXe70AFx';

        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => $filename,
            'parents' => array($parentId)
        ));
        $content = file_get_contents($picture);
        $file = $service->files->create($fileMetadata, array(
            'data' => $content,
            'mimeType' => 'image/jpeg',
            'uploadType' => 'multipart',
            'fields' => 'id'));

///////////////////////////////////////
//        $data = file_get_contents($picture);
//        $createdFile = $service->files->create($file, array(
//            'data' => $data,
//            'mimeType' => $mimeType,
//            'uploadType'=>'media',
//        ));

        return redirect()->route('index');
    }


    public function createFolder(){

        $client = $this->setGoogleClientToken();
        $service = new \Google_Service_Drive($client);
        $fileMetadata = new \Google_Service_Drive_DriveFile(array(
            'name' => 'My Files2',
            'mimeType' => 'application/vnd.google-apps.folder'));
        $file = $service->files->create($fileMetadata, array(
            'fields' => 'id'));
        return redirect()->route('index');
    }

    public function moveBetweenFolders(){

        $client = $this->setGoogleClientToken();
        $service = new \Google_Service_Drive($client);
        $fileId = '1REYDqeVEnspCqSCRwDdmETrKOxOewVsl';
        $folderId = '1bJTI2lzS64krd9FFq5qA8rW3GlsuTBTq';
        $emptyFileMetadata = new \Google_Service_Drive_DriveFile();
        $file = $service->files->get($fileId, array('fields' => 'parents'));
        $previousParents = join(',', $file->parents);
        $file = $service->files->update($fileId, $emptyFileMetadata, array(
            'addParents' => $folderId,
            'removeParents' => $previousParents,
            'fields' => 'id, parents'));
        return redirect()->route('index');
    }
}




