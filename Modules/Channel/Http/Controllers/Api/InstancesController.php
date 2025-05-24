<?php

namespace Modules\Channel\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Core\Traits\Dashboard\CrudDashboardController;
use Modules\Channel\Entities\Channel;
use Modules\Channel\Services\WAService;
use Illuminate\Support\Facades\Http;

class InstancesController extends ApiController
{

    public function __construct(){
        $this->service = new WAService();
    }

    /**
     * @OA\Get(
     *     path="/instances/qr",
     *     tags={"Instances"},
     *     operationId="qr",
     *     summary="fetch qr",
     *     description="fetch user a new qr or return connected as status if connection established",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *
     *     @OA\Response(response="200", description="returns qr image base64 or connected.")
     * )
     */
    public function qr(){
        try {
            $response = $this->service->qr(CHANNEL_ID);
            return $this->response($response);
        }catch (\Exception $e){
            return $this->error("System Error, Contact Your System Adminstrator !!");
        }
    }

    /**
     * @OA\Get(
     *     path="/instances/status",
     *     tags={"Instances"},
     *     operationId="status",
     *     summary="fetch qr",
     *     description="fetch user connection status",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *
     *     @OA\Response(response="200", description="returns disconnected or connected.")
     * )
     */
    public function status(Request $request){
        try {
            $input = $request->all();
            $data = [
                'status' => '',
                'image'  => null,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if(isset($input['status']) && !empty($input['status']) && in_array($input['status'], ['connected','authenticated','disconnected'])){
                $data['status'] = $input['status'];
            }

            $response = $this->service->status(CHANNEL_ID);

            if($response?->message == "" && in_array($response?->data?->status , ['connected','authenticated'])){
                $data['status'] = 'connected';
            }else{
                $response = $this->service->find(CHANNEL_ID);
                if($response?->message == "Session found."){
                    $data['status'] = 'got QR and ready to scan';
                }else{
                    $data['status'] = 'disconnected';
                    $response = $this->service->createChannel(CHANNEL_ID);
                }
            }

            Channel::where('channel_id', CHANNEL_ID)->update($data);
            unset($data['image']);
            unset($data['updated_at']);

            return $this->response($data);
        }catch (\Exception $e){
            return $this->error("System Error, Contact Your System Adminstrator !!");
        }

    }

    /**
     * @OA\Post(
     *     path="/instances/disconnect",
     *     tags={"Instances"},
     *     operationId="disconnect",
     *     summary="disconnect connection",
     *     description="disconnect user current connection",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *
     *     @OA\Response(response="200", description="returns Disconnected.")
     * )
     */
    public function disconnect(){
        try {
            $response = $this->service->disconnect(CHANNEL_ID);
            return $this->response($response);
        }catch (\Exception $e){
            return $this->error("System Error, Contact Your System Adminstrator !!");

        }
    }

    /**
     * @OA\Post(
     *     path="/instances/clearInstance",
     *     tags={"Instances"},
     *     operationId="clearInstance",
     *     summary="clear instance",
     *     description="clear instance",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *
     *     @OA\Response(response="200", description="returns Disconnected.")
     * )
     */
    public function clearInstance(){
        try {
            $response = $this->service->clearInstance(CHANNEL_ID);
            return $this->response($response);
        }catch (\Exception $e){
            return $this->error("System Error, Contact Your System Adminstrator !!");
        }
    }

    /**
     * @OA\Post(
     *     path="/instances/clearInstanceData",
     *     tags={"Instances"},
     *     operationId="clearInstanceData",
     *     summary="clear instance data",
     *     description="clear instance data",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *
     *     @OA\Response(response="200", description="returns Disconnected.")
     * )
     */
    public function clearInstanceData(){
        try {
            $response = $this->service->clearInstanceData(CHANNEL_ID);
            return $this->response($response);
        }catch (\Exception $e){
            return $this->error("System Error, Contact Your System Adminstrator !!");

        }
    }


}
