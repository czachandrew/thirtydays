<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Challenge;

class advanceday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thirtydays:advanceday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advance the day and active workout for ThirtyDays';

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
        $challenges = Challenge::where('status', 'active');
        $challenges->each(function ($challenge, $key){
            $challenge->current_day++;
            $challenge->save();
        });
    }
}
