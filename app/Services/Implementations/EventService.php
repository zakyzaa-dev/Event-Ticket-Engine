<?php

namespace App\Services\Implementations;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Models\User;
use App\Services\Interfaces\IEventService;
use Illuminate\Support\Facades\Log;
use Override;

class EventService implements IEventService
{
    #[Override]
    public function getAllEvents()
    {
        $events = Event::take(10)->get();
        return $events;
    }

    #[Override]
    public function getAllUserEvents(User $user)
    {
        $myEvents = $user->createdEvents()->take(10)->get();
        return $myEvents;
    }

    #[Override]
    public function createNewEvent(User $user, array $data)
    {
        $createNewEvent = $user->createdEvents()->create($data);
        Log::info("$user->name membuat event baru!", [
            'user_id' => $user->id,
            'event_name' => $createNewEvent->title,
            'created_at' => $createNewEvent->created_at
        ]);
        return $createNewEvent;
    }
}
