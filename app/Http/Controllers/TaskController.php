<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task; 
use App\Zonegroup;
use App\MediaRequirement;
use Log;

class TaskController extends Controller
{
    //

    public function save(Request $request){
        $data = $request->all();
        Log::info($request->all());
        $task = Task::create($data['experienceTask']);
        if($data['requirements']){
            foreach($data['requirements'] as $requirement){
                $task->addRequirement($requirement);
            }
        }
        return $task;
    }

    public function delete(Task $task){
        $task->delete();
        return 'success';
    }

    public function createTaskForZone(Zonegroup $zonegroup, Request $request){
        $task = $zonegroup->addTask($request->toArray());
        return $task;
    }
}
