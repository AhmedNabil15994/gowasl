<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Modules\Channel\Entities\Channel;
use Modules\Channel\Services\WAService;

class QrImage extends Component
{
    public $channel_id = 0;
    public $channel_token = 0;
    public $identifier = 0;
    public $days = 0;
    protected $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new WAService();
    }

    public function mount($id,$token,$identifier,$days)
    {
        $this->channel_id = $id;
        $this->channel_token = $token;
        $this->identifier = $identifier;
        $this->days = $days;
    }

    public function render(){
        $data['url'] = asset('/images/qr-load.png');
        $data['image'] = asset('/images/connected.png');
        $data['channelStatus'] = 'connected';

        $device = Channel::where('channel_id',$this->channel_id)->first();
        if($device?->valid_until < date('Y-m-d H:i:s')){
            return view('livewire.qr-image')->with('data',(object) $data);
        }

        $result = $this->service->qr($this->channel_id);

        if(isset($result['data'])){
            if($result['data']['qr'] != 'connected'){
                $data['url'] = $result['data']['qr'];
                $data['channelStatus'] = 'got QR and ready to scan';
                $data['image'] = $result['data']['qr'];
            }else{
                $data['url'] = $data['image'];
            }

            $this->emit('statusChanged',$data);
        }
        return view('livewire.qr-image')->with('data',(object) $data);
    }
}
