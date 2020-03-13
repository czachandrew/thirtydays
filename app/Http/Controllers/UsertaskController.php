<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\UsertaskApproved;
use App\Usertask;
use App\Task;
use App\Media;
use App\Progression;
use Log;
use Auth;

class UsertaskController extends Controller
{
    public function save(Request $request){
        $data = $request->all();
        Log::info($data);
        $usertask = Usertask::create($data['usertask']);
        
        
        foreach($request->media as $media){

            $usertask->media()->create($media);
        }

        return $usertask;
    }

    public function approve(Usertask $usertask){
        
        $usertask->approve();
        //get user progression and award the experience
        //$user = App\User::find($usertask->user_id);
        $usertask->user->progression->awardExperience($usertask->task->xp_value);
        if($usertask->task->limited === 1){
            $task = Task::find($usertask->task->id);
            $task->incrementCount();
            $task->save();
        }
        event(new UsertaskApproved($usertask->user_id,$usertask->id, $usertask->task->xp_value));
    }

    public function deny(Usertask $usertask){
        $usertask->deny();
    }
}
