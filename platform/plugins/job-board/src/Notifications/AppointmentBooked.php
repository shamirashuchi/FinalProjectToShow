<?php

namespace Botble\JobBoard\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Botble\JobBoard\Models\SuperAdminNotification;

class AppointmentBooked extends Notification
{
    use Queueable;

    protected $type = 'Appointment successfully booked.';
    protected $read_at;
    protected $notifiable;
    protected $eventId;
    protected $eventDate;

    const MESSAGE = 'Appointment successfully booked.';

    public function __construct($type, $read_at, $notifiable, $eventId, $eventDate)
    {
        $this->type = "unread";
        $this->read_at = $read_at;
        $this->notifiable = $notifiable;
        $this->eventId = $eventId;
        $this->eventDate = $eventDate;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => "unread",
            'notifiable_id' => $this->notifiable,
            'event_id' => $this->eventId,
            'event_date' => $this->eventDate,
            'message' => self::MESSAGE,
            'read_at' => $this->read_at,
        ];
    }

    public function getNotificationModel()
    {
        return SuperAdminNotification::class;
    }
}
