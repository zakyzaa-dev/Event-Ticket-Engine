<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventException extends Exception
{
    protected string $reason;
    /**
     * Report the exception.
     */
    public function report(): void
    {
        $user = Auth::user();

        Log::error("Terjadi event error: {$this->getMessage()}", [
            'exception_code' => $this->getCode(),
            'user_id' => $user ? $user->id : 'Guest/Anonym',
            'email' => $user ? $user->email : '-',
        ]);
    }

    public function __construct(string $message, string $reason = "", int $code = 400)
    {
        parent::__construct($message, $code);
        $this->reason = $reason;
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $this->getMessage(),
            'reason' => $this->reason,
        ], $this->getCode());
    }
}
