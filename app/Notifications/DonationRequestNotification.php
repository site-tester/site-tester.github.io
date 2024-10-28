<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationRequestNotification extends Notification
{
    use Queueable;


    protected $donation;
    protected $barangay;
    /**
     * Create a new notification instance.
     */
    public function __construct($donation, $barangay)
    {
        $this->donation = $donation;
        $this->barangay = $barangay;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'title' => 'New Donation Request',
            'message' => 'A new donation request for a Fire Disaster has been posted. <a href="' . route('donate-now', [
                'donation_type' => $this->donation->preffered_donation_type,
                'barangay' => $this->barangay->id
            ]) . '">Click here</a> to view donation form.',
            'donation_type' => $this->donation->preffered_donation_type,
            'barangay' => $this->barangay->id,
            'url' => url('/donate-now'),
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
