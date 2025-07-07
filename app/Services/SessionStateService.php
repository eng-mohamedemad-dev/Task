<?php

// app/Services/SessionState/SessionStateService.php
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
}
