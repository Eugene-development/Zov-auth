<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Notification routes (public, throttled)
Route::post('/notify/service-request', [NotificationController::class, 'sendServiceRequestNotification'])
    ->middleware('throttle:10,1'); // 10 attempts per minute
