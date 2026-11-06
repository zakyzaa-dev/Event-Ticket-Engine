<?php

namespace App\Services\Implementations;

use App\Exceptions\EventException;
use App\Models\Event;
use App\Models\User;
use App\Services\Interfaces\IEventService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Override;

class EventService implements IEventService
{
    // Service method to get all events existed
    #[Override]
    public function getAllEvents()
    {
        $events = Event::take(10)->get();
        return $events;
    }

    // Service method to get all events created by user
    #[Override]
    public function getAllUserEvents(User $user)
    {
        $myEvents = $user->createdEvents()->take(10)->get();
        return $myEvents;
    }

    // create new events
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

    // generating random ticket code
    public function codeTicket()
    {
        return "EVT-" . Str::upper(Str::random(5));
    }

    // register to an event
    #[Override]
    public function registerEvent(User $user, int $eventId)
    {
        return DB::transaction(function () use ($user, $eventId){
            $event = Event::where('id', $eventId)->lockForUpdate()->first();

            if (!$event){
                throw new EventException(
                    message: "Not found",
                    reason: "Can't find event",
                    code: 404
                );
            }

            if (!empty($event->allowed_domains)){
                $userDomain = Str::after($user->email, '@');

                if (!in_array($userDomain, $event->allowed_domains)){
                    throw new EventException(
                        message: "Forbidden access",
                        reason: "Email domain not allowed for this event",
                        code: 403
                    );
                };
            }

            $isRegistered = $user->registeredEvents()->where('event_id', $event->id)->exists();
            if ($isRegistered){
                throw new EventException(
                    message: "Failed to register",
                    reason: "You have already registered for this event",
                    code: 422
                );
            };

            $totalParticipants = $event->participants()->count();
            if ($totalParticipants >= $event->max_capacity){
                throw new EventException(
                    message: "Event quota is full",
                    reason: "Quota limit reached",
                    code: 422);
            }

            $ticketCode = $this->codeTicket();
            $user->registeredEvents()->attach($event->id, [
                'ticket_code' => $ticketCode,
            ]);

            return $user->registeredEvents()->where('event_id', $event->id)->first();
        });
    }
}
