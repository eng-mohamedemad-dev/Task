<?php

namespace App\Services;
use App\Repositories\ChatRepository;
use App\Interfaces\ChatRepositoryInterface;

class ChatService
{
    protected ChatRepository $chatRepository;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

    public function handleMessage(string $sessionId, string $text): array
    {
        $session = $this->chatRepository->getSessionById($sessionId);
        $history = $session->interaction_history ?? [];

        // add user message
        $history[] = ['role' => 'user', 'message' => $text];

        // generate bot reply
        $reply = $this->generateBotReply($text);

        // add bot reply
        $history[] = ['role' => 'bot', 'message' => $reply];

        // update session
        $this->chatRepository->updateSessionInteraction($sessionId, $history);

        return [
            'session_id' => $sessionId,
            'response_text' => $reply,
            'next_step' => $session->current_step,
            'current_order_summary' => [],
            'products_available' => [],
            'debug_info' => ['user_message' => $text],
        ];
    }

    private function generateBotReply(string $text): string
    {
        $text = mb_strtolower($text);
        if (str_contains($text, 'مرحبا')) {
            return 'مرحبًا بك في متجرنا';
        }

        return 'شكرًا لتواصلك! كيف يمكنني مساعدتك؟';
    }
}
