<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

class PrayerTimeController extends Controller
{
    public function index(Request $request)
    {
        // Default state is 'Kuala Lumpur' if not provided
        $state = $request->input('state', 'Kuala Lumpur');

        // Make an API call to Aladhan API to get prayer times for the selected state
        $client = new Client();
        $response = $client->get('http://api.aladhan.com/v1/timingsByCity', [
            'query' => [
                'city' => $state,
                'country' => 'Malaysia',
                'method' => 2, // You can change this to the appropriate method if needed
            ]
        ]);

        // Parse the response data
        $data = json_decode($response->getBody()->getContents(), true);

        // If the API returns valid prayer times
        if (isset($data['data']['timings'])) {
            // Filter to only include the 5 daily prayers
            $allPrayerTimes = $data['data']['timings'];
            $prayerTimes = [
                'Fajr' => $allPrayerTimes['Fajr'],
                'Dhuhr' => $allPrayerTimes['Dhuhr'],
                'Asr' => $allPrayerTimes['Asr'],
                'Maghrib' => $allPrayerTimes['Maghrib'],
                'Isha' => $allPrayerTimes['Isha']
            ];
        } else {
            $prayerTimes = null;
            $error = 'Unable to fetch prayer times. Please try again later.';
        }

        // Get the current time in Malaysia (Asia/Kuala_Lumpur timezone)
        $currentTime = Carbon::now('Asia/Kuala_Lumpur');
        $currentTimeFormatted = $currentTime->format('H:i');
        $currentDate = $currentTime->format('l, d F Y');

        // Try making an API call to convert the current Gregorian date to Islamic (Hijri)
        try {
            $hijriResponse = $client->get('https://api.aladhan.com/v1/gToH', [
                'query' => [
                    'date' => $currentTime->toDateString(),
                ]
            ]);
            $hijriData = json_decode($hijriResponse->getBody()->getContents(), true);
            $hijriDate = $hijriData['data']['hijri'] ?? null;

            // Get the Islamic date (Hijri)
            $islamicDate = $hijriDate ? "{$hijriDate['day']} {$hijriDate['month']} {$hijriDate['year']}" : 'N/A';
        } catch (\Exception $e) {
            // Fallback if the conversion API call fails
            $islamicDate = 'N/A';
        }

        // Find out which prayer time we are currently in
        $currentPrayer = null;
        foreach ($prayerTimes as $prayer => $time) {
            // Compare only hours and minutes (HH:mm format)
            $prayerTime = Carbon::createFromFormat('H:i', $time, 'Asia/Kuala_Lumpur');
            if ($currentTime->greaterThanOrEqualTo($prayerTime)) {
                $currentPrayer = $prayer;
            }
        }

        return view('infomuslim.prayer', [
            'state' => $state,
            'prayerTimes' => $prayerTimes ?? [],
            'currentTimeFormatted' => $currentTimeFormatted,
            'currentDate' => $currentDate,
            'islamicDate' => $islamicDate,
            'currentPrayer' => $currentPrayer,
            'error' => $error ?? null,
        ]);
    }
}
