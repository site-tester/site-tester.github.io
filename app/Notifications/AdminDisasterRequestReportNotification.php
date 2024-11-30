<?php

namespace App\Notifications;

use App\Models\DisasterRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminDisasterRequestReportNotification extends Notification
{
    use Queueable;

    protected $donationRequest, $requested_to;

    /**
     * Create a new notification instance.
     */
    public function __construct(DisasterRequest $donationRequest, $requested_to)
    {
        $this->donationRequest = $donationRequest;
        $this->requested_to = $requested_to;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  object  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'notification_to' => $this->requested_to,
            'barangay_id' => $this->donationRequest->barangay_id,
            'status' => $this->donationRequest->status,
            'donation_request_id' => $this->donationRequest->id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
