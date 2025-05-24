<?php

namespace Modules\Channel\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Modules\Channel\Entities\Channel;

class WAService
{
    public function __construct()
    {
        $this->baseURL = env('URL_WA_SERVER');
        $this->model = new Channel();
    }

    public static function ErrorMessage($message = "Error in process, please try again later", $code = 400){
        $statusObj['status'] = new \stdClass();
        $statusObj['status']->status = 0;
        $statusObj['status']->code = $code;
        $statusObj['status']->message = $message;
        return (object) $statusObj;
    }

    public static function SuccessResponse($message = 'Data Generated Successfully'){
        $statusObj = new \stdClass();
        $statusObj->status = 1;
        $statusObj->code = 200;
        $statusObj->message = $message;
        return (object) $statusObj;
    }

    /******************************* Channels *****************/

    public function createChannel($id){
        try{
            $response = Http::post($this->baseURL.'/sessions/add', ['id' => $id, 'isLegacy' => 'false']);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    /******************************* Instances *****************/
    public function status($id) {
        try{
            $response = Http::get($this->baseURL.'/sessions/status/'.$id);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function find($id) {
        try{
            $response = Http::get($this->baseURL.'/sessions/find/'.$id);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function qr($id){
        try {
            $response = $this->status($id);

            if($response?->message == "" && in_array($response?->data?->status,['authenticated','connected'])){
                $this->model->where('channel_id', $id)->update(['status' => 'connected','updated_at' => date('Y-m-d H:i:s')]);
                return  [
                    'data' => ['qr' => 'connected'],
                    'status' => true,
                ];
            }

            $deviceObj = $this->model->where('channel_id',$id)->first();
            $islegacy = "false";
            $response = $this->createChannel($id);
            $updateData['image'] = $deviceObj?->image ?? null;
            if($response?->success){
                $updateData['image'] = $response->data->qr;
                $updateData['status'] = null;
            }

            $fileName = $id.time().'.png';
            if($updateData['image']){
                file_put_contents(public_path().'/uploads/qrImages/'.$fileName, file_get_contents($updateData['image']));
            }

            $url = URL::to('/').'/uploads/qrImages/'.$fileName;

            $newImage  = changeQR([
                'qr'    => public_path().'/uploads/qrImages/'.$fileName,
                'logo'  => public_path().'/uploads/tocaan-white-logo.png',
                'fileName'  => $fileName,
            ]);

            $updateData['image'] = $newImage;
            $deviceObj->update($updateData);

            return [
                'data'  => ['url' => $url, 'qr' => $newImage],
                'status'    => true,
            ];
        }catch (\Exception $e){}
    }

    public function disconnect($id) {
        try{
            $response = Http::delete($this->baseURL.'/sessions/delete/'.$id);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function clearInstance($id){
        try {
            $response = Http::post($this->baseURL.'/sessions/clearInstance',['id'=>$id]);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function clearInstanceData($id){
        try {
            $response = Http::post($this->baseURL.'/sessions/clearData',['id'=>$id]);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    /********************* Messages ***********************/
    public function sendMessage($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendMessage?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendImage($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendImage?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendVideo($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendVideo?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendAudio($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendAudio?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendFile($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendFile?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendLink($id,$data){
        try {
            $data['body']   = $data['description'];
            $response = Http::post($this->baseURL.'/messages/sendLink?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendSticker($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendSticker?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendGif($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendGif?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendContact($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendContact?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendLocation($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendLocation?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendMention($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendMention?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendReaction($id,$data){
        try {
            $data['body']   = $data['reaction'];
            $response = Http::post($this->baseURL.'/messages/sendReaction?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendButtons($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendButtons?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }

    public function sendBulkMessage($id,$data){
        try {
            $response = Http::post($this->baseURL.'/messages/sendGroupMessage?id='.$id, $data);
            return json_decode($response->getBody());
        }catch (\Exception $e){}
    }
}
