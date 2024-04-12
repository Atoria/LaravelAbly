<?php

namespace App\Services;

use Ably\AblyRest;

class AblyService
{
    protected $ably;

    public function __construct(AblyRest $ably)
    {
        $this->ably = $ably;
    }

    public function publishMessage($channelName, $message)
    {
        $channel = $this->ably->channel($channelName);
        $channel->publish('message', $message);
    }

    public function getTokenRequest($clientId)
    {
        return  $this->ably->auth->requestToken();
    }
}
