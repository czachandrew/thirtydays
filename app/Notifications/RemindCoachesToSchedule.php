<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RemindCoachesToSchedule extends Notification
{
    use Queueable;

    protected $remainingWorkouts;
    protected $challenge;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($remainingWorkouts)
    {
        $this->remainingWorkouts = $remainingWorkouts;
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
                    ->subject($challenge->title . ' only has ' . $this->remainingWorkouts . ' workouts scheduled - get some on the board!')
                    ->greeting('Hey Coach!')
                    ->line('You only have <b>' . $this->remainingWorkouts . '</b> workouts scheduled! Keep the momentum going with your atheletes and schedule more now!')
                    ->action('Schedule Workout', url('/challenges/' . $challenge->id))
                    ->line('You got this coach!');
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
