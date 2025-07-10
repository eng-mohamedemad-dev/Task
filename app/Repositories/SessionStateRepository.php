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
            ['session_id' => $data['session_id'], 'user_id' => $data['user_id']],
            $data
        );
    }

    public function all()
    {
        return SessionState::where('user_id', auth()->id())->get();
    }

    public function updateBySessionId(string $sessionId, array $data)
    {
        $session = SessionState::where('session_id', $sessionId)
            ->where('user_id', auth()->id())
            ->first();
        if (!$session) {
            return null;
        }
        $session->update($data);
        return $session;
    }

    public function deleteBySessionId(string $sessionId)
    {
        return SessionState::where('session_id', $sessionId)
            ->where('user_id', auth()->id())
            ->delete();
    }
}
