<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function eventRegister(Event $event)
    {

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
