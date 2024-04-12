<?php

namespace App\Http\Controllers;

use App\Services\AblyService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $ably;

    public function __construct(AblyService $ably)
    {
        $this->ably = $ably;
    }

    public function getToken(Request $request)
    {
        $tokenDetails = $this->ably->getTokenRequest($request->user()->id);
        return response()->json($tokenDetails);

    }
    public function send(Request $request)
    {
        $user = $request->user();
        $this->ably->publishMessage('chat', [
            'id' => $user->id,
            'username' => $user->name,
            'content' => $request->input('content')
        ]);
    }

}
