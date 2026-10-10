<?php

namespace App\Services\Interfaces;

use App\Models\Event;
use App\Models\User;

interface IEventService
{
    public function getAllEvents();
}
