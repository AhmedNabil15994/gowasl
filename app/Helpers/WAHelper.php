<?php

namespace App\Helpers;

class WAHelper
{
    public $channel_id;
    public function __construct($channel_id)
    {
        $this->baseURL = env('URL_WA_SERVER');
        $this->channel_id = $channel_id;
    }


    /*******************************Channels *****************/

}
