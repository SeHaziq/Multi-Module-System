<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Room;
use Illuminate\Support\Facades\Log;

class UpdatePastBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:past-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update bookings where the end time has passed and mark them as past.';

    /**
     * Execute the console command.
     */
    public function handle()
{
    Log::info("Starting From Here.");

    // Fetch bookings where the booking_date is in the past and is not marked as past already
    $bookings = Booking::where('booking_date', '<', Carbon::today()) // Compare only the booking_date
                       ->where('is_past', false)
                       ->get();

    info("Number of past bookings found: " . $bookings->count());

    if ($bookings->isEmpty()) {
        $this->info('No past bookings found.');
    } else {
        foreach ($bookings as $booking) {
            // Update the booking's is_past field
            $booking->update(['is_past' => true]);
            info("Booking ID {$booking->id} marked as past.");
        }
    }

    $this->info('Past bookings have been successfully updated.');
}

}
