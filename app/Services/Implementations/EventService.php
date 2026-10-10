<?php

namespace App\Services\Implementations;

use App\Models\Event;
use App\Models\User;
use App\Services\Interfaces\IEventService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Override;

class EventService implements IEventService
{
    public function ticketCode(): string
    {
        return "EVT-" . Str::upper(Str::random(5));
    }

    #[Override]
    public function getAllEvents()
    {
        $events = Event::take(10)->get();
        return $events;
    }
}
