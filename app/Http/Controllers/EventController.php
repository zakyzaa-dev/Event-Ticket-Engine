<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\Interfaces\IEventService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{

    protected IEventService $_eventService;

    public function __construct(IEventService $eser)
    {
        $this->_eventService = $eser;
    }

    public function getAllEvents()
    {
        $events = $this->_eventService->getAllEvents();
        return response()->json([
            'message' => 'Success get all events',
            'events' => EventResource::collection($events),
        ], 200);
    }

    public function ticketCode(): string
    {
        return "EVT-" . Str::upper(Str::random(5));
    }

    public function eventRegister(Event $event)
    {
        $event = $this->_eventService->registerEvent(Auth::user(), $event->id);
        return response()->json([
            'message' => 'Registration success',
            'registration' => [
                'event_title' => $event->title,
                'ticket_code' => $event->pivot->ticketCode,
                'joined' => $event->pivot->created_at,
            ]
        ], 201);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $myEvents = $this->_eventService->getAllUserEvents(Auth::user());

            return response()->json([
                'message'=> 'Get events success',
                'events' => EventResource::collection($myEvents),
            ], 200);

        }catch (Exception $e){
            Log::error('Gagal mengambil event. Error:' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to get user event',
                'error' => config('app.debug') ? $e->getMessage() : "Internal server error",
            ], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        try{
            $newEvent = $this->_eventService->createNewEvent(Auth::user(), $request->validated());
            return response()->json([
                'message' => 'Success created new event',
                'event' => new EventResource($newEvent)
            ], 201);
        }catch (Exception $e){
            Log::error('Gagal membuat event. Error:' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to get user event',
                'error' => config('app.debug') ? $e->getMessage() : "Internal server error",
            ], 500);
        }
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
