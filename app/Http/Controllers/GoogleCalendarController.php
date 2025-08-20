<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleClientFactory;
use Carbon\Carbon;
use Google_Service_Calendar_Event;

class GoogleCalendarController extends Controller
{
    public function index(Request $request)
    {
        $service = GoogleClientFactory::forUser($request->user());

        $params = [
            'timeMin'      => Carbon::now('Asia/Kolkata')->startOfDay()->toRfc3339String(),
            'maxResults'   => 10,
            'singleEvents' => true,
            'orderBy'      => 'startTime',
        ];

        $events = $service->events->listEvents('primary', $params)->getItems();

        return response()->json([
            'events' => array_map(function ($e) {
                return [
                    'id'          => $e->getId(),
                    'summary'     => $e->getSummary(),
                    'starts'      => optional($e->getStart())->getDateTime() ?? optional($e->getStart())->getDate(),
                    'ends'        => optional($e->getEnd())->getDateTime() ?? optional($e->getEnd())->getDate(),
                    'meet_link'   => optional($e->getConferenceData())->getEntryPoints()[0]['uri'] ?? null,
                    'hangoutLink' => $e->getHangoutLink(),
                ];
            }, $events),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'summary'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'start'       => 'required|date',   // e.g., 2025-08-21 15:00:00
            'end'         => 'required|date|after:start',
            'attendees'   => 'array',           // ['a@x.com','b@y.com']
            'create_meet' => 'boolean',         // if true, create a Google Meet link
        ]);

        $service = GoogleClientFactory::forUser($request->user());

        $start = Carbon::parse($data['start'], 'Asia/Kolkata');
        $end   = Carbon::parse($data['end'], 'Asia/Kolkata');

        $event = new Google_Service_Calendar_Event([
            'summary'     => $data['summary'],
            'description' => $data['description'] ?? null,
            'start'       => [
                'dateTime' => $start->toRfc3339String(),
                'timeZone' => 'Asia/Kolkata',
            ],
            'end'         => [
                'dateTime' => $end->toRfc3339String(),
                'timeZone' => 'Asia/Kolkata',
            ],
            'attendees'   => collect($data['attendees'] ?? [])
                                ->map(fn ($email) => ['email' => $email])
                                ->values()
                                ->all(),
            'reminders'   => [
                'useDefault' => false,
                'overrides'  => [
                    ['method' => 'email', 'minutes' => 24 * 60],
                    ['method' => 'popup', 'minutes' => 10],
                ],
            ],
        ]);

        $optParams = [];
        if (!empty($data['create_meet'])) {
            // Need full calendar scope for conferenceData
            $event['conferenceData'] = [
                'createRequest' => [
                    'requestId' => (string) \Str::uuid(),
                    'conferenceSolutionKey' => ['type' => 'hangoutsMeet'],
                ],
            ];
            $optParams['conferenceDataVersion'] = 1;
        }

        $created = $service->events->insert('primary', $event, $optParams);

        return response()->json([
            'id'        => $created->getId(),
            'htmlLink'  => $created->getHtmlLink(),
            'meet_link' => optional($created->getConferenceData())->getEntryPoints()[0]['uri'] ?? null,
            'status'    => $created->getStatus(),
        ], 201);
    }
}
