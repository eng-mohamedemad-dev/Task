<?php


// app/Http/Controllers/Api/ChatController.php
namespace App\Http\Controllers;

use App\Services\ChatService;
use App\Http\Requests\ChatRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResponseResource;

class ChatController extends Controller
{
    public function __construct(protected ChatService $chatService)
    {
    }

    public function handle(ChatRequest $request)
    {
        $response = $this->chatService->handleMessage(
            $request->session_id,
            $request->text
        );
        return $this->successResponse('Chat response', new ChatResponseResource($response));
    }
}
