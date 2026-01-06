<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\ProfileMessage;

class Message extends Notification
{
    use Queueable;

    public $profileMessage;

    public function __construct(ProfileMessage $profileMessage)
    {
        $this->profileMessage = $profileMessage;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nieuw bericht in je gastenboek')
            ->line($this->profileMessage->sender->name . ' heeft een bericht achtergelaten.')
            ->action('Bekijk Profiel', route('profile.show', $notifiable->id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->profileMessage->id,
            'sender_id' => $this->profileMessage->from_user_id,
            'sender_name' => $this->profileMessage->sender->name,
            'content' => $this->profileMessage->preview(40),
            'link' => route('profile.show', $notifiable->id),
            'type' => $this->profileMessage->parent_id ? 'reply' : 'message',
        ];
    }
}
