<?php

namespace App\Repositories;

use App\Models\SessionState;
use App\Interfaces\SessionStateRepositoryInterface;

class SessionStateRepository implements SessionStateRepositoryInterface
{
    public function getBySessionId(string $sessionId)
    {
        return SessionState::where('session_id', $sessionId)->first();
    }

    public function createOrUpdate(array $data): SessionState
    {
        return SessionState::updateOrCreate(
            ['session_id' => $data['session_id']],
            $data
        );
    }
}
