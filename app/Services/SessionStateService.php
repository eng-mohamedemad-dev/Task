<?php

namespace App\Services;

use App\Interfaces\SessionStateRepositoryInterface;

class SessionStateService
{
    public function __construct(protected SessionStateRepositoryInterface $sessionRepo)
    {
    }

    public function get(string $sessionId)
    {
        return $this->sessionRepo->getBySessionId($sessionId);
    }

    public function storeOrUpdate(array $data)
    {
        return $this->sessionRepo->createOrUpdate($data);
    }

    public function all()
    {
        return $this->sessionRepo->all();
    }

    public function deleteBySessionId(string $sessionId)
    {
        return $this->sessionRepo->deleteBySessionId($sessionId);
    }

    public function updateBySessionId(string $sessionId, array $data)
    {
        return $this->sessionRepo->updateBySessionId($sessionId, $data);
    }
}
