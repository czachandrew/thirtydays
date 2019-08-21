<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Challenge;
use App\Notifications\RemindCoachesToSchedule;

class remindcoaches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thirtydays:remindcoach';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $challenges = Challenge::where('status','active');

        $challenges->each(function($challenge, $key){

            $scheduled = $challenge->days->filter(function($day){
                    return $day->workout;
                })->count();
            $difference = $scheduled - $challenge->current_day;

            switch($difference){
                case 0: 
                    //send emergency message that there is no workout for this day
                    $user = $challenge->creator; 
                    $user->notify(new RemindCoachesToSchedule($difference, $challenge));
                    break;
                case 1:
                    //send messsage that there is no workout for tomorrow!
                    $user = $challenge->creator; 
                    $user->notify(new RemindCoachesToSchedule($difference, $challenge));
                    break;
                case 2: 
                    //send a message that you need to schedule more workouts 
                    $user = $challenge->creator; 
                    $user->notify(new RemindCoachesToSchedule($difference, $challenge));
                    break;
                default: 
                    //do nothing everything is fine 
                    break;
            }

        });
    }
}
