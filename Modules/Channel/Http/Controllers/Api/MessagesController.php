<?php

namespace Modules\Channel\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Channel\Http\Requests\Api\BulkMessageRequest;
use Modules\Channel\Http\Requests\Api\ButtonsMessageRequest;
use Modules\Channel\Http\Requests\Api\ContactMessageRequest;
use Modules\Channel\Http\Requests\Api\DecisionMessageRequest;
use Modules\Channel\Http\Requests\Api\LinkMessageRequest;
use Modules\Channel\Http\Requests\Api\LocationMessageRequest;
use Modules\Channel\Http\Requests\Api\MentionMessageRequest;
use Modules\Channel\Http\Requests\Api\MultiMediaMessageRequest;
use Modules\Channel\Http\Requests\Api\ReactionMessageRequest;
use Modules\Channel\Http\Requests\Api\TextMessageRequest;
use Modules\Channel\Repositories\Api\MessageRepository;
use Modules\Channel\Services\WAService;

class MessagesController extends ApiController
{

    public function __construct(MessageRepository $repository){
        $this->service = new WAService();
        $this->repository = $repository;
    }

    public function msgResponse($response) {
        return $this->response([
            'id' => 'true_'.str_replace('@s.whatsapp.net','@c.us',$response?->data?->key?->remoteJid).'_'.$response?->data?->key?->id,
            'chatId' => str_replace('@s.whatsapp.net','@c.us',$response?->data?->key?->remoteJid),
        ],"Message Sent Successfully !!!");
    }

    public function convertAudio($data) {
        $fileName = 'soundFile'.time();
        $extension = '.'.array_reverse(explode('.',$data['url']))[0];
        $path = public_path().'/uploads/temp/'.$fileName;
        file_put_contents($path.$extension, fopen($data['url'], 'r'));
        shell_exec("/usr/bin/ffmpeg -i ".$path.$extension." -ac 1 -c:a libopus -b:a 64k  -ar 48000 ".$path.".oga");
        $data['url'] = URL::to('/').'/uploads/temp/'.$fileName.'.oga';

        return $data;
    }

    /**
     * @OA\Post(
     *     path="/messages/sendMessage",
     *     tags={"Messages"},
     *     operationId="sendMessage",
     *     summary="text message",
     *     description="send text message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Message Body to send",in="query",name="body", required=true),
     * )
     */
    public function sendMessage(TextMessageRequest $request){
        try{
            $response = $this->service->sendMessage(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendImage",
     *     tags={"Messages"},
     *     operationId="sendImage",
     *     summary="send image message",
     *     description="send image message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Image Url to send",in="query",name="url", required=true),
     *     @OA\Parameter(description="Caption to send",in="query",name="caption", required=false),
     * )
     */
    public function sendImage(MultiMediaMessageRequest $request){
        try{
            $response = $this->service->sendImage(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendVideo",
     *     tags={"Messages"},
     *     operationId="sendVideo",
     *     summary="send video message",
     *     description="send video message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Video Url to send",in="query",name="url", required=true),
     *     @OA\Parameter(description="Caption to send",in="query",name="caption", required=false),
     * )
     */
    public function sendVideo(MultiMediaMessageRequest $request){
        try{
            $response = $this->service->sendVideo(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendFile",
     *     tags={"Messages"},
     *     operationId="sendFile",
     *     summary="send file message",
     *     description="send file message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="File Url to send",in="query",name="url", required=true),
     * )
     */
    public function sendFile(MultiMediaMessageRequest $request){
        try{
            $response = $this->service->sendFile(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendAudio",
     *     tags={"Messages"},
     *     operationId="sendAudio",
     *     summary="send audio message",
     *     description="send audio message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Audio Url to send",in="query",name="url", required=true),
     * )
     */
    public function sendAudio(MultiMediaMessageRequest $request){
        try{
            $data = $this->convertAudio($request->validated());

            $response = $this->service->sendAudio(CHANNEL_ID,$data);
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendLink",
     *     tags={"Messages"},
     *     operationId="sendLink",
     *     summary="send link with preview message",
     *     description="send link with preview message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Message URL to send to",in="query",name="url", required=true),
     *     @OA\Parameter(description="Message URL title to send to",in="query",name="title", required=true),
     *     @OA\Parameter(description="Message URL description to send to",in="query",name="description", required=false),
     * )
     */
    public function sendLink(LinkMessageRequest $request){
        try{
            $response = $this->service->sendLink(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendSticker",
     *     tags={"Messages"},
     *     operationId="sendSticker",
     *     summary="send sticker message",
     *     description="send sticker message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Sticker Url to send",in="query",name="url", required=true),
     * )
     */
    public function sendSticker(MultiMediaMessageRequest $request){
        try{
            $response = $this->service->sendSticker(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendGif",
     *     tags={"Messages"},
     *     operationId="sendGif",
     *     summary="send gif message",
     *     description="send gif message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Gif Url to send",in="query",name="url", required=true),
     *     @OA\Parameter(description="Caption to send",in="query",name="caption", required=false),
     * )
     */
    public function sendGif(MultiMediaMessageRequest $request){
        try{
            $response = $this->service->sendGif(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendContact",
     *     tags={"Messages"},
     *     operationId="sendContact",
     *     summary="send contact message",
     *     description="send contact message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Contact Name to send",in="query",name="name", required=true),
     *     @OA\Parameter(description="Contact Phone to send",in="query",name="contact", required=false),
     *     @OA\Parameter(description="Contact Organization to send",in="query",name="organization", required=false),
     * )
     */
    public function sendContact(ContactMessageRequest $request){
        try{
            $response = $this->service->sendContact(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendLocation",
     *     tags={"Messages"},
     *     operationId="sendLocation",
     *     summary="send location message",
     *     description="send location message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Location latitude to send",in="query",name="latitude", required=true),
     *     @OA\Parameter(description="Location Longitude to send",in="query",name="longitude", required=false),
     *     @OA\Parameter(description="Location Address Text to send",in="query",name="address", required=false),
     * )
     */
    public function sendLocation(LocationMessageRequest $request){
        try{
            $response = $this->service->sendLocation(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendMention",
     *     tags={"Messages"},
     *     operationId="sendMention",
     *     summary="send mention message",
     *     description="send mention message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Phone to send to",in="query",name="phone", required=true),
     *     @OA\Parameter(description="Contact Mention to send",in="query",name="contact", required=true),
     * )
     */
    public function sendMention(MentionMessageRequest $request){
        try{
            $response = $this->service->sendMention(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/messages/sendReaction",
     *     tags={"Messages"},
     *     operationId="sendReaction",
     *     summary="send reaction message",
     *     description="send reaction message",
     *     security={ {"bearer_token": {} , "channel_id": {} , "channel_token": {} }},
     *     @OA\Response(response="200",description=""),
     *     @OA\Parameter(description="Message Id to react to (fromMe must be false)",in="query",name="messageId", required=true),
     *     @OA\Parameter(description="Reaction to react to ('👍' ,'❤️' ,'😂','😮','😢' ,'🙏','unset')",in="query",name="reaction", required=true),
     * )
     */
    public function sendReaction(ReactionMessageRequest $request){
        try{
            $response = $this->service->sendReaction(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function sendBulkMessage(BulkMessageRequest $request){
        try{
            $response = $this->service->sendBulkMessage(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->response([],"Message Sent Successfully !!!");
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function sendButtons(ButtonsMessageRequest $request){
        try{
            $response = $this->service->sendButtons(CHANNEL_ID,$request->validated());
            if(!$response?->success){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            if(isset($response?->data?->pending)){
                return $this->error("Missing Connection, you've gotten QR scan it please before sending !!");
            }

            return $this->msgResponse($response);
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    public function sendDecisionMessage(DecisionMessageRequest $request)
    {
        try{
            $response = $this->repository->createDecisionMessage($request->validated());
            if(!$response){
                return $this->error($response?->message ?? "System Error, Contact Your System Adminstrator !!");
            }

            return $this->response([
                'job_queue_id' => $response->job_queue_id,
            ],"Message queued Successfully !!!");
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }

    }
}
