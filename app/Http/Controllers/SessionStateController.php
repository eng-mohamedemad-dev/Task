<?php

// app/Http/Controllers/Api/SessionStateController.php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\SessionStateService;
use App\Http\Requests\StoreSessionStateRequest;

class SessionStateController extends Controller
{
    public function __construct(protected SessionStateService $sessionService)
    {
    }

    public function storeOrUpdate(StoreSessionStateRequest $request)
    {
        $session = $this->sessionService->storeOrUpdate($request->validated());

        return $this->successResponse('Session state saved successfully', $session);
    }

    public function show(string $sessionId)
    {
        $session = $this->sessionService->get($sessionId);

        return $session
            ? $this->successResponse($session)
            : $this->errorResponse('Session not found', 404);
    }
}
