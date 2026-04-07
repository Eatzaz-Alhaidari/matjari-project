<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdvertisementRejectedNotification extends Notification
{
    use Queueable;

    protected $advertisement;

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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('تم رفض إعلانك: ' . $this->advertisement->title)
                    ->line('نأسف لإبلاغك بأن إعلانك المسمى "' . $this->advertisement->title . '" قد تم رفضه من قبل الإدارة.')
                    ->line('سبب الرفض: ' . $this->advertisement->rejection_reason)
                    ->action('تعديل الإعلان', url('/vendor/advertisements/' . $this->advertisement->id . '/edit'))
                    ->line('يرجى مراجعة السبب وتعديل الإعلان لإعادة إرساله للمراجعة.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'advertisement_id' => $this->advertisement->id,
            'title' => $this->advertisement->title,
            'message' => 'تم رفض إعلانك بسبب: ' . $this->advertisement->rejection_reason,
            'status' => 'rejected',
        ];
    }
}
