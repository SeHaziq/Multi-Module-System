<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('bookings.index', compact('rooms'));
    }

    public function show($roomId)
    {
        $room = Room::findOrFail($roomId);
        // $bookings = $room->bookings()->orderBy('start_time')->get();
        $bookings = $room->bookings()->where('is_past', false)->orderBy('start_time')->get();


        // Mark past bookings as 'past'
        foreach ($bookings as $booking) {
            if (\Carbon\Carbon::parse($booking->end_time)->isPast()) {
                $booking->update(['is_past' => true]);
            }
        }

        return view('bookings.show', compact('room', 'bookings'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Check for overlapping bookings
        $conflict = $room->bookings()->where('booking_date', $request->booking_date)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhereRaw('? BETWEEN start_time AND end_time', [$request->start_time])
                    ->orWhereRaw('? BETWEEN start_time AND end_time', [$request->end_time]);
            })->exists();

        if ($conflict) {
            return back()->with('error', 'The selected time slot is not available.');
        }

        // Add the authenticated user's ID before creating the booking
        $booking = new Booking([
            'user_id' => auth()->id(),  // Get the authenticated user's ID
            'room_id' => $request->room_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        $booking->save();

        return redirect()->route('bookings.show', $request->room_id)->with('success', 'Booking successfully created.');
    }
}
