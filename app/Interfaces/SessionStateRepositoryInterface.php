<?php

namespace App\Interfaces;

interface SessionStateRepositoryInterface
{
    public function getBySessionId(string $sessionId);
    public function createOrUpdate(array $data): mixed;
}
