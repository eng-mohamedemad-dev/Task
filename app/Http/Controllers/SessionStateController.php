<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Services\SessionStateService;
use App\Http\Resources\SessionStateResource;
use App\Http\Requests\StoreSessionStateRequest;

class SessionStateController extends Controller
{
    public function __construct(protected SessionStateService $sessionService)
    {
    }

    public function store(StoreSessionStateRequest $request)
    {
        $session = $this->sessionService->storeOrUpdate($request->validated());

        return $this->successResponse('Session state saved successfully', new SessionStateResource($session));
    }

    public function show(string $sessionId)
    {
        $session = $this->sessionService->get($sessionId);

        return $session
            ? $this->successResponse('Session fetched successfully', new SessionStateResource($session))
            : $this->errorResponse('Session not found', 404);
    }

    public function index()
    {
        $sessions = $this->sessionService->all();
        return $this->successResponse('Sessions fetched successfully', SessionStateResource::collection($sessions));
    }

    public function update(StoreSessionStateRequest $request, string $sessionId)
    {
        $session = $this->sessionService->updateBySessionId($sessionId, $request->validated());
        if (!$session) {
            return $this->errorResponse('Session not found', 404);
        }
        return $this->successResponse('Session updated successfully', new SessionStateResource($session));
    }

    public function destroy(string $sessionId)
    {
        $deleted = $this->sessionService->deleteBySessionId($sessionId);
        if ($deleted) {
            return $this->successResponse('Session deleted successfully');
        }
        return $this->errorResponse('Session not found', 404);
    }
}
