<?php

namespace Modules\Message\Repositories\Vendor;

use App\Imports\ContactImport;
use App\Jobs\BulkMessageJob;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Channel\Entities\Channel;
use Modules\Contact\Entities\Contact;
use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Message\Entities\BulkMessage;

class BulkMessageRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(BulkMessage::class);
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

    public function createBulkMessage($request) {
        $message_data = $this->getMessageData($request);
        $bulk_contacts = $this->getContactsData($request);

        $bulk_message = [
            'channel_id' => $request->channel_id,
            'message_type'  => $request->message_type,
            'interval'      => $request->interval,
            'sending_date'  => $request->sending_date,
            'sending_later' => $request->sending_later,
            'bulk_flag'     => $request->bulk_flag,
            'message_data'  => $message_data,
            'bulk_contacts' => $bulk_contacts,
            'status'        => 1,
        ];

        $deviceObj = Channel::find($request->channel_id);
        $check = $deviceObj->incrementDialyUsage(count($bulk_contacts['phones']) ?? 0);
        if(!$check){
            return false;
        }

        DB::beginTransaction();
        try {

            DB::commit();

            $model = $this->model->create($bulk_message);

            if($request->sending_later == 0){
                $on = Carbon::now()->addSeconds(0);
            }else{
                $on = Carbon::parse($request->sending_date);
            }

            $job = (new BulkMessageJob($model))->delay($on);
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

    public function getContactsData($request) {
        $data = ['bulk_flag' => $request->bulk_flag,];

        if($request->bulk_flag == 'numbers_groups'){
            $contacts = Contact::whereHas('numbers_groups',function ($q) use ($request){
                $q->whereIn('numbers_groups_contacts.numbers_group_id',explode(',',$request->numbers_groups));
            });
            $data['contacts'] = $contacts->pluck('id')->toArray();
            $data['phones'] = $contacts->distinct('whatsapp')->pluck('whatsapp')->toArray();
        }else if($request->bulk_flag == 'new_contacts'){
            $newContacts = explode(',',$request->new_contacts);
            $data['contacts'] = [];
            foreach ($newContacts as $item) {
                $contact = $this->addContact([$item,$item]);
                $data['contacts'][] = $contact->id;
            }
            $data['phones'] = $newContacts;
        }else if($request->bulk_flag == 'contacts'){
            $contacts = Contact::whereIn('id',explode(',',$request->contacts));
            $data['contacts'] = $contacts->pluck('id')->toArray();
            $data['phones'] = $contacts->distinct('whatsapp')->pluck('whatsapp')->toArray();
        }else if($request->bulk_flag == 'excel_contacts'){
            $excelData = $this->dealWithExcel($request);
            $data['contacts'] = $excelData['contacts'];
            $data['phones'] = $excelData['phones'];
        }
        return $data;
    }

    public function dealWithExcel($request) {
        if($request->hasFile('excel_file')){
            $rows = Excel::toArray(new ContactImport(), $request->file('excel_file'));
            $data = array_filter(array_slice($rows[0], 1, 100) , function ($subArray) {
                return $subArray[0] !== null;
            });

            $phones = [];
            $contacts = [];

            foreach ($data as $item) {
                $contact = $this->addContact($item);
                $phones[] = $item[1];
                $contacts[] = $contact->id;
            }

            return [
                'phones' => $phones,
                'contacts' => $contacts
            ];
        }
    }

    public function addContact($item) {
        return Contact::firstOrCreate([
            'whatsapp'  => $item[1],
        ],[
            'name'  => $item[0],
            'mobile'  => $item[1],
            'whatsapp'  => $item[1],
            'channel_id'  => request()->channel_id,
        ]);
    }
}
