<?php

namespace App\Services\Interfaces;

use App\Models\User;

interface IEventService
{
    public function getAllEvents();
    public function getAllUserEvents(User $user);
    public function createNewEvent(User $user ,array $data);
    public function registerEvent(User $user, int $eventId);
}
