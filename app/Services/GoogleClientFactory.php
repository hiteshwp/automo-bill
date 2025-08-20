<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar as GoogleCalendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Carbon\Carbon;

class GoogleClientFactory
{
    protected $calendar;

    public function __construct($user)
    {
        $client = new Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setAccessType('offline');
        $client->setScopes(['https://www.googleapis.com/auth/calendar.events']);

        $client->setAccessToken($user->google_token);

        if ($client->isAccessTokenExpired() && $user->google_refresh_token) {
            $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
        }

        $this->calendar = new GoogleCalendar($client);
    }

    // Return the raw Google Calendar client if needed
    public function getClient()
    {
        return $this->calendar;
    }

    // Create event directly inside the factory
    public function createEvent($title, $start, $end = null, $description = null)
    {
        if (!$end) {
            // Default duration 1 hour if end not provided
            $end = $start->copy()->addHour();
        }

        $event = new Event([
            'summary' => $title,
            'description' => $description,
            'start' => new EventDateTime([
                'dateTime' => $start->toRfc3339String(),
                'timeZone' => 'Asia/Kolkata',
            ]),
            'end' => new EventDateTime([
                'dateTime' => $end->toRfc3339String(),
                'timeZone' => 'Asia/Kolkata',
            ]),
        ]);

        $createdEvent = $this->calendar->events->insert('primary', $event);

        return $createdEvent->id; // return Google Event ID if needed
    }
}


