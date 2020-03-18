<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JoinRequest;
use Log;

class JoinRequestController extends Controller
{
    public function approve(JoinRequest $joinrequest){
        Log::info($joinrequest);
        $joinrequest->status = 'approved';
        //add the user to the kratespace
        $user = $joinrequest->user;
        $user->joinKratespace($joinrequest->kratespace_id);
        return 'success'; 
    }
}
