<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventException extends Exception
{
    protected string $reason;
    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    public function __construct(string $message, string $reason = "", int $code = 0)
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
