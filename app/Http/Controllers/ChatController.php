<?php


namespace App\Http\Controllers;

use App\Services\ChatService;
use App\Http\Requests\ChatRequest;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    protected ChatService $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function store(ChatRequest $request)
    {
        $data = $this->chatService->handleMessage(
           $request->validated()['session_id'],
           $request->validated()['text']
        );

        return response()->json($data);
    }
}
