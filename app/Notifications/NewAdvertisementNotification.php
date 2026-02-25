<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAdvertisementNotification extends Notification
{
    use Queueable;

    public $advertisement;

    /**
     * Create a new notification instance.
     */
    public function __construct($advertisement)
    {
        $this->advertisement = $advertisement;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_advertisement',
            'message' => 'هناك عرض جديد ينتظر الموافقة: ' . $this->advertisement->title,
            'advertisement_id' => $this->advertisement->id,
            'vendor_name' => $this->advertisement->vendor->name ?? 'تاجر',
            'url' => route('admin.advertisements.index', ['status' => 'pending']),
        ];
    }
}
