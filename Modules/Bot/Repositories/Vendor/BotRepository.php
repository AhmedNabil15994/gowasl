<?php

namespace Modules\Bot\Repositories\Vendor;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Bot\Entities\Bot;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class BotRepository extends CrudRepository
{

    public function __construct()
    {
        parent::__construct(Bot::class);
    }

    public function findById($id)
    {
        if (method_exists($this->model, 'trashed')) {
            $model = $this->model->withDeleted()->whereHas('channel',function ($q){
                $q->where('id_users',auth()->user()->id);
            })->findOrFail($id);
        } else {
            $model = $this->model->whereHas('channel',function ($q){
                $q->where('id_users',auth()->user()->id);
            })->findOrFail($id);
        }

        return $model;
    }

    public function QueryTable($request)
    {
        $query = $this->model->whereHas('channel',function ($q){
            $q->where('id_users',auth()->user()->id);
        });

        $this->appendSearch($query, $request);
        foreach ($this->getModelTranslatable() as $key) {
            $query->orWhere($key . '->' . locale(), 'like', '%' . $request->input('search.value') . '%');
        }
        $query = $this->filterDataTable($query, $request);
        return $query;
    }

    public function filterDataTable($query, $request)
    {
        $query=parent::filterDataTable($query, $request);
        return $query;
    }

    public function prepareData(array $data, Request $request, $is_create = false): array
    {
        $reply = [];
        foreach($data['reply'] as $key => $item){
            if($item !== null && $item !== '+'){
                $reply[$key] = $item;
            }
        }
        foreach ($reply as $oneReplyKey => $oneReply){
            if(in_array($oneReplyKey,['gif_caption','image_caption','video_caption'])){
                $reply['caption'] = $oneReply;
                unset($reply[$oneReplyKey]);
            }
        }
        $data['reply'] = $reply;
        return $data;
    }
}
