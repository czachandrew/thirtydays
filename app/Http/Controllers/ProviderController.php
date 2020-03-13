<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Usertask;
use Auth; 
use Log;
/// need to make endpoint for krates


class ProviderController extends Controller
{
    //
    public function superdata(Request $request){
        $user = Auth::user();
        if($user->mykratespace){
            return $user->mykratespace->load(['groups.tasks.usertasks.user', 'groups.tasks.usertasks.media','users.progression', 'rewards']);
        } else {
            return; 
        }

    }
}
