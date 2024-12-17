<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RoomBookedNotification extends Notification
{
    use Queueable;

    protected $room;
    protected $bookingDate;
    protected $startTime;
    protected $endTime;

    public function __construct($room, $bookingDate, $startTime, $endTime)
    {
        $this->room = $room;
        $this->bookingDate = $bookingDate;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "You have successfully booked the room: {$this->room->name} on {$this->bookingDate} from {$this->startTime} to {$this->endTime}.",
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('You have successfully booked a room.')
                    ->action('View Booking', url('/bookings'))
                    ->line('Thank you for using our application!');
    }
}
