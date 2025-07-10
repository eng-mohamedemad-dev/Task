<?php

namespace App\Interfaces;

interface ChatRepositoryInterface
{
    public function getSessionById(string $sessionId);
    public function updateSessionInteraction(string $sessionId, array $interactionHistory): void;
}
