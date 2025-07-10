<?php

namespace App\Interfaces;

interface SessionStateRepositoryInterface
{
    public function getBySessionId(string $sessionId);
    public function createOrUpdate(array $data): mixed;
    public function all();
    public function deleteBySessionId(string $sessionId);
    public function updateBySessionId(string $sessionId, array $data);
}
