<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'project' => 'Event Ticket Engine API',
        'status' => 'Online',
        'version' => '1.0.0',
        'author' => 'zakyzaa-dev'
    ]);
});
