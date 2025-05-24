<?php

namespace Modules\Message\Repositories\Vendor;

use App\Imports\ContactImport;
use App\Jobs\BulkMessageJob;
use App\Jobs\DecisionMessageJob;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Channel\Entities\Channel;
use Modules\Contact\Entities\Contact;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Message\Entities\DecisionMessage;

class DecisionMessageRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(DecisionMessage::class);
    }

    public function findById($id)
    {
        if (method_exists($this->model, 'trashed')) {
            $model = $this->model->withDeleted()->whereIn('channel_id',auth()->user()->channels()->pluck('id')->toArray())->findOrFail($id);
        } else {
            $model = $this->model->whereIn('channel_id',auth()->user()->channels()->pluck('id')->toArray())->findOrFail($id);
        }
        return $model;
    }

    public function QueryTable($request)
    {
        $query = $this->model;
        if(auth()->user()->can('dashboard_access') || auth()->user()->can('seller_access')){
            if(!auth()->user()->hasRole('super-admin')){
                $query = $query->whereIn('channel_id',auth()->user()->channels()->pluck('id')->toArray());
            }
        }

        return $this->filterDataTable($query, $request);
    }
    public function filterDataTable($query, $request)
    {
        return $query->orderBy('id','desc');
    }

    public function createDecisionMessage($request) {
        $message_data = array_merge($request->message_data,$this->getMessageData($request));
        $on = Carbon::now()->addSeconds(30);
        $decision_message = [
            'channel_id' => $request->channel_id,
            'send_at'  => date('Y-m-d H:i:s',strtotime($on)),
            'is_replied' => 0,
            'whatsapp'     => $request->whatsapp,
            'message_data'  => $message_data,
            'status'        => 1,
            'job_queue_id'  => (string) \Str::uuid(),
        ];

        $deviceObj = Channel::find($request->channel_id);
        $check = $deviceObj->incrementDialyUsage(1);
        if(!$check){
            return false;
        }

        DB::beginTransaction();
        try {

            DB::commit();

            $model = $this->model->create($decision_message);
            $job = (new DecisionMessageJob($model))->delay($on);
            $jobID = custom_dispatch($job);

            $model->update([
                'queue_data' => ['job'   => $jobID,],
            ]);

            $this->committedAction($model, $request, "create");
            return $model;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function getMessageData($request) {
        $data = [];

        if($request->message_type == 'text'){ // Text Message
            $data['body'] = $request->body;
        }else if($request->message_type == 'image'){ // Image Message
            $data['caption'] = $request->caption;
            $data['url'] = $request->url;
        }else if($request->message_type == 'video'){ // Video Message
            $data['caption'] = $request->caption;
            $data['url'] = $request->url;
        }else if($request->message_type == 'file'){ // File Message
            $data['url'] = $request->url;
        }else if($request->message_type == 'audio'){ // Audio Message
            $data['url'] = $request->url;
        }else if($request->message_type == 'link'){ // Link with preview Message
            $data['url'] =  $request->url;
            $data['title'] =  $request->title;
            $data['description'] =  $request->description;
        }else if($request->message_type == 'sticker'){ // Sticker Message
            $data['url'] = $request->url;
        }else if($request->message_type == 'gif'){ // Gif Message
            $data['caption'] = $request->caption;
            $data['url'] = $request->url;
        }else if($request->message_type == 'contact'){ // Contact Message
            $data['name'] = $request->name;
            $data['organization'] = $request->organization;
            $data['contact'] = $request->contact;
        }else if($request->message_type == 'location'){ // Location Message
            $data['lat'] = $request->lat;
            $data['lng'] = $request->lng;
        }else if($request->message_type == 'mention'){ // Mention Message
            $data['mention'] = $request->mention;
        }
        return $data;
    }

}
