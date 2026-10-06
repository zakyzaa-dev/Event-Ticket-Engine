<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function ticketCode(): string
    {
        return "EVT-" . Str::upper(Str::random(5));
    }

    public function eventRegister(Event $event)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($event->allowed_domains){
            $user_domain = Str::after($user->email, '@');

            if (!in_array($user_domain, $event->allowed_domains)){
                return response()->json([
                    'message' => 'Forbidden access',
                    'reason' => "Email domain not allowed for this event",
                ], 403);
            }

            $isRegistered = $user->registeredEvents()->where('event_id', $event->id)->exists();
            if ($isRegistered){
                return response()->json([
                    'message' => 'Failed to register',
                    'reason' => 'You have already registered for this event'
                ], 422);
            }

            $totalParticipants = $event->participants()->count();
            if ($totalParticipants >= $event->max_capacity) {
                return response()->json([
                    'message' => 'Event quota is full'
                ], 422);
            }

            $ticketCode = $this->ticketCode();
            $user->registeredEvents()
            ->attach($event->id,
            [
                'ticket_code' => $ticketCode
            ]);

            return response()->json([
                'message' => 'Registration success',
                'registration' => [
                    'event_title' => $event->title,
                    'ticket_code' => $ticketCode,
                    'registered_at' => $event->pivot->created_at
                ],
            ], 200);

            // TESTING
            // return response()->json([
            //     'sisa_kapasitas' => $event->max_capacity - $totalParticipants - 1
            // ], 200);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myEvents = Auth::user()->createdEvents;
        return response()->json([
            'message'=> 'Get events success',
            'events' => EventResource::collection($myEvents),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        // return response()->json([
        //     'data' => $request->all()
        // ]);

        $validated = $request->validated();
        $event = $request->user()->createdEvents()->create($validated);

        return response()->json([
            'message' => 'Create event success',
            'event' => new EventResource($event)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
