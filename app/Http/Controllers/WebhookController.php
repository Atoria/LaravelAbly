<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function storeMessage(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data['messages'] as $message){
            if($message['name'] == 'message'){
                $messageInfo = json_decode($message['data'],true);
                Message::create([
                    'user_id' => $messageInfo['id'],
                    'message' => $messageInfo['content']
                ]);
            }
        }
    }
}
