<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JoinRequest;

class JoinRequestController extends Controller
{
    public function approve(JoinRequest $joinRequest){
        $joinRequest->status = 'approved';
        //add the user to the kratespace
        $user = $joinRequest->user;
        $user->joinKratespace($joinRequest->kratespace_id);
        return 'success'; 
    }
}
