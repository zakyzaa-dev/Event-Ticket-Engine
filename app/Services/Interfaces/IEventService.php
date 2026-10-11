<?php

namespace App\Services\Interfaces;

use App\Http\Requests\StoreEventRequest;
use App\Models\Event;
use App\Models\User;

interface IEventService
{
    public function getAllEvents();
    public function getAllUserEvents(User $user);
    public function createNewEvent(User $user ,array $data);
}
