<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Challenge;

class ChallengeBegun extends Notification
{
    use Queueable;

    protected $challenge;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Challenge $challenge)
    {
        $this->challenge = $challenge;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->success()
                    ->subject('The ' . $this->challenge->title . ' has begun, get after it!')
                    ->line($notifiable->name . ' time to get to work. Other athletes are probably already getting their workout done!')
                    ->action('Get it!', url('/challenge/' . $this->challenge->id))
                    ->line('Thanks for using ThirtyDays!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
