<?php

namespace App\Repositories;

use App\Models\SessionState;
use App\Interfaces\ChatRepositoryInterface;

class ChatRepository implements ChatRepositoryInterface
{
    public function getSessionById(string $sessionId)
    {
        return SessionState::where('session_id', $sessionId)->firstOrFail();
    }

    public function updateSessionInteraction(string $sessionId, array $interactionHistory): void
    {
        SessionState::where('session_id', $sessionId)
            ->update([
                'interaction_history' => $interactionHistory,
                'last_interaction' => now(),
            ]);
    }
}
